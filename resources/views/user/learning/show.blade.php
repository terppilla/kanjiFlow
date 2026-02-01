<h1>{{ $character->character }}</h1>

<p>{{ $character->pinyin }}</p>
<p>{{ $character->meaning }}</p> 
<p>{{ $character->hsk_level }}</p>

<hr>

<h3>Пример</h3>
<p>{{ $character->example_hanzi }}</p>
<p>{{ $character->example_pinyin }}</p>
<p>{{ $character->example_translation }}</p>

<a href="{{ route->('learn.index') }}">Назад</a>