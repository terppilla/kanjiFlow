<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Services\BuiltinCollectionsSync;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CharacterSeeder::class,
            ArticleSeeder::class,
            AchievementSeeder::class,
        ]);

        $sync = app(BuiltinCollectionsSync::class);
        User::query()->orderBy('id')->each(function (User $user) use ($sync) {
            $sync->syncForUser($user);
        });
    }
}
