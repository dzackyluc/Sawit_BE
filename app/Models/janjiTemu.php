<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class janjiTemu extends Model
{
        protected $table = 'janji_temu';

        protected $fillable = [
            'nama_petani',
            'alamat',
            'no_hp',
            'date',
        ];
}
