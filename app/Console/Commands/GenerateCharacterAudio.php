<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Character;
use Bestmomo\LaravelEdgeTts\Contracts\TtsSynthesizer;
use Illuminate\Support\Facades\Storage;

class GenerateCharacterAudio extends Command
{
    protected $signature = 'characters:generate-audio';
    protected $description = 'Генерирует аудио для иероглифов и примеров их использования';

    protected TtsSynthesizer $tts;

    public function __construct(TtsSynthesizer $tts)
    {
        parent::__construct();
        $this->tts = $tts;
    }

    public function handle()
    {
        $characters = Character::all();
        $this->info("Найдено иероглифов: {$characters->count()}");

        foreach ($characters as $character) {
            $this->line("Обработка: {$character->character}");

            // 1. Генерация аудио для самого иероглифа
            if (empty($character->audio_character) && !empty($character->pinyin)) {
                $audioPath = $this->generateAudio($character->pinyin, $character->character);
                if ($audioPath) {
                    $character->audio_character = $audioPath;
                    $this->info("  ✓ Аудио иероглифа создано");
                }
            }

            // 2. Генерация аудио для примера предложения
            if (empty($character->audio_example) && !empty($character->example_pinyin)) {
                $audioPath = $this->generateAudio($character->example_pinyin, $character->character . '_example');
                if ($audioPath) {
                    $character->audio_example = $audioPath;
                    $this->info("  ✓ Аудио примера создано");
                }
            }

            $character->save();
        }

        $this->newLine();
        $this->info('Генерация завершена');
    }

    private function generateAudio(string $text, string $identifier): ?string
    {
        try {
            $filename = 'audio/' . $identifier . '.mp3';
            $fullPath = storage_path('app/public/' . $filename);

            $this->tts->toFile($text, 'zh-CN-XiaoxiaoNeural', $fullPath);

            return '/storage/' . $filename;
        } catch (\Exception $e) {
            $this->error("  Ошибка: {$e->getMessage()}");
            return null;
        }
    }
}