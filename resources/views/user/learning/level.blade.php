<x-app-layout>
    <div class="learning-level-page">
        <div class="learning-level-shell">
            <div class="learning-level-inner page-learning-level">
                <nav class="level-navigation level-navigation-bar" aria-label="Раздел">
                    @if(isset($collection) && $collection)
                        <a href="{{ route('collections.show', $collection) }}" class="nav-btn">
                            ← К коллекции
                        </a>
                    @else
                        <a href="{{ route('learning.select-level') }}" class="nav-btn">
                            ← Назад к выбору уровня
                        </a>
                    @endif

                    @if($characters->count() > 0)
                        @if(isset($collection) && $collection)
                            <a href="{{ route('learning.collection.show', [$collection, $characters->first()]) }}" class="nav-btn nav-btn--accent">
                                Начать изучение →
                            </a>
                        @else
                            <a href="{{ route('learning.show', $characters->first() ?? 1) }}" class="nav-btn nav-btn--accent">
                                Начать изучение →
                            </a>
                        @endif
                    @endif
                </nav>

                <header class="level-header">
                    @if(isset($collection) && $collection)
                        <h1>{{ $collection->name }}</h1>
                        <p>Коллекция: изучение выбранных иероглифов</p>
                    @else
                        <h1>HSK {{ $level }}</h1>
                        <p>Изучение иероглифов уровня HSK {{ $level }}</p>
                    @endif

                    <div class="level-stats">
                        <div class="stat">
                            <span class="stat-value">{{ $totalScope }}</span>
                            <span class="stat-label">Всего иероглифов</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">{{ $learnedScopeCount }}</span>
                            <span class="stat-label">Выучено</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">
                                {{ $totalScope > 0 ? round(($learnedScopeCount / $totalScope) * 100) : 0 }}%
                            </span>
                            <span class="stat-label">Прогресс</span>
                        </div>
                    </div>
                </header>

                <div class="learning-level-panel learning-level-panel--search">
                    <div class="search-box">
                        <input type="text"
                               class="search-input"
                               placeholder="Поиск иероглифа по значению или пиньиню..."
                               id="searchInput"
                               autocomplete="off">
                        <button type="button" class="search-btn" id="searchBtn">Найти</button>
                    </div>
                </div>

                @if($characters->count() > 0)
                    <section class="learning-level-panel learning-level-panel--grid" aria-live="polite">
                        <div id="levelPaginatedRegion">
                            @include('user.learning.partials.level-characters')
                        </div>
                    </section>
                @else
                    <div class="learning-level-panel learning-level-panel--empty">
                        <div class="empty-state">
                            @if(isset($collection) && $collection)
                                <h3>Коллекция пуста</h3>
                                <p><a href="{{ route('collections.show', $collection) }}">Добавьте иероглифы</a> в коллекцию.</p>
                            @else
                                <h3>В этом уровне пока нет иероглифов</h3>
                                <p>В базе данных еще нет иероглифов уровня HSK {{ $level }}</p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        (function() {
            const region = document.getElementById('levelPaginatedRegion');
            const searchBtn = document.getElementById('searchBtn');
            const searchInput = document.getElementById('searchInput');

            function filterCharacters() {
                if (!searchInput) return;
                const searchTerm = searchInput.value.toLowerCase().trim();
                const cards = document.querySelectorAll('#charactersGrid .character-card');

                cards.forEach(function(card) {
                    const pinyin = card.dataset.pinyin || '';
                    const meaning = card.dataset.meaning || '';
                    if (searchTerm === '' || pinyin.includes(searchTerm) || meaning.includes(searchTerm)) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }

            if (searchBtn) searchBtn.addEventListener('click', filterCharacters);
            if (searchInput) {
                searchInput.addEventListener('keyup', function(e) {
                    if (e.key === 'Enter') filterCharacters();
                });
            }

            function reorderLearnedCardsFirst(container) {
                const root = container || document;
                const learnedCards = root.querySelectorAll('#charactersGrid .character-card.learned');
                learnedCards.forEach(function(card) {
                    card.style.order = '-1';
                });
            }

            document.addEventListener('DOMContentLoaded', function() {
                reorderLearnedCardsFirst();
            });

            if (!region) return;

            async function loadLevelPage(url, opts) {
                const pushState = opts && opts.pushState !== false;
                region.setAttribute('aria-busy', 'true');
                region.style.opacity = '0.55';
                region.style.pointerEvents = 'none';
                try {
                    const r = await fetch(url, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html',
                        },
                        credentials: 'same-origin',
                    });
                    if (!r.ok) throw new Error('HTTP');
                    const html = await r.text();
                    region.innerHTML = html;
                    reorderLearnedCardsFirst(region);
                    filterCharacters();
                    if (pushState && window.history && window.history.pushState) {
                        window.history.pushState({ levelAjax: true }, '', url);
                    }
                    region.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                } catch (e) {
                    window.location.href = url;
                } finally {
                    region.removeAttribute('aria-busy');
                    region.style.opacity = '';
                    region.style.pointerEvents = '';
                }
            }

            region.addEventListener('click', function(e) {
                const a = e.target.closest('a');
                if (!a || !region.contains(a)) return;
                const pag = a.closest('[data-level-pagination]');
                if (!pag) return;
                e.preventDefault();
                loadLevelPage(a.href, { pushState: true });
            });

            window.addEventListener('popstate', function() {
                if (!document.getElementById('levelPaginatedRegion')) return;
                loadLevelPage(window.location.href, { pushState: false });
            });
        })();
    </script>
</x-app-layout>
