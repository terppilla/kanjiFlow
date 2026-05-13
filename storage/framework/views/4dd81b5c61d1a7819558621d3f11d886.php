<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация | KanjiFlow</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
   <link rel="stylesheet" href="<?php echo e(asset('css/forms.css')); ?>">

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
        
        <form method="POST" action="<?php echo e(route('register')); ?>" class="auth-form">
            <?php echo csrf_field(); ?>
            
            <!-- Имя -->
            <div class="form-group">
                <label for="name" class="form-label">Имя</label>
                <input id="name" type="text" name="name" value="<?php echo e(old('name')); ?>"  min="3"required autofocus autocomplete="name" class="form-input">
                <?php $__errorArgs = ['name'];
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
            
            <!-- Email -->
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" class="form-input">
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
                <input id="password" type="password" name="password" required autocomplete="new-password" class="form-input">
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
            
            <!-- Подтверждение пароля -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Подтверждение пароля</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="form-input">
                <?php $__errorArgs = ['password_confirmation'];
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
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    Зарегистрироваться
                </button>
            </div>
            
            <div class="form-links">
                <a href="<?php echo e(route('login')); ?>" class="form-link">
                    Уже есть аккаунт? Войти
                </a>
            </div>
        </form>
    </div>
   </div>
</body>
</html><?php /**PATH /home/c/cy906984/kanjilflow_public/public_html/resources/views/auth/register.blade.php ENDPATH**/ ?>