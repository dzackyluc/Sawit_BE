<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    
    // Kolom yang bisa diisi
    protected $fillable = [
        'jnaji_temu_id',
        'pengepul_id',
        'total_harga',
    ];

    // Relasi dengan User untuk Petani
    public function petani()
    {
        return $this->belongsTo(User::class, 'janji_temu_id');  // Menghubungkan dengan ID Petani
    }

    // Relasi dengan User untuk Pengepul
    public function pengepul()
    {
        return $this->belongsTo(User::class, 'pengepul_id');  // Menghubungkan dengan ID Pengepul
    }
}
