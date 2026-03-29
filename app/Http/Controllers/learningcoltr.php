<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\UserCharacter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LearningController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Выбор уровня HSK для обучения
     */
    public function selectLevel()
    {
        $user = Auth::user();
        
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
        
        return view('user.learning.select-level', compact('hskStats'));
    }
    
    /**
     * Показать список иероглифов уровня HSK
     */
    public function showLevel($level)
    {
        $characters = Character::where('hsk_level', $level)
            ->orderBy('id')
            ->paginate(20);
            
        $user = Auth::user();
        
        $learnedCharacterIds = UserCharacter::where('user_id', $user->id)
            ->where('is_learned', true)
            ->pluck('character_id')
            ->toArray();
        
        return view('user.learning.level', compact('characters', 'level', 'learnedCharacterIds'));
    }
    
    /**
     * Показать карточку для изучения
     */
    public function show(Request $request, Character $character)
    {
        $user = Auth::user();
        $mode = $request->get('mode', 'keyboard');
        
        // Получаем соседние иероглифы
        $prevCharacter = Character::where('hsk_level', $character->hsk_level)
            ->where('id', '<', $character->id)
            ->orderBy('id', 'desc')
            ->first();
            
        $nextCharacter = Character::where('hsk_level', $character->hsk_level)
            ->where('id', '>', $character->id)
            ->orderBy('id')
            ->first();
        
        // Статистика для уровня
        $totalInLevel = Character::where('hsk_level', $character->hsk_level)->count();
        $learnedCount = UserCharacter::where('user_id', $user->id)
            ->whereHas('character', function($query) use ($character) {
                $query->where('hsk_level', $character->hsk_level);
            })
            ->where('is_learned', true)
            ->count();
        
        $progress = $totalInLevel > 0 ? round(($learnedCount / $totalInLevel) * 100) : 0;
        
        return view('user.learning.show', compact(
            'character',
            'mode',
            'prevCharacter',
            'nextCharacter',
            'totalInLevel',
            'learnedCount',
            'progress'
        ));
    }
    
    /**
     * Получить варианты ответов для multiple choice
     */
    public function getMultipleChoiceOptions(Character $character)
    {
        $options = [];
        
        // Добавляем правильный ответ
        $options[] = [
            'id' => $character->id,
            'meaning' => $character->meaning,
            'pinyin' => $character->pinyin,
            'is_correct' => true,
        ];
        
        // Получаем 3 случайных неправильных варианта
        $wrongCharacters = Character::where('hsk_level', $character->hsk_level)
            ->where('id', '!=', $character->id)
            ->inRandomOrder()
            ->limit(3)
            ->get()
            ->map(function($char) {
                return [
                    'id' => $char->id,
                    'meaning' => $char->meaning,
                    'pinyin' => $char->pinyin,
                    'is_correct' => false,
                ];
            })
            ->toArray();
        
        $options = array_merge($options, $wrongCharacters);
        
        // Перемешиваем
        shuffle($options);
        
        return response()->json([
            'success' => true,
            'options' => $options,
        ]);
    }
    
    /**
     * Проверить ответ
     */
    public function checkAnswer(Request $request, Character $character)
    {
        $request->validate([
            'mode' => 'required|in:keyboard,multiple',
            'answer' => 'required_if:mode,keyboard|string',
            'selected_option' => 'required_if:mode,multiple|integer',
        ]);
        
        $isCorrect = false;
        
        switch ($request->mode) {
            case 'keyboard':
                $userAnswer = strtolower(trim($request->answer));
                $correctAnswer = strtolower(trim($character->meaning));
                $isCorrect = $this->validateAnswer($userAnswer, $correctAnswer);
                break;
                
            case 'multiple':
                $selectedOption = (int) $request->selected_option;
                $isCorrect = $selectedOption === $character->id;
                break;
        }
        
        return response()->json([
            'success' => true,
            'is_correct' => $isCorrect,
            'correct_answer' => [
                'character' => $character->character,
                'pinyin' => $character->pinyin,
                'meaning' => $character->meaning,
            ],
        ]);
    }
    
    /**
     * Валидация ответа с клавиатуры
     */
    private function validateAnswer(string $userAnswer, string $correctAnswer): bool
    {
        $correctParts = explode(';', $correctAnswer);
        $correctParts = array_map('trim', $correctParts);
        $correctParts = array_map('strtolower', $correctParts);
        
        if (in_array($userAnswer, $correctParts)) {
            return true;
        }
        
        foreach ($correctParts as $part) {
            if (str_contains($part, $userAnswer) || str_contains($userAnswer, $part)) {
                return true;
            }
        }
        
        return false;
    }
}