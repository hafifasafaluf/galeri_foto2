<?php

namespace App\Http\Controllers;

use App\Models\KomentarFoto;
use Illuminate\Http\Request;

class KomentarFotoController extends Controller
{
    public function index()
    {
        return KomentarFoto::with(['foto', 'user'])->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'FotoID' => ['required', 'integer', 'exists:foto,FotoID'],
            'UserID' => ['required', 'integer', 'exists:user,UserID'],
            'IsiKomentar' => ['required', 'string'],
            'TanggalKomentar' => ['required', 'date'],
        ]);

        return KomentarFoto::create($data);
    }

    public function show(KomentarFoto $komentarFoto)
    {
        return $komentarFoto->load(['foto', 'user']);
    }

    public function update(Request $request, KomentarFoto $komentarFoto)
    {
        $data = $request->validate([
            'IsiKomentar' => ['sometimes', 'required', 'string'],
            'TanggalKomentar' => ['sometimes', 'required', 'date'],
        ]);

        $komentarFoto->update($data);

        return $komentarFoto;
    }

    public function destroy(KomentarFoto $komentarFoto)
    {
        $komentarFoto->delete();

        return response()->noContent();
    }
}
