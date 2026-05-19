<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Character;
use App\Services\CharacterAudioService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CharacterAudioController extends Controller
{
    public function __construct(
        private readonly CharacterAudioService $audio,
    ) {}

    public function preview(Request $request): JsonResponse
    {
        $data = $request->validate([
            'text' => ['required', 'string', 'max:500'],
            'glyph' => ['required', 'string', 'max:32'],
            'kind' => ['required', 'in:character,example'],
        ]);

        $result = $this->audio->generatePreview(
            $data['text'],
            $data['glyph'],
            $data['kind'],
        );

        return response()->json($result, $result['success'] ? 200 : 422);
    }

    public function generateCharacter(Character $character): JsonResponse
    {
        $result = $this->audio->generateCharacterAudio($character);

        return response()->json($result, $result['success'] ? 200 : 422);
    }

    public function generateExample(Character $character): JsonResponse
    {
        $result = $this->audio->generateExampleAudio($character);

        return response()->json($result, $result['success'] ? 200 : 422);
    }
}
