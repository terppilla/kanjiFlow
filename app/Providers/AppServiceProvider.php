<?php

namespace App\Providers;

use App\Models\User;
use App\Services\BuiltinCollectionsSync;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        User::created(function (User $user) {
            app(BuiltinCollectionsSync::class)->syncForUser($user);
        });
    }
}
