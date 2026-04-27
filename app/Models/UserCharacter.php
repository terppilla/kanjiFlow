<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserCharacter extends Model
{
    use HasFactory;

    protected $table = 'user_characters';

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

    /**
     * Обновление SRS по оценке: again | hard | good | easy
     * (как в повторении: «забыл» … «легко»).
     */
    public function processReview(string $result): void
    {
        $result = in_array($result, ['again', 'hard', 'good', 'easy'], true) ? $result : 'again';

        $this->last_reviewed_at = now();
        $this->last_result = $result;
        $this->total_reviews = (int) $this->total_reviews + 1;

        $ease = (float) $this->ease_factor;
        $interval = (int) $this->interval;

        if ($result === 'again') {
            $this->repetitions = 0;
            $this->streak = 0;
            $this->ease_factor = max(1.3, $ease - 0.2);
            $this->interval = 15;
            $this->next_review_at = now()->addMinutes(30);
            $this->applySuccessRateUpdate(false);
            $this->checkIfLearned();
            $this->save();

            return;
        }

        $this->repetitions = (int) $this->repetitions + 1;
        $this->streak = (int) $this->streak + 1;

        match ($result) {
            'hard' => $this->applyHardGrade($interval, $ease),
            'good' => $this->applyGoodGrade($interval, $ease),
            'easy' => $this->applyEasyGrade($interval, $ease),
            default => null,
        };

        $this->next_review_at = now()->addMinutes(max(1, (int) $this->interval));
        $this->applySuccessRateUpdate(true);
        $this->checkIfLearned();
        $this->save();
    }

    private function applyHardGrade(int $interval, float $ease): void
    {
        $this->ease_factor = max(1.3, $ease - 0.15);
        $this->interval = (int) round($interval * 1.2);
    }

    private function applyGoodGrade(int $interval, float $ease): void
    {
        $this->interval = (int) round($interval * $ease);
    }

    private function applyEasyGrade(int $interval, float $ease): void
    {
        $this->ease_factor = min(2.5, $ease + 0.1);
        $this->interval = (int) round($interval * $ease * 1.3);
    }

    private function applySuccessRateUpdate(bool $wasSuccessful): void
    {
        $n = (int) $this->total_reviews;
        if ($n < 1) {
            return;
        }

        if ($n === 1) {
            $this->success_rate = $wasSuccessful ? 100.0 : 0.0;

            return;
        }

        $prevTotal = $n - 1;
        $successCount = ((float) $this->success_rate / 100.0) * $prevTotal;
        $successCount += $wasSuccessful ? 1.0 : 0.0;
        $this->success_rate = ($successCount / (float) $n) * 100.0;
    }

    private function checkIfLearned(): void
    {
        if ($this->is_learned) {
            return;
        }

        if (
            $this->repetitions >= 5
            && $this->interval >= 43_200
            && (float) $this->success_rate >= 90.0
        ) {
            $this->is_learned = true;
            $this->learned_at = now();
        }
    }
}
