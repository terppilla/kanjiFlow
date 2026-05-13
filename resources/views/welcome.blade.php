<x-guest-layout>

<header class="header">    
<div class="hero">
        <div class="hero-big-title">
        <img src="img/new-hero.svg" alt="KANJIFLOW">
    </div>

        <div class="hero-text">
            <h1>Учите китайские иероглифы с умной системой</h1>
            <span>Бесплатная платформа с методом интервальных повторений.</span>
            <div class="hero-buttons">
              <a href="{{ route('register') }}" class="btn btn--gold-filled">Начать обучение</a>
              <a href="{{ route('login') }}" class="btn btn-primary">У меня уже есть аккаунт</a>
            </div>
        </div>
</div>
</header>
<main>
<section class="how">
<!-- Свечение -->
    <!-- Декоративные узоры -->
    <div class="chinese-pattern pattern-1">學</div>
    <div class="chinese-pattern pattern-2">習</div>
    
    <!-- Соединительные линии сетки -->
    <div class="grid-connector horizontal"></div>
    <div class="grid-connector vertical"></div>
    
    <h2>Как проходит обучение</h2>

    <div class="cards-container">
        <ul>
            <li>
                <!-- Эффект подсветки -->
                <div class="hover-glow"></div>
                
                <div class="icon-wrapper">
                    <img src="img/book.svg" alt="book">
                </div>
                
                <h3>Изучение</h3>
                <p>Вы видите иероглиф, его значение, чтение и пример использования в языке. Подробное объяснение с аудио сопровождением.</p>
                
                <!-- Акцентная линия -->
                <div class="accent-line"></div>
            </li>
            
            <li>
                <div class="hover-glow"></div>
                
                <div class="icon-wrapper">
                    <img src="img/brain.svg" alt="brain">
                </div>
                
                <h3>Проверка</h3>
                <p>Вы пытаетесь вспомнить значение и чтение иероглифа самостоятельно. Интерактивные упражнения и тесты.</p>
                
                <div class="accent-line"></div>
            </li>
            
            <li>
                <div class="hover-glow"></div>
                
                <div class="icon-wrapper">
                    <img src="img/check.svg" alt="check">
                </div>
                
                <h3>Оценка</h3>
                <p>Система оценивает, насколько хорошо вы запомнили иероглиф. Адаптивный алгоритм подстраивается под ваш темп.</p>
                
                <div class="accent-line"></div>
            </li>
            
            <li>
                <div class="hover-glow"></div>
                
                <div class="icon-wrapper">
                    <img src="img/retry.svg" alt="retry">
                </div>
                
                <h3>Повторение</h3>
                <p>Иероглифы повторяются в нужный момент, чтобы вы действительно их запомнили. Метод интервальных повторений.</p>
                
                <div class="accent-line"></div>
            </li>
        </ul>
    </div>
</section>

<section class="why">
    <h2>ПОЧЕМУ KANJIFLOW</h2>
    
    <div class="staircase">
        <!-- Ступень 1 -->
        <div class="step">
            <div class="step-number">1</div>
            <div class="platform">
                <div class="platform-content">
                    <h3>Умная система повторений</h3>
                    <p>Иероглифы повторяются в оптимальный момент забывания, используя алгоритм интервальных повторений.</p>
                </div>
            </div>
        </div>
        
        <!-- Ступень 2 -->
        <div class="step">
            <div class="step-number">2</div>
            <div class="platform">
                <div class="platform-content">
                    <h3>Фокус на иероглифах</h3>
                    <p>Только значение, чтение и повторение — без лишней информации, чтобы не перегружать память.</p>
                </div>
            </div>
        </div>
        
        <!-- Ступень 3 -->
        <div class="step">
            <div class="step-number">3</div>
            <div class="platform">
                <div class="platform-content">
                    <h3>Регулярное обучение</h3>
                    <p>Сессии и достижения формируют устойчивую привычку изучения китайского языка.</p>
                </div>
            </div>
        </div>
        
        <!-- Ступень 4 -->
        <div class="step">
            <div class="step-number">4</div>
            <div class="platform">
                <div class="platform-content">
                    <h3>Наглядный прогресс</h3>
                    <p>Статистика и серии дней помогают отслеживать результат и мотивируют продолжать обучение.</p>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="sta">
    <h2>Начните изучение китайских иероглифов уже сегодня</h2>
    <p>Используйте умную систему повторений и отслеживайте свой прогресс</p>
    
    <div class="cta-buttons">
        <a href="{{ route('register') }}" class="btn btn--primary">Начать обучение</a>
        <a href="{{ route('login') }}" class="btn btn-filled">У меня уже есть аккаунт</a>
    </div>
</section>
</main>

<footer class="landing-footer">
    <div class="landing-footer-inner">
        <p class="landing-footer-copy">&copy; {{ date('Y') }} {{ config('app.name', 'KanjiFlow') }}. Все права защищены.</p>
    </div>
</footer>

<script>
// Анимация появления при прокрутке для блока "Почему"
document.addEventListener('DOMContentLoaded', function() {
    const whyElements = document.querySelectorAll('.why h2, .why .step');
    
    function checkVisibility() {
        whyElements.forEach(el => {
            const rect = el.getBoundingClientRect();
            const windowHeight = window.innerHeight;
            
            if (rect.top <= windowHeight * 0.8) {
                el.classList.add('visible');
            }
        });
    }
    
    checkVisibility();
    window.addEventListener('scroll', checkVisibility);
    
    // Оптимизация с debounce
    let scrollTimeout;
    window.addEventListener('scroll', () => {
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(checkVisibility, 50);
    });
});
</script>
<noscript>
    <style>
        .why h2,
        .why .step {
            opacity: 1 !important;
            transform: none !important;
            filter: none !important;
        }
    </style>
</noscript>
</x-guest-layout>
