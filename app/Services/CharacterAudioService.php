<?php

namespace App\Services;

use App\Models\Character;
use Bestmomo\LaravelEdgeTts\Contracts\TtsSynthesizer;
use Illuminate\Support\Facades\Cache;

class CharacterAudioService
{
    public const VOICE = 'zh-CN-XiaoxiaoNeural';

    /** Сколько иероглифов обрабатывать за один HTTP-запрос (Edge TTS медленный). */
    public const BULK_BATCH_SIZE = 8;

    public function __construct(
        private readonly TtsSynthesizer $tts,
    ) {}

    public function prepareLongRunning(int $seconds = 300): void
    {
        if (function_exists('set_time_limit')) {
            @set_time_limit($seconds);
        }
        if (function_exists('ini_set')) {
            @ini_set('max_execution_time', (string) $seconds);
        }
    }

    /**
     * @return array{success: bool, path?: string, message: string}
     */
    public function generateCharacterAudio(Character $character): array
    {
        $text = trim((string) $character->pinyin);
        if ($text === '') {
            return ['success' => false, 'message' => 'Укажите пиньинь для озвучки иероглифа.'];
        }

        $path = $this->synthesizeToStorage($text, $this->characterFileSlug($character->character));
        if ($path === null) {
            return ['success' => false, 'message' => 'Не удалось сгенерировать аудио иероглифа.'];
        }

        $character->audio_character = $path;
        $character->save();

        return ['success' => true, 'path' => $path, 'message' => 'Аудио иероглифа создано.'];
    }

    /**
     * @return array{success: bool, path?: string, message: string}
     */
    public function generateExampleAudio(Character $character): array
    {
        $text = $character->exampleSpeechForTts();
        if ($text === null || $text === '') {
            return ['success' => false, 'message' => 'Заполните пример на китайском или пиньинь примера.'];
        }

        $path = $this->synthesizeToStorage($text, $this->exampleFileSlug($character->character));
        if ($path === null) {
            return ['success' => false, 'message' => 'Не удалось сгенерировать аудио примера.'];
        }

        $character->audio_example = $path;
        $character->save();

        return ['success' => true, 'path' => $path, 'message' => 'Аудио примера создано.'];
    }

    /**
     * Preview for create form (no DB record yet).
     *
     * @return array{success: bool, path?: string, message: string}
     */
    public function generatePreview(string $text, string $glyph, string $kind): array
    {
        $text = trim($text);
        $glyph = trim($glyph);
        if ($text === '') {
            return ['success' => false, 'message' => 'Нет текста для озвучки.'];
        }
        if ($glyph === '') {
            return ['success' => false, 'message' => 'Сначала укажите иероглиф.'];
        }

        $slug = $kind === 'example'
            ? $this->exampleFileSlug($glyph)
            : $this->characterFileSlug($glyph);

        $path = $this->synthesizeToStorage($text, $slug);
        if ($path === null) {
            return ['success' => false, 'message' => 'Не удалось сгенерировать аудио.'];
        }

        return ['success' => true, 'path' => $path, 'message' => 'Аудио сгенерировано.'];
    }

    /**
     * Порция массовой генерации для веб-интерфейса.
     *
     * @return array{character: int, example: int, errors: list<string>, processed: int, remaining: int}
     */
    public function generateMissingBatch(int $limit = self::BULK_BATCH_SIZE): array
    {
        $this->prepareLongRunning(max(120, $limit * 25));

        $stats = ['character' => 0, 'example' => 0, 'errors' => [], 'processed' => 0, 'remaining' => 0];

        foreach (Character::query()->orderBy('id')->cursor() as $character) {
            $needsChar = $this->needsCharacterAudio($character);
            $needsEx = $this->needsExampleAudio($character);

            if (! $needsChar && ! $needsEx) {
                continue;
            }

            if ($stats['processed'] >= $limit) {
                $stats['remaining']++;

                continue;
            }

            $stats['processed']++;

            if ($needsChar) {
                $result = $this->generateCharacterAudio($character);
                if ($result['success']) {
                    $stats['character']++;
                } else {
                    $stats['errors'][] = $character->character . ': ' . $result['message'];
                }
            }

            $character->refresh();

            if ($this->needsExampleAudio($character)) {
                $result = $this->generateExampleAudio($character);
                if ($result['success']) {
                    $stats['example']++;
                } else {
                    $stats['errors'][] = $character->character . ' (пример): ' . $result['message'];
                }
            }
        }

        return $stats;
    }

    /**
     * @return array{character: int, example: int, errors: list<string>}
     */
    public function generateMissingForCharacters(iterable $characters): array
    {
        $this->prepareLongRunning(300);

        $stats = ['character' => 0, 'example' => 0, 'errors' => []];

        foreach ($characters as $character) {
            if (! $character instanceof Character) {
                continue;
            }

            if ($this->needsCharacterAudio($character)) {
                $result = $this->generateCharacterAudio($character);
                if ($result['success']) {
                    $stats['character']++;
                } else {
                    $stats['errors'][] = $character->character . ': ' . $result['message'];
                }
            }

            $character->refresh();

            if ($this->needsExampleAudio($character)) {
                $result = $this->generateExampleAudio($character);
                if ($result['success']) {
                    $stats['example']++;
                } else {
                    $stats['errors'][] = $character->character . ' (пример): ' . $result['message'];
                }
            }
        }

        return $stats;
    }

    public function needsCharacterAudio(Character $character): bool
    {
        if (trim((string) $character->pinyin) === '') {
            return false;
        }

        if (empty($character->audio_character)) {
            return true;
        }

        $abs = $this->absoluteStoragePath($character->audio_character);

        return ! is_file($abs) || filesize($abs) < 1;
    }

    public function needsExampleAudio(Character $character): bool
    {
        $speech = $character->exampleSpeechForTts();
        if ($speech === null || $speech === '') {
            return false;
        }

        if (empty($character->audio_example)) {
            return true;
        }

        $abs = $this->absoluteStoragePath($character->audio_example);

        return ! is_file($abs) || filesize($abs) < 1;
    }

    public function synthesizeToStorage(string $text, string $fileSlug): ?string
    {
        $this->prepareLongRunning(120);

        $filename = 'audio/' . $fileSlug . '.mp3';
        $fullPath = storage_path('app/public/' . $filename);
        $dir = dirname($fullPath);
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $this->forgetEdgeTtsCache($text);
        $this->tts->toFile($text, self::VOICE, $fullPath);

        if (! is_file($fullPath) || filesize($fullPath) < 1) {
            return null;
        }

        return '/storage/' . $filename;
    }

    public function characterFileSlug(string $glyph): string
    {
        return trim($glyph);
    }

    public function exampleFileSlug(string $glyph): string
    {
        return trim($glyph) . '_example';
    }

    public function absoluteStoragePath(string $stored): string
    {
        $rel = $stored;
        if (str_starts_with($rel, '/storage/')) {
            $rel = substr($rel, strlen('/storage/'));
        }
        $rel = ltrim($rel, '/');

        return storage_path('app/public/' . $rel);
    }

    private function forgetEdgeTtsCache(string $text, array $options = []): void
    {
        Cache::forget(md5(serialize([$text, self::VOICE, $options])));
    }
}
