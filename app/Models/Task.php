<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'janji_temu_id',
        'pengepul_id',
        'status',
    ];

    /**
     * Relasi ke JanjiTemu.
     */
    public function janjiTemu(): BelongsTo
    {
        return $this->belongsTo(JanjiTemu::class, 'janji_temu_id');
    }

    /**
     * Relasi ke User sebagai pengepul.
     */
    public function pengepul(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengepul_id');
    }

    /**
     * Akses petani melalui janjiTemu.
     */
    public function petani(): BelongsTo
    {
        return $this->janjiTemu()->belongsTo(User::class, 'petani_id');
    }
}
