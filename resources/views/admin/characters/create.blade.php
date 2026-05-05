<x-app-layout>
    <div class="form-container admin-article-form-page">
        <h1 class="form-title">Добавить иероглиф</h1>
        <p class="admin-form-subtitle">Заполните данные иероглифа и при необходимости пример использования — в том же светлом стиле, что и форма статьи.</p>

        @if(session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.characters.store') }}" method="POST" class="character-form">
            @csrf

            <div class="form-group">
                <label for="character">Иероглиф</label>
                <input type="text" id="character" name="character" class="form-control @error('character') error @enderror"
                       value="{{ old('character') }}" required>
                @error('character')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="pinyin">Пиньинь</label>
                <input type="text" id="pinyin" name="pinyin" class="form-control @error('pinyin') error @enderror"
                       value="{{ old('pinyin') }}" required>
                @error('pinyin')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="meaning">Значение</label>
                <textarea name="meaning" id="meaning" class="form-control @error('meaning') error @enderror"
                          required>{{ old('meaning') }}</textarea>
                @error('meaning')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="hsk_level">Уровень HSK</label>
                <select name="hsk_level" id="hsk_level" class="form-control @error('hsk_level') error @enderror" required>
                    <option value="1" {{ (string) old('hsk_level', '1') === '1' ? 'selected' : '' }}>HSK 1</option>
                    <option value="2" {{ (string) old('hsk_level') === '2' ? 'selected' : '' }}>HSK 2</option>
                    <option value="3" {{ (string) old('hsk_level') === '3' ? 'selected' : '' }}>HSK 3</option>
                    <option value="4" {{ (string) old('hsk_level') === '4' ? 'selected' : '' }}>HSK 4</option>
                    <option value="5" {{ (string) old('hsk_level') === '5' ? 'selected' : '' }}>HSK 5</option>
                    <option value="6" {{ (string) old('hsk_level') === '6' ? 'selected' : '' }}>HSK 6</option>
                </select>
                @error('hsk_level')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="audio_character" class="optional">Аудио иероглифа</label>
                <input type="text" id="audio_character" name="audio_character"
                       class="form-control @error('audio_character') error @enderror"
                       value="{{ old('audio_character') }}">
                <div class="form-hint">Ссылка на аудиофайл</div>
                @error('audio_character')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <fieldset>
                    <legend>Пример использования</legend>

                    <div class="fieldset-group">
                        <label for="example_hanzi" class="optional">Пример на китайском</label>
                        <textarea name="example_hanzi" id="example_hanzi"
                                  class="form-control @error('example_hanzi') error @enderror">{{ old('example_hanzi') }}</textarea>
                        @error('example_hanzi')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="fieldset-group">
                        <label for="example_pinyin" class="optional">Пиньинь примера</label>
                        <textarea name="example_pinyin" id="example_pinyin"
                                  class="form-control @error('example_pinyin') error @enderror">{{ old('example_pinyin') }}</textarea>
                        @error('example_pinyin')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="fieldset-group">
                        <label for="example_translation" class="optional">Перевод примера</label>
                        <textarea name="example_translation" id="example_translation"
                                  class="form-control @error('example_translation') error @enderror">{{ old('example_translation') }}</textarea>
                        @error('example_translation')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="fieldset-group">
                        <label for="audio_example" class="optional">Аудио примера</label>
                        <input type="text" id="audio_example" name="audio_example"
                               class="form-control @error('audio_example') error @enderror"
                               value="{{ old('audio_example') }}">
                        @error('audio_example')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </fieldset>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Сохранить иероглиф</button>
                <a href="{{ route('admin.characters.index') }}" class="btn-cancel">Отмена</a>
            </div>
        </form>
    </div>
</x-app-layout>
