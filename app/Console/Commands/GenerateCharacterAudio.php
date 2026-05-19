<?php

namespace App\Console\Commands;

use App\Models\Character;
use App\Services\CharacterAudioService;
use Illuminate\Console\Command;

class GenerateCharacterAudio extends Command
{
    protected $signature = 'characters:generate-audio';

    protected $description = 'Генерирует аудио для иероглифов и примеров их использования';

    public function __construct(
        private readonly CharacterAudioService $audio,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $characters = Character::all();
        $this->info("Найдено иероглифов: {$characters->count()}");

        foreach ($characters as $character) {
            $this->line("Обработка: {$character->character}");

            if ($this->audio->needsCharacterAudio($character)) {
                $result = $this->audio->generateCharacterAudio($character);
                if ($result['success']) {
                    $this->info('  ✓ Аудио иероглифа создано или обновлено');
                } else {
                    $this->error('  ' . $result['message']);
                }
            }

            $character->refresh();

            if ($this->audio->needsExampleAudio($character)) {
                $result = $this->audio->generateExampleAudio($character);
                if ($result['success']) {
                    $this->info('  ✓ Аудио примера создано или обновлено');
                } else {
                    $this->error('  ' . $result['message']);
                }
            }
        }

        $this->newLine();
        $this->info('Генерация завершена');

        return self::SUCCESS;
    }
}
