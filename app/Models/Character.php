<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;

    protected $fillable = [
        'character',
        'pinyin',
        'hsk_level',
        'example_hanzi',
        'example_pinyin',
        'example_translation',
        'audio_character',
        'audio_example',
        'meaning',
    ];

    /**
     * Путь из БД к публичному URL под /storage (поддержка старых значений без префикса).
     */
    public static function publicAudioUrl(?string $path): ?string
    {
        if ($path === null || $path === '') {
            return null;
        }
        if (str_starts_with($path, '/storage/')) {
            return $path;
        }
        if (str_starts_with($path, 'storage/')) {
            return '/' . $path;
        }

        return '/storage/' . ltrim($path, '/');
    }

    public function collections()
    {
        return $this->belongsToMany(Collection::class, 'collection_character')->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_characters')
            ->withPivot([
                'interval',
                'ease_factor',
                'repetitions',
                'streak',
                'total_reviews',
                'next_review_at',
                'last_reviewed_at',
                'last_result',
                'average_time',
                'success_rate',
                'is_learned',
                'learned_at',
                'days_studied',
            ])
            ->withTimestamps();
    }
}
