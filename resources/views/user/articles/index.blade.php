<x-app-layout>
    <div class="articles-page" id="articles-index-page">
        <div class="articles-shell">
            <div class="articles-header">
                <div class="articles-header-text">
                    <h1 class="articles-title">Статьи о Китае и китайском языке</h1>
                    <p class="articles-lead">Читайте материалы о культуре, языке и традициях и сохраняйте интересные статьи в избранное.</p>
                </div>
                <a href="{{ route('articles.favorites') }}" class="btn btn-outline">Мои избранные</a>
            </div>

            <form method="GET" action="{{ route('articles.index') }}" class="articles-search">
                <input type="text" name="q" value="{{ $query }}" placeholder="Поиск по названию или подзаголовку">
                <button type="submit" class="btn btn-primary">Найти</button>
            </form>

            <div id="articles-index-async">
                @include('user.articles.partials.index-async')
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
</x-app-layout>
