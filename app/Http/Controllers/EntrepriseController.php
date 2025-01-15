<?php
namespace App\Http\Controllers;
use App\Mail\NotifyMail;
use App\Mail\recepisseMail;
use App\Mail\resumeMail;
use App\Mail\synthese;
use App\Models\Decision;
use App\Models\Entreprise;
use App\Models\Entreprise_activite;
use App\Models\Entreprise_activite_invest;
use App\Models\Evaluation;
use App\Models\Infoeffectifentreprise;
use App\Models\Infoentreprise;
use App\Models\Investissement;
use App\Models\Piecejointe;
use App\Models\Projet;
use App\Models\Projetinfo;
use App\Models\Promotrice;
use App\Models\Proportion_de_depense_promotrice;
use App\Models\User;
use App\Models\Valeur;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Spatie\SimpleExcel\SimpleExcelReader;
//use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;

class EntrepriseController extends Controller
{ 
    public function __construct()
    {
        $this->middleware('auth')->only(["show","detaildocument","return_view"]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
 function createEntreprise($identreprise,$indicateur, $note ){
    Evaluation::create([
        "entreprise_id"=>$identreprise,
        "note"=>$note,
        "indicateur"=> $indicateur
    ]);
}
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function creation(Request $request)
    {
        
        $promoteur_code= $request->promoteur_code;
        $promoteur=Promotrice::where('code_promoteur',$promoteur_code )->first();
       // dd($promoteur->suscription_etape);
        if(!empty($request->entreprise)){
            $entreprise=Entreprise::where("id",$request->entreprise )->first();
        }
        $regions=Valeur::where('parametre_id',1 )->whereNotIn('id', [62,64,63,59,58,53])->get();
        $forme_juridiques=Valeur::where('parametre_id',8 )->get();
        $nature_clienteles=Valeur::where('parametre_id',10 )->get();
        $provenance_clients=Valeur::where('parametre_id',9 )->get();
        $maillon_activites=Valeur::where('parametre_id',7 )->get();
        $source_appros=Valeur::where('parametre_id',12 )->get();
        $sys_suivi_activites=Valeur::where('parametre_id',13 )->get();
        $annees=Valeur::where('parametre_id',16 )->where('id','!=', 46)->get();
        $futur_annees=Valeur::where('parametre_id',17 )->get();
        $rentabilite_criteres=Valeur::where('parametre_id',14)->where('id','!=',env("VALEUR_ID_NOMBRE_CLIENT"))->whereNotIn('id',[7098,7099,7100,7101,7102,7116])->get();
        $effectifs=Valeur::where('parametre_id',15 )->get();
        $secteur_activites= Valeur::where('parametre_id', env('PARAMETRE_SECTEUR_ACTIVITE_ID') )->get();
        $nb_annee_activites= Valeur::where('parametre_id', env('PARAMETRE_NB_ANNEE_EXISTENCE_ENT') )->get();
        $techno_utilisees= Valeur::where('parametre_id', env('PARAMETRE_TECHNO_UTILISE_ENTREPRISE_ID') )->get();
        $nouveaute_entreprises=Valeur::where('parametre_id',env("PARAMETRE_INOVATION_ENTREPRISE_ID") )->get();
        $ouinon_reponses=Valeur::where('parametre_id',env("PARAMETRE_REPONSES_OUINON_ID") )->get();
        $niveau_resiliences=Valeur::where('parametre_id',env("PARAMETRE_NIVEAUDE_RESILIENCE_ID") )->get();
    if($promoteur->suscription_etape==1 || $promoteur->suscription_etape==null){
        return view("public.enrentreprise", compact("regions","forme_juridiques","nature_clienteles","provenance_clients","maillon_activites","source_appros","sys_suivi_activites","promoteur_code","annees","rentabilite_criteres","effectifs", "nb_annee_activites","secteur_activites","techno_utilisees","nouveaute_entreprises","ouinon_reponses","niveau_resiliences"));
    }elseif($promoteur->suscription_etape==2 && $entreprise!= null){
        return view("public.projet", compact("nature_clienteles","source_appros","promoteur_code","entreprise","futur_annees","effectifs"));
    }
  else{
    return view("validateStep1", compact("promoteur"))->with('success','Item created successfully!');
  }
}
    public function create(Request $request)
    {
        $entreprise_nn_traite= Entreprise::where('code_promoteur', $request->promoteur_code)->where("conforme",null)->get();
       // dd($entreprise_nn_traite);
      if(count($entreprise_nn_traite) < 2){
                $promoteur_code= $request->promoteur_code;
                $promoteur=Promotrice::where('code_promoteur',$promoteur_code )->first();
                if(!empty($request->entreprise)){
                    $entreprise=Entreprise::where("id",$request->entreprise )->first();
                }
                $regions=Valeur::where('parametre_id',1 )->whereNotIn('id', [62,64,63,59,58,53])->get();
               
                $forme_juridiques=Valeur::where('parametre_id',8 )->get();
                $nature_clienteles=Valeur::where('parametre_id',10 )->get();
                $provenance_clients=Valeur::where('parametre_id',9 )->get();
                $maillon_activites=Valeur::where('parametre_id',7 )->get();
                $source_appros=Valeur::where('parametre_id',12 )->get();
                $sys_suivi_activites=Valeur::where('parametre_id',13 )->get();
                $annees=Valeur::where('parametre_id',16 )->where('id','!=', 46)->get();
                $futur_annees=Valeur::where('parametre_id',17 )->get();
                $rentabilite_criteres=Valeur::where('parametre_id',14 )->where('id','!=',env("VALEUR_ID_NOMBRE_CLIENT"))->get();
                $effectifs=Valeur::where('parametre_id',15 )->get();
                $secteur_activites= Valeur::where('parametre_id', env('PARAMETRE_SECTEUR_ACTIVITE_ID') )->get();
                $nb_annee_activites= Valeur::where('parametre_id', env('PARAMETRE_NB_ANNEE_EXISTENCE_ENT') )->get();
                $techno_utilisees= Valeur::where('parametre_id', env('PARAMETRE_TECHNO_UTILISE_ENTREPRISE_ID') )->get();
                $nouveaute_entreprises=Valeur::where('parametre_id',env("PARAMETRE_INOVATION_ENTREPRISE_ID") )->get();
                $ouinon_reponses=Valeur::where('parametre_id',env("PARAMETRE_REPONSES_OUINON_ID") )->get();
                $niveau_resiliences=Valeur::where('parametre_id',env("PARAMETRE_NIVEAUDE_RESILIENCE_ID") )->get();
            if($promoteur->suscription_etape==1){
                return view("public.enrentreprise", compact("regions","forme_juridiques","nature_clienteles","provenance_clients","maillon_activites","source_appros","sys_suivi_activites","promoteur_code","annees","rentabilite_criteres","effectifs", "nb_annee_activites","secteur_activites","techno_utilisees","nouveaute_entreprises","ouinon_reponses","niveau_resiliences"));
            }elseif($promoteur->suscription_etape==2 && $entreprise!= null){
                return view("public.projet", compact("nature_clienteles","source_appros","promoteur_code","entreprise","futur_annees","effectifs"));
            }
            else{
                return view("validateStep1", compact("promoteur"))->with('success','Item created successfully!');
            }
        
        }
    else{
        return redirect()->back();
    }
       

}
    public function create2(Promotrice $promoteur, Request $request)
    {
    $entreprise_nn_traite= Entreprise::where('code_promoteur', $request->promoteur_code)->where("conforme",null)->get();
    
        if(count($entreprise_nn_traite )<2 ){
        $entreprise= Entreprise::where("promotrice_id", $promoteur->id)->orderBy('created_at','desc')->first();
        $promoteur_code=$promoteur->code_promoteur;
        $regions=Valeur::where('parametre_id',1 )->whereNotIn('id', [64,63,59])->get();
        
        $forme_juridiques=Valeur::where('parametre_id',8 )->get();
        $nature_clienteles=Valeur::where('parametre_id',10 )->get();
        $provenance_clients=Valeur::where('parametre_id',9 )->get();
        $maillon_activites=Valeur::where('parametre_id',7 )->get();
        $source_appros=Valeur::where('parametre_id',12 )->get();
        $sys_suivi_activites=Valeur::where('parametre_id',13 )->get();
        $annees=Valeur::where('parametre_id',16 )->where('id','!=', 46)->get();
        $futur_annees=Valeur::where('parametre_id',17 )->get();
        $rentabilite_criteres=Valeur::where('parametre_id',14 )->get();
        $effectifs=Valeur::where('parametre_id',15 )->get();
        $secteur_activites= Valeur::where('parametre_id', env('PARAMETRE_SECTEUR_ACTIVITE_ID') )->get();
        // $secteur_activites= Valeur::where('parametre_id', env('PARAMETRE_SECTEUR_ACTIVITE_ID') )->get();
        $nb_annee_activites= Valeur::where('parametre_id', env('PARAMETRE_NB_ANNEE_EXISTENCE_ENT') )->get();
        $techno_utilisees= Valeur::where('parametre_id', env('PARAMETRE_TECHNO_UTILISE_ENTREPRISE_ID') )->get();
        $nouveaute_entreprises=Valeur::where('parametre_id',env("PARAMETRE_INOVATION_ENTREPRISE_ID") )->get();
        $ouinon_reponses=Valeur::where('parametre_id',env("PARAMETRE_REPONSES_OUINON_ID") )->get();
        $niveau_resiliences=Valeur::where('parametre_id',env("PARAMETRE_NIVEAUDE_RESILIENCE_ID") )->get();
    if($promoteur->suscription_etape==3){
        return view("public.enrentreprise", compact("regions","forme_juridiques","nature_clienteles","provenance_clients","maillon_activites","source_appros","sys_suivi_activites","promoteur_code","annees","rentabilite_criteres","effectifs","secteur_activites","techno_utilisees","nouveaute_entreprises","ouinon_reponses","niveau_resiliences","nb_annee_activites"));
    }elseif($promoteur->etape_suscription2== 2 && $entreprise!= null){
        return view("public.projet", compact("nature_clienteles","source_appros","promoteur_code","entreprise","futur_annees","effectifs"));
    }
    else{
    return view("validateStep1", compact("promoteur"))->with('success','Item created successfully!');
    }
}
else{
    return redirect()->back(); 
}

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
        $year=date("Y");
        $promoteur=Promotrice::where("code_promoteur",$request->code_promoteur)->first();
        $annees=Valeur::where('parametre_id',16 )->where('id','!=', 46)->get();
        $rentabilite_criteres=Valeur::where('parametre_id',14)->where('id','!=',env("VALEUR_ID_NOMBRE_CLIENT"))->whereNotIn('id',[7098,7099,7100,7101,7102,7116])->get();
        $effectifs=Valeur::where('parametre_id',15 )->get();
        $nouveaute_entreprises=Valeur::where('parametre_id',env("PARAMETRE_INOVATION_ENTREPRISE_ID") )->get();
       $entreprises= Entreprise::where('promotrice_id',$promoteur->id)->get();
       $entreprise_traite= Entreprise::where('code_promoteur', $promoteur->code_promoteur)->where("conforme","!=",null)->get();
       $entreprise_nn_traite= Entreprise::where('code_promoteur', $promoteur->code_promoteur)->where("aopOuleader","mpme")->where("conforme",null)->get();
       $date_de_formalisation= date('Y-m-d', strtotime($request->date_de_formalisation));
       //Pour eviter les doubles enregistrements
       $entreprise_controle_doublon= Entreprise::where("code_promoteur",$promoteur->code_promoteur)->where("denomination",$request->denomination)->where("conforme",null)->get();
       $nombre_de_souscription_de_la_phase=Entreprise::where('phase_de_souscription',4)->where('aopOuleader','mpme')->count();
       if( count($entreprise_controle_doublon)==0 && count($entreprise_nn_traite)< 2){
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
            'status'=>0,
            'banque_choisi'=>0,
            "aopOuleader"=>"mpme",
            'phase_de_souscription'=>3,
            'phase_projet'=>2,
            "num_ss_compte"=>"non défini"
        ]);
        if($request->hasFile('docagrement')) {
            $docagrement= $request->docagrement->store('public/'.$year.'/'.'docagrement');
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
            $file = $request->file('docrccm');
            $extension=$file->getClientOriginalExtension();
            $fileName = $entreprise->code_promoteur.'.'.$extension;
            $emplacement='public/'.$year.'/'.'docrccm'; 
            $urldocrccm= $request['docrccm']->storeAs($emplacement, $fileName);
            Piecejointe::create([
                'type_piece'=>env("VALEUR_ID_DOCUMENT_RCCM"),
                  'entreprise_id'=>$entreprise->id,
                  'url'=>$urldocrccm,
              ]);
        }
        else{
            $urldocrccm=null;
        }
        // if($entreprises->count()<1){
            $promoteur->update([
                "suscription_etape"=>2,
            ]);
       
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
    
$formation_en_rapport_avec_activite= $entreprise->promotrice->formation_en_rapport_avec_activite;
switch ($formation_en_rapport_avec_activite) {
  case "1":
    $note_formation_en_rapport_avec_activite = env("NOTE_FORMATION_TECHNIQUE");
    break;
  case "2":
    $note_formation_en_rapport_avec_activite = env("NOTE_FORMATION_SUR_LE_TAS");
    break;
  case "3":
    $note_formation_en_rapport_avec_activite = env("NOTE_FORMATION_AUCUN");
    break;
  default:
  $note_formation_en_rapport_avec_activite = 0;
}
// notation de l'expérience dans l'activite
$nombre_annee_experience= $entreprise->promotrice->nombre_annee_experience;
if ($nombre_annee_experience>10){
    $note_nombre_annee_experience = env("NOTE_EXPERIENCE_PLUS_DE_10ANS");
}
elseif($nombre_annee_experience<=10 && $nombre_annee_experience>6){
    $note_nombre_annee_experience = env("NOTE_EXPERIENCE_DE_6_A_10ANS");
}
elseif($nombre_annee_experience<=6 && $nombre_annee_experience>1){
    $note_nombre_annee_experience = env("NOTE_EXPERIENCE_DE_1_A_5ANS");
}
else{
    $note_nombre_annee_experience = env("NOTE_EXPERIENCE_MOINS_DE_1AN");
}
$secteur_activite= $entreprise->secteur_activite;
if($secteur_activite==6690 || $secteur_activite==6691 || $secteur_activite==6692 || $secteur_activite==6693){
    $note_secteur_activite=env("NOTE_SECTEUR_ACTIVITE_PRIORITAIRE");
}
else{
    $note_secteur_activite=env("NOTE_SECTEUR_ACTIVITE_AUTRE");
}
// Notation entreprise formalisée
$entreprise_formalise= $entreprise->formalise;
if($entreprise_formalise==1){
    $note_entreprise_formalise=env("NOTE_ENTREPRISE_FORMALISEE");
}
else{
    $note_entreprise_formalise=env("NOTE_ENTREPRISE_NON_FORMALISEE");
}
//Notation utilisation d'outil de suivi
$outil_de_suivi= $entreprise->systeme_suivi;
if($outil_de_suivi==1){
    $note_outil_de_suivi=env("NOTE_OUTIL_DE_SUIVI_ACTIVITE_OUI");
}
else{
    $note_outil_de_suivi=env("NOTE_OUTIL_DE_SUIVI_ACTIVITE_NON");
}
$affecte_par_covid= $entreprise->affecte_par_covid;
if($affecte_par_covid==6716 || $affecte_par_covid==6717){
    $note_affecte_par_covid=env("NOTE_IMPACT_COVID_OUI");
}
else{
    $note_affecte_par_covid=env("NOTE_IMPACT_COVID_NON");
}
//Notation impacter par la securite
$affecte_par_securite= $entreprise->affecte_par_securite;
if($affecte_par_securite==6716 || $affecte_par_securite==6717){
    $note_affecte_par_securite=env("NOTE_IMPACT_SECURITE_OUI");
}
else{
    $note_affecte_par_securite=env("NOTE_IMPACT_SECURITE_NON");
}
$mobililise_contrepartie= $entreprise->mobililise_contrepartie;
if($mobililise_contrepartie=='Oui'){
    $note_mobililise_contrepartie=env("NOTE_CAPACITE_DE_MOBILISATION_OUI");
}
else{
    $note_mobililise_contrepartie=env("NOTE_CAPACITE_DE_MOBILISATION_OUI");
}
$chiffre_daffaire= Infoentreprise::where("entreprise_id",$entreprise->id)->where("indicateur",42)->where("annee",48)->first();
$chiffre_daffaire2021=$chiffre_daffaire->quantite;
//effectif permanent crée en 2021
$effectif_2021= Infoeffectifentreprise::where("entreprise_id",$entreprise->id)->where("effectif",44)->where("annee",48)->first();
$effectif_2021=$effectif_2021->homme+$effectif_2021->femme;
if($chiffre_daffaire2021>10000000){
    $note_chiffre_daffaire=env("NOTE_CHIFFREDAFFAIRE_PLUS_DE_10MILLION");
}
elseif($chiffre_daffaire2021<10000000 && $chiffre_daffaire2021>6000000){
    $note_chiffre_daffaire=env("NOTE_CHIFFREDAFFAIRE_6_A_10");
}
elseif($chiffre_daffaire2021<6000000 && $chiffre_daffaire2021>1000000){
    $note_chiffre_daffaire=env("NOTE_CHIFFREDAFFAIRE_1_A_5");
}else{
    $note_chiffre_daffaire=env("NOTE_CHIFFREDAFFAIRE_MOINS_1");
}
// note effectif
if($effectif_2021>10){
    $note_effectif=env("NOTE_NBRE_CREATION_EMPLOI_PLUS_10");
}
elseif($effectif_2021<10 && $effectif_2021>6){
    $note_effectif=env("NOTE_NBRE_CREATION_EMPLOI_6_A_10");
}
elseif($effectif_2021<6 && $effectif_2021>1){
    $note_effectif=env("NOTE_NBRE_CREATION_EMPLOI_1_A_5");
}else{
    $note_effectif=env("NOTE_NBRE_CREATION_EMPLOI_0");
}

$this->createEntreprise($entreprise->id,"Formation en rapport avec l'activite", $note_formation_en_rapport_avec_activite);
$this->createEntreprise($entreprise->id,"Nombre d'année d'expérience dans l'activite", $note_nombre_annee_experience);
$this->createEntreprise($entreprise->id,"Secteur d'activité", $note_secteur_activite);
$this->createEntreprise($entreprise->id,"Formalisation de l'entreprise",  $note_entreprise_formalise);
$this->createEntreprise($entreprise->id,"Outil de suivi de l'activité",  $note_outil_de_suivi);
$this->createEntreprise($entreprise->id,"Impact de la COVID 19",  $note_affecte_par_covid);
$this->createEntreprise($entreprise->id,"Impact de la crise securitaire",  $note_affecte_par_securite);
$this->createEntreprise($entreprise->id,"Capacite de mobilisation",  $note_mobililise_contrepartie);
$this->createEntreprise($entreprise->id,"Chiffre d'affaire", $note_chiffre_daffaire);
$this->createEntreprise($entreprise->id,"Création d'emploi", $note_effectif);
$note_totale= $note_formation_en_rapport_avec_activite + $note_nombre_annee_experience+
$note_secteur_activite+ $note_entreprise_formalise + $note_outil_de_suivi+$note_affecte_par_covid+$note_affecte_par_securite+$note_mobililise_contrepartie+$note_chiffre_daffaire+$note_effectif;
 $entreprise->update([
     "noteTotale"=>$note_totale,

 ]);
$entreprise=$entreprise->id;
$entreprise_nn_traite= Entreprise::where('code_promoteur', $promoteur->code_promoteur)->where("aopOuleader","mpme")->where("conforme",null)->get();
        //nombre de nouvelle entreprise enregistré pas le promoteur
        $nbre_ent_nn_traite = count($entreprise_nn_traite);

return view("validateStep1", compact("promoteur","entreprise","nbre_ent_nn_traite"));
    }
else{
    return view("validateStep2", compact("promoteur") );
       }
}


    public function genereRecpisse(Request $request)
    {
        //return route()->back(); 
        $promoteur= Promotrice::where("slug", $request->promoteur)->first();
        $entreprise= Entreprise::where("code_promoteur", $promoteur->code_promoteur)->orderBy('created_at','desc')->first();
        $chef_de_zone= User::where("zone",$entreprise->region)->first();
        if($chef_de_zone){
            $contact_chef_de_zone= $chef_de_zone->telephone ;
        }
        else{
            $contact_chef_de_zone= env("NUMERO_SUPPORT");
        }
        $effectif_permanent_entreprises= Infoeffectifentreprise::where("entreprise_id",$entreprise->id)->where("effectif",env("VALEUR_EFFECTIF_PERMANENENT"))->get();
        $effectif_temporaire_entreprises= Infoeffectifentreprise::where("entreprise_id",$entreprise->id)->where("effectif",env("VALEUR_EFFECTIF_TEMPORAIRE"))->get();
        $chiffre_daffaire= Infoentreprise::where("entreprise_id",$entreprise->id)->where("indicateur",env("VALEUR_CHIFFRE_D_AFFAIRE"))->get();
        $produit_vendus= Infoentreprise::where("entreprise_id",$entreprise->id)->where("indicateur",env("VALEUR_PRODUIT_VENDU"))->get();
        $benefice_nets= Infoentreprise::where("entreprise_id",$entreprise->id)->where("indicateur",env("VALEUR_PRODUIT_VENDU"))->get();
        $data["email"] = $promoteur->email_promoteur;
        $this->email= $promoteur->email_promoteur;
        //générer le qrCode 
       // $qrcode = base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate('string'));
         $qrcode =  base64_encode(QrCode::format('svg')->size(100)->errorCorrection('H')->generate("Ceci est un recepissé généré par la plateforme BRAVE WOMEN Burkina"."Code didentification:"." ".$promoteur->code_promoteur."_".$promoteur->id."BWBF"));
        $pdf = PDF::loadView('pdf.recepisse', compact('promoteur','entreprise','contact_chef_de_zone','qrcode'));
        return  $pdf->download('récépissé BRAVE WOMEN.pdf');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Entreprise  $entreprise
     * @return \Illuminate\Http\Response
     */
    public function show(Entreprise $entreprise)
    {
        $piecejointes=Piecejointe::where("entreprise_id",$entreprise->id)->orWhere("promotrice_id", $entreprise->promotrice->id )->orderBy('updated_at', 'desc')->get();
        $effectif_permanent_entreprises= Infoeffectifentreprise::where("entreprise_id",$entreprise->id)->where("effectif",env("VALEUR_EFFECTIF_PERMANENENT"))->get();
        $effectif_temporaire_entreprises= Infoeffectifentreprise::where("entreprise_id",$entreprise->id)->where("effectif",env("VALEUR_EFFECTIF_TEMPORAIRE"))->get();
        $chiffre_daffaire= Infoentreprise::where("entreprise_id",$entreprise->id)->where("indicateur",env("VALEUR_CHIFFRE_D_AFFAIRE"))->get();
        $produit_vendus= Infoentreprise::where("entreprise_id",$entreprise->id)->where("indicateur",env("VALEUR_PRODUIT_VENDU"))->get();
        $benefice_nets= Infoentreprise::where("entreprise_id",$entreprise->id)->where("indicateur",env("VALEUR_BENEFICE_NET"))->get();
        $salaire_annuelles= Infoentreprise::where("entreprise_id",$entreprise->id)->where('indicateur', env("VALEUR_SALAIRE_MOYEN_ANNUEL") )->get();
        $nombre_nouveau_marche=Infoentreprise::where("entreprise_id",$entreprise->id)->where('indicateur', env("VALEUR_NOMBRE_NOUVEAU_MARCHE") )->get();
        $nombre_nouveau_produit=Infoentreprise::where("entreprise_id",$entreprise->id)->where('indicateur', 6715)->get();
        $nombre_total_client=Infoentreprise::where("entreprise_id",$entreprise->id)->where('indicateur', env("VALEUR_NOMBRE_CLIENT") )->get();
        $nombre_innovation=Infoentreprise::where("entreprise_id",$entreprise->id)->where('indicateur', 6713 )->get();
        $proportion_de_depense_education= Proportion_de_depense_promotrice::where("promotrice_id",$entreprise->promotrice->id)->where('proportion_id',env("VALEUR_PROPORTION_EDUCATION"))->get();
        $proportion_de_depense_sante= Proportion_de_depense_promotrice::where("promotrice_id",$entreprise->promotrice->id)->where('proportion_id',env("VALEUR_PROPORTION_SANTE"))->get();
        $proportion_de_depense_bien_materiel= Proportion_de_depense_promotrice::where("promotrice_id",$entreprise->promotrice->id)->where('proportion_id',env("VALEUR_PROPORTION_BIEN"))->get();
        $decision_dossier_user=Decision::where(['entreprise_id'=>$entreprise->id, 'user_id'=>Auth::user()->id])->get();
        $aStatuer=count($decision_dossier_user)>=1?true:false;
        if($entreprise->entrepriseaop){
           $activite_verticale_devs= Entreprise_activite::where('entreprise_id',$entreprise->id)->where('type','verticale')->get();
           $activite_verticale_invests= Entreprise_activite_invest::where('entreprise_id',$entreprise->id)->where('type','verticale')->get();
           $activite_horizontale_devs=Entreprise_activite::where('entreprise_id',$entreprise->id)->where('type','horizontale')->get();
           $activite_horizontale_invests=  Entreprise_activite_invest::where('entreprise_id',$entreprise->id)->where('type','horizontale')->get();
           $nombre_de_pme_partenaires= Infoentreprise::where("entreprise_id",$entreprise->id)->where('indicateur', 7100)->get();
           $montant_des_achats_aupres_des_mpme_des_femmes= Infoentreprise::where("entreprise_id",$entreprise->id)->where('indicateur', 7102)->get();
	       $nombre_de_pme_partenaires_de_la_zones= Infoentreprise::where("entreprise_id",$entreprise->id)->where('indicateur', 7116)->get();
	       $montant_obtenu_aupres_des_institutions_financiaires=Infoentreprise::where("entreprise_id",$entreprise->id)->where('indicateur', 7102)->get();
           if($entreprise->aopOuleader=='aop' || $entreprise->aopOuleader=='leader'){
            $nombre_membres= Infoentreprise::where("entreprise_id",$entreprise->id)->where('indicateur', 7098)->get();
            $pourcentage_femmes= Infoentreprise::where("entreprise_id",$entreprise->id)->where('indicateur', 7099)->get();
                return view("entreprise.detailaopleader",compact("nombre_de_pme_partenaires_de_la_zones","montant_obtenu_aupres_des_institutions_financiaires","montant_des_achats_aupres_des_mpme_des_femmes","nombre_de_pme_partenaires","nombre_membres","pourcentage_femmes","aStatuer","entreprise","nombre_total_client",'proportion_de_depense_education','proportion_de_depense_sante','proportion_de_depense_bien_materiel','nombre_innovation','nombre_nouveau_marche','nombre_nouveau_produit',"piecejointes","chiffre_daffaire","produit_vendus", "benefice_nets","salaire_annuelles","effectif_permanent_entreprises","effectif_temporaire_entreprises","activite_verticale_devs","activite_horizontale_devs","activite_verticale_invests","activite_horizontale_invests"));
           }
           else{
                return view("entreprise.detailaopleader",compact("nombre_de_pme_partenaires_de_la_zones","montant_obtenu_aupres_des_institutions_financiaires","montant_des_achats_aupres_des_mpme_des_femmes","nombre_de_pme_partenaires","aStatuer","entreprise","nombre_total_client",'proportion_de_depense_education','proportion_de_depense_sante','proportion_de_depense_bien_materiel','nombre_innovation','nombre_nouveau_marche','nombre_nouveau_produit',"piecejointes","chiffre_daffaire","produit_vendus", "benefice_nets","salaire_annuelles","effectif_permanent_entreprises","effectif_temporaire_entreprises","activite_verticale_devs","activite_horizontale_devs","activite_verticale_invests","activite_horizontale_invests"));
           }
        }
        else{
            return view("entreprise.detail",compact("aStatuer","entreprise","nombre_total_client",'proportion_de_depense_education','proportion_de_depense_sante','proportion_de_depense_bien_materiel','nombre_innovation','nombre_nouveau_marche','nombre_nouveau_produit',"piecejointes","chiffre_daffaire","produit_vendus", "benefice_nets","salaire_annuelles","effectif_permanent_entreprises","effectif_temporaire_entreprises"));
        }

    }
    public function view($id)
    {
        $entreprise= Entreprise::find($id);
        $piecejointes=Piecejointe::where("entreprise_id",$entreprise->id)->orWhere("promotrice_id", $entreprise->promotrice->id )->orderBy('updated_at', 'desc')->get();
        $effectif_permanent_entreprises= Infoeffectifentreprise::where("entreprise_id",$entreprise->id)->where("effectif",env("VALEUR_EFFECTIF_PERMANENENT"))->get();
        $effectif_temporaire_entreprises= Infoeffectifentreprise::where("entreprise_id",$entreprise->id)->where("effectif",env("VALEUR_EFFECTIF_TEMPORAIRE"))->get();
        $chiffre_daffaire= Infoentreprise::where("entreprise_id",$entreprise->id)->where("indicateur",env("VALEUR_CHIFFRE_D_AFFAIRE"))->get();
        $produit_vendus= Infoentreprise::where("entreprise_id",$entreprise->id)->where("indicateur",env("VALEUR_PRODUIT_VENDU"))->get();
        $benefice_nets= Infoentreprise::where("entreprise_id",$entreprise->id)->where("indicateur",env("VALEUR_PRODUIT_VENDU"))->get();
        $salaire_annuelles= Infoentreprise::where("entreprise_id",$entreprise->id)->where('indicateur', env("VALEUR_SALAIRE_MOYEN_ANNUEL") )->get();
        $nombre_nouveau_marche=Infoentreprise::where("entreprise_id",$entreprise->id)->where('indicateur', 6714 )->get();
        $nombre_nouveau_produit=Infoentreprise::where("entreprise_id",$entreprise->id)->where('indicateur', 6715)->get();
        $nombre_total_client=Infoentreprise::where("entreprise_id",$entreprise->id)->where('indicateur', env("VALEUR_NOMBRE_CLIENT") )->get();
        $nombre_innovation=Infoentreprise::where("entreprise_id",$entreprise->id)->where('indicateur', 6713 )->get();
        $proportion_de_depense_education= Proportion_de_depense_promotrice::where("promotrice_id",$entreprise->promotrice->id)->where('proportion_id',env("VALEUR_PROPORTION_EDUCATION") )->get();
        $proportion_de_depense_sante= Proportion_de_depense_promotrice::where("promotrice_id",$entreprise->promotrice->id)->where('proportion_id',env("VALEUR_PROPORTION_SANTE"))->get();
        $proportion_de_depense_bien_materiel= Proportion_de_depense_promotrice::where("promotrice_id",$entreprise->promotrice->id)->where('proportion_id',env("VALEUR_PROPORTION_BIEN"))->get();
        //dd($proportion_de_depense_education);
        return view("entreprise.detail",compact("entreprise","nombre_total_client",'proportion_de_depense_education','proportion_de_depense_sante','proportion_de_depense_bien_materiel','nombre_innovation','nombre_nouveau_marche','nombre_nouveau_produit',"piecejointes","chiffre_daffaire","produit_vendus", "benefice_nets","salaire_annuelles","effectif_permanent_entreprises","effectif_temporaire_entreprises"));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Entreprise  $entreprise
     * @return \Illuminate\Http\Response
     */
    public function edit(Entreprise $entreprise)
    {
        $entrepriseInfos = Infoentreprise::where("entreprise_id",$entreprise->id)->get();
        $entrepriseInfoseffectif = Infoeffectifentreprise::where("entreprise_id",$entreprise->id)->get();
        $regions=Valeur::where('parametre_id',1 )->whereIn('id', [env('VALEUR_ID_CENTRE'),env('VALEUR_ID_HAUT_BASSIN'), env('VALEUR_ID_BOUCLE_DU_MOUHOUN'), env('VALEUR_ID_NORD')])->get();
        $forme_juridiques=Valeur::where('parametre_id',8 )->get();
        $nature_clienteles=Valeur::where('parametre_id',10 )->get();
        $provenance_clients=Valeur::where('parametre_id',9 )->get();
        $maillon_activites=Valeur::where('parametre_id',7 )->get();
        $source_appros=Valeur::where('parametre_id',12 )->get();
        $sys_suivi_activites=Valeur::where('parametre_id',13 )->get();
        $annees=Valeur::where('parametre_id',16 )->where('id','!=', 46)->get();
        $futur_annees=Valeur::where('parametre_id',17 )->get();
        $rentabilite_criteres=Valeur::where('parametre_id',14 )->where('id','!=',env("VALEUR_ID_NOMBRE_CLIENT"))->get();
        $effectifs=Valeur::where('parametre_id',15 )->get();
        return view("entreprise.edit", compact("entreprise","regions","forme_juridiques","nature_clienteles","provenance_clients","maillon_activites","source_appros","sys_suivi_activites","annees","rentabilite_criteres","effectifs","entrepriseInfos"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Entreprise  $entreprise
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Entreprise $entreprise)
    {
       // return redirect()->back();
        $promoteur= Promotrice::where("code_promoteur",$request->code_promoteur)->first();
        $entreprise= Entreprise::where("code_promoteur", $promoteur->code_promoteur)->where("description_du_projet",null)->orderBy('created_at','desc')->first();
     if($entreprise->aopOuleader == "mpme"){
        $promoteur->update([
            "suscription_etape"=>3
        ]);
    }
    else{
        $promoteur->update([
            "suscriptionaopleader_etape"=>3
        ]);
    }
       
    //     //Si le promoteur a enregistré deux entreprises et le la deuxième entreprise a un projet.
    //     //Cela veut dire qu'il a créer deux entreprise et chaque entreprise à une projet
    //     if($promoteur->entreprises->count()==2){
    //         $promoteur->update([
    //         //pour spécifier que le souscripteur a renseigné une deuxième entreprise
    //             "etape_suscription2"=>3,
    //         ]);
    //     }
        $entreprise->update([
           'description_du_projet'=> $request->description_projet,
            'cout_projet'=> $request->cout_projet,
            'montant_subvention'=> $request->subvention_demandee,
             'status'=>1
        ]);
            $this->email= $entreprise->promotrice->email_promoteur;
            $chef_de_zone= User::where("zone",$entreprise->region)->first();
        if($chef_de_zone){
            $contact_chef_de_zone= $chef_de_zone->telephone ;
     }
        else{
             $contact_chef_de_zone= env("NUMERO_SUPPORT");
        }

        $entreprise_nn_traite= Entreprise::where('code_promoteur', $promoteur->code_promoteur)->where("aopOuleader","mpme")->where("conforme",null)->get();
        //nombre de nouvelle entreprise enregistré pas le promoteur
        $nbre_ent_nn_traite = count($entreprise_nn_traite);
        $data["email"] = $promoteur->email_promoteur;
        $this->email= $promoteur->email_promoteur;
        Mail::to($this->email)->queue(new resumeMail($entreprise->promotrice->id));
        Mail::to($this->email)->queue(new recepisseMail($entreprise->promotrice->id));
    if($entreprise->aopOuleader == "mpme"){
        return view("validateStep1", compact("promoteur","nbre_ent_nn_traite"))->with('success','Item created successfully!');
    }
    else{
        return view("validateStep1aop", compact("promoteur","nbre_ent_nn_traite"))->with('success','Item created successfully!');

    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Entreprise  $entreprise
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entreprise $entreprise)
    {
        //
    }
    //Fonction pour télécharger une pièce jointe
    public function telecharger($id)
    {
        $piecejointe= Piecejointe::where('id', $id)->first();
       return $path = Storage::download($piecejointe->url);
    }
    public function detaildocument(Piecejointe $piecejointe){
        return view("document.show", compact('piecejointe'));
    }
    public function verifierentreprise(Request $request){
            $denomination= $request->denom;
            $result= Entreprise::where("denomination",$denomination)->where("code_promoteur",$promoteur)->first();
        return json_encode($result);
    }
    public function updatelocalisationentreprise(Request $request)
   {
       $entreprise = Entreprise::find($request->id);
       
        $entreprise->update([
            'latitude'=>$request['longitude'],
            'longitude'=>$request['latitude'],
        ]);
    }
    public function sendSyntheseToComite(Request $request)
    {
            $membre_comites= User::where('structure_represente','!=',0)->where('structure_represente','!=',null)->get();
          foreach($membre_comites as $membre_comite){
               $mail=$membre_comite->email;
               Mail::to($mail)->queue(new synthese($request->entreprise_id));
      }
          return redirect()->back();
    }
    public function addPlanDeContinute($id)
    {
       $entreprise= Entreprise::find($id);
       return view("public.addPlanDeContitune", compact('entreprise'));
    }
    public function completerPoportiondeDepensedupromoteur(Entreprise $entreprise)
    {
        $proportiondedepences= Valeur::where('parametre_id', 32)->get();
        $nombre_de_clients= Valeur::where('id', 7085)->get();
        $annees=Valeur::where('parametre_id',16 )->where('id','!=', 46)->get();
        return view("entreprise.completerProportiondepensedupromoteur", compact("entreprise", "nombre_de_clients","proportiondedepences","annees"));
}
public function storePoportiondeDepensedupromoteur(Request $request){
    $proportiondedepences= Valeur::where('parametre_id', 32)->get();
    $nombre_de_clients= Valeur::where('id', 7085)->get();
        // dd($proportiondedepences);
        $annees=Valeur::where('parametre_id',16 )->where('id','!=', 46)->get();
    foreach($proportiondedepences as $proportiondedepence){
        foreach($annees as $annee){
            $variable=$proportiondedepence->id.$annee->id;
            Proportion_de_depense_promotrice::create([
                "proportion_id"=>$proportiondedepence->id,
                "annee_id"=>$annee->id,
                "pourcentage"=>$request->$variable,
                "promotrice_id"=>$request->id_promoteur,
            ]);
        }
    }
    foreach($nombre_de_clients as $nombre_de_client){
        foreach($annees as $annee){
            $variable=$nombre_de_client->id.$annee->id;
            Infoentreprise::create([
                "indicateur"=>$nombre_de_client->id,
                "annee"=>$annee->id,
                "quantite"=>$request->$variable,
                "entreprise_id"=>$request->id_entreprise,
                "code_promoteur"=>$request->code_promoteur,
            ]);
        }
    }
    return redirect()->route("souscription__reparties_par_zone");
}
public function return_view(){
    return view('entreprise.import');
}
public function chargerGeoData(Request $request){
    $entreprises= Entreprise::all();
    // 1. Validation du fichier uploadé. Extension ".xlsx" autorisée
    $this->validate($request, [
        'fichier' => 'bail|required|file|mimes:xlsx'
    ]);

    // 2. On déplace le fichier uploadé vers le dossier "public" pour le lire
    $fichier = $request->fichier->move(public_path(), $request->fichier->hashName());

    // 3. $reader : L'instance Spatie\SimpleExcel\SimpleExcelReader
    $reader = SimpleExcelReader::create($fichier);
     // On récupère le contenu (les lignes) du fichier
    $rows = $reader->getRows();

$ids=[];
$i=0;
foreach($rows as $row){
    $datas[]= array('code_promoteur'=>$row['code_promoteur'], 'longitude'=>$row['longitude'],'latitude'=>$row['latitude']);

}
//dd($data);
    foreach($entreprises as $entreprise){
        foreach($datas as $data){
           // dd($data['code_promoteur']);
            if($entreprise->code_promoteur==$data['code_promoteur']){
                //dd($entreprise->id);
                $entreprise->update([
                    'longitude'=>$data['longitude'],
                    'latitude'=>$data['latitude']
                ]);
            }
    }
}

    // $rows est une Illuminate\Support\LazyCollection

    // 4. On insère toutes les lignes dans la base de données
    
    $status = TRUE;

    // Si toutes les lignes sont insérées
    if ($status) {

        // 5. On supprime le fichier uploadé
        $reader->close(); // On ferme le $reader
      
      //  unlink($fichier);

        // 6. Retour vers le formulaire avec un message $msg
        return back()->withMsg("Importation réussie !");

    } else { abort(500); }

}
}
