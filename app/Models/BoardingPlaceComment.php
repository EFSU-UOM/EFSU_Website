<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BoardingPlaceComment extends Model
{
    protected $fillable = [
        'content',
        'parent_id',
        'depth',
        'upvotes',
        'downvotes',
        'score',
        'user_id',
        'boarding_place_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function boardingPlace(): BelongsTo
    {
        return $this->belongsTo(BoardingPlace::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(BoardingPlaceComment::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(BoardingPlaceComment::class, 'parent_id');
    }

    public function allReplies(): HasMany
    {
        return $this->hasMany(BoardingPlaceComment::class, 'parent_id')->with('allReplies');
    }

    public function upvote(User $user): void
    {
        $this->increment('upvotes');
        $this->updateScore();
    }

    public function downvote(User $user): void
    {
        $this->increment('downvotes');
        $this->updateScore();
    }

    private function updateScore(): void
    {
        $this->update(['score' => $this->upvotes - $this->downvotes]);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($comment) {
            if ($comment->parent_id) {
                $parent = self::find($comment->parent_id);
                $comment->depth = $parent ? $parent->depth + 1 : 0;
            } else {
                $comment->depth = 0;
            }
        });
    }

    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeOrderedByScore($query)
    {
        return $query->orderBy('score', 'desc');
    }
}
