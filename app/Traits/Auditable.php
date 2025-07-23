<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

trait Auditable
{
    public static function bootAuditable()
    {
        static::created(function ($model) {
            $model->logAudit('created');
        });

        static::updated(function ($model) {
            $model->logAudit('updated');
        });

        static::deleted(function ($model) {
            $model->logAudit('deleted');
        });
    }

    public function logAudit($event)
    {
        $changes = [
            'attributes' => $this->getAttributes(),
            'original' => $this->getOriginal(),
            'changes' => $this->getChanges(),
        ];

        AuditLog::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'auditable_type' => get_class($this),
            'auditable_id' => $this->id,
            'event' => $event,
            'old_values' => $event === 'updated' ? json_encode($changes['original']) : null,
            'new_values' => json_encode($changes['attributes']),
            'changed_values' => json_encode($changes['changes']),
        ]);
    }

    public function auditLogs()
    {
        return $this->morphMany(\App\Models\AuditLog::class, 'auditable');
    }
}
