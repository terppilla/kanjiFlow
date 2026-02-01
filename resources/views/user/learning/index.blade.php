<h1>Обучение иероглифам</h1>

<ul>
<li>
    @foreach ($characters as $character)
    <a href="{{ route('learn.show', $character) }}">
    {{ $character->character }} - {{ $character->pinyin }}
    </a>
@endforeach
</li>
</ul>