<?php

namespace App\Console\Commands;

use App\Models\Character;
use App\Models\User;
use App\Services\BuiltinCollectionsSync;
use Illuminate\Console\Command;

class SyncBuiltinCollectionsCommand extends Command
{
    protected $signature = 'collections:sync-builtin {--user= : ID пользователя (по умолчанию — все)}';

    protected $description = 'Создать или обновить встроенные тематические коллекции у пользователей';

    public function handle(BuiltinCollectionsSync $sync): int
    {
        if (! Character::query()->exists()) {
            $this->error('Таблица characters пуста — нечего добавлять в коллекции.');
            $this->line('Выполните: php artisan db:seed --class=CharacterSeeder');
            $this->line('или полный сид: php artisan db:seed');

            return self::FAILURE;
        }

        $userId = $this->option('user');

        $query = User::query()->orderBy('id');
        if ($userId !== null) {
            $query->where('id', (int) $userId);
        }

        $count = 0;
        $query->each(function (User $user) use ($sync, &$count) {
            $sync->syncForUser($user);
            $count++;
        });

        $this->info("Готово. Обработано пользователей: {$count}.");

        return self::SUCCESS;
    }
}
