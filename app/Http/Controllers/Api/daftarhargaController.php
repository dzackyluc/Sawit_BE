<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DaftarHarga;
use Illuminate\Http\Request;

class DaftarHargaController extends Controller
{
    public function index()
    {
        return response()->json(DaftarHarga::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'harga' => 'required|numeric',
        ]);

        $data = DaftarHarga::create($request->all());

        return response()->json($data, 201);
    }

    public function show($id)
    {
        $data = DaftarHarga::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $data = DaftarHarga::findOrFail($id);
        $data->update($request->only('harga', 'tanggal'));

        return response()->json($data);
    }

    public function destroy($id)
    {
        DaftarHarga::destroy($id);
        return response()->json(null, 204);
    }
}
