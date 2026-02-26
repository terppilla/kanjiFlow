<x-app-layout>
    <style>
        :root {
            --color-primary: #C1121F;
            --color-dark-red: #7A1414;
            --color-gold: #D69B64;
            --color-white-gold: #F3CAA5;
            --color-calm-blue: #1F2933;
            --color-dark-blue: #0F172A;
            --color-gray: #C0C0C0;
            --color-success: #10b981;
            --color-light-bg: #f8f9fa;
            --color-white: #ffffff;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--color-light-bg);
            color: var(--color-calm-blue);
        }

        .learning-level-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
            min-height: 100vh;
        }

        /* Навигация */
        .level-navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
        }

        .nav-btn {
            padding: 0.75rem 1.5rem;
            background: var(--color-white-gold);
            color: var(--color-dark-red);
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s ease;
            border: 1px solid rgba(214, 155, 100, 0.3);
            font-size: 0.9rem;
        }

        .nav-btn:hover {
            background: var(--color-gold);
            color: white;
            transform: translateY(-1px);
        }

        /* Заголовок уровня */
        .level-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .level-header h1 {
            font-size: 2.5rem;
            color: var(--color-dark-red);
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .level-header p {
            font-size: 1.1rem;
            color: var(--color-calm-blue);
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        /* Статистика */
        .level-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .stat {
            text-align: center;
            padding: 1.5rem;
            background: white;
            border-radius: 10px;
            border: 1px solid rgba(214, 155, 100, 0.1);
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .stat-value {
            display: block;
            font-size: 2rem;
            font-weight: 700;
            color: var(--color-primary);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--color-gray);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Поиск */
        .search-box {
            max-width: 600px;
            margin: 0 auto 2.5rem;
            display: flex;
            gap: 0.75rem;
        }

        .search-input {
            flex: 1;
            padding: 1rem 1.25rem;
            border: 2px solid rgba(214, 155, 100, 0.3);
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.2s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--color-gold);
        }

        .search-btn {
            padding: 1rem 1.5rem;
            background: var(--color-primary);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s ease;
            min-width: 100px;
        }

        .search-btn:hover {
            background: var(--color-dark-red);
            transform: translateY(-1px);
        }

        /* Кнопка начала */
        .learn-all-btn {
            display: inline-block;
            padding: 1rem 2rem;
            background: var(--color-primary);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.2s ease;
            margin-bottom: 2.5rem;
            border: 2px solid transparent;
        }

        .learn-all-btn:hover {
            background: var(--color-dark-red);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(193, 18, 31, 0.2);
        }

        /* Сетка иероглифов */
        .characters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
            margin: 2.5rem 0;
        }

        .character-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            text-decoration: none;
            transition: all 0.2s ease;
            border: 1px solid rgba(214, 155, 100, 0.1);
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .character-card:hover {
            border-color: var(--color-gold);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .character-card.learned {
            border-color: var(--color-success);
            background: rgba(16, 185, 129, 0.03);
        }

        .character-char {
            font-family: 'Noto Serif SC', serif;
            font-size: 3rem;
            color: var(--color-dark-red);
            font-weight: 600;
        }

        .character-pinyin {
            color: var(--color-primary);
            font-style: italic;
            font-size: 1rem;
            font-weight: 500;
        }

        .character-meaning {
            color: var(--color-calm-blue);
            font-size: 0.95rem;
            line-height: 1.4;
            text-align: center;
            min-height: 2.8em;
        }

        .character-status {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            margin-top: 0.5rem;
        }

        .status-learned {
            background: var(--color-success);
            color: white;
        }

        .status-new {
            background: var(--color-white-gold);
            color: var(--color-dark-red);
        }

        /* Пустое состояние */
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            background: white;
            border-radius: 10px;
            border: 2px dashed rgba(214, 155, 100, 0.2);
            margin: 2rem 0;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            color: var(--color-dark-blue);
            margin-bottom: 1rem;
        }

        .empty-state p {
            color: var(--color-gray);
            font-size: 1rem;
        }

        /* Пагинация */
        .pagination {
            text-align: center;
            margin-top: 3rem;
        }

        /* Адаптивность */
        @media (max-width: 768px) {
            .learning-level-container {
                padding: 1.5rem 1rem;
            }
            
            .level-navigation {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            
            .level-header h1 {
                font-size: 2rem;
            }
            
            .level-stats {
                grid-template-columns: 1fr;
                gap: 1rem;
                max-width: 300px;
            }
            
            .stat {
                padding: 1rem;
            }
            
            .stat-value {
                font-size: 1.75rem;
            }
            
            .search-box {
                flex-direction: column;
            }
            
            .search-input {
                width: 100%;
            }
            
            .search-btn {
                width: 100%;
            }
            
            .characters-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }
        }

        @media (max-width: 576px) {
            .characters-grid {
                grid-template-columns: 1fr;
            }
            
            .learn-all-btn {
                padding: 0.75rem 1.5rem;
                font-size: 0.9rem;
            }
        }
    </style>

    <div class="learning-level-container">
        <div class="level-navigation">
            <a href="{{ route('learning.select-level') }}" class="nav-btn">
                ← Назад к выбору уровня
            </a>
            
            @if($characters->count() > 0)
                <a href="{{ route('learning.show', $characters->first() ?? 1) }}" class="nav-btn">
                    Начать изучение →
                </a>
            @endif
        </div>

        <div class="level-header">
            <h1>HSK {{ $level }}</h1>
            <p>Изучение иероглифов уровня HSK {{ $level }}</p>
            
            <div class="level-stats">
                <div class="stat">
                    <span class="stat-value">{{ $characters->total() }}</span>
                    <span class="stat-label">Всего иероглифов</span>
                </div>
                <div class="stat">
                    <span class="stat-value">{{ count($learnedCharacterIds) }}</span>
                    <span class="stat-label">Выучено</span>
                </div>
                <div class="stat">
                    <span class="stat-value">
                        {{ $characters->total() > 0 ? round((count($learnedCharacterIds) / $characters->total()) * 100) : 0 }}%
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
            <div style="text-align: center; margin-bottom: 2rem;">
                <a href="{{ route('learning.show', $characters->first() ?? 1) }}" class="learn-all-btn">
                    Начать изучение первого иероглифа
                </a>
            </div>

            <div class="characters-grid" id="charactersGrid">
                @foreach($characters as $character)
                    @php
                        $isLearned = in_array($character->id, $learnedCharacterIds);
                    @endphp
                    <a href="{{ route('learning.show', $character) }}" 
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
                <h3>В этом уровне пока нет иероглифов</h3>
                <p>В базе данных еще нет иероглифов уровня HSK {{ $level }}</p>
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
                
                if (searchTerm === '' || 
                    pinyin.includes(searchTerm) || 
                    meaning.includes(searchTerm)) {
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