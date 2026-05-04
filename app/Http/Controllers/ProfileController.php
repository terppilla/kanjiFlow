<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Включение или отключение двухфакторной аутентификации (отключение — только с подтверждением пароля).
     */
    public function updateTwoFactor(Request $request): RedirectResponse|JsonResponse
    {
        $user = $request->user();
        $enable = $request->boolean('two_factor_enabled');

        if ($enable) {
            if (! $user->two_factor_enabled) {
                $user->update([
                    'two_factor_enabled' => true,
                ]);
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'two_factor_enabled' => true,
                    'message' => 'Двухфакторная аутентификация включена.',
                ]);
            }

            return Redirect::route('profile.edit')->with('status', 'two-factor-enabled');
        }

        $request->validateWithBag('twoFactor', [
            'password' => ['required', 'current_password'],
        ]);

        $user->update([
            'two_factor_enabled' => false,
            'two_factor_code' => null,
            'two_factor_expires_at' => null,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'two_factor_enabled' => false,
                'message' => 'Двухфакторная аутентификация отключена.',
            ]);
        }

        return Redirect::route('profile.edit')->with('status', 'two-factor-disabled');
    }
}
