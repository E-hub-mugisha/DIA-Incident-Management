<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncidentMitigation extends Model
{
    protected $fillable = [
        'incident_id',
        'user_id',
        'mitigation',
    ];

    public function incident()
    {
        return $this->belongsTo(Incident::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
