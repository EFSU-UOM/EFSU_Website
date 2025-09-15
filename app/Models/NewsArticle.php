<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
