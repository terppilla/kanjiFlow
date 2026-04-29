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
            max-width: 900px;
            margin: 0 auto;
            padding: 12px 14px 24px;
            min-height: auto;
        }

        /* Навигационная панель */
        .nav-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--color-dark-blue);
            padding: 0.6rem 1rem;
            border-radius: 8px;
            margin-bottom: 0.85rem;
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
            font-size: 1.15rem;
            font-weight: 600;
            margin-bottom: 0.15rem;
            letter-spacing: 0.5px;
        }

        .nav-subtitle {
            font-size: 0.78rem;
            opacity: 0.9;
            color: var(--color-white-gold);
        }

        /* Прогресс уровня */
        .level-progress {
            background: white;
            padding: 0.85rem 1rem;
            border-radius: 8px;
            margin-bottom: 0.85rem;
            border: 1px solid rgba(214, 155, 100, 0.1);
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .progress-title {
            font-weight: 600;
            color: var(--color-dark-blue);
            font-size: 0.95rem;
        }

        .progress-header > div:last-child {
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--color-primary);
        }

        .progress-bar {
            height: 6px;
            background: #e5e7eb;
            border-radius: 4px;
            margin-bottom: 0.5rem;
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
            flex-wrap: wrap;
            gap: 0.35rem;
            font-size: 0.8rem;
            color: var(--color-gray);
            padding-top: 0.35rem;
            border-top: 1px solid rgba(214, 155, 100, 0.1);
        }

        /* Карточка иероглифа */
        .character-card {
            background: white;
            border-radius: 10px;
            padding: 1rem 1.1rem;
            border: 1px solid rgba(214, 155, 100, 0.15);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .character-display {
            text-align: center;
            padding: 0.75rem 1rem;
            background: rgba(243, 202, 165, 0.05);
            border-radius: 8px;
            margin-bottom: 0.65rem;
            border: 1px dashed rgba(214, 155, 100, 0.2);
        }

        .character-char {
            font-family: 'Noto Serif SC', serif;
            font-size: 3rem;
            color: var(--color-dark-red);
            margin-bottom: 0.4rem;
            font-weight: 600;
            line-height: 1.1;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.08);
        }

        .character-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.5rem;
            margin: 0.5rem 0 0;
        }

        .info-item {
            background: white;
            padding: 0.5rem 0.65rem;
            border-radius: 6px;
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
            font-size: 0.95rem;
            font-weight: 600;
        }

        .pinyin-value {
            color: var(--color-primary);
            font-style: italic;
            font-size: 1rem;
        }

        .audio-btn {
            background: transparent;
            padding: 0.45rem 0.85rem;
            cursor: pointer;
            font-weight: 500;
            margin-top: 0.5rem;
            transition: all 0.2s ease;
            font-size: 0.82rem;
        }

        .audio-icon {
            width: 30px;
            height: 30px;
        }

        .audio-btn:hover {
            transform: translateY(-1px);
        }

        /* Пример использования (после ответа) */
        .example-section {
            background: rgba(31, 41, 51, 0.03);
            padding: 0.85rem 1rem;
            border-radius: 8px;
            margin: 0.65rem 0;
            border: 1px solid rgba(214, 155, 100, 0.1);
        }

        .example-hidden {
            display: none !important;
        }

        .example-title {
            font-weight: 600;
            color: var(--color-dark-blue);
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .example-content {
            background: white;
            padding: 0.75rem 1rem;
            border-radius: 6px;
            border: 1px solid rgba(214, 155, 100, 0.1);
        }

        .example-hanzi {
            font-size: 1.2rem;
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
            gap: 0.5rem;
            margin: 0.65rem 0;
        }

        .mode-btn {
            padding: 0.55rem 0.5rem;
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
            margin: 0.65rem 0;
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
            font-size: 1rem;
            color: var(--color-dark-blue);
            margin-bottom: 0.65rem;
            text-align: center;
            font-weight: 600;
        }

        /* Режим ввода */
        .keyboard-input {
            display: flex;
            gap: 0.5rem;
            max-width: 560px;
            margin: 0 auto 0.65rem;
        }

        #textAnswer {
            flex: 1;
            padding: 0.55rem 0.75rem;
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
            padding: 0.55rem 1rem;
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
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid rgba(16, 185, 129, 0.2);
            text-align: center;
        }

        .meaning-display {
            font-size: 1.35rem;
            color: var(--color-success);
            font-weight: 700;
            margin: 0.5rem 0;
            padding: 0.65rem;
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
            gap: 0.5rem;
            max-width: 640px;
            margin: 0 auto 0.65rem;
        }

        .option-btn {
            padding: 0.65rem 0.85rem;
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
            gap: 0.5rem;
            margin-top: 0.85rem;
            padding-top: 0.85rem;
            border-top: 1px solid rgba(214, 155, 100, 0.1);
        }

        .nav-char-btn {
            padding: 0.6rem 0.75rem;
            background: var(--color-white-gold);
            color: var(--color-dark-red);
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            text-align: center;
            border: 1px solid rgba(214, 155, 100, 0.3);
            transition: all 0.2s ease;
            font-size: 0.85rem;
            font-family: inherit;
            cursor: pointer;
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

        .wrong-reveal {
            display: none;
            background: rgba(239, 68, 68, 0.06);
            border: 1px solid rgba(239, 68, 68, 0.28);
            border-radius: 10px;
            padding: 1.25rem 1.5rem;
            margin: 1rem 0;
            text-align: center;
        }

        .wrong-reveal.is-visible {
            display: block;
        }

        .wrong-reveal-title {
            font-weight: 600;
            color: #b91c1c;
            margin-bottom: 0.5rem;
        }

        .wrong-reveal-meaning {
            font-size: 1.15rem;
            color: var(--color-dark-blue);
            font-weight: 600;
        }

        .evaluation-section {
            display: none;
            margin-top: 0.85rem;
            padding-top: 0.85rem;
            border-top: 1px solid rgba(214, 155, 100, 0.15);
        }

        .evaluation-section.is-visible {
            display: block;
        }

        .evaluation-question {
            font-size: 1.1rem;
            color: var(--color-dark-blue);
            margin-bottom: 1rem;
            text-align: center;
            font-weight: 600;
        }

        .evaluation-note {
            font-size: 0.85rem;
            color: var(--color-gray);
            text-align: center;
            margin-bottom: 1rem;
            line-height: 1.45;
        }

        .evaluation-buttons {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.75rem;
        }

        .eval-btn {
            background: white;
            border: 2px solid rgba(214, 155, 100, 0.25);
            border-radius: 10px;
            padding: 0.85rem 1rem;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.35rem;
            min-width: 110px;
            transition: all 0.2s ease;
            font: inherit;
        }

        .eval-btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.08);
        }

        .eval-btn:disabled {
            opacity: 0.55;
            cursor: not-allowed;
        }

        .btn-again { border-color: #ef4444; }
        .btn-again:hover:not(:disabled) { background: #fef2f2; }
        .btn-hard { border-color: #f59e0b; }
        .btn-hard:hover:not(:disabled) { background: #fffbeb; }
        .btn-good { border-color: #10b981; }
        .btn-good:hover:not(:disabled) { background: #f0fdf4; }
        .btn-easy { border-color: #8b5cf6; }
        .btn-easy:hover:not(:disabled) { background: #f5f3ff; }

        .eval-label {
            font-weight: 600;
            color: var(--color-calm-blue);
            font-size: 0.9rem;
        }

        .practice-feedback {
            min-height: 1.25rem;
            text-align: center;
            color: var(--color-calm-blue);
            font-size: 0.95rem;
            margin: 0.5rem 0 0;
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

            .evaluation-buttons {
                flex-direction: column;
                align-items: stretch;
            }

            .eval-btn {
                width: 100%;
                max-width: 320px;
                margin: 0 auto;
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

            .notification {
                left: 1rem;
                right: 1rem;
                width: auto;
            }
        }
    </style>

    <div class="learning-container">
        <div class="nav-bar">
            
            
            <a href="{{ route('dashboard') }}" class="nav-btn">
                Дашборд
            </a>
        </div>
        
        <div class="level-progress">
            <div class="progress-header">
                <div class="progress-title" id="progressTitle">{{ $progressTitle }}</div>
                <div id="progressPercent">{{ $progress }}%</div>
            </div>
            <div class="progress-bar">
                <div class="progress-fill" id="progressFill" style="width: {{ $progress }}%"></div>
            </div>
            <div class="progress-stats">
                <span id="statPracticed">Пройдено в практике: {{ $practicedCount }}/{{ $totalInLevel }}</span>
                <span id="statLearned">Полностью выучено: {{ $learnedCount }}</span>
            </div>
        </div>
        
        <div class="character-card">
            <div class="character-display">
                <div class="character-char" id="charGlyph">{{ $character->character }}</div>
                
                <div class="character-info">
                    <div class="info-item">
                        <span class="info-label">Пиньинь</span>
                        <span class="info-value pinyin-value" id="charPinyin">{{ $character->pinyin }}</span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Уровень</span>
                        <span class="info-value" id="charHskLevel">HSK {{ $character->hsk_level }}</span>
                    </div>
                </div>
                
                <button type="button" class="audio-btn" id="audioCharacterBtn" 
                style="{{ $character->audio_character ? '' : 'display:none' }}" 
                data-audio-url="{{ $character->audio_character ?? '' }}">
                <img src="{{ asset('img/voice-icon.svg') }}" alt="Произношение" class="audio-icon">
            </button>
            </div>
            
            <div id="exampleRoot" class="@if(!$character->example_hanzi) example-hidden @endif">
                <div id="exampleSection" class="example-section example-hidden">
                    <div class="example-title">Пример использования:</div>
                    <div class="example-content">
                        <div class="example-hanzi" id="exHanzi">{{ $character->example_hanzi }}</div>
                        <div class="example-pinyin" id="exPinyin">{{ $character->example_pinyin }}</div>
                        <div class="example-translation" id="exTranslation">{{ $character->example_translation }}</div>
                        <button type="button" class="audio-btn" id="audioExampleBtn" 
                        style="{{ $character->audio_example ? '' : 'display:none' }}" 
                        data-audio-url="{{ $character->audio_example ?? '' }}">
                        <img src="{{ asset('img/voice-icon.svg') }}" alt="Произношение" class="audio-icon">
                    </button>
                    </div>
                </div>
            </div>

            <div id="wrongReveal" class="wrong-reveal" aria-live="polite">
                <div class="wrong-reveal-title">Правильное значение</div>
                <div class="wrong-reveal-meaning" id="wrongRevealMeaning">{{ $character->meaning }}</div>
            </div>
            
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
                        <div class="meaning-display" id="meaningDisplay">{{ $character->meaning }}</div>
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

            <div id="evaluationSection" class="evaluation-section">
                <div class="evaluation-question">Насколько было сложно вспомнить значение?</div>
                <p id="evaluationNote" class="evaluation-note" style="display: none;"></p>
                <div id="practiceFeedback" class="practice-feedback" role="status"></div>
                <div class="evaluation-buttons">
                    <button type="button" class="eval-btn btn-again" data-result="again" onclick="submitPracticeRating('again')">
                        <span class="eval-label">Снова</span>
                    </button>
                    <button type="button" class="eval-btn btn-hard" data-result="hard" onclick="submitPracticeRating('hard')">
                        <span class="eval-label">Сложно</span>
                    </button>
                    <button type="button" class="eval-btn btn-good" data-result="good" onclick="submitPracticeRating('good')">
                        <span class="eval-label">Нормально</span>
                    </button>
                    <button type="button" class="eval-btn btn-easy" data-result="easy" onclick="submitPracticeRating('easy')">
                        <span class="eval-label">Легко</span>
                    </button>
                </div>
            </div>
            
            <div class="character-navigation">
                <button type="button" class="nav-char-btn{{ $prevCharacter ? '' : ' disabled' }}" id="navPrevBtn"
                    @if($prevCharacter) data-character-id="{{ $prevCharacter->id }}" @else disabled @endif>
                    ← Предыдущий
                </button>
                <button type="button" class="nav-char-btn{{ $nextCharacter ? '' : ' disabled' }}" id="navNextBtn"
                    @if($nextCharacter) data-character-id="{{ $nextCharacter->id }}" @else disabled @endif>
                    Следующий →
                </button>
            </div>
        </div>
    </div>
    
    <script>
        const LEARN_BASE = @json(rtrim(url('/learn'), '/'));
        const csrfToken = @json(csrf_token());
        const learningCollectionId = @json($learningCollection !== null ? $learningCollection->id : null);

        let practiceUrl = @json(route('learning.practice', $character));

        function practiceUrlFor(id) {
            return LEARN_BASE + '/character/' + id + '/practice';
        }

        function panelUrlFor(id) {
            let url = LEARN_BASE + '/character/' + id + '/panel';
            if (learningCollectionId) {
                url += '?collection=' + encodeURIComponent(learningCollectionId);
            }
            return url;
        }

        function studyUrlForCharacter(id) {
            if (learningCollectionId) {
                return LEARN_BASE + '/collection/' + learningCollectionId + '/character/' + id;
            }
            return LEARN_BASE + '/character/' + id;
        }

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
        let correctAnswer = @json(strtolower($character->meaning));
        let characterId = {{ $character->id }};
        let lastKeyboardAnswer = '';
        let lastSelectedOptionId = null;
        let objectiveAnswerCorrect = true;
        let practiceLocked = false;
        let isLoadingCharacter = false;

        document.addEventListener('DOMContentLoaded', function() {
            history.replaceState({ characterId: characterId }, '', window.location.href);

            if (currentMode === 'multiple') {
                loadMultipleChoiceOptions();
            }

            setupEventListeners();
            wireNavHandlers();
            wireAudioButtons();

            if (currentMode === 'keyboard') {
                document.getElementById('textAnswer').focus();
            }
        });

        window.addEventListener('popstate', function() {
            const path = window.location.pathname;
            let m = path.match(/\/learn\/collection\/\d+\/character\/(\d+)/);
            if (!m) {
                m = path.match(/\/learn\/character\/(\d+)/);
            }
            if (!m) {
                return;
            }
            const id = parseInt(m[1], 10);
            const mode = new URLSearchParams(window.location.search).get('mode');
            if (['keyboard', 'eye', 'multiple'].includes(mode)) {
                currentMode = mode;
                document.querySelectorAll('.answer-mode').forEach(el => el.classList.remove('active'));
                document.querySelectorAll('.mode-btn').forEach(btn => btn.classList.remove('active'));
                const modeEl = document.getElementById(mode + 'Mode');
                if (modeEl) {
                    modeEl.classList.add('active');
                }
                document.querySelector('[data-mode="' + mode + '"]')?.classList.add('active');
            }
            loadCharacter(id, { pushState: false });
        });

        function wireNavHandlers() {
            const prevBtn = document.getElementById('navPrevBtn');
            const nextBtn = document.getElementById('navNextBtn');
            prevBtn.onclick = function() {
                const id = this.getAttribute('data-character-id');
                if (id) {
                    loadCharacter(parseInt(id, 10));
                }
            };
            nextBtn.onclick = function() {
                const id = this.getAttribute('data-character-id');
                if (id) {
                    loadCharacter(parseInt(id, 10));
                }
            };
        }

        function wireAudioButtons() {
            const ac = document.getElementById('audioCharacterBtn');
            const ax = document.getElementById('audioExampleBtn');
            ac.onclick = function() {
                const u = this.getAttribute('data-audio-url');
                if (u) {
                    playAudio(u);
                }
            };
            ax.onclick = function() {
                const u = this.getAttribute('data-audio-url');
                if (u) {
                    playAudio(u);
                }
            };
        }

        async function loadCharacter(id, opts = {}) {
            const pushState = opts.pushState !== false;
            if (isLoadingCharacter) {
                return false;
            }
            isLoadingCharacter = true;
            try {
                const res = await fetch(panelUrlFor(id), {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    credentials: 'same-origin',
                });
                const data = await res.json();
                if (!res.ok) {
                    throw new Error(data.message || 'Ошибка загрузки');
                }
                applyPanelData(data);
                if (pushState) {
                    const qs = new URLSearchParams({ mode: currentMode });
                    const path = studyUrlForCharacter(id) + '?' + qs.toString();
                    history.pushState({ characterId: id }, '', path);
                }
                window.scrollTo({ top: 0, behavior: 'smooth' });
                return true;
            } catch (e) {
                console.error(e);
                showNotification('Не удалось загрузить иероглиф.', 'error');
                return false;
            } finally {
                isLoadingCharacter = false;
            }
        }

        function applyPanelData(data) {
            const c = data.character;
            const st = data.stats;
            const nav = data.nav;

            characterId = c.id;
            correctAnswer = (c.meaning || '').toLowerCase();
            practiceUrl = practiceUrlFor(c.id);

            document.getElementById('charGlyph').textContent = c.glyph || '';
            document.getElementById('charPinyin').textContent = c.pinyin || '';
            document.getElementById('charHskLevel').textContent = 'HSK ' + c.hsk_level;
            document.getElementById('navHskTitle').textContent = st.nav_title || ('HSK ' + c.hsk_level);
            document.getElementById('meaningDisplay').textContent = c.meaning || '';
            document.getElementById('wrongRevealMeaning').textContent = c.meaning || '';

            document.getElementById('progressTitle').textContent = st.progress_title || ('Прогресс уровня HSK ' + st.hsk_level);
            document.getElementById('progressPercent').textContent = st.progress + '%';
            const fill = document.getElementById('progressFill');
            const w = st.progress + '%';
            fill.style.transition = 'none';
            fill.style.width = '0';
            requestAnimationFrame(function() {
                requestAnimationFrame(function() {
                    fill.style.transition = 'width 0.55s ease';
                    fill.style.width = w;
                });
            });

            document.getElementById('statPracticed').textContent =
                'Пройдено в практике: ' + st.practiced_count + '/' + st.total_in_level;
            document.getElementById('statLearned').textContent = 'Полностью выучено: ' + st.learned_count;

            const acBtn = document.getElementById('audioCharacterBtn');
            if (c.audio_character) {
                acBtn.style.display = '';
                acBtn.setAttribute('data-audio-url', c.audio_character);
            } else {
                acBtn.style.display = 'none';
                acBtn.setAttribute('data-audio-url', '');
            }

            const exRoot = document.getElementById('exampleRoot');
            const exSec = document.getElementById('exampleSection');
            if (c.has_example) {
                exRoot.classList.remove('example-hidden');
                exSec.classList.add('example-hidden');
                document.getElementById('exHanzi').textContent = c.example_hanzi || '';
                document.getElementById('exPinyin').textContent = c.example_pinyin || '';
                document.getElementById('exTranslation').textContent = c.example_translation || '';
                const exAud = document.getElementById('audioExampleBtn');
                if (c.audio_example) {
                    exAud.style.display = '';
                    exAud.setAttribute('data-audio-url', c.audio_example);
                } else {
                    exAud.style.display = 'none';
                    exAud.setAttribute('data-audio-url', '');
                }
            } else {
                exRoot.classList.add('example-hidden');
            }

            const prevBtn = document.getElementById('navPrevBtn');
            const nextBtn = document.getElementById('navNextBtn');
            if (nav.prev_id) {
                prevBtn.disabled = false;
                prevBtn.classList.remove('disabled');
                prevBtn.setAttribute('data-character-id', String(nav.prev_id));
            } else {
                prevBtn.disabled = true;
                prevBtn.classList.add('disabled');
                prevBtn.removeAttribute('data-character-id');
            }
            if (nav.next_id) {
                nextBtn.disabled = false;
                nextBtn.classList.remove('disabled');
                nextBtn.setAttribute('data-character-id', String(nav.next_id));
            } else {
                nextBtn.disabled = true;
                nextBtn.classList.add('disabled');
                nextBtn.removeAttribute('data-character-id');
            }

            resetAnswerState();
            wireNavHandlers();
            wireAudioButtons();

            if (currentMode === 'multiple') {
                loadMultipleChoiceOptions();
            } else if (currentMode === 'keyboard') {
                document.getElementById('textAnswer').focus();
            }
        }
        
        function playAudio(url) {
            try {
                const audio = new Audio(url);
                audio.play();
            } catch (error) {
                console.log('Ошибка воспроизведения:', error);
            }
        }
        
        function setMode(mode) {
            if (practiceLocked) {
                return;
            }

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
            const raw = document.getElementById('textAnswer').value.trim();
            const userAnswer = raw.toLowerCase();
            const hintContainer = document.getElementById('hintContainer');
            const attemptsCounter = document.getElementById('attemptsCounter');
            const attemptsLeftSpan = document.getElementById('attemptsLeft');

            if (!userAnswer) {
                showNotification('Пожалуйста, введите ответ', 'warning');
                return;
            }

            lastKeyboardAnswer = raw;
            const isCorrect = validateAnswer(userAnswer, correctAnswer);

            if (isCorrect) {
                objectiveAnswerCorrect = true;
                document.getElementById('textAnswer').disabled = true;
                document.getElementById('checkAnswerBtn').disabled = true;
                revealAfterAnswer(true);
            } else {
                objectiveAnswerCorrect = false;
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
                    document.getElementById('textAnswer').disabled = true;
                    document.getElementById('checkAnswerBtn').disabled = true;
                    revealAfterAnswer(false);
                }
            }
        }
        
        function checkMultipleChoiceAnswer(button) {
            const isCorrect = button.dataset.isCorrect === 'true';
            const attemptsCounter = document.getElementById('multipleAttemptsCounter');
            const attemptsLeftSpan = document.getElementById('multipleAttemptsLeft');

            lastSelectedOptionId = parseInt(button.dataset.optionId, 10);

            if (isCorrect) {
                objectiveAnswerCorrect = true;
                button.classList.add('correct');
                disableAllOptions();
                revealAfterAnswer(true);
            } else {
                objectiveAnswerCorrect = false;
                button.classList.add('incorrect');
                multipleAttemptsLeft--;
                attemptsLeftSpan.textContent = multipleAttemptsLeft;
                attemptsCounter.style.display = 'block';

                if (multipleAttemptsLeft <= 0) {
                    disableAllOptions();
                    revealAfterAnswer(false);
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
            lastKeyboardAnswer = '';
            lastSelectedOptionId = null;
            objectiveAnswerCorrect = true;
            practiceLocked = false;

            document.querySelectorAll('.mode-btn').forEach(btn => { btn.disabled = false; });

            const textInput = document.getElementById('textAnswer');
            if (textInput) {
                textInput.value = '';
                textInput.disabled = false;
                if (currentMode === 'keyboard') {
                    textInput.focus();
                }
            }

            const checkBtn = document.getElementById('checkAnswerBtn');
            if (checkBtn) {
                checkBtn.disabled = false;
            }

            document.getElementById('attemptsCounter').style.display = 'none';
            document.getElementById('multipleAttemptsCounter').style.display = 'none';
            document.getElementById('hintContainer').style.display = 'none';
            document.getElementById('hintContainer').innerHTML = '';

            const ex = document.getElementById('exampleSection');
            if (ex) {
                ex.classList.add('example-hidden');
            }

            const wr = document.getElementById('wrongReveal');
            if (wr) {
                wr.classList.remove('is-visible');
            }

            const ev = document.getElementById('evaluationSection');
            if (ev) {
                ev.classList.remove('is-visible');
            }

            const note = document.getElementById('evaluationNote');
            if (note) {
                note.style.display = 'none';
                note.textContent = '';
            }

            const fb = document.getElementById('practiceFeedback');
            if (fb) {
                fb.textContent = '';
            }

            document.querySelectorAll('.eval-btn').forEach(b => { b.disabled = false; });

            if (currentMode === 'multiple') {
                document.querySelectorAll('.option-btn').forEach(btn => {
                    btn.disabled = false;
                    btn.classList.remove('correct', 'incorrect');
                });
            }
        }

        function revealAfterAnswer(isObjectiveCorrect) {
            practiceLocked = true;
            document.querySelectorAll('.mode-btn').forEach(btn => { btn.disabled = true; });

            const ex = document.getElementById('exampleSection');
            if (ex) {
                ex.classList.remove('example-hidden');
            }

            const wr = document.getElementById('wrongReveal');
            if (wr) {
                if (isObjectiveCorrect) {
                    wr.classList.remove('is-visible');
                } else {
                    wr.classList.add('is-visible');
                }
            }

            const note = document.getElementById('evaluationNote');
            if (note && !isObjectiveCorrect) {
                note.style.display = 'block';
                note.textContent = 'Ответ был неверным: повторение запланировано как «Снова». Оценка ниже отражает, насколько сложным казался иероглиф.';
            }

            document.getElementById('evaluationSection').classList.add('is-visible');
            document.getElementById('evaluationSection').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        async function submitPracticeRating(result) {
            if (currentMode === 'eye') {
                return;
            }

            if (currentMode === 'keyboard' && !lastKeyboardAnswer.trim()) {
                showNotification('Сначала введите и проверьте ответ.', 'warning');
                return;
            }

            if (currentMode === 'multiple' && (lastSelectedOptionId === null || Number.isNaN(lastSelectedOptionId))) {
                showNotification('Сначала выберите вариант ответа.', 'warning');
                return;
            }

            const payload = {
                mode: currentMode,
                result: result,
            };

            if (currentMode === 'keyboard') {
                payload.answer = lastKeyboardAnswer;
            } else {
                payload.selected_option = lastSelectedOptionId;
            }

            if (learningCollectionId) {
                payload.collection_id = learningCollectionId;
            }

            document.querySelectorAll('.eval-btn').forEach(b => { b.disabled = true; });

            try {
                const res = await fetch(practiceUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify(payload),
                });

                const data = await res.json();

                if (!res.ok || !data.success) {
                    const msg = (data.errors && Object.values(data.errors).flat()[0]) || data.message || 'Не удалось сохранить.';
                    showNotification(msg, 'error');
                    document.querySelectorAll('.eval-btn').forEach(b => { b.disabled = false; });
                    return;
                }

                const fb = document.getElementById('practiceFeedback');
                if (fb && data.message) {
                    fb.textContent = data.message;
                }

                const pause = data.message ? 450 : 0;
                await new Promise(function(r) { setTimeout(r, pause); });

                if (data.next_character_id) {
                    const ok = await loadCharacter(data.next_character_id);
                    if (!ok) {
                        document.querySelectorAll('.eval-btn').forEach(function(b) { b.disabled = false; });
                    }
                    return;
                }

                if (data.redirect_url) {
                    window.location.href = data.redirect_url;
                }
            } catch (e) {
                console.error(e);
                showNotification('Ошибка сети. Попробуйте ещё раз.', 'error');
                document.querySelectorAll('.eval-btn').forEach(b => { b.disabled = false; });
            }
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