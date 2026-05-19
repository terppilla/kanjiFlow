<p class="admin-list-results-meta">
    @if($articles->total() > 0)
        Показано {{ $articles->firstItem() }}–{{ $articles->lastItem() }} из <span data-admin-list-total>{{ $articles->total() }}</span>
    @else
        Ничего не найдено
    @endif
</p>

<div class="characters-index-table-wrap">
    <table class="characters-index-table">
        <thead>
            <tr>
                <th>Заголовок</th>
                <th>Подзаголовок</th>
                <th>Фото</th>
                <th>Создано</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @forelse($articles as $article)
                <tr>
                    <td>{{ $article->title }}</td>
                    <td>{{ $article->subtitle ?: '—' }}</td>
                    <td>{{ $article->images_count }}</td>
                    <td>{{ $article->created_at->format('d.m.Y H:i') }}</td>
                    <td class="characters-index__actions">
                        <a href="{{ route('articles.show', $article) }}" class="table-actions table-actions-view" target="_blank" rel="noopener noreferrer" title="Открыть так, как видит пользователь">Просмотр</a>
                        <a href="{{ route('admin.articles.edit', $article) }}" class="table-actions">Изменить</a>
                        <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="table-actions"
                            onsubmit="return confirm('Удалить статью?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="table-actions-link">Удалить</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="admin-list-empty">Статей по запросу не найдено.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="pagination admin-pagination">
    {{ $articles->links('vendor.pagination.my-pagination') }}
</div>
