<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class LostAndFoundVote extends Model
{
    protected $fillable = [
        'user_id',
        'votable_type',
        'votable_id',
        'is_upvote',
    ];

    protected $casts = [
        'is_upvote' => 'boolean',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function votable(): MorphTo
    {
        return $this->morphTo();
    }
}