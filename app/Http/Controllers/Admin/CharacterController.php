<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Character;
use App\Models\CharacterSuggestion;
use App\Services\CharacterAudioService;
use App\Services\CharacterJsonImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CharacterController extends Controller
{
    public function __construct(
        private readonly CharacterAudioService $audio,
    ) {}

    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        $hsk = $request->get('hsk', '');
        $sort = (string) $request->get('sort', 'hsk_asc');

        $query = Character::query();

        if ($q !== '') {
            $query->where(function ($builder) use ($q) {
                $builder->where('character', 'like', '%' . $q . '%')
                    ->orWhere('pinyin', 'like', '%' . $q . '%')
                    ->orWhere('meaning', 'like', '%' . $q . '%');
            });
        }

        if ($hsk !== '' && $hsk !== null && in_array((int) $hsk, range(1, 6), true)) {
            $query->where('hsk_level', (int) $hsk);
        }

        match ($sort) {
            'hsk_desc' => $query->orderByDesc('hsk_level')->orderBy('character'),
            'newest' => $query->orderByDesc('id'),
            'oldest' => $query->orderBy('id'),
            default => $query->orderBy('hsk_level')->orderBy('character'),
        };

        $characters = $query->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return view('admin.characters.partials.list-content', compact('characters', 'q', 'hsk', 'sort'));
        }

        return view('admin.characters.index', compact('characters', 'q', 'hsk', 'sort'));
    }

    public function create(Request $request) {
        $suggestion = null;
        if ($request->filled('suggestion')) {
            $suggestion = CharacterSuggestion::query()
                ->where('status', CharacterSuggestion::STATUS_PENDING)
                ->with(['user:id,name,email', 'collection:id,name'])
                ->find($request->integer('suggestion'));
        }

        return view('admin.characters.create', compact('suggestion'));
    }

    public function store(Request $request) {
        $request->validate([
            'character'=>'required',
            'pinyin' => 'required',
            'hsk_level' => 'required|integer',
            'example_hanzi' => 'nullable|string',
            'example_pinyin' => 'nullable|string',
            'example_translation' => 'nullable|string',
            'audio_character' => 'nullable|string',
            'audio_example' => 'nullable|string',
            'meaning' => 'nullable|string',
            'character_suggestion_id' => ['nullable', 'integer', 'exists:character_suggestions,id'],
            'generate_audio' => ['sometimes', 'boolean'],
        ]);

        $character = Character::create([
            'character'=> $request ->input('character'),
            'pinyin'=>$request ->input('pinyin'),
            'meaning'=>$request->input('meaning'),
            'hsk_level'=>$request->input('hsk_level'),
            'example_hanzi'=>$request->input('example_hanzi'),
            'example_pinyin'=>$request->input('example_pinyin'),
            'example_translation'=>$request->input('example_translation'),
            'audio_character'=>$request->input('audio_character'),
            'audio_example'=>$request->input('audio_example'),
        ]);

        if ($request->boolean('generate_audio')) {
            $this->generateAudioForCharacter($character);
            $character->refresh();
        }

        if ($request->filled('character_suggestion_id')) {
            CharacterSuggestion::query()
                ->where('id', $request->integer('character_suggestion_id'))
                ->where('status', CharacterSuggestion::STATUS_PENDING)
                ->update([
                    'status' => CharacterSuggestion::STATUS_PROCESSED,
                    'processed_at' => now(),
                    'processed_by' => Auth::id(),
                ]);
        }

        return redirect()->route('admin.characters.index');
    }

    public function edit($id) {
        $character = Character::findOrFail($id);
        return view('admin.characters.edit', compact('character'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'character'=>'required',
            'pinyin' => 'required',
            'hsk_level' => 'required|integer',
            'example_hanzi' => 'nullable|string',
            'example_pinyin' => 'nullable|string',
            'example_translation' => 'nullable|string',
            'audio_character' => 'nullable|string',
            'audio_example' => 'nullable|string',
            'meaning' => 'nullable|string',
            'generate_audio' => ['sometimes', 'boolean'],
        ]);

        $character = Character::findOrFail($id);
        $character->update([
            'character'=> $request ->input('character'),
            'pinyin'=>$request ->input('pinyin'),
            'meaning'=>$request->input('meaning'),
            'hsk_level'=>$request->input('hsk_level'),
            'example_hanzi'=>$request->input('example_hanzi'),
            'example_pinyin'=>$request->input('example_pinyin'),
            'example_translation'=>$request->input('example_translation'),
            'audio_character'=>$request->input('audio_character'),
            'audio_example'=>$request->input('audio_example'),
        ]);

        if ($request->boolean('generate_audio')) {
            $this->generateAudioForCharacter($character);
        }

        return redirect()->route('admin.characters.index');
    }

    public function generateMissingAudio(Request $request)
    {
        $stats = $this->audio->generateMissingBatch();

        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json($stats);
        }

        $message = "За этот запуск: иероглифов — {$stats['character']}, примеров — {$stats['example']}.";
        if ($stats['remaining'] > 0) {
            $message .= " Осталось иероглифов без озвучки: {$stats['remaining']} — нажмите кнопку ещё раз.";
        }
        if ($stats['errors'] !== []) {
            $message .= ' Ошибки: ' . implode(' ', array_slice($stats['errors'], 0, 3));
        }

        return redirect()
            ->route('admin.characters.index')
            ->with('success', $message);
    }

    public function importJson(Request $request, CharacterJsonImport $importer)
    {
        $request->validate([
            'json_file' => ['required', 'file', 'max:5120'],
            'generate_audio' => ['sometimes', 'boolean'],
        ]);

        $file = $request->file('json_file');
        $ext = strtolower((string) $file->getClientOriginalExtension());
        if (! in_array($ext, ['json', 'txt'], true)) {
            return back()->withErrors([
                'json_file' => 'Разрешены только файлы с расширением .json или .txt.',
            ]);
        }

        $contents = file_get_contents($file->getRealPath());
        if ($contents === false) {
            return back()->withErrors(['json_file' => 'Не удалось прочитать файл.']);
        }

        $result = $importer->decodeAndValidate($contents);

        if (! $result['ok']) {
            return back()->with('import_errors', $result['errors']);
        }

        $created = 0;
        $updated = 0;
        $imported = [];

        DB::transaction(function () use ($result, &$created, &$updated, &$imported): void {
            foreach ($result['items'] as $item) {
                $model = Character::firstOrNew(['character' => $item['character']]);
                $wasExisting = $model->exists;

                $payload = [
                    'pinyin' => $item['pinyin'],
                    'meaning' => $item['meaning'],
                    'hsk_level' => $item['hsk_level'],
                    'example_hanzi' => $item['example_hanzi'],
                    'example_pinyin' => $item['example_pinyin'],
                    'example_translation' => $item['example_translation'],
                ];

                if ($item['audio_raw'] !== null) {
                    $payload['audio_character'] = $item['audio_raw'];
                } elseif (! $wasExisting) {
                    $payload['audio_character'] = null;
                }

                if (! $wasExisting) {
                    $payload['audio_example'] = null;
                }

                $model->fill($payload);
                $model->save();
                $imported[] = $model->fresh();

                if ($wasExisting) {
                    $updated++;
                } else {
                    $created++;
                }
            }
        });

        $audioNote = '';
        if ($request->boolean('generate_audio')) {
            $importAudioLimit = 20;
            $toGenerate = array_slice($imported, 0, $importAudioLimit);
            $stats = $this->audio->generateMissingForCharacters($toGenerate);
            $audioNote = " Озвучка: иероглифов — {$stats['character']}, примеров — {$stats['example']}.";
            if (count($imported) > $importAudioLimit) {
                $audioNote .= ' Озвучены первые ' . $importAudioLimit . ' записей; остальные — кнопкой на странице списка.';
            }
        }

        return redirect()
            ->route('admin.characters.index')
            ->with(
                'success',
                "Импорт выполнен: добавлено новых — {$created}, обновлено существующих — {$updated}.{$audioNote}"
            );
    }

    public function destroy($id) {
        $character = Character::findOrFail($id);
        $character->delete();

        return redirect()->route('admin.characters.index');
    }

    private function generateAudioForCharacter(Character $character): void
    {
        if ($this->audio->needsCharacterAudio($character)) {
            $this->audio->generateCharacterAudio($character);
        }

        $character->refresh();

        if ($this->audio->needsExampleAudio($character)) {
            $this->audio->generateExampleAudio($character);
        }
    }
}
