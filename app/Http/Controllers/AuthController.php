<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'Username' => ['required', 'string'],
            'Password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors(['Username' => 'Login gagal, cek username/password'])->onlyInput('Username');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'Username' => ['required', 'string', 'max:255', 'unique:user,Username'],
            'Password' => ['required', 'string', 'min:6', 'confirmed'],
            'Email' => ['required', 'email', 'max:255', 'unique:user,Email'],
            'NamaLengkap' => ['required', 'string', 'max:255'],
            'Alamat' => ['nullable', 'string'],
        ]);

        $data['Password'] = Hash::make($data['Password']);

        $user = User::create($data);
        Auth::login($user);

        return redirect('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
