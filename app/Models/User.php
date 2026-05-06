<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'two_factor_code',
        'two_factor_expires_at',
        'two_factor_enabled',
        'login_attempts',
        'locked_until',
        'last_study_date',
        'study_streak',
        'study_sessions_completed',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_code',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'two_factor_expires_at' => 'datetime',
        'two_factor_enabled' => 'boolean',
        'locked_until' => 'datetime',
        'login_attempts' => 'integer',
        'last_study_date' => 'date',
        'study_streak' => 'integer',
        'study_sessions_completed' => 'integer',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function collections(): HasMany
    {
        return $this->hasMany(Collection::class);
    }

    public function characters()
    {
        return $this->belongsToMany(Character::class, 'user_characters')
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

    public function userCharacters(): HasMany
    {
        return $this->hasMany(UserCharacter::class);
    }

    public function favoriteArticles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'article_user_favorites')->withTimestamps();
    }

    public function achievements(): BelongsToMany
    {
        return $this->belongsToMany(Achievement::class, 'user_achievements')
            ->withPivot('earned_at')
            ->withTimestamps()
            ->orderByDesc('user_achievements.earned_at');
    }

    public function dueForReview()
    {
        return $this->userCharacters()
            ->where('next_review_at', '<=', now())
            ->where('is_learned', false)
            ->with('character')
            ->orderBy('next_review_at')
            ->get();
    }

    public function getNextCardForLevel($hskLevel)
    {
        return $this->userCharacters()
            ->where('next_review_at', '<=', now())
            ->where('is_learned', false)
            ->whereHas('character', function ($q) use ($hskLevel) {
                $q->where('hsk_level', $hskLevel);
            })
            ->with('character')
            ->orderBy('next_review_at')
            ->first();
    }

    public function learnedCharacters()
    {
        return $this->userCharacters()
            ->where('is_learned', true)
            ->with('character')
            ->get();
    }

    public function getReviewStats()
    {
        return [
            'total_learned' => $this->userCharacters()->where('is_learned', true)->count(),
            'due_today' => $this->userCharacters()
                ->where('next_review_at', '<=', now())
                ->where('is_learned', false)
                ->count(),
            'total_reviews' => $this->userCharacters()->sum('total_reviews'),
            'average_success_rate' => $this->userCharacters()->avg('success_rate') ?? 0,
        ];
    }
}
