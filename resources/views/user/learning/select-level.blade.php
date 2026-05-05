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

        .page-learning-select-level-inner {
            max-width: 1120px;
            margin: 0 auto;
            padding: 0 1rem 2rem;
        }

        /* Ссылка назад */
        .back-link {
            display: inline-block;
            margin-bottom: 2rem;
            color: var(--color-primary);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
            padding: 0.5rem 1rem;
            background: rgba(193, 18, 31, 0.05);
            border-radius: 6px;
        }

        .back-link:hover {
            color: var(--color-dark-red);
            background: rgba(193, 18, 31, 0.1);
            transform: translateX(-2px);
        }

        /* Сетка уровней HSK */
        .hsk-levels-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .hsk-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            text-decoration: none;
            transition: all 0.2s ease;
            border: 1px solid rgba(214, 155, 100, 0.1);
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .hsk-card:hover {
            border-color: var(--color-gold);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        .hsk-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .hsk-title {
            font-size: 1.5rem;
            color: var(--color-dark-blue);
            font-weight: 600;
        }

        .hsk-count {
            padding: 0.5rem 1rem;
            background: var(--color-primary);
            color: white;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .hsk-description {
            color: var(--color-calm-blue);
            line-height: 1.6;
            font-size: 0.95rem;
            min-height: 60px;
        }

        /* Прогресс */
        .progress-container {
            background: rgba(243, 202, 165, 0.1);
            padding: 1.5rem;
            border-radius: 8px;
            border: 1px solid rgba(214, 155, 100, 0.1);
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
        }

        .progress-label {
            color: var(--color-calm-blue);
            font-weight: 500;
            font-size: 0.9rem;
        }

        .progress-percent {
            color: var(--color-primary);
            font-weight: 700;
            font-size: 1.2rem;
        }

        .progress-bar {
            height: 8px;
            background: #e5e7eb;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: var(--color-primary);
            border-radius: 4px;
            transition: width 0.6s ease;
        }

        /* Статистика уровня */
        .hsk-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            text-align: center;
        }

        .hsk-stats .stat {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .hsk-stats .stat-value {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--color-dark-red);
        }

        .hsk-stats .stat-label {
            font-size: 0.8rem;
            color: var(--color-gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Кнопки действий */
        .hsk-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: 0.5rem;
        }

        .action-btn {
            flex: 1;
            text-align: center;
            padding: 0.75rem;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .learn-btn {
            display: flex;
            justify-content: center;
            background: var(--color-primary);
            color: white;
            border: 1px solid var(--color-primary);
        }

        .learn-btn:hover {
            background: var(--color-dark-red);
            border-color: var(--color-dark-red);
        }

        .review-btn {
            background: var(--color-white-gold);
            color: var(--color-dark-red);
            border: 1px solid rgba(214, 155, 100, 0.3);
        }

        .review-btn:hover {
            background: var(--color-gold);
            color: white;
            border-color: var(--color-gold);
        }

        /* Быстрый старт */
        .quick-start {
            text-align: center;
            margin-bottom: 3rem;
        }

        .quick-start-btn {
            display: inline-block;
            padding: 1rem 2rem;
            background: var(--color-primary);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.2s ease;
            border: 2px solid transparent;
        }

        .quick-start-btn:hover {
            background: var(--color-dark-red);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(193, 18, 31, 0.2);
        }

        /* Информационный раздел */
        .info-section {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            border: 1px solid rgba(214, 155, 100, 0.1);
            margin-top: 2rem;
        }

        .info-title {
            font-size: 1.3rem;
            color: var(--color-dark-blue);
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .info-text {
            color: var(--color-calm-blue);
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .info-tip {
            color: var(--color-gold);
            padding: 1rem;
            background: rgba(214, 155, 100, 0.1);
            border-radius: 8px;
            border-left: 3px solid var(--color-gold);
        }

        /* Тематические коллекции */
        .select-level-collections {
            margin: 5rem 0;
        }

        .select-level-collections-header {
            text-align: center;
            margin-bottom: 1.35rem;
        }

        .select-level-collections-title {
            font-size: 1.65rem;
            color: var(--color-dark-blue);
            font-weight: 600;
            margin-bottom: 0.45rem;
        }

        .select-level-collections-lead {
            font-size: 0.98rem;
            color: var(--color-calm-blue);
            opacity: 0.92;
            max-width: 640px;
            margin: 0 auto;
            line-height: 1.5;
        }

        .select-level-collections-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1rem;
        }

        .select-level-collections-empty {
            grid-column: 1 / -1;
            text-align: center;
            padding: 1.25rem;
            color: #64748b;
            font-size: 0.92rem;
            background: rgba(248, 250, 252, 0.9);
            border-radius: 10px;
            border: 1px dashed rgba(214, 155, 100, 0.35);
        }

        .select-level-collections-empty code {
            font-size: 0.82rem;
            background: rgba(15, 23, 42, 0.06);
            padding: 0.15rem 0.4rem;
            border-radius: 4px;
        }

        .select-level-collections-all-link {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--color-primary);
            text-decoration: none;
            margin-top: 0.25rem;
        }

        .select-level-collections-all-link:hover {
            color: var(--color-dark-red);
            text-decoration: underline;
        }

        .select-level-collections-footer {
            text-align: center;
        }

        /* Адаптивность */
        @media (max-width: 768px) {
            .hsk-levels-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .hsk-card {
                padding: 1.5rem;
            }

            .quick-start-btn {
                padding: 0.75rem 1.5rem;
                font-size: 1rem;
                width: 100%;
            }

            .info-section {
                padding: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .hsk-actions {
                flex-direction: column;
            }

            .hsk-stats {
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }

            .hsk-stats .stat {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
                padding: 0.5rem;
                background: rgba(214, 155, 100, 0.05);
                border-radius: 6px;
            }
        }
    </style>

    <div class="articles-page page-learning-select-level">
        <div class="articles-shell page-learning-select-level-inner">
        <a href="{{ route('dashboard') }}" class="back-link">← Назад в дашборд</a>

        <header class="articles-header">
            <div class="articles-header-text">
                <h1 class="articles-title">Выберите уровень HSK для изучения</h1>
                <p class="articles-lead">Начните с HSK 1 и постепенно переходите к более сложным уровням</p>
            </div>
        </header>

        @php
            $builtinCollections = $builtinCollections ?? collect();
        @endphp

 
        
        <div class="hsk-levels-grid">
            @for($level = 1; $level <= 6; $level++)
                @php
                    $stats = $hskStats[$level] ?? ['total' => 0, 'learned' => 0, 'progress' => 0];
                    $progress = $stats['progress'];
                @endphp
                
                <a href="{{ route('learning.level', $level) }}" class="hsk-card">
                    <div class="hsk-card-header">
                        <div class="hsk-title">HSK {{ $level }}</div>
                        <div class="hsk-count">{{ $stats['learned'] }}/{{ $stats['total'] }}</div>
                    </div>
                    
                    <div class="hsk-description">
                        @if($level == 1)
                            Базовые иероглифы для начинающих. 150 слов.
                        @elseif($level == 2)
                            Для элементарного общения. 300 слов.
                        @elseif($level == 3)
                            Для повседневного общения. 600 слов.
                        @elseif($level == 4)
                            Для свободного общения. 1200 слов.
                        @elseif($level == 5)
                            Для чтения газет и журналов. 2500 слов.
                        @elseif($level == 6)
                            Для понимания сложных текстов. 5000+ слов.
                        @endif
                    </div>
                    
                    <div class="progress-container">
                        <div class="progress-header">
                            <span class="progress-label">Ваш прогресс</span>
                            <span class="progress-percent">{{ $progress }}%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $progress }}%"></div>
                        </div>
                    </div>
                    
                    <div class="hsk-stats">
                        <div class="stat">
                            <span class="stat-value">{{ $stats['total'] }}</span>
                            <span class="stat-label">Всего</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">{{ $stats['learned'] }}</span>
                            <span class="stat-label">Выучено</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">{{ $stats['total'] - $stats['learned'] }}</span>
                            <span class="stat-label">Осталось</span>
                        </div>
                    </div>
                    
                    <div class="hsk-actions">
                        <span class="action-btn learn-btn">Изучать</span>
                    </div>
                </a>
            @endfor
        </div>

        <div class="info-section">
            <h3 class="info-title">Что такое HSK?</h3>
            <p class="info-text">
                HSK (Hanyu Shuiping Kaoshi) - это стандартизированный экзамен по китайскому языку 
                для не носителей. Он состоит из 6 уровней, где HSK 1 - самый простой, 
                а HSK 6 - самый сложный. Каждый уровень включает определенное количество слов 
                и грамматических конструкций, необходимых для общения на соответствующем уровне.
            </p>
            <p class="info-tip">
                <strong>Совет:</strong> Рекомендуется начинать с HSK 1, даже если у вас уже есть 
                некоторые знания. Это поможет систематизировать обучение и заполнить пробелы.
            </p>
        </div>
   
        

        <section class="select-level-collections" aria-labelledby="select-level-collections-heading">
            <div class="select-level-collections-header">
                <h2 id="select-level-collections-heading" class="select-level-collections-title">Тематические подборки</h2>
              
            </div>
            <div class="select-level-collections-grid">
                @forelse ($builtinCollections as $collection)
                    @php
                        $cTotal = $collection->select_level_total ?? (int) $collection->characters_count;
                        $cLearned = $collection->select_level_learned ?? 0;
                        $cProgress = $collection->select_level_progress ?? 0;
                        $cRemaining = max(0, $cTotal - $cLearned);
                    @endphp
                    <a href="{{ route('learning.collection.level', $collection) }}" class="hsk-card">
                        <div class="hsk-card-header">
                            <div class="hsk-title">{{ $collection->name }}</div>
                            <div class="hsk-count">{{ $cLearned }}/{{ $cTotal }}</div>
                        </div>

                        <div class="hsk-description">
                            Тематическая подборка из {{ $cTotal }} иероглифов. Можно проходить параллельно с уровнями HSK.
                        </div>

                        <div class="progress-container">
                            <div class="progress-header">
                                <span class="progress-label">Ваш прогресс</span>
                                <span class="progress-percent">{{ $cProgress }}%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: {{ $cProgress }}%"></div>
                            </div>
                        </div>

                        <div class="hsk-stats">
                            <div class="stat">
                                <span class="stat-value">{{ $cTotal }}</span>
                                <span class="stat-label">Всего</span>
                            </div>
                            <div class="stat">
                                <span class="stat-value">{{ $cLearned }}</span>
                                <span class="stat-label">Выучено</span>
                            </div>
                            <div class="stat">
                                <span class="stat-value">{{ $cRemaining }}</span>
                                <span class="stat-label">Осталось</span>
                            </div>
                        </div>

                        <div class="hsk-actions">
                            <span class="action-btn learn-btn">Изучать</span>
                        </div>
                    </a>
                @empty
                    <p class="select-level-collections-empty">
                        Встроенные подборки ещё не созданы для вашего аккаунта. Администратор может выполнить команду
                        <code>php artisan collections:sync-builtin</code>
                        или зарегистрируйтесь заново после обновления приложения.
                    </p>
                @endforelse
            </div>
            <div class="select-level-collections-footer">
                <a href="{{ route('collections.index') }}" class="select-level-collections-all-link">Все мои коллекции →</a>
            </div>
        </section>
  
        </div>
    </div>

</x-app-layout>