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
    <div class="characters-index admin-articles-page">
        <h1>Статьи</h1>
        <p class="admin-page-subtitle">Управление статьями для пользователей: редактирование, публикация и удаление.</p>

        <?php if(session('success')): ?>
            <div class="success-message"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <a href="<?php echo e(route('admin.articles.create')); ?>" class="add-new-link">Добавить статью</a>

        <table>
            <thead>
                <tr>
                    <th>Заголовок</th>
                    <th>Подзаголовок</th>
                    <th>Фото</th>
                    <th>Создано</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($article->title); ?></td>
                        <td><?php echo e($article->subtitle ?: '—'); ?></td>
                        <td><?php echo e($article->images->count()); ?></td>
                        <td><?php echo e($article->created_at->format('d.m.Y H:i')); ?></td>
                        <td class="characters-index__actions">
                            <a href="<?php echo e(route('admin.articles.edit', $article)); ?>" class="table-actions">Редактировать</a>
                            <form action="<?php echo e(route('admin.articles.destroy', $article)); ?>" method="POST" class="table-actions" onsubmit="return confirm('Удалить статью?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit">Удалить</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5">Статей пока нет.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="pagination admin-pagination">
            <?php echo e($articles->links('vendor.pagination.my-pagination')); ?>

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
<?php /**PATH /home/c/cy906984/kanjilflow_public/public_html/resources/views/admin/articles/index.blade.php ENDPATH**/ ?>