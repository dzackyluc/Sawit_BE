<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'task_id',     
        'jumlah',
        'total_harga',
    ];

    // Relasi ke JanjiTemu
    public function janjiTemu()
    {
        return $this->belongsTo(JanjiTemu::class, 'task_id');
    }

    public function task() 
    {
        return $this->belongsTo(Task::class);
    }
}
