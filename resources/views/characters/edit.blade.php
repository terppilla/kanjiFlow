<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Редактировать иероглиф</title>
</head>
<body>
    <h1>Редактировать иероглиф</h1>

    <form action="{{route('characters.update', $character->id)}}" method="POST">
    @csrf
    @method('PUT')

    <label for="character">Иероглиф</label>
    <input type="text" id="character" name="character" value="{{ $character->character}}" required>

    <label for="pinyin">Пиньинь</label>
    <input type="text" id="pinyin" name="pinyin" value="{{ $character->pinyin}}" required>

    <label for="meaning">Значение</label>
    <textarea name="meaning" id="meaning" value="{{ $character->meaning}}" required></textarea>

    <label for="hsk_level">Уровень HSK</label>
    <select name="hsk_level" id="hsk_level" value="{{ $character->hsk_level}}" required>
        <option value="1">1 HSK</option>
        <option value="2">2 HSK</option>
        <option value="3">3 HSK</option>
        <option value="4">4 HSK</option>
        <option value="5">5 HSK</option>
        <option value="6">6 HSK</option>
    </select>
    
    <label for="audio_character">Аудио иероглифа</label>
    <input type="text" id="audio_character" name="audio_character" value="{{ $character->audio_character}}">


   <fieldset>
    <legend>Пример</legend>
    <label for="example_hanji">Пример на китайском</label>
    <textarea name="example_hanji" id="example_hanji" value="{{ $character->example_hanji}}"></textarea>

    <label for="example_pinyin">Пиньинь примера</label>
    <textarea name="example_pinyin" id="example_pinyin" value="{{ $character->example_pinyin}}" ></textarea>

    <label for="example_translation">Перевод примера</label>
    <textarea name="example_translation" id="example_translation" value="{{ $character->example_translation}}"></textarea>
            
    <label for="audio_example">Аудио примера</label>
    <input type="text" id="audio_example" name="audio_example" value="{{ $character->audio_example}}">
   </fieldset>

   

    <button type="submit">Сохранить</button>
    </form>

    <a href="{{route('characters.index')}}">Назад</a>
</body>
</html>