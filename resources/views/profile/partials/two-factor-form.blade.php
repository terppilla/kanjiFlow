@php
    $twoFactorOn = $user->two_factor_enabled;
@endphp

<section class="profile-section">
    <header class="profile-section-header">
        <h2 class="profile-section-title">Двухфакторная аутентификация</h2>
        <p class="profile-section-desc">
            После входа по паролю на email отправляется одноразовый код. Рекомендуется оставить защиту включённой.
        </p>
    </header>

    <div
        id="profile-two-factor-root"
        class="profile-two-factor-root"
        data-update-url="{{ route('profile.two-factor.update') }}"
    >
        <div class="profile-2fa-status">
            <span class="profile-2fa-label">Статус:</span>
            <span id="profile-2fa-badge" class="profile-badge {{ $twoFactorOn ? 'profile-badge--success' : 'profile-badge--muted' }}">
                {{ $twoFactorOn ? 'Включена' : 'Отключена' }}
            </span>
        </div>

        <p id="profile-2fa-flash" class="profile-flash profile-flash--success" role="status" hidden></p>

        @if (session('status') === 'two-factor-enabled' || session('status') === 'two-factor-disabled')
            <p class="profile-flash profile-flash--success profile-2fa-initial-flash" role="status">
                @if (session('status') === 'two-factor-enabled')
                    Двухфакторная аутентификация включена.
                @else
                    Двухфакторная аутентификация отключена.
                @endif
            </p>
        @endif

        <div id="profile-2fa-when-off" class="profile-2fa-actions {{ $twoFactorOn ? 'profile-2fa--hidden' : '' }}">
            <form id="profile-2fa-form-enable" class="profile-inline-form" action="#" method="post">
                @csrf
                <button type="submit" class="btn btn-primary profile-btn" id="profile-2fa-btn-enable">Включить</button>
            </form>
        </div>

        <div id="profile-2fa-when-on" class="profile-2fa-actions {{ $twoFactorOn ? '' : 'profile-2fa--hidden' }}">
            <details class="profile-details-2fa" id="profile-2fa-details">
                <summary class="profile-details-summary">Отключить…</summary>
                <div class="profile-details-body">
                    <p class="profile-details-hint">Введите текущий пароль, чтобы отключить вход по коду из письма.</p>
                    <form id="profile-2fa-form-disable" class="profile-form-vertical" action="#" method="post">
                        @csrf
                        <div class="form-group profile-form-group">
                            <label for="two_factor_password" class="form-label">Текущий пароль</label>
                            <input
                                id="two_factor_password"
                                name="password"
                                type="password"
                                class="form-control @error('password', 'twoFactor') error @enderror"
                                autocomplete="current-password"
                            >
                            <p id="profile-2fa-password-error" class="profile-field-error profile-2fa-js-error" hidden></p>
                            @error('password', 'twoFactor')
                                <p class="profile-field-error profile-2fa-server-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="btn profile-btn profile-btn--danger-outline" id="profile-2fa-btn-disable">Отключить защиту</button>
                    </form>
                </div>
            </details>
        </div>
    </div>
</section>

<script>
(function () {
    var root = document.getElementById('profile-two-factor-root');
    if (!root) return;

    var url = root.getAttribute('data-update-url');
    var meta = document.querySelector('meta[name="csrf-token"]');
    var token = meta ? meta.getAttribute('content') : '';

    var badge = document.getElementById('profile-2fa-badge');
    var flash = document.getElementById('profile-2fa-flash');
    var panelOn = document.getElementById('profile-2fa-when-on');
    var panelOff = document.getElementById('profile-2fa-when-off');
    var details = document.getElementById('profile-2fa-details');
    var pwdInput = document.getElementById('two_factor_password');
    var pwdErr = document.getElementById('profile-2fa-password-error');
    var formEnable = document.getElementById('profile-2fa-form-enable');
    var formDisable = document.getElementById('profile-2fa-form-disable');
    var btnEnable = document.getElementById('profile-2fa-btn-enable');
    var btnDisable = document.getElementById('profile-2fa-btn-disable');

    function csrfHeaders() {
        return {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'X-Requested-With': 'XMLHttpRequest'
        };
    }

    function setUi(enabled) {
        if (enabled) {
            badge.textContent = 'Включена';
            badge.className = 'profile-badge profile-badge--success';
            panelOn.classList.remove('profile-2fa--hidden');
            panelOff.classList.add('profile-2fa--hidden');
        } else {
            badge.textContent = 'Отключена';
            badge.className = 'profile-badge profile-badge--muted';
            panelOn.classList.add('profile-2fa--hidden');
            panelOff.classList.remove('profile-2fa--hidden');
        }
    }

    function showFlash(text) {
        flash.textContent = text;
        flash.hidden = false;
        var initial = root.querySelector('.profile-2fa-initial-flash');
        if (initial) initial.remove();
        window.clearTimeout(showFlash._t);
        showFlash._t = window.setTimeout(function () {
            flash.hidden = true;
        }, 5000);
    }

    function clearPwdError() {
        pwdErr.hidden = true;
        pwdErr.textContent = '';
        if (pwdInput) pwdInput.classList.remove('error');
    }

    function showPwdError(msg) {
        pwdErr.textContent = msg;
        pwdErr.hidden = false;
        if (pwdInput) pwdInput.classList.add('error');
    }

    function parseJsonSafe(res) {
        return res.text().then(function (t) {
            try {
                return { ok: res.ok, status: res.status, body: JSON.parse(t) };
            } catch (e) {
                return { ok: false, status: res.status, body: { message: 'Ошибка ответа сервера.' } };
            }
        });
    }

    formEnable.addEventListener('submit', function (e) {
        e.preventDefault();
        clearPwdError();
        btnEnable.disabled = true;
        fetch(url, {
            method: 'PATCH',
            headers: csrfHeaders(),
            body: JSON.stringify({ two_factor_enabled: true })
        })
            .then(parseJsonSafe)
            .then(function (r) {
                btnEnable.disabled = false;
                if (r.ok && r.body && r.body.two_factor_enabled === true) {
                    setUi(true);
                    showFlash(r.body.message || 'Двухфакторная аутентификация включена.');
                    return;
                }
                showFlash((r.body && r.body.message) ? r.body.message : 'Не удалось включить защиту.');
            })
            .catch(function () {
                btnEnable.disabled = false;
                showFlash('Сетевая ошибка. Попробуйте ещё раз.');
            });
    });

    formDisable.addEventListener('submit', function (e) {
        e.preventDefault();
        clearPwdError();
        var pwd = pwdInput ? pwdInput.value : '';
        if (!pwd) {
            showPwdError('Введите пароль.');
            return;
        }
        btnDisable.disabled = true;
        fetch(url, {
            method: 'PATCH',
            headers: csrfHeaders(),
            body: JSON.stringify({ two_factor_enabled: false, password: pwd })
        })
            .then(parseJsonSafe)
            .then(function (r) {
                btnDisable.disabled = false;
                if (r.ok && r.body && r.body.two_factor_enabled === false) {
                    setUi(false);
                    if (pwdInput) pwdInput.value = '';
                    if (details) details.removeAttribute('open');
                    showFlash(r.body.message || 'Двухфакторная аутентификация отключена.');
                    return;
                }
                var msg = 'Не удалось отключить защиту.';
                if (r.status === 422 && r.body && r.body.errors) {
                    var pe = r.body.errors.password;
                    if (pe && pe[0]) msg = pe[0];
                    else if (r.body.message) msg = r.body.message;
                } else if (r.body && r.body.message) {
                    msg = r.body.message;
                }
                showPwdError(msg);
            })
            .catch(function () {
                btnDisable.disabled = false;
                showPwdError('Сетевая ошибка. Попробуйте ещё раз.');
            });
    });
})();
</script>
