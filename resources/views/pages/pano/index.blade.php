@extends('layouts.app')

@section('content')

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

@endsection

@section('js')
    <script type="text/javascript">

    </script>
@endsection
