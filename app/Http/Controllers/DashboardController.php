<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Article;
use App\Models\BuiltinCollectionTemplate;
use App\Models\Character;
use App\Models\Collection;
use App\Models\User;
use App\Models\UserCharacter;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
public function index()
{
    $user = Auth::user();
    
    if ($user->isAdmin()) {
        return $this->adminIndex();
    }
    
    $collections = $user->collections()->withCount('characters')->get();
    $allCharacters = Character::all();
    $reviewStats = $user->getReviewStats();
    
    // Получаем иероглифы для повторения сегодня
    $dueCards = UserCharacter::where('user_id', $user->id)
        ->where('next_review_at', '<=', now())
        ->where('is_learned', false)
        ->with('character')
        ->orderBy('next_review_at')
        ->paginate(6);
    
        $dueCardsTotal = UserCharacter::where('user_id', $user->id)
            ->where('next_review_at', '<=', now())
            ->where('is_learned', false)
            ->count();

        $allAchievements = Achievement::query()
            ->orderBy('category')
            ->orderBy('id')
            ->get();

        $earnedById = $user->achievements()->get()->keyBy('id');

        $sortedAchievements = $allAchievements
            ->sort(function (Achievement $a, Achievement $b) use ($earnedById) {
                $aEarned = $earnedById->has($a->id);
                $bEarned = $earnedById->has($b->id);
                if ($aEarned !== $bEarned) {
                    return $aEarned ? -1 : 1;
                }
                if ($aEarned) {
                    $ta = Carbon::parse($earnedById[$a->id]->pivot->earned_at)->timestamp;
                    $tb = Carbon::parse($earnedById[$b->id]->pivot->earned_at)->timestamp;

                    return $tb <=> $ta;
                }

                return ($a->category <=> $b->category) ?: ($a->id <=> $b->id);
            })
            ->values();

        $earnedAtByAchievementId = $earnedById->mapWithKeys(
            fn (Achievement $row) => [$row->id => $row->pivot->earned_at]
        )->all();

    // Статистика по уровням HSK
    $hskStats = [];
    for ($level = 1; $level <= 6; $level++) {
        $totalInLevel = Character::where('hsk_level', $level)->count();
        $learnedInLevel = UserCharacter::where('user_id', $user->id)
            ->whereHas('character', function($query) use ($level) {
                $query->where('hsk_level', $level);
            })
            ->where('is_learned', true)
            ->count();
            
        $hskStats[$level] = [
            'total' => $totalInLevel,
            'learned' => $learnedInLevel,
            'progress' => $totalInLevel > 0 ? round(($learnedInLevel / $totalInLevel) * 100) : 0,
        ];
    }
    

    return view('user.dashboard', compact(
        'collections',
        'allCharacters',
        'reviewStats',
        'dueCards',
        'hskStats',
        'dueCardsTotal',
        'sortedAchievements',
        'earnedAtByAchievementId',
    ));
}




    public function adminIndex()
    {
        $totalCharacters = Character::count();
        $totalUsers = User::count();
        $totalArticles = Article::query()->count();

        $newUsersWeek = User::where('created_at', '>=', now()->subDays(7))->count();

        $activeTodayUsers = (int) DB::table('user_characters')
            ->whereNotNull('last_reviewed_at')
            ->where('last_reviewed_at', '>=', now()->startOfDay())
            ->selectRaw('COUNT(DISTINCT user_id) AS c')
            ->value('c');

        $learnedGlyphRecords = UserCharacter::where('is_learned', true)->count();
        $totalReviews = (int) UserCharacter::query()->sum('total_reviews');

        $reviewsPerDay = [];
        $maxReviewsDay = 1;
        for ($i = 6; $i >= 0; $i--) {
            $day = now()->subDays($i);
            $count = UserCharacter::whereDate('last_reviewed_at', $day->toDateString())->count();
            $reviewsPerDay[] = [
                'label' => $day->format('d.m'),
                'count' => $count,
            ];
            $maxReviewsDay = max($maxReviewsDay, $count);
        }

        $hskRaw = DB::table('user_characters')
            ->join('characters', 'user_characters.character_id', '=', 'characters.id')
            ->select('characters.hsk_level', DB::raw('COUNT(*) as cnt'))
            ->groupBy('characters.hsk_level')
            ->orderBy('characters.hsk_level')
            ->pluck('cnt', 'hsk_level');

        $hskDistribution = [];
        $maxHskCount = 1;
        for ($level = 1; $level <= 6; $level++) {
            $cnt = (int) ($hskRaw[$level] ?? 0);
            $hskDistribution[$level] = $cnt;
            $maxHskCount = max($maxHskCount, $cnt);
        }

        $builtinTemplatesCount = Schema::hasTable('builtin_collection_templates')
            ? BuiltinCollectionTemplate::query()->count()
            : 0;

        return view('admin.dashboard', compact(
            'totalCharacters',
            'totalUsers',
            'totalArticles',
            'newUsersWeek',
            'activeTodayUsers',
            'learnedGlyphRecords',
            'totalReviews',
            'reviewsPerDay',
            'maxReviewsDay',
            'hskDistribution',
            'maxHskCount',
            'builtinTemplatesCount',
        ));
    }
    
    public function stats()
    {
        $user = Auth::user();
        $stats = [
            'total_cards' => UserCharacter::where('user_id', $user->id)->count(),
            'learned_cards' => UserCharacter::where('user_id', $user->id)
                ->where('is_learned', true)
                ->count(),
            'due_cards' => UserCharacter::where('user_id', $user->id)
                ->where('next_review_at', '<=', now())
                ->where('is_learned', false)
                ->count(),
            'total_reviews' => UserCharacter::where('user_id', $user->id)->sum('total_reviews'),
            'average_success_rate' => UserCharacter::where('user_id', $user->id)->avg('success_rate') ?? 0,
        ];
        
        return view('user.stats', compact('stats'));
    }
    
//     // Старые методы для обратной совместимости
//     public function createCollection(Request $request)
//     {
//         $request->validate(['name' => 'required|string|max:255']);
        
//         $collection = Auth::user()->collections()->create([
//             'name' => $request->name,
//         ]);
        
//         return redirect()->route('dashboard')
//             ->with('success', 'Коллекция создана успешно!');
//     }
    
//     public function deleteCollection($id)
//     {
//         $collection = Collection::findOrFail($id);
//         $this->authorize('delete', $collection);
        
//         $collection->delete();
        
//         return redirect()->route('dashboard')
//             ->with('success', 'Коллекция удалена успешно!');
//     }
    
//     public function addCharacterToCollection(Request $request, $collectionId)
//     {
//         $request->validate(['character_id' => 'required|exists:characters,id']);
        
//         $collection = Collection::findOrFail($collectionId);
//         $this->authorize('update', $collection);
        
//         if (!$collection->characters->contains($request->character_id)) {
//             $collection->characters()->attach($request->character_id);
//         }
        
//         return back()->with('success', 'Иероглиф добавлен в коллекцию!');
//     }
    
//     public function addMultipleCharacters(Request $request, $collectionId)
//     {
//         $request->validate([
//             'character_ids' => 'required|array',
//             'character_ids.*' => 'exists:characters,id',
//         ]);
        
//         $collection = Collection::findOrFail($collectionId);
//         $this->authorize('update', $collection);
        
//         $newCharacters = array_diff($request->character_ids, $collection->characters->pluck('id')->toArray());
        
//         if (!empty($newCharacters)) {
//             $collection->characters()->attach($newCharacters);
//         }
        
//         return back()->with('success', count($newCharacters) . ' иероглифов добавлено в коллекцию!');
//     }
    
//     public function removeCharacterFromCollection($collectionId, $characterId)
//     {
//         $collection = Collection::findOrFail($collectionId);
//         $this->authorize('update', $collection);
        
//         $collection->characters()->detach($characterId);
        
//         return back()->with('success', 'Иероглиф удален из коллекции');
//     }
}