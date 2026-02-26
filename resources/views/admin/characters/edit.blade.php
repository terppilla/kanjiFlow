<x-app-layout>
    <link href="{{ asset('css/forms.css') }}" rel="stylesheet">
    
    <div class="form-container">
        <h1 class="form-title">Редактировать иероглиф</h1>

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
            
            <div class="form-group">
                <label for="audio_character" class="optional">Аудио иероглифа</label>
                <input type="text" id="audio_character" name="audio_character" class="form-control" 
                       value="{{ old('audio_character', $character->audio_character) }}">
                <div class="form-hint">Ссылка на аудиофайл</div>
            </div>

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
                            
                    <div class="fieldset-group">
                        <label for="audio_example" class="optional">Аудио примера</label>
                        <input type="text" id="audio_example" name="audio_example" class="form-control" 
                               value="{{ old('audio_example', $character->audio_example) }}">
                    </div>
                </fieldset>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Обновить иероглиф</button>
                <a href="{{ route('admin.characters.index') }}" class="btn-cancel">Отмена</a>
            </div>
        </form>
    </div>
</x-app-layout>