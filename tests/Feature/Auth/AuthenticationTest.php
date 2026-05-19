<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create([
            'two_factor_enabled' => false,
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_users_with_two_factor_redirected_to_verify_after_login(): void
    {
        $user = User::factory()->create([
            'two_factor_enabled' => true,
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertGuest();
        $response->assertRedirect(route('two-factor.verify'));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_account_is_locked_after_too_many_failed_login_attempts(): void
    {
        $user = User::factory()->create([
            'two_factor_enabled' => false,
        ]);

        for ($i = 0; $i < 5; $i++) {
            $response = $this->from('/login')->post('/login', [
                'email' => $user->email,
                'password' => 'wrong-password',
            ]);

            $this->assertGuest();
        }

        $user->refresh();

        $this->assertNotNull($user->locked_until);
        $this->assertTrue($user->locked_until->isFuture());

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('account_locked', true);
        $response->assertSessionHas('lockout_until');
        $response->assertSessionMissing('login_error');

        $response = $this->withSession([
            'account_locked' => true,
            'lockout_until' => $user->locked_until->toIso8601String(),
            '_old_input' => ['email' => $user->email],
        ])->get(route('login'));

        $response->assertOk();
        $response->assertSee('Аккаунт временно заблокирован', false);
        $response->assertSee('lockout-timer', false);
        $response->assertDontSee('Неверный email или пароль', false);
        $response->assertDontSee('form-error', false);

        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertGuest();
        $response->assertSessionHas('account_locked', true);
        $response->assertSessionMissing('errors');
    }

    public function test_existing_attempt_count_without_lockout_is_restored_on_login(): void
    {
        $user = User::factory()->create([
            'two_factor_enabled' => false,
            'login_attempts' => 6,
            'locked_until' => null,
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $user->refresh();

        $this->assertNotNull($user->locked_until);
        $this->assertTrue($user->locked_until->isFuture());
        $response->assertSessionHas('account_locked', true);
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
