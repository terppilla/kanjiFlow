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

                <p class="article-card-excerpt"><?php echo e(\Illuminate\Support\Str::limit(trim(preg_replace('/\s+/u', ' ', strip_tags($article->content))), 400)); ?></p>

                <div class="article-card-actions">
                    <a href="<?php echo e(route('articles.show', $article)); ?>" class="btn btn-ghost">Читать далее</a>
                    <form method="POST" action="<?php echo e(route('articles.favorite.toggle', $article)); ?>">
                        <?php echo csrf_field(); ?>
                        <button
                            type="submit"
                            class="favorite-icon-btn <?php echo e(in_array($article->id, $favoriteIds, true) ? 'is-active' : ''); ?>"
                            aria-label="<?php echo e(in_array($article->id, $favoriteIds, true) ? 'Убрать из избранного' : 'Добавить в избранное'); ?>"
                            title="<?php echo e(in_array($article->id, $favoriteIds, true) ? 'Убрать из избранного' : 'Добавить в избранное'); ?>"
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
            Пока нет статей или ничего не найдено по запросу.
        </div>
    <?php endif; ?>
</div>

<div class="pagination articles-index-pagination">
    <?php echo e($articles->links('vendor.pagination.my-pagination')); ?>

</div>
<?php /**PATH /home/c/cy906984/kanjilflow_public/public_html/resources/views/user/articles/partials/index-async.blade.php ENDPATH**/ ?>