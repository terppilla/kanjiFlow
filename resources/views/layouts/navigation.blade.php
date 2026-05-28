<nav class="site-nav" aria-label="Основная навигация">
    <div class="nav">
        <a href="{{ route('dashboard') }}" class="text-2xl font-semibold nav-brand-logo" aria-label="{{ config('app.name') }}">
            <span aria-hidden="true">{{ config('app.logo_hanzi') }}</span>
        </a>

        <button
            type="button"
            class="nav-burger"
            aria-expanded="false"
            aria-controls="site-nav-menu"
            aria-label="Открыть меню"
        >
            <span class="nav-burger__bar" aria-hidden="true"></span>
            <span class="nav-burger__bar" aria-hidden="true"></span>
            <span class="nav-burger__bar" aria-hidden="true"></span>
        </button>

        <div id="site-nav-menu" class="nav-menu">
            @auth
                <a href="{{ route('learning.select-level') }}" class="text-lg">Обучение</a>
                <a href="{{ route('collections.index') }}" class="text-lg">Коллекции</a>
                <a href="{{ route('articles.index') }}" class="text-lg">Статьи</a>
                <a href="{{ route('articles.favorites') }}" class="text-lg">Избранные статьи</a>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="text-lg">Админ-панель</a>
                @endif
                <a href="{{ route('profile.edit') }}" class="text-lg">Профиль</a>
                <form method="POST" action="{{ route('logout') }}" class="nav-menu__logout">
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
    <div class="nav-backdrop" hidden></div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var nav = document.querySelector('nav.site-nav');
    if (!nav) {
        return;
    }

    var burger = nav.querySelector('.nav-burger');
    var menu = nav.querySelector('#site-nav-menu');
    var backdrop = nav.querySelector('.nav-backdrop');

    if (!burger || !menu) {
        return;
    }

    function setOpen(isOpen) {
        nav.classList.toggle('nav-open', isOpen);
        burger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        burger.setAttribute('aria-label', isOpen ? 'Закрыть меню' : 'Открыть меню');
        document.body.classList.toggle('nav-menu-open', isOpen);

        if (backdrop) {
            backdrop.hidden = !isOpen;
        }
    }

    function closeMenu() {
        setOpen(false);
    }

    burger.addEventListener('click', function () {
        setOpen(!nav.classList.contains('nav-open'));
    });

    if (backdrop) {
        backdrop.addEventListener('click', closeMenu);
    }

    menu.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', closeMenu);
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeMenu();
        }
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth > 768) {
            closeMenu();
        }
    });
});
</script>
