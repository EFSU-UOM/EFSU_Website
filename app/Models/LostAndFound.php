<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LostAndFound extends Model
{
    protected $table = 'lost_and_found';

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'description',
        'location',
        'contact_info',
        'image',
        'status',
        'item_date',
    ];

    protected $casts = [
        'item_date' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(LostAndFoundComment::class);
    }

    public function scopeLost($query)
    {
        return $query->where('type', 'lost');
    }

    public function scopeFound($query)
    {
        return $query->where('type', 'found');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeByLocation($query, $location)
    {
        return $query->where('location', 'like', "%{$location}%");
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'active' => 'Active',
            'owner_found' => 'Owner Found',
            'lost_item_obtained' => 'Item Obtained',
            default => 'Unknown',
        };
    }

    public function getTypeLabelAttribute(): string
    {
        return ucfirst($this->type);
    }
}
