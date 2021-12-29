<?php

namespace App\Http\Controllers;

use App\Models\Liste;
use App\Models\Pano;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PanoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::findOrFail(auth()->user()->id);

        $title = "Panolar";

        return view('pages.pano.index', compact('title', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pano  $pano
     * @return \Illuminate\Http\Response
     */
    public function show(Pano $pano)
    {
        $userPano = User::findOrFail($pano->id);

        $title = $pano->id == auth()->user()->id ? "Benim Panom" : $pano->name;

        return view('pages.pano.show', compact('title', 'userPano'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pano  $pano
     * @return \Illuminate\Http\Response
     */
    public function edit(Pano $pano)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pano  $pano
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pano $pano)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pano  $pano
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pano $pano)
    {
        //
    }

    public function userSetPanos(Request $request)
    {

        $userPanos = [];
        if($request->panolar)
            $userPanos = $request->panolar;

        array_push($userPanos, auth()->user()->id);

        $userChoice = User::whereIn('id', $userPanos)->get();

        $userPano = Pano::findOrFail(auth()->user()->id);
        $userPano->users()->sync($userPanos);
        return response()->json($userPano);

        foreach($userChoice as $user){
            $user->panos()->sync(auth()->user()->id);
        }


        return response()->json("Güncellendi");

    }
}
