<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CharacterSuggestion extends Model
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_PROCESSED = 'processed';

    public const STATUS_DISMISSED = 'dismissed';

    protected $fillable = [
        'user_id',
        'collection_id',
        'search_query',
        'words',
        'note',
        'status',
        'processed_at',
        'processed_by',
    ];

    protected $casts = [
        'words' => 'array',
        'processed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }

    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function wordsLabel(): string
    {
        return implode(', ', $this->words ?? []);
    }
}
