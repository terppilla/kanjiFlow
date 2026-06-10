<?php

namespace App\Services;

use App\Mail\TwoFactorCodeMail;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TwoFactorMailService
{
    public function sendCode(User $user, string $code): void
    {
        try {
            Mail::to($user->email)->send(new TwoFactorCodeMail($code));
        } catch (\Throwable $e) {
            Log::error("Ошибка отправки 2FA кода для {$user->email}: {$e->getMessage()}");

            throw $e;
        }
    }
}
