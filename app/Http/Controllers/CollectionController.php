<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Collection;
use App\Models\UserCharacter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CollectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $collections = Auth::user()
            ->collections()
            ->withCount('characters')
            ->orderByDesc('is_builtin')
            ->orderBy('builtin_slug')
            ->latest('id')
            ->get();

        return view('user.collections.index', compact('collections'));
    }

    public function create()
    {
        return view('user.collections.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
        ]);

        $collection = Auth::user()->collections()->create([
            'name' => trim($data['name']),
        ]);

        return redirect()
            ->route('collections.show', $collection)
            ->with('success', 'Коллекция создана. Добавьте иероглифы.');
    }

    public function show(Collection $collection)
    {
        $this->authorizeCollection($collection);

        $collection->load(['characters' => function ($q) {
            $q->orderByPivot('id');
        }]);

        $learnedCharacterIds = UserCharacter::where('user_id', Auth::id())
            ->where('is_learned', true)
            ->pluck('character_id')
            ->all();

        return view('user.collections.show', compact('collection', 'learnedCharacterIds'));
    }

    public function edit(Collection $collection)
    {
        $this->authorizeCollection($collection);

        return view('user.collections.edit', compact('collection'));
    }

    public function update(Request $request, Collection $collection)
    {
        $this->authorizeCollection($collection);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
        ]);

        $collection->update(['name' => trim($data['name'])]);

        return redirect()
            ->route('collections.show', $collection)
            ->with('success', 'Название обновлено.');
    }

    public function destroy(Collection $collection)
    {
        $this->authorizeCollection($collection);

        if ($collection->is_builtin) {
            return redirect()
                ->route('collections.index')
                ->withErrors('Встроенные подборки нельзя удалить.');
        }

        $collection->delete();

        return redirect()
            ->route('collections.index')
            ->with('success', 'Коллекция удалена.');
    }

    public function addCharacter(Request $request, Collection $collection)
    {
        $this->authorizeCollection($collection);

        $data = $request->validate([
            'character_id' => ['required', 'integer', 'exists:characters,id'],
        ]);

        if ($collection->characters()->where('characters.id', $data['character_id'])->exists()) {
            return back()->with('info', 'Этот иероглиф уже в коллекции.');
        }

        $collection->characters()->attach($data['character_id']);

        return back()->with('success', 'Иероглиф добавлен.');
    }

    public function addMultipleCharacters(Request $request, Collection $collection)
    {
        $this->authorizeCollection($collection);

        $data = $request->validate([
            'character_ids' => ['required', 'array', 'min:1'],
            'character_ids.*' => ['integer', 'exists:characters,id'],
        ]);

        $existing = $collection->characters()->pluck('characters.id')->all();
        $toAttach = array_values(array_diff($data['character_ids'], $existing));

        if ($toAttach === []) {
            return back()->with('info', 'Все выбранные иероглифы уже в коллекции.');
        }

        $collection->characters()->attach($toAttach);

        return back()->with('success', 'Добавлено иероглифов: ' . count($toAttach));
    }

    public function removeCharacter(Collection $collection, Character $character)
    {
        $this->authorizeCollection($collection);

        $collection->characters()->detach($character->id);

        return back()->with('success', 'Иероглиф убран из коллекции.');
    }

    /**
     * Поиск иероглифов для автодополнения (добавление в коллекцию).
     */
    public function searchCharacters(Request $request, Collection $collection)
    {
        $this->authorizeCollection($collection);

        $q = trim((string) $request->get('q', ''));
        if (mb_strlen($q) < 1) {
            return response()->json(['characters' => []]);
        }

        $characters = Character::query()
            ->where(function ($query) use ($q) {
                $query->where('meaning', 'like', '%' . $q . '%')
                    ->orWhere('pinyin', 'like', '%' . $q . '%')
                    ->orWhere('character', 'like', '%' . $q . '%');
            })
            ->orderBy('id')
            ->limit(25)
            ->get(['id', 'character', 'pinyin', 'meaning', 'hsk_level']);

        return response()->json(['characters' => $characters]);
    }

    public function review(Collection $collection)
    {
        $this->authorizeCollection($collection);

        return redirect()->route('learning.collection.level', $collection);
    }

    private function authorizeCollection(Collection $collection): void
    {
        abort_unless($collection->user_id === Auth::id(), 403);
    }
}
