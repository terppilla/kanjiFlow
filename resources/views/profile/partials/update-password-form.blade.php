<section class="profile-section">
    <header class="profile-section-header">
        <h2 class="profile-section-title">Смена пароля</h2>
        <p class="profile-section-desc">
            Используйте длинный уникальный пароль, который вы нигде больше не применяете.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="profile-form-vertical">
        @csrf
        @method('put')

        <div class="form-group profile-form-group">
            <label for="update_password_current_password" class="form-label">Текущий пароль</label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-control @error('current_password', 'updatePassword') error @enderror" autocomplete="current-password">
            @error('current_password', 'updatePassword')
                <p class="profile-field-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group profile-form-group">
            <label for="update_password_password" class="form-label">Новый пароль</label>
            <input id="update_password_password" name="password" type="password" class="form-control @error('password', 'updatePassword') error @enderror" autocomplete="new-password">
            @error('password', 'updatePassword')
                <p class="profile-field-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group profile-form-group">
            <label for="update_password_password_confirmation" class="form-label">Повторите пароль</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password">
            @error('password_confirmation', 'updatePassword')
                <p class="profile-field-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="profile-form-actions">
            <button type="submit" class="btn btn-primary profile-btn">Обновить пароль</button>
            @if (session('status') === 'password-updated')
                <span class="profile-saved-hint" role="status">Пароль обновлён.</span>
            @endif
        </div>
    </form>
</section>
