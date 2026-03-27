<x-app-layout>
    <div class="form-container">
        <h1 class="form-title">Добавить иероглиф</h1>

        <form action="{{route('admin.characters.store')}}" method="POST" class="character-form">
            @csrf

            <div class="form-group">
                <label for="character">Иероглиф</label>
                <input type="text" id="character" name="character" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="pinyin">Пиньинь</label>
                <input type="text" id="pinyin" name="pinyin" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="meaning">Значение</label>
                <textarea name="meaning" id="meaning" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label for="hsk_level">Уровень HSK</label>
                <select name="hsk_level" id="hsk_level" class="form-control" required>
                    <option value="1">1 HSK</option>
                    <option value="2">2 HSK</option>
                    <option value="3">3 HSK</option>
                    <option value="4">4 HSK</option>
                    <option value="5">5 HSK</option>
                    <option value="6">6 HSK</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="audio_character" class="optional">Аудио иероглифа</label>
                <input type="text" id="audio_character" name="audio_character" class="form-control">
                <div class="form-hint">Ссылка на аудиофайл</div>
            </div>

            <div class="form-group">
                <fieldset>
                    <legend>Пример использования</legend>
                    
                    <div class="fieldset-group">
                        <label for="example_hanji" class="optional">Пример на китайском</label>
                        <textarea name="example_hanji" id="example_hanji" class="form-control"></textarea>
                    </div>

                    <div class="fieldset-group">
                        <label for="example_pinyin" class="optional">Пиньинь примера</label>
                        <textarea name="example_pinyin" id="example_pinyin" class="form-control"></textarea>
                    </div>

                    <div class="fieldset-group">
                        <label for="example_translation" class="optional">Перевод примера</label>
                        <textarea name="example_translation" id="example_translation" class="form-control"></textarea>
                    </div>
                            
                    <div class="fieldset-group">
                        <label for="audio_example" class="optional">Аудио примера</label>
                        <input type="text" id="audio_example" name="audio_example" class="form-control">
                    </div>
                </fieldset>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Сохранить иероглиф</button>
                <a href="{{route('admin.characters.index')}}" class="btn-cancel">Отмена</a>
            </div>
        </form>
    </div>
</x-app-layout>
