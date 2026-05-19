<x-app-layout>
    <div class="characters-index admin-articles-page admin-builtin-templates-page admin-list-page" data-admin-list-page="{{ parse_url(route('admin.builtin-collections.index'), PHP_URL_PATH) }}">
        <header class="admin-list-header">
            <h1>Тематические подборки (шаблоны)</h1>
            <p class="admin-page-subtitle">
                Шаблоны копируются пользователям как встроенные коллекции. После изменений — «Обновить у всех» или
                <code>php artisan collections:sync-builtin</code>. Всего: <span data-admin-list-header-total>{{ $templates->total() }}</span>.
            </p>
        </header>

        @if(session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        @include('admin.partials.page-toolbar', [
            'createUrl' => route('admin.builtin-collections.create'),
            'createLabel' => 'Добавить шаблон',
            'toolbarAppend' => view('admin.builtin_collections.partials.sync-form')->render(),
        ])

        @include('admin.partials.list-filters', [
            'action' => route('admin.builtin-collections.index'),
            'fields' => [
                [
                    'type' => 'search',
                    'name' => 'q',
                    'value' => $q,
                    'label' => 'Поиск',
                    'placeholder' => 'Название или код (slug)…',
                ],
                [
                    'type' => 'select',
                    'name' => 'sort',
                    'value' => $sort,
                    'label' => 'Сортировка',
                    'options' => [
                        'sort_order' => 'Порядок в списке',
                        'name_asc' => 'Название А→Я',
                        'name_desc' => 'Название Я→А',
                        'glyphs_desc' => 'Больше иероглифов',
                        'glyphs_asc' => 'Меньше иероглифов',
                        'newest' => 'Сначала новые',
                        'oldest' => 'Сначала старые',
                    ],
                ],
            ],
        ])

        <div id="admin-list-async" class="admin-list-async">
            @include('admin.builtin_collections.partials.list-content')
        </div>
    </div>

    <script src="{{ asset('js/admin-list-async.js') }}" defer></script>
</x-app-layout>
