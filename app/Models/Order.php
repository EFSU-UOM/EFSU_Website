<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'subtotal',
        'service_charge',
        'total_amount',
        'status',
        'currency',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'country',
        'payment_id',
        'payment_method',
        'paid_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'service_charge' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateOrderId(): string
    {
        do {
            $orderId = 'ORD-' . date('Ymd') . '-' . Str::upper(Str::random(8));
        } while (static::where('order_id', $orderId)->exists());

        return $orderId;
    }
}
