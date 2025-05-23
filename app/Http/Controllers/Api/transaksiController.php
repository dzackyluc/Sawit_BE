<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\User;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with(['petani', 'pengepul'])->get();

        return response()->json([
            'success' => true,
            'data' => $transaksi
        ]);
    }

    // Code ketika pengepul menemui petani dan mencatat transaksi
    public function store(Request $request)
    {
        // Validasi input untuk memastikan petani_id dan pengepul_id ada di tabel users
        $validated = $request->validate([
            'petani_id' => 'required|exists:users,id',  // ID Petani
            'pengepul_id' => 'required|exists:users,id', // ID Pengepul
            'total_harga' => 'required|numeric|min:0',   // Total harga transaksi
        ]);
    
        // Membuat transaksi baru dengan ID petani dan pengepul
        $transaksi = Transaksi::create([
            'petani_id' => $validated['petani_id'],     // Menyimpan ID Petani
            'pengepul_id' => $validated['pengepul_id'],  // Menyimpan ID Pengepul
            'total_harga' => $validated['total_harga'],  // Menyimpan total harga transaksi
        ]);
    
        // Mengembalikan response sukses dengan data transaksi
        return response()->json([
            'success' => true,
            'data' => $transaksi,
            'message' => 'Transaksi berhasil ditambahkan dan status task diubah menjadi completed',
        ], 201);
    }

    public function show($id)
    {
        $transaksi = Transaksi::with(['petani', 'pengepul'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $transaksi,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'petani_id' => 'required|exists:users,id',  // Gunakan petani_id yang merujuk ke id petani
            'pengepul_id' => 'required|exists:users,id', // Gunakan pengepul_id yang merujuk ke id pengepul
            'total_harga' => 'required|numeric|min:0',   // Total harga transaksi
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update([
            'petani_id' => $validated['petani_id'],     // Menyimpan ID Petani
            'pengepul_id' => $validated['pengepul_id'],  // Menyimpan ID Pengepul
            'total_harga' => $validated['total_harga'],  // Menyimpan total harga transaksi
        ]);

        return response()->json([
            'success' => true,
            'data' => $transaksi,
            'message' => 'Transaksi berhasil diperbarui',
        ]);
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil dihapus',
        ]);
    }
}
