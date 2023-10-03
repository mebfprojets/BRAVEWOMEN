<?php

namespace App\Http\Controllers;

use App\Models\Banque;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $beneficiaire_non_affectees= Entreprise::where('verdit_pca','selectionné')->where('banque_id',null)->orderBy('updated_at', 'desc')->get();
        $entreprises_affectee_ala_banque = Entreprise::where('banque_id',$banque->id)->orderBy('updated_at', 'desc')->get();
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
        if (Auth::user()->can('lister_les_mouvements_financiers')) {
        if(Auth::user()->banque_id!=null){
            $entreprises= Entreprise::where('resultat_kyc', 'concluant')->where("date_de_signature_accord_beneficiaire",'!=',null)->where("banque_id",Auth::user()->banque_id)->get();
        }
        elseif(Auth::user()->banque_id==null){
            $entreprises= Entreprise::where('resultat_kyc', 'concluant')->where("date_de_signature_accord_beneficiaire",'!=',null)->get();
        }
            return view("banque.beneficiaires",compact("entreprises"));
        }
        else{
            flash("Vous n'avez pas le droit d'acceder à cette ressource. Bien vouloir contacter l'administrateur !!!")->success();
            return redirect()->back();
        }
    }
    public function mobilisation_de_fond_par_banque(){
        $contrepartie_par_banks= DB::table('accomptes')
        ->join('entreprises','accomptes.entreprise_id','=','entreprises.id')
        ->where('entreprises.banque_id',Auth::user()->banque_id)
        ->get();
    
$subvention_par_banks= DB::table('subventions')
        ->join('entreprises','subventions.entreprise_id','=','entreprises.id')
        ->where('entreprises.banque_id',Auth::user()->banque_id)
        ->select('subventions.montant_subvention as montant' , 'subventions.date_subvention as date_subvention', 'entreprises.denomination', 'entreprises.telephone_entreprise')
        ->get();
        return view('banque.mobilisation', compact('contrepartie_par_banks','subvention_par_banks'));
    }
public function demande_de_payement_par_banque(Request $request){
    $factures= DB::table('factures')
                ->join('entreprises','factures.entreprise_id','=','entreprises.id')
                ->where('entreprises.banque_id',Auth::user()->banque_id)
                ->where('factures.statut',$request->statut)
                ->select('factures.id as facture_id', 'factures.montant' , 'factures.mode_de_paiement', 'factures.num_facture', 'entreprises.telephone_entreprise', 'entreprises.denomination', 'factures.num_facture')
                ->get();
    if($request->statut=='validé'){
        return view('banque.dem_paiement', compact('factures'));
    }
    else{
        return view('banque.dem_paiement_paye', compact('factures'));
    }
}
}
