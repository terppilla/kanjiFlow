<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class LoginLockoutService
{
    public const MAX_ATTEMPTS = 5;

    public const LOCKOUT_MINUTES = 30;

    public function isLocked(User $user): bool
    {
        return $this->lockoutEndsAt($user) !== null;
    }

    public function lockoutEndsAt(User $user): ?Carbon
    {
        if ($user->locked_until !== null) {
            $lockedUntil = Carbon::parse($user->locked_until);
            if ($lockedUntil->isFuture()) {
                return $lockedUntil;
            }
        }

        $cachedUntil = Cache::get($this->cacheKey($user->email));
        if ($cachedUntil === null) {
            return null;
        }

        $cachedUntil = Carbon::parse($cachedUntil);
        if ($cachedUntil->isFuture()) {
            return $cachedUntil;
        }

        Cache::forget($this->cacheKey($user->email));

        return null;
    }

    public function sync(User $user): User
    {
        $this->clearIfExpired($user);
        $user->refresh();

        $attempts = (int) $user->login_attempts;
        if ($attempts >= self::MAX_ATTEMPTS && ! $this->isLocked($user)) {
            $this->applyLockout($user, $attempts);
            $user->refresh();
        }

        return $user;
    }

    public function recordFailedAttempt(User $user): User
    {
        if ($this->isLocked($user)) {
            return $user;
        }

        $attempts = (int) $user->login_attempts + 1;

        if ($attempts >= self::MAX_ATTEMPTS) {
            $this->applyLockout($user, $attempts);

            return $user->fresh();
        }

        $user->update(['login_attempts' => $attempts]);

        if ($attempts >= 3) {
            Log::info("User {$user->email}: failed login attempts: {$attempts}");
        }

        return $user->fresh();
    }

    public function clear(User $user): void
    {
        Cache::forget($this->cacheKey($user->email));

        $user->update([
            'login_attempts' => 0,
            'locked_until' => null,
        ]);
    }

    public function remainingAttempts(User $user): int
    {
        return max(0, self::MAX_ATTEMPTS - (int) $user->login_attempts);
    }

    private function applyLockout(User $user, int $attempts): void
    {
        $lockedUntil = Carbon::now()->addMinutes(self::LOCKOUT_MINUTES);

        $user->update([
            'login_attempts' => $attempts,
            'locked_until' => $lockedUntil,
        ]);

        Cache::put(
            $this->cacheKey($user->email),
            $lockedUntil->toIso8601String(),
            $lockedUntil
        );

        Log::warning("User {$user->email} locked until {$lockedUntil} (attempts: {$attempts})");
    }

    private function clearIfExpired(User $user): void
    {
        if ($user->locked_until === null) {
            return;
        }

        if (Carbon::parse($user->locked_until)->isFuture()) {
            return;
        }

        Cache::forget($this->cacheKey($user->email));

        $user->update([
            'login_attempts' => 0,
            'locked_until' => null,
        ]);
    }

    private function cacheKey(string $email): string
    {
        return 'login_lockout:'.mb_strtolower(trim($email));
    }
}
