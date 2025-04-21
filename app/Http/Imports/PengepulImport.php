<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PengepulImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new User([
            'name' => $row['name'],
            'password' => Hash::make($row['password']),
            'email' => $row['email'],
            'nama' => $row['nama'],
            'no_telp'=>$row['no_telp'],
            'role' => 'pengepul',
        ]);
    }
}
