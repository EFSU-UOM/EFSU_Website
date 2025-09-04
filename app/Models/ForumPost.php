<?php

namespace App\Models;

use App\ForumCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ForumPost extends Model
{
    protected $fillable = [
        'title',
        'content',
        'category',
        'user_id',
        'upvotes',
        'downvotes',
        'score',
        'is_pinned',
    ];

    protected $casts = [
        'category' => ForumCategory::class,
        'is_pinned' => 'boolean',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(ForumComment::class, 'post_id');
    }

    public function topLevelComments(): HasMany
    {
        return $this->hasMany(ForumComment::class, 'post_id')->whereNull('parent_id');
    }

    public function votes(): MorphMany
    {
        return $this->morphMany(ForumVote::class, 'votable');
    }

    // Vote methods
    public function upvote(User $user): void
    {
        $existingVote = $this->votes()->where('user_id', $user->id)->first();

        if ($existingVote) {
            if ($existingVote->is_upvote) {
                // Remove upvote
                $existingVote->delete();
                $this->decrement('upvotes');
            } else {
                // Change downvote to upvote
                $existingVote->update(['is_upvote' => true]);
                $this->decrement('downvotes');
                $this->increment('upvotes');
            }
        } else {
            // New upvote
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
                // Remove downvote
                $existingVote->delete();
                $this->decrement('downvotes');
            } else {
                // Change upvote to downvote
                $existingVote->update(['is_upvote' => false]);
                $this->decrement('upvotes');
                $this->increment('downvotes');
            }
        } else {
            // New downvote
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

    // Scopes
    public function scopeByCategory($query, ForumCategory $category)
    {
        return $query->where('category', $category);
    }

    public function scopePopular($query)
    {
        return $query->orderBy('score', 'desc');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function togglePin(): void
    {
        $this->update(['is_pinned' => !$this->is_pinned]);
    }

    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }
}
