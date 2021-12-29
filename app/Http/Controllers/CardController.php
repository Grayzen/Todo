<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'list_id' => 'required',
            'cardName' => 'required',
        ]);

        if ($validator) {
            $newCard = new Card;
            $newCard->liste_id = $request->list_id;
            $newCard->name = $request->cardName;
            $newCard->save();

            return response()->json($newCard);
        }

        return response()->json(['error'=>$validator->errors()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function show(Card $card)
    {
            $card = Card::findOrFail($card->id);
            $controls = $card->controls;

            return response()->json(["card" => $card, "controls" => $controls]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function edit(Card $card)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Card $card)
    {
        $card = Card::findOrFail($card->id);

        $card->name = $request->card_title;
        $card->content = $request->card_content;
        $card->save();

        return response()->json($card);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function destroy(Card $card)
    {
        $card = Card::findOrFail($card->id);

        $card->delete();

        return response()->json("Kart Silindi");
    }
}
