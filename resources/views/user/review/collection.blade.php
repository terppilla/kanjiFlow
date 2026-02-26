<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Повторение коллекции {{ $collection->name }} - KanjiFlow</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%);
            min-height: 100vh;
            color: white;
        }
        
        .review-collection-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding: 25px;
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
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        
        .header-info p {
            opacity: 0.9;
            font-size: 1.1rem;
        }
        
        .collection-meta {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 15px;
            font-size: 0.95rem;
        }
        
        .stats {
            display: flex;
            gap: 15px;
        }
        
        .stat {
            background: rgba(255,255,255,0.15);
            padding: 15px 25px;
            border-radius: 15px;
            text-align: center;
            min-width: 120px;
        }
        
        .stat-value {
            display: block;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 8px;
        }
        
        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        /* Основной контент */
        .review-main {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 30px;
        }
        
        /* Левая панель */
        .review-sidebar {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }
        
        .sidebar-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 25px;
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .sidebar-title {
            font-size: 1.3rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .progress-section {
            margin-bottom: 20px;
        }
        
        .progress-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 0.95rem;
            opacity: 0.9;
        }
        
        .progress-bar {
            height: 10px;
            background: rgba(255,255,255,0.2);
            border-radius: 5px;
            overflow: hidden;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #ec4899 0%, #8b5cf6 100%);
            border-radius: 5px;
            transition: width 1s ease;
        }
        
        .status-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .status-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: rgba(255,255,255,0.05);
            border-radius: 10px;
        }
        
        .status-icon {
            font-size: 1.2rem;
        }
        
        .status-text {
            flex: 1;
        }
        
        .status-count {
            background: rgba(255,255,255,0.2);
            padding: 4px 10px;
            border-radius: 12px;
            font-weight: 600;
        }
        
        /* Правая часть */
        .review-content {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }
        
        /* Карточка иероглифа */
        .review-card {
            background: white;
            border-radius: 25px;
            padding: 40px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.2);
            color: #1f2937;
        }
        
        .character-display {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .character-char {
            font-family: 'Noto Serif SC', serif;
            font-size: 7rem;
            color: #1f2937;
            margin-bottom: 20px;
            line-height: 1;
        }
        
        .character-info {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 15px;
        }
        
        .info-item {
            text-align: center;
        }
        
        .info-label {
            display: block;
            color: #6b7280;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }
        
        .info-value {
            font-size: 1.2rem;
            font-weight: 600;
            color: #1f2937;
        }
        
        .pinyin-value {
            color: #8b5cf6;
            font-size: 1.4rem;
        }
        
        /* Пример использования */
        .example-section {
            background: #f9fafb;
            border-radius: 15px;
            padding: 20px;
            margin: 25px 0;
            border-left: 4px solid #8b5cf6;
        }
        
        .example-title {
            color: #1f2937;
            font-weight: 600;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .example-content {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .example-hanzi {
            font-family: 'Noto Serif SC', serif;
            font-size: 1.3rem;
            color: #1f2937;
        }
        
        .example-pinyin {
            color: #8b5cf6;
            font-style: italic;
        }
        
        .example-translation {
            color: #6b7280;
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
        }
        
        #checkAnswerBtn:hover {
            background: #059669;
        }
        
        .hint-container {
            text-align: center;
            margin: 20px 0;
        }
        
        .hint-message {
            display: inline-block;
            background: #fef3c7;
            color: #92400e;
            padding: 12px 20px;
            border-radius: 8px;
            border: 1px solid #fde68a;
        }
        
        /* Оценка */
        .evaluation-section {
            text-align: center;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid #e5e7eb;
            display: none;
        }
        
        .evaluation-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }
        
        .eval-btn {
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 15px;
            padding: 20px;
            cursor: pointer;
            min-width: 120px;
            transition: all 0.3s;
        }
        
        .eval-btn:hover {
            transform: translateY(-5px);
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
            cursor: pointer;
        }
        
        .nav-btn:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-3px);
        }
        
        /* Завершение */
        .completed {
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
        }
        
        /* Адаптивность */
        @media (max-width: 992px) {
            .review-main {
                grid-template-columns: 1fr;
            }
            
            .review-sidebar {
                order: 2;
            }
        }
        
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
                font-size: 5rem;
            }
            
            .navigation {
                flex-direction: column;
                gap: 15px;
            }
            
            .evaluation-buttons {
                flex-direction: column;
            }
            
            .eval-btn {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="review-collection-container">
        <!-- Шапка -->
        <div class="header">
            <a href="{{ route('collections.show', $collection) }}" class="back-link">
                ← Назад в коллекцию
            </a>
            
            <div class="header-info">
                <h1>Повторение коллекции</h1>
                <p>{{ $collection->name }}</p>
                <div class="collection-meta">
                    <span>📁 {{ $collection->characters->count() }} иероглифов</span>
                    <span>🔄 {{ $dueCards->count() }} для повторения</span>
                </div>
            </div>
            
            <div class="stats">
                <div class="stat">
                    <span class="stat-value" id="remainingCards">{{ $dueCards->count() }}</span>
                    <span class="stat-label">Осталось</span>
                </div>
                <div class="stat">
                    <span class="stat-value" id="sessionCards">0</span>
                    <span class="stat-label">Сессия</span>
                </div>
            </div>
        </div>
        
        <!-- Основной контент -->
        <div class="review-main">
            <!-- Левая панель -->
            <aside class="review-sidebar">
                <div class="sidebar-card">
                    <h3 class="sidebar-title">📊 Прогресс</h3>
                    
                    <div class="progress-section">
                        <div class="progress-header">
                            <span>Текущая сессия</span>
                            <span id="progressPercent">0%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" id="progressBar" style="width: 0%"></div>
                        </div>
                    </div>
                    
                    <div class="status-list">
                        <div class="status-item">
                            <span class="status-icon">🔄</span>
                            <span class="status-text">Для повторения</span>
                            <span class="status-count" id="dueCount">{{ $dueCards->count() }}</span>
                        </div>
                        <div class="status-item">
                            <span class="status-icon">🎯</span>
                            <span class="status-text">Повторено</span>
                            <span class="status-count" id="reviewedCount">0</span>
                        </div>
                        <div class="status-item">
                            <span class="status-icon">⏱️</span>
                            <span class="status-text">Среднее время</span>
                            <span class="status-count" id="avgTime">0с</span>
                        </div>
                    </div>
                </div>
                
                <div class="sidebar-card">
                    <h3 class="sidebar-title">⚡ Быстрые действия</h3>
                    
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <button class="nav-btn" onclick="skipCard()" style="justify-content: center;">
                            ⏭️ Пропустить иероглиф
                        </button>
                        <button class="nav-btn" onclick="showAnswer()" style="justify-content: center;">
                            👁️ Показать ответ
                        </button>
                        <a href="{{ route('collections.show', $collection) }}" class="nav-btn" style="justify-content: center;">
                            📁 В коллекцию
                        </a>
                    </div>
                </div>
            </aside>
            
            <!-- Правая часть -->
            <main class="review-content">
                @if($dueCards->count() > 0)
                    @php
                        $currentCard = $dueCards->first();
                        $character = $currentCard->character;
                    @endphp
                    
                    <!-- Карточка для повторения -->
                    <div class="review-card">
                        <div class="character-display">
                            <div class="character-char">{{ $character->character }}</div>
                            
                            <div class="character-info">
                                <div class="info-item">
                                    <span class="info-label">Пиньинь</span>
                                    <span class="info-value pinyin-value">{{ $character->pinyin }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">HSK</span>
                                    <span class="info-value">Уровень {{ $character->hsk_level }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Повторений</span>
                                    <span class="info-value">{{ $currentCard->repetitions }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Пример использования -->
                        @if($character->example_hanzi)
                            <div class="example-section">
                                <div class="example-title">📖 Пример использования</div>
                                <div class="example-content">
                                    <div class="example-hanzi">{{ $character->example_hanzi }}</div>
                                    <div class="example-pinyin">{{ $character->example_pinyin }}</div>
                                    <div class="example-translation">{{ $character->example_translation }}</div>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Область ответа -->
                        <div class="answer-section">
                            <div class="question">Введите перевод этого иероглифа:</div>
                            
                            <div class="keyboard-input">
                                <input type="text" 
                                       id="textAnswer" 
                                       placeholder="Введите значение на русском..."
                                       autocomplete="off"
                                       autofocus>
                                <button id="checkAnswerBtn" onclick="checkAnswer()">
                                    Проверить
                                </button>
                            </div>
                            
                            <div class="hint-container" id="hintContainer"></div>
                            <div class="attempts-counter" id="attemptsCounter" style="display: none;">
                                Осталось попыток: <span id="attemptsLeft">3</span>
                            </div>
                            
                            <!-- Оценка результата -->
                            <div class="evaluation-section" id="evaluationSection">
                                <div class="evaluation-buttons">
                                    <button class="eval-btn btn-again" onclick="submitResult('again')">
                                        😣 Забыл
                                    </button>
                                    <button class="eval-btn btn-hard" onclick="submitResult('hard')">
                                        🤔 С трудом
                                    </button>
                                    <button class="eval-btn btn-good" onclick="submitResult('good')">
                                        😊 Знаю
                                    </button>
                                    <button class="eval-btn btn-easy" onclick="submitResult('easy')">
                                        🎯 Отлично
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Навигация -->
                    <div class="navigation">
                        <button class="nav-btn" onclick="previousCard()" id="prevBtn" disabled>
                            ← Предыдущий
                        </button>
                        <button class="nav-btn" onclick="nextCard()" id="nextBtn">
                            Следующий →
                        </button>
                    </div>
                @else
                    <!-- Завершение -->
                    <div class="completed">
                        <div class="completed-icon">🎉</div>
                        <h2 class="completed-title">Коллекция повторена!</h2>
                        <p class="completed-text">
                            Вы успешно повторили все иероглифы из коллекции "{{ $collection->name }}".
                            Система SRS рассчитает оптимальное время для следующего повторения.
                        </p>
                        <div class="navigation">
                            <a href="{{ route('collections.show', $collection) }}" class="nav-btn">
                                📁 Вернуться в коллекцию
                            </a>
                            <a href="{{ route('collections.index') }}" class="nav-btn">
                                📚 Все коллекции
                            </a>
                            <a href="{{ route('dashboard') }}" class="nav-btn">
                                📊 В дашборд
                            </a>
                        </div>
                    </div>
                @endif
            </main>
        </div>
    </div>
    
    <script>
        // Глобальные переменные
        let currentCardIndex = 0;
        let cards = @json($dueCards->toArray());
        let attemptsLeft = 3;
        let isAnswered = false;
        let sessionStartTime = Date.now();
        let reviewedCards = 0;
        let totalTime = 0;
        
        // Инициализация
        document.addEventListener('DOMContentLoaded', function() {
            updateStats();
            updateNavigation();
            
            // Обработка Enter
            document.getElementById('textAnswer')?.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    checkAnswer();
                }
            });
        });
        
        // Проверка ответа
        function checkAnswer() {
            if (isAnswered) return;
            
            const userAnswer = document.getElementById('textAnswer').value.trim().toLowerCase();
            const correctAnswer = cards[currentCardIndex].character.meaning.toLowerCase();
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
                const hint = generateHint(userAnswer, correctAnswer);
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
        
        // Валидация ответа
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
        
        // Генерация подсказки
        function generateHint(userAnswer, correctAnswer) {
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
            
            const correctAnswer = cards[currentCardIndex].character.meaning;
            document.getElementById('hintContainer').innerHTML = `
                <div class="hint-message" style="background: #d1fae5; border-color: #10b981; color: #065f46;">
                    📖 Правильный ответ: ${correctAnswer}
                </div>
            `;
            
            showEvaluation();
            isAnswered = true;
        }
        
        // Показать оценку
        function showEvaluation() {
            document.getElementById('evaluationSection').style.display = 'block';
            isAnswered = true;
        }
        
        // Отправить результат
        async function submitResult(result) {
            const card = cards[currentCardIndex];
            const responseTime = Date.now() - sessionStartTime;
            
            try {
                const response = await fetch(`/review/submit/${card.id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        result: result,
                        response_time: Math.floor(responseTime / 1000),
                        attempts: 3 - attemptsLeft
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    reviewedCards++;
                    totalTime += responseTime;
                    
                    // Удаляем карточку из массива
                    cards.splice(currentCardIndex, 1);
                    
                    if (cards.length > 0) {
                        // Если остались карточки, показываем следующую
                        if (currentCardIndex >= cards.length) {
                            currentCardIndex = cards.length - 1;
                        }
                        loadCard(currentCardIndex);
                    } else {
                        // Иначе завершаем
                        window.location.href = "{{ route('collections.review.completed', $collection) }}";
                    }
                    
                    updateStats();
                }
            } catch (error) {
                showNotification('Ошибка сохранения', 'error');
            }
        }
        
        // Загрузить карточку
        function loadCard(index) {
            const card = cards[index];
            
            // Сброс состояния
            isAnswered = false;
            attemptsLeft = 3;
            sessionStartTime = Date.now();
            
            // Обновление DOM
            document.querySelector('.character-char').textContent = card.character.character;
            document.querySelector('.pinyin-value').textContent = card.character.pinyin;
            document.querySelectorAll('.info-value')[1].textContent = `Уровень ${card.character.hsk_level}`;
            document.querySelectorAll('.info-value')[2].textContent = card.repetitions;
            
            // Пример использования
            const exampleSection = document.querySelector('.example-section');
            if (card.character.example_hanzi) {
                exampleSection.querySelector('.example-hanzi').textContent = card.character.example_hanzi;
                exampleSection.querySelector('.example-pinyin').textContent = card.character.example_pinyin;
                exampleSection.querySelector('.example-translation').textContent = card.character.example_translation;
                exampleSection.style.display = 'block';
            } else {
                exampleSection.style.display = 'none';
            }
            
            // Сброс формы
            document.getElementById('textAnswer').value = '';
            document.getElementById('textAnswer').disabled = false;
            document.getElementById('checkAnswerBtn').disabled = false;
            document.getElementById('hintContainer').innerHTML = '';
            document.getElementById('attemptsCounter').style.display = 'none';
            document.getElementById('evaluationSection').style.display = 'none';
            
            // Фокус
            document.getElementById('textAnswer').focus();
            
            updateNavigation();
        }
        
        // Навигация
        function previousCard() {
            if (currentCardIndex > 0) {
                currentCardIndex--;
                loadCard(currentCardIndex);
            }
        }
        
        function nextCard() {
            if (currentCardIndex < cards.length - 1) {
                currentCardIndex++;
                loadCard(currentCardIndex);
            }
        }
        
        function skipCard() {
            if (confirm('Пропустить этот иероглиф?')) {
                cards.splice(currentCardIndex, 1);
                
                if (cards.length > 0) {
                    if (currentCardIndex >= cards.length) {
                        currentCardIndex = cards.length - 1;
                    }
                    loadCard(currentCardIndex);
                } else {
                    window.location.reload();
                }
                
                updateStats();
            }
        }
        
        // Обновление навигации
        function updateNavigation() {
            document.getElementById('prevBtn').disabled = currentCardIndex === 0;
            document.getElementById('nextBtn').disabled = currentCardIndex === cards.length - 1;
        }
        
        // Обновление статистики
        function updateStats() {
            const remaining = cards.length;
            const progress = reviewedCards > 0 ? Math.round((reviewedCards / (reviewedCards + remaining)) * 100) : 0;
            const avgTime = reviewedCards > 0 ? Math.round(totalTime / reviewedCards / 1000) : 0;
            
            document.getElementById('remainingCards').textContent = remaining;
            document.getElementById('sessionCards').textContent = reviewedCards;
            document.getElementById('progressPercent').textContent = `${progress}%`;
            document.getElementById('progressBar').style.width = `${progress}%`;
            document.getElementById('dueCount').textContent = remaining;
            document.getElementById('reviewedCount').textContent = reviewedCards;
            document.getElementById('avgTime').textContent = `${avgTime}с`;
        }
        
        // Показ уведомлений
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.style.position = 'fixed';
            notification.style.top = '20px';
            notification.style.right = '20px';
            notification.style.background = type === 'error' ? '#ef4444' : 
                                           type === 'success' ? '#10b981' : '#3b82f6';
            notification.style.color = 'white';
            notification.style.padding = '15px 25px';
            notification.style.borderRadius = '12px';
            notification.style.boxShadow = '0 10px 25px rgba(0,0,0,0.15)';
            notification.style.zIndex = '1001';
            notification.style.animation = 'slideIn 0.3s ease';
            
            notification.innerHTML = `
                <span>${message}</span>
                <button onclick="this.parentElement.remove()" style="background: none; border: none; color: white; font-size: 1.2rem; cursor: pointer; margin-left: 15px;">×</button>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 3000);
        }
    </script>
</body>