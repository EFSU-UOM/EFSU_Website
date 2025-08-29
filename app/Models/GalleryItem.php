<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GalleryItem extends Model
{
    protected $fillable = [
        'title',
        'description',
        'type',
        'file_path',
        'category',
        'link'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
