<x-app-layout>
    <div class="collections-page">
        <div class="collections-shell page-collections-show">
            <header class="collections-show-head">
                <div class="collections-show-intro">
                    <h1 class="collections-title">{{ $collection->name }}</h1>
                    <p class="collections-show-meta">Иероглифов в коллекции: <strong>{{ $collection->characters->count() }}</strong></p>
                </div>
                <div class="collections-toolbar">
                    <a href="{{ route('learning.collection.level', $collection) }}" class="btn btn-primary">Учить коллекцию</a>
                    <a href="{{ route('collections.edit', $collection) }}" class="btn btn-outline">Переименовать</a>
                    <a href="{{ route('collections.index') }}" class="btn btn-ghost">Все коллекции</a>
                </div>
            </header>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('info'))
                <div class="alert alert-info">{{ session('info') }}</div>
            @endif

            <section class="collections-panel collections-panel--accent">
                <h2 class="collections-panel-title">Добавить иероглиф</h2>
                <p class="collections-subtle">Поиск по значению, пиньиню или символу</p>
                <div class="search-row">
                    <input type="search" id="charSearch" autocomplete="off" placeholder="Начните вводить…" data-url="{{ route('collections.characters.search', $collection) }}">
                </div>
                <div class="suggest" id="searchSuggest"></div>
            </section>

            <section class="collections-panel">
                <h2 class="collections-panel-title">Состав коллекции</h2>
                @if($collection->characters->isEmpty())
                    <div class="collections-empty-inline">Пока пусто — добавьте иероглифы поиском выше.</div>
                @else
                    <div class="collections-characters-grid">
                        @foreach($collection->characters as $character)
                            @php $isLearned = in_array($character->id, $learnedCharacterIds ?? [], true); @endphp
                            <div class="collections-char-cell">
                                <a href="{{ route('learning.collection.show', [$collection, $character]) }}"
                                   class="collections-learn-card {{ $isLearned ? 'collections-learn-card--learned' : '' }}">
                                    <div class="collections-learn-card-glyph">{{ $character->character }}</div>
                                    <div class="collections-learn-card-pinyin">{{ $character->pinyin }}</div>
                                    <div class="collections-learn-card-meaning">{{ \Illuminate\Support\Str::limit($character->meaning, 40) }}</div>
                                    <span class="collections-learn-card-badge {{ $isLearned ? 'is-learned' : 'is-new' }}">{{ $isLearned ? 'Выучен' : 'Новый' }}</span>
                                </a>
                                <form action="{{ route('collections.remove-character', [$collection, $character]) }}" method="post" class="collections-char-remove"
                                    onsubmit="return confirm('Убрать этот иероглиф из коллекции?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-icon-remove" title="Убрать из коллекции">✕</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            @if(! $collection->is_builtin)
                <section class="collections-danger-zone" aria-labelledby="danger-zone-title">
                    <h2 id="danger-zone-title" class="collections-danger-title">Опасная зона</h2>
                    <p class="collections-danger-text">Удаление коллекции не удаляет иероглифы из базы, только убирает этот набор.</p>
                    <form action="{{ route('collections.destroy', $collection) }}" method="post"
                        onsubmit="return confirm('Удалить коллекцию «{{ addslashes($collection->name) }}»?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger-solid">Удалить коллекцию</button>
                    </form>
                </section>
            @endif
        </div>
    </div>

    <script>
        (function() {
            const input = document.getElementById('charSearch');
            const box = document.getElementById('searchSuggest');
            const url = input.dataset.url;
            let t;

            input.addEventListener('input', function() {
                clearTimeout(t);
                const q = input.value.trim();
                if (q.length < 1) {
                    box.style.display = 'none';
                    box.innerHTML = '';
                    return;
                }
                t = setTimeout(async function() {
                    try {
                        const r = await fetch(url + '?q=' + encodeURIComponent(q), {
                            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                        });
                        const data = await r.json();
                        box.innerHTML = '';
                        if (!data.characters || !data.characters.length) {
                            box.style.display = 'block';
                            box.innerHTML = '<div class="collections-empty-search">Ничего не найдено</div>';
                            return;
                        }
                        data.characters.forEach(function(ch) {
                            const b = document.createElement('button');
                            b.type = 'button';
                            b.innerHTML = '<span class="glyph">' + escapeHtml(ch.character) + '</span> ' + escapeHtml(ch.meaning || '') + ' <small class="collections-hsk-badge">HSK' + ch.hsk_level + '</small>';
                            b.addEventListener('click', function() {
                                const form = document.createElement('form');
                                form.method = 'POST';
                                form.action = @json(route('collections.add-character', $collection));
                                const token = document.querySelector('meta[name="csrf-token"]');
                                form.innerHTML = '<input type="hidden" name="_token" value="' + (token ? token.content : '') + '">' +
                                    '<input type="hidden" name="character_id" value="' + ch.id + '">';
                                document.body.appendChild(form);
                                form.submit();
                            });
                            box.appendChild(b);
                        });
                        box.style.display = 'block';
                    } catch (e) {
                        console.error(e);
                    }
                }, 220);
            });

            function escapeHtml(s) {
                const d = document.createElement('div');
                d.textContent = s;
                return d.innerHTML;
            }

            document.addEventListener('click', function(e) {
                if (!input.contains(e.target) && !box.contains(e.target)) {
                    box.style.display = 'none';
                }
            });
        })();
    </script>
</x-app-layout>
