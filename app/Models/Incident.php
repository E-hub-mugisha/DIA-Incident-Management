<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Incident extends Model
{
    //
    use Auditable;

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

    // User who reported the incident
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    public function reviews()
    {
        return $this->hasMany(IncidentReviews::class);
    }

    // Audit logs
    public function auditLogs()
    {
        return $this->morphMany(AuditLog::class, 'auditable');
    }

    public function dailyNotes()
    {
        return $this->hasMany(DailyNote::class);
    }
    public function mitigations()
    {
        return $this->hasMany(IncidentMitigation::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}
