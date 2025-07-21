<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiskLog extends Model
{
    protected $fillable = [
        'risk_id', 'user_id', 'action', 'description'
    ];

    public function risk()
    {
        return $this->belongsTo(Risk::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
