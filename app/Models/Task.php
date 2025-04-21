<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        'petani_id',
        'pengepul_id',
        'alamat',
        'status',
    ];

    /**
     * Relasi ke User sebagai petani.
     */
    public function petani(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petani_id');
    }

    /**
     * Relasi ke User sebagai pengepul.
     */
    public function pengepul(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengepul_id');
    }
}
