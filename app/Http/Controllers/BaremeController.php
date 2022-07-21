<?php

namespace App\Http\Controllers;

use App\Models\Bareme;
use App\Models\Valeur;
use Illuminate\Http\Request;

class BaremeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $baremes=Bareme::all();
       return view("bareme.index", compact("baremes"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $criteres= Valeur::where("parametre_id", 15)
                            ->orWhere("parametre_id", 14)
                            ->get();
        return view("bareme.create", compact("criteres"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Bareme::create([
            "valeur_inf"=>$request->val_inf,
            "valeur_sup"=>$request->val_sup,
            "note"=>$request->note,
            "valeur_id"=>$request->critere
        ]);
        return redirect()->route("baremes.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bareme  $bareme
     * @return \Illuminate\Http\Response
     */
    public function show(Bareme $bareme)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bareme  $bareme
     * @return \Illuminate\Http\Response
     */
    public function edit(Bareme $bareme)
    {
        $criteres= Valeur::where("parametre_id", 15)
                            ->orWhere("parametre_id", 14)
                            ->get();
        return view("bareme.update", compact("criteres", "bareme"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bareme  $bareme
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bareme $bareme)
    {
       $bareme->update([
        "valeur_inf"=>$request->val_inf,
        "valeur_sup"=>$request->val_sup,
        "note"=>$request->note,
        "valeur_id"=>$request->critere
    ]);
        return redirect()->route("baremes.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bareme  $bareme
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bareme $bareme)
    {
        //
    }
}
