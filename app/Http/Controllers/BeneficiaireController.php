<?php

namespace App\Http\Controllers;

use App\Models\Promotrice;
use App\Models\User;
use App\Models\Valeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BeneficiaireController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
   public function gotoEspaceBeneficiaire(){
       $promotrice= Promotrice::where('code_promoteur', Auth::user()->code_promoteur)->first();
       return view('public.espace_beneficiaire',compact("promotrice"));
   }
   public function showprofil(){
    $promotrice= Promotrice::where('code_promoteur', Auth::user()->code_promoteur)->first();
    $regions=Valeur::where('parametre_id',env('PARAMETRE_ID_REGION'))->get();
    $niveau_instructions=Valeur::where("parametre_id", env('PARAMETRE_NIVEAU_D_INSTRUCTION'))->get();
    $nb_annee_experience=Valeur::where("parametre_id", env('PARAMETRE_TRANCHE_EXPERIENCE'))->get();
    return view('public.profilbeneficiaire', compact("promotrice", "niveau_instructions","nb_annee_experience","regions"));
   }
   public function updatebeneficiare(Request $request, Promotrice $promotrice){
    $datenaiss= date('Y-m-d', strtotime($request->datenais_promoteur));
    $date_etabli_identite= date('Y-m-d', strtotime($request->date_identification));
        $promotrice->update([
            'nom' => $request->nom_promoteur,
            'prenom' => $request->prenom_promoteur,
            'datenais' => $datenaiss,
            'genre' => $request->genre,
            'fonction'=>$request->fonction,
            'telephone_promoteur' => $request->telephone_promoteur,
            'email_promoteur' => $request->email_promoteur,
            'type_identite' => $request->type_identite_promoteur,
            'numero_identite' => $request->numero_identite,
            'date_etabli_identite' => $date_etabli_identite,
            'mobile_promoteur' => $request->mobile_promoteur,
            'region_residence' => $request->region_residence,
            'province_residence' => $request->province_residence,
            'commune_residence' => $request->commune_residence,
            'situation_residence' => $request->situation_residence,
            'arrondissement_residence' => $request->arrondissement_residence,
            'niveau_instruction' => $request->niveau_instruction,
            'domaine_formation'=> $request->domaine_formation,
            'nombre_annee_experience'=> $request->nombre_annee_experience,
            'formation_en_rapport_avec_activite' => $request->formation_activite,
            'occupation_professionnelle_actuelle' => $request->occupation_pro_actuelle,
        ]);
        $user= User::find(Auth::user()->id);
        $user->update([
            'name'=>$request->nom_promoteur,
            'prenom' => $request->prenom_promoteur,
            'email' => $request->email_promoteur,
        ]);
        if(!empty($request['password'])){
            $user->update([
                'password' => bcrypt($request['password'])
            ]);
        }
        return redirect()->back();

   }
}
