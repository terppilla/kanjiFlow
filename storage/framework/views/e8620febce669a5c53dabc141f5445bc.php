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
    <div class="characters-index admin-articles-page admin-builtin-templates-page">
        <h1>Тематические подборки (шаблоны)</h1>
        <p class="admin-page-subtitle">
            Эти шаблоны копируются каждому пользователю как встроенные коллекции на странице выбора уровня.
            После изменений нажмите «Обновить у всех пользователей» или выполните
            <code>php artisan collections:sync-builtin</code>.
        </p>

        <?php if(session('success')): ?>
            <div class="success-message"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <div class="admin-builtin-templates-toolbar">
            <a href="<?php echo e(route('admin.builtin-collections.create')); ?>" class="add-new-link">Добавить шаблон</a>
            <form action="<?php echo e(route('admin.builtin-collections.sync-all')); ?>" method="POST" class="admin-inline-form"
                  onsubmit="return confirm('Синхронизировать встроенные подборки у всех пользователей?');">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn-sync-all">Обновить у всех пользователей</button>
            </form>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="admin-back-dashboard">← Админ-панель</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Порядок</th>
                    <th>Код (slug)</th>
                    <th>Название</th>
                    <th>Иероглифов</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tpl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($tpl->sort_order); ?></td>
                        <td><code><?php echo e($tpl->slug); ?></code></td>
                        <td><?php echo e($tpl->name); ?></td>
                        <td><?php echo e($tpl->characters_count); ?></td>
                        <td class="characters-index__actions">
                            <a href="<?php echo e(route('admin.builtin-collections.edit', $tpl)); ?>" class="table-actions">Изменить</a>
                            <form action="<?php echo e(route('admin.builtin-collections.destroy', $tpl)); ?>" method="POST" class="table-actions"
                                  onsubmit="return confirm('Удалить шаблон и все пользовательские копии этой подборки?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit">Удалить</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5">Шаблонов нет. Запустите миграции или добавьте первый шаблон.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
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
<?php /**PATH /home/c/cy906984/kanjilflow_public/public_html/resources/views/admin/builtin_collections/index.blade.php ENDPATH**/ ?>