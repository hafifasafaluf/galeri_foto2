<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Galeri Foto')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>
<body>
    <section class="section">
        <div class="container">
            <nav class="breadcrumb" aria-label="breadcrumbs">
                <ul>
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('/users') }}">Users</a></li>
                    <li><a href="{{ url('/albums') }}">Albums</a></li>
                    <li><a href="{{ url('/fotos') }}">Fotos</a></li>
                    <li><a href="{{ url('/likes') }}">Likes</a></li>
                    <li><a href="{{ url('/komentar') }}">Komentar</a></li>
                </ul>

                <ul style="margin-left: auto;">
                    @auth
                        <li><a href="#">{{ auth()->user()->Username }}</a></li>
                        <li>
                            <form method="POST" action="{{ url('/logout') }}" style="display:inline;">
                                @csrf
                                <button class="button is-small is-light" type="submit">Logout</button>
                            </form>
                        </li>
                    @else
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @endauth
                </ul>
            </nav>

            <h1 class="title">@yield('title')</h1>

            @yield('content')
        </div>
    </section>
</body>
</html>
