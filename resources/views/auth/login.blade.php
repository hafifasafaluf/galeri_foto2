@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="box" style="max-width: 480px; margin: auto;">
    <h2 class="subtitle">Login</h2>

    @if ($errors->any())
        <div class="notification is-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ url('/login') }}">
        @csrf

        <div class="field">
            <label class="label">Username</label>
            <div class="control">
                <input class="input" type="text" name="Username" value="{{ old('Username') }}" required />
            </div>
        </div>

        <div class="field">
            <label class="label">Password</label>
            <div class="control">
                <input class="input" type="password" name="Password" required />
            </div>
        </div>

        <div class="field">
            <div class="control">
                <label class="checkbox">
                    <input type="checkbox" name="remember"> Ingat saya
                </label>
            </div>
        </div>

        <div class="field is-grouped">
            <div class="control">
                <button class="button is-primary" type="submit">Login</button>
            </div>
            <div class="control">
                <a class="button is-light" href="{{ url('/register') }}">Register</a>
            </div>
        </div>
    </form>
</div>
@endsection
