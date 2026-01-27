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

    public function users() {
        return $this->belongsToMany(User::class)->using(UserCharacter::class)->withPivot([
            'interval',
            'next_review_at',
            'easy_factor',
            'last_result'
        ])->withTimestamps();
    }
}
