<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BuiltinCollectionTemplate;
use App\Models\Character;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BuiltinCollectionTemplateController extends Controller
{
    public function index()
    {
        $templates = BuiltinCollectionTemplate::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->withCount('characters')
            ->get();

        return view('admin.builtin_collections.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.builtin_collections.create', [
            'initialCharacters' => [],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => ['required', 'string', 'max:64', 'regex:/^[a-z0-9][a-z0-9_-]*$/', Rule::unique('builtin_collection_templates', 'slug')],
            'name' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999999'],
            'character_ids' => ['required', 'string'],
        ]);

        $orderedIds = $this->decodeCharacterIdsPayload($validated['character_ids']);
        if ($orderedIds === null) {
            return back()
                ->withErrors(['character_ids' => 'Добавьте хотя бы один иероглиф из базы (поиск или импорт JSON).'])
                ->withInput();
        }

        $template = BuiltinCollectionTemplate::create([
            'slug' => $validated['slug'],
            'name' => $validated['name'],
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        $this->syncCharacterIds($template, $orderedIds);
        $template->refresh();
        if ($template->characters()->count() === 0) {
            $template->delete();

            return back()
                ->withErrors(['character_ids' => 'Не удалось сохранить состав подборки. Проверьте данные.'])
                ->withInput();
        }

        return redirect()->route('admin.builtin-collections.index')->with('success', 'Шаблон тематической подборки создан.');
    }

    public function edit(BuiltinCollectionTemplate $template)
    {
        $template->load(['characters' => fn ($q) => $q->orderByPivot('sort_order')]);

        $initialCharacters = $template->characters->map(fn (Character $c) => [
            'id' => $c->id,
            'character' => $c->character,
            'pinyin' => $c->pinyin,
            'meaning' => $c->meaning,
            'hsk_level' => $c->hsk_level,
        ])->values()->all();

        return view('admin.builtin_collections.edit', compact('template', 'initialCharacters'));
    }

    public function update(Request $request, BuiltinCollectionTemplate $template)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999999'],
            'character_ids' => ['required', 'string'],
        ]);

        $orderedIds = $this->decodeCharacterIdsPayload($validated['character_ids']);
        if ($orderedIds === null) {
            return back()
                ->withErrors(['character_ids' => 'Должен остаться хотя бы один иероглиф из базы в списке.'])
                ->withInput();
        }

        $template->update([
            'name' => $validated['name'],
            'sort_order' => $validated['sort_order'] ?? $template->sort_order,
        ]);

        $this->syncCharacterIds($template, $orderedIds);
        $template->refresh();
        if ($template->characters()->count() === 0) {
            return back()
                ->withErrors(['character_ids' => 'Должен остаться хотя бы один иероглиф из базы в списке.'])
                ->withInput();
        }

        Collection::query()
            ->where('is_builtin', true)
            ->where('builtin_slug', $template->slug)
            ->update(['name' => $template->name]);

        return redirect()->route('admin.builtin-collections.index')->with('success', 'Шаблон обновлён.');
    }

    public function destroy(BuiltinCollectionTemplate $template)
    {
        $slug = $template->slug;
        Collection::query()->where('is_builtin', true)->where('builtin_slug', $slug)->delete();
        $template->delete();

        return redirect()->route('admin.builtin-collections.index')->with('success', 'Шаблон удалён; встроенные подборки с этим кодом у пользователей удалены.');
    }

    public function syncAll()
    {
        Artisan::call('collections:sync-builtin');

        return redirect()->route('admin.builtin-collections.index')->with('success', 'Встроенные подборки обновлены у всех пользователей (команда collections:sync-builtin).');
    }

    /**
     * Поиск иероглифов для подборки (как у пользователя в коллекции).
     */
    public function searchCharacters(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        if (mb_strlen($q) < 1) {
            return response()->json(['characters' => []]);
        }

        $characters = Character::query()
            ->where(function ($query) use ($q) {
                $query->where('meaning', 'like', '%'.$q.'%')
                    ->orWhere('pinyin', 'like', '%'.$q.'%')
                    ->orWhere('character', 'like', '%'.$q.'%');
            })
            ->orderBy('id')
            ->limit(25)
            ->get(['id', 'character', 'pinyin', 'meaning', 'hsk_level']);

        return response()->json(['characters' => $characters]);
    }

    /**
     * Восстановить строки таблицы после ошибки валидации (только id в скрытом поле).
     */
    public function resolveCharacters(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:characters,id'],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        /** @var list<int> $ids */
        $ids = array_map('intval', $validator->validated()['ids']);
        $characters = Character::query()
            ->whereIn('id', $ids)
            ->get(['id', 'character', 'pinyin', 'meaning', 'hsk_level']);

        $byId = $characters->keyBy('id');
        $ordered = [];
        foreach ($ids as $id) {
            if ($byId->has($id)) {
                $ordered[] = $byId->get($id);
            }
        }

        return response()->json(['characters' => $ordered]);
    }

    /**
     * Импорт списка строк или объектов из JSON — сопоставление с базой по полю «character».
     */
    public function importGlyphsJson(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'json_file' => ['required', 'file', 'max:2048'],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $file = $request->file('json_file');
        $ext = strtolower((string) $file->getClientOriginalExtension());
        if (! in_array($ext, ['json', 'txt'], true)) {
            return response()->json(['message' => 'Разрешены только файлы .json или .txt.'], 422);
        }

        $contents = file_get_contents($file->getRealPath());
        if ($contents === false) {
            return response()->json(['message' => 'Не удалось прочитать файл.'], 422);
        }

        $decoded = json_decode($contents, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['message' => 'Невалидный JSON: '.json_last_error_msg()], 422);
        }

        $list = $this->normalizeImportList($decoded);
        if ($list === []) {
            return response()->json(['message' => 'Ожидается непустой массив строк или объектов с полем character.', 'characters' => [], 'missing' => []], 422);
        }

        $glyphStrings = $this->extractGlyphStringsFromImportItems($list);
        if ($glyphStrings === []) {
            return response()->json([
                'message' => 'В файле нет строк с текстом иероглифа или объектов с полем «character».',
                'characters' => [],
                'missing' => [],
            ], 422);
        }

        $resolved = [];
        $missing = [];
        $seenGlyph = [];

        foreach ($glyphStrings as $g) {
            if (isset($seenGlyph[$g])) {
                continue;
            }
            $seenGlyph[$g] = true;

            $character = Character::query()->where('character', $g)->first();
            if ($character === null) {
                $missing[] = $g;

                continue;
            }

            $resolved[] = [
                'id' => $character->id,
                'character' => $character->character,
                'pinyin' => $character->pinyin,
                'meaning' => $character->meaning,
                'hsk_level' => $character->hsk_level,
            ];
        }

        return response()->json([
            'characters' => $resolved,
            'missing' => $missing,
        ]);
    }

    /**
     * @return list<int>|null
     */
    private function decodeCharacterIdsPayload(string $json): ?array
    {
        $decoded = json_decode($json, true);
        if (! is_array($decoded)) {
            return null;
        }

        $seen = [];
        $ordered = [];
        foreach ($decoded as $raw) {
            $id = (int) $raw;
            if ($id <= 0 || isset($seen[$id])) {
                continue;
            }
            if (! Character::query()->whereKey($id)->exists()) {
                continue;
            }
            $seen[$id] = true;
            $ordered[] = $id;
        }

        return $ordered === [] ? null : $ordered;
    }

    /**
     * @param  list<int>  $orderedIds
     */
    private function syncCharacterIds(BuiltinCollectionTemplate $template, array $orderedIds): void
    {
        $sync = [];
        $order = 0;
        foreach ($orderedIds as $id) {
            $sync[(int) $id] = ['sort_order' => $order++];
        }
        $template->characters()->sync($sync);
    }

    /**
     * @return list<mixed>
     */
    private function normalizeImportList(mixed $decoded): array
    {
        if (! is_array($decoded)) {
            return [];
        }

        if ($decoded !== [] && array_keys($decoded) === range(0, count($decoded) - 1)) {
            return $decoded;
        }

        if (isset($decoded['characters']) && is_array($decoded['characters'])) {
            return $decoded['characters'];
        }

        return [];
    }

    /**
     * @param  list<mixed>  $items
     * @return list<string>
     */
    private function extractGlyphStringsFromImportItems(array $items): array
    {
        $out = [];
        foreach ($items as $item) {
            if (is_string($item)) {
                $t = trim($item);
                if ($t !== '') {
                    $out[] = $t;
                }

                continue;
            }

            if (is_array($item) && isset($item['character']) && is_string($item['character'])) {
                $t = trim($item['character']);
                if ($t !== '') {
                    $out[] = $t;
                }
            }
        }

        return $out;
    }
}
