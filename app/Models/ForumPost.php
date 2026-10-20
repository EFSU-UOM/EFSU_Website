<?php

namespace App\Models;

use App\ForumCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\DB;
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

    protected static function booted(): void
    {
        static::deleting(function (ForumPost $post) {
            $post->votes()->delete();
        });
    }

    // Vote methods
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
                $this->newQuery()->whereKey($this->getKey())->lockForUpdate()->first();

                $existingVote = $this->votes()->where('user_id', $user->id)->first();

                if ($existingVote && $existingVote->is_upvote === $isUpvote) {
                    $existingVote->delete();
                } elseif ($existingVote) {
                    $existingVote->update(['is_upvote' => $isUpvote]);
                } else {
                    $this->votes()->create([
                        'user_id' => $user->id,
                        'is_upvote' => $isUpvote,
                    ]);
                }

                $this->syncVoteCounts();
            });
        } catch (UniqueConstraintViolationException) {
            // A concurrent request already recorded this vote
        }
    }

    private function syncVoteCounts(): void
    {
        $upvotes = $this->votes()->where('is_upvote', true)->count();
        $downvotes = $this->votes()->where('is_upvote', false)->count();

        $this->update([
            'upvotes' => $upvotes,
            'downvotes' => $downvotes,
            'score' => $upvotes - $downvotes,
        ]);
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

    public function totalVotes(): int
    {
        return $this->upvotes + $this->downvotes;
    }
}
