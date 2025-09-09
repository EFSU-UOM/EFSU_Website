<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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

    public function votes(): MorphMany
    {
        return $this->morphMany(BoardingPlaceVote::class, 'votable');
    }

    public function upvote(User $user): void
    {
        $existingVote = $this->votes()->where('user_id', $user->id)->first();

        if ($existingVote) {
            if ($existingVote->is_upvote) {
                $existingVote->delete();
                $this->decrement('upvotes');
            } else {
                $existingVote->update(['is_upvote' => true]);
                $this->decrement('downvotes');
                $this->increment('upvotes');
            }
        } else {
            $this->votes()->create([
                'user_id' => $user->id,
                'is_upvote' => true,
            ]);
            $this->increment('upvotes');
        }

        $this->updateScore();
    }

    public function downvote(User $user): void
    {
        $existingVote = $this->votes()->where('user_id', $user->id)->first();

        if ($existingVote) {
            if (!$existingVote->is_upvote) {
                $existingVote->delete();
                $this->decrement('downvotes');
            } else {
                $existingVote->update(['is_upvote' => false]);
                $this->decrement('upvotes');
                $this->increment('downvotes');
            }
        } else {
            $this->votes()->create([
                'user_id' => $user->id,
                'is_upvote' => false,
            ]);
            $this->increment('downvotes');
        }

        $this->updateScore();
    }

    public function getUserVote(User $user): ?bool
    {
        $vote = $this->votes()->where('user_id', $user->id)->first();
        return $vote ? $vote->is_upvote : null;
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
