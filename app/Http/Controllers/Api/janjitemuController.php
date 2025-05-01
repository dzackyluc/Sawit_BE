<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JanjiTemu;
use App\Models\User;

class JanjiTemuController extends Controller
{
    /**
     * Tampilkan semua janji temu
     */
    public function index()
    {
        $janji = JanjiTemu::with('petani')->get();

        return response()->json([
            'success' => true,
            'data' => $janji,
        ]);
    }

    /**
     * Tampilkan satu janji temu
     */
    public function show($id)
    {
        $janji = JanjiTemu::with('petani')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $janji,
        ]);
    }

    /**
     * Store janji temu baru
     */
    public function store(Request $request)
    {
        // Validasi input yang dikirimkan petani
        $validated = $request->validate([
            'petani_id' => 'required|exists:users,id',  // Pastikan petani_id valid
            'no_hp' => 'required|string',
            'alamat' => 'required|string',
            'tanggal' => 'required|date',
            'petani_lat' => 'required|numeric',
            'petani_lng' => 'required|numeric',
        ]);

        // Menyimpan data janji temu
        $janji = JanjiTemu::create([
            'petani_id' => $validated['petani_id'],
            'no_hp' => $validated['no_hp'],
            'alamat' => $validated['alamat'],
            'tanggal' => $validated['tanggal'],
            'petani_lat' => $validated['petani_lat'],
            'petani_lng' => $validated['petani_lng'],
            'status' => 'pending',  // Status awal adalah pending
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Janji temu berhasil disimpan dan menunggu approval',
            'data' => $janji,
        ], 201);
    }

    /**
     * Approve janji temu
     */
    public function approve($id)
    {
        $janji = JanjiTemu::findOrFail($id);
        $janji->update(['status' => 'approved', 'alasan_reject' => null]);

        return response()->json([
            'success' => true,
            'message' => 'Janji temu telah disetujui',
            'data' => $janji,
        ]);
    }

    /**
     * Reject janji temu dengan alasan
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'alasan_reject' => 'required|string',
        ]);

        $janji = JanjiTemu::findOrFail($id);
        $janji->update([
            'status' => 'rejected',
            'alasan_reject' => $request->input('alasan_reject'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Janji temu ditolak',
            'data' => $janji,
        ]);
    }

    /**
     * Update data janji temu (misal ubah tanggal atau alamat)
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'alamat' => 'sometimes|string',
            'no_hp' => 'sometimes|string',
            'tanggal' => 'sometimes|date',
            'petani_lat' => 'sometimes|numeric',
            'petani_lng' => 'sometimes|numeric',
        ]);

        $janji = JanjiTemu::findOrFail($id);
        $janji->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data janji temu diperbarui',
            'data' => $janji,
        ]);
    }

    /**
     * Hapus janji temu
     */
    public function destroy($id)
    {
        $janji = JanjiTemu::findOrFail($id);
        $janji->delete();

        return response()->json([
            'success' => true,
            'message' => 'Janji temu dihapus',
        ]);
    }
}