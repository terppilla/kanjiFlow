<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход | {{ config('app.name') }}</title>
    @include('layouts.partials.fonts')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}?v={{ filemtime(public_path('css/forms.css')) }}">
</head>
<body class="auth-layout">
    <div class="auth-decoration top-left">入</div>
    <div class="auth-decoration bottom-right">室</div>

    <div class="auth-container">
        <div class="auth-header">
            <h1 class="auth-title">Вход в аккаунт</h1>
            <p class="auth-subtitle">Войдите чтобы продолжить изучение иероглифов</p>
        </div>

        @if(session('status'))
            <div class="auth-status">{{ session('status') }}</div>
        @endif

        @if(!empty($accountLocked) && !empty($lockoutUntil))
            <div class="auth-alert auth-alert-lockout" role="alert" id="lockout-alert">
                <strong class="auth-alert-title">Аккаунт временно заблокирован</strong>
                <p class="auth-alert-text">
                    Слишком много неудачных попыток входа.
                    Разблокировка через <strong id="lockout-timer" class="auth-lockout-timer">--:--</strong>.
                </p>
            </div>
        @elseif(!empty($loginError))
            <div class="auth-alert auth-alert-error" role="alert">
                <strong class="auth-alert-title">Не удалось войти</strong>
                <p class="auth-alert-text">{{ $loginError }}</p>
            </div>
        @endif

        @if ($errors->any() && empty($loginError) && empty($accountLocked))
            <div class="auth-alert auth-alert-error" role="alert">
                <strong class="auth-alert-title">Проверьте форму</strong>
                <p class="auth-alert-text">Исправьте указанные поля и попробуйте снова.</p>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="auth-form" id="login-form">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="email"
                    class="form-input @if($errors->has('email') || !empty($loginError)) error @endif"
                    @if(!empty($accountLocked)) readonly @endif
                >
                @error('email')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Пароль</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    class="form-input @error('password') error @enderror"
                    @if(!empty($accountLocked)) disabled @endif
                >
                @error('password')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="remember-group">
                <input id="remember_me" type="checkbox" name="remember" class="remember-checkbox" @if(!empty($accountLocked)) disabled @endif>
                <label for="remember_me" class="remember-label">Запомнить меня</label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary" id="login-submit" @if(!empty($accountLocked)) disabled @endif>
                    Войти
                </button>
            </div>

            <div class="form-links">
                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="form-link">Забыли пароль?</a>
                @endif
                <a href="{{ route('register') }}" class="form-link">Нет аккаунта? Зарегистрироваться</a>
            </div>
        </form>
    </div>

    @if(!empty($accountLocked) && !empty($lockoutUntil))
        <script>
            (function () {
                const lockoutUntil = new Date(@json($lockoutUntil));
                const timerEl = document.getElementById('lockout-timer');
                const submitBtn = document.getElementById('login-submit');
                const passwordInput = document.getElementById('password');
                const emailInput = document.getElementById('email');

                function formatTime(totalSeconds) {
                    const minutes = Math.floor(totalSeconds / 60);
                    const seconds = totalSeconds % 60;
                    return String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
                }

                function unlockForm() {
                    if (submitBtn) submitBtn.disabled = false;
                    if (passwordInput) passwordInput.disabled = false;
                    if (emailInput) emailInput.readOnly = false;
                    const alert = document.getElementById('lockout-alert');
                    if (alert) alert.remove();
                }

                function tick() {
                    const secondsLeft = Math.max(0, Math.ceil((lockoutUntil.getTime() - Date.now()) / 1000));

                    if (secondsLeft <= 0) {
                        timerEl.textContent = '00:00';
                        unlockForm();
                        return;
                    }

                    timerEl.textContent = formatTime(secondsLeft);
                }

                tick();
                setInterval(tick, 1000);
            })();
        </script>
    @endif
</body>
</html>
