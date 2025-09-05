<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ForumComment extends Model
{
    protected $fillable = [
        'content',
        'parent_id',
        'depth',
        'upvotes',
        'downvotes',
        'score',
        'user_id',
        'post_id',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(ForumPost::class, 'post_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ForumComment::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(ForumComment::class, 'parent_id');
    }

    public function votes(): MorphMany
    {
        return $this->morphMany(ForumVote::class, 'votable');
    }

    // Get all nested replies
    public function allReplies(): HasMany
    {
        return $this->hasMany(ForumComment::class, 'parent_id')->with('allReplies');
    }

    // Vote methods (similar to Post)
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

    // Set depth when creating nested comment
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

    // Scopes
    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeOrderedByScore($query)
    {
        return $query->orderBy('score', 'desc');
    }
}
