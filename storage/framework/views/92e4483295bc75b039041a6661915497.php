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
    <div class="admin-layout">
        <div class="admin-container">
            <div class="admin-hero">
                <h1>Админ-панель</h1>
                <p>
                    В базе:
                    <strong><?php echo e(number_format($totalUsers, 0, ',', ' ')); ?></strong> пользователей,
                    <strong><?php echo e(number_format($totalCharacters, 0, ',', ' ')); ?></strong> иероглифов,
                    <strong><?php echo e(number_format($totalArticles, 0, ',', ' ')); ?></strong> статей,
                    <strong><?php echo e(number_format($builtinTemplatesCount, 0, ',', ' ')); ?></strong> шаблонов тематических подборок.
                </p>
            </div>

            <div class="admin-stats">
                <div class="stat-card">
                    <div class="stat-value"><?php echo e(number_format($totalUsers, 0, ',', ' ')); ?></div>
                    <div class="stat-label">Всего пользователей</div>
                    <div class="stat-change stat-change-muted">+<?php echo e(number_format($newUsersWeek, 0, ',', ' ')); ?> зарегистрировались за 7 дней</div>
                </div>

                <div class="stat-card">
                    <div class="stat-value"><?php echo e(number_format($activeTodayUsers, 0, ',', ' ')); ?></div>
                    <div class="stat-label">Активных сегодня</div>
                    <div class="stat-change stat-change-muted">Уникальных пользователей с отметкой повторения за сегодня</div>
                </div>

                <div class="stat-card">
                    <div class="stat-value"><?php echo e(number_format($learnedGlyphRecords, 0, ',', ' ')); ?></div>
                    <div class="stat-label">Выучено иероглифов</div>
                    <div class="stat-change stat-change-muted">Записей пользователь ↔ иероглиф со статусом «выучено»</div>
                </div>

                <div class="stat-card">
                    <div class="stat-value"><?php echo e(number_format($totalReviews, 0, ',', ' ')); ?></div>
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
                        <?php $__currentLoopData = $reviewsPerDay; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $pct = $maxReviewsDay > 0 ? round(($day['count'] / $maxReviewsDay) * 100) : 0;
                            ?>
                            <div class="admin-bar-chart__col">
                                <div class="admin-bar-chart__bar-wrap">
                                    <div class="admin-bar-chart__bar" style="height: <?php echo e(max($pct, $day['count'] > 0 ? 8 : 0)); ?>%;" title="<?php echo e($day['count']); ?> повторений"></div>
                                </div>
                                <span class="admin-bar-chart__label"><?php echo e($day['label']); ?></span>
                                <span class="admin-bar-chart__count"><?php echo e($day['count']); ?></span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <p class="chart-footnote">По числу записей с обновлённым полем «последнее повторение» в этот календарный день.</p>
                </div>

                <div class="chart-container">
                    <div class="chart-header">
                        <h3>Распределение по уровням HSK</h3>
                        <span class="chart-badge">карты в обучении</span>
                    </div>
                    <div class="admin-bar-chart admin-bar-chart--hsk">
                        <?php $__currentLoopData = range(1, 6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $cnt = $hskDistribution[$level] ?? 0;
                                $pct = $maxHskCount > 0 ? round(($cnt / $maxHskCount) * 100) : 0;
                            ?>
                            <div class="admin-bar-chart__col">
                                <div class="admin-bar-chart__bar-wrap">
                                    <div class="admin-bar-chart__bar admin-bar-chart__bar--hsk" style="height: <?php echo e(max($pct, $cnt > 0 ? 8 : 0)); ?>%;" title="HSK <?php echo e($level); ?>: <?php echo e($cnt); ?>"></div>
                                </div>
                                <span class="admin-bar-chart__label">HSK <?php echo e($level); ?></span>
                                <span class="admin-bar-chart__count"><?php echo e(number_format($cnt, 0, ',', ' ')); ?></span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <p class="chart-footnote">Количество связей пользователь ↔ иероглиф по уровню HSK иероглифа.</p>
                </div>
            </div>

            <div class="quick-actions">
                <h3>Управление контентом</h3>
                <div class="action-buttons">
                    <a href="<?php echo e(route('admin.builtin-collections.index')); ?>" class="action-btn">
                        <div class="action-text">
                            <div class="action-title">Тематические подборки</div>
                            <div class="action-desc">Шаблоны коллекций для пользователей</div>
                        </div>
                    </a>

                    <a href="<?php echo e(route('admin.characters.index')); ?>" class="action-btn">
                        <div class="action-text">
                            <div class="action-title">Иероглифы</div>
                            <div class="action-desc">Список, редактирование и удаление</div>
                        </div>
                    </a>

                    <a href="<?php echo e(route('admin.articles.index')); ?>" class="action-btn">
                        <div class="action-text">
                            <div class="action-title">Статьи</div>
                            <div class="action-desc">Материалы раздела статей</div>
                        </div>
                    </a>

                    <a href="<?php echo e(route('admin.characters.create')); ?>" class="action-btn">
                        <div class="action-text">
                            <div class="action-title">Добавить иероглиф</div>
                            <div class="action-desc">Новая карточка в базе</div>
                        </div>
                    </a>

                    <a href="<?php echo e(route('admin.articles.create')); ?>" class="action-btn">
                        <div class="action-text">
                            <div class="action-title">Добавить статью</div>
                            <div class="action-desc">Новый материал</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
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
<?php /**PATH /home/c/cy906984/kanjilflow_public/public_html/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>