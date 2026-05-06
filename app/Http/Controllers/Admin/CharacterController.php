<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Character;
use App\Services\CharacterJsonImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CharacterController extends Controller
{
    public function index() {
        $characters = Character::query()
            ->orderBy('hsk_level')
            ->orderBy('character')
            ->get();

        return view('admin.characters.index', compact('characters'));
    }

    public function create() {
        return view('admin.characters.create');
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
        ]);

        Character::create([
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
            'meaning' => 'nullable|string'
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

        return redirect()->route('admin.characters.index');
    }

    public function importJson(Request $request, CharacterJsonImport $importer)
    {
        $request->validate([
            'json_file' => ['required', 'file', 'max:5120'],
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

        DB::transaction(function () use ($result, &$created, &$updated): void {
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

                if ($wasExisting) {
                    $updated++;
                } else {
                    $created++;
                }
            }
        });

        return redirect()
            ->route('admin.characters.index')
            ->with(
                'success',
                "Импорт выполнен: добавлено новых — {$created}, обновлено существующих — {$updated}. Записи из файла обработаны в порядке уровня HSK (1→6), внутри уровня — по иероглифу."
            );
    }

    public function destroy($id) {
        $character = Character::findOrFail($id);
        $character->delete();

        return redirect()->route('admin.characters.index');
    }
}
