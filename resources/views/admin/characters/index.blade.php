<x-app-layout>
    <div class="characters-index">
        <h1>Все иероглифы</h1>
        <a href="{{ route('admin.characters.create') }}" class="add-new-link">Добавить новый иероглиф</a>

        <div class="characters-index-table-wrap">
            <table class="characters-index-table">
                <thead>
                    <tr>
                        <th>Иероглиф</th>
                        <th>Пиньинь</th>
                        <th>Значение</th>
                        <th>Уровень HSK</th>
                        <th>Аудио иероглифа</th>
                        <th>Пример на китайском</th>
                        <th>Пиньинь примера</th>
                        <th>Перевод примера</th>
                        <th>Аудио примера</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($characters as $character)
                        <tr>
                            <td>{{ $character->character }}</td>
                            <td>{{ $character->pinyin }}</td>
                            <td>{{ $character->meaning }}</td>
                            <td>{{ $character->hsk_level }}</td>
                            <td>{{ $character->audio_character }}</td>
                            <td>{{ $character->example_hanzi }}</td>
                            <td>{{ $character->example_pinyin }}</td>
                            <td>{{ $character->example_translation }}</td>
                            <td>{{ $character->audio_example }}</td>
                            <td class="characters-index__actions">
                                <a href="{{ route('admin.characters.edit', $character->id) }}" class="table-actions">Редактировать</a>
                                <form action="{{ route('admin.characters.destroy', $character->id) }}" method="POST" class="table-actions">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
