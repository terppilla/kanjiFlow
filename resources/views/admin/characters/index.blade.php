<x-app-layout>
    <div class="characters-index admin-list-page" data-admin-list-page="{{ parse_url(route('admin.characters.index'), PHP_URL_PATH) }}">
        <header class="admin-list-header">
            <h1>Все иероглифы</h1>
            <p class="admin-page-subtitle">Поиск, фильтр по HSK и сортировка. Всего в базе: <span data-admin-list-header-total>{{ $characters->total() }}</span>.</p>
        </header>

        @include('admin.partials.page-toolbar', [
            'createUrl' => route('admin.characters.create'),
            'createLabel' => 'Добавить иероглиф',
        ])

        @include('admin.characters.partials.import-audio-tools')

        @include('admin.partials.list-filters', [
            'action' => route('admin.characters.index'),
            'fields' => [
                [
                    'type' => 'search',
                    'name' => 'q',
                    'value' => $q,
                    'label' => 'Поиск',
                    'placeholder' => 'Иероглиф, пиньинь или значение…',
                ],
                [
                    'type' => 'select',
                    'name' => 'hsk',
                    'value' => $hsk,
                    'label' => 'Уровень HSK',
                    'options' => [
                        '' => 'Все уровни',
                        '1' => 'HSK 1',
                        '2' => 'HSK 2',
                        '3' => 'HSK 3',
                        '4' => 'HSK 4',
                        '5' => 'HSK 5',
                        '6' => 'HSK 6',
                    ],
                ],
                [
                    'type' => 'select',
                    'name' => 'sort',
                    'value' => $sort,
                    'label' => 'Сортировка',
                    'options' => [
                        'hsk_asc' => 'HSK ↑, иероглиф',
                        'hsk_desc' => 'HSK ↓, иероглиф',
                        'char_asc' => 'Иероглиф А→Я',
                        'char_desc' => 'Иероглиф Я→А',
                        'newest' => 'Сначала новые',
                        'oldest' => 'Сначала старые',
                    ],
                ],
            ],
        ])

        @if(session('success'))
            <div class="characters-json-import-success" role="status">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="characters-json-import-errors" role="alert">
                <strong>Файл не принят:</strong>
                <ul>
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('import_errors'))
            <div class="characters-json-import-errors" role="alert">
                <strong>Проверьте формат JSON</strong> (как в <code>database/data/characters.json</code>):
                <ul>
                    @foreach (session('import_errors') as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div id="admin-list-async" class="admin-list-async">
            @include('admin.characters.partials.list-content')
        </div>
    </div>

    <script src="{{ asset('js/admin-list-async.js') }}" defer></script>
    <script src="{{ asset('js/admin-characters-bulk-audio.js') }}" defer></script>
</x-app-layout>
