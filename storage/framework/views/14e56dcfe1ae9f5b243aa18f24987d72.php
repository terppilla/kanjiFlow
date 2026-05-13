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
    <div class="articles-page">
        <div class="articles-shell">
            <div class="articles-header">
                <div class="articles-header-text">
                    <h1 class="articles-title">Избранные статьи</h1>
                    <p class="articles-lead">Список статей, которые вы сохранили для быстрого доступа.</p>
                </div>
                <a href="<?php echo e(route('articles.index')); ?>" class="btn btn-outline">Все статьи</a>
            </div>

            <div class="articles-grid">
                <?php $__empty_1 = true; $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <article class="article-card">
                        <?php if($article->images->first()): ?>
                            <a href="<?php echo e(route('articles.show', $article)); ?>">
                                <div class="article-card-image-wrap">
                                    <img src="<?php echo e(Storage::url($article->images->first()->image_path)); ?>" alt="<?php echo e($article->title); ?>" class="article-card-image">
                                </div>
                            </a>
                        <?php endif; ?>

                        <div class="article-card-body">
                            <h2 class="article-card-title">
                                <a href="<?php echo e(route('articles.show', $article)); ?>"><?php echo e($article->title); ?></a>
                            </h2>

                            <?php if($article->subtitle): ?>
                                <p class="article-card-subtitle"><?php echo e($article->subtitle); ?></p>
                            <?php endif; ?>

                            <div class="article-card-actions">
                                <a href="<?php echo e(route('articles.show', $article)); ?>" class="btn btn-ghost">Читать</a>
                                <form method="POST" action="<?php echo e(route('articles.favorite.toggle', $article)); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button
                                        type="submit"
                                        class="favorite-icon-btn is-active"
                                        aria-label="Убрать из избранного"
                                        title="Убрать из избранного"
                                    >
                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M12.001 21s-7.2-4.438-9.428-8.125C.75 9.862 1.316 6.054 4.4 4.644 6.495 3.68 8.877 4.16 10.4 5.82L12 7.56l1.6-1.74c1.523-1.66 3.905-2.14 6-1.176 3.084 1.41 3.65 5.218 1.827 8.231C19.201 16.562 12.001 21 12.001 21z"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="articles-empty-state">
                        Вы ещё не добавили статьи в избранное.
                    </div>
                <?php endif; ?>
            </div>

            <div class="pagination">
                <?php echo e($articles->links('vendor.pagination.my-pagination')); ?>

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
<?php /**PATH /home/c/cy906984/kanjilflow_public/public_html/resources/views/user/articles/favorites.blade.php ENDPATH**/ ?>