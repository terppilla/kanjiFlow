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
    <div class="collections-page">
        <div class="collections-shell page-collections-index">
            <header class="collections-header">
                <div class="collections-header-text">
                    <h1 class="collections-title">Мои коллекции</h1>
                    <p class="collections-lead">Собирайте иероглифы в наборы и учите их отдельно от уровней HSK.</p>
                </div>
                <a href="<?php echo e(route('collections.create')); ?>" class="btn btn-primary collections-header-cta">
                    <span aria-hidden="true">+</span> Новая коллекция
                </a>
            </header>

            <?php if(session('success')): ?>
                <div class="alert alert-success"><?php echo e(session('success')); ?></div>
            <?php endif; ?>
            <?php if(session('info')): ?>
                <div class="alert alert-info"><?php echo e(session('info')); ?></div>
            <?php endif; ?>
            <?php if($errors->any()): ?>
                <div class="alert alert-info" role="alert"><?php echo e($errors->first()); ?></div>
            <?php endif; ?>

            <?php if($collections->isEmpty()): ?>
                <div class="collections-empty-state">
                    <p>Пока нет коллекций. Создайте первую и добавьте в неё иероглифы.</p>
                    <a href="<?php echo e(route('collections.create')); ?>" class="btn btn-primary">Создать коллекцию</a>
                </div>
            <?php else: ?>
                <ul class="coll-list" role="list">
                    <?php $__currentLoopData = $collections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $collection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="coll-card">
                            <div class="coll-card-main">
                                <h2 class="coll-card-title"><?php echo e($collection->name); ?></h2>
                                <div class="coll-meta">Иероглифов: <span class="coll-meta-count"><?php echo e($collection->characters_count); ?></span></div>
                            </div>
                            <div class="coll-actions">
                                <a href="<?php echo e(route('learning.collection.level', $collection)); ?>" class="btn btn-primary btn-sm">Учить</a>
                                <a href="<?php echo e(route('collections.show', $collection)); ?>" class="btn btn-outline btn-sm">Открыть</a>
                                <a href="<?php echo e(route('collections.edit', $collection)); ?>" class="btn btn-ghost btn-sm">Переименовать</a>
                                <?php if(! $collection->is_builtin): ?>
                                    <form action="<?php echo e(route('collections.destroy', $collection)); ?>" method="post" class="coll-delete-form"
                                        onsubmit="return confirm('Удалить коллекцию «<?php echo e(addslashes($collection->name)); ?>»? Связи с иероглифами будут сняты.');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger-outline btn-sm">Удалить</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php endif; ?>

            <p class="collections-footer-nav">
                <a href="<?php echo e(route('learning.select-level')); ?>" class="btn btn-ghost">← К выбору HSK</a>
            </p>
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
<?php /**PATH /home/c/cy906984/kanjilflow_public/public_html/resources/views/user/collections/index.blade.php ENDPATH**/ ?>