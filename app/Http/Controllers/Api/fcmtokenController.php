<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class FcmTokenController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'old_token' => 'nullable|string',
            'new_token' => 'required|string',
        ]);

        // Cari user berdasarkan old token
        $user = User::where('fcm_token', $request->old_token)->first();

        if ($user) {
            // Update token lama menjadi token baru
            $user->update([
                'fcm_token' => $request->new_token
            ]);
        } else {
            // Optional: kalau old token kosong atau tidak ketemu
            // Kamu bisa abaikan atau log
        }

        return response()->json(['success' => true]);
    }
}
