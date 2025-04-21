<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    protected $fillable = [
        'task_id',
        'pengepul_id',
        'latitude',
        'longitude',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function pengepul()
    {
        return $this->belongsTo(User::class, 'pengepul_id');
    }
}
