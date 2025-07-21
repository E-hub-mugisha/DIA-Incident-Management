<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name', 'description'];

    public function risks()
    {
        return $this->hasMany(Risk::class);
    }

    public function staff()
    {
        return $this->hasMany(Staff::class);
    }
}
