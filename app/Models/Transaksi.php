<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'petani_id',
        'pengepul_id',
        'total_harga',
    ];

    // Relasi ke JanjiTemu
    public function janjiTemu()
    {
        return $this->belongsTo(User::class, 'petani_id');  // Menghubungkan dengan ID Petani
    }

    public function task() 
    {
        return $this->belongsTo(Task::class);
    }
}
