<section class="profile-section">
    <header class="profile-section-header">
        <h2 class="profile-section-title">Смена пароля</h2>
        <p class="profile-section-desc">
            Используйте длинный уникальный пароль, который вы нигде больше не применяете.
        </p>
    </header>

    <form method="post" action="<?php echo e(route('password.update')); ?>" class="profile-form-vertical">
        <?php echo csrf_field(); ?>
        <?php echo method_field('put'); ?>

        <div class="form-group profile-form-group">
            <label for="update_password_current_password" class="form-label">Текущий пароль</label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-control <?php $__errorArgs = ['current_password', 'updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" autocomplete="current-password">
            <?php $__errorArgs = ['current_password', 'updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="profile-field-error"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group profile-form-group">
            <label for="update_password_password" class="form-label">Новый пароль</label>
            <input id="update_password_password" name="password" type="password" class="form-control <?php $__errorArgs = ['password', 'updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" autocomplete="new-password">
            <?php $__errorArgs = ['password', 'updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="profile-field-error"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group profile-form-group">
            <label for="update_password_password_confirmation" class="form-label">Повторите пароль</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password">
            <?php $__errorArgs = ['password_confirmation', 'updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="profile-field-error"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="profile-form-actions">
            <button type="submit" class="btn btn-primary profile-btn">Обновить пароль</button>
            <?php if(session('status') === 'password-updated'): ?>
                <span class="profile-saved-hint" role="status">Пароль обновлён.</span>
            <?php endif; ?>
        </div>
    </form>
</section>
<?php /**PATH /home/c/cy906984/kanjilflow_public/public_html/resources/views/profile/partials/update-password-form.blade.php ENDPATH**/ ?>