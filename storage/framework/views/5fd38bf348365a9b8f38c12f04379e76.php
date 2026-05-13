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
    <div class="articles-page" id="articles-index-page">
        <div class="articles-shell">
            <div class="articles-header">
                <div class="articles-header-text">
                    <h1 class="articles-title">Статьи о Китае и китайском языке</h1>
                    <p class="articles-lead">Читайте материалы о культуре, языке и традициях и сохраняйте интересные статьи в избранное.</p>
                </div>
                <a href="<?php echo e(route('articles.favorites')); ?>" class="btn btn-outline">Мои избранные</a>
            </div>

            <form method="GET" action="<?php echo e(route('articles.index')); ?>" class="articles-search">
                <input type="text" name="q" value="<?php echo e($query); ?>" placeholder="Поиск по названию или подзаголовку">
                <button type="submit" class="btn btn-primary">Найти</button>
            </form>

            <div id="articles-index-async">
                <?php echo $__env->make('user.articles.partials.index-async', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div>

    <script>
        (function () {
            var root = document.getElementById('articles-index-async');
            var pageRoot = document.getElementById('articles-index-page');
            if (!root || !pageRoot) return;

            pageRoot.addEventListener('click', function (e) {
                var a = e.target.closest('#articles-index-async a.pagination-btn');
                if (!a || a.classList.contains('disabled') || a.classList.contains('active')) return;
                var url = a.getAttribute('href');
                if (!url || url === '#') return;
                e.preventDefault();

                root.style.opacity = '0.55';
                root.style.pointerEvents = 'none';

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html'
                    },
                    credentials: 'same-origin'
                })
                    .then(function (r) {
                        if (!r.ok) throw new Error('Network error');
                        return r.text();
                    })
                    .then(function (html) {
                        root.innerHTML = html;
                        if (window.history && window.history.pushState) {
                            window.history.pushState({}, '', url);
                        }
                        root.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    })
                    .catch(function () {
                        window.location.href = url;
                    })
                    .finally(function () {
                        root.style.opacity = '';
                        root.style.pointerEvents = '';
                    });
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
<?php /**PATH /home/c/cy906984/kanjilflow_public/public_html/resources/views/user/articles/index.blade.php ENDPATH**/ ?>