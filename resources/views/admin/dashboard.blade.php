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
                        <h3>Самые сложные иероглифы</h3>
                        <span class="chart-badge">оценки Не помню и «Сложно»</span>
                    </div>
                    @if(count($hardestCharacters) > 0)
                        <div class="admin-bar-chart admin-bar-chart--hardest">
                            @foreach($hardestCharacters as $item)
                                @php
                                    $cnt = $item['difficult_count'];
                                    $pct = $maxHardestCount > 0 ? round(($cnt / $maxHardestCount) * 100) : 0;
                                    $title = $item['character'] . ': ' . $cnt
                                        . ' (снова: ' . $item['again_count'] . ', сложно: ' . $item['hard_count'] . ')';
                                @endphp
                                <div class="admin-bar-chart__col">
                                    <div class="admin-bar-chart__bar-wrap">
                                        <div class="admin-bar-chart__bar admin-bar-chart__bar--hardest" style="height: {{ max($pct, 8) }}%;" title="{{ $title }}"></div>
                                    </div>
                                    <span class="admin-bar-chart__label admin-bar-chart__label--glyph">{{ $item['character'] }}</span>
                                    <span class="admin-bar-chart__count">{{ number_format($cnt, 0, ',', ' ') }}</span>
                                </div>
                            @endforeach
                        </div>
                        <p class="chart-footnote">Топ по числу карт с последней оценкой «Снова» или «Сложно» у всех пользователей. Наведите на столбец — разбивка по типу оценки.</p>
                    @else
                        <p class="chart-placeholder">Пока нет данных: пользователи ещё не отмечали иероглифы как сложные при повторении.</p>
                    @endif
                </div>
            </div>

            <section class="admin-content-hub" aria-labelledby="admin-content-hub-title">
                <header class="admin-content-hub-header">
                    <h3 id="admin-content-hub-title">Управление контентом</h3>
                    <p class="admin-content-hub-lead">Разделы базы: иероглифы для обучения, статьи для чтения и шаблоны тематических коллекций.</p>
                </header>

                <div class="admin-content-hub-grid">
                    <article class="admin-content-group admin-content-group--glyphs">
                        <header class="admin-content-group-head">
                            <div>
                                <h4 class="admin-content-group-title">Иероглифы</h4>
                                <p class="admin-content-group-meta">{{ number_format($totalCharacters, 0, ',', ' ') }} в базе</p>
                            </div>
                        </header>
                        <p class="admin-content-group-desc">Карточки HSK, импорт JSON, озвучка и правки.</p>
                        <a href="{{ route('admin.characters.index') }}" class="admin-content-group-primary">Открыть список иероглифов</a>
                        <ul class="admin-content-group-links">
                            <li><a href="{{ route('admin.characters.create') }}">Добавить иероглиф</a></li>
                            <li>
                                <a href="{{ route('admin.character-suggestions.index') }}">
                                    Предложения пользователей
                                    @if(($pendingCharacterSuggestions ?? 0) > 0)
                                        <span class="admin-pending-badge">{{ $pendingCharacterSuggestions }}</span>
                                    @endif
                                </a>
                            </li>
                        </ul>
                    </article>

                    <article class="admin-content-group admin-content-group--articles">
                        <header class="admin-content-group-head">
                            <div>
                                <h4 class="admin-content-group-title">Статьи</h4>
                                <p class="admin-content-group-meta">{{ number_format($totalArticles, 0, ',', ' ') }} опубликовано</p>
                            </div>
                        </header>
                        <p class="admin-content-group-desc">Материалы о языке и культуре для раздела статей.</p>
                        <a href="{{ route('admin.articles.index') }}" class="admin-content-group-primary">Открыть список статей</a>
                        <ul class="admin-content-group-links">
                            <li><a href="{{ route('admin.articles.create') }}">Добавить статью</a></li>
                        </ul>
                    </article>

                    <article class="admin-content-group admin-content-group--templates">
                        <header class="admin-content-group-head">
                            <div>
                                <h4 class="admin-content-group-title">Шаблоны подборок</h4>
                                <p class="admin-content-group-meta">{{ number_format($builtinTemplatesCount, 0, ',', ' ') }} шаблонов</p>
                            </div>
                        </header>
                        <p class="admin-content-group-desc">Тематические коллекции, синхронизируемые пользователям.</p>
                        <a href="{{ route('admin.builtin-collections.index') }}" class="admin-content-group-primary">Открыть шаблоны</a>
                        <ul class="admin-content-group-links">
                            <li><a href="{{ route('admin.builtin-collections.create') }}">Создать шаблон</a></li>
                        </ul>
                    </article>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
