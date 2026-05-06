<x-app-layout>
    <div class="characters-index admin-articles-page admin-builtin-templates-page">
        <h1>Тематические подборки (шаблоны)</h1>
        <p class="admin-page-subtitle">
            Эти шаблоны копируются каждому пользователю как встроенные коллекции на странице выбора уровня.
            После изменений нажмите «Обновить у всех пользователей» или выполните
            <code>php artisan collections:sync-builtin</code>.
        </p>

        @if(session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        <div class="admin-builtin-templates-toolbar">
            <a href="{{ route('admin.builtin-collections.create') }}" class="add-new-link">Добавить шаблон</a>
            <form action="{{ route('admin.builtin-collections.sync-all') }}" method="POST" class="admin-inline-form"
                  onsubmit="return confirm('Синхронизировать встроенные подборки у всех пользователей?');">
                @csrf
                <button type="submit" class="btn-sync-all">Обновить у всех пользователей</button>
            </form>
            <a href="{{ route('admin.dashboard') }}" class="admin-back-dashboard">← Админ-панель</a>
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
                @forelse($templates as $tpl)
                    <tr>
                        <td>{{ $tpl->sort_order }}</td>
                        <td><code>{{ $tpl->slug }}</code></td>
                        <td>{{ $tpl->name }}</td>
                        <td>{{ $tpl->characters_count }}</td>
                        <td class="characters-index__actions">
                            <a href="{{ route('admin.builtin-collections.edit', $tpl) }}" class="table-actions">Изменить</a>
                            <form action="{{ route('admin.builtin-collections.destroy', $tpl) }}" method="POST" class="table-actions"
                                  onsubmit="return confirm('Удалить шаблон и все пользовательские копии этой подборки?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Шаблонов нет. Запустите миграции или добавьте первый шаблон.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
