<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Risk extends Model
{
    protected $fillable = [
        'title',
        'description',
        'department_id',
        'category_id',
        'likelihood',
        'impact',
        'level',
        'status'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function mitigations()
    {
        return $this->hasMany(Mitigation::class);
    }

    public function logs()
    {
        return $this->hasMany(RiskLog::class);
    }
    public function calculateRiskLevel(): string
    {
        $scores = ['Low' => 1, 'Medium' => 2, 'High' => 3];

        $likelihoodScore = $scores[$this->likelihood] ?? 0;
        $impactScore = $scores[$this->impact] ?? 0;
        $total = $likelihoodScore * $impactScore;

        return match (true) {
            $total <= 2 => 'Low',
            $total <= 4 => 'Medium',
            $total == 6 => 'High',
            $total == 9 => 'Critical',
            default => 'Unknown',
        };
    }
}
