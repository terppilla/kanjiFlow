<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\LoginLockoutService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class LoginLockoutServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_lockout_is_stored_in_database_and_cache(): void
    {
        $user = User::factory()->create([
            'login_attempts' => 4,
            'locked_until' => null,
        ]);

        $service = app(LoginLockoutService::class);
        $user = $service->recordFailedAttempt($user);

        $this->assertTrue($service->isLocked($user));
        $this->assertNotNull($user->locked_until);
        $this->assertTrue(Cache::has('login_lockout:'.mb_strtolower($user->email)));
    }
}
