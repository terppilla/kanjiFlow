<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CharacterSuggestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CharacterSuggestionController extends Controller
{
    public function index()
    {
        $suggestions = CharacterSuggestion::query()
            ->with(['user:id,name,email', 'collection:id,name,user_id'])
            ->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END")
            ->orderByDesc('created_at')
            ->paginate(30);

        $pendingCount = CharacterSuggestion::query()
            ->where('status', CharacterSuggestion::STATUS_PENDING)
            ->count();

        return view('admin.character_suggestions.index', compact('suggestions', 'pendingCount'));
    }

    public function dismiss(CharacterSuggestion $characterSuggestion)
    {
        if (! $characterSuggestion->isPending()) {
            return back()->with('info', 'Предложение уже обработано.');
        }

        $characterSuggestion->update([
            'status' => CharacterSuggestion::STATUS_DISMISSED,
            'processed_at' => now(),
            'processed_by' => Auth::id(),
        ]);

        return back()->with('success', 'Предложение отклонено.');
    }
}
