<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncidentReviews extends Model
{
    //
    protected $fillable = [
        'incident_id',
        'user_id',
        'comment',
        'rating',
        'media',
    ];

    public function incident()
    {
        return $this->hasMany(Incident::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
