<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BuiltinCollectionTemplate extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function characters(): BelongsToMany
    {
        return $this->belongsToMany(
            Character::class,
            'builtin_collection_character',
            'builtin_collection_template_id',
            'character_id'
        )->withPivot('sort_order')->orderByPivot('sort_order');
    }
}
