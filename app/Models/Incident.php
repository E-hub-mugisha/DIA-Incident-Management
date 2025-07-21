<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    //
    protected $fillable = [
        'title',
        'description',
        'category_id',
        'severity',
        'location',
        'status',
        'reported_by',
        'assigned_to',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function reportedBy()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
