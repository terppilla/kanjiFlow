<x-app-layout>
    <div class="wrap page-collections-show">
        <div class="top">
            <div>
                <h1>{{ $collection->name }}</h1>
                <div class="meta">Иероглифов: {{ $collection->characters->count() }}</div>
            </div>
            <div class="toolbar">
                <a href="{{ route('learning.collection.level', $collection) }}" class="btn btn-primary">Учить коллекцию</a>
                <a href="{{ route('collections.edit', $collection) }}" class="btn btn-ghost">Переименовать</a>
                <a href="{{ route('collections.index') }}" class="btn btn-ghost">Все коллекции</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('info'))
            <div class="alert alert-info">{{ session('info') }}</div>
        @endif

        <div class="add-box">
            <h2>Добавить иероглиф</h2>
            <p class="collections-subtle">Поиск по значению, пиньиню или символу</p>
            <div class="search-row">
                <input type="search" id="charSearch" autocomplete="off" placeholder="Начните вводить…" data-url="{{ route('collections.characters.search', $collection) }}">
            </div>
            <div class="suggest" id="searchSuggest"></div>
        </div>

        <div class="chars">
            <h2>Состав коллекции</h2>
            @if($collection->characters->isEmpty())
                <div class="empty-chars">Пока пусто — добавьте иероглифы поиском выше.</div>
            @else
                <div class="char-grid">
                    @foreach($collection->characters as $character)
                        <div class="char-item">
                            <div>
                                <span class="glyph">{{ $character->character }}</span>
                                <span>{{ \Illuminate\Support\Str::limit($character->meaning, 32) }}</span>
                            </div>
                            <div class="char-item-actions">
                                <a href="{{ route('learning.collection.show', [$collection, $character]) }}">Учить</a>
                                <form action="{{ route('collections.remove-character', [$collection, $character]) }}" method="post" onsubmit="return confirm('Убрать из коллекции?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-xs">✕</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
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
