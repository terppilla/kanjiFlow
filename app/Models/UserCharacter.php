<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCharacter extends Model
{
    use HasFactory;
    protected $table = "user_characters";

    protected $fillable = [
        'user_id',
        'character_id',
        'interval',
        'next_review_at',
        'easy_factor',
        'last_result',
    ]

    protected $casts = [
        'next_review_at' => 'datetime',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function character() {
        return $this->belongsTo(Character::class);
    }
}
