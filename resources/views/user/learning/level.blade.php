<x-app-layout>
    <div class="container page-learning-level">
        <div class="level-navigation">
            @if(isset($collection) && $collection)
                <a href="{{ route('collections.show', $collection) }}" class="nav-btn">
                    ← К коллекции
                </a>
            @else
                <a href="{{ route('learning.select-level') }}" class="nav-btn">
                    ← Назад к выбору уровня
                </a>
            @endif

            @if($characters->count() > 0)
                @if(isset($collection) && $collection)
                    <a href="{{ route('learning.collection.show', [$collection, $characters->first()]) }}" class="nav-btn">
                        Начать изучение →
                    </a>
                @else
                    <a href="{{ route('learning.show', $characters->first() ?? 1) }}" class="nav-btn">
                        Начать изучение →
                    </a>
                @endif
            @endif
        </div>

        <div class="level-header">
            @if(isset($collection) && $collection)
                <h1>{{ $collection->name }}</h1>
                <p>Коллекция: изучение выбранных иероглифов</p>
            @else
                <h1>HSK {{ $level }}</h1>
                <p>Изучение иероглифов уровня HSK {{ $level }}</p>
            @endif

            <div class="level-stats">
                <div class="stat">
                    <span class="stat-value">{{ $totalScope }}</span>
                    <span class="stat-label">Всего иероглифов</span>
                </div>
                <div class="stat">
                    <span class="stat-value">{{ $learnedScopeCount }}</span>
                    <span class="stat-label">Выучено</span>
                </div>
                <div class="stat">
                    <span class="stat-value">
                        {{ $totalScope > 0 ? round(($learnedScopeCount / $totalScope) * 100) : 0 }}%
                    </span>
                    <span class="stat-label">Прогресс</span>
                </div>
            </div>
        </div>

        <div class="search-box">
            <input type="text"
                   class="search-input"
                   placeholder="Поиск иероглифа по значению или пиньиню..."
                   id="searchInput">
            <button class="search-btn" id="searchBtn">Найти</button>
        </div>

        @if($characters->count() > 0)
            <div class="learn-all-row">
                @if(isset($collection) && $collection)
                    <a href="{{ route('learning.collection.show', [$collection, $characters->first()]) }}" class="learn-all-btn">
                        Начать изучение первого иероглифа
                    </a>
                @else
                    <a href="{{ route('learning.show', $characters->first() ?? 1) }}" class="learn-all-btn">
                        Начать изучение первого иероглифа
                    </a>
                @endif
            </div>

            <div class="characters-grid" id="charactersGrid">
                @foreach($characters as $character)
                    @php
                        $isLearned = in_array($character->id, $learnedCharacterIds);
                    @endphp
                    <a href="{{ isset($collection) && $collection ? route('learning.collection.show', [$collection, $character]) : route('learning.show', $character) }}"
                       class="character-card {{ $isLearned ? 'learned' : '' }}"
                       data-pinyin="{{ strtolower($character->pinyin) }}"
                       data-meaning="{{ strtolower($character->meaning) }}">
                        <div class="character-char">{{ $character->character }}</div>
                        <div class="character-pinyin">{{ $character->pinyin }}</div>
                        <div class="character-meaning">{{ $character->meaning }}</div>
                        <div class="character-status {{ $isLearned ? 'status-learned' : 'status-new' }}">
                            {{ $isLearned ? 'Выучен' : 'Новый' }}
                        </div>
                    </a>
                @endforeach
            </div>

            @if($characters->hasPages())
                <div class="pagination">
                    {{ $characters->links() }}
                </div>
            @endif
        @else
            <div class="empty-state">
                @if(isset($collection) && $collection)
                    <h3>Коллекция пуста</h3>
                    <p><a href="{{ route('collections.show', $collection) }}">Добавьте иероглифы</a> в коллекцию.</p>
                @else
                    <h3>В этом уровне пока нет иероглифов</h3>
                    <p>В базе данных еще нет иероглифов уровня HSK {{ $level }}</p>
                @endif
            </div>
        @endif
    </div>

    <script>
        document.getElementById('searchBtn').addEventListener('click', filterCharacters);
        document.getElementById('searchInput').addEventListener('keyup', function(e) {
            if (e.key === 'Enter') filterCharacters();
        });

        function filterCharacters() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
            const cards = document.querySelectorAll('.character-card');

            cards.forEach(card => {
                const pinyin = card.dataset.pinyin;
                const meaning = card.dataset.meaning;

                if (searchTerm === '' || pinyin.includes(searchTerm) || meaning.includes(searchTerm)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const learnedCards = document.querySelectorAll('.character-card.learned');
            learnedCards.forEach(card => {
                card.style.order = '-1';
            });
        });
    </script>
</x-app-layout>
