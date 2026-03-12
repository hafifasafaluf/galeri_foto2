<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FotoController extends Controller
{
    public function index()
    {
        return Foto::with(['album', 'user', 'komentar', 'likes'])->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'JudulFoto' => ['required', 'string', 'max:255'],
            'DeskripsiFoto' => ['nullable', 'string'],
            'TanggalUnggah' => ['required', 'date'],
            'LokasiFile' => ['required', 'string', 'max:255'],
            'AlbumID' => ['required', 'integer', 'exists:album,AlbumID'],
            'UserID' => ['required', 'integer', 'exists:user,UserID'],
        ]);

        return Foto::create($data);
    }

    public function show(Foto $foto)
    {
        return $foto->load(['album', 'user', 'komentar', 'likes']);
    }

    public function update(Request $request, Foto $foto)
    {
        $data = $request->validate([
            'JudulFoto' => ['sometimes', 'required', 'string', 'max:255'],
            'DeskripsiFoto' => ['nullable', 'string'],
            'TanggalUnggah' => ['sometimes', 'required', 'date'],
            'LokasiFile' => ['sometimes', 'required', 'string', 'max:255'],
            'AlbumID' => ['sometimes', 'required', 'integer', 'exists:album,AlbumID'],
            'UserID' => ['sometimes', 'required', 'integer', 'exists:user,UserID'],
        ]);

        $foto->update($data);

        return $foto;
    }

    public function destroy(Foto $foto)
    {
        $foto->delete();

        return response()->noContent();
    }
}
