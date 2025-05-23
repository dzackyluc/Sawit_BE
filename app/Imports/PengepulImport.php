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
        // Contoh validasi sederhana:
        if (($row['password'] ?? '') !== ($row['password_confirmation'] ?? '')) {
            // abaikan baris ini atau lempar exception
            return null;
        }

        return new User([
            'name'      => $row['name'],
            'email'     => $row['email'],
            'password'  => Hash::make($row['password']),
            'no_phone'  => $row['no_phone'],
            'role'      => 'pengepul',
        ]);
    }
}

