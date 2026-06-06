<x-app-layout>
    <div class="characters-index admin-suggestions-page admin-list-page" data-admin-list-page="{{ parse_url(route('admin.character-suggestions.index'), PHP_URL_PATH) }}">
        <header class="admin-list-header">
            <h1>Предложения иероглифов</h1>
            <p class="admin-page-subtitle">
                Пользователи отправляют слова, которых нет в базе. Добавьте иероглиф через форму — предложение отметится обработанным.
                @if($pendingCount > 0)
                    <strong> Ожидают: {{ $pendingCount }}</strong>
                @endif
                Всего: <span data-admin-list-header-total>{{ $suggestions->total() }}</span>.
            </p>
        </header>

        @include('admin.partials.page-toolbar', [
            'createUrl' => route('admin.characters.create'),
            'createLabel' => 'Добавить иероглиф',
        ])

        @if(session('success'))
            <div class="characters-json-import-success" role="status">{{ session('success') }}</div>
        @endif
        @if(session('info'))
            <div class="characters-json-import-success" role="status">{{ session('info') }}</div>
        @endif

        <div id="admin-list-async" class="admin-list-async">
            @include('admin.character_suggestions.partials.list-content')
        </div>
    </div>

    <script src="{{ asset('js/admin-list-async.js') }}" defer></script>
</x-app-layout>
