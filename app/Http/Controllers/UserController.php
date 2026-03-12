<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'Username' => ['required', 'string', 'max:255', 'unique:user,Username'],
            'Password' => ['required', 'string', 'min:6'],
            'Email' => ['required', 'email', 'max:255', 'unique:user,Email'],
            'NamaLengkap' => ['required', 'string', 'max:255'],
            'Alamat' => ['nullable', 'string'],
        ]);

        $data['Password'] = bcrypt($data['Password']);

        return User::create($data);
    }

    public function show(User $user)
    {
        return $user;
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'Username' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('user', 'Username')->ignore($user->UserID, 'UserID')],
            'Password' => ['sometimes', 'nullable', 'string', 'min:6'],
            'Email' => ['sometimes', 'required', 'email', 'max:255', Rule::unique('user', 'Email')->ignore($user->UserID, 'UserID')],
            'NamaLengkap' => ['sometimes', 'required', 'string', 'max:255'],
            'Alamat' => ['nullable', 'string'],
        ]);

        if (isset($data['Password'])) {
            $data['Password'] = bcrypt($data['Password']);
        }

        $user->update($data);

        return $user;
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->noContent();
    }
}
