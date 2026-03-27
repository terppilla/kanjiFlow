<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход | KanjiFlow</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">

</head>
<body class="auth-layout">
    <!-- Декоративные иероглифы -->
    <div class="auth-decoration top-left">入</div>
    <div class="auth-decoration bottom-right">室</div>
    
    <div class="auth-container">
        <div class="auth-header">
            <h1 class="auth-title">Вход в аккаунт</h1>
            <p class="auth-subtitle">Войдите чтобы продолжить изучение иероглифов</p>
        </div>
        
        @if(session('status'))
            <div class="auth-status">
                {{ session('status') }}
            </div>
        @endif


        
        <form method="POST" action="{{ route('login') }}" class="auth-form">
            @csrf
            
            <!-- Email -->
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" class="form-input">
                @error('email')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Пароль -->
            <div class="form-group">
                <label for="password" class="form-label">Пароль</label>
                <input id="password" type="password" name="password" required autocomplete="current-password" class="form-input">
                @error('password')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Запомнить меня -->
            <div class="remember-group">
                <input id="remember_me" type="checkbox" name="remember" class="remember-checkbox">
                <label for="remember_me" class="remember-label">Запомнить меня</label>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    Войти
                </button>
            </div>
            
            <div class="form-links">
                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="form-link">
                        Забыли пароль?
                    </a>
                @endif
                <a href="{{ route('register') }}" class="form-link">
                    Нет аккаунта? Зарегистрироваться
                </a>
            </div>
        </form>
    </div>
</body>
</html>