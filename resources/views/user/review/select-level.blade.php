<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Повторение - Выбор уровня - KanjiFlow</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            min-height: 100vh;
            color: white;
        }
        
        .review-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 40px;
            padding-top: 40px;
        }
        
        .back-link {
            position: absolute;
            top: 20px;
            left: 20px;
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            backdrop-filter: blur(10px);
            transition: all 0.3s;
        }
        
        .back-link:hover {
            background: rgba(255,255,255,0.3);
            transform: translateX(-5px);
        }
        
        h1 {
            font-size: 3.5rem;
            margin-bottom: 15px;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        
        .subtitle {
            font-size: 1.3rem;
            opacity: 0.9;
            max-width: 800px;
            margin: 0 auto 30px;
            line-height: 1.5;
        }
        
        /* Быстрый старт */
        .quick-start {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 40px;
            text-align: center;
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .quick-start h2 {
            font-size: 1.8rem;
            margin-bottom: 20px;
        }
        
        .quick-actions {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        
        .quick-btn {
            background: white;
            color: #10b981;
            padding: 18px 35px;
            border-radius: 15px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .quick-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        
        /* Сетка уровней */
        .levels-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }
        
        .level-card {
            background: rgba(255,255,255,0.95);
            border-radius: 20px;
            padding: 30px;
            color: #1f2937;
            transition: all 0.4s;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 3px solid transparent;
            position: relative;
            overflow: hidden;
        }
        
        .level-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            border-color: #10b981;
        }
        
        .level-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 0 0 0 60px;
        }
        
        .level-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .level-title {
            font-size: 2rem;
            font-weight: 800;
            color: #1f2937;
        }
        
        .level-count {
            background: #10b981;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 1.1rem;
        }
        
        .level-description {
            color: #6b7280;
            margin-bottom: 25px;
            line-height: 1.5;
            min-height: 60px;
        }
        
        /* Прогресс */
        .progress-section {
            margin-bottom: 25px;
        }
        
        .progress-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 0.95rem;
            color: #6b7280;
        }
        
        .progress-bar {
            height: 10px;
            background: #e5e7eb;
            border-radius: 5px;
            overflow: hidden;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #10b981 0%, #34d399 100%);
            border-radius: 5px;
            transition: width 1s ease;
        }
        
        /* Статистика */
        .level-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 25px;
            text-align: center;
        }
        
        .level-stat {
            padding: 15px;
            background: #f9fafb;
            border-radius: 10px;
        }
        
        .stat-value {
            display: block;
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 0.85rem;
            color: #6b7280;
        }
        
        /* Действия */
        .level-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        
        .level-btn {
            padding: 14px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            text-align: center;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }
        
        .review-btn {
            background: #10b981;
            color: white;
        }
        
        .review-btn:hover {
            background: #059669;
        }
        
        .learn-btn {
            background: #3b82f6;
            color: white;
        }
        
        .learn-btn:hover {
            background: #2563eb;
        }
        
        /* Общая статистика */
        .overall-stats {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            margin-top: 40px;
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .overall-stats h2 {
            font-size: 1.8rem;
            margin-bottom: 25px;
            text-align: center;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        
        .overall-stat {
            text-align: center;
            padding: 20px;
            background: rgba(255,255,255,0.05);
            border-radius: 15px;
            border: 1px solid rgba(255,255,255,0.1);
        }
        
        .overall-stat-value {
            display: block;
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 10px;
        }
        
        .overall-stat-label {
            font-size: 1rem;
            opacity: 0.9;
        }
        
        /* Адаптивность */
        @media (max-width: 768px) {
            h1 {
                font-size: 2.5rem;
            }
            
            .levels-grid {
                grid-template-columns: 1fr;
            }
            
            .quick-actions {
                flex-direction: column;
            }
            
            .quick-btn {
                justify-content: center;
            }
            
            .level-card {
                padding: 25px;
            }
            
            .level-title {
                font-size: 1.8rem;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 480px) {
            h1 {
                font-size: 2rem;
            }
            
            .level-stats {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .level-actions {
                grid-template-columns: 1fr;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .back-link {
                position: static;
                display: inline-block;
                margin-bottom: 20px;
            }
            
            .header {
                padding-top: 0;
            }
        }
    </style>
</head>
<body>
    <div class="review-container">
        <!-- Навигация -->
        <a href="{{ route('dashboard') }}" class="back-link">← Назад в дашборд</a>
        
        <!-- Заголовок -->
        <div class="header">
            <h1>Повторение иероглифов</h1>
            <p class="subtitle">
                Повторяйте иероглифы с помощью системы интервальных повторений (SRS). 
                Выберите уровень HSK или начните общее повторение.
            </p>
        </div>
        
        <!-- Быстрый старт -->
        <div class="quick-start">
            <h2>Быстрый старт</h2>
            <div class="quick-actions">
                <a href="{{ route('review.show') }}" class="quick-btn">
                    Общее повторение
                    @if($dueCardsCount ?? 0 > 0)
                        <span style="background: #10b981; color: white; padding: 4px 12px; border-radius: 12px; font-size: 0.9rem;">
                            {{ $dueCardsCount ?? 0 }}
                        </span>
                    @endif
                </a>
                <a href="{{ route('review.random') }}" class="quick-btn">
                    Случайные иероглифы
                </a>
                <a href="{{ route('collections.index') }}" class="quick-btn">
                    Повторить коллекции
                </a>
            </div>
        </div>
        
        <!-- Сетка уровней -->
        <div class="levels-grid">
            @for($level = 1; $level <= 6; $level++)
                @php
                    $stats = $hskStats[$level] ?? [
                        'total' => 0,
                        'due' => 0,
                        'learned' => 0,
                        'progress' => 0
                    ];
                @endphp
                
                <div class="level-card">
                    <div class="level-header">
                        <div class="level-title">HSK {{ $level }}</div>
                        <div class="level-count">
                            {{ $stats['learned'] }}/{{ $stats['total'] }}
                        </div>
                    </div>
                    
                    <div class="level-description">
                        @if($level == 1)
                            150 базовых иероглифов для начинающих
                        @elseif($level == 2)
                            Элементарное общение - 300 иероглифов
                        @elseif($level == 3)
                            Повседневное общение - 600 иероглифов
                        @elseif($level == 4)
                            Свободное общение - 1200 иероглифов
                        @elseif($level == 5)
                            Чтение СМИ - 2500 иероглифов
                        @elseif($level == 6)
                            Сложные тексты - 5000+ иероглифов
                        @endif
                    </div>
                    
                    <!-- Прогресс -->
                    <div class="progress-section">
                        <div class="progress-header">
                            <span>Прогресс изучения</span>
                            <span>{{ $stats['progress'] }}%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $stats['progress'] }}%"></div>
                        </div>
                    </div>
                    
                    <!-- Статистика -->
                    <div class="level-stats">
                        <div class="level-stat">
                            <span class="stat-value">{{ $stats['total'] }}</span>
                            <span class="stat-label">Всего</span>
                        </div>
                        <div class="level-stat">
                            <span class="stat-value">{{ $stats['learned'] }}</span>
                            <span class="stat-label">Выучено</span>
                        </div>
                        <div class="level-stat">
                            <span class="stat-value">{{ $stats['due'] }}</span>
                            <span class="stat-label">Для повторения</span>
                        </div>
                    </div>
                    
                    <!-- Действия -->
                    <div class="level-actions">
                        <a href="{{ route('review.hsk', $level) }}" class="level-btn review-btn">
                            🔄 Повторить
                            @if($stats['due'] > 0)
                                ({{ $stats['due'] }})
                            @endif
                        </a>
                        <a href="{{ route('learning.level', $level) }}" class="level-btn learn-btn">
                            📚 Изучать
                        </a>
                    </div>
                </div>
            @endfor
        </div>
        
        <!-- Общая статистика -->
        @php
            $totalLearned = array_sum(array_column($hskStats, 'learned'));
            $totalDue = array_sum(array_column($hskStats, 'due'));
            $totalCards = array_sum(array_column($hskStats, 'total'));
            $totalProgress = $totalCards > 0 ? round(($totalLearned / $totalCards) * 100) : 0;
        @endphp
        
        <div class="overall-stats">
            <h2>Общая статистика повторений</h2>
            <div class="stats-grid">
                <div class="overall-stat">
                    <span class="overall-stat-value">{{ $totalCards }}</span>
                    <span class="overall-stat-label">Всего иероглифов</span>
                </div>
                <div class="overall-stat">
                    <span class="overall-stat-value">{{ $totalLearned }}</span>
                    <span class="overall-stat-label">Выучено всего</span>
                </div>
                <div class="overall-stat">
                    <span class="overall-stat-value">{{ $totalDue }}</span>
                    <span class="overall-stat-label">Для повторения</span>
                </div>
                <div class="overall-stat">
                    <span class="overall-stat-value">{{ $totalProgress }}%</span>
                    <span class="overall-stat-label">Общий прогресс</span>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Анимация прогресс-баров
        document.addEventListener('DOMContentLoaded', function() {
            const progressBars = document.querySelectorAll('.progress-fill');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0';
                setTimeout(() => {
                    bar.style.transition = 'width 1s ease';
                    bar.style.width = width;
                }, 300);
            });
            
            // Анимация появления карточек
            const cards = document.querySelectorAll('.level-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>