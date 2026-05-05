<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Bestmomo\LaravelEdgeTts\Contracts\TtsSynthesizer;
use Illuminate\Http\Request;

class AudioController extends Controller
{
    protected TtsSynthesizer $tts;

    public function __construct(TtsSynthesizer $tts)
    {
        $this->tts = $tts;
    }

    /**
     * Имя маршрута: generateCharacterAudio
     */
    public function generateCharacterAudio($characterId)
    {
        return $this->generateAndSave($characterId);
    }

    public function generateAndSave($characterId)
    {
        $character = Character::findOrFail($characterId);

        $filename = 'audio/' . $character->character . '.mp3';
        $fullPath = storage_path('app/public/' . $filename);

        $this->tts->toFile(
            $character->pinyin,
            'zh-CN-XiaoxiaoNeural',
            $fullPath
        );

        if (! is_file($fullPath) || filesize($fullPath) < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Не удалось сохранить озвучку (пустой файл). Повторите попытку.',
            ], 422);
        }

        $character->audio_character = '/storage/' . $filename;
        $character->save();

        return response()->json(['success' => true, 'path' => $character->audio_character]);
    }

    public function getBase64($characterId) {
        $character = Character::findOrFail($characterId);

        $base64Audio = $this->tts->toBase64(
            $character->pinyin,
            'zh-CN-XiaoxiaoNeural'
        );

        return response()->json(['success' => true, 'base64' => $base64Audio]);
    }

    public function generateExampleAudio($characterId)
    {
        $character = Character::findOrFail($characterId);
        
        if (empty($character->example_pinyin)) {
            return response()->json([
                'success' => false, 
                'message' => 'У этого иероглифа нет примера для озвучки'
            ]);
        }
        
        $filename = 'audio/' . $character->character . '_example.mp3';
        $fullPath = storage_path('app/public/' . $filename);

        $this->tts->toFile(
            $character->example_pinyin,
            'zh-CN-XiaoxiaoNeural',
            $fullPath
        );

        if (! is_file($fullPath) || filesize($fullPath) < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Не удалось сохранить озвучку примера (пустой файл). Повторите попытку.',
            ], 422);
        }

        // Сохраняем путь в поле audio_example
        $character->audio_example = '/storage/' . $filename;
        $character->save();

        return response()->json([
            'success' => true, 
            'path' => $character->audio_example
        ]);
    }

    // Получение аудио в формате Base64 (без сохранения файла)
    public function getCharacterBase64($characterId)
    {
        $character = Character::findOrFail($characterId);

        $base64Audio = $this->tts->toBase64(
            $character->pinyin,
            'zh-CN-XiaoxiaoNeural'
        );

        return response()->json([
            'success' => true, 
            'base64' => $base64Audio
        ]);
    }

    // Получение аудио для примера в формате Base64
    public function getExampleBase64($characterId)
    {
        $character = Character::findOrFail($characterId);

        if (empty($character->example_pinyin)) {
            return response()->json([
                'success' => false, 
                'message' => 'Нет текста для озвучки'
            ]);
        }

        $base64Audio = $this->tts->toBase64(
            $character->example_pinyin,
            'zh-CN-XiaoxiaoNeural'
        );

        return response()->json([
            'success' => true, 
            'base64' => $base64Audio
        ]);
    }
}
