@php
    $categoryLabels = [
        'progress' => 'Прогресс',
        'regularity' => 'Регулярность',
        'accuracy' => 'Точность',
    ];
@endphp
<x-app-layout>
    <div class="achievements-page page-achievements-index">
        <div class="achievements-shell">
            <header class="achievements-header">
                <div class="achievements-header-text">
                    <h1 class="achievements-title">Мои достижения</h1>
                    <p class="achievements-lead">
                        Получено {{ $earnedCount }} из {{ $totalCount }}.
                        Продолжайте заниматься, чтобы открыть остальные награды.
                    </p>
                </div>
                <a href="{{ route('dashboard') }}" class="btn btn-ghost">← В личный кабинет</a>
            </header>

            @if($sortedAchievements->isEmpty())
                <div class="achievements-empty-state">
                    <p>Достижения пока не настроены.</p>
                </div>
            @else
                <ul class="achievements-full-list" role="list">
                    @foreach($sortedAchievements as $achievement)
                        <li class="achievements-full-item" role="listitem">
                            @include('user.achievements.partials.card', [
                                'achievement' => $achievement,
                                'earnedAtByAchievementId' => $earnedAtByAchievementId,
                            ])
                            <span class="achievement-category-badge">
                                {{ $categoryLabels[$achievement->category] ?? $achievement->category }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-app-layout>
