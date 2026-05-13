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
        <div class="collections-shell page-collections-show">
            <header class="collections-show-head">
                <div class="collections-show-intro">
                    <h1 class="collections-title"><?php echo e($collection->name); ?></h1>
                    <p class="collections-show-meta">Иероглифов в коллекции: <strong><?php echo e($collection->characters->count()); ?></strong></p>
                </div>
                <div class="collections-toolbar">
                    <a href="<?php echo e(route('learning.collection.level', $collection)); ?>" class="btn btn-primary">Учить коллекцию</a>
                    <a href="<?php echo e(route('collections.edit', $collection)); ?>" class="btn btn-outline">Переименовать</a>
                    <a href="<?php echo e(route('collections.index')); ?>" class="btn btn-ghost">Все коллекции</a>
                </div>
            </header>

            <?php if(session('success')): ?>
                <div class="alert alert-success"><?php echo e(session('success')); ?></div>
            <?php endif; ?>
            <?php if(session('info')): ?>
                <div class="alert alert-info"><?php echo e(session('info')); ?></div>
            <?php endif; ?>

            <section class="collections-panel collections-panel--accent">
                <h2 class="collections-panel-title">Добавить иероглиф</h2>
                <p class="collections-subtle">Поиск по значению, пиньиню или символу</p>
                <div class="search-row">
                    <input type="search" id="charSearch" autocomplete="off" placeholder="Начните вводить…" data-url="<?php echo e(route('collections.characters.search', $collection)); ?>">
                </div>
                <div class="suggest" id="searchSuggest"></div>
            </section>

            <section class="collections-panel">
                <h2 class="collections-panel-title">Состав коллекции</h2>
                <?php if($collection->characters->isEmpty()): ?>
                    <div class="collections-empty-inline">Пока пусто — добавьте иероглифы поиском выше.</div>
                <?php else: ?>
                    <div class="collections-characters-grid">
                        <?php $__currentLoopData = $collection->characters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $character): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $isLearned = in_array($character->id, $learnedCharacterIds ?? [], true); ?>
                            <div class="collections-char-cell">
                                <a href="<?php echo e(route('learning.collection.show', [$collection, $character])); ?>"
                                   class="collections-learn-card <?php echo e($isLearned ? 'collections-learn-card--learned' : ''); ?>">
                                    <div class="collections-learn-card-glyph"><?php echo e($character->character); ?></div>
                                    <div class="collections-learn-card-pinyin"><?php echo e($character->pinyin); ?></div>
                                    <div class="collections-learn-card-meaning"><?php echo e(\Illuminate\Support\Str::limit($character->meaning, 40)); ?></div>
                                    <span class="collections-learn-card-badge <?php echo e($isLearned ? 'is-learned' : 'is-new'); ?>"><?php echo e($isLearned ? 'Выучен' : 'Новый'); ?></span>
                                </a>
                                <form action="<?php echo e(route('collections.remove-character', [$collection, $character])); ?>" method="post" class="collections-char-remove"
                                    onsubmit="return confirm('Убрать этот иероглиф из коллекции?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-icon-remove" title="Убрать из коллекции">✕</button>
                                </form>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </section>

            <?php if(! $collection->is_builtin): ?>
                <section class="collections-danger-zone" aria-labelledby="danger-zone-title">
                    <h2 id="danger-zone-title" class="collections-danger-title">Опасная зона</h2>
                    <p class="collections-danger-text">Удаление коллекции не удаляет иероглифы из базы, только убирает этот набор.</p>
                    <form action="<?php echo e(route('collections.destroy', $collection)); ?>" method="post"
                        onsubmit="return confirm('Удалить коллекцию «<?php echo e(addslashes($collection->name)); ?>»?');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger-solid">Удалить коллекцию</button>
                    </form>
                </section>
            <?php endif; ?>
        </div>
    </div>

    <script>
        (function() {
            const input = document.getElementById('charSearch');
            const box = document.getElementById('searchSuggest');
            const url = input.dataset.url;
            let t;

            input.addEventListener('input', function() {
                clearTimeout(t);
                const q = input.value.trim();
                if (q.length < 1) {
                    box.style.display = 'none';
                    box.innerHTML = '';
                    return;
                }
                t = setTimeout(async function() {
                    try {
                        const r = await fetch(url + '?q=' + encodeURIComponent(q), {
                            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                        });
                        const data = await r.json();
                        box.innerHTML = '';
                        if (!data.characters || !data.characters.length) {
                            box.style.display = 'block';
                            box.innerHTML = '<div class="collections-empty-search">Ничего не найдено</div>';
                            return;
                        }
                        data.characters.forEach(function(ch) {
                            const b = document.createElement('button');
                            b.type = 'button';
                            b.innerHTML = '<span class="glyph">' + escapeHtml(ch.character) + '</span> ' + escapeHtml(ch.meaning || '') + ' <small class="collections-hsk-badge">HSK' + ch.hsk_level + '</small>';
                            b.addEventListener('click', function() {
                                const form = document.createElement('form');
                                form.method = 'POST';
                                form.action = <?php echo json_encode(route('collections.add-character', $collection), 512) ?>;
                                const token = document.querySelector('meta[name="csrf-token"]');
                                form.innerHTML = '<input type="hidden" name="_token" value="' + (token ? token.content : '') + '">' +
                                    '<input type="hidden" name="character_id" value="' + ch.id + '">';
                                document.body.appendChild(form);
                                form.submit();
                            });
                            box.appendChild(b);
                        });
                        box.style.display = 'block';
                    } catch (e) {
                        console.error(e);
                    }
                }, 220);
            });

            function escapeHtml(s) {
                const d = document.createElement('div');
                d.textContent = s;
                return d.innerHTML;
            }

            document.addEventListener('click', function(e) {
                if (!input.contains(e.target) && !box.contains(e.target)) {
                    box.style.display = 'none';
                }
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
<?php /**PATH /home/c/cy906984/kanjilflow_public/public_html/resources/views/user/collections/show.blade.php ENDPATH**/ ?>