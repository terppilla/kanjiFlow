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
    <div class="article-show-page">
        <div class="article-show-shell">
            <div class="article-show-nav">
                <a href="<?php echo e(route('articles.index')); ?>" class="btn btn-outline">← Все статьи</a>
                <a href="<?php echo e(route('articles.favorites')); ?>" class="btn btn-ghost">Избранные</a>
            </div>

            <article class="article-show-card">
                <header class="article-show-header">
                    <h1><?php echo e($article->title); ?></h1>
                    <?php if($article->subtitle): ?>
                        <p><?php echo e($article->subtitle); ?></p>
                    <?php endif; ?>
                    <div class="article-show-meta">
                        <span>Автор: <?php echo e($article->author->name ?? 'Администратор'); ?></span>
                        <span>Дата: <?php echo e($article->created_at->format('d.m.Y')); ?></span>
                    </div>
                    <form method="POST" action="<?php echo e(route('articles.favorite.toggle', $article)); ?>">
                        <?php echo csrf_field(); ?>
                        <button
                            type="submit"
                            class="favorite-icon-btn <?php echo e($isFavorite ? 'is-active' : ''); ?>"
                            aria-label="<?php echo e($isFavorite ? 'Убрать из избранного' : 'Добавить в избранное'); ?>"
                            title="<?php echo e($isFavorite ? 'Убрать из избранного' : 'Добавить в избранное'); ?>"
                        >
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12.001 21s-7.2-4.438-9.428-8.125C.75 9.862 1.316 6.054 4.4 4.644 6.495 3.68 8.877 4.16 10.4 5.82L12 7.56l1.6-1.74c1.523-1.66 3.905-2.14 6-1.176 3.084 1.41 3.65 5.218 1.827 8.231C19.201 16.562 12.001 21 12.001 21z"/>
                            </svg>
                        </button>
                    </form>
                </header>

                <?php if($article->images->isNotEmpty()): ?>
                    <section class="article-gallery">
                        <?php $__currentLoopData = $article->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <figure>
                                <div class="article-gallery-media">
                                    <img src="<?php echo e(Storage::url($image->image_path)); ?>" alt="<?php echo e($article->title); ?>">
                                </div>
                                <?php if($image->caption): ?>
                                    <figcaption><?php echo e($image->caption); ?></figcaption>
                                <?php endif; ?>
                            </figure>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </section>
                <?php endif; ?>

                <section class="article-content prose">
                    <?php echo $article->content; ?>

                </section>
            </article>
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
<?php /**PATH /home/c/cy906984/kanjilflow_public/public_html/resources/views/user/articles/show.blade.php ENDPATH**/ ?>