<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\User;
use App\Models\UserCharacter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Демо-аккаунты для тестирования UI с разным прогрессом.
 *
 * Общий пароль для всех (локальная разработка): см. {@see DemoUsersSeeder::DEMO_PASSWORD}
 *
 * | Email                           | Описание прогресса                          |
 * |---------------------------------|---------------------------------------------|
 * | demo.novice@kanjiflow.local     | Нет записей в user_characters               |
 * | demo.start@kanjiflow.local      | 5 иероглифов «в процессе», низкий SRS       |
 * | demo.hsk1-25@kanjiflow.local    | ~25% HSK1 выучено                           |
 * | demo.hsk1-50@kanjiflow.local    | ~50% HSK1 выучено                           |
 * | demo.hsk1-85@kanjiflow.local    | ~85% HSK1 выучено                           |
 * | demo.hsk1-plus@kanjiflow.local  | весь HSK1 + часть HSK2 выучены              |
 * | demo.review-queue@kanjiflow.local | Много карточек «к повторению» (срок прошёл) |
 * | demo.streak@kanjiflow.local     | Высокая серия дней + средний прогресс       |
 * | demo.advanced@kanjiflow.local   | HSK1 полностью + ~половина HSK2             |
 * | demo.low-success@kanjiflow.local | Много карточек, низкий success_rate       |
 * | demo.one-master@kanjiflow.local | 1 выучен + несколько новых                  |
 * | demo.power-user@kanjiflow.local | Много завершённых сессий                    |
 */
class DemoUsersSeeder extends Seeder
{
    public const DEMO_PASSWORD = 'KanjiDemo2026';

    private const LEARNED_INTERVAL_MINUTES = 30 * 24 * 60;

    public function run(): void
    {
        $hsk1Ids = Character::query()->where('hsk_level', 1)->orderBy('id')->pluck('id')->values();
        $hsk2Ids = Character::query()->where('hsk_level', 2)->orderBy('id')->pluck('id')->values();

        if ($hsk1Ids->isEmpty()) {
            $this->command?->warn('DemoUsersSeeder: нет иероглифов HSK1. Сначала выполните CharacterSeeder.');

            return;
        }

        $passwordHash = Hash::make(self::DEMO_PASSWORD);

        $demoEmails = [
            'demo.novice@kanjiflow.local',
            'demo.start@kanjiflow.local',
            'demo.hsk1-25@kanjiflow.local',
            'demo.hsk1-50@kanjiflow.local',
            'demo.hsk1-85@kanjiflow.local',
            'demo.hsk1-plus@kanjiflow.local',
            'demo.review-queue@kanjiflow.local',
            'demo.streak@kanjiflow.local',
            'demo.advanced@kanjiflow.local',
            'demo.low-success@kanjiflow.local',
            'demo.one-master@kanjiflow.local',
            'demo.power-user@kanjiflow.local',
        ];

        $existingDemoIds = User::query()->whereIn('email', $demoEmails)->pluck('id');
        if ($existingDemoIds->isNotEmpty()) {
            UserCharacter::query()->whereIn('user_id', $existingDemoIds)->delete();
        }

        $n1 = $hsk1Ids->count();

        $usersSpec = [
            [
                'email' => 'demo.novice@kanjiflow.local',
                'name' => 'Демо · без прогресса',
                'last_study_date' => null,
                'study_streak' => 0,
                'study_sessions_completed' => 0,
                'characters' => [],
            ],
            [
                'email' => 'demo.start@kanjiflow.local',
                'name' => 'Демо · первые шаги',
                'last_study_date' => now()->subDays(2)->toDateString(),
                'study_streak' => 2,
                'study_sessions_completed' => 3,
                'characters' => $this->mapStudying($hsk1Ids->take(5)),
            ],
            [
                'email' => 'demo.hsk1-25@kanjiflow.local',
                'name' => 'Демо · HSK1 ~25%',
                'last_study_date' => now()->subDay()->toDateString(),
                'study_streak' => 4,
                'study_sessions_completed' => 18,
                'characters' => array_merge(
                    $this->mapLearned($hsk1Ids->take((int) max(1, floor($n1 * 0.25)))),
                    $this->mapStudying($hsk1Ids->slice((int) floor($n1 * 0.25), 4)),
                ),
            ],
            [
                'email' => 'demo.hsk1-50@kanjiflow.local',
                'name' => 'Демо · HSK1 ~50%',
                'last_study_date' => now()->subDay()->toDateString(),
                'study_streak' => 7,
                'study_sessions_completed' => 42,
                'characters' => array_merge(
                    $this->mapLearned($hsk1Ids->take((int) floor($n1 * 0.5))),
                    $this->mapStudying($hsk1Ids->slice((int) floor($n1 * 0.5), 6)),
                ),
            ],
            [
                'email' => 'demo.hsk1-85@kanjiflow.local',
                'name' => 'Демо · HSK1 ~85%',
                'last_study_date' => now()->toDateString(),
                'study_streak' => 11,
                'study_sessions_completed' => 95,
                'characters' => array_merge(
                    $this->mapLearned($hsk1Ids->take((int) floor($n1 * 0.85))),
                    $this->mapStudying($hsk1Ids->slice((int) floor($n1 * 0.85), 8)),
                ),
            ],
            [
                'email' => 'demo.hsk1-plus@kanjiflow.local',
                'name' => 'Демо · HSK1 полностью + HSK2',
                'last_study_date' => now()->toDateString(),
                'study_streak' => 20,
                'study_sessions_completed' => 140,
                'characters' => array_merge(
                    $this->mapLearned($hsk1Ids),
                    $hsk2Ids->isEmpty() ? [] : $this->mapLearned($hsk2Ids->take(max(1, (int) ceil($hsk2Ids->count() * 0.35)))),
                    $hsk2Ids->isEmpty() ? [] : $this->mapStudying($hsk2Ids->slice((int) ceil($hsk2Ids->count() * 0.35), 5)),
                ),
            ],
            [
                'email' => 'demo.review-queue@kanjiflow.local',
                'name' => 'Демо · очередь повторений',
                'last_study_date' => now()->subDays(3)->toDateString(),
                'study_streak' => 1,
                'study_sessions_completed' => 22,
                'characters' => $this->mapDueQueue($hsk1Ids->take(22)),
            ],
            [
                'email' => 'demo.streak@kanjiflow.local',
                'name' => 'Демо · длинная серия',
                'last_study_date' => now()->toDateString(),
                'study_streak' => 14,
                'study_sessions_completed' => 56,
                'characters' => array_merge(
                    $this->mapLearned($hsk1Ids->take((int) floor($n1 * 0.4))),
                    $this->mapStudying($hsk1Ids->slice((int) floor($n1 * 0.4), 10)),
                ),
            ],
            [
                'email' => 'demo.advanced@kanjiflow.local',
                'name' => 'Демо · продвинутый',
                'last_study_date' => now()->toDateString(),
                'study_streak' => 30,
                'study_sessions_completed' => 210,
                'characters' => array_merge(
                    $this->mapLearned($hsk1Ids),
                    $hsk2Ids->isEmpty() ? [] : $this->mapLearned($hsk2Ids->take((int) ceil($hsk2Ids->count() * 0.55))),
                    $hsk2Ids->isEmpty() ? [] : $this->mapStudying($hsk2Ids->slice((int) ceil($hsk2Ids->count() * 0.55), 6)),
                ),
            ],
            [
                'email' => 'demo.low-success@kanjiflow.local',
                'name' => 'Демо · низкий процент успеха',
                'last_study_date' => now()->subDay()->toDateString(),
                'study_streak' => 3,
                'study_sessions_completed' => 28,
                'characters' => $this->mapStruggling($hsk1Ids->take(14)),
            ],
            [
                'email' => 'demo.one-master@kanjiflow.local',
                'name' => 'Демо · одна выученная карточка',
                'last_study_date' => now()->subDays(5)->toDateString(),
                'study_streak' => 0,
                'study_sessions_completed' => 4,
                'characters' => array_merge(
                    $this->mapLearned($hsk1Ids->take(1)),
                    $this->mapNewbie($hsk1Ids->slice(1, 4)),
                ),
            ],
            [
                'email' => 'demo.power-user@kanjiflow.local',
                'name' => 'Демо · много сессий',
                'last_study_date' => now()->toDateString(),
                'study_streak' => 9,
                'study_sessions_completed' => 187,
                'characters' => array_merge(
                    $this->mapLearned($hsk1Ids->take((int) floor($n1 * 0.65))),
                    $this->mapStudying($hsk1Ids->slice((int) floor($n1 * 0.65), 12)),
                ),
            ],
        ];

        foreach ($usersSpec as $spec) {
            $user = User::query()->updateOrCreate(
                ['email' => $spec['email']],
                [
                    'name' => $spec['name'],
                    'password' => $passwordHash,
                    'role' => 'user',
                    'email_verified_at' => now(),
                    'two_factor_enabled' => false,
                    'two_factor_code' => null,
                    'two_factor_expires_at' => null,
                    'login_attempts' => 0,
                    'locked_until' => null,
                    'last_study_date' => $spec['last_study_date'],
                    'study_streak' => $spec['study_streak'],
                    'study_sessions_completed' => $spec['study_sessions_completed'],
                ]
            );

            foreach ($spec['characters'] as $row) {
                UserCharacter::query()->create(array_merge($row, ['user_id' => $user->id]));
            }
        }

        $this->command?->info('DemoUsersSeeder: создано/обновлено '.count($usersSpec).' пользователей. Пароль: '.self::DEMO_PASSWORD);
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
     * @param  \Illuminate\Support\Collection<int, int>  $ids
     * @return list<array<string, mixed>>
     */
    private function mapDueQueue($ids): array
    {
        $out = [];
        foreach ($ids as $i => $characterId) {
            $out[] = [
                'character_id' => $characterId,
                'interval' => 180,
                'ease_factor' => 2.2,
                'repetitions' => 1 + ($i % 2),
                'streak' => 1,
                'total_reviews' => 4 + ($i % 4),
                'next_review_at' => now()->subMinutes(30 + $i * 5),
                'last_reviewed_at' => now()->subDays(2),
                'last_result' => 'hard',
                'average_time' => 18.0,
                'success_rate' => 61.0,
                'is_learned' => false,
                'learned_at' => null,
                'days_studied' => 6,
            ];
        }

        return $out;
    }

    /**
     * @param  \Illuminate\Support\Collection<int, int>  $ids
     * @return list<array<string, mixed>>
     */
    private function mapStruggling($ids): array
    {
        $out = [];
        foreach ($ids as $i => $characterId) {
            $out[] = [
                'character_id' => $characterId,
                'interval' => 45,
                'ease_factor' => 1.85,
                'repetitions' => 0,
                'streak' => 0,
                'total_reviews' => 6 + $i,
                'next_review_at' => now()->addHour(),
                'last_reviewed_at' => now()->subHours(3),
                'last_result' => 'again',
                'average_time' => 25.0,
                'success_rate' => 38.0 + min(8, $i),
                'is_learned' => false,
                'learned_at' => null,
                'days_studied' => 4,
            ];
        }

        return $out;
    }

    /**
     * @param  \Illuminate\Support\Collection<int, int>  $ids
     * @return list<array<string, mixed>>
     */
    private function mapNewbie($ids): array
    {
        $out = [];
        foreach ($ids as $characterId) {
            $out[] = [
                'character_id' => $characterId,
                'interval' => 15,
                'ease_factor' => 2.5,
                'repetitions' => 0,
                'streak' => 0,
                'total_reviews' => 0,
                'next_review_at' => now(),
                'last_reviewed_at' => null,
                'last_result' => null,
                'average_time' => null,
                'success_rate' => 0,
                'is_learned' => false,
                'learned_at' => null,
                'days_studied' => 0,
            ];
        }

        return $out;
    }
}
