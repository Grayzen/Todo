@extends('layouts.app')

@section('content')
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
                            Benim Panom
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <a class="btn btn-link" href="">
                                {{ __('Panolar') }}
                            </a><br>
                            <a class="btn btn-link" href="">
                                {{ __('Uyeler') }}
                            </a><br>
                            <a class="btn btn-link" href="">
                                {{ __('Ayarlar') }}
                            </a><br>
                            Panolarınız <br>
                            <a class="btn btn-link" href="{{ route('liste.index') }}">
                                {{ __('Benim Panom') }}
                            </a><br>
                        </div>
                        <div class="col-9">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
