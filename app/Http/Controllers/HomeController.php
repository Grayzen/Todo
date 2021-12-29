<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userPano = User::findOrFail(auth()->user()->id);

        $title = "Benim Panom";

        return view('pages.pano.show', compact('title', 'userPano'));
    }

    public function users()
    {
        $uyeler = User::all()->except(auth()->user()->id);

        $title = "Uyeler";

        return view('pages.uyeler.index', compact('title', 'uyeler'));
    }
}
