<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    // Register new user
    public function register(Request $request)
    {
        $messages = [
            'name.required'     => 'Nama wajib diisi.',
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email sudah digunakan.',
            'no_phone.regex' => 'Nomor telepon harus diawali 08 dan diikuti 8-12 digit.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
            'password.confirmed'=> 'Konfirmasi password tidak cocok.',
        ];
    
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'no_phone' => 'nullable|string|regex:/^08[0-9]{8,12}$/',
            'role'     => 'nullable|in:pengepul,petani,manager',
        ], $messages);
    
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'no_phone'    => $validated['no_phone'],
            'password' => Hash::make($validated['password']),
            'role'     => 'petani',
        ]);
    
        $token = $user->createToken('auth_token')->plainTextToken;
    
        return response()->json([
            'user'  => $user,
            'token' => $token,
        ], 201);
    }
    

    // Login user
    public function login(Request $request)
    {
        $messages = [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ];
    
        $validated = $request->validate([
            'email'     => 'required|string|email',
            'password'  => 'required|string',
            'fcm_token' => 'nullable|string',
        ], $messages);
    
        $user = User::where('email', $validated['email'])->first();
    
        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'Email atau password salah'
            ], 401);
        }
    
        if (isset($validated['fcm_token'])) {
            $user->update([
                'fcm_token' => $validated['fcm_token'],
            ]);
        }
    
        $token = $user->createToken('auth_token')->plainTextToken;
    
        return response()->json([
            'user'  => $user,
            'token' => $token,
        ]);
    }
    
    
    // Logout (revoke current token)
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out'
        ]);
    }

    // Get authenticated user
    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
