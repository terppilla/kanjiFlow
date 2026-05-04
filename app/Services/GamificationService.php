<?php

namespace App\Services;

use App\Models\Achievement;
use App\Models\User;
use App\Models\UserCharacter;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GamificationService
{
    /**
     * Учёт календарного дня занятий и серии дней подряд (максимум одно обновление в сутки).
     */
    public function recordStudyActivity(User $user): void
    {
        $user->refresh();

        $today = Carbon::today();
        $last = $user->last_study_date
            ? Carbon::parse($user->last_study_date)->startOfDay()
            : null;

        if ($last && $last->equalTo($today)) {
            return;
        }

        if ($last === null || $last->lt($today->copy()->subDay())) {
            $user->study_streak = 1;
        } else {
            $user->study_streak = (int) $user->study_streak + 1;
        }

        $user->last_study_date = $today->toDateString();
        $user->save();
    }

    /**
     * Проверить условия и выдать новые достижения.
     *
     * @param  array{correct: int, total: int}|null  $sessionStats  Статистика только что завершённой сессии «к повторению».
     * @return list<array{name: string, description: string, icon: string}>
     */
    public function evaluateAndGrant(User $user, ?array $sessionStats, bool $incrementSessionCounter): array
    {
        return DB::transaction(function () use ($user, $sessionStats, $incrementSessionCounter) {
            User::query()->whereKey($user->id)->lockForUpdate()->first();
            $user->refresh();

            if ($incrementSessionCounter) {
                $user->increment('study_sessions_completed');
                $user->refresh();
            }

            $learned = UserCharacter::where('user_id', $user->id)->where('is_learned', true)->count();
            $totalReviews = (int) UserCharacter::where('user_id', $user->id)->sum('total_reviews');
            $streak = (int) $user->study_streak;
            $sessions = (int) $user->study_sessions_completed;

            $earnedIds = $user->achievements()->pluck('achievements.id')->all();

            $toAttach = [];

            foreach (Achievement::query()->orderBy('id')->cursor() as $achievement) {
                if (in_array($achievement->id, $earnedIds, true)) {
                    continue;
                }

                if ($this->matches($achievement->slug, $learned, $streak, $sessions, $totalReviews, $sessionStats)) {
                    $toAttach[] = $achievement;
                }
            }

            $payload = [];

            foreach ($toAttach as $achievement) {
                $user->achievements()->attach($achievement->id, [
                    'earned_at' => now(),
                ]);
                $payload[] = [
                    'name' => $achievement->name,
                    'description' => $achievement->description,
                    'icon' => $achievement->icon,
                ];
            }

            return $payload;
        });
    }

    private function matches(
        string $slug,
        int $learned,
        int $streak,
        int $sessions,
        int $totalReviews,
        ?array $sessionStats
    ): bool {
        return match ($slug) {
            'first_step' => $sessions >= 1 || $totalReviews >= 1,
            'learned_50' => $learned >= 50,
            'learned_200' => $learned >= 200,
            'learned_500' => $learned >= 500,
            'streak_3' => $streak >= 3,
            'streak_7' => $streak >= 7,
            'streak_30' => $streak >= 30,
            'streak_100' => $streak >= 100,
            'session_accuracy_90_20' => $this->sessionAccuracyAtLeast($sessionStats, 20, 90.0),
            'session_accuracy_95_30' => $this->sessionAccuracyAtLeast($sessionStats, 30, 95.0),
            'session_accuracy_100_50' => $this->sessionPerfect($sessionStats, 50),
            default => false,
        };
    }

    private function sessionAccuracyAtLeast(?array $sessionStats, int $minCards, float $minPercent): bool
    {
        if (! $sessionStats || ($sessionStats['total'] ?? 0) < $minCards) {
            return false;
        }

        $total = (int) $sessionStats['total'];
        $correct = (int) $sessionStats['correct'];

        if ($total < 1) {
            return false;
        }

        return (($correct * 100.0) / $total) >= $minPercent - 0.0001;
    }

    private function sessionPerfect(?array $sessionStats, int $minCards): bool
    {
        if (! $sessionStats || ($sessionStats['total'] ?? 0) < $minCards) {
            return false;
        }

        return (int) $sessionStats['correct'] === (int) $sessionStats['total'];
    }
}
