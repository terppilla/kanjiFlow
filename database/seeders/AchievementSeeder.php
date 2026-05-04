<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'slug' => 'first_step',
                'name' => 'Первый шаг',
                'description' => 'Завершите первую учебную сессию или сделайте первое повторение.',
                'criteria' => 'sessions_completed >= 1 или total_reviews >= 1',
                'icon' => '👣',
                'category' => 'progress',
            ],
            [
                'slug' => 'learned_50',
                'name' => 'Исследователь',
                'description' => 'Изучите 50 иероглифов (отмечены как выученные в SRS).',
                'criteria' => 'learned_characters >= 50',
                'icon' => '🔍',
                'category' => 'progress',
            ],
            [
                'slug' => 'learned_200',
                'name' => 'Путешественник',
                'description' => 'Изучите 200 иероглифов.',
                'criteria' => 'learned_characters >= 200',
                'icon' => '✈️',
                'category' => 'progress',
            ],
            [
                'slug' => 'learned_500',
                'name' => 'Мастер иероглифов',
                'description' => 'Изучите 500 иероглифов.',
                'criteria' => 'learned_characters >= 500',
                'icon' => '👑',
                'category' => 'progress',
            ],
            [
                'slug' => 'streak_3',
                'name' => 'Новичок',
                'description' => 'Занимайтесь 3 дня подряд.',
                'criteria' => 'study_streak >= 3',
                'icon' => '🌱',
                'category' => 'regularity',
            ],
            [
                'slug' => 'streak_7',
                'name' => 'Энтузиаст',
                'description' => 'Занимайтесь 7 дней подряд.',
                'criteria' => 'study_streak >= 7',
                'icon' => '🔥',
                'category' => 'regularity',
            ],
            [
                'slug' => 'streak_30',
                'name' => 'Непрерывный рост',
                'description' => 'Занимайтесь 30 дней подряд.',
                'criteria' => 'study_streak >= 30',
                'icon' => '📈',
                'category' => 'regularity',
            ],
            [
                'slug' => 'streak_100',
                'name' => 'Легенда регулярности',
                'description' => 'Занимайтесь 100 дней подряд.',
                'criteria' => 'study_streak >= 100',
                'icon' => '⭐',
                'category' => 'regularity',
            ],
            [
                'slug' => 'session_accuracy_90_20',
                'name' => 'Точный стрелок',
                'description' => 'В одной сессии «к повторению» ответьте верно не менее чем на 90% карточек (не менее 20 карточек в сессии).',
                'criteria' => 'accuracy >= 90%, cards >= 20 (сессия повторения)',
                'icon' => '🎯',
                'category' => 'accuracy',
            ],
            [
                'slug' => 'session_accuracy_95_30',
                'name' => 'Перфекционист',
                'description' => 'Не менее 95% верных ответов в сессии из минимум 30 карточек.',
                'criteria' => 'accuracy >= 95%, cards >= 30',
                'icon' => '💎',
                'category' => 'accuracy',
            ],
            [
                'slug' => 'session_accuracy_100_50',
                'name' => 'Невероятная точность',
                'description' => '100% верных ответов в сессии из минимум 50 карточек.',
                'criteria' => 'accuracy == 100%, cards >= 50',
                'icon' => '💯',
                'category' => 'accuracy',
            ],
        ];

        foreach ($rows as $row) {
            Achievement::query()->updateOrCreate(
                ['slug' => $row['slug']],
                $row
            );
        }
    }
}
