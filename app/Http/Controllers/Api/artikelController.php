<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class artikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $artikels = Artikel::all();
        return response()->json([
            'success' => true,
            'data'    => $artikels,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'title.required'   => 'Judul artikel wajib diisi.',
            'content.required' => 'Konten artikel wajib diisi.',
            'image.image'      => 'File gambar harus berupa gambar.',
            'image.max'        => 'Ukuran gambar maksimal 2MB.',
        ];
    
        $data = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|max:2048',
        ], $messages);
    
        if ($request->hasFile('image')) {
            // simpan di public/images/artikels
            $path = $request->file('image')->store('images/artikels', 'public');
            $data['image'] = $path;
        }
    
        $artikel = Artikel::create($data);
    
        return response()->json([
            'success' => true,
            'data'    => $artikel,
            'message' => 'Artikel berhasil dibuat',
        ], 201);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Artikel $artikel)
    {
        return response()->json([
            'success' => true,
            'data'    => $artikel,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Artikel $artikel)
    {
        $messages = [
            'title.required'   => 'Judul artikel wajib diisi.',
            'content.required' => 'Konten artikel wajib diisi.',
            'image.image'      => 'File gambar harus berupa gambar.',
            'image.max'        => 'Ukuran gambar maksimal 2MB.',
        ];
    
        $data = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|max:2048',
        ], $messages);
    
        if ($request->hasFile('image')) {
            // hapus file lama bila ada
            if ($artikel->image) {
                Storage::disk('public')->delete($artikel->image);
            }
            $path = $request->file('image')->store('images/artikels', 'public');
            $data['image'] = $path;
        }
    
        $artikel->update($data);
    
        return response()->json([
            'success' => true,
            'data'    => $artikel,
            'message' => 'Artikel berhasil diperbarui',
        ], 200);
    }    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artikel $artikel)
    {
        // hapus file image bila ada
        if ($artikel->image) {
            Storage::disk('public')->delete($artikel->image);
        }
        $artikel->delete();

        return response()->json([
            'success' => true,
            'message' => 'Artikel berhasil dihapus',
        ], 200);
    }
}
