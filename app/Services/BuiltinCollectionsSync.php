<?php

namespace App\Services;

use App\Models\Character;
use App\Models\Collection;
use App\Models\User;
use Illuminate\Support\Collection as SupportCollection;

class BuiltinCollectionsSync
{
    // #region agent log
    private function agentDebugLog(string $hypothesisId, string $location, string $message, array $data = []): void
    {
        $path = base_path('debug-37bbcf.log');
        $line = json_encode([
            'sessionId' => '37bbcf',
            'hypothesisId' => $hypothesisId,
            'location' => $location,
            'message' => $message,
            'data' => $data,
            'timestamp' => (int) round(microtime(true) * 1000),
        ], JSON_UNESCAPED_UNICODE);
        file_put_contents($path, $line."\n", FILE_APPEND | LOCK_EX);
    }
    // #endregion

    /**
     * @return array<string, array{name: string, characters: list<string>}>
     */
    public function definitions(): array
    {
        return [
            'people' => [
                'name' => 'Люди и общение',
                'characters' => ['我', '你', '他', '她', '我们', '朋友', '家', '爱', '这', '那'],
            ],
            'verbs' => [
                'name' => 'Бытовые действия',
                'characters' => ['吃', '喝', '看', '听', '说', '学', '去', '来', '做', '买'],
            ],
            'time_scale' => [
                'name' => 'Время и размеры',
                'characters' => ['天', '月', '年', '时间', '大', '小', '多', '少', '上', '下'],
            ],
            'function_words' => [
                'name' => 'Базовые служебные слова',
                'characters' => ['有', '没', '在', '不', '很', '和', '也', '都', '中', '国'],
            ],
        ];
    }

    public function syncForUser(User $user): void
    {
        $glyphs = SupportCollection::make($this->definitions())
            ->pluck('characters')
            ->flatten()
            ->unique()
            ->values()
            ->all();

        $charactersReady = Character::query()->exists();
        $totalCharsInDb = Character::query()->count();

        // #region agent log
        $this->agentDebugLog('H1', 'BuiltinCollectionsSync::syncForUser', 'characters table state', [
            'userId' => $user->id,
            'charactersReady' => $charactersReady,
            'totalCharsInDb' => $totalCharsInDb,
            'glyphsRequested' => count($glyphs),
        ]);
        // #endregion

        $byChar = $charactersReady
            ? Character::query()
                ->whereIn('character', $glyphs)
                ->pluck('id', 'character')
            : collect();

        // #region agent log
        $this->agentDebugLog('H2', 'BuiltinCollectionsSync::syncForUser', 'whereIn pluck result', [
            'byCharCount' => $byChar->count(),
            'sampleKeysFromDb' => $byChar->keys()->take(5)->values()->all(),
        ]);
        // #endregion

        foreach ($this->definitions() as $slug => $def) {
            $collection = Collection::query()->firstOrCreate(
                [
                    'user_id' => $user->id,
                    'builtin_slug' => $slug,
                ],
                [
                    'name' => $def['name'],
                    'is_builtin' => true,
                ]
            );

            if (! $collection->is_builtin) {
                $collection->update(['is_builtin' => true]);
            }

            if (! $charactersReady) {
                continue;
            }

            $ids = [];
            foreach ($def['characters'] as $ch) {
                $id = $byChar[$ch] ?? null;
                if ($id !== null) {
                    $ids[] = (int) $id;
                }
            }

            $collection->characters()->sync($ids);

            // #region agent log
            $this->agentDebugLog('H3', 'BuiltinCollectionsSync::syncForUser', 'collection synced', [
                'slug' => $slug,
                'collectionId' => $collection->id,
                'idsAttachedCount' => count($ids),
            ]);
            // #endregion
        }
    }
}
