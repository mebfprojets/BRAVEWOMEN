<?php

namespace App\Http\Controllers;

use App\Models\Entreprise;
use App\Models\Entreprise_activite;
use App\Models\Entreprise_activite_invest;
use App\Models\Evaluation;
use App\Models\Infoeffectifentreprise;
use App\Models\Infoentreprise;
use App\Models\Piecejointe;
use App\Models\Promotrice;
use App\Models\Valeur;
use Illuminate\Http\Request;

class EntrepriseaopController extends Controller
{
    function createEntreprise($identreprise,$indicateur, $note ){
        Evaluation::create([
            "entreprise_id"=>$identreprise,
            "note"=>$note,
            "indicateur"=> $indicateur
        ]);
    }
    public function create(Request $request, $code)
    {
       
       $promoteur_code= $code;
        $cat_entreprise=$request->typeentreprise;
        $promoteur=Promotrice::where('code_promoteur',$code )->first();
        //dd($promoteur);
        if(!empty($request->entreprise)){
            $entreprise=Entreprise::where("id",$request->entreprise )->first();
        }
        $regions=Valeur::where('parametre_id',1 )->get();
        $forme_juridiques_aop=Valeur::where('parametre_id',8)->whereNotIn('id',[19,20,21,22])->get();
        //dd($forme_juridiques_aop);
       $forme_juridiques_leader=Valeur::where('parametre_id',8 )->whereNotIn('id', [23,7105,7103,7106,7107,6708])->get();
        $nature_clienteles=Valeur::where('parametre_id',10 )->get();
        $provenance_clients=Valeur::where('parametre_id',9 )->get();
        $maillon_activites=Valeur::where('parametre_id',7 )->get();
        $source_appros=Valeur::where('parametre_id',12 )->get();
        $sys_suivi_activites=Valeur::where('parametre_id',13 )->get();
        $annees=Valeur::where('parametre_id',16 )->get();
        $futur_annees=Valeur::where('parametre_id',17 )->get();
        if($cat_entreprise=='aop'){
            $rentabilite_criteres=Valeur::where('parametre_id',14 )->whereNotIn('id',[7085,41])->get();
        }
        else{
            $rentabilite_criteres=Valeur::where('parametre_id',14 )->whereNotIn('id',[7085,7099,41,	
            7098])->get();
        }
        $effectifs=Valeur::where('parametre_id',15 )->get();
        $pourcentages= Valeur::where('parametre_id', env('PARAMETRE_POURCENTAGE_ID') )->get();
        $secteur_activites= Valeur::where('parametre_id', env('PARAMETRE_SECTEUR_ACTIVITE_ID') )->get();
        $nb_annee_activites= Valeur::where('parametre_id', env('PARAMETRE_NB_ANNEE_EXISTENCE_ENT') )->get();
        $techno_utilisees= Valeur::where('parametre_id', env('PARAMETRE_TECHNO_UTILISE_ENTREPRISE_ID') )->get();
        $nouveaute_entreprises=Valeur::where('parametre_id',env("PARAMETRE_INOVATION_ENTREPRISE_ID") )->get();
        $ouinon_reponses=Valeur::where('parametre_id',env("PARAMETRE_REPONSES_OUINON_ID") )->get();
        $niveau_resiliences=Valeur::where('parametre_id',env("PARAMETRE_NIVEAUDE_RESILIENCE_ID") )->get();
        $activites_verticales=Valeur::where('parametre_id',env("PARAMETRE_ACTIVITES_VERTICALES_ID") )->get();
        $activites_horizotales=Valeur::where('parametre_id',env("PARAMETRE_ACTIVITE_HORIZONTALE_ID") )->get();
        $type_document_formalisations=Valeur::where('parametre_id',env("PARAMETRE_TYPE_DOCUMENT_FORMALISATION") )->get();
    if($promoteur->suscriptionaopleader_etape==1){
        if($cat_entreprise=='aop'){
            return view("public.createentrepriseAOP", compact("regions","cat_entreprise","activites_verticales","activites_horizotales","pourcentages","forme_juridiques_aop","nature_clienteles","provenance_clients","maillon_activites","source_appros","sys_suivi_activites","promoteur_code","annees","rentabilite_criteres","effectifs", "nb_annee_activites","secteur_activites","techno_utilisees","nouveaute_entreprises","ouinon_reponses","niveau_resiliences",'type_document_formalisations'));
        }else{
            return view("public.createentrepriseLeader", compact("regions","cat_entreprise","activites_verticales","activites_horizotales","pourcentages","forme_juridiques_leader","nature_clienteles","provenance_clients","maillon_activites","source_appros","sys_suivi_activites","promoteur_code","annees","rentabilite_criteres","effectifs", "nb_annee_activites","secteur_activites","techno_utilisees","nouveaute_entreprises","ouinon_reponses","niveau_resiliences",'type_document_formalisations'));
        }
    }elseif($promoteur->suscriptionaopleader_etape==2 && $entreprise!= null){
        return view("public.projet", compact("nature_clienteles","source_appros","promoteur_code","entreprise","futur_annees","effectifs"));
    }
  else{
    return view("validateStep1aop", compact("promoteur"))->with('success','Item created successfully!');
  }
    }
    public function store(Request $request)
    {        
        $cat_entreprise=$request->cat_entreprise;
        $promoteur=Promotrice::where("code_promoteur",$request->code_promoteur)->first();
        $annees=Valeur::where('parametre_id',16 )->get();
        if($cat_entreprise=='aop'){
            $rentabilite_criteres=Valeur::where('parametre_id',14 )->whereNotIn('id',[7085,41])->get();
        }
        else{
            $rentabilite_criteres=Valeur::where('parametre_id',14 )->whereNotIn('id',[7085,41,7099,	
            7098])->get();
        }
        // $rentabilite_criteres=Valeur::where('parametre_id',14 )->where('id','!=',7085)->get();
        $effectifs=Valeur::where('parametre_id',15 )->get();
        $nouveaute_entreprises=Valeur::where('parametre_id',env("PARAMETRE_INOVATION_ENTREPRISE_ID") )->get();
       $entreprises= Entreprise::where('promotrice_id',$promoteur->id)->get();
       $date_de_formalisation= date('Y-m-d', strtotime($request->date_de_formalisation));
       //dd($date_de_formalisation);
       if($entreprises->count()< 1){
        $entreprise = Entreprise::create([
            'denomination'=>$request->denomination,
            'region'=>$request->region,
            'province'=>$request->province,
            'commune'=>$request->commune,
            'arrondissement'=>$request->arrondissement,
            'telephone_entreprise'=>$request->telephone_entreprise,
            'email_entreprise'=>$request->email_entreprise,
            'secteur_activite'=>$request->secteur_activite,
            'nombre_annee_existence'=>$request->nombre_annee_existence,
            'maillon_activite'=>$request->maillon_activite,
            'formalise'=>$request->formalise,
            'date_de_formalisation'=>$date_de_formalisation,
            'num_rccm'=>$request->num_rccm,
            'forme_juridique'=>$request->forme_juridique,
            'num_rccm'=>$request->num_rccm,
            'agrement_exige'=>$request->agrement_exige,
            'banque_entreprise'=>$request->structure_financiere_entreprise,
            'compte_dispo'=>$request->compte_dispo,
            'beneficier_credit'=>$request->beneficier_credit,
            'source_appro'=>$request->source_appro,
            'techno_utilise'=>$request->techno_utilisee,
            'description_activite'=>$request->description_activite,
            'provenance_clientele'=>$request->provenance_clientele,
            'nature_client'=>$request->nature_client,
            'systeme_suivi'=>$request->systeme_suivi,
            'type_sys_suivi'=>$request->type_de_systeme_suivi,
            'code_promoteur'=>$request->code_promoteur,
            'promotrice_id'=>$promoteur->id,
            'affecte_par_covid'=>$request->affecte_par_covid,
            'description_effect_covid'=>$request->description_effect_covid,
            'affecte_par_securite'=>$request->affecte_par_securite,
            'description_effet_securite'=>$request->description_effet_securite,
            'niveau_resilience'=>$request->niveau_resilience,
            'mobililise_contrepartie'=>$request->mobililise_contrepartie,
            'femme_au_ca'=>$request->femme_au_ca,
            'capital_detenu_par_femme'=>$request->capital_detenu_par_femme,
            'entrepriseaop'=>1,
            "chaine_de_valeur"=>$request->chaine_de_valeur,
            "dans_une_chaine_de_valeur"=>$request->dans_une_chaine_de_valeur,
            'produit_vendus'=>$request->produit_vendus,
            'type_document_de_formalisation'=>$request->type_document_de_formalisation,
            'status'=>0,
            'aopOuleader'=>$request->cat_entreprise,
            'membre_ass'=>$request->membre_ass,
            'ass_de_entreprise_leader'=>$request->ass_de_entreprise_leader,
        ]);
        if ($request->hasFile('docidentite')) {
            $urldocidentite= $request->docidentite->store('public/docidentification');
            Piecejointe::create([
                'type_piece'=>env("VALEUR_ID_DOCUMENT_IDENTITE"),
                  'promotrice_id'=>$promoteur->id,
                  'url'=>$urldocidentite,
              ]);
        }
        $activites_verticales=$request['activites_verticales'];
        $activites_verticales_invests=$request['activites_verticales_invests'];
        $activites_horizotales=$request['activites_horizotales'];
        $activites_horizotales_invests=$request['activites_horizotales_invests'];
        if($activites_verticales){
        foreach($activites_verticales as $activites_verticale){
                Entreprise_activite::create([
                        'entreprise_id'=>$entreprise->id,
                        'activite'=>$activites_verticale,
                        'type'=>'verticale'
                ]);
        }
        }
        if($activites_horizotales){
            foreach($activites_horizotales as $activites_horizotale){
                Entreprise_activite::create([
                        'entreprise_id'=>$entreprise->id,
                        'activite'=>$activites_horizotale,
                        'type'=>'horizontale'
                ]);
            }
        }
        if($activites_verticales_invests){
            foreach($activites_verticales_invests as $activites_verticales_invests){
                Entreprise_activite_invest::create([
                        'entreprise_id'=>$entreprise->id,
                        'activite'=>$activites_verticale,
                        'type'=>'verticale'
                ]);
            }
        }
        if($activites_horizotales_invests){
            foreach($activites_horizotales_invests as $activites_horizotale){
                Entreprise_activite_invest::create([
                        'entreprise_id'=>$entreprise->id,
                        'activite'=>$activites_horizotale,
                        'type'=>'horizontale'
                ]);
            }
        }
        if ($request->hasFile('docagrement')) {
            $docagrement= $request->docagrement->store('public/docagrement');
            Piecejointe::create([
                'type_piece'=>env("VALEUR_ID_DOCUMENT_AGREMENT"),
                  'entreprise_id'=>$entreprise->id,
                  'url'=>$docagrement,
              ]);
        }
        else{
            $urldocrccm=null;
        }
        if ($request->hasFile('docrccm')) {
            $urldocrccm= $request->docrccm->store('public/docrccm');
            Piecejointe::create([
                'type_piece'=>env("VALEUR_ID_DOCUMENT_RCCM"),
                  'entreprise_id'=>$entreprise->id,
                  'url'=>$urldocrccm,
              ]);
        }
        else{
            $urldocrccm=null;
        }
        $promoteur->update([
            "suscriptionaopleader_etape"=>2,
        ]);
        // if($entreprises->count()<1){
        //     $promoteur->update([
        //         "suscriptionaopleader_etape"=>2,
        //     ]);
        // }
        // if($entreprises->count()==1){
        //     $promoteur->update([
        //         "etape_suscription2"=>2,
        //     ]);
        //}
        foreach($rentabilite_criteres as $rentabilite_critere){
            foreach($annees as $annee){
                $variable=$rentabilite_critere->id.$annee->id;
            if($rentabilite_critere->id==41){
                Infoentreprise::create([
                    "indicateur"=>$rentabilite_critere->id,
                    "annee"=>$annee->id,
                    "quantite"=>$request->$variable,
                    "entreprise_id"=>$entreprise->id,
                    "unite_de_mesure"=>$request->unite_de_mesure,
                    "code_promoteur"=>$request->code_promoteur
                ]);
            }
            else{
                Infoentreprise::create([
                    "indicateur"=>$rentabilite_critere->id,
                    "annee"=>$annee->id,
                    "quantite"=>$request->$variable,
                    "entreprise_id"=>$entreprise->id,
                    "code_promoteur"=>$request->code_promoteur
                ]);
            }
               
            }
        }
        foreach($nouveaute_entreprises as $nouveaute_entreprise){
            foreach($annees as $annee){
                $variable=$nouveaute_entreprise->id.$annee->id;
                Infoentreprise::create([
                    "indicateur"=>$nouveaute_entreprise->id,
                    "annee"=>$annee->id,
                    "quantite"=>$request->$variable,
                    "entreprise_id"=>$entreprise->id,
                    "code_promoteur"=>$request->code_promoteur,
                ]);
            }
        }
        foreach($effectifs as $effectif){
            foreach($annees as $annee){
                $homme=$effectif->id.$annee->id."homme";
                $femme=$effectif->id.$annee->id."femme";
                Infoeffectifentreprise::create([
                    "effectif"=>$effectif->id,
                    "annee"=>$annee->id,
                    "homme"=>$request->$homme,
                    "femme"=>$request->$femme,
                    "entreprise_id"=>$entreprise->id,
                    "code_promoteur"=>$request->code_promoteur
                ]);
            }
        }

//Notation activités verticales et horizontales
$nombre_activite_dev= Entreprise_activite::where('entreprise_id',$entreprise->id)->count();
if($nombre_activite_dev>=3){
    $nombre_activite_dev=10;
}else{
    $nombre_activite_dev=5;
}
//Notation nombre de MPME partenaires
$mpme_partenaire_2021= Infoentreprise::where("entreprise_id",$entreprise->id)->where("indicateur",7100)->where("annee",48)->first()->quantite;
if ($mpme_partenaire_2021>=5){
    $note_mpme_partenaire_2021 = 10 ;
}
elseif($mpme_partenaire_2021<5 && $mpme_partenaire_2021>=3){
    $note_mpme_partenaire_2021 = 7;
}
elseif($mpme_partenaire_2021<3 && $mpme_partenaire_2021>=1){
    $note_mpme_partenaire_2021 = 5;
}
else{
    $note_mpme_partenaire_2021 = 0;
}
// notation de l'expérience dans l'activite
$nombre_annee_experience= $entreprise-> nombre_annee_existence ;
if ($nombre_annee_experience>10){
    $note_nombre_annee_experience = 10 ;
}
elseif($nombre_annee_experience<=10 && $nombre_annee_experience>=5){
    $note_nombre_annee_experience = 7;
}
elseif($nombre_annee_experience<5 && $nombre_annee_experience>=1){
    $note_nombre_annee_experience = 5;
}
else{
    $note_nombre_annee_experience = 0;
}
$secteur_activite= $entreprise->secteur_activite;
if($secteur_activite==6690 || $secteur_activite==6691 || $secteur_activite==6692 || $secteur_activite==6693  || $secteur_activite==6695){
    $note_secteur_activite=10;
}
else{
    $note_secteur_activite=5;
}
// Notation entreprise formalisée
$entreprise_formalise= $entreprise->formalise;
if($entreprise_formalise==1){
    $note_entreprise_formalise=10;
}
else{
    $note_entreprise_formalise=0;
}
//Notation utilisation d'outil de suivi
$outil_de_suivi= $entreprise->systeme_suivi;
if($outil_de_suivi==1){
    $note_outil_de_suivi=5;
}
else{
    $note_outil_de_suivi=3;
}
$affecte_par_covid= $entreprise->affecte_par_covid;
if($affecte_par_covid==6716 || $affecte_par_covid==6717){
    $note_affecte_par_covid=10;
}
else{
    $note_affecte_par_covid=5;
}
//Notation impacter par la securite
$affecte_par_securite= $entreprise->affecte_par_securite;
if($affecte_par_securite==6716 || $affecte_par_securite==6717){
    $note_affecte_par_securite=10;
}
else{
    $note_affecte_par_securite=5;
}
$mobililise_contrepartie= $entreprise->mobililise_contrepartie;
if($mobililise_contrepartie=='Oui'){
    $note_mobililise_contrepartie=10;
}
else{
    $note_mobililise_contrepartie=0;
}
// note effectif
$effectif_2021= Infoeffectifentreprise::where("entreprise_id",$entreprise->id)->where("effectif",44)->where("annee",48)->first();
$effectif_2021=$effectif_2021->homme+$effectif_2021->femme;
if($effectif_2021>=20){
    $note_effectif=10;
}
elseif($effectif_2021<20 && $effectif_2021>=10){
    $note_effectif=7;
}
elseif($effectif_2021<10 && $effectif_2021>=1){
    $note_effectif=5;
}else{
    $note_effectif=0;
}
$this->createEntreprise($entreprise->id,"Nombre d'année d'expérience dans l'activite", $note_nombre_annee_experience);
$this->createEntreprise($entreprise->id,"Secteur d'activité", $note_secteur_activite);
$this->createEntreprise($entreprise->id,"Formalisation de l'entreprise",  $note_entreprise_formalise);
$this->createEntreprise($entreprise->id,"Outil de suivi de l'activité",  $note_outil_de_suivi);
$this->createEntreprise($entreprise->id,"Impact de la COVID 19",  $note_affecte_par_covid);
$this->createEntreprise($entreprise->id,"Impact de la crise securitaire",  $note_affecte_par_securite);
$this->createEntreprise($entreprise->id,"Capacite de mobilisation",  $note_mobililise_contrepartie);
$this->createEntreprise($entreprise->id,"Création d'emploi", $note_effectif);
$this->createEntreprise($entreprise->id,"Nombre de MPME de femmes partenaires", $note_mpme_partenaire_2021);
$note_totale=  $note_nombre_annee_experience +
$note_secteur_activite + $note_mpme_partenaire_2021+ $note_entreprise_formalise + $note_outil_de_suivi + $note_affecte_par_covid + $note_affecte_par_securite + $note_mobililise_contrepartie + $note_effectif;
$entreprise->update([
    "noteTotale"=>$note_totale,
]);
$entreprise=$entreprise->id;
//Fin de la notation des souscriptions 
return view("validateStep1aop", compact("promoteur","entreprise"));
       }
else{
    return view("validateStep2" );
       }
    }
}
