@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="box" style="max-width: 560px; margin: auto;">
    <h2 class="subtitle">Register</h2>

    @if ($errors->any())
        <div class="notification is-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ url('/register') }}">
        @csrf

        <div class="field">
            <label class="label">Username</label>
            <div class="control">
                <input class="input" type="text" name="Username" value="{{ old('Username') }}" required />
            </div>
        </div>

        <div class="field">
            <label class="label">Email</label>
            <div class="control">
                <input class="input" type="email" name="Email" value="{{ old('Email') }}" required />
            </div>
        </div>

        <div class="field">
            <label class="label">Nama Lengkap</label>
            <div class="control">
                <input class="input" type="text" name="NamaLengkap" value="{{ old('NamaLengkap') }}" required />
            </div>
        </div>

        <div class="field">
            <label class="label">Alamat</label>
            <div class="control">
                <textarea class="textarea" name="Alamat">{{ old('Alamat') }}</textarea>
            </div>
        </div>

        <div class="field">
            <label class="label">Password</label>
            <div class="control">
                <input class="input" type="password" name="Password" required />
            </div>
        </div>

        <div class="field">
            <label class="label">Konfirmasi Password</label>
            <div class="control">
                <input class="input" type="password" name="Password_confirmation" required />
            </div>
        </div>

        <div class="field is-grouped">
            <div class="control">
                <button class="button is-primary" type="submit">Register</button>
            </div>
            <div class="control">
                <a class="button is-light" href="{{ url('/login') }}">Login</a>
            </div>
        </div>
    </form>
</div>
@endsection
