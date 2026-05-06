<x-app-layout>
    <div class="admin-layout">
        <div class="admin-container">
            <div class="admin-hero">
                <h1>Админ-панель</h1>
                <p>
                    В базе:
                    <strong>{{ number_format($totalUsers, 0, ',', ' ') }}</strong> пользователей,
                    <strong>{{ number_format($totalCharacters, 0, ',', ' ') }}</strong> иероглифов,
                    <strong>{{ number_format($totalArticles, 0, ',', ' ') }}</strong> статей,
                    <strong>{{ number_format($builtinTemplatesCount, 0, ',', ' ') }}</strong> шаблонов тематических подборок.
                </p>
            </div>

            <div class="admin-stats">
                <div class="stat-card">
                    <div class="stat-value">{{ number_format($totalUsers, 0, ',', ' ') }}</div>
                    <div class="stat-label">Всего пользователей</div>
                    <div class="stat-change stat-change-muted">+{{ number_format($newUsersWeek, 0, ',', ' ') }} зарегистрировались за 7 дней</div>
                </div>

                <div class="stat-card">
                    <div class="stat-value">{{ number_format($activeTodayUsers, 0, ',', ' ') }}</div>
                    <div class="stat-label">Активных сегодня</div>
                    <div class="stat-change stat-change-muted">Уникальных пользователей с отметкой повторения за сегодня</div>
                </div>

                <div class="stat-card">
                    <div class="stat-value">{{ number_format($learnedGlyphRecords, 0, ',', ' ') }}</div>
                    <div class="stat-label">Выучено иероглифов</div>
                    <div class="stat-change stat-change-muted">Записей пользователь ↔ иероглиф со статусом «выучено»</div>
                </div>

                <div class="stat-card">
                    <div class="stat-value">{{ number_format($totalReviews, 0, ',', ' ') }}</div>
                    <div class="stat-label">Всего повторений</div>
                    <div class="stat-change stat-change-muted">Сумма счётчиков повторений по всем картам</div>
                </div>
            </div>

            <div class="admin-charts">
                <div class="chart-container">
                    <div class="chart-header">
                        <h3>Активность: повторения по дням</h3>
                        <span class="chart-badge">7 дней</span>
                    </div>
                    <div class="admin-bar-chart">
                        @foreach($reviewsPerDay as $day)
                            @php
                                $pct = $maxReviewsDay > 0 ? round(($day['count'] / $maxReviewsDay) * 100) : 0;
                            @endphp
                            <div class="admin-bar-chart__col">
                                <div class="admin-bar-chart__bar-wrap">
                                    <div class="admin-bar-chart__bar" style="height: {{ max($pct, $day['count'] > 0 ? 8 : 0) }}%;" title="{{ $day['count'] }} повторений"></div>
                                </div>
                                <span class="admin-bar-chart__label">{{ $day['label'] }}</span>
                                <span class="admin-bar-chart__count">{{ $day['count'] }}</span>
                            </div>
                        @endforeach
                    </div>
                    <p class="chart-footnote">По числу записей с обновлённым полем «последнее повторение» в этот календарный день.</p>
                </div>

                <div class="chart-container">
                    <div class="chart-header">
                        <h3>Распределение по уровням HSK</h3>
                        <span class="chart-badge">карты в обучении</span>
                    </div>
                    <div class="admin-bar-chart admin-bar-chart--hsk">
                        @foreach(range(1, 6) as $level)
                            @php
                                $cnt = $hskDistribution[$level] ?? 0;
                                $pct = $maxHskCount > 0 ? round(($cnt / $maxHskCount) * 100) : 0;
                            @endphp
                            <div class="admin-bar-chart__col">
                                <div class="admin-bar-chart__bar-wrap">
                                    <div class="admin-bar-chart__bar admin-bar-chart__bar--hsk" style="height: {{ max($pct, $cnt > 0 ? 8 : 0) }}%;" title="HSK {{ $level }}: {{ $cnt }}"></div>
                                </div>
                                <span class="admin-bar-chart__label">HSK {{ $level }}</span>
                                <span class="admin-bar-chart__count">{{ number_format($cnt, 0, ',', ' ') }}</span>
                            </div>
                        @endforeach
                    </div>
                    <p class="chart-footnote">Количество связей пользователь ↔ иероглиф по уровню HSK иероглифа.</p>
                </div>
            </div>

            <div class="quick-actions">
                <h3>Управление контентом</h3>
                <div class="action-buttons">
                    <a href="{{ route('admin.builtin-collections.index') }}" class="action-btn">
                        <div class="action-text">
                            <div class="action-title">Тематические подборки</div>
                            <div class="action-desc">Шаблоны коллекций для пользователей</div>
                        </div>
                    </a>

                    <a href="{{ route('admin.characters.index') }}" class="action-btn">
                        <div class="action-text">
                            <div class="action-title">Иероглифы</div>
                            <div class="action-desc">Список, редактирование и удаление</div>
                        </div>
                    </a>

                    <a href="{{ route('admin.articles.index') }}" class="action-btn">
                        <div class="action-text">
                            <div class="action-title">Статьи</div>
                            <div class="action-desc">Материалы раздела статей</div>
                        </div>
                    </a>

                    <a href="{{ route('admin.characters.create') }}" class="action-btn">
                        <div class="action-text">
                            <div class="action-title">Добавить иероглиф</div>
                            <div class="action-desc">Новая карточка в базе</div>
                        </div>
                    </a>

                    <a href="{{ route('admin.articles.create') }}" class="action-btn">
                        <div class="action-text">
                            <div class="action-title">Добавить статью</div>
                            <div class="action-desc">Новый материал</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
