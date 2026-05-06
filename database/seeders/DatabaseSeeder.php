<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
<<<<<<< HEAD
use App\Models\User;
use App\Services\BuiltinCollectionsSync;
=======
>>>>>>> e3a0717bac623e7789a121de1a25aa2df13d4476
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
<<<<<<< HEAD
        $this->call([
            CharacterSeeder::class,
            ArticleSeeder::class,
            AchievementSeeder::class,
        ]);

        $sync = app(BuiltinCollectionsSync::class);
        User::query()->orderBy('id')->each(function (User $user) use ($sync) {
            $sync->syncForUser($user);
        });
=======
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
>>>>>>> e3a0717bac623e7789a121de1a25aa2df13d4476
    }
}
