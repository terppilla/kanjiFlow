<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    public function index() {
        $characters = Character::all();
        return view('characters.index',  compact('characters'));
    }

    public function create() {
        return view('characters.create');
    }

    public function store(Request $request) {
        $request->validate([
            'character'=>'required',
            'pinyin' => 'required',
            'hsk_level' => 'required|integer',
            'example_hanzi' => 'nullable|dtring',
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

        return redirect()->route('characters.index');
    }

    public function edit($id) {
        $character = Character::findOrFail($id);
        return view('characters.edit', compact('character'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'character'=>'required',
            'pinyin' => 'required',
            'hsk_level' => 'required|integer',
            'example_hanzi' => 'nullable|dtring',
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

        return redirect()->route('characters.index');
    }

    public function destroy($id) {
        $character = Character::findOrFail($id);
        $character->delete();

        return redirect()->route('characters.index');
    }
}
