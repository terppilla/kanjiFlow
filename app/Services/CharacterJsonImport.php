<?php

namespace App\Services;

class CharacterJsonImport
{
    /** Ключи как в database/data/characters.json */
    public const SCHEMA_KEYS = [
        'character',
        'pinyin',
        'meaning',
        'hsk_level',
        'example_hanzi',
        'example_pinyin',
        'example_translation',
        'audio',
    ];

    /**
     * @return array{ok: bool, errors: list<string>, items: list<array<string, mixed>>}
     */
    public function decodeAndValidate(string $json): array
    {
        $decoded = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return [
                'ok' => false,
                'errors' => ['Невалидный JSON: ' . json_last_error_msg()],
                'items' => [],
            ];
        }

        if (! is_array($decoded)) {
            return [
                'ok' => false,
                'errors' => ['Ожидается JSON-массив объектов иероглифов.'],
                'items' => [],
            ];
        }

        $errors = [];
        $normalized = [];
        $seenCharacters = [];

        foreach ($decoded as $index => $row) {
            $line = $index + 1;
            if (! is_array($row)) {
                $errors[] = "Строка {$line}: элемент должен быть объектом.";
                continue;
            }

            $unknown = array_diff(array_keys($row), self::SCHEMA_KEYS);
            if ($unknown !== []) {
                $errors[] = "Строка {$line}: неизвестные поля: " . implode(', ', $unknown) . '. Допустимы только: "'
                    . implode('", "', self::SCHEMA_KEYS) . '".';
            }

            foreach (['character', 'pinyin', 'meaning', 'hsk_level'] as $key) {
                if (! array_key_exists($key, $row)) {
                    $errors[] = "Строка {$line}: отсутствует обязательное поле \"{$key}\".";
                }
            }

            $char = isset($row['character']) && is_string($row['character'])
                ? trim($row['character'])
                : null;
            if ($char === null || $char === '') {
                $errors[] = "Строка {$line}: поле \"character\" должно быть непустой строкой.";
            } elseif (isset($seenCharacters[$char])) {
                $errors[] = "Строка {$line}: дубликат иероглифа «{$char}» (уже в строке {$seenCharacters[$char]}).";
            } else {
                $seenCharacters[$char] = $line;
            }

            if (isset($row['pinyin']) && ! is_string($row['pinyin'])) {
                $errors[] = "Строка {$line}: \"pinyin\" должно быть строкой.";
            } elseif (isset($row['pinyin']) && trim((string) $row['pinyin']) === '') {
                $errors[] = "Строка {$line}: \"pinyin\" не может быть пустым.";
            }

            if (isset($row['meaning']) && ! is_string($row['meaning'])) {
                $errors[] = "Строка {$line}: \"meaning\" должно быть строкой.";
            } elseif (isset($row['meaning']) && trim((string) $row['meaning']) === '') {
                $errors[] = "Строка {$line}: \"meaning\" не может быть пустым.";
            }

            if (isset($row['hsk_level'])) {
                if (! is_int($row['hsk_level']) || $row['hsk_level'] < 1 || $row['hsk_level'] > 6) {
                    $errors[] = "Строка {$line}: \"hsk_level\" должно быть целым числом от 1 до 6.";
                }
            }

            foreach (['example_hanzi', 'example_pinyin', 'example_translation'] as $opt) {
                if (! array_key_exists($opt, $row)) {
                    $errors[] = "Строка {$line}: отсутствует поле \"{$opt}\" (задайте строку или null, как в characters.json).";
                    continue;
                }
                $v = $row[$opt];
                if ($v !== null && ! is_string($v)) {
                    $errors[] = "Строка {$line}: \"{$opt}\" должно быть строкой или null.";
                }
            }

            if (! array_key_exists('audio', $row)) {
                $errors[] = "Строка {$line}: отсутствует поле \"audio\" (обычно null).";
            } elseif ($row['audio'] !== null && ! is_string($row['audio'])) {
                $errors[] = "Строка {$line}: \"audio\" должно быть строкой или null.";
            }

            if (count($errors) >= 50) {
                $errors[] = 'Слишком много ошибок, проверка остановлена.';
                break;
            }
        }

        if ($errors !== []) {
            return ['ok' => false, 'errors' => $errors, 'items' => []];
        }

        foreach ($decoded as $row) {
            $normalized[] = $this->normalizeRow($row);
        }

        usort($normalized, function (array $a, array $b): int {
            $lvl = $a['hsk_level'] <=> $b['hsk_level'];
            if ($lvl !== 0) {
                return $lvl;
            }

            return strcmp($a['character'], $b['character']);
        });

        return ['ok' => true, 'errors' => [], 'items' => $normalized];
    }

    /**
     * @param  array<string, mixed>  $row
     * @return array{character: string, pinyin: string, meaning: string, hsk_level: int, example_hanzi: ?string, example_pinyin: ?string, example_translation: ?string, audio_raw: string|null}
     */
    private function normalizeRow(array $row): array
    {
        $audio = $row['audio'];
        $audioStr = is_string($audio) ? trim($audio) : null;

        return [
            'character' => trim((string) $row['character']),
            'pinyin' => trim((string) $row['pinyin']),
            'meaning' => trim((string) $row['meaning']),
            'hsk_level' => (int) $row['hsk_level'],
            'example_hanzi' => $this->nullableString($row['example_hanzi']),
            'example_pinyin' => $this->nullableString($row['example_pinyin']),
            'example_translation' => $this->nullableString($row['example_translation']),
            'audio_raw' => ($audioStr === null || $audioStr === '') ? null : $audioStr,
        ];
    }

    private function nullableString(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $s = trim((string) $value);

        return $s === '' ? null : $s;
    }
}
