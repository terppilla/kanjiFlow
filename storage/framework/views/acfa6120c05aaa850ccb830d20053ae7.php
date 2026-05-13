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
    <div class="characters-index">
        <h1>Все иероглифы</h1>
        <a href="<?php echo e(route('admin.characters.create')); ?>" class="add-new-link">Добавить новый иероглиф</a>

        <?php if(session('success')): ?>
            <div class="characters-json-import-success" role="status"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="characters-json-import-errors" role="alert">
                <strong>Файл не принят:</strong>
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($err); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if(session('import_errors')): ?>
            <div class="characters-json-import-errors" role="alert">
                <strong>Проверьте формат JSON</strong> (как в <code>database/data/characters.json</code>):
                <ul>
                    <?php $__currentLoopData = session('import_errors'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($err); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <section class="characters-json-import-panel" aria-labelledby="characters-json-import-title">
            <h2 id="characters-json-import-title" class="characters-json-import-title">Импорт из JSON</h2>
            <p class="characters-json-import-hint">
                Массив объектов с полями: <code>character</code>, <code>pinyin</code>, <code>meaning</code>,
                <code>hsk_level</code> (1–6), <code>example_hanzi</code>, <code>example_pinyin</code>,
                <code>example_translation</code>, <code>audio</code> (обычно <code>null</code> или путь).
                Дубликаты по строке <code>character</code> в одном файле запрещены. Совпадающие по тексту записи в базе будут обновлены.
            </p>
            <form action="<?php echo e(route('admin.characters.import-json')); ?>" method="POST" enctype="multipart/form-data" class="characters-json-import-form">
                <?php echo csrf_field(); ?>
                <label class="characters-json-import-label">
                    Файл (.json или .txt)
                    <input type="file" name="json_file" accept=".json,.txt,application/json" required class="characters-json-import-file">
                </label>
                <button type="submit" class="characters-json-import-submit">Загрузить и импортировать</button>
            </form>
        </section>

        <div class="characters-index-table-wrap">
            <table class="characters-index-table">
                <thead>
                    <tr>
                        <th>Иероглиф</th>
                        <th>Пиньинь</th>
                        <th>Значение</th>
                        <th>Уровень HSK</th>
                        <th>Аудио иероглифа</th>
                        <th>Пример на китайском</th>
                        <th>Пиньинь примера</th>
                        <th>Перевод примера</th>
                        <th>Аудио примера</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $characters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $character): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($character->character); ?></td>
                            <td><?php echo e($character->pinyin); ?></td>
                            <td><?php echo e($character->meaning); ?></td>
                            <td><?php echo e($character->hsk_level); ?></td>
                            <td><?php echo e($character->audio_character); ?></td>
                            <td><?php echo e($character->example_hanzi); ?></td>
                            <td><?php echo e($character->example_pinyin); ?></td>
                            <td><?php echo e($character->example_translation); ?></td>
                            <td><?php echo e($character->audio_example); ?></td>
                            <td class="characters-index__actions">
                                <a href="<?php echo e(route('admin.characters.edit', $character->id)); ?>" class="table-actions">Редактировать</a>
                                <form action="<?php echo e(route('admin.characters.destroy', $character->id)); ?>" method="POST" class="table-actions">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
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
<?php /**PATH /home/c/cy906984/kanjilflow_public/public_html/resources/views/admin/characters/index.blade.php ENDPATH**/ ?>