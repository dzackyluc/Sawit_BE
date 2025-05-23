<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\JanjiTemuNotification;
use App\Mail\JanjiTemuRejectedMail;
use Illuminate\Support\Facades\Mail;
use App\Models\JanjiTemu;
use Illuminate\Support\Facades\Validator;

class JanjiTemuController extends Controller
{
    /**
     * Tampilkan semua janji temu
     */
    public function index()
    {
        $janjitemu = JanjiTemu::all();
        return response()->json([
            'success' => true,
            'data'    => $janjitemu,
        ], 200);
    }

    /**
     * Tampilkan satu janji temu
     */
    public function show(JanjiTemu $janjiTemu)
    {
        return response()->json([
            'success' => true,
            'data'    => $janjiTemu,
        ], 200);
    }

    // Code ketika petani mengajukan jadwal pertemuan
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_petani' => 'required|string',
            'email' => 'required|email',
            'no_hp' => 'required|string',
            'alamat' => 'required|string',
            'tanggal' => 'required|date_format:Y-m-d H:i:s',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ], [
            'required' => ':attribute wajib diisi.',
            'email' => 'Format :attribute tidak valid.',
            'date_format' => 'Format :attribute harus Y-m-d H:i:s.',
            'numeric' => ':attribute harus berupa angka.',
        ], [
            // custom attributes agar underscore hilang dan terlihat rapi
            'nama_petani' => 'Nama Petani',
            'email' => 'Email',
            'no_hp' => 'No HP',
            'alamat' => 'Alamat',
            'tanggal' => 'Tanggal',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        $janji = JanjiTemu::create([
            'nama_petani' => $validated['nama_petani'],
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'],
            'alamat' => $validated['alamat'],
            'tanggal' => $validated['tanggal'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'status' => 'pending',
        ]);

        $managerEmails = User::where('role', 'manager')->pluck('email');

        foreach ($managerEmails as $email) {
            Mail::to($email)->send(new JanjiTemuNotification($janji));
        }

        return response()->json([
            'success' => true,
            'message' => 'Janji temu berhasil disimpan dan notifikasi dikirim ke manager.',
            'data' => $janji,
        ], 201);
    }

    /**
     * Reject janji temu
     */
    public function reject(Request $request, $id)
        {
            $request->validate([
                'alasan_reject' => 'required|string',
            ]);

            // Ambil satu model, bukan Collection
            $janji = JanjiTemu::where('id', $id)->firstOrFail();

            $janji->status        = 'rejected';
            $janji->alasan_reject = $request->alasan_reject;
            $janji->save();

            // Kirim email penolakan (asumsikan kolom email benar‐benar string)
            if (! empty($janji->email) && is_string($janji->email)) {
                Mail::to($janji->email)
                    ->send(new JanjiTemuRejectedMail($janji, $request->alasan_reject));
            } else {
                // kalau perlu, log supaya tahu nilai $janji->email apa
                logger()->warning('Gagal kirim email penolakan: email invalid', [
                    'email_field' => $janji->email,
                    'janji_id'    => $janji->id,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Janji temu ditolak dan email notifikasi dikirim',
                'data'    => $janji,
            ], 200);
        }

    /**
     * Update janji temu
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_petani' => 'sometimes|string',
            'no_hp'       => 'sometimes|string',
            'alamat'      => 'sometimes|string',
            'tanggal'     => 'sometimes|date_format:Y-m-d H:i:s',
            'latitude'    => 'sometimes|numeric',
            'longitude'   => 'sometimes|numeric',
        ]);

        $janji = JanjiTemu::findOrFail($id);
        $janji->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data janji temu diperbarui',
            'data'    => $janji,
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