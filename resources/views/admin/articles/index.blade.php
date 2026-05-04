<x-app-layout>
    <div class="characters-index admin-articles-page">
        <h1>Статьи</h1>
        <p class="admin-page-subtitle">Управление статьями для пользователей: редактирование, публикация и удаление.</p>

        @if(session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        <a href="{{ route('admin.articles.create') }}" class="add-new-link">Добавить статью</a>

        <table>
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
                        <td>{{ $article->images->count() }}</td>
                        <td>{{ $article->created_at->format('d.m.Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.articles.edit', $article) }}" class="table-actions">Редактировать</a>
                            <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="table-actions" onsubmit="return confirm('Удалить статью?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Статей пока нет.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination admin-pagination">
            {{ $articles->links('vendor.pagination.my-pagination') }}
        </div>
    </div>
</x-app-layout>
