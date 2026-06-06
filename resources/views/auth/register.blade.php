<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация | {{ config('app.name') }}</title>
    @include('layouts.partials.fonts')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}?v={{ filemtime(public_path('css/forms.css')) }}">

</head>
<body class="auth-layout">
    <div class="auth-decoration top-left">学</div>
    <div class="auth-decoration bottom-right">会</div>

    <div class="auth-container">
        <div class="auth-header">
            <h1 class="auth-title">Регистрация</h1>
            <p class="auth-subtitle">Создайте аккаунт для изучения китайских иероглифов</p>
        </div>
        
        @if ($errors->any())
            <div class="auth-alert auth-alert-error" role="alert">
                <strong class="auth-alert-title">Проверьте форму</strong>
                <p class="auth-alert-text">Исправьте указанные поля и попробуйте снова.</p>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="auth-form">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">Имя</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" minlength="3" maxlength="255" required autofocus autocomplete="name" class="form-input @error('name') error @enderror">
                @error('name')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Email -->
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" class="form-input @error('email') error @enderror">
                @error('email')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Пароль -->
            <div class="form-group">
                <label for="password" class="form-label">Пароль</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    minlength="8"
                    required
                    autocomplete="new-password"
                    class="form-input @error('password') error @enderror"
                    aria-describedby="password-hint"
                >
                <p id="password-hint" class="form-hint" role="status">Не менее 8 символов</p>
                @error('password')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Подтверждение пароля -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Подтверждение пароля</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="form-input @error('password_confirmation') error @enderror">
                @error('password_confirmation')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    Зарегистрироваться
                </button>
            </div>
            
            <div class="form-links">
                <a href="{{ route('login') }}" class="form-link">
                    Уже есть аккаунт? Войти
                </a>
            </div>
        </form>
    </div>

    <script>
        (function () {
            var input = document.getElementById('password');
            var hint = document.getElementById('password-hint');
            if (!input || !hint) {
                return;
            }

            var minLength = 8;

            function pluralizeSymbols(count) {
                var mod10 = count % 10;
                var mod100 = count % 100;

                if (mod10 === 1 && mod100 !== 11) {
                    return 'символ';
                }

                if (mod10 >= 2 && mod10 <= 4 && (mod100 < 12 || mod100 > 14)) {
                    return 'символа';
                }

                return 'символов';
            }

            function updateHint() {
                var length = input.value.length;

                if (length === 0) {
                    hint.className = 'form-hint';
                    hint.textContent = 'Не менее ' + minLength + ' символов';
                    return;
                }

                if (length < minLength) {
                    var remaining = minLength - length;
                    hint.className = 'form-hint is-invalid';
                    hint.textContent = 'Ещё ' + remaining + ' ' + pluralizeSymbols(remaining);
                    return;
                }

                hint.className = 'form-hint is-valid';
                hint.textContent = 'Длина пароля подходит';
            }

            input.addEventListener('input', updateHint);
            input.addEventListener('blur', updateHint);
        })();
    </script>
</body>
</html>