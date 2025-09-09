<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\AsCollection;

class BoardingPlace extends Model
{
    protected $fillable = [
        'title',
        'description',
        'images',
        'location',
        'latitude',
        'longitude',
        'distance_to_university',
        'price',
        'payment_method',
        'capacity',
        'contact_phone',
        'contact_email',
        'status',
        'views_count',
        'user_id',
    ];

    protected $casts = [
        'images' =>  AsCollection::class,
        'price' => 'decimal:2',
        'distance_to_university' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(BoardingPlaceComment::class);
    }

    public function topLevelComments(): HasMany
    {
        return $this->hasMany(BoardingPlaceComment::class)->whereNull('parent_id')->orderBy('score', 'desc');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeWithinDistance($query, $maxDistance)
    {
        return $query->where('distance_to_university', '<=', $maxDistance);
    }

    public function scopeWithinPriceRange($query, $minPrice = null, $maxPrice = null)
    {
        if ($minPrice) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        }
        return $query;
    }

    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function getFormattedPriceAttribute()
    {
        if (!$this->price) {
            return 'Price not specified';
        }

        $paymentMethod = $this->payment_method ? " {$this->payment_method}" : '';
        return "LKR " . number_format($this->price, 2) . $paymentMethod;
    }

    public function getFormattedDistanceAttribute()
    {
        if (!$this->distance_to_university) {
            return 'Distance not specified';
        }
        
        return number_format($this->distance_to_university, 1) . ' km from university';
    }
}
