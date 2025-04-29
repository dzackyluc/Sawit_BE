<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JanjiTemu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class JanjiTemuController extends Controller
{
    /**
     * Display a listing of all janji temus.
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

        $data = $request->validate([
            'petani_id'   => 'sometimes|required|exists:users,id',
            'alamat'      => 'sometimes|required|string|max:500',
            'no_hp'       => 'sometimes|required|string|max:20',
            'tanggal'     => 'sometimes|required|date',
            'petani_lat'  => 'sometimes|required|numeric',
            'petani_lng'  => 'sometimes|required|numeric',
        ]);

        $janji->update($data);

        return response()->json([
            'success' => true,
            'data'    => $janji,
            'message' => 'Janji temu updated successfully',
        ], 200);
    }

    /**
     * Remove the specified janji temu.
     */
    public function destroy($id)
    {
        JanjiTemu::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Janji temu deleted successfully',
        ], 204);
    }
}
