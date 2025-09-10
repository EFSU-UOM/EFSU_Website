<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'category', 'complaint_text', 'status', 'is_anonymous', 'images'];

    protected $casts = [
        'is_anonymous' => 'boolean',
        'images' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusBadgeColorAttribute()
    {
        return match($this->status) {
            'delivered' => 'info',
            'viewed' => 'warning', 
            'in_progress' => 'primary',
            'action_taken' => 'success',
            'rejected' => 'error',
            'incomplete' => 'neutral',
            default => 'neutral'
        };
    }

    public function getFormattedStatusAttribute()
    {
        return match($this->status) {
            'delivered' => 'Delivered',
            'viewed' => 'Viewed',
            'in_progress' => 'In Progress',
            'action_taken' => 'Action Taken',
            'rejected' => 'Rejected',
            'incomplete' => 'Incomplete',
            default => ucfirst($this->status)
        };
    }
}
