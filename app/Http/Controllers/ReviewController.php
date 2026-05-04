<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\InteractsWithReviewFeedback;
use App\Models\Character;
use App\Models\UserCharacter;
use App\Services\GamificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    use InteractsWithReviewFeedback;

    public function __construct(
        private GamificationService $gamification,
    ) {
        $this->middleware('auth');
    }

    /**
     * Alias для маршрута review.submit
     */
    public function submitResult(Request $request, UserCharacter $userCharacter)
    {
        return $this->submitAnswer($request, $userCharacter);
    }
    
    /**
     * Показать карточку для повторения
     */
    public function show(Request $request)
    {
        $user = Auth::user();
        $hskLevel = $request->get('hsk_level', 1);
        $mode = $request->get('mode', 'keyboard');
        
        // Получаем следующую карточку
        $userCharacter = $this->getNextCard($user->id, $hskLevel);
        
        if (!$userCharacter) {
            return view('review.completed', [
                'message' => "Нет карточек уровня HSK {$hskLevel} для повторения.",
                'hskLevel' => $hskLevel,
            ]);
        }
        
        return view('user.review.show', [
            'userCharacter' => $userCharacter,
            'character' => $userCharacter->character,
            'hskLevel' => $hskLevel,
            'mode' => $mode,
        ]);
    }
    
    /**
     * Получить следующую карточку
     */
    private function getNextCard(int $userId, int $hskLevel): ?UserCharacter
    {
        // 1. Сначала ищем просроченные карточки
        $dueCard = UserCharacter::where('user_id', $userId)
            ->where('next_review_at', '<=', now())
            ->where('is_learned', false)
            ->whereHas('character', function($q) use ($hskLevel) {
                $q->where('hsk_level', $hskLevel);
            })
            ->with('character')
            ->orderBy('next_review_at')
            ->first();
            
        if ($dueCard) {
            return $dueCard;
        }
        
        // 2. Если нет, ищем новые карточки этого уровня
        return $this->getNewCard($userId, $hskLevel);
    }
    
    /**
     * Получить новую карточку (иероглиф, который пользователь ещё не видел)
     */
    private function getNewCard(int $userId, int $hskLevel): ?UserCharacter
    {
        // Ищем иероглифы, которые пользователь ещё не изучал
        $learnedIds = UserCharacter::where('user_id', $userId)
            ->pluck('character_id');
            
        $character = Character::whereNotIn('id', $learnedIds)
            ->where('hsk_level', $hskLevel)
            ->orderBy('id')
            ->first();
            
        if ($character) {
            // Создаём SRS запись
            return UserCharacter::create([
                'user_id' => $userId,
                'character_id' => $character->id,
                'interval' => 1,
                'ease_factor' => 2.5,
                'next_review_at' => now()->addDay(),
            ]);
        }
        
        return null;
    }
    
    /**
     * Обработать ответ пользователя
     */
    public function submitAnswer(Request $request, UserCharacter $userCharacter)
    {
        $request->validate([
            'result' => 'required|in:again,hard,good,easy',
            'mode' => 'required|in:keyboard,multiple',
            'answer' => 'nullable|string', // для режима keyboard
            'selected_option' => 'nullable|integer', // для режима multiple
        ]);
        
        // Проверяем, что карточка принадлежит пользователю
        if ($userCharacter->user_id !== Auth::id()) {
            abort(403);
        }
        
        // Обрабатываем результат через SRS (метод в модели UserCharacter)
        $userCharacter->processReview($request->result);
        $userCharacter->refresh();

        $user = Auth::user();
        $this->gamification->recordStudyActivity($user);
        $newAchievements = $this->gamification->evaluateAndGrant($user, null, false);

        // Получаем следующую карточку
        $nextCard = $this->getNextCard(Auth::id(), $request->get('hsk_level', 1));

        return response()->json([
            'success' => true,
            'message' => $this->getResultMessage($request->result),
            'next_review_at' => $userCharacter->next_review_at?->format('d.m.Y H:i'),
            'next_card' => $nextCard ? [
                'id' => $nextCard->id,
                'character' => $nextCard->character->character,
                'pinyin' => $nextCard->character->pinyin,
            ] : null,
            'new_achievements' => $newAchievements,
        ]);
    }
}