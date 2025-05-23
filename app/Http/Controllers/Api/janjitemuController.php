<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JanjiTemu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class JanjiTemuController extends Controller
{
    /**
     * Tampilkan semua janji temu
     */
    public function index()
    {
        $janjiList = JanjiTemu::with('petani')->get();
        return response()->json([
            'success' => true,
            'data'    => $janjiList,
        ], 200);
    }

    /**
     * Store a newly created janji temu.
     * Expect front-end to provide latitude & longitude from a map picker.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'petani_id'   => 'required|exists:users,id',
            'alamat'      => 'required|string|max:500',
            'no_hp'       => 'required|string|max:20',
            'tanggal'     => 'required|date',
            'petani_lat'  => 'required|numeric',
            'petani_lng'  => 'required|numeric',
        ]);

        $janji = JanjiTemu::create($data);

        return response()->json([
            'success' => true,
            'data'    => $janji,
            'message' => 'Janji temu created successfully',
        ], 201);
    }

    /**
     * Display the specified janji temu.
     */
    public function show($id)
    {
        $janji = JanjiTemu::with('petani', 'tasks')->findOrFail($id);
        return response()->json([
            'success' => true,
            'data'    => $janji,
        ], 200);
    }

    /**
     * Update the specified janji temu.
     */
    public function update(Request $request, $id)
    {
        $janji = JanjiTemu::findOrFail($id);
        $janji->update($validated);

        return response()->json([
            'success' => true,
            'data'    => $janji,
            'message' => 'Janji temu updated successfully',
        ], 200);
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