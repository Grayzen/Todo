<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body id="body">
    <div id="app">
        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">{{ __('Dashboard') }}</div>

                            <div class="card-body row">
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-3">
                                        <ul class="navbar-nav ms-auto">
                                            <li class="nav-item dropdown">
                                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                    {{ Auth::user()->name }}
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                                       onclick="event.preventDefault();
                                                                     document.getElementById('logout-form').submit();">
                                                        {{ __('Logout') }}
                                                    </a>

                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                        @csrf
                                                    </form>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-9">
                                        {{ $title }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <a class="btn btn-link" href="{{ route('pano.index') }}">
                                            {{ __('Panolar') }}
                                        </a><br>
                                        <a class="btn btn-link" href="{{ route('users') }}">
                                            {{ __('Uyeler') }}
                                        </a><br>
                                        <a class="btn btn-link" href="">
                                            {{ __('Ayarlar') }}
                                        </a><br>
                                        Panolarınız <br>
                                        <ul>
                                            @foreach (auth()->user()->panos as $pano)
                                                <li>
                                                    <a class="btn btn-link" href="{{ route('pano.show', $pano) }}">
                                                        {{ $pano->id == auth()->user()->id ? "Benim Panom" : $pano->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="col-9">
                                        @yield('content')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    @yield('js')
</body>
</html>
