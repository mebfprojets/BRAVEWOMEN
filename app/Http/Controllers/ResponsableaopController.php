<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Models\Promotrice;
use App\Models\Valeur;
use Illuminate\Http\Request;
use App\Models\Proportion_de_depense_promotrice;


class ResponsableaopController extends Controller
{
    public function completeview($code){
        $proportiondedepences= Valeur::where('parametre_id', 32)->get();
         $annees=Valeur::where('parametre_id',16 )->get();
        $promoteur = Promotrice::where('code_promoteur',$code)->first();
        $proportiondedepence=Proportion_de_depense_promotrice::where('promotrice_id', $promoteur->id )->get();
        (count($proportiondedepence) == 0)?($afficherproportion=1):($afficherproportion=0);
       return view("public.completeresponsableAOP", compact("promoteur","proportiondedepences","annees","afficherproportion"));
    }

    public function create()
    {
        
        $regions=Valeur::where('parametre_id',env('PARAMETRE_ID_REGION'))->get();
        $niveau_instructions=Valeur::where("parametre_id", env('PARAMETRE_NIVEAU_D_INSTRUCTION'))->get();
        $proportiondedepences= Valeur::where('parametre_id', 32)->get();
         $annees=Valeur::where('parametre_id',16 )->get();
        return view("public.responsableAOP", compact("regions","proportiondedepences","annees", "niveau_instructions"));
    }
    public function storecompleteresponsableaop(Request $request)
    {
        $proportiondedepences= Valeur::where('parametre_id', 32)->get();
        $annees=Valeur::where('parametre_id',16 )->get();
        $promoteur= Promotrice::find($request->promoteur);
        $promoteur->update([
            'fonction'=>$request->fonction,
           'suscriptionaopleader_etape'=>1,
        ]);
        if($request->afficherproportion){
            foreach($proportiondedepences as $proportiondedepence){
                foreach($annees as $annee){
                    $variable=$proportiondedepence->id.$annee->id;
                    Proportion_de_depense_promotrice::create([
                        "proportion_id"=>$proportiondedepence->id,
                        "annee_id"=>$annee->id,
                        "pourcentage"=>$request->$variable,
                        "promotrice_id"=>$promoteur->id,
                    ]);
                }
            }
            return  view("validateStep1aop", compact("promoteur"))->with('success','Item created successfully!');
        }
        
       
    }
    public function store(Request $request)
    {
        $this->email = $request->email_promoteur;
        $this->nom = $request->nom_promoteur;
        $this->prenom= $request->prenom_promoteur;
        $proportiondedepences= Valeur::where('parametre_id', 32)->get();
        $annees=Valeur::where('parametre_id',16 )->get();
       $validated= $request->validate([
            'nom_promoteur' =>'required',
            // 'numero_identite'=>'unique:promotrices|max:255',
            'telephone_promoteur'=>'unique:promotrices|max:255',
            ]);

        $dateTime = new \DateTime();
        $dateTime= $dateTime->format('is');
        $code_promoteur = 'BWBF-AL'.$request->telephone_promoteur.$dateTime;
        $details['email'] = $this->email;
        $details['nom'] = $this->nom;
        $details['prenom'] = $this->prenom;
        $details['code'] = $code_promoteur;
        $datenaiss= date('Y-m-d', strtotime($request->datenais_promoteur));
        $date_etabli_identite= date('Y-m-d', strtotime($request->date_identification));
        $dest=dispatch(new SendEmailJob($details));
       $promoteur= Promotrice::create([
            'nom' => $request->nom_promoteur,
            'prenom' => $request->prenom_promoteur,
            'fonction'=>$request->fonction,
            'datenais' => $datenaiss,
            'genre' => $request->genre,
            'telephone_promoteur' => $request->telephone_promoteur,
            'email_promoteur' => $request->email_promoteur,
            'type_identite' => $request->type_identite_promoteur,
            'numero_identite' => $request->numero_identite,
            'date_etabli_identite' => $date_etabli_identite,
            'mobile_promoteur' => $request->mobile_promoteur,
            'code_promoteur'=>$code_promoteur,
            'region_residence' => $request->region_residence,
            'province_residence' => $request->province_residence,
            'commune_residence' => $request->commune_residence,
            'situation_residence' => $request->situation_residence,
            'arrondissement_residence' => $request->arrondissement_residence,
            'niveau_instruction' => $request->niveau_instruction,
            'domaine_formation'=> $request->domaine_formation,
            'nombre_annee_experience'=> $request->nombre_annee_experience,
            'precision_residence' => $request->precision_residence,
            'formation_en_rapport_avec_activite' => $request->formation_activite,
            'occupation_professionnelle_actuelle' => $request->occupation_pro_actuelle,
             'membre_ass' => 0,
             'domaine_etude'=>$request->domaine_detude,
            // 'compte_perso_existe' => $request->compte_perso_existe,
            // 'structure_financiere_personne'=> $request->structure_financiere_personne,
            // 'associations' => $request->associations,
            "resp_aop"=>1,

            'suscriptionaopleader_etape'=>1
        ]);
        foreach($proportiondedepences as $proportiondedepence){
            foreach($annees as $annee){
                $variable=$proportiondedepence->id.$annee->id;
                Proportion_de_depense_promotrice::create([
                    "proportion_id"=>$proportiondedepence->id,
                    "annee_id"=>$annee->id,
                    "pourcentage"=>$request->$variable,
                    "promotrice_id"=>$promoteur->id,
                ]);
            }
        }
        return  view("validateStep1aop", compact("promoteur"))->with('success','Item created successfully!');
    }
}
