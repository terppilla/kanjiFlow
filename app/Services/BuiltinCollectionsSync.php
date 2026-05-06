<?php

namespace App\Services;

use App\Models\BuiltinCollectionTemplate;
use App\Models\Character;
use App\Models\Collection;
use App\Models\User;
use Illuminate\Support\Facades\Schema;

class BuiltinCollectionsSync
{
    /**
     * @return array<string, array{name: string, characters: list<string>}>
     */
    public function definitions(): array
    {
        if (! Schema::hasTable('builtin_collection_templates')) {
            return $this->fallbackDefinitions();
        }

        $templates = BuiltinCollectionTemplate::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->with(['characters'])
            ->get();

        if ($templates->isEmpty()) {
            return $this->fallbackDefinitions();
        }

        $out = [];
        foreach ($templates as $template) {
            $out[$template->slug] = [
                'name' => $template->name,
                'characters' => $template->characters->pluck('character')->all(),
            ];
        }

        return $out;
    }

    /**
     * @return array<string, array{name: string, characters: list<string>}>
     */
    private function fallbackDefinitions(): array
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
        $definitions = $this->definitions();

        $glyphs = collect($definitions)
            ->pluck('characters')
            ->flatten()
            ->unique()
            ->values()
            ->all();

        $charactersReady = Character::query()->exists();

        $byChar = $charactersReady
            ? Character::query()
                ->whereIn('character', $glyphs)
                ->pluck('id', 'character')
            : collect();

        foreach ($definitions as $slug => $def) {
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

            if ($collection->name !== $def['name']) {
                $collection->update(['name' => $def['name']]);
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
        }

        // Убрать у пользователя встроенные подборки, которых больше нет в шаблонах
        $allowedSlugs = array_keys($definitions);
        Collection::query()
            ->where('user_id', $user->id)
            ->where('is_builtin', true)
            ->whereNotNull('builtin_slug')
            ->whereNotIn('builtin_slug', $allowedSlugs)
            ->delete();
    }
}
