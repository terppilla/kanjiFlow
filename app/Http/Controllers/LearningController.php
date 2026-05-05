<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\InteractsWithReviewFeedback;
use App\Models\Character;
use App\Models\Collection;
use App\Models\UserCharacter;
use App\Services\BuiltinCollectionsSync;
use App\Services\GamificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class LearningController extends Controller
{
    use InteractsWithReviewFeedback;

    public function __construct(
        private GamificationService $gamification,
    ) {
        $this->middleware('auth');
    }

    public function selectLevel()
    {
        $user = Auth::user();

        $hskStats = [];
        for ($level = 1; $level <= 6; $level++) {
            $totalInLevel = Character::where('hsk_level', $level)->count();
            $learnedInLevel = UserCharacter::where('user_id', $user->id)
                ->whereHas('character', function ($query) use ($level) {
                    $query->where('hsk_level', $level);
                })
                ->where('is_learned', true)
                ->count();

            $practicedInLevel = UserCharacter::where('user_id', $user->id)
                ->whereHas('character', function ($query) use ($level) {
                    $query->where('hsk_level', $level);
                })
                ->where('total_reviews', '>', 0)
                ->count();

            $hskStats[$level] = [
                'total' => $totalInLevel,
                'learned' => $learnedInLevel,
                'practiced' => $practicedInLevel,
                'progress' => $totalInLevel > 0 ? round(($practicedInLevel / $totalInLevel) * 100) : 0,
            ];
        }

        if (Character::query()->exists()) {
            app(BuiltinCollectionsSync::class)->syncForUser($user);
        }

        $builtinCollections = $user->collections()
            ->where('is_builtin', true)
            ->withCount('characters')
            ->orderBy('builtin_slug')
            ->get();

        return view('user.learning.select-level', compact('hskStats', 'builtinCollections'));
    }

    public function showLevel(Request $request, $level)
    {
        $characters = Character::where('hsk_level', $level)
            ->orderBy('id')
            ->paginate(10);

        $learnedCharacterIds = UserCharacter::where('user_id', Auth::id())
            ->where('is_learned', true)
            ->pluck('character_id')
            ->toArray();

        $levelIds = Character::where('hsk_level', $level)->pluck('id')->toArray();
        $totalScope = count($levelIds);
        $learnedScopeCount = count(array_intersect($learnedCharacterIds, $levelIds));

        $collection = null;

        if ($request->ajax()) {
            return response()->view('user.learning.partials.level-characters', compact(
                'characters',
                'learnedCharacterIds',
                'collection',
                'level'
            ));
        }

        return view('user.learning.level', compact(
            'characters',
            'level',
            'learnedCharacterIds',
            'collection',
            'totalScope',
            'learnedScopeCount'
        ));
    }

    public function showCollectionLevel(Request $request, Collection $collection)
    {
        $this->authorizeOwnedCollection($collection);

        $characters = $collection->characters()
            ->orderByPivot('id')
            ->paginate(24);

        $learnedCharacterIds = UserCharacter::where('user_id', Auth::id())
            ->where('is_learned', true)
            ->pluck('character_id')
            ->toArray();

        $collIds = DB::table('collection_character')
            ->where('collection_id', $collection->id)
            ->orderBy('id')
            ->pluck('character_id')
            ->toArray();
        $totalScope = count($collIds);
        $learnedScopeCount = UserCharacter::where('user_id', Auth::id())
            ->whereIn('character_id', $collIds)
            ->where('is_learned', true)
            ->count();

        $level = null;

        if ($request->ajax()) {
            return response()->view('user.learning.partials.level-characters', compact(
                'characters',
                'learnedCharacterIds',
                'collection',
                'level'
            ));
        }

        return view('user.learning.level', compact(
            'characters',
            'level',
            'learnedCharacterIds',
            'collection',
            'totalScope',
            'learnedScopeCount'
        ));
    }

    public function show(Request $request, Character $character)
    {
        return $this->renderShow($request, $character, null);
    }

    public function showInCollection(Request $request, Collection $collection, Character $character)
    {
        $this->authorizeOwnedCollection($collection);
        abort_unless(
            $collection->characters()->where('characters.id', $character->id)->exists(),
            404
        );

        return $this->renderShow($request, $character, $collection);
    }

    /**
     * Повторение иероглифов из очереди SRS (те же условия, что счётчик на дашборде).
     */
    public function dueReview(Request $request)
    {
        $user = Auth::user();

        $firstDueCharacterId = UserCharacter::where('user_id', $user->id)
            ->where('next_review_at', '<=', now())
            ->where('is_learned', false)
            ->orderBy('next_review_at')
            ->value('character_id');

        if (! $firstDueCharacterId) {
            return redirect()->route('dashboard')->with('info', 'Нет иероглифов для повторения.');
        }

        $dueRemaining = UserCharacter::where('user_id', $user->id)
            ->where('next_review_at', '<=', now())
            ->where('is_learned', false)
            ->count();
        $request->session()->put('due_review_initial_count', max(1, $dueRemaining));

        $character = Character::findOrFail($firstDueCharacterId);

        return $this->renderShow($request, $character, null, true);
    }

    private function renderShow(Request $request, Character $character, ?Collection $learningCollection, bool $dueReview = false)
    {
        $user = Auth::user();
        $mode = $request->get('mode', 'keyboard');

        if (! $dueReview) {
            $request->session()->forget('due_review_initial_count');
        }

        $ctx = $dueReview
            ? $this->dueReviewContext($request, $user, $character)
            : $this->learningContext($user, $character, $learningCollection);

        return view('user.learning.show', array_merge($ctx, compact('mode', 'learningCollection', 'dueReview')));
    }

    public function characterPanel(Request $request, Character $character)
    {
        $user = Auth::user();

        if ($request->boolean('due_review')) {
            $exists = UserCharacter::where('user_id', $user->id)
                ->where('character_id', $character->id)
                ->where('next_review_at', '<=', now())
                ->where('is_learned', false)
                ->exists();
            abort_unless($exists, 404);

            $ctx = $this->dueReviewContext($request, $user, $character);

            return response()->json([
                'character' => $this->serializeCharacterForPanel($ctx['character']),
                'stats' => [
                    'progress' => $ctx['progress'],
                    'learned_count' => $ctx['learnedCount'],
                    'practiced_count' => $ctx['practicedCount'],
                    'total_in_level' => $ctx['totalInLevel'],
                    'hsk_level' => $character->hsk_level,
                    'progress_title' => $ctx['progressTitle'],
                    'nav_title' => $ctx['navTitle'],
                    'due_review_mode' => true,
                    'due_completed' => $ctx['dueCompleted'],
                    'due_initial' => $ctx['dueInitial'],
                    'due_remaining' => $ctx['dueRemaining'],
                ],
                'nav' => [
                    'prev_id' => $ctx['prevCharacter']?->id,
                    'next_id' => $ctx['nextCharacter']?->id,
                ],
            ]);
        }

        $collection = $this->resolveCollectionFromQuery($request, $user, $character);
        $ctx = $this->learningContext($user, $character, $collection);

        return response()->json([
            'character' => $this->serializeCharacterForPanel($ctx['character']),
            'stats' => [
                'progress' => $ctx['progress'],
                'learned_count' => $ctx['learnedCount'],
                'practiced_count' => $ctx['practicedCount'],
                'total_in_level' => $ctx['totalInLevel'],
                'hsk_level' => $character->hsk_level,
                'progress_title' => $ctx['progressTitle'],
                'nav_title' => $ctx['navTitle'],
            ],
            'nav' => [
                'prev_id' => $ctx['prevCharacter']?->id,
                'next_id' => $ctx['nextCharacter']?->id,
            ],
        ]);
    }

    public function getMultipleChoiceOptions(Character $character)
    {
        $options = [];

        $options[] = [
            'id' => $character->id,
            'meaning' => $character->meaning,
            'pinyin' => $character->pinyin,
            'is_correct' => true,
        ];

        $wrongCharacters = Character::where('hsk_level', $character->hsk_level)
            ->where('id', '!=', $character->id)
            ->inRandomOrder()
            ->limit(3)
            ->get()
            ->map(function ($char) {
                return [
                    'id' => $char->id,
                    'meaning' => $char->meaning,
                    'pinyin' => $char->pinyin,
                    'is_correct' => false,
                ];
            })
            ->toArray();

        $options = array_merge($options, $wrongCharacters);
        shuffle($options);

        return response()->json([
            'success' => true,
            'options' => $options,
        ]);
    }

    public function submitPractice(Request $request, Character $character)
    {
        $request->validate([
            'mode' => 'required|in:keyboard,multiple',
            'result' => 'required|in:again,hard,good,easy',
            'answer' => Rule::requiredIf($request->input('mode') === 'keyboard'),
            'selected_option' => Rule::requiredIf($request->input('mode') === 'multiple'),
            'collection_id' => 'nullable|integer|exists:collections,id',
            'due_review' => 'nullable|boolean',
        ]);

        $user = Auth::user();
        $collection = $this->resolveCollectionFromBody($request, $user, $character);

        $isCorrect = $this->computeIsAnswerCorrect($request, $character);
        $effectiveResult = $isCorrect ? $request->input('result') : 'again';

        $userCharacter = UserCharacter::firstOrCreate(
            [
                'user_id' => $user->id,
                'character_id' => $character->id,
            ],
            [
                'interval' => 15,
                'ease_factor' => 2.5,
                'repetitions' => 0,
                'streak' => 0,
                'total_reviews' => 0,
                'success_rate' => 0,
                'is_learned' => false,
                'days_studied' => 0,
                'next_review_at' => now(),
            ]
        );

        $dueReview = $request->boolean('due_review');
        $remainingBeforeDue = null;
        $initialDue = null;

        if ($dueReview) {
            $remainingBeforeDue = UserCharacter::where('user_id', $user->id)
                ->where('next_review_at', '<=', now())
                ->where('is_learned', false)
                ->count();
            $initialDue = (int) $request->session()->get('due_review_initial_count', max(1, $remainingBeforeDue));
            if ($remainingBeforeDue === $initialDue) {
                $request->session()->put('due_review_session_stats', ['correct' => 0, 'total' => 0]);
            }
        }

        $userCharacter->processReview($effectiveResult);

        $this->gamification->recordStudyActivity($user);

        $sessionStatsForEval = null;
        $incrementSession = false;

        if ($dueReview) {
            $stats = $request->session()->get('due_review_session_stats', ['correct' => 0, 'total' => 0]);
            $stats['total'] = (int) $stats['total'] + 1;
            if ($isCorrect) {
                $stats['correct'] = (int) $stats['correct'] + 1;
            }
            $request->session()->put('due_review_session_stats', $stats);

            $nextDue = UserCharacter::where('user_id', $user->id)
                ->where('next_review_at', '<=', now())
                ->where('is_learned', false)
                ->orderBy('next_review_at')
                ->first();

            if (! $nextDue) {
                $request->session()->forget('due_review_initial_count');
                $sessionStatsForEval = $stats;
                $incrementSession = true;
                $request->session()->forget('due_review_session_stats');
            }

            $newAchievements = $this->gamification->evaluateAndGrant($user, $sessionStatsForEval, $incrementSession);

            return response()->json([
                'success' => true,
                'message' => $this->getResultMessage($effectiveResult),
                'next_character_id' => $nextDue?->character_id,
                'redirect_url' => $nextDue ? null : route('dashboard'),
                'new_achievements' => $newAchievements,
            ]);
        }

        $newAchievements = $this->gamification->evaluateAndGrant($user, null, false);

        $ctx = $this->learningContext($user, $character, $collection);
        $nextCharacter = $ctx['nextCharacter'];

        $redirectUrl = $nextCharacter
            ? null
            : ($collection
                ? route('learning.collection.level', $collection)
                : route('learning.level', $character->hsk_level));

        return response()->json([
            'success' => true,
            'message' => $this->getResultMessage($effectiveResult),
            'next_character_id' => $nextCharacter?->id,
            'redirect_url' => $redirectUrl,
            'new_achievements' => $newAchievements,
        ]);
    }

    /**
     * Контекст страницы обучения для очереди «к повторению сегодня» (дашборд).
     */
    private function dueReviewContext(Request $request, $user, Character $character): array
    {
        $queueIds = UserCharacter::where('user_id', $user->id)
            ->where('next_review_at', '<=', now())
            ->where('is_learned', false)
            ->orderBy('next_review_at')
            ->pluck('character_id')
            ->all();

        $remainingCount = count($queueIds);

        if (! $request->session()->has('due_review_initial_count')) {
            $request->session()->put('due_review_initial_count', max(1, $remainingCount));
        }

        $initial = (int) $request->session()->get('due_review_initial_count');
        if ($initial < 1) {
            $initial = max(1, $remainingCount);
        }
        if ($remainingCount > $initial) {
            $initial = $remainingCount;
            $request->session()->put('due_review_initial_count', $initial);
        }

        $completed = max(0, $initial - $remainingCount);
        $progress = $initial > 0 ? min(100, max(0, (int) round(($completed / $initial) * 100))) : 0;

        $idx = array_search($character->id, $queueIds, true);
        if ($idx === false) {
            $idx = 0;
            $queueIds = [$character->id];
        }

        $prevCharacter = ($idx > 0) ? Character::find($queueIds[$idx - 1]) : null;
        $nextCharacter = ($idx < count($queueIds) - 1) ? Character::find($queueIds[$idx + 1]) : null;

        $queueSize = count($queueIds);

        $learnedCount = UserCharacter::where('user_id', $user->id)
            ->where('is_learned', true)
            ->count();

        return [
            'character' => $character,
            'prevCharacter' => $prevCharacter,
            'nextCharacter' => $nextCharacter,
            'totalInLevel' => $queueSize,
            'learnedCount' => $learnedCount,
            'practicedCount' => $completed,
            'progress' => $progress,
            'progressTitle' => 'Повторение по расписанию',
            'navTitle' => 'Очередь SRS',
            'backUrl' => route('dashboard'),
            'dueCompleted' => $completed,
            'dueInitial' => $initial,
            'dueRemaining' => $remainingCount,
        ];
    }

    private function learningContext($user, Character $character, ?Collection $learningCollection): array
    {
        if ($learningCollection) {
            $ids = DB::table('collection_character')
                ->where('collection_id', $learningCollection->id)
                ->orderBy('id')
                ->pluck('character_id')
                ->all();
            $idx = array_search($character->id, $ids, true);

            $prevCharacter = null;
            $nextCharacter = null;
            if ($idx !== false) {
                if ($idx > 0) {
                    $prevCharacter = Character::find($ids[$idx - 1]);
                }
                if ($idx < count($ids) - 1) {
                    $nextCharacter = Character::find($ids[$idx + 1]);
                }
            }

            $totalInLevel = count($ids);
            $charIds = $ids;

            $learnedCount = $totalInLevel > 0
                ? UserCharacter::where('user_id', $user->id)
                    ->whereIn('character_id', $charIds)
                    ->where('is_learned', true)
                    ->count()
                : 0;

            $practicedCount = $totalInLevel > 0
                ? UserCharacter::where('user_id', $user->id)
                    ->whereIn('character_id', $charIds)
                    ->where('total_reviews', '>', 0)
                    ->count()
                : 0;

            $progressTitle = 'Коллекция «' . $learningCollection->name . '»';
            $navTitle = $learningCollection->name;
            $backUrl = route('learning.collection.level', $learningCollection);
        } else {
            $prevCharacter = Character::where('hsk_level', $character->hsk_level)
                ->where('id', '<', $character->id)
                ->orderBy('id', 'desc')
                ->first();

            $nextCharacter = Character::where('hsk_level', $character->hsk_level)
                ->where('id', '>', $character->id)
                ->orderBy('id')
                ->first();

            $totalInLevel = Character::where('hsk_level', $character->hsk_level)->count();

            $learnedCount = UserCharacter::where('user_id', $user->id)
                ->whereHas('character', function ($query) use ($character) {
                    $query->where('hsk_level', $character->hsk_level);
                })
                ->where('is_learned', true)
                ->count();

            $practicedCount = UserCharacter::where('user_id', $user->id)
                ->whereHas('character', function ($query) use ($character) {
                    $query->where('hsk_level', $character->hsk_level);
                })
                ->where('total_reviews', '>', 0)
                ->count();

            $progressTitle = 'Прогресс уровня HSK ' . $character->hsk_level;
            $navTitle = 'HSK ' . $character->hsk_level;
            $backUrl = route('learning.level', $character->hsk_level);
        }

        $progress = $totalInLevel > 0
            ? min(100, max(0, (int) round(($practicedCount / $totalInLevel) * 100)))
            : 0;

        return compact(
            'character',
            'prevCharacter',
            'nextCharacter',
            'totalInLevel',
            'learnedCount',
            'practicedCount',
            'progress',
            'progressTitle',
            'navTitle',
            'backUrl'
        );
    }

    private function resolveCollectionFromQuery(Request $request, $user, Character $character): ?Collection
    {
        if (! $request->filled('collection')) {
            return null;
        }

        $collection = Collection::where('user_id', $user->id)
            ->where('id', $request->query('collection'))
            ->first();

        abort_unless($collection, 404);
        abort_unless(
            $collection->characters()->where('characters.id', $character->id)->exists(),
            404
        );

        return $collection;
    }

    private function resolveCollectionFromBody(Request $request, $user, Character $character): ?Collection
    {
        if (! $request->filled('collection_id')) {
            return null;
        }

        $collection = Collection::where('user_id', $user->id)
            ->where('id', $request->input('collection_id'))
            ->first();

        abort_unless($collection, 403);
        abort_unless(
            $collection->characters()->where('characters.id', $character->id)->exists(),
            403
        );

        return $collection;
    }

    private function authorizeOwnedCollection(Collection $collection): void
    {
        abort_unless($collection->user_id === Auth::id(), 403);
    }

    private function serializeCharacterForPanel(Character $character): array
    {
        return [
            'id' => $character->id,
            'glyph' => $character->character,
            'pinyin' => $character->pinyin,
            'meaning' => $character->meaning,
            'hsk_level' => $character->hsk_level,
            'audio_character' => Character::publicAudioUrl($character->audio_character),
            'example_hanzi' => $character->example_hanzi,
            'example_pinyin' => $character->example_pinyin,
            'example_translation' => $character->example_translation,
            'audio_example' => Character::publicAudioUrl($character->audio_example),
            'has_example' => (bool) $character->example_hanzi,
        ];
    }

    private function computeIsAnswerCorrect(Request $request, Character $character): bool
    {
        return match ($request->input('mode')) {
            'keyboard' => $this->validateMeaningAnswer(
                strtolower(trim((string) $request->input('answer', ''))),
                strtolower(trim((string) $character->meaning))
            ),
            'multiple' => (int) $request->input('selected_option') === $character->id,
            default => false,
        };
    }

    private function validateMeaningAnswer(string $userAnswer, string $correctAnswer): bool
    {
        $correctParts = explode(';', $correctAnswer);
        $correctParts = array_map('trim', $correctParts);
        $correctParts = array_map('strtolower', $correctParts);

        if (in_array($userAnswer, $correctParts, true)) {
            return true;
        }

        foreach ($correctParts as $part) {
            if ($part !== '' && (str_contains($part, $userAnswer) || str_contains($userAnswer, $part))) {
                return true;
            }
        }

        return false;
    }
}
