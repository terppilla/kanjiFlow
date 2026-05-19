<nav>
    <div class="nav">
        <a href="{{ route('dashboard') }}" class="text-2xl font-semibold nav-brand-logo" aria-label="{{ config('app.name') }}">
            <span aria-hidden="true">{{ config('app.logo_hanzi') }}</span>
        </a>
        <div>
            @auth
                <a href="{{ route('learning.select-level') }}" class="text-lg">Обучение</a>
                <a href="{{ route('collections.index') }}" class="text-lg">Коллекции</a>
                <a href="{{ route('articles.index') }}" class="text-lg">Статьи</a>
                <a href="{{ route('articles.favorites') }}" class="text-lg">Избранные статьи</a>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="text-lg">Админ-панель</a>
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
