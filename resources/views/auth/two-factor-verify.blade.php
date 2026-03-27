<x-guest-layout>
 <div class="auth-layout">
    <div class="auth-decoration top-left">入</div>
    <div class="auth-decoration bottom-right">室</div>
    
       <div class="auth-container">
        <div class="auth-header">
            <h1>Двухфакторная аутентификация</h1>
            <p>Введите код, отправленный на вашу электронную почту</p>
        </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('two-factor.verify') }}" >
        @csrf

        <div class="form-group">
            <label for="code" class="form-label">Код подтверждения</label>
            <input type="text" class="form-input" name="code" id="code" placeholder="000000" maxlength="6" required autofocus>
            @error('code')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class=" btn btn-primary">
                Подтвердить
            </button>
            
            <form method="POST" action="{{ route('two-factor.resend') }}">
                @csrf
                <button type="submit" class="btn btn-secondary">
                    Отправить код повторно
                </button>
            </form>
        </div>
    </form>
        </div>
 </div>

</x-guest-layout>