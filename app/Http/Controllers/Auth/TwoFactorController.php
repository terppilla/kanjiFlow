<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Mail\TwoFactorCodeMail;


class TwoFactorController extends Controller
{
    public function showVerifyForm() {
        if (!Session::has('two_factor_user_id')) {
            return redirect()->route('login');
        }
        return view('auth.two-factor-verify');
    }

    public function verify(Request $request) {
        $request->validate([
            'code' => 'required|string|size:6'
        ]);

        if(!Session::has('two_factor_user_id')) {
            return redirect()->route('login') ->withErrors(['code' => 'Сессия истекла. Войдите снова.']);
        }

        $userId = Session::get('two_factor_user_id');
        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('login')->withErrors(['code' => 'Пользователь не найден.']);
        }

        if($user->two_factor_code !== $request->code) {
            $this->handleFailed2FAAtempt($user);

            return back()->withErrors([
                'code' => 'Неверный код подтверждения'
            ]);
        }

        
        if (Carbon::parse($user->two_factor_expires_at)->isPast()) {
            return back()->withErrors([
                'code' => 'Код подтверждения истёк. Войдите снова.'
            ]);
        }

        $user->update([
            'two_factor_code' => null, 
            'two_factor_expires_at' => null
        ]);

        Auth::login($user);

        Session::forget('two_factor_user_id');

        Log::info("Пользователь {$user->email} успешно прошёл 2FA проверку");

        return redirect()->intended('/dashboard');
    }

    public function resend() {
        if(!Session::has('two_factor_user_id')) {
            return redirect()->route('login');
        }

        $userId = Session::get('two_factor_user_id');
        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('login');
        }

        $twoFactorCode = sprintf("%06d", mt_rand(1, 999999));

        $user->update([
            'two_factor_code' => $twoFactorCode,
            'two_factor_expires_at' => Carbon::now()->addMinutes(5)
        ]);

        Log::info("Новый 2FA код для пользователя {$user->email}: {$twoFactorCode}");
        
        // try {
        //     Mail::to($user->email)->send(new TwoFactorCodeMail($twoFactorCode));
        // } catch (\Exception $e) {
        //     Log::error("Ошибка отправки нового 2FA кода: " . $e->getMessage());
        // }
        
        return back()->with('status', 'Новый код отправлен!');
    }

    private function handleFailed2FAAttempt(User $user) {

    Log::warning("Неудачная попытка 2FA для пользователя {$user->email}");
    }
}
