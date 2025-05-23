<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PengepulImport;
use App\Models\User;

class PengepulController extends Controller
{
    /**
     * Display a listing of pengepul users.
     */
        public function index()
    {
        $pengepuls = User::where('role', 'pengepul')->get();

        $pengepuls->transform(function ($item) {
            $item->photo_url = $item->photo ? url('storage/' . $item->photo) : null;
            return $item;
        });

        return response()->json([
            'success' => true,
            'data' => $pengepuls,
        ], 200);
    }

    /**
     * Store a newly created pengepul user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'no_phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('pengepul', 'public');
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'no_phone' => $validated['no_phone'] ?? null,
            'role' => 'pengepul',
            'photo' => $photoPath,
        ]);

        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'Pengepul created successfully',
        ], 201);
    }

    /**
     * Display the specified pengepul user.
     */
    public function show($id)
    {
        $user = User::where('role', 'pengepul')->findOrFail($id);

        $user->photo_url = $user->photo ? url('storage/' . $user->photo) : null;

        return response()->json([
            'success' => true,
            'data' => $user,
        ], 200);
    }

    /**
     * Update the specified pengepul user.
     */
    public function update(Request $request, $id)
    {
        $user = User::where('role', 'pengepul')->findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => "sometimes|required|email|unique:users,email,{$id}",
            'password' => 'sometimes|nullable|string|min:6|confirmed',
            'no_phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if (isset($validated['name'])) {
            $user->name = $validated['name'];
        }
        if (isset($validated['email'])) {
            $user->email = $validated['email'];
        }
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        if (array_key_exists('no_phone', $validated)) {
            $user->no_phone = $validated['no_phone'];
        }
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika perlu (opsional)
            if ($user->photo) {
                \Storage::disk('public')->delete($user->photo);
            }
            $user->photo = $request->file('photo')->store('pengepul', 'public');
        }

        $user->save();

        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'Pengepul updated successfully',
        ], 200);
    }

    /**
     * Remove the specified pengepul user from storage.
     */
    public function destroy($id)
    {
        $user = User::where('role', 'pengepul')->findOrFail($id);
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pengepul deleted successfully',
        ], 200);
    }

    /**
     * Import pengepul users from Excel file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048',
        ]);

        Excel::import(new PengepulImport, $request->file('file'));

        return response()->json([
            'success' => true,
            'message' => 'Data pengepul berhasil diunggah',
        ], 200);
    }
}
