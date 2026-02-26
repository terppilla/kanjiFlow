<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Повторение - KanjiFlow</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
            min-height: 100vh;
            color: white;
        }
        
        .review-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding: 20px;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .back-link {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .back-link:hover {
            background: rgba(255,255,255,0.3);
            transform: translateX(-5px);
        }
        
        .header-info {
            text-align: center;
        }
        
        .header-info h1 {
            font-size: 2.2rem;
            margin-bottom: 8px;
        }
        
        .header-info p {
            opacity: 0.9;
            font-size: 1rem;
        }
        
        .stats {
            display: flex;
            gap: 15px;
        }
        
        .stat {
            background: rgba(255,255,255,0.15);
            padding: 12px 20px;
            border-radius: 12px;
            text-align: center;
            min-width: 100px;
        }
        
        .stat-value {
            display: block;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 0.85rem;
            opacity: 0.9;
        }
        
        /* Карточка для повторения */
        .review-card {
            background: white;
            border-radius: 25px;
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.2);
            color: #1f2937;
            position: relative;
            overflow: hidden;
        }
        
        .review-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
            border-radius: 0 0 0 80px;
            opacity: 0.1;
        }
        
        .character-display {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .character-char {
            font-family: 'Noto Serif SC', serif;
            font-size: 8rem;
            color: #1f2937;
            margin-bottom: 20px;
            line-height: 1;
        }
        
        .character-meta {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 15px;
        }
        
        .meta-item {
            text-align: center;
        }
        
        .meta-label {
            display: block;
            color: #6b7280;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }
        
        .meta-value {
            font-size: 1.2rem;
            font-weight: 600;
            color: #1f2937;
        }
        
        .pinyin-value {
            color: #8b5cf6;
            font-size: 1.4rem;
        }
        
        .audio-btn {
            background: #8b5cf6;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-size: 1rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-top: 15px;
            transition: background 0.3s;
        }
        
        .audio-btn:hover {
            background: #7c3aed;
        }
        
        /* Область ответа */
        .answer-section {
            margin-top: 30px;
        }
        
        .question {
            text-align: center;
            font-size: 1.4rem;
            color: #1f2937;
            margin-bottom: 25px;
            font-weight: 500;
        }
        
        /* Режимы ответа */
        .mode-selector {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .mode-btn {
            background: #f9fafb;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 15px 25px;
            cursor: pointer;
            font-weight: 600;
            color: #6b7280;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .mode-btn:hover {
            border-color: #8b5cf6;
            color: #8b5cf6;
        }
        
        .mode-btn.active {
            background: #8b5cf6;
            color: white;
            border-color: #8b5cf6;
        }
        
        /* Ввод с клавиатуры */
        .keyboard-input {
            display: flex;
            gap: 15px;
            max-width: 600px;
            margin: 0 auto 20px;
        }
        
        #textAnswer {
            flex: 1;
            padding: 18px 20px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 1.1rem;
            transition: border-color 0.3s;
        }
        
        #textAnswer:focus {
            outline: none;
            border-color: #8b5cf6;
        }
        
        #checkAnswerBtn {
            background: #10b981;
            color: white;
            border: none;
            padding: 18px 30px;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        #checkAnswerBtn:hover {
            background: #059669;
        }
        
        /* Множественный выбор */
        .options-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            max-width: 600px;
            margin: 0 auto 20px;
        }
        
        .option-btn {
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 25px 20px;
            cursor: pointer;
            text-align: left;
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .option-btn:hover {
            border-color: #8b5cf6;
            transform: translateY(-3px);
        }
        
        .option-btn.correct {
            background: #d1fae5;
            border-color: #10b981;
            color: #065f46;
        }
        
        .option-btn.incorrect {
            background: #fee2e2;
            border-color: #ef4444;
            color: #7f1d1d;
        }
        
        .option-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }
        
        .option-number {
            display: inline-block;
            width: 30px;
            height: 30px;
            background: #8b5cf6;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .option-text {
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 5px;
        }
        
        .option-pinyin {
            color: #6b7280;
            font-size: 0.9rem;
        }
        
        /* Подсказки и попытки */
        .hint-container {
            text-align: center;
            margin: 20px 0;
            min-height: 30px;
        }
        
        .hint-message {
            display: inline-block;
            background: #fef3c7;
            color: #92400e;
            padding: 12px 20px;
            border-radius: 8px;
            border: 1px solid #fde68a;
        }
        
        .attempts-counter {
            text-align: center;
            color: #6b7280;
            margin: 15px 0;
        }
        
        /* Оценка результата */
        .evaluation-section {
            text-align: center;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid #e5e7eb;
            display: none;
        }
        
        .evaluation-question {
            font-size: 1.3rem;
            color: #1f2937;
            margin-bottom: 25px;
        }
        
        .evaluation-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
        }
        
        .eval-btn {
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 15px;
            padding: 20px;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            min-width: 120px;
            transition: all 0.3s;
        }
        
        .eval-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .btn-again {
            border-color: #ef4444;
        }
        
        .btn-again:hover {
            border-color: #dc2626;
            background: #fef2f2;
        }
        
        .btn-hard {
            border-color: #f59e0b;
        }
        
        .btn-hard:hover {
            border-color: #d97706;
            background: #fffbeb;
        }
        
        .btn-good {
            border-color: #10b981;
        }
        
        .btn-good:hover {
            border-color: #059669;
            background: #f0fdf4;
        }
        
        .btn-easy {
            border-color: #8b5cf6;
        }
        
        .btn-easy:hover {
            border-color: #7c3aed;
            background: #f5f3ff;
        }
        
        .emoji {
            font-size: 2rem;
        }
        
        .eval-label {
            font-weight: 600;
            color: #1f2937;
        }
        
        /* Навигация */
        .navigation {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }
        
        .nav-btn {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 15px 30px;
            border-radius: 15px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            border: 1px solid rgba(255,255,255,0.3);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .nav-btn:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-3px);
        }
        
        /* Завершение */
        .completed-message {
            text-align: center;
            padding: 60px 40px;
            background: white;
            border-radius: 25px;
            color: #1f2937;
            box-shadow: 0 20px 50px rgba(0,0,0,0.2);
        }
        
        .completed-icon {
            font-size: 5rem;
            margin-bottom: 30px;
        }
        
        .completed-title {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #10b981;
        }
        
        .completed-text {
            font-size: 1.2rem;
            color: #6b7280;
            margin-bottom: 30px;
            line-height: 1.6;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        /* Уведомления */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #10b981;
            color: white;
            padding: 18px 25px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            gap: 15px;
            z-index: 1001;
            animation: slideIn 0.3s ease;
        }
        
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        .notification button {
            background: none;
            border: none;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
        }
        
        /* Адаптивность */
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }
            
            .stats {
                justify-content: center;
                flex-wrap: wrap;
            }
            
            .character-char {
                font-size: 6rem;
            }
            
            .options-grid {
                grid-template-columns: 1fr;
            }
            
            .keyboard-input {
                flex-direction: column;
            }
            
            .evaluation-buttons {
                flex-wrap: wrap;
            }
            
            .eval-btn {
                min-width: calc(50% - 10px);
            }
            
            .navigation {
                flex-direction: column;
                gap: 15px;
            }
        }
        
        @media (max-width: 480px) {
            .character-char {
                font-size: 5rem;
            }
            
            .character-meta {
                flex-direction: column;
                gap: 15px;
            }
            
            .mode-selector {
                flex-direction: column;
            }
            
            .eval-btn {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="review-container">
        <!-- Шапка -->
        <div class="header">
            <a href="{{ route('review.select-level') }}" class="back-link">
                ← Выбор уровня
            </a>
            
            <div class="header-info">
                <h1>🔄 Повторение</h1>
                <p>Система интервальных повторений (SRS)</p>
            </div>
            
            <div class="stats">
                <div class="stat">
                    <span class="stat-value" id="remainingCards">0</span>
                    <span class="stat-label">Осталось</span>
                </div>
                <div class="stat">
                    <span class="stat-value" id="sessionCards">0</span>
                    <span class="stat-label">Сессия</span>
                </div>
            </div>
        </div>
        
        @if(!$userCharacter)
            <!-- Завершение -->
            <div class="completed-message">
                <div class="completed-icon">🎉</div>
                <h2 class="completed-title">Отличная работа!</h2>
                <p class="completed-text">
                    Вы повторили все иероглифы, которые были запланированы на сегодня.
                    Приходите завтра для продолжения обучения.
                </p>
                <div class="navigation">
                    <a href="{{ route('review.select-level') }}" class="nav-btn">
                        🔄 Выбрать другой уровень
                    </a>
                    <a href="{{ route('learning.select-level') }}" class="nav-btn">
                        📚 Изучать новые иероглифы
                    </a>
                    <a href="{{ route('dashboard') }}" class="nav-btn">
                        📊 В дашборд
                    </a>
                </div>
            </div>
        @else
            <!-- Карточка для повторения -->
            <div class="review-card">
                <div class="character-display">
                    <div class="character-char">{{ $character->character }}</div>
                    
                    <div class="character-meta">
                        <div class="meta-item">
                            <span class="meta-label">Уровень</span>
                            <span class="meta-value">HSK {{ $character->hsk_level }}</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Пиньинь</span>
                            <span class="meta-value pinyin-value">{{ $character->pinyin }}</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Номер</span>
                            <span class="meta-value">#{{ $character->id }}</span>
                        </div>
                    </div>
                    
                    @if($character->audio_character)
                        <button class="audio-btn" onclick="playAudio('{{ $character->audio_character }}')">
                            🔊 Произношение
                        </button>
                    @endif
                </div>
                
                <!-- Выбор режима ответа -->
                <div class="mode-selector">
                    <button class="mode-btn {{ $mode == 'keyboard' ? 'active' : '' }}" 
                            onclick="setMode('keyboard')">
                        ⌨️ Ввод ответа
                    </button>
                    <button class="mode-btn {{ $mode == 'multiple' ? 'active' : '' }}" 
                            onclick="setMode('multiple')">
                        🔘 Выбор варианта
                    </button>
                </div>
                
                <!-- Область ответа -->
                <div class="answer-section">
                    <!-- Ввод с клавиатуры -->
                    <div id="keyboardMode" style="{{ $mode != 'keyboard' ? 'display: none;' : '' }}">
                        <div class="question">Введите перевод этого иероглифа:</div>
                        
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
                    
                    <!-- Множественный выбор -->
                    <div id="multipleMode" style="{{ $mode != 'multiple' ? 'display: none;' : '' }}">
                        <div class="question">Выберите правильный перевод:</div>
                        
                        <div class="options-grid" id="optionsGrid">
                            @foreach($options as $index => $option)
                                <button class="option-btn" 
                                        data-option-id="{{ $option['id'] }}"
                                        data-is-correct="{{ $option['is_correct'] ? 'true' : 'false' }}"
                                        onclick="checkMultipleChoiceAnswer(this)">
                                    <div class="option-number">{{ $index + 1 }}</div>
                                    <div class="option-text">{{ $option['meaning'] }}</div>
                                    @if($option['pinyin'])
                                        <div class="option-pinyin">{{ $option['pinyin'] }}</div>
                                    @endif
                                </button>
                            @endforeach
                        </div>
                        
                        <div class="attempts-counter" id="multipleAttemptsCounter" style="display: none;">
                            Осталось попыток: <span id="multipleAttemptsLeft">3</span>
                        </div>
                    </div>
                    
                    <!-- Оценка результата -->
                    <div class="evaluation-section" id="evaluationSection">
                        <div class="evaluation-question">
                            Оцените, насколько хорошо вы знаете этот иероглиф:
                        </div>
                        
                        <div class="evaluation-buttons">
                            <button class="eval-btn btn-again" onclick="submitResult('again')">
                                <span class="emoji">😣</span>
                                <span class="eval-label">Забыл</span>
                            </button>
                            <button class="eval-btn btn-hard" onclick="submitResult('hard')">
                                <span class="emoji">🤔</span>
                                <span class="eval-label">С трудом</span>
                            </button>
                            <button class="eval-btn btn-good" onclick="submitResult('good')">
                                <span class="emoji">😊</span>
                                <span class="eval-label">Знаю</span>
                            </button>
                            <button class="eval-btn btn-easy" onclick="submitResult('easy')">
                                <span class="emoji">🎯</span>
                                <span class="eval-label">Отлично</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Навигация -->
            <div class="navigation">
                <button class="nav-btn" onclick="skipCard()">
                    ⏭️ Пропустить
                </button>
                <button class="nav-btn" onclick="showAnswer()" id="showAnswerBtn">
                    👁️ Показать ответ
                </button>
            </div>
        @endif
    </div>
    
    <script>
        // Глобальные переменные
        let currentMode = '{{ $mode }}';
        let attemptsLeft = 3;
        let multipleAttemptsLeft = 3;
        let correctAnswer = "{{ strtolower($character->meaning ?? '') }}";
        let userCharacterId = {{ $userCharacter->id ?? 0 }};
        let csrfToken = '{{ csrf_token() }}';
        let isAnswered = false;
        
        // Инициализация
        document.addEventListener('DOMContentLoaded', function() {
            updateStats();
            
            // Фокус на поле ввода
            if (currentMode === 'keyboard') {
                document.getElementById('textAnswer').focus();
            }
            
            // Обработка Enter
            document.getElementById('textAnswer')?.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    checkKeyboardAnswer();
                }
            });
            
            // Обработка цифр для выбора вариантов
            if (currentMode === 'multiple') {
                document.addEventListener('keypress', function(e) {
                    if (e.key >= '1' && e.key <= '4') {
                        const index = parseInt(e.key) - 1;
                        const options = document.querySelectorAll('.option-btn');
                        if (options[index]) {
                            options[index].click();
                        }
                    }
                });
            }
        });
        
        // Воспроизведение аудио
        function playAudio(url) {
            try {
                const audio = new Audio(url);
                audio.play();
            } catch (error) {
                console.log('Ошибка воспроизведения:', error);
            }
        }
        
        // Смена режима
        function setMode(mode) {
            currentMode = mode;
            
            // Обновляем URL
            const url = new URL(window.location.href);
            url.searchParams.set('mode', mode);
            window.history.replaceState({}, '', url);
            
            // Показываем/скрываем режимы
            document.getElementById('keyboardMode').style.display = mode === 'keyboard' ? 'block' : 'none';
            document.getElementById('multipleMode').style.display = mode === 'multiple' ? 'block' : 'none';
            
            // Обновляем активные кнопки
            document.querySelectorAll('.mode-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');
            
            // Фокус на поле ввода
            if (mode === 'keyboard') {
                document.getElementById('textAnswer').focus();
            }
        }
        
        // Проверка ответа с клавиатуры
        function checkKeyboardAnswer() {
            if (isAnswered) return;
            
            const userAnswer = document.getElementById('textAnswer').value.trim().toLowerCase();
            const hintContainer = document.getElementById('hintContainer');
            const attemptsCounter = document.getElementById('attemptsCounter');
            const attemptsLeftSpan = document.getElementById('attemptsLeft');
            
            if (!userAnswer) {
                showNotification('Пожалуйста, введите ответ', 'warning');
                return;
            }
            
            const isCorrect = validateAnswer(userAnswer, correctAnswer);
            
            if (isCorrect) {
                showEvaluation();
                document.getElementById('textAnswer').disabled = true;
                document.getElementById('checkAnswerBtn').disabled = true;
            } else {
                attemptsLeft--;
                attemptsLeftSpan.textContent = attemptsLeft;
                attemptsCounter.style.display = 'block';
                
                // Показываем подсказку
                const hint = generateHint(userAnswer);
                if (hint) {
                    hintContainer.innerHTML = `<div class="hint-message">💡 ${hint}</div>`;
                }
                
                if (attemptsLeft <= 0) {
                    showAnswer();
                    showEvaluation();
                    document.getElementById('textAnswer').disabled = true;
                    document.getElementById('checkAnswerBtn').disabled = true;
                }
            }
        }
        
        // Проверка выбора варианта
        function checkMultipleChoiceAnswer(button) {
            if (isAnswered) return;
            
            const isCorrect = button.dataset.isCorrect === 'true';
            const attemptsCounter = document.getElementById('multipleAttemptsCounter');
            const attemptsLeftSpan = document.getElementById('multipleAttemptsLeft');
            
            if (isCorrect) {
                button.classList.add('correct');
                showEvaluation();
                disableAllOptions();
            } else {
                button.classList.add('incorrect');
                multipleAttemptsLeft--;
                attemptsLeftSpan.textContent = multipleAttemptsLeft;
                attemptsCounter.style.display = 'block';
                
                if (multipleAttemptsLeft <= 0) {
                    showAnswer();
                    showEvaluation();
                    disableAllOptions();
                }
            }
        }
        
        // Отключить все варианты ответов
        function disableAllOptions() {
            document.querySelectorAll('.option-btn').forEach(btn => {
                btn.disabled = true;
                if (btn.dataset.isCorrect === 'true') {
                    btn.classList.add('correct');
                }
            });
        }
        
        // Валидация ответа
        function validateAnswer(userAnswer, correctAnswer) {
            const correctParts = correctAnswer.split(';').map(part => part.trim().toLowerCase());
            
            // Полное совпадение
            if (correctParts.includes(userAnswer)) {
                return true;
            }
            
            // Частичное совпадение
            for (const part of correctParts) {
                if (part.includes(userAnswer) || userAnswer.includes(part)) {
                    return true;
                }
            }
            
            return false;
        }
        
        // Генерация подсказки
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
        
        // Показать ответ
        function showAnswer() {
            if (isAnswered) return;
            
            document.getElementById('hintContainer').innerHTML = `
                <div class="hint-message" style="background: #d1fae5; border-color: #10b981; color: #065f46;">
                    📖 Правильный ответ: {{ $character->meaning ?? '' }}
                </div>
            `;
            
            if (currentMode === 'multiple') {
                disableAllOptions();
            }
            
            showEvaluation();
            isAnswered = true;
        }
        
        // Показать оценку
        function showEvaluation() {
            document.getElementById('evaluationSection').style.display = 'block';
            isAnswered = true;
            
            // Прокрутка к оценке
            document.getElementById('evaluationSection').scrollIntoView({ 
                behavior: 'smooth',
                block: 'center'
            });
        }
        
        // Отправить результат
        async function submitResult(result) {
            try {
                const response = await fetch(`/review/submit/${userCharacterId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        result: result,
                        mode: currentMode,
                        attempts: currentMode === 'keyboard' ? (3 - attemptsLeft) : (3 - multipleAttemptsLeft)
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showNotification(data.message, 'success');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showNotification('Ошибка сохранения', 'error');
                }
            } catch (error) {
                showNotification('Ошибка соединения', 'error');
            }
        }
        
        // Пропустить карточку
        function skipCard() {
            if (confirm('Пропустить этот иероглиф?')) {
                window.location.reload();
            }
        }
        
        // Обновление статистики
        function updateStats() {
            // Здесь можно добавить логику обновления статистики
            // Например, через AJAX запрос
        }
        
        // Показ уведомлений
        function showNotification(message, type = 'info') {
            const colors = {
                info: '#3b82f6',
                success: '#10b981',
                warning: '#f59e0b',
                error: '#ef4444'
            };
            
            const notification = document.createElement('div');
            notification.className = 'notification';
            notification.innerHTML = `
                <span>${message}</span>
                <button onclick="this.parentElement.remove()">×</button>
            `;
            notification.style.background = colors[type] || colors.info;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 3000);
        }
    </script>
</body>
</html>