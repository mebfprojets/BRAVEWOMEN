<?php

namespace App\Http\Controllers;

use App\Models\Prestataire;
use App\Models\Valeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PrestataireController extends Controller
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
    if (Auth::user()->can('changer_statut_facture_ou_devis')) {
        $regions=Valeur::where('parametre_id',1)->get();
        $prestataires= Prestataire::all();
        $secteur_activites= Valeur::where('parametre_id', env('PARAMETRE_COMPETENCE_PRESTATAIRE_ID') )->get();
        return view('prestataires.index', compact('prestataires', 'regions', 'secteur_activites'));
    }
    else{
        flash("Vous n'avez pas le droit d'acceder à cette ressource. Veillez contacter l'administrateur!!!")->error();
        return redirect()->back();
    }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $regions=Valeur::where('parametre_id',1 )->get();
        $secteur_activites= Valeur::where('parametre_id', env('PARAMETRE_COMPETENCE_PRESTATAIRE_ID') )->get();
        
        return view('prestataires.create', compact('regions', 'secteur_activites'));
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    if (Auth::user()->can('changer_statut_facture_ou_devis')) {
        $lastOne = DB::table('prestataires')->latest('id')->first();
        if($lastOne){
        $code_prestataire="BWBF-PRES-00". $lastOne->id+1;}
        else{
            $code_prestataire="BWBF-PRES-00".'0';
        }
        Prestataire::create([
            'denomination_entreprise'=> $request->denomination_entreprise, 
            'nom_responsable'=> $request->nom_responsable, 
            'prenom_responsable'=> $request->prenom_responsable, 
            'telephone'=> $request->telephone, 
            'domaine_activite'=> $request->secteur_activite, 
            'region'=> $request->region, 
            'province'=> $request->province, 
            'commune'=> $request->commune, 
            'code_prestaire' => $code_prestataire
        ]);
        return redirect()->route('prestataire.index');
    }
    else{
        flash("Vous n'avez pas le droit d'acceder à cette ressource. Veillez contacter l'administrateur!!!")->error();
        return redirect()->back();
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Prestataire  $prestataire
     * @return \Illuminate\Http\Response
     */
    public function show(Prestataire $prestataire)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Prestataire  $prestataire
     * @return \Illuminate\Http\Response
     */
    public function edit(Prestataire $prestataire)
    {
        $regions=Valeur::where('parametre_id',1 )->get();
        $secteur_activites= Valeur::where('parametre_id', env('PARAMETRE_COMPETENCE_PRESTATAIRE_ID') )->get();
        
        return view('prestataire.edit', compact('prestataire', 'secteur_activites'));
    }
    public function modifier(Request $request){
        $prestataire= Prestataire::find($request->id);
        $data = array(
         'id'=>$prestataire->id,
         'denomination'=>$prestataire->denomination_entreprise,
         'domaine_activite'=>$prestataire->domaine_activite,
         'nom_responsable'=>$prestataire->nom_responsable,
         'prenom_responsable'=>$prestataire->prenom_responsable,
         'telephone'=>$prestataire->telephone,
         'domaine_activite'=>$prestataire->secteur_activite,
         'region'=>$prestataire->region,
         'province'=>$prestataire->province,
         'commune'=>$prestataire->commune, 
     );
     return json_encode($data);
 }
 public function modifierstore(Request $request){
    $prestataire= Prestataire::find($request->prestataire);
    $prestataire->update([
        'denomination_entreprise'=> $request->denomination_entreprise, 
        'nom_responsable'=> $request->nom_responsable, 
        'prenom_responsable'=> $request->prenom_responsable, 
        'telephone'=> $request->telephone, 
        'domaine_activite'=> $request->secteur_activite, 
        'region'=> $request->region, 
        'province'=> $request->province, 
        'commune'=> $request->commune, 
    ]);
    return redirect()->route('prestataire.index');

 }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Prestataire  $prestataire
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prestataire $prestataire)
    {
        $prestataire->update([
            'denomination_entreprise'=> $request->denomination_entreprise, 
            'nom_responsable'=> $request->nom_responsable, 
            'prenom_responsable'=> $request->prenom_responsable, 
            'telephone'=> $request->telephone, 
            'domaine_activite'=> $request->domaine_activite, 
            'region'=> $request->region, 
            'province'=> $request->province, 
            'commune'=> $request->commune, 
        ]);
        return redirect()->route('prestataire');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prestataire  $prestataire
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prestataire $prestataire)
    {
        
    }
    public function verifier_denomination(Request $request){
     //dd($request->denomination);
            $prestataire= Prestataire::where('denomination_entreprise' , 'LIKE', '%'.$request->denomination.'%' )->count();
            //dd($prestataire);
            if($prestataire > 0){
                return 1;
            }
            else{
                return 0;
            }

    }
}
