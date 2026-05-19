<x-app-layout>
    <div class="characters-index admin-articles-page admin-list-page" data-admin-list-page="{{ parse_url(route('admin.articles.index'), PHP_URL_PATH) }}">
        <header class="admin-list-header">
            <h1>Статьи</h1>
            <p class="admin-page-subtitle">Управление материалами для пользователей. Всего: <span data-admin-list-header-total>{{ $articles->total() }}</span>.</p>
        </header>

        @include('admin.partials.page-toolbar', [
            'createUrl' => route('admin.articles.create'),
            'createLabel' => 'Добавить статью',
            'toolbarAppend' => view('admin.articles.partials.user-section-link')->render(),
        ])

        @include('admin.partials.list-filters', [
            'action' => route('admin.articles.index'),
            'fields' => [
                [
                    'type' => 'search',
                    'name' => 'q',
                    'value' => $q,
                    'label' => 'Поиск',
                    'placeholder' => 'Заголовок, подзаголовок или текст…',
                ],
                [
                    'type' => 'select',
                    'name' => 'sort',
                    'value' => $sort,
                    'label' => 'Сортировка',
                    'options' => [
                        'newest' => 'Сначала новые',
                        'oldest' => 'Сначала старые',
                        'title_asc' => 'Заголовок А→Я',
                        'title_desc' => 'Заголовок Я→А',
                    ],
                ],
            ],
        ])

        @if(session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        <div id="admin-list-async" class="admin-list-async">
            @include('admin.articles.partials.list-content')
        </div>
    </div>

    <script src="{{ asset('js/admin-list-async.js') }}" defer></script>
</x-app-layout>
