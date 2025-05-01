<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JanjiTemu extends Model
{
    use HasFactory;

    // Tambahkan kolom alasan_reject jika belum ada di migrasi
    protected $fillable = [
        'petani_id',
        'alamat',
        'no_hp',
        'tanggal',
        'petani_lat',
        'petani_lng',
        'status',
        'alasan_reject',
    ];

    /**
     * Relasi ke User (petani)
     */
    public function petani()
    {
        return $this->belongsTo(User::class, 'petani_id');
    }
}