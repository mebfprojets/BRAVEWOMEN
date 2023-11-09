<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Mail\NotifyMail;
use App\Models\Entreprise;
use App\Models\Piecejointe;
use App\Models\Promotrice;
use App\Models\Proportion_de_depense_promotrice;
use App\Models\Valeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

class PromotriceController extends Controller
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
    //    return redirect()->back();
    
        $regions=Valeur::where('parametre_id',env('PARAMETRE_ID_REGION'))->get();
        $niveau_instructions=Valeur::where("parametre_id", env('PARAMETRE_NIVEAU_D_INSTRUCTION'))->get();
        $nb_annee_experience=Valeur::where("parametre_id", env('PARAMETRE_TRANCHE_EXPERIENCE'))->get();
        $proportiondedepences= Valeur::where('parametre_id', 31)->get();
       
        $annees=Valeur::where('parametre_id',16 )->get();
        return view("public.subscription", compact("regions", "niveau_instructions","nb_annee_experience","proportiondedepences","annees"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return redirect()->back();
        $proportiondedepences= Valeur::where('parametre_id', 31)->get();
         $annees=Valeur::where('parametre_id',16 )->get();
        $this->email = $request->email_promoteur;
        $this->nom = $request->nom_promoteur;
        $this->prenom= $request->prenom_promoteur;
       $validated= $request->validate([
            'nom_promoteur' =>'required',
            'numero_identite'=>'unique:promotrices|max:255',
            'telephone_promoteur'=>'unique:promotrices|max:255',
            ]);
        $dateTime = new \DateTime();
        $dateTime= $dateTime->format('YmdHis');
        $code_promoteur = 'BWBF-'.$request->telephone_promoteur.$dateTime;
        $details['email'] = $this->email;
        $details['nom'] = $this->nom;
        $details['prenom'] = $this->prenom;
        $details['code'] = $code_promoteur;
        $dest=dispatch(new SendEmailJob($details));
        $datenaiss= date('Y-m-d', strtotime($request->datenais_promoteur));
        $date_etabli_identite= date('Y-m-d', strtotime($request->date_identification));
       $promoteur= Promotrice::create([
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
            'code_promoteur'=>$code_promoteur,
            'region_residence' => $request->region_residence,
            'province_residence' => $request->province_residence,
            'commune_residence' => $request->commune_residence,
            'situation_residence' => $request->situation_residence,
            'arrondissement_residence' => $request->arrondissement_residence,
            'niveau_instruction' => $request->niveau_instruction,
            'autre_niveau_dinstruction' => $request->autre_niveau_instruction,
            'autre_occupation_pro'=> $request->autre_occupation,
            'domaine_formation'=> $request->domaine_formation,
            'nombre_annee_experience'=> $request->nombre_annee_experience,
            'precision_residence' => $request->precision_residence,
            'formation_en_rapport_avec_activite' => $request->formation_activite,
            'occupation_professionnelle_actuelle' => $request->occupation_pro_actuelle,
            'membre_ass' => $request->membre_ass,
            'compte_perso_existe' => $request->compte_perso_existe,
            'structure_financiere_personne'=> $request->structure_financiere_personne,
            'associations' => $request->associations,
            'suscription_etape'=>1
        ]);
        if ($request->hasFile('docidentite')) {
            $urldocidentite= $request->docidentite->store('public/docidentification');
            Piecejointe::create([
                'type_piece'=>env("VALEUR_ID_DOCUMENT_IDENTITE"),
                  'promotrice_id'=>$promoteur->id,
                  'url'=>$urldocidentite,
              ]);
        }

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
        return  view("validateStep1", compact("promoteur"))->with('success','Item created successfully!');
    }

    public function afficherform(){
        return view("public.search");
    }
    public function result(Request $request){
        $promoteur = Promotrice::where("code_promoteur", $request->code_promoteur)->first();
        if($promoteur==null){
            $result= 'code promoteur invalide';
        }
        else{
           // dd($promoteur);
           $entreprises= Entreprise::where('promotrice_id', $promoteur->id)->get();
            //dd($entreprises);
           $data=[];
            foreach( $entreprises as $value)
            {
                if($value->decision_du_comite_phase1==null){
                    $resultat= "resultat non disponible";
                }
                else{
                    $resultat =$value->decision_du_comite_phase1;
                }
               $data[] = array('denomination'=>$value->denomination, 'resultat'=>$resultat);
            }
            return json_encode($data);

        }
        $data=[];
        $data= array('result'=>$result);
        return json_encode($data);
    }
    public function entrepriseRetenuParPromoteur(Request $request){
        $promoteur = Promotrice::where("code_promoteur", $request->code_promoteur)->first();
        if($promoteur==null){
            $result= 'code promoteur invalide';
        }
        else{
          
           $entreprises= Entreprise::where('promotrice_id', $promoteur->id)->where('decision_du_comite_phase1', "selectionnee")->where('participer_a_la_formation',1)->get();
            //dd($entreprises);
           $data=[];
            foreach( $entreprises as $value)
            {
               $data[] = array('id_entreprise'=>$value->id,'denomination'=>$value->denomination);
            }
            return json_encode($data);

        }
        $data=[];
        $data= array('result'=>$result);
        return json_encode($data);
    } 
//function search utilisée pour la recherche des MPMES
    // public function search(Request $request){
      
    //     $promoteur = Promotrice::where("code_promoteur", $request->code_promoteur)->first();
    //     if($promoteur==null){
    //         return view("invalide");
    //     }
    //     else{
    //         if($promoteur->suscription_etape==2){
    //             $entreprise= Entreprise::where("promotrice_id",$promoteur->id )->first();
    //             $entreprise=$entreprise->id;
    //             return view("validateStep1", compact("promoteur","entreprise"));
    //            // return view("validateStep1aop", compact("promoteur","entreprise"));
              
    //         }
    //         elseif($promoteur->suscription_etape==1){
               
    //             //return view("validateStep1", compact("promoteur"));
    //             return view("validateStep1aop", compact("promoteur"));
    //         }
    //         else{
    //             //dd('oko');
    //             return view("validateStep1aop", compact("promoteur"));
    //            // return view("validateStep2",compact("promoteur"));
    //         }
    //     }
    // }
    public function search(Request $request){
      
        $promoteur = Promotrice::where("code_promoteur", $request->code_promoteur)->first();
        if($promoteur==null){
            return view("invalide");
        }
        else{
            if($promoteur->suscriptionaopleader_etape==2){
                $entreprise= Entreprise::where("promotrice_id",$promoteur->id )->first();
                $entreprise=$entreprise->id;
                return view("validateStep1", compact("promoteur","entreprise"));
               // return view("validateStep1aop", compact("promoteur","entreprise"));
              
            }
            elseif($promoteur->suscriptionaopleader_etape==1 || $promoteur->suscriptionaopleader_etape==null ){
               
              
                return view("validateStep1aop", compact("promoteur"));
            }
            else{
             
                return view("validateStep1aop", compact("promoteur"));
               
            }
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Promotrice  $promotrice
     * @return \Illuminate\Http\Response
     */
    public function show(Promotrice $promotrice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Promotrice  $promotrice
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $promoteur= Promotrice::where("slug", $slug)->first();
        $regions=Valeur::where('parametre_id',1 )->get();
        $niveau_instructions=Valeur::where("parametre_id", env('PARAMETRE_NIVEAU_D_INSTRUCTION'))->get();
        $occupation_professionnelle_actuelles =Valeur::where("parametre_id",env('PARAMETRE_OCCUPATION_PROFESSIONNELLE'))->get();
        return view("souscriptions.edit", compact("promoteur","regions","occupation_professionnelle_actuelles","niveau_instructions"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Promotrice  $promotrice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $promotrice= Promotrice::where("id",$id)->first();

        $promotrice->update(
            [
                'nom' => $request->nom_promoteur,
                'prenom' => $request->prenom_promoteur,
                'datenais' => $request->datenais_promoteur,
                'genre' => $request->genre,
                'telephone_promoteur' => $request->telephone_promoteur,
                'email_promoteur' => $request->email_promoteur,
                'type_identite' => $request->type_identite_promoteur,
                'numero_identite' => $request->numero_identite,
                'date_etabli_identite' => $request->date_identification,
                'date_expire_identite' => $request->date_identification,
                'autorite_delivrance' => $request->autorite_delivrance_identification,
                'mobile_promoteur' => $request->mobile_promoteur,
                'lieu_etablissement' => $request->lieu_etablissement_identification,
                'region_residence' => $request->region_residence,
                'province_residence' => $request->province_residence,
                'commune_residence' => $request->commune_residence,
                'situation_residence' => $request->situation_residence,
                'arrondissement_residence' => $request->arrondissement_residence,
                'niveau_instruction' => $request->niveau_instruction,
               // 'domaine_etude' => $request->domaine_etude,
                //'domaine_activite'=> $request->domaine_etude,
                'nombre_annee_experience'=> $request->nombre_annee_experience,
                'precision_residence' => $request->precision_residence,
                'formation_en_rapport_avec_activite' => $request->formation_activite,
                'occupation_professionnelle_actuelle' => $request->occupation_pro_actuelle,
                'membre_ass' => $request->membre_ass,
                'associations' => $request->associations,

        ]);
        return redirect()->route("souscription_a_valide_chefdezone");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Promotrice  $promotrice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Promotrice $promotrice)
    {
        //
    }
     public function afficher(){
        $regions=Valeur::where('parametre_id',1 )->get();
        $niveau_instructions=Valeur::where("parametre_id",5)->get();
        $occupation_professionnelle_actuelles =Valeur::where("parametre_id",6)->get();
         return view("public.subscription", compact('regions', 'niveau_instructions','occupation_professionnelle_actuelles'));
     }
}
