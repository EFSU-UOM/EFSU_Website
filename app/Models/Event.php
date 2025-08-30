<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'location',
        'image_url',
        'start_datetime',
        'end_datetime',
        'requires_registration',
        'max_participants',
        'facebook_page_url',
        'facebook_album_urls',
        'user_id',
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
        'requires_registration' => 'boolean',
        'facebook_album_urls' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
