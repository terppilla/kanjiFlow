<section class="profile-section">
    <header class="profile-section-header">
        <h2 class="profile-section-title">Личные данные</h2>
        <p class="profile-section-desc">
            Имя и адрес электронной почты, привязанные к аккаунту.
        </p>
    </header>

    <form id="send-verification" method="post" action="<?php echo e(route('verification.send')); ?>">
        <?php echo csrf_field(); ?>
    </form>

    <form method="post" action="<?php echo e(route('profile.update')); ?>" class="profile-form-vertical">
        <?php echo csrf_field(); ?>
        <?php echo method_field('patch'); ?>

        <div class="form-group profile-form-group">
            <label for="name" class="form-label">Имя</label>
            <input id="name" name="name" type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('name', $user->name)); ?>" required autofocus autocomplete="name">
            <?php $__errorArgs = ['name'];
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
            <label for="email" class="form-label">Email</label>
            <input id="email" name="email" type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('email', $user->email)); ?>" required autocomplete="username">
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="profile-field-error"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            <?php if($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail()): ?>
                <div class="profile-verify-hint">
                    <p>
                        Адрес почты не подтверждён.
                        <button type="submit" form="send-verification" class="profile-link-inline">Выслать письмо ещё раз</button>
                    </p>
                    <?php if(session('status') === 'verification-link-sent'): ?>
                        <p class="profile-flash profile-flash--success">Новая ссылка отправлена на вашу почту.</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="profile-form-actions">
            <button type="submit" class="btn btn-primary profile-btn">Сохранить</button>
            <?php if(session('status') === 'profile-updated'): ?>
                <span class="profile-saved-hint" role="status">Сохранено.</span>
            <?php endif; ?>
        </div>
    </form>
</section>
<?php /**PATH /home/c/cy906984/kanjilflow_public/public_html/resources/views/profile/partials/update-profile-information-form.blade.php ENDPATH**/ ?>