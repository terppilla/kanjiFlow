<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация | KanjiFlow</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
   <link rel="stylesheet" href="{{ asset('css/forms.css') }}">

</head>
<body>
   <div class="auth-layout">
     <div class="auth-decoration top-left">学</div>
    <div class="auth-decoration bottom-right">会</div>
    
    <div class="auth-container">
        <div class="auth-header">
            <h1 class="auth-title">Регистрация</h1>
            <p class="auth-subtitle">Создайте аккаунт для изучения китайских иероглифов</p>
        </div>
        
        <form method="POST" action="{{ route('register') }}" class="auth-form">
            @csrf
            
            <!-- Имя -->
            <div class="form-group">
                <label for="name" class="form-label">Имя</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="form-input">
                @error('name')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Email -->
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" class="form-input">
                @error('email')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Пароль -->
            <div class="form-group">
                <label for="password" class="form-label">Пароль</label>
                <input id="password" type="password" name="password" required autocomplete="new-password" class="form-input">
                @error('password')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Подтверждение пароля -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Подтверждение пароля</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="form-input">
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
   </div>
</body>
</html>