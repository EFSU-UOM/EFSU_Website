<?php

namespace App\Models;

use App\Enums\AccessLevel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'contact',
        'batch',
        'password',
        'access_level',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'access_level' => AccessLevel::class,
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function isAdmin()
    {
        return $this->access_level->value <= AccessLevel::ADMIN->value;
    }

    public function isModerator()
    {
        return $this->access_level->value <= AccessLevel::MODERATOR->value;
    }

    public function isBanned()
    {
        return $this->access_level === AccessLevel::BANNED;
    }

    public function hasAccessLevel(AccessLevel $requiredLevel): bool
    {
        return $this->access_level->canAccess($requiredLevel);
    }

    public function getAccessLevelLabel(): string
    {
        return $this->access_level->label();
    }

    public function posts(): HasMany
    {
        return $this->hasMany(ForumPost::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(ForumComment::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(ForumVote::class);
    }
}
