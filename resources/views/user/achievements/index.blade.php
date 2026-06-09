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
                @php
                    $categoryOrder = array_keys($categoryLabels);
                    $achievementsByCategory = $sortedAchievements->groupBy(
                        fn ($achievement) => $achievement->category ?? 'other'
                    );
                    $orderedCategories = collect($categoryOrder)
                        ->filter(fn ($category) => $achievementsByCategory->has($category))
                        ->merge(
                            $achievementsByCategory->keys()->diff($categoryOrder)->sort()->values()
                        );
                @endphp

                <div class="achievements-category-groups">
                    @foreach($orderedCategories as $category)
                        <section class="achievements-category-group" aria-labelledby="achievements-cat-{{ $category }}">
                            <h2 class="achievements-category-title" id="achievements-cat-{{ $category }}">
                                {{ $categoryLabels[$category] ?? $category }}
                            </h2>
                            <ul class="achievements-full-list" role="list">
                                @foreach($achievementsByCategory[$category] as $achievement)
                                    <li class="achievements-full-item" role="listitem">
                                        @include('user.achievements.partials.card', [
                                            'achievement' => $achievement,
                                            'earnedAtByAchievementId' => $earnedAtByAchievementId,
                                        ])
                                    </li>
                                @endforeach
                            </ul>
                        </section>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
