<x-guest-layout assets="landing" class="page-welcome">

<header class="header">
    <div class="hero">
        <div class="hero__inner">
            <div class="hero__brand">
                <img
                    src="{{ asset('img/KANJIFLOW.svg') }}"
                    alt="KANJIFLOW"
                    class="hero__logo"
                    width="900"
                    height="140"
                    decoding="async"
                    fetchpriority="high"
                >
            </div>

            <div class="hero__content">
            <h1>Учите китайские иероглифы с умной системой</h1>
            <p class="hero__lead">Бесплатная платформа с методом интервальных повторений.</p>
                <div class="hero-buttons">
                    <a href="{{ route('register') }}" class="btn btn--gold-filled">Начать обучение</a>
                    <a href="{{ route('login') }}" class="btn btn-primary">У меня уже есть аккаунт</a>
                </div>
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
                    <img src="{{ asset('img/book.svg') }}" alt="" width="120" height="120" loading="lazy" decoding="async">
                </div>
                
                <h3>Изучение</h3>
                <p>Вы видите иероглиф, его значение, чтение и пример использования в языке. Подробное объяснение с аудио сопровождением.</p>
                
                <!-- Акцентная линия -->
                <div class="accent-line"></div>
            </li>
            
            <li>
                <div class="hover-glow"></div>
                
                <div class="icon-wrapper">
                    <img src="{{ asset('img/brain.svg') }}" alt="" width="120" height="120" loading="lazy" decoding="async">
                </div>
                
                <h3>Проверка</h3>
                <p>Вы пытаетесь вспомнить значение и чтение иероглифа самостоятельно. Интерактивные упражнения и тесты.</p>
                
                <div class="accent-line"></div>
            </li>
            
            <li>
                <div class="hover-glow"></div>
                
                <div class="icon-wrapper">
                    <img src="{{ asset('img/check.svg') }}" alt="" width="120" height="120" loading="lazy" decoding="async">
                </div>
                
                <h3>Оценка</h3>
                <p>Система оценивает, насколько хорошо вы запомнили иероглиф. Адаптивный алгоритм подстраивается под ваш темп.</p>
                
                <div class="accent-line"></div>
            </li>
            
            <li>
                <div class="hover-glow"></div>
                
                <div class="icon-wrapper">
                    <img src="{{ asset('img/retry.svg') }}" alt="" width="120" height="120" loading="lazy" decoding="async">
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
    <div class="sta-pattern sta-pattern--1" aria-hidden="true">学</div>
    <div class="sta-pattern sta-pattern--2" aria-hidden="true">習</div>

    <div class="sta-inner">
        <h2>Начните изучение китайских иероглифов уже сегодня</h2>
        <p>Используйте умную систему повторений и отслеживайте свой прогресс</p>

        <div class="sta-buttons">
            <a href="{{ route('register') }}" class="btn btn--gold-filled">Начать обучение</a>
            <a href="{{ route('login') }}" class="btn btn-primary">У меня уже есть аккаунт</a>
        </div>
    </div>
</section>
</main>

<footer class="landing-footer">
    <div class="landing-footer-inner">
        <p class="landing-footer-copy">&copy; {{ date('Y') }} {{ config('app.name', 'KanjiFlow') }}. Все права защищены.</p>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const whyElements = document.querySelectorAll('.why h2, .why .step');
    if (!whyElements.length || !('IntersectionObserver' in window)) {
        whyElements.forEach(function (el) { el.classList.add('visible'); });
        return;
    }

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { rootMargin: '0px 0px -15% 0px', threshold: 0 });

    whyElements.forEach(function (el) { observer.observe(el); });
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
