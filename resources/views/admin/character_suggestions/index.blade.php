<x-app-layout>
    <div class="characters-index admin-suggestions-page">
        <h1>Предложения иероглифов</h1>
        <p class="admin-form-subtitle">
            Пользователи отправляют слова, которых нет в базе. Добавьте иероглиф через форму — предложение отметится обработанным.
            @if($pendingCount > 0)
                <strong> Ожидают: {{ $pendingCount }}</strong>
            @endif
        </p>

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

        @if($suggestions->isEmpty())
            <p class="admin-suggestions-empty">Пока нет предложений от пользователей.</p>
        @else
            <div class="characters-index-table-wrap">
                <table class="characters-index-table admin-suggestions-table">
                    <thead>
                        <tr>
                            <th>Дата</th>
                            <th>Пользователь</th>
                            <th>Коллекция</th>
                            <th>Поиск</th>
                            <th>Слова</th>
                            <th>Комментарий</th>
                            <th>Статус</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($suggestions as $suggestion)
                            <tr class="{{ $suggestion->isPending() ? 'admin-suggestion-row--pending' : '' }}">
                                <td>{{ $suggestion->created_at->format('d.m.Y H:i') }}</td>
                                <td>
                                    {{ $suggestion->user?->name ?? '—' }}
                                    @if($suggestion->user?->email)
                                        <br><small>{{ $suggestion->user->email }}</small>
                                    @endif
                                </td>
                                <td>{{ $suggestion->collection?->name ?? '—' }}</td>
                                <td>{{ $suggestion->search_query ?: '—' }}</td>
                                <td>
                                    <ul class="admin-suggestion-words">
                                        @foreach($suggestion->words ?? [] as $word)
                                            <li>{{ $word }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>{{ $suggestion->note ? \Illuminate\Support\Str::limit($suggestion->note, 80) : '—' }}</td>
                                <td>
                                    @if($suggestion->status === \App\Models\CharacterSuggestion::STATUS_PENDING)
                                        <span class="admin-suggestion-status admin-suggestion-status--pending">Ожидает</span>
                                    @elseif($suggestion->status === \App\Models\CharacterSuggestion::STATUS_PROCESSED)
                                        <span class="admin-suggestion-status admin-suggestion-status--done">Добавлено</span>
                                    @else
                                        <span class="admin-suggestion-status admin-suggestion-status--dismissed">Отклонено</span>
                                    @endif
                                </td>
                                <td class="characters-index__actions admin-suggestion-actions">
                                    @if($suggestion->isPending())
                                        <a href="{{ route('admin.characters.create', ['suggestion' => $suggestion->id]) }}"
                                           class="admin-btn admin-btn--primary admin-suggestion-add-btn">
                                            Добавить в базу
                                        </a>
                                        <form action="{{ route('admin.character-suggestions.dismiss', $suggestion) }}" method="post" class="admin-suggestion-dismiss-form"
                                            onsubmit="return confirm('Отклонить это предложение?');">
                                            @csrf
                                            <button type="submit" class="admin-btn admin-btn--outline admin-suggestion-dismiss-btn">Отклонить</button>
                                        </form>
                                    @else
                                        —
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="admin-suggestions-pagination">
                {{ $suggestions->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
