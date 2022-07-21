<?php

namespace App\Http\Controllers;

use App\Models\Banque;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BanqueController extends Controller
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
        $banques = Banque::all();
        return view("banque.index",compact('banques'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("banque.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Banque::create([
            "nom"=>$request->nom,
            "telephone"=>$request->telephone,
        ]);
        return redirect()->route("banque.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Banque  $banque
     * @return \Illuminate\Http\Response
     */
    public function show(Banque $banque)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Banque  $banque
     * @return \Illuminate\Http\Response
     */
    public function edit(Banque $banque)
    {

       return view("banque.update", compact('banque'));
    }
    public function affecter_des_beneficiaire(Banque $banque,Request $request){
        $beneficiaire_non_affectees= Entreprise::where('entrepriseaop',null)->where('banque_id',null)->orderBy('updated_at', 'desc')->get();
        $entreprises_affectee_ala_banque = Entreprise::where("decision_du_comite_phase1", null)->where('banque_id',$banque->id)->where('entrepriseaop',null)->orderBy('updated_at', 'desc')->get();
        return view('banque.affecter',compact("banque","beneficiaire_non_affectees",'entreprises_affectee_ala_banque'));
    }
    public function store_affifiation_beneficiaire_banque(Request $request)
    {
        $id_beneficiaires= $request->beneficiaires;
        $banque = $request->banque;
            foreach($id_beneficiaires as $beneficiaire){
            $beneficiaire= Entreprise::find($beneficiaire);
            $beneficiaire->update([
                "banque_id"=>$banque,
            ]);
        }
    }
    public function annuler_affifiation_beneficiaire_banque(Request $request)
    {
        $id_beneficiaires= $request->beneficiaires;
        //$banque = $request->banque;
            foreach($id_beneficiaires as $beneficiaire){
            $beneficiaire= Entreprise::where('id',$beneficiaire)->first();
            $beneficiaire->update([
                "banque_id"=>null,
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Banque  $banque
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banque $banque)
    {
        
        $banque->update([
            'nom'=>$request->nom,
            'telephone'=>$request->telephone
        ]);
        return redirect()->route("banque.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banque  $banque
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banque $banque)
    {
        //
    }
    public function liste_des_beneficiaires_de_la_banque(){
        $entreprises= Entreprise::where("banque_id",Auth::user()->banque_id)->get();

        return view("banque.beneficiaires",compact("entreprises"));
    }
}
