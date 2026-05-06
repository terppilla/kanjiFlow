<x-app-layout>
    <div class="characters-index">
        <h1>Все иероглифы</h1>
        <a href="{{ route('admin.characters.create') }}" class="add-new-link">Добавить новый иероглиф</a>

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

        <section class="characters-json-import-panel" aria-labelledby="characters-json-import-title">
            <h2 id="characters-json-import-title" class="characters-json-import-title">Импорт из JSON</h2>
            <p class="characters-json-import-hint">
                Массив объектов с полями: <code>character</code>, <code>pinyin</code>, <code>meaning</code>,
                <code>hsk_level</code> (1–6), <code>example_hanzi</code>, <code>example_pinyin</code>,
                <code>example_translation</code>, <code>audio</code> (обычно <code>null</code> или путь).
                Дубликаты по строке <code>character</code> в одном файле запрещены. Совпадающие по тексту записи в базе будут обновлены.
            </p>
            <form action="{{ route('admin.characters.import-json') }}" method="POST" enctype="multipart/form-data" class="characters-json-import-form">
                @csrf
                <label class="characters-json-import-label">
                    Файл (.json или .txt)
                    <input type="file" name="json_file" accept=".json,.txt,application/json" required class="characters-json-import-file">
                </label>
                <button type="submit" class="characters-json-import-submit">Загрузить и импортировать</button>
            </form>
        </section>

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
