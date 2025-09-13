<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplaintReply extends Model
{
    protected $fillable = [
        'complaint_id',
        'user_id', 
        'parent_id',
        'content'
    ];

    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(ComplaintReply::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(ComplaintReply::class, 'parent_id')->with(['user', 'replies']);
    }

    // Scope for top-level replies (no parent)
    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }
}
