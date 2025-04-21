<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JanjiTemu;
use Illuminate\Http\Request;

class janjitemuController extends Controller
{
    public function index()
    {
        return response()->json(JanjiTemu::all(), 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_petani'  => 'required|string|max:255',
            'alamat'       => 'required|string|max:500',
            'no_hp'        => 'required|string|max:20',
            'date'        => 'required|date',
        ]);

        $janji = JanjiTemu::create($data);

        return response()->json($janji, 201);
    }

    public function show($id)
    {
        $janji = JanjiTemu::findOrFail($id);
        return response()->json($janji, 200);
    }

    public function update(Request $request, $id)
    {
        $janji = JanjiTemu::findOrFail($id);

        $data = $request->validate([
            'nama_petani'  => 'required|string|max:255',
            'alamat'       => 'required|string|max:500',
            'no_hp'        => 'required|string|max:20',
            'date'        => 'required|date',
        ]);

        $janji->update($data);

        return response()->json($janji, 200);
    }

    public function destroy($id)
    {
        JanjiTemu::destroy($id);
        return response()->json(null, 204);
    }
}
