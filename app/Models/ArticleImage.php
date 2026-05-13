<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ArticleImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'image_path',
        'caption',
        'sort_order',
    ];

    /** URL через диск public + симлинк public/storage → storage/app/public */
    public function getImageUrlAttribute(): string
    {
        return Storage::disk('public')->url((string) $this->image_path);
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
