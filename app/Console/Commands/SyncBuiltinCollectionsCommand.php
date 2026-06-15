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

        if ($userId !== null) {
            $user = User::query()->findOrFail((int) $userId);
            $sync->syncForUser($user);
            $this->info('Готово. Обработан пользователь #'.$user->id.'.');

            return self::SUCCESS;
        }

        $count = $sync->syncAllUsers();

        $this->info("Готово. Обработано пользователей: {$count}.");

        return self::SUCCESS;
    }
}
