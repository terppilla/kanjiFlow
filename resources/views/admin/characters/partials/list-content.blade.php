<p class="admin-list-results-meta">
    @if($characters->total() > 0)
        Показано {{ $characters->firstItem() }}–{{ $characters->lastItem() }} из <span data-admin-list-total>{{ $characters->total() }}</span>
    @else
        Ничего не найдено
    @endif
</p>

<div class="characters-index-table-wrap">
    <table class="characters-index-table">
        <thead>
            <tr>
                <th>Иероглиф</th>
                <th>Пиньинь</th>
                <th>Значение</th>
                <th>HSK</th>
                <th>Аудио</th>
                <th>Пример</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($characters as $character)
                <tr>
                    <td class="admin-cell-glyph">{{ $character->character }}</td>
                    <td>{{ $character->pinyin }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($character->meaning, 48) }}</td>
                    <td><span class="admin-hsk-badge">HSK {{ $character->hsk_level }}</span></td>
                    <td class="admin-cell-muted">{{ $character->audio_character ? '✓' : '—' }}</td>
                    <td class="admin-cell-muted">{{ $character->example_hanzi ? \Illuminate\Support\Str::limit($character->example_hanzi, 24) : '—' }}</td>
                    <td class="characters-index__actions">
                        <a href="{{ route('admin.characters.edit', $character->id) }}" class="table-actions">Изменить</a>
                        <form action="{{ route('admin.characters.destroy', $character->id) }}" method="POST" class="table-actions"
                            onsubmit="return confirm('Удалить этот иероглиф?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="table-actions-link">Удалить</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="admin-list-empty">По вашему запросу иероглифов не найдено.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="pagination admin-pagination">
    {{ $characters->links('vendor.pagination.my-pagination') }}
</div>
