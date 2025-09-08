<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    protected $fillable = [
        'title',
        'content',
        'type',
        'is_active',
        'is_featured',
        'image_url',
        'expires_at'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'expires_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getTimeAgo()
    {
        $now = now();
        $diffInMinutes = round($now->diffInMinutes($this->created_at,true));
        $diffInHours = round($now->diffInHours($this->created_at,true));
        $diffInDays = round($now->diffInDays($this->created_at,true));

        if ($diffInMinutes < 60) {
            return $diffInMinutes < 1 ? 'Just now' : $diffInMinutes . ' minutes ago';
        } elseif ($diffInHours < 24) {
            return $diffInHours . ' hours ago';
        } else {
            return $diffInDays . ' days ago';
        }
    }
}
