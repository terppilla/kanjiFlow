<?php

namespace App\Console\Commands;

use App\Models\Character;
use App\Models\User;
use App\Models\UserCharacter;
use App\Services\BuiltinCollectionsSync;
use App\Services\GamificationService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PrepareSiteDefenseCommand extends Command
{
    protected $signature = 'site:prepare-defense';

    protected $description = 'Настроить роли, 2FA и демо-прогресс для защиты сайта перед сдачей';

    private const ADMIN_EMAIL = 'admin_kanjiflow@gmail.com';

    private const ADMIN_PASSWORD = 'kanji_admin';

    private const LEARNED_INTERVAL_MINUTES = 30 * 24 * 60;

    public function handle(GamificationService $gamification, BuiltinCollectionsSync $builtinSync): int
    {
        $twoFactorEmail = config('auth.two_factor_allowed_email');

        if (! is_string($twoFactorEmail) || $twoFactorEmail === '') {
            $this->error('Не задан auth.two_factor_allowed_email (TWO_FACTOR_ALLOWED_EMAIL в .env).');

            return self::FAILURE;
        }

        $hsk1Ids = Character::query()->where('hsk_level', 1)->orderBy('id')->pluck('id');
        $hsk2Ids = Character::query()->where('hsk_level', 2)->orderBy('id')->pluck('id');
        $hsk3Ids = Character::query()->where('hsk_level', 3)->orderBy('id')->pluck('id');

        if ($hsk1Ids->isEmpty()) {
            $this->error('В базе нет иероглифов HSK1. Сначала выполните миграции и сиды.');

            return self::FAILURE;
        }

        DB::transaction(function () use ($twoFactorEmail, $hsk1Ids, $hsk2Ids, $hsk3Ids, $gamification, $builtinSync) {
            User::query()->update([
                'role' => 'user',
                'two_factor_enabled' => false,
                'two_factor_code' => null,
                'two_factor_expires_at' => null,
            ]);

            $admin = User::query()->updateOrCreate(
                ['email' => self::ADMIN_EMAIL],
                [
                    'name' => 'Администратор KanjiFlow',
                    'password' => Hash::make(self::ADMIN_PASSWORD),
                    'role' => 'admin',
                    'email_verified_at' => now(),
                    'two_factor_enabled' => false,
                    'two_factor_code' => null,
                    'two_factor_expires_at' => null,
                    'login_attempts' => 0,
                    'locked_until' => null,
                ]
            );

            $demoUser = User::query()->where('email', $twoFactorEmail)->first();

            if ($demoUser === null) {
                $this->warn("Пользователь {$twoFactorEmail} не найден — прогресс не загружен.");
            } else {
                $demoUser->update([
                    'role' => 'user',
                    'two_factor_enabled' => true,
                    'two_factor_code' => null,
                    'two_factor_expires_at' => null,
                    'email_verified_at' => $demoUser->email_verified_at ?? now(),
                    'last_study_date' => now()->toDateString(),
                    'study_streak' => 8,
                    'study_sessions_completed' => 62,
                    'login_attempts' => 0,
                    'locked_until' => null,
                ]);

                UserCharacter::query()->where('user_id', $demoUser->id)->delete();
                $demoUser->achievements()->detach();

                $n2 = $hsk2Ids->count();
                $n3 = $hsk3Ids->count();

                $rows = $this->deduplicateCharacterRows(array_merge(
                    $this->mapLearned($hsk1Ids),
                    $n2 > 0 ? $this->mapLearned($hsk2Ids->take((int) max(1, floor($n2 * 0.45)))) : [],
                    $n3 > 0 ? $this->mapLearned($hsk3Ids->take((int) max(1, floor($n3 * 0.15)))) : [],
                    $n2 > 0 ? $this->mapStudying($hsk2Ids->slice((int) floor($n2 * 0.45), 6)) : [],
                    $n3 > 0 ? $this->mapStudying($hsk3Ids->slice((int) floor($n3 * 0.15), 5)) : [],
                ));

                foreach ($rows as $row) {
                    UserCharacter::query()->create(array_merge($row, ['user_id' => $demoUser->id]));
                }

                $gamification->evaluateAndGrant($demoUser->fresh(), null, false);

                $builtinSync->syncForUser($demoUser->fresh());
            }

            $builtinSync->syncForUser($admin->fresh());
        });

        $learnedCount = UserCharacter::query()
            ->where('user_id', User::query()->where('email', $twoFactorEmail)->value('id'))
            ->where('is_learned', true)
            ->count();

        $achievementCount = User::query()
            ->where('email', $twoFactorEmail)
            ->first()
            ?->achievements()
            ->count() ?? 0;

        $this->info('Готово.');
        $this->line('Админ: '.self::ADMIN_EMAIL);
        $this->line("2FA включена только для: {$twoFactorEmail}");
        if (User::query()->where('email', $twoFactorEmail)->exists()) {
            $this->line("Прогресс демо-пользователя: {$learnedCount} выученных иероглифов, {$achievementCount} достижений.");
        }

        return self::SUCCESS;
    }

    /**
     * @param  \Illuminate\Support\Collection<int, int>  $ids
     * @return list<array<string, mixed>>
     */
    private function mapLearned($ids): array
    {
        $out = [];
        foreach ($ids as $characterId) {
            $out[] = [
                'character_id' => $characterId,
                'interval' => self::LEARNED_INTERVAL_MINUTES,
                'ease_factor' => 2.45,
                'repetitions' => 5,
                'streak' => 5,
                'total_reviews' => 14,
                'next_review_at' => now()->addDays(10),
                'last_reviewed_at' => now()->subDays(2),
                'last_result' => 'good',
                'average_time' => 7.2,
                'success_rate' => 93.0,
                'is_learned' => true,
                'learned_at' => now()->subWeeks(3),
                'days_studied' => 18,
            ];
        }

        return $out;
    }

    /**
     * @param  \Illuminate\Support\Collection<int, int>  $ids
     * @return list<array<string, mixed>>
     */
    private function mapStudying($ids): array
    {
        $out = [];
        foreach ($ids as $i => $characterId) {
            $out[] = [
                'character_id' => $characterId,
                'interval' => 360 + $i * 120,
                'ease_factor' => 2.35,
                'repetitions' => $i % 3 === 0 ? 1 : 2,
                'streak' => $i % 3,
                'total_reviews' => 3 + $i,
                'next_review_at' => now()->addHours(4 + $i),
                'last_reviewed_at' => now()->subHours(6),
                'last_result' => 'good',
                'average_time' => 12.0,
                'success_rate' => 72.0 + $i,
                'is_learned' => false,
                'learned_at' => null,
                'days_studied' => 5,
            ];
        }

        return $out;
    }

    /**
     * @param  list<array<string, mixed>>  $rows
     * @return list<array<string, mixed>>
     */
    private function deduplicateCharacterRows(array $rows): array
    {
        $byCharacter = [];

        foreach ($rows as $row) {
            $characterId = $row['character_id'];
            if (! isset($byCharacter[$characterId])) {
                $byCharacter[$characterId] = $row;
            }
        }

        return array_values($byCharacter);
    }
}
