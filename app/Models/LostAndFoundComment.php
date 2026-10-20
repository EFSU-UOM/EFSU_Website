<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\DB;

class LostAndFoundComment extends Model
{
    protected $fillable = [
        'content',
        'parent_id',
        'depth',
        'upvotes',
        'downvotes',
        'score',
        'user_id',
        'lost_and_found_id',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lostAndFound(): BelongsTo
    {
        return $this->belongsTo(LostAndFound::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(LostAndFoundComment::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(LostAndFoundComment::class, 'parent_id');
    }

    public function votes(): MorphMany
    {
        return $this->morphMany(LostAndFoundVote::class, 'votable');
    }

    // Get all nested replies
    public function allReplies(): HasMany
    {
        return $this->hasMany(LostAndFoundComment::class, 'parent_id')->with('allReplies');
    }

    // Vote methods (similar to ForumComment)
    public function upvote(User $user): void
    {
        $this->castVote($user, true);
    }

    public function downvote(User $user): void
    {
        $this->castVote($user, false);
    }

    public function getUserVote(User $user): ?bool
    {
        $vote = $this->votes()->where('user_id', $user->id)->first();
        return $vote ? $vote->is_upvote : null;
    }

    private function castVote(User $user, bool $isUpvote): void
    {
        try {
            DB::transaction(function () use ($user, $isUpvote) {
                $existingVote = $this->votes()->where('user_id', $user->id)->first();

                if (!$existingVote) {
                    $this->votes()->create([
                        'user_id' => $user->id,
                        'is_upvote' => $isUpvote,
                    ]);
                } elseif ($existingVote->is_upvote === $isUpvote) {
                    $existingVote->delete();
                } else {
                    $existingVote->update(['is_upvote' => $isUpvote]);
                }

                $this->updateScore();
            });
        } catch (UniqueConstraintViolationException) {
            // A concurrent request already recorded this user's vote
            $this->updateScore();
        }
    }

    private function updateScore(): void
    {
        $upvotes = $this->votes()->where('is_upvote', true)->count();
        $downvotes = $this->votes()->where('is_upvote', false)->count();

        $this->update([
            'upvotes' => $upvotes,
            'downvotes' => $downvotes,
            'score' => $upvotes - $downvotes,
        ]);
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
