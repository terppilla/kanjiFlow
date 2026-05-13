<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="learning-level-page">
        <div class="learning-level-shell">
            <div class="learning-level-inner page-learning-level">
                <nav class="level-navigation level-navigation-bar" aria-label="Раздел">
                    <?php if(isset($collection) && $collection): ?>
                        <a href="<?php echo e(route('collections.show', $collection)); ?>" class="nav-btn">
                            ← К коллекции
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('learning.select-level')); ?>" class="nav-btn">
                            ← Назад к выбору уровня
                        </a>
                    <?php endif; ?>

                    <?php if($characters->count() > 0): ?>
                        <?php if(isset($collection) && $collection): ?>
                            <a href="<?php echo e(route('learning.collection.show', [$collection, $characters->first()])); ?>" class="nav-btn nav-btn--accent">
                                Начать изучение →
                            </a>
                        <?php else: ?>
                            <a href="<?php echo e(route('learning.show', $characters->first() ?? 1)); ?>" class="nav-btn nav-btn--accent">
                                Начать изучение →
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                </nav>

                <header class="level-header">
                    <?php if(isset($collection) && $collection): ?>
                        <h1><?php echo e($collection->name); ?></h1>
                        <p>Коллекция: изучение выбранных иероглифов</p>
                    <?php else: ?>
                        <h1>HSK <?php echo e($level); ?></h1>
                        <p>Изучение иероглифов уровня HSK <?php echo e($level); ?></p>
                    <?php endif; ?>

                    <div class="level-stats">
                        <div class="stat">
                            <span class="stat-value"><?php echo e($totalScope); ?></span>
                            <span class="stat-label">Всего иероглифов</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value"><?php echo e($learnedScopeCount); ?></span>
                            <span class="stat-label">Выучено</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">
                                <?php echo e($totalScope > 0 ? round(($learnedScopeCount / $totalScope) * 100) : 0); ?>%
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

                <?php if($characters->count() > 0): ?>
                    <section class="learning-level-panel learning-level-panel--grid" aria-live="polite">
                        <div id="levelPaginatedRegion">
                            <?php echo $__env->make('user.learning.partials.level-characters', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </section>
                <?php else: ?>
                    <div class="learning-level-panel learning-level-panel--empty">
                        <div class="empty-state">
                            <?php if(isset($collection) && $collection): ?>
                                <h3>Коллекция пуста</h3>
                                <p><a href="<?php echo e(route('collections.show', $collection)); ?>">Добавьте иероглифы</a> в коллекцию.</p>
                            <?php else: ?>
                                <h3>В этом уровне пока нет иероглифов</h3>
                                <p>В базе данных еще нет иероглифов уровня HSK <?php echo e($level); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
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
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH /home/c/cy906984/kanjilflow_public/public_html/resources/views/user/learning/level.blade.php ENDPATH**/ ?>