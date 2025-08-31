<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NewsArticle extends Model
{
    protected $fillable = [
        'title',
        'excerpt',
        'content',
        'category',
        'image_url',
        'is_published',
        'is_featured',
        'published_at'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'published_at' => 'datetime'
    ];
}
