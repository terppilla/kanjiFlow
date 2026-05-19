<?php

namespace App\Http\Controllers;

use App\Models\CharacterSuggestion;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CharacterSuggestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Collection $collection)
    {
        abort_unless($collection->user_id === Auth::id(), 403);

        $data = $request->validate([
            'words' => ['required', 'string', 'max:2000'],
            'note' => ['nullable', 'string', 'max:500'],
            'search_query' => ['nullable', 'string', 'max:255'],
        ]);

        $words = self::parseWords($data['words']);
        if ($words === []) {
            return back()
                ->withErrors(['words' => 'Укажите хотя бы одно слово или иероглиф.'])
                ->withInput();
        }

        CharacterSuggestion::create([
            'user_id' => Auth::id(),
            'collection_id' => $collection->id,
            'search_query' => isset($data['search_query']) ? trim($data['search_query']) : null,
            'words' => $words,
            'note' => isset($data['note']) ? trim($data['note']) : null,
            'status' => CharacterSuggestion::STATUS_PENDING,
        ]);

        return back()->with('success', 'Спасибо! Предложение отправлено администратору.');
    }

    /**
     * @return list<string>
     */
    public static function parseWords(string $raw): array
    {
        $parts = preg_split('/[\r\n,;]+/u', $raw) ?: [];
        $words = [];
        foreach ($parts as $part) {
            $word = trim($part);
            if ($word !== '' && ! in_array($word, $words, true)) {
                $words[] = $word;
            }
            if (count($words) >= 20) {
                break;
            }
        }

        return $words;
    }
}
