<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DaftarHarga;
use Illuminate\Http\Request;

class DaftarHargaController extends Controller
{
    public function index()
{
    $data = DaftarHarga::all()->map(function ($item) {
        $item->bulan = $item->tanggal->format('F'); // Menambahkan nama bulan
        return $item;
    });
    return response()->json($data);
}


    public function store(Request $request)
    {
        $request->validate([
            'harga' => 'required|numeric',
        ]);

        $data = DaftarHarga::create($request->all());

        $latestData = DaftarHarga::where('tanggal', '<', $request->tanggal)
            ->orderBy('tanggal', 'desc')
            ->first();

        if ($latestData) {
            $diff = $request->harga - $latestData->harga;
            $kenaikan = $diff > 0 ? $diff : 0;
            $penurunan = $diff < 0 ? abs($diff) : 0;
            $presentase = $diff !== 0 ? abs(($diff / $latestData->harga) * 100) : 0;

            $request->merge([
                'kenaikan' => $kenaikan,
                'presentase' => $presentase,
            ]);
        }

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
