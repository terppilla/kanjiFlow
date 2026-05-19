<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Services\CharacterAudioService;
use Illuminate\Http\JsonResponse;

class AudioController extends Controller
{
    public function __construct(
        private readonly CharacterAudioService $audio,
    ) {}

    /**
     * Имя маршрута: generateCharacterAudio
     */
    public function generateCharacterAudio($characterId): JsonResponse
    {
        $character = Character::findOrFail($characterId);
        $result = $this->audio->generateCharacterAudio($character);

        return response()->json($result, $result['success'] ? 200 : 422);
    }

    public function generateExampleAudio($characterId): JsonResponse
    {
        $character = Character::findOrFail($characterId);
        $result = $this->audio->generateExampleAudio($character);

        return response()->json($result, $result['success'] ? 200 : 422);
    }

    public function getBase64($characterId)
    {
        $character = Character::findOrFail($characterId);

        $base64Audio = app(\Bestmomo\LaravelEdgeTts\Contracts\TtsSynthesizer::class)->toBase64(
            $character->pinyin,
            CharacterAudioService::VOICE
        );

        return response()->json(['success' => true, 'base64' => $base64Audio]);
    }

    public function getCharacterBase64($characterId)
    {
        return $this->getBase64($characterId);
    }

    public function getExampleAudioBase64($characterId)
    {
        $character = Character::findOrFail($characterId);

        $speech = $character->exampleSpeechForTts();
        if ($speech === null || $speech === '') {
            return response()->json([
                'success' => false,
                'message' => 'Нет текста для озвучки',
            ]);
        }

        $base64Audio = app(\Bestmomo\LaravelEdgeTts\Contracts\TtsSynthesizer::class)->toBase64(
            $speech,
            CharacterAudioService::VOICE
        );

        return response()->json([
            'success' => true,
            'base64' => $base64Audio,
        ]);
    }
}
