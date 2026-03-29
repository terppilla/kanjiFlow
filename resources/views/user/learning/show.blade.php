<x-app-layout>
    <style>
        /* Переменные цветов в стиле сайта */
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
            --color-bg: #f5f7fa;
        }

        /* Основные стили */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--color-bg);
            color: var(--color-calm-blue);
        }

        /* Контейнер */
        .learning-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            min-height: 100vh;
        }

        /* Навигационная панель */
        .nav-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--color-dark-blue);
            padding: 1rem 1.5rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-left: 4px solid var(--color-primary);
        }

        .nav-btn {
            padding: 0.5rem 1rem;
            background: var(--color-white-gold);
            color: var(--color-dark-red);
            text-decoration: none;
            border-radius: 6px;
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

        .nav-center {
            text-align: center;
            color: white;
        }

        .nav-title {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
            letter-spacing: 0.5px;
        }

        .nav-subtitle {
            font-size: 0.85rem;
            opacity: 0.9;
            color: var(--color-white-gold);
        }

        /* Прогресс уровня */
        .level-progress {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            border: 1px solid rgba(214, 155, 100, 0.1);
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .progress-title {
            font-weight: 600;
            color: var(--color-dark-blue);
            font-size: 1.1rem;
        }

        .progress-header > div:last-child {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--color-primary);
        }

        .progress-bar {
            height: 8px;
            background: #e5e7eb;
            border-radius: 4px;
            margin-bottom: 1rem;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--color-primary), var(--color-gold));
            border-radius: 4px;
            transition: width 0.6s ease;
        }

        .progress-stats {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            color: var(--color-gray);
            padding-top: 0.5rem;
            border-top: 1px solid rgba(214, 155, 100, 0.1);
        }

        /* Карточка иероглифа */
        .character-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            border: 1px solid rgba(214, 155, 100, 0.15);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .character-display {
            text-align: center;
            padding: 2rem;
            background: rgba(243, 202, 165, 0.05);
            border-radius: 10px;
            margin-bottom: 1.5rem;
            border: 1px dashed rgba(214, 155, 100, 0.2);
        }

        .character-char {
            font-family: 'Noto Serif SC', serif;
            font-size: 5rem;
            color: var(--color-dark-red);
            margin-bottom: 1rem;
            font-weight: 600;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        .character-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
            margin: 1.5rem 0;
        }

        .info-item {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid rgba(214, 155, 100, 0.1);
            transition: transform 0.2s ease;
        }

        .info-item:hover {
            transform: translateY(-2px);
            border-color: var(--color-gold);
        }

        .info-label {
            display: block;
            color: var(--color-gray);
            font-size: 0.8rem;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            display: block;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .pinyin-value {
            color: var(--color-primary);
            font-style: italic;
            font-size: 1.2rem;
        }

        .audio-btn {
            padding: 0.75rem 1.5rem;
            background: var(--color-white-gold);
            color: var(--color-dark-red);
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            margin-top: 1rem;
            transition: all 0.2s ease;
            border: 1px solid rgba(214, 155, 100, 0.3);
            font-size: 0.9rem;
        }

        .audio-btn:hover {
            background: var(--color-gold);
            color: white;
            transform: translateY(-1px);
        }

        /* Пример использования */
        .example-section {
            background: rgba(31, 41, 51, 0.03);
            padding: 1.5rem;
            border-radius: 10px;
            margin: 1.5rem 0;
            border: 1px solid rgba(214, 155, 100, 0.1);
        }

        .example-title {
            font-weight: 600;
            color: var(--color-dark-blue);
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .example-content {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            border: 1px solid rgba(214, 155, 100, 0.1);
        }

        .example-hanzi {
            font-size: 1.5rem;
            color: var(--color-dark-red);
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .example-pinyin {
            color: var(--color-primary);
            font-style: italic;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }

        .example-translation {
            color: var(--color-calm-blue);
            line-height: 1.5;
            padding-top: 0.5rem;
            border-top: 1px solid rgba(214, 155, 100, 0.1);
        }

        /* Выбор режима */
        .mode-selector {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin: 2rem 0;
        }

        .mode-btn {
            padding: 1rem;
            background: white;
            border: 2px solid rgba(214, 155, 100, 0.2);
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
            font-size: 0.9rem;
        }

        .mode-btn:hover {
            border-color: var(--color-gold);
            transform: translateY(-2px);
        }

        .mode-btn.active {
            background: var(--color-primary);
            color: white;
            border-color: var(--color-primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(193, 18, 31, 0.2);
        }

        .mode-label {
            font-weight: 500;
        }

        /* Разделы ответов */
        .answer-section {
            margin: 2rem 0;
        }

        .answer-mode {
            display: none;
        }

        .answer-mode.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .question-text {
            font-size: 1.2rem;
            color: var(--color-dark-blue);
            margin-bottom: 1.5rem;
            text-align: center;
            font-weight: 600;
        }

        /* Режим ввода */
        .keyboard-input {
            display: flex;
            gap: 1rem;
            max-width: 600px;
            margin: 0 auto 1.5rem;
        }

        #textAnswer {
            flex: 1;
            padding: 1rem 1.25rem;
            border: 2px solid rgba(214, 155, 100, 0.3);
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.2s ease;
        }

        #textAnswer:focus {
            outline: none;
            border-color: var(--color-gold);
            box-shadow: 0 0 0 3px rgba(214, 155, 100, 0.1);
        }

        #textAnswer:disabled {
            background: rgba(192, 192, 192, 0.1);
            cursor: not-allowed;
        }

        #checkAnswerBtn {
            padding: 1rem 1.5rem;
            background: var(--color-primary);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s ease;
            min-width: 120px;
        }

        #checkAnswerBtn:hover:not(:disabled) {
            background: var(--color-dark-red);
            transform: translateY(-1px);
        }

        #checkAnswerBtn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        .hint-container {
            max-width: 600px;
            margin: 1rem auto;
            background: rgba(59, 130, 246, 0.05);
            padding: 1rem;
            border-radius: 6px;
            border: 1px solid rgba(59, 130, 246, 0.2);
            display: none;
        }

        .hint-message {
            color: #3b82f6;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
        }

        .hint-message:before {
            content: "💡";
            font-size: 1rem;
        }

        .attempts-counter {
            text-align: center;
            color: #f59e0b;
            font-weight: 500;
            margin: 1rem 0;
            display: none;
        }

        /* Режим просмотра */
        .answer-revealed {
            background: rgba(16, 185, 129, 0.05);
            padding: 2rem;
            border-radius: 10px;
            border: 1px solid rgba(16, 185, 129, 0.2);
            text-align: center;
        }

        .meaning-display {
            font-size: 2rem;
            color: var(--color-success);
            font-weight: 700;
            margin: 1rem 0;
            padding: 1rem;
            background: white;
            border-radius: 8px;
            border: 1px dashed rgba(16, 185, 129, 0.3);
        }

        .view-mode-hint {
            color: var(--color-gray);
            font-size: 0.95rem;
            margin-top: 1rem;
        }

        /* Режим выбора */
        .options-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            max-width: 700px;
            margin: 0 auto 1.5rem;
        }

        .option-btn {
            padding: 1.5rem;
            background: white;
            border: 2px solid rgba(214, 155, 100, 0.2);
            border-radius: 10px;
            cursor: pointer;
            text-align: left;
            transition: all 0.2s ease;
            position: relative;
        }

        .option-btn:hover:not(:disabled) {
            border-color: var(--color-gold);
            transform: translateY(-2px);
        }

        .option-btn.correct {
            background: rgba(16, 185, 129, 0.1);
            border-color: var(--color-success);
            color: var(--color-success);
        }

        .option-btn.incorrect {
            background: rgba(239, 68, 68, 0.1);
            border-color: #ef4444;
            color: #ef4444;
        }

        .option-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        .option-number {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            width: 24px;
            height: 24px;
            background: rgba(214, 155, 100, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--color-calm-blue);
        }

        .option-text {
            font-size: 1.1rem;
            font-weight: 500;
            margin-right: 2rem;
            line-height: 1.4;
        }

        .option-pinyin {
            color: var(--color-gray);
            font-style: italic;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }

        .loading-options {
            text-align: center;
            padding: 2rem;
            grid-column: 1 / -1;
            color: var(--color-gray);
        }

        .loading-error {
            text-align: center;
            padding: 1.5rem;
            background: rgba(239, 68, 68, 0.05);
            border-radius: 8px;
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #ef4444;
            font-size: 0.9rem;
        }

        /* Навигация по иероглифам */
        .character-navigation {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(214, 155, 100, 0.1);
        }

        .nav-char-btn {
            padding: 1rem;
            background: var(--color-white-gold);
            color: var(--color-dark-red);
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            text-align: center;
            border: 1px solid rgba(214, 155, 100, 0.3);
            transition: all 0.2s ease;
            font-size: 0.9rem;
        }

        .nav-char-btn:hover:not(.disabled) {
            background: var(--color-gold);
            color: white;
            transform: translateY(-1px);
        }

        .nav-char-btn.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            background: #f3f4f6;
            color: var(--color-gray);
        }

        .try-again-btn {
            grid-column: 1 / -1;
            padding: 1rem;
            background: var(--color-white-gold);
            color: var(--color-dark-red);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s ease;
            margin-top: 0.5rem;
            font-size: 0.9rem;
        }

        .try-again-btn:hover {
            background: var(--color-gold);
            color: white;
            transform: translateY(-1px);
        }

        /* Модальное окно */
        .result-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-content {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            border: 2px solid var(--color-gold);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(214, 155, 100, 0.2);
        }

        .modal-header h3 {
            font-size: 1.5rem;
            color: var(--color-dark-blue);
            font-weight: 700;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--color-gray);
            cursor: pointer;
            transition: color 0.2s ease;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .modal-close:hover {
            color: var(--color-primary);
            background: rgba(193, 18, 31, 0.1);
        }

        .modal-body {
            text-align: center;
            padding: 1rem 0;
        }

        .result-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .result-message {
            font-size: 1.1rem;
            color: var(--color-calm-blue);
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        .correct-answer-card {
            background: rgba(16, 185, 129, 0.05);
            padding: 1.5rem;
            border-radius: 8px;
            margin: 1rem 0;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .answer-row {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(16, 185, 129, 0.1);
        }

        .answer-row:last-child {
            border-bottom: none;
        }

        .answer-label {
            color: var(--color-success);
            font-weight: 500;
            min-width: 100px;
            text-align: left;
        }

        .answer-value {
            color: var(--color-calm-blue);
            font-weight: 500;
            text-align: right;
            flex: 1;
            padding-left: 1rem;
        }

        .modal-footer {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(214, 155, 100, 0.2);
        }

        .modal-btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s ease;
            min-width: 120px;
            font-size: 0.9rem;
        }

        .modal-btn-secondary {
            background: rgba(192, 192, 192, 0.1);
            color: var(--color-calm-blue);
            border: 1px solid rgba(192, 192, 192, 0.3);
        }

        .modal-btn-secondary:hover {
            background: var(--color-gray);
            color: white;
        }

        .modal-btn-primary {
            background: var(--color-primary);
            color: white;
            border: 1px solid var(--color-primary);
        }

        .modal-btn-primary:hover {
            background: var(--color-dark-red);
            transform: translateY(-1px);
        }

        /* Уведомления */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 1rem 1.25rem;
            border-radius: 8px;
            color: white;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            z-index: 1001;
            min-width: 300px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        .notification.info {
            background: #3b82f6;
        }

        .notification.success {
            background: var(--color-success);
        }

        .notification.warning {
            background: #f59e0b;
        }

        .notification.error {
            background: #ef4444;
        }

        .notification button {
            background: none;
            border: none;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            opacity: 0.8;
            transition: opacity 0.2s ease;
        }

        .notification button:hover {
            opacity: 1;
        }

        /* Адаптивность */
        @media (max-width: 768px) {
            .nav-bar {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
                padding: 1rem;
            }
            
            .nav-btn {
                width: 100%;
            }
            
            .character-char {
                font-size: 4rem;
            }
            
            .character-info {
                grid-template-columns: 1fr;
            }
            
            .mode-selector {
                grid-template-columns: 1fr;
            }
            
            .keyboard-input {
                flex-direction: column;
            }
            
            .options-grid {
                grid-template-columns: 1fr;
            }
            
            .character-navigation {
                grid-template-columns: 1fr;
            }
            
            .modal-content {
                padding: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .learning-container {
                padding: 1rem;
            }
            
            .character-card {
                padding: 1.5rem;
            }
            
            .character-display {
                padding: 1.5rem;
            }
            
            .character-char {
                font-size: 3rem;
            }
            
            .modal-content {
                padding: 1.25rem;
                width: 95%;
            }
            
            .modal-footer {
                flex-direction: column;
            }
            
            .modal-btn {
                width: 100%;
            }
            
            .notification {
                left: 1rem;
                right: 1rem;
                width: auto;
            }
        }
    </style>

    <div class="learning-container">
        <div class="nav-bar">
            <a href="{{ route('learning.level', $character->hsk_level) }}" class="nav-btn">
                ← Назад к списку
            </a>
            
            <div class="nav-center">
                <div class="nav-title">HSK {{ $character->hsk_level }}</div>
                <div class="nav-subtitle">Изучение иероглифов</div>
            </div>
            
            <a href="{{ route('dashboard') }}" class="nav-btn">
                Дашборд
            </a>
        </div>
        
        <div class="level-progress">
            <div class="progress-header">
                <div class="progress-title">Прогресс уровня HSK {{ $character->hsk_level }}</div>
                <div>{{ $progress }}%</div>
            </div>
            <div class="progress-bar">
                <div class="progress-fill" style="width: {{ $progress }}%"></div>
            </div>
            <div class="progress-stats">
                <span>Выучено: {{ $learnedCount }}/{{ $totalInLevel }}</span>
                <span>Текущий иероглиф: {{ $character->id }}</span>
            </div>
        </div>
        
        <div class="character-card">
            <div class="character-display">
                <div class="character-char">{{ $character->character }}</div>
                
                <div class="character-info">
                    <div class="info-item">
                        <span class="info-label">Пиньинь</span>
                        <span class="info-value pinyin-value">{{ $character->pinyin }}</span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Уровень</span>
                        <span class="info-value">HSK {{ $character->hsk_level }}</span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Номер</span>
                        <span class="info-value">#{{ $character->id }}</span>
                    </div>
                </div>
                
                @if($character->audio_character)
                    <button class="audio-btn" onclick="playAudio('{{ $character->audio_character }}')">
                        🔊 Произношение
                    </button>
                @endif
            </div>
            
            @if($character->example_hanzi)
                <div class="example-section">
                    <div class="example-title">Пример использования:</div>
                    <div class="example-content">
                        <div class="example-hanzi">{{ $character->example_hanzi }}</div>
                        <div class="example-pinyin">{{ $character->example_pinyin }}</div>
                        <div class="example-translation">{{ $character->example_translation }}</div>
                        
                        @if($character->audio_example)
                            <button class="audio-btn" onclick="playAudio('{{ $character->audio_example }}')">
                                🔊 Прослушать пример
                            </button>
                        @endif
                    </div>
                </div>
            @endif
            
            <div class="mode-selector">
                <button class="mode-btn {{ $mode == 'keyboard' ? 'active' : '' }}" 
                        data-mode="keyboard" onclick="setMode('keyboard')">
                    <span class="mode-label">Режим ввода</span>
                </button>
                
                <button class="mode-btn {{ $mode == 'eye' ? 'active' : '' }}" 
                        data-mode="eye" onclick="setMode('eye')">
                    <span class="mode-label">Режим просмотра</span>
                </button>
                
                <button class="mode-btn {{ $mode == 'multiple' ? 'active' : '' }}" 
                        data-mode="multiple" onclick="setMode('multiple')">
                    <span class="mode-label">Выбор варианта</span>
                </button>
            </div>
           
            <div class="answer-section">
                <div class="answer-mode {{ $mode == 'keyboard' ? 'active' : '' }}" id="keyboardMode">
                    <div class="question-text">Введите перевод этого иероглифа:</div>
                    
                    <div class="keyboard-input">
                        <input type="text" 
                               id="textAnswer" 
                               placeholder="Введите значение на русском..."
                               autocomplete="off"
                               autofocus>
                        <button id="checkAnswerBtn" onclick="checkKeyboardAnswer()">
                            Проверить
                        </button>
                    </div>
                    
                    <div class="hint-container" id="hintContainer"></div>
                    <div class="attempts-counter" id="attemptsCounter" style="display: none;">
                        Осталось попыток: <span id="attemptsLeft">3</span>
                    </div>
                </div>
                
                <div class="answer-mode {{ $mode == 'eye' ? 'active' : '' }}" id="eyeMode">
                    <div class="answer-revealed">
                        <div class="question-text">Значение иероглифа:</div>
                        <div class="meaning-display">{{ $character->meaning }}</div>
                        <p class="view-mode-hint">
                            Прочитайте значение и постарайтесь запомнить его
                        </p>
                    </div>
                </div>
                
                <div class="answer-mode {{ $mode == 'multiple' ? 'active' : '' }}" id="multipleMode">
                    <div class="question-text">Выберите правильный перевод:</div>
                    
                    <div class="options-grid" id="optionsGrid">
                        <div class="loading-options">
                            Загрузка вариантов...
                        </div>
                    </div>
                    
                    <div class="attempts-counter" id="multipleAttemptsCounter" style="display: none;">
                        Осталось попыток: <span id="multipleAttemptsLeft">3</span>
                    </div>
                </div>
            </div>
            
            <div class="character-navigation">
                @if($prevCharacter)
                    <a href="{{ route('learning.show', ['character' => $prevCharacter, 'mode' => $mode]) }}" 
                       class="nav-char-btn">
                        ← Предыдущий иероглиф
                    </a>
                @else
                    <span class="nav-char-btn disabled">← Начало уровня</span>
                @endif
                
                @if($nextCharacter)
                    <a href="{{ route('learning.show', ['character' => $nextCharacter, 'mode' => $mode]) }}" 
                       class="nav-char-btn">
                        Следующий иероглиф →
                    </a>
                @else
                    <span class="nav-char-btn disabled">Конец уровня →</span>
                @endif
                
                <button onclick="resetAnswerState()" class="try-again-btn">
                    ↻ Попробовать снова
                </button>
            </div>
        </div>
    </div>

    <div class="result-modal" id="resultModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="resultTitle">Результат</h3>
                <button class="modal-close" onclick="closeResultModal()">×</button>
            </div>
            
            <div class="modal-body">
                <div class="result-icon" id="resultIcon"></div>
                <div class="result-message" id="resultMessage"></div>
                
                <div class="correct-answer-card" id="correctAnswerCard" style="display: none;">
                    <div class="answer-row">
                        <span class="answer-label">Иероглиф:</span>
                        <span class="answer-value">{{ $character->character }}</span>
                    </div>
                    <div class="answer-row">
                        <span class="answer-label">Пиньинь:</span>
                        <span class="answer-value">{{ $character->pinyin }}</span>
                    </div>
                    <div class="answer-row">
                        <span class="answer-label">Значение:</span>
                        <span class="answer-value">{{ $character->meaning }}</span>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button class="modal-btn modal-btn-secondary" onclick="closeResultModal()">
                    Закрыть
                </button>
                @if($nextCharacter)
                    <button class="modal-btn modal-btn-primary" onclick="goToNextCharacter()">
                        Следующий иероглиф
                    </button>
                @endif
            </div>
        </div>
    </div>
    
    <script>
        
        document.addEventListener('DOMContentLoaded', function() {
            const progressBars = document.querySelectorAll('.progress-fill');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0';
                setTimeout(() => {
                    bar.style.transition = 'width 1.2s cubic-bezier(0.34, 1.56, 0.64, 1)';
                    bar.style.width = width;
                }, 100);
            });
        });

        let currentMode = '{{ $mode }}';
        let attemptsLeft = 3;
        let multipleAttemptsLeft = 3;
        let hasAnswered = false;
        let correctAnswer = "{{ strtolower($character->meaning) }}";
        let characterId = {{ $character->id }};
        
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('resultModal').style.display = 'none';
            
            if (currentMode === 'multiple') {
                loadMultipleChoiceOptions();
            }
            
            setupEventListeners();
            
            if (currentMode === 'keyboard') {
                document.getElementById('textAnswer').focus();
            }
        });
        
        function playAudio(url) {
            try {
                const audio = new Audio(url);
                audio.play();
            } catch (error) {
                console.log('Ошибка воспроизведения:', error);
            }
        }
        
        function setMode(mode) {
            currentMode = mode;
            
            const url = new URL(window.location.href);
            url.searchParams.set('mode', mode);
            window.history.replaceState({}, '', url);
            
            document.querySelectorAll('.answer-mode').forEach(el => {
                el.classList.remove('active');
            });
            document.querySelectorAll('.mode-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            document.getElementById(mode + 'Mode').classList.add('active');
            document.querySelector(`[data-mode="${mode}"]`).classList.add('active');
            
            resetAnswerState();
            
            if (mode === 'multiple') {
                loadMultipleChoiceOptions();
            } else if (mode === 'keyboard') {
                document.getElementById('textAnswer').focus();
            }
        }
        
        async function loadMultipleChoiceOptions() {
            try {
                const response = await fetch(`/learn/character/${characterId}/options`);
                const data = await response.json();
                
                if (data.success) {
                    const optionsGrid = document.getElementById('optionsGrid');
                    optionsGrid.innerHTML = '';
                    
                    data.options.forEach((option, index) => {
                        const button = document.createElement('button');
                        button.className = 'option-btn';
                        button.innerHTML = `
                            <div class="option-number">${index + 1}</div>
                            <div class="option-text">${option.meaning}</div>
                            ${option.pinyin ? `<div class="option-pinyin">${option.pinyin}</div>` : ''}
                        `;
                        button.dataset.optionId = option.id;
                        button.dataset.isCorrect = option.is_correct;
                        
                        button.addEventListener('click', () => checkMultipleChoiceAnswer(button));
                        
                        optionsGrid.appendChild(button);
                    });
                }
            } catch (error) {
                console.error('Ошибка загрузки вариантов:', error);
                document.getElementById('optionsGrid').innerHTML = 
                    '<div class="loading-error">Не удалось загрузить варианты. Пожалуйста, попробуйте снова.</div>';
            }
        }
        
        function setupEventListeners() {
            document.getElementById('textAnswer')?.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    checkKeyboardAnswer();
                }
            });
        }
        
        function checkKeyboardAnswer() {
            const userAnswer = document.getElementById('textAnswer').value.trim().toLowerCase();
            const hintContainer = document.getElementById('hintContainer');
            const attemptsCounter = document.getElementById('attemptsCounter');
            const attemptsLeftSpan = document.getElementById('attemptsLeft');
            
            if (!userAnswer) {
                showNotification('Пожалуйста, введите ответ', 'warning');
                return;
            }
            
            hasAnswered = true;
            const isCorrect = validateAnswer(userAnswer, correctAnswer);
            
            if (isCorrect) {
                showResultModal(true);
                document.getElementById('textAnswer').disabled = true;
                document.getElementById('checkAnswerBtn').disabled = true;
            } else {
                attemptsLeft--;
                attemptsLeftSpan.textContent = attemptsLeft;
                attemptsCounter.style.display = 'block';
                
                if (attemptsLeft > 0) {
                    const hint = generateHint(userAnswer);
                    if (hint) {
                        hintContainer.innerHTML = `<div class="hint-message">${hint}</div>`;
                        hintContainer.style.display = 'block';
                    }
                }
                
                if (attemptsLeft <= 0) {
                    showResultModal(false);
                    document.getElementById('textAnswer').disabled = true;
                    document.getElementById('checkAnswerBtn').disabled = true;
                }
            }
        }
        
        function checkMultipleChoiceAnswer(button) {
            const isCorrect = button.dataset.isCorrect === 'true';
            const attemptsCounter = document.getElementById('multipleAttemptsCounter');
            const attemptsLeftSpan = document.getElementById('multipleAttemptsLeft');
            
            hasAnswered = true;
            
            if (isCorrect) {
                button.classList.add('correct');
                showResultModal(true);
                disableAllOptions();
            } else {
                button.classList.add('incorrect');
                multipleAttemptsLeft--;
                attemptsLeftSpan.textContent = multipleAttemptsLeft;
                attemptsCounter.style.display = 'block';
                
                if (multipleAttemptsLeft <= 0) {
                    showResultModal(false);
                    disableAllOptions();
                }
            }
        }
        
        function disableAllOptions() {
            document.querySelectorAll('.option-btn').forEach(btn => {
                btn.disabled = true;
                if (btn.dataset.isCorrect === 'true') {
                    btn.classList.add('correct');
                }
            });
        }
        
        function validateAnswer(userAnswer, correctAnswer) {
            const correctParts = correctAnswer.split(';').map(part => part.trim().toLowerCase());
            
            if (correctParts.includes(userAnswer)) {
                return true;
            }
            
            for (const part of correctParts) {
                if (part.includes(userAnswer) || userAnswer.includes(part)) {
                    return true;
                }
            }
            
            return false;
        }
        
        function generateHint(userAnswer) {
            const hints = [];
            const firstLetter = correctAnswer.charAt(0);
            
            if (!userAnswer.startsWith(firstLetter.toLowerCase())) {
                hints.push(`Начинается с "${firstLetter}"`);
            }
            
            const wordCount = correctAnswer.split(' ').length;
            if (wordCount > 1 && userAnswer.split(' ').length < wordCount) {
                hints.push(`Состоит из ${wordCount} слов`);
            }
            
            if (correctAnswer.includes(';')) {
                const synonyms = correctAnswer.split(';');
                if (synonyms.length > 1) {
                    hints.push(`Также может означать: ${synonyms[1].trim()}`);
                }
            }
            
            return hints.length > 0 ? hints[0] : null;
        }
        
        function resetAnswerState() {
            attemptsLeft = 3;
            multipleAttemptsLeft = 3;
            hasAnswered = false;
            
            const textInput = document.getElementById('textAnswer');
            if (textInput) {
                textInput.value = '';
                textInput.disabled = false;
                textInput.focus();
            }
            
            const checkBtn = document.getElementById('checkAnswerBtn');
            if (checkBtn) {
                checkBtn.disabled = false;
            }
            
            document.getElementById('attemptsCounter').style.display = 'none';
            document.getElementById('multipleAttemptsCounter').style.display = 'none';
            document.getElementById('hintContainer').style.display = 'none';
            document.getElementById('hintContainer').innerHTML = '';
            
            if (currentMode === 'multiple') {
                document.querySelectorAll('.option-btn').forEach(btn => {
                    btn.disabled = false;
                    btn.classList.remove('correct', 'incorrect');
                });
            }
            
            closeResultModal();
        }
        
        function showResultModal(isCorrect) {
            const modal = document.getElementById('resultModal');
            const icon = document.getElementById('resultIcon');
            const title = document.getElementById('resultTitle');
            const message = document.getElementById('resultMessage');
            const answerCard = document.getElementById('correctAnswerCard');
            
            if (isCorrect) {
                icon.textContent = '✓';
                title.textContent = 'Правильно!';
                message.textContent = 'Вы правильно определили значение иероглифа.';
                answerCard.style.display = 'none';
            } else {
                icon.textContent = '✗';
                title.textContent = 'Попробуйте еще раз';
                message.textContent = 'Не совсем правильно. Вот правильный ответ:';
                answerCard.style.display = 'block';
            }
            
            modal.style.display = 'flex';
        }
        
        function closeResultModal() {
            document.getElementById('resultModal').style.display = 'none';
        }
        
        function goToNextCharacter() {
            @if($nextCharacter)
                window.location.href = "{{ route('learning.show', ['character' => $nextCharacter, 'mode' => $mode]) }}";
            @endif
        }
        
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = 'notification ' + type;
            notification.innerHTML = `
                <span>${message}</span>
                <button onclick="this.parentElement.remove()">×</button>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 3000);
        }
    </script>
</x-app-layout>