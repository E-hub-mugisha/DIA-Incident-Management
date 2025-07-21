<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mitigation extends Model
{
    protected $fillable = [
        'risk_id',
        'strategy',
        'staff_id',
        'deadline',
        'status'
    ];

    public function risk()
    {
        return $this->belongsTo(Risk::class);
    }
    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
    protected $appends = ['is_overdue'];

    public function getIsOverdueAttribute()
    {
        return $this->deadline && $this->deadline < now() && $this->status != 'Completed';
    }
}
