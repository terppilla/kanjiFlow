<nav>
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

        /* Навигация */
        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            background: var(--color-dark-blue);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        /* Логотип */
        .nav a.text-2xl {
            color: var(--color-white-gold);
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: 600;
            letter-spacing: 1px;
            transition: color 0.2s ease;
            font-family: 'Noto Serif SC', serif;
        }

        .nav a.text-2xl:hover {
            color: var(--color-gold);
        }

        /* Контейнер ссылок */
        .nav > div {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        /* Стили для ссылок */
        .nav a.text-lg {
            color: rgba(243, 202, 165, 0.9);
            text-decoration: none;
            font-size: 1rem;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            transition: all 0.2s ease;
            position: relative;
        }

        .nav a.text-lg:hover {
            color: white;
            background: rgba(214, 155, 100, 0.15);
        }

        /* Активная ссылка (если нужно) */
        .nav a.text-lg.active {
            color: white;
            background: var(--color-primary);
        }

        /* Стили для кнопки выхода */
        .nav button.text-lg {
            color: rgba(243, 202, 165, 0.9);
            font-size: 1rem;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            transition: all 0.2s ease;
            background: none;
            border: none;
            cursor: pointer;
            font-family: inherit;
        }

        .nav button.text-lg:hover {
            color: white;
            background: var(--color-primary);
        }

        /* Адаптивность */
        @media (max-width: 768px) {
            .nav {
                flex-direction: column;
                padding: 1rem;
                gap: 1rem;
            }

            .nav > div {
                flex-wrap: wrap;
                justify-content: center;
                gap: 0.75rem;
            }

            .nav a.text-lg,
            .nav button.text-lg {
                padding: 0.4rem 0.8rem;
                font-size: 0.95rem;
            }
        }

        @media (max-width: 480px) {
            .nav {
                padding: 0.75rem;
            }

            .nav a.text-2xl {
                font-size: 1.3rem;
            }

            .nav > div {
                gap: 0.5rem;
            }

            .nav a.text-lg,
            .nav button.text-lg {
                padding: 0.35rem 0.7rem;
                font-size: 0.9rem;
            }
        }

        /* Анимация при наведении */
        @keyframes slideIn {
            from {
                transform: translateY(-2px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .nav a.text-lg:hover,
        .nav button.text-lg:hover {
            animation: slideIn 0.2s ease;
        }
    </style>

    <div class="nav">
        <a href="{{ route('dashboard') }}" class="text-2xl font-semibold">KanjiFlow</a>
        <div>
            @auth
                <a href="{{ route('learning.select-level') }}" class="text-lg">Обучение</a>
                <a href="{{ route('collections.index') }}" class="text-lg">Коллекции</a>
                <a href="{{ route('articles.index') }}" class="text-lg">Статьи</a>
                <a href="{{ route('articles.favorites') }}" class="text-lg">Избранные статьи</a>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.articles.index') }}" class="text-lg">Админ: статьи</a>
                @endif
                <a href="{{ route('profile.edit') }}" class="text-lg">Профиль</a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="text-lg">
                        Выйти
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-lg">Войти</a>
                <a href="{{ route('register') }}" class="text-lg">Регистрация</a>
            @endauth
        </div>
    </div>
</nav>