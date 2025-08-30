<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category',
        'price',
        'image_url',
        'is_available',
        'stock_quantity',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
    ];
}
