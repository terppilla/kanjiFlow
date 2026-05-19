<x-app-layout>
    <div class="form-container admin-article-form-page">
        @include('admin.partials.form-back-bar')
        <h1 class="form-title">Добавить иероглиф</h1>
        <p class="admin-form-subtitle">Заполните данные иероглифа и при необходимости пример использования — в том же светлом стиле, что и форма статьи.</p>

        @if(session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        @if(isset($suggestion) && $suggestion)
            <div class="admin-suggestion-prefill-banner" role="status">
                <strong>Предложение от пользователя {{ $suggestion->user?->name }}</strong>
                @if($suggestion->collection)
                    (коллекция «{{ $suggestion->collection->name }}»)
                @endif
                <p>Слова: {{ $suggestion->wordsLabel() }}</p>
                @if($suggestion->search_query)
                    <p>Запрос в поиске: «{{ $suggestion->search_query }}»</p>
                @endif
                @if($suggestion->note)
                    <p>Комментарий: {{ $suggestion->note }}</p>
                @endif
            </div>
        @endif

        <form action="{{ route('admin.characters.store') }}" method="POST" class="character-form">
            @csrf
            @if(isset($suggestion) && $suggestion)
                <input type="hidden" name="character_suggestion_id" value="{{ $suggestion->id }}">
            @endif

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
                          required>{{ old('meaning', isset($suggestion) && $suggestion ? $suggestion->wordsLabel() : '') }}</textarea>
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

            @include('admin.characters.partials.audio-field', [
                'label' => 'Аудио иероглифа',
                'inputId' => 'audio_character',
                'inputName' => 'audio_character',
                'kind' => 'character',
                'textSourceId' => 'pinyin',
                'glyphSourceId' => 'character',
                'value' => old('audio_character'),
            ])
            @error('audio_character')
                <div class="error-message">{{ $message }}</div>
            @enderror

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

                    @include('admin.characters.partials.audio-field', [
                        'label' => 'Аудио примера',
                        'inputId' => 'audio_example',
                        'inputName' => 'audio_example',
                        'kind' => 'example',
                        'textSourceId' => 'example_hanzi',
                        'textSourceFallback' => 'example_pinyin',
                        'glyphSourceId' => 'character',
                        'value' => old('audio_example'),
                    ])
                    @error('audio_example')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </fieldset>
            </div>

            <div class="form-group admin-generate-audio-option">
                <label class="admin-checkbox-label">
                    <input type="checkbox" name="generate_audio" value="1" {{ old('generate_audio') ? 'checked' : '' }}>
                    Сгенерировать аудио при сохранении (если пути пустые)
                </label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Сохранить иероглиф</button>
                <a href="{{ route('admin.characters.index') }}" class="btn-cancel">Отмена</a>
            </div>
        </form>
    </div>

    <script src="{{ asset('js/admin-character-audio.js') }}" defer></script>
</x-app-layout>
