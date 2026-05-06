<?php

namespace App\Providers;

<<<<<<< HEAD
use App\Models\User;
use App\Services\BuiltinCollectionsSync;
use Illuminate\Support\Facades\Schema;
=======
>>>>>>> e3a0717bac623e7789a121de1a25aa2df13d4476
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
<<<<<<< HEAD
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        User::created(function (User $user) {
            app(BuiltinCollectionsSync::class)->syncForUser($user);
        });
=======
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
        //
>>>>>>> e3a0717bac623e7789a121de1a25aa2df13d4476
    }
}
