<x-app-layout>
    <div class="form-container admin-article-form-page">
        @include('admin.partials.form-back-bar')
        <h1 class="form-title">Редактировать иероглиф</h1>
        <p class="admin-form-subtitle">Измените данные иероглифа и при необходимости пример использования.</p>

        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.characters.update', $character->id) }}" method="POST" class="character-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="character">Иероглиф</label>
                <input type="text" id="character" name="character" class="form-control @error('character') error @enderror" 
                       value="{{ old('character', $character->character) }}" required>
                @error('character')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="pinyin">Пиньинь</label>
                <input type="text" id="pinyin" name="pinyin" class="form-control @error('pinyin') error @enderror" 
                       value="{{ old('pinyin', $character->pinyin) }}" required>
                @error('pinyin')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="meaning">Значение</label>
                <textarea name="meaning" id="meaning" class="form-control @error('meaning') error @enderror" 
                          required>{{ old('meaning', $character->meaning) }}</textarea>
                @error('meaning')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="hsk_level">Уровень HSK</label>
                <select name="hsk_level" id="hsk_level" class="form-control" required>
                    <option value="1" {{ old('hsk_level', $character->hsk_level) == 1 ? 'selected' : '' }}>HSK 1</option>
                    <option value="2" {{ old('hsk_level', $character->hsk_level) == 2 ? 'selected' : '' }}>HSK 2</option>
                    <option value="3" {{ old('hsk_level', $character->hsk_level) == 3 ? 'selected' : '' }}>HSK 3</option>
                    <option value="4" {{ old('hsk_level', $character->hsk_level) == 4 ? 'selected' : '' }}>HSK 4</option>
                    <option value="5" {{ old('hsk_level', $character->hsk_level) == 5 ? 'selected' : '' }}>HSK 5</option>
                    <option value="6" {{ old('hsk_level', $character->hsk_level) == 6 ? 'selected' : '' }}>HSK 6</option>
                </select>
            </div>
            
            @include('admin.characters.partials.audio-field', [
                'label' => 'Аудио иероглифа',
                'inputId' => 'audio_character',
                'inputName' => 'audio_character',
                'kind' => 'character',
                'textSourceId' => 'pinyin',
                'glyphSourceId' => 'character',
                'value' => old('audio_character', $character->audio_character),
                'character' => $character,
            ])

            <div class="form-group">
                <fieldset>
                    <legend>Пример использования</legend>
                    
                    <div class="fieldset-group">
                        <label for="example_hanzi" class="optional">Пример на китайском</label>
                        <textarea name="example_hanzi" id="example_hanzi" class="form-control">{{ old('example_hanzi', $character->example_hanzi) }}</textarea>
                    </div>

                    <div class="fieldset-group">
                        <label for="example_pinyin" class="optional">Пиньинь примера</label>
                        <textarea name="example_pinyin" id="example_pinyin" class="form-control">{{ old('example_pinyin', $character->example_pinyin) }}</textarea>
                    </div>

                    <div class="fieldset-group">
                        <label for="example_translation" class="optional">Перевод примера</label>
                        <textarea name="example_translation" id="example_translation" class="form-control">{{ old('example_translation', $character->example_translation) }}</textarea>
                    </div>
                            
                    @include('admin.characters.partials.audio-field', [
                        'label' => 'Аудио примера',
                        'inputId' => 'audio_example',
                        'inputName' => 'audio_example',
                        'kind' => 'example',
                        'textSourceId' => 'example_hanzi',
                        'textSourceFallback' => 'example_pinyin',
                        'glyphSourceId' => 'character',
                        'value' => old('audio_example', $character->audio_example),
                        'character' => $character,
                    ])
                </fieldset>
            </div>

            <div class="form-group admin-generate-audio-option">
                <label class="admin-checkbox-label">
                    <input type="checkbox" name="generate_audio" value="1" {{ old('generate_audio') ? 'checked' : '' }}>
                    Сгенерировать недостающее аудио при сохранении
                </label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Обновить иероглиф</button>
                <a href="{{ route('admin.characters.index') }}" class="btn-cancel">Отмена</a>
            </div>
        </form>
    </div>

    <script src="{{ asset('js/admin-character-audio.js') }}" defer></script>
</x-app-layout>