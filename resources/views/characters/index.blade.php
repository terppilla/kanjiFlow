<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Все иероглифы</title>
</head>
<body>
    <h1>Всё иероглифы</h1>
    <a href="{{route('characters.create')}}">Добавить новый иероглиф</a>

    <table>
        <thead>
            <tr>Иероглиф</tr>
            <tr>Пиньинь</tr>
            <tr>Значение</tr>
            <tr>Уровень HSK</tr>
            <tr>Аудио иероглифа</tr>
            <tr>Пример на китайском</tr>
            <tr>Пиньинь примера</tr>
            <tr>Перевод примера</tr>
            <tr>Аудио примера</tr>
            <tr>Действия</tr>
        </thead>
        <tbody>
            @foreach ($characters as $character)
            <tr>
              <td>{{ $character->character }}</td>
              <td>{{ $character->pinyin }}</td>
              <td>{{ $character->meaning }}</td>
              <td>{{ $character->hsk_level }}</td>
              <td>{{ $character->audio_character }}</td>
              <td>{{ $character->example_hanji }}</td>
              <td>{{ $character->example_pinyin }}</td>
              <td>{{ $character->example_translation }}</td>
              <td>{{ $character->audio_example }}</td>
              <td>
                <a href="{{ route('characters.edit', $character->id)}}">Редактировать</a>
                <form action="{{route('characters.destroy', $character->id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Удалить</button>
                </form>
              </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>