<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BoardingRating extends Model
{
    protected $table = 'boarding_ratings';
    
    protected $fillable = [
        'user_id',
        'boarding_place_id',
        'rating',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function boardingPlace(): BelongsTo
    {
        return $this->belongsTo(BoardingPlace::class);
    }
}
