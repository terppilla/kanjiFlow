<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход | KanjiFlow</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/forms.css')); ?>">

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
        
        <?php if(session('status')): ?>
            <div class="auth-status">
                <?php echo e(session('status')); ?>

            </div>
        <?php endif; ?>


        
        <form method="POST" action="<?php echo e(route('login')); ?>" class="auth-form">
            <?php echo csrf_field(); ?>
            
            <!-- Email -->
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus autocomplete="email" class="form-input">
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="form-error"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            
            <!-- Пароль -->
            <div class="form-group">
                <label for="password" class="form-label">Пароль</label>
                <input id="password" type="password" name="password" required autocomplete="current-password" class="form-input">
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="form-error"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                <?php if(Route::has('password.request')): ?>
                    <a href="<?php echo e(route('password.request')); ?>" class="form-link">
                        Забыли пароль?
                    </a>
                <?php endif; ?>
                <a href="<?php echo e(route('register')); ?>" class="form-link">
                    Нет аккаунта? Зарегистрироваться
                </a>
            </div>
        </form>
    </div>
</body>
</html><?php /**PATH /home/c/cy906984/kanjilflow_public/public_html/resources/views/auth/login.blade.php ENDPATH**/ ?>