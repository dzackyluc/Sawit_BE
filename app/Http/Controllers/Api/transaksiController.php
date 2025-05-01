<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\JanjiTemu;
use App\Models\DaftarHarga;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with(['janjiTemu.petani', 'pengepul'])->get();

        return response()->json([
            'success' => true,
            'data' => $transaksis,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'janji_temu_id' => 'required|exists:janji_temu,id',
            'pengepul_id' => 'required|exists:users,id',
            'jumlah' => 'required|numeric|min:0',
        ]);

        $hargaTerbaru = DaftarHarga::latest()->first();
        if (!$hargaTerbaru) {
            return response()->json([
                'success' => false,
                'message' => 'Harga belum tersedia dalam daftar_harga',
            ], 400);
        }

        $totalHarga = $validated['jumlah'] * $hargaTerbaru->harga;

        $transaksi = Transaksi::create([
            'janji_temu_id' => $validated['janji_temu_id'],
            'pengepul_id' => $validated['pengepul_id'],
            'jumlah' => $validated['jumlah'],
            'total_harga' => $totalHarga,
        ]);

        return response()->json([
            'success' => true,
            'data' => $transaksi,
            'message' => 'Transaksi berhasil ditambahkan',
        ], 201);
    }

    public function show($id)
    {
        $transaksi = Transaksi::with(['janjiTemu.petani', 'pengepul'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $transaksi,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'janji_temu_id' => 'required|exists:janji_temu,id',
            'pengepul_id' => 'required|exists:users,id',
            'jumlah' => 'required|numeric|min:0',
        ]);

        $hargaTerbaru = DaftarHarga::latest()->first();
        if (!$hargaTerbaru) {
            return response()->json([
                'success' => false,
                'message' => 'Harga belum tersedia',
            ], 400);
        }

        $totalHarga = $validated['jumlah'] * $hargaTerbaru->harga;

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update([
            'janji_temu_id' => $validated['janji_temu_id'],
            'pengepul_id' => $validated['pengepul_id'],
            'jumlah' => $validated['jumlah'],
            'total_harga' => $totalHarga,
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
