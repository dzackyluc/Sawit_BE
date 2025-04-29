<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JanjiTemu extends Model
{
    use HasFactory;

    protected $table = 'janji_temu';

    protected $fillable = [
        'petani_id',
        'alamat',
        'no_hp',
        'tanggal',
        'petani_lat',
        'petani_lng',
    ];

    /**
     * Cast attributes to appropriate types.
     * 'tanggal' as datetime, coords as float.
     */
    protected $casts = [
        'tanggal'     => 'datetime',
        'petani_lat'  => 'float',
        'petani_lng'  => 'float',
    ];

    /**
     * Relationship: JanjiTemu belongs to a Petani (User).
     */
    public function petani(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petani_id');
    }

    /**
     * Relationship: JanjiTemu may have many Tasks.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'janji_temu_id');
    }
}
