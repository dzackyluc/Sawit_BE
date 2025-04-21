<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    // Jika nama table bukan plural baku, tambahkan:
    // protected $table = 'artikels';

    protected $fillable = [
        'title',
        'content',
        'image',
    ];
}
