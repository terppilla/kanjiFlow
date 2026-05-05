<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Character;
use Bestmomo\LaravelEdgeTts\Contracts\TtsSynthesizer;
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

            // 1. Генерация аудио для самого иероглифа (в т.ч. перезапись пустых файлов на диске)
            if (! empty($character->pinyin) && $this->needsCharacterAudioRefresh($character)) {
                $audioPath = $this->generateAudio($character->pinyin, $character->character);
                if ($audioPath) {
                    $character->audio_character = $audioPath;
                    $this->info('  ✓ Аудио иероглифа создано или обновлено');
                }
            }

            // 2. Генерация аудио для примера предложения
            if (! empty($character->example_pinyin) && $this->needsExampleAudioRefresh($character)) {
                $audioPath = $this->generateAudio($character->example_pinyin, $character->character . '_example');
                if ($audioPath) {
                    $character->audio_example = $audioPath;
                    $this->info('  ✓ Аудио примера создано или обновлено');
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

            if (! is_file($fullPath) || filesize($fullPath) < 1) {
                $this->error('  Ошибка: TTS записал пустой файл');

                return null;
            }

            return '/storage/' . $filename;
        } catch (\Exception $e) {
            $this->error("  Ошибка: {$e->getMessage()}");

            return null;
        }
    }

    private function needsCharacterAudioRefresh(Character $character): bool
    {
        if (empty($character->audio_character)) {
            return true;
        }

        $abs = $this->absoluteStoragePath($character->audio_character);

        return ! is_file($abs) || filesize($abs) < 1;
    }

    private function needsExampleAudioRefresh(Character $character): bool
    {
        if (empty($character->audio_example)) {
            return true;
        }

        $abs = $this->absoluteStoragePath($character->audio_example);

        return ! is_file($abs) || filesize($abs) < 1;
    }

    /**
     * Значение из БД: /storage/audio/我.mp3 или audio/我.mp3
     */
    private function absoluteStoragePath(string $stored): string
    {
        $rel = $stored;
        if (str_starts_with($rel, '/storage/')) {
            $rel = substr($rel, strlen('/storage/'));
        }
        $rel = ltrim($rel, '/');

        return storage_path('app/public/' . $rel);
    }
}