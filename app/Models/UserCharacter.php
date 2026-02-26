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

    public function processReview(string $result, int $responseTime = 0): self
{
    $this->last_reviewed_at = now();
    $this->last_result = $result;
    $this->total_reviews++;
    
    
    switch ($result) {
        case 'again':
            $this->interval = 1;
            $this->repetitions = 0;
            $this->streak = 0;
            $this->ease_factor = max(1.3, $this->ease_factor - 0.2);
            $this->next_review_at = now()->addDay();
            break;
            
        case 'hard':
            $this->repetitions++;
            $this->streak++;
            $this->ease_factor = max(1.3, $this->ease_factor - 0.15);
            
            if ($this->repetitions == 1) {
                $this->interval = 1;
            } elseif ($this->repetitions == 2) {
                $this->interval = 3;
            } else {
                $this->interval = (int) ($this->interval * 1.2);
            }
            
            $this->next_review_at = now()->addDays($this->interval);
            break;
            
        case 'good':
            $this->repetitions++;
            $this->streak++;
            
            if ($this->repetitions == 1) {
                $this->interval = 1;
            } elseif ($this->repetitions == 2) {
                $this->interval = 3;
            } else {
                $this->interval = (int) ($this->interval * $this->ease_factor);
            }
            
            $this->next_review_at = now()->addDays($this->interval);
            break;
            
        case 'easy':
            $this->repetitions++;
            $this->streak++;
            $this->ease_factor = min(2.5, $this->ease_factor + 0.1);
            
            if ($this->repetitions == 1) {
                $this->interval = 2;
            } elseif ($this->repetitions == 2) {
                $this->interval = 5;
            } else {
                $this->interval = (int) ($this->interval * $this->ease_factor * 1.3);
            }
            
            $this->next_review_at = now()->addDays($this->interval);
            break;
    }
    
   
    $this->updateSuccessRate($result);
    
    
    $this->checkIfLearned();
    
    $this->save();
    return $this;
}

private function updateSuccessRate(string $result): void
{
    $isSuccessful = in_array($result, ['good', 'easy']);
    
    if ($this->total_reviews == 1) {
        $this->success_rate = $isSuccessful ? 100 : 0;
    } else {
        $successCount = ($this->success_rate / 100) * ($this->total_reviews - 1);
        $successCount += $isSuccessful ? 1 : 0;
        $this->success_rate = ($successCount / $this->total_reviews) * 100;
    }
}

private function checkIfLearned(): void
{
    if (!$this->is_learned && 
        $this->repetitions >= 5 && 
        $this->interval >= 30 && 
        $this->success_rate >= 90) {
        
        $this->is_learned = true;
        $this->learned_at = now();
    }
}
}
