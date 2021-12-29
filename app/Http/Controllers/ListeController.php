<?php

namespace App\Http\Controllers;

use App\Models\Liste;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ListeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lists = Liste::all();

        return view('pages.liste.index', compact('lists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.liste.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userID' => 'required',
            'listName' => 'required',
        ]);

        if ($validator) {
            $newList = new Liste;
            $newList->user_id = $request->userID;
            $newList->name = $request->listName;
            $newList->save();

            return response()->json($newList->id);
        }

        return response()->json(['error'=>$validator->errors()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Liste  $liste
     * @return \Illuminate\Http\Response
     */
    public function show(Liste $liste)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Liste  $liste
     * @return \Illuminate\Http\Response
     */
    public function edit(Liste $liste)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Liste  $liste
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Liste $liste)
    {
        $liste = Liste::findOrFail($liste->id);

        $liste->name = $request->list_name;
        $liste->save();

        return response()->json($liste);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Liste  $liste
     * @return \Illuminate\Http\Response
     */
    public function destroy(Liste $liste)
    {
        $liste = Liste::findOrFail($liste->id);

        $liste->delete();

        return response()->json("Liste Silindi");
    }
}
