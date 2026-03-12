<?php

namespace App\Http\Controllers;

use App\Models\LikeFoto;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LikeFotoController extends Controller
{
    public function index()
    {
        return LikeFoto::with(['foto', 'user'])->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'FotoID' => ['required', 'integer', 'exists:foto,FotoID'],
            'UserID' => ['required', 'integer', 'exists:user,UserID'],
            'TanggalLike' => ['required', 'date'],
        ]);

        // Prevent duplicate likes from the same user on the same photo.
        $exists = LikeFoto::where('FotoID', $data['FotoID'])
            ->where('UserID', $data['UserID'])
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'User already liked this photo'], 409);
        }

        return LikeFoto::create($data);
    }

    public function show(LikeFoto $likeFoto)
    {
        return $likeFoto->load(['foto', 'user']);
    }

    public function update(Request $request, LikeFoto $likeFoto)
    {
        $data = $request->validate([
            'TanggalLike' => ['sometimes', 'required', 'date'],
        ]);

        $likeFoto->update($data);

        return $likeFoto;
    }

    public function destroy(LikeFoto $likeFoto)
    {
        $likeFoto->delete();

        return response()->noContent();
    }
}
