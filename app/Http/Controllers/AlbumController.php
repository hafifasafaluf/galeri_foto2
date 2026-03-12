<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AlbumController extends Controller
{
    public function index()
    {
        return Album::with(['user', 'fotos'])->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'NamaAlbum' => ['required', 'string', 'max:255'],
            'Deskripsi' => ['nullable', 'string'],
            'TanggalDibuat' => ['required', 'date'],
            'UserID' => ['required', 'integer', 'exists:user,UserID'],
        ]);

        return Album::create($data);
    }

    public function show(Album $album)
    {
        return $album->load(['user', 'fotos']);
    }

    public function update(Request $request, Album $album)
    {
        $data = $request->validate([
            'NamaAlbum' => ['sometimes', 'required', 'string', 'max:255'],
            'Deskripsi' => ['nullable', 'string'],
            'TanggalDibuat' => ['sometimes', 'required', 'date'],
            'UserID' => ['sometimes', 'required', 'integer', 'exists:user,UserID'],
        ]);

        $album->update($data);

        return $album;
    }

    public function destroy(Album $album)
    {
        $album->delete();

        return response()->noContent();
    }
}
