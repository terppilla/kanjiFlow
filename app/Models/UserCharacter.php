<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class UserCharacter extends Model
{
    use HasFactory;
    protected $table = "user_characters";

     protected $fillable = [
        'user_id',
        'character_id',
        'interval',
        'ease_factor',
        'repetitions',
        'streak',
        'total_reviews',
        'next_review_at',
        'last_reviewed_at',
        'last_result',
        'average_time',
        'success_rate',
        'is_learned',
        'learned_at',
        'days_studied',
    ];
    
    protected $casts = [
        'next_review_at' => 'datetime',
        'last_reviewed_at' => 'datetime',
        'learned_at' => 'datetime',
        'interval' => 'integer',
        'ease_factor' => 'float',
        'repetitions' => 'integer',
        'streak' => 'integer',
        'total_reviews' => 'integer',
        'average_time' => 'float',
        'success_rate' => 'float',
        'is_learned' => 'boolean',
        'days_studied' => 'integer',
    ];
    
    
   public function user(): BelongsTo 
   {
    return $this->belongsTo(User::class);
   }

   public function character(): BelongsTo
   {
    return $this->belongsTo(Character::class);
   }

   public function StartLearning(Character $character) :self {
    $this->userCharacters()->create([
        'character_id'=>$character->id, 
        'interval' => 15,
        'ease_factor' => 2.5,
        'repetitions' => 0,
        'streak' => 0,
        'total_reviews' => 0,
        'succes_rate' => 0,
        'is_learned' => false,
        'days_studied' => 0, 
        'last_reviewed_at' => now(),
        'next_review_at' => now()->addMinutes(15),
    ]);

    return $this;
   }

   public function proccessReview(string $result) {
    $this->last_reviewed_at = now();
    $this->last_result = $result;
    $this->total_reviews++;
    $isCorrect = $this->validatedAnswer($userAnswer, $CorrectAnswer);

    if (!isCorrect) {
        $this->interval = 15;
        $this->repetitions = 0;
        $this->ease_factor = max(1.3, $this->ease_factor - 0.2);
        $this->next_review_at = now()->addMinutes(30);
    } else {
        switch($result) {
            case 'again':
             $this->interval = 15;
             $this->repetitions = 0;
             $this->ease_factor = max(1.3, $this->ease_factor - 0.2);
             $this->next_review_at = now()->addMinutes(30);
             break;

            case 'hard':
                $this->repetitions++;
                $this->streak++;
                $this->ease_factor = max(1.3, $this->ease_factor - 0.15);
                $this->interval = (int) ($this->interval * 1.2);
                break;

             case 'good':
                $this->repetitions++;
                $this->streak++;
                $this->interval = (int) ($this->interval * $this->ease_factor);
                break;

            case 'ease':
                $this->repetitions++;
                $this->streak++;
                $this->ease_factor = min(2.5, $this->ease_factor + 0.1);
                $this->interval = (int) ($this->interval * $this->ease_factor * 1.3);
                break;
        }
            
       $this->next_review_at = now()->addMinutes($this->interval);
       $this->checkIfLearned();
       $this->updateSuccessRate();
       $this->save();
       return $this;
    }
    }

        private function validateAnswer(string $userAnswer = null, string $сorrectAnswer = null): bool
    {
        return strtolower(trim($userAnswer)) === strtolower(trim($correctAnswer));
    }

    private function checkIfLearned(): void 
    {
        if(!$this->is_learned && 
             $this->repetitions >= 5 &&
             $this->interval >= 43200 &&
             $this->success_rate >=90)
             {
                $this->is_learned = true;
                $this->learned_at = now();
             }
    }

    private function updateSuccessRate(string $result): void
    {
        $isSuccessful = in_array($result, ['good', 'ease']);

        if($this->total_reviews == 1) {
            $this->success_rate = $isSuccessful ? 100:0;
        } else {
            $successCount = ($this->success_rate / 100) * ($this->total_reviews - 1);
            $successCount += $isSuccessful ? 1 : 0;
            $this->success_rate = ($successCount / $this->total_reviews) * 100;
        }
    }
}