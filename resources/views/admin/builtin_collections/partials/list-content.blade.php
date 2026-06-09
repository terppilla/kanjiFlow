<p class="admin-list-results-meta">
    @if($templates->total() > 0)
        Показано {{ $templates->firstItem() }}–{{ $templates->lastItem() }} из <span data-admin-list-total>{{ $templates->total() }}</span>
    @else
        Ничего не найдено
    @endif
</p>

<div class="characters-index-table-wrap">
    <table class="characters-index-table">
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
                    <td><code class="admin-slug-code">{{ $tpl->slug }}</code></td>
                    <td>{{ $tpl->name }}</td>
                    <td>{{ $tpl->characters_count }}</td>
                    <td class="characters-index__actions">
                        <a href="{{ route('admin.builtin-collections.edit', $tpl) }}" class="table-actions">Изменить</a>
                        <form action="{{ route('admin.builtin-collections.destroy', $tpl) }}" method="POST" class="table-actions"
                            onsubmit="return confirm('Удалить базовую коллекцию и все пользовательские копии?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="table-actions-link">Удалить</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="admin-list-empty">Базовых коллекций по запросу не найдено.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@include('admin.partials.pagination', ['paginator' => $templates])
