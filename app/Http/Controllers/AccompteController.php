<?php

namespace App\Http\Controllers;

use App\Models\Accompte;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AccompteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function accompte_de_la_beneficiaire(Entreprise $entreprise){
        
        $accomptes= Accompte::where("entreprise_id",$entreprise->id)->get();
       // dd($accomptes);
        return view("accompte.index", compact("accomptes","entreprise"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_for_beneficiary(Entreprise $entreprise)
    {
        return view("accompte.create", compact("entreprise") );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        // $validated= $request->validate([
        //     'nom_promoteur' =>'required',
        //     'numero_identite'=>'unique:promotrices|max:255',
        //     'telephone_promoteur'=>'unique:promotrices|max:255',
        //     ]);
        if ($request->hasFile('copie_du_recu')) {
        $copie_du_recu= $request->copie_du_recu->store('public/recu_paiement_accompte_beneficiaire');
    }
    else{
        $copie_du_recu=null;
    }
    // $montant=reformater_montant($request->montant);
    // $montant= doubleval($montant);
  //  dd($montant);
       Accompte::create([
           'entreprise_id'=>$request['entreprise_id'],
           'date_versement'=>$request['date'],
           'montant'=> reformater_montant($request->montant), 
           'copie_du_recu'=>$copie_du_recu
       ]);
       return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Accompte  $accompte
     * @return \Illuminate\Http\Response
     */
    public function show(Accompte $accompte)
    {
        //
    }
    public function get_recu(Accompte $accompt){
       // dd($accompt);
        return $path = Storage::download($accompt->copie_du_recu);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Accompte  $accompte
     * @return \Illuminate\Http\Response
     */
    public function edit(Accompte $accompte)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Accompte  $accompte
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Accompte $accompte)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Accompte  $accompte
     * @return \Illuminate\Http\Response
     */
    public function destroy(Accompte $accompte)
    {
        //
    }
}
