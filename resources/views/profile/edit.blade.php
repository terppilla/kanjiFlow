<x-app-layout>
    <div class="profile-page">
        <div class="profile-shell">
            <header class="articles-header profile-page-main-header">
                <div class="articles-header-text">
                    <h1 class="articles-title">Профиль</h1>
                    <p class="articles-lead">Данные аккаунта, пароль и настройки безопасности.</p>
                </div>
            </header>

            <div class="profile-stack">
                <div class="profile-card">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <div class="profile-card">
                    @include('profile.partials.two-factor-form')
                </div>

                <div class="profile-card">
                    @include('profile.partials.update-password-form')
                </div>

                <div class="profile-card profile-card--danger">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
