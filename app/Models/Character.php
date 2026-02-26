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
