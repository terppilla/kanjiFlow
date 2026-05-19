<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Services\LoginLockoutService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function __construct(
        private readonly LoginLockoutService $lockout
    ) {}

    public function create(Request $request): View
    {
        return view('auth.login', $this->buildLoginViewData(old('email')));
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            $user = $this->lockout->sync($user);

            if ($this->lockout->isLocked($user)) {
                return $this->loginLockoutRedirect($request, $user);
            }
        }

        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            if ($user) {
                $user = $this->lockout->recordFailedAttempt($user);

                if ($this->lockout->isLocked($user)) {
                    return $this->loginLockoutRedirect($request, $user);
                }

                $remaining = $this->lockout->remainingAttempts($user);
                if ($remaining > 0 && $remaining <= 2) {
                    return $this->loginErrorRedirect(
                        $request,
                        "Неверный email или пароль. Осталось попыток: {$remaining}."
                    );
                }
            }

            return $this->loginErrorRedirect($request, 'Неверный email или пароль.');
        }

        $user = Auth::user();
        $this->lockout->clear($user);

        if (! $user->two_factor_enabled) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        $request->session()->regenerate();

        $twoFactorCode = sprintf('%06d', mt_rand(1, 999999));

        $user->update([
            'two_factor_code' => $twoFactorCode,
            'two_factor_expires_at' => Carbon::now()->addMinutes(5),
        ]);

        Log::info("2FA код для пользователя {$user->email}: {$twoFactorCode}");

        Auth::logout();

        Session::put('two_factor_user_id', $user->id);

        return redirect()->route('two-factor.verify');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    private function buildLoginViewData(?string $email): array
    {
        $accountLocked = (bool) session('account_locked');
        $lockoutUntil = session('lockout_until');
        $loginError = session('login_error');

        if ($email) {
            $user = User::where('email', $email)->first();
            if ($user) {
                $user = $this->lockout->sync($user);
                $lockoutEndsAt = $this->lockout->lockoutEndsAt($user);

                if ($lockoutEndsAt !== null) {
                    $accountLocked = true;
                    $lockoutUntil = $lockoutEndsAt->toIso8601String();
                    $loginError = null;
                }
            }
        }

        return [
            'accountLocked' => $accountLocked,
            'lockoutUntil' => $lockoutUntil,
            'loginError' => $loginError,
        ];
    }

    private function loginErrorRedirect(LoginRequest $request, string $message): RedirectResponse
    {
        return redirect()
            ->route('login')
            ->withInput($request->only('email'))
            ->with('login_error', $message);
    }

    private function loginLockoutRedirect(LoginRequest $request, User $user): RedirectResponse
    {
        $lockoutEndsAt = $this->lockout->lockoutEndsAt($user);

        return redirect()
            ->route('login')
            ->withInput($request->only('email'))
            ->with([
                'account_locked' => true,
                'lockout_until' => $lockoutEndsAt?->toIso8601String(),
                'login_error' => null,
            ]);
    }
}
