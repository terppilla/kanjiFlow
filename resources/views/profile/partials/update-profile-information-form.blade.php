<section class="profile-section">
    <header class="profile-section-header">
        <h2 class="profile-section-title">Личные данные</h2>
        <p class="profile-section-desc">
            Имя и адрес электронной почты, привязанные к аккаунту.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="profile-form-vertical">
        @csrf
        @method('patch')

        <div class="form-group profile-form-group">
            <label for="name" class="form-label">Имя</label>
            <input id="name" name="name" type="text" class="form-control @error('name') error @enderror" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')
                <p class="profile-field-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group profile-form-group">
            <label for="email" class="form-label">Email</label>
            <input id="email" name="email" type="email" class="form-control @error('email') error @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')
                <p class="profile-field-error">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="profile-verify-hint">
                    <p>
                        Адрес почты не подтверждён.
                        <button type="submit" form="send-verification" class="profile-link-inline">Выслать письмо ещё раз</button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="profile-flash profile-flash--success">Новая ссылка отправлена на вашу почту.</p>
                    @endif
                </div>
            @endif
        </div>

        <div class="profile-form-actions">
            <button type="submit" class="btn btn-primary profile-btn">Сохранить</button>
            @if (session('status') === 'profile-updated')
                <span class="profile-saved-hint" role="status">Сохранено.</span>
            @endif
        </div>
    </form>
</section>
