<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Mail\TwoFactorCodeMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
public function store(LoginRequest $request): RedirectResponse
{
    $user = User::where('email', $request->email)->first();

    // Проверка блокировки аккаунта
    if ($user && $user->locked_until && Carbon::parse($user->locked_until)->isFuture()) {
        $minutes = Carbon::now()->diffInMinutes($user->locked_until);
        return back()->withErrors([
            'email' => "Слишком много попыток входа. Аккаунт заблокирован на {$minutes} мин.",
        ]);
    }

    // Проверка пароля
    if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
        if ($user) {
            $this->handleFailedLogin($user);
        }

        return back()->withErrors([
            'email' => 'Неверный email или пароль.',
        ]);
    }

    // Успешная аутентификация - получаем пользователя
    $user = Auth::user();

    // Сбрасываем счетчик попыток при успешном вводе пароля
    $user->update([
        'login_attempts' => 0,
        'locked_until' => null,
    ]);

    if (! $user->two_factor_enabled) {
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    // Генерируем 2FA код
    $twoFactorCode = sprintf('%06d', mt_rand(1, 999999));

    $user->update([
        'two_factor_code' => $twoFactorCode,
        'two_factor_expires_at' => Carbon::now()->addMinutes(5),
    ]);

    // Логируем код (временно)
    Log::info("2FA код для пользователя {$user->email}: {$twoFactorCode}");

    // Разлогиниваем временно
    Auth::logout();

    // Сохраняем ID пользователя в сессии
    Session::put('two_factor_user_id', $user->id);

    // Перенаправляем на страницу ввода 2FA кода
    return redirect()->route('two-factor.verify');
}


    private function handleFailedLogin(User $user): void
    {
        $attempts = $user->login_attempts + 1;
        $maxAttempts = 8;
        $lockoutMinutes = 15;
        $lockoutTime = null;

        if ($attempts >= $maxAttempts) {
            $lockoutTime = Carbon::now()->addMinutes($lockoutMinutes);
            Log::warning("Пользователь {$user->email} заблокирован до {$lockoutTime} (попыток: {$attempts})");
        } elseif ($attempts >= 4) {
            Log::info("Пользователь {$user->email}: неудачных попыток входа: {$attempts}");
        }

        $user->update([
            'login_attempts' => $attempts,
            'locked_until' => $lockoutTime,
        ]);
    }
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
