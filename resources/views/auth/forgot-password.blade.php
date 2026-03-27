<x-guest-layout>
 <div class="auth-layout">
       <div class="auth-container">
        <div class="auth-header">
            <h1>Восстановление пароля</h1>
            <p>Забыли пароль? Нет проблем. Просто сообщите нам свой адрес электронной почты, и мы отправим вам ссылку для сброса пароля, по которой вы сможете выбрать новый.</p>
        </div>

    <x-auth-session-status class="" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="auth-form">
        @csrf

        <div class="form-group">
            <label for="email" class="form-label">Электронная почта</label>  
            <input type="email"  class="form-input"name="email" id="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                Сбросить пароль
            </button>
        </div>
    </form>
        </div>

 </div>
</x-guest-layout>