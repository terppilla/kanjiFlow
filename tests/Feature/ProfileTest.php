<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/profile');

        $response->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $user->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertSame('test@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => $user->email,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    public function test_user_can_delete_their_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete('/profile/account', [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
        $this->assertNull($user->fresh());
    }

    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->delete('/profile/account', [
                'password' => 'wrong-password',
            ]);

        $response
            ->assertSessionHasErrorsIn('userDeletion', 'password')
            ->assertRedirect('/profile');

        $this->assertNotNull($user->fresh());
    }

    public function test_user_can_disable_two_factor_with_password(): void
    {
        $user = User::factory()->create([
            'two_factor_enabled' => true,
        ]);

        $this->actingAs($user)
            ->from('/profile')
            ->patch('/profile/two-factor', [
                'two_factor_enabled' => false,
                'password' => 'password',
            ])
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->assertFalse($user->fresh()->two_factor_enabled);
    }

    public function test_user_cannot_disable_two_factor_without_password(): void
    {
        $user = User::factory()->create([
            'two_factor_enabled' => true,
        ]);

        $this->actingAs($user)
            ->from('/profile')
            ->patch('/profile/two-factor', [
                'two_factor_enabled' => false,
            ])
            ->assertSessionHasErrorsIn('twoFactor', 'password')
            ->assertRedirect('/profile');

        $this->assertTrue($user->fresh()->two_factor_enabled);
    }

    public function test_user_can_enable_two_factor_without_password(): void
    {
        $user = User::factory()->create([
            'two_factor_enabled' => false,
        ]);

        $this->actingAs($user)
            ->patch('/profile/two-factor', [
                'two_factor_enabled' => true,
            ])
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->assertTrue($user->fresh()->two_factor_enabled);
    }
}
