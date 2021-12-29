<?php

namespace App\Http\Controllers;

use App\Models\Control;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ControlController extends Controller
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
            'card_id' => 'required',
            'controlName' => 'required',
        ]);

        if ($validator) {
            $newControl = new Control;
            $newControl->card_id = $request->card_id;
            $newControl->name = $request->controlName;
            $newControl->save();

            return response()->json($newControl->id);
        }

        return response()->json(['error'=>$validator->errors()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Control  $control
     * @return \Illuminate\Http\Response
     */
    public function show(Control $control)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Control  $control
     * @return \Illuminate\Http\Response
     */
    public function edit(Control $control)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Control  $control
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Control $control)
    {
        $cont = Control::findOrFail($control->id);

        $cont->name = $request->control_name;
        $cont->save();

        return response()->json($cont->name);

    }

    public function check(Request $request, Control $control)
    {
        $cont = Control::findOrFail($request->control_id);

        if($cont->done == 0)
            $cont->done = 1;
        else
            $cont->done = 0;

        $cont->save();

        return response()->json(["id" => $cont->id, "done" => $cont->done]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Control  $control
     * @return \Illuminate\Http\Response
     */
    public function destroy(Control $control)
    {
        $control = Control::findOrFail($control->id);

        $control->delete();

        return response()->json("Kontrol Öğesi Silindi");
    }
}
