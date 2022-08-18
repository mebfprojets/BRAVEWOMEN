<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Models\Contact;
use App\Models\Decision;
use App\Models\Entreprise;
use App\Models\Promotrice;
use App\Models\Valeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SouscriptionController extends Controller
{
        public function __construct()
        {
            $this->middleware('auth')->except(["afficher", "contactSendMessage","send"]);
        }
        
    public function afficher(){
        $regions=Valeur::where('parametre_id',env('PARAMETRE_ID_REGION'))->get();
        $niveau_instructions=Valeur::where("parametre_id", env('PARAMETRE_NIVEAU_D_INSTRUCTION'))->get();
        $tests=Valeur::where("parametre_id", env('PARAMETRE_NIVEAU_D_INSTRUCTION'))->get();
        //les plages d'annee
        //$tests = Valeur::where("parametre_id",env('PARAMETRE_ID_REGION'))->get();
        return view("public.subscription", compact("regions", "niveau_instructions","tests"));
    }

    public function listerallsouscriptiontermine(Request $request){
        $active='souscription_enregistre';
        $active_principal="pme";
        $titre="Enregistrées";
        $categorieentreprise= $request->typeentreprise;
        ($categorieentreprise=='mpme')?($active='souscription_enregistre'):($active='aop_enregistre');
        ($categorieentreprise=='mpme')?($active_principal="pme"):($active_principal='aop');
        ($categorieentreprise=='mpme')?($categorieentreprise=null):($categorieentreprise=1);
        $entreprises = Entreprise::where(['entrepriseaop'=>$categorieentreprise, "status"=>!(0)])->orderBy('updated_at', 'desc')->get();  
        return view("souscriptions.liste_de_souscription_soumis_a_ugp", compact("entreprises","active","titre","active_principal"));
    }

public function listersouscriptionpostpreanalyse(Request $request){
        $active='souscription_post_preanalyse';
        $active_principal="pme";
        $titre="Enregistrées";
        $categorieentreprise= $request->typeentreprise;
        ($categorieentreprise=='mpme')?($active='souscription_enregistre'):($active='aop_enregistre');
        ($categorieentreprise=='mpme')?($active_principal="pme"):($active_principal='aop');
        ($categorieentreprise=='mpme')?($categorieentreprise=null):($categorieentreprise=1);
        $entreprises = Entreprise::where(['entrepriseaop'=>$categorieentreprise, "status"=>!(0)])->orderBy('updated_at', 'desc')->get();  
        return view("souscriptions.liste_souscription_postpreanalyse", compact("entreprises","active","titre","active_principal"));
    }
  public function listersouscriptionParZone(){
        $active='souscription_par_zone';
        $active_principal="pme";
        $titre="de la zone"." ".getlibelle(Auth::user()->zone);
        //where statuts = 0 pour n'afficher que les souscription qui sont terminées
        $entreprises = Entreprise::where("status",'!=',0)->where('region', Auth::user()->zone)->where('entrepriseaop',null)->get();
        return view("souscriptions.prevalidable", compact("entreprises","active","titre","active_principal"));
    }
public function listerlespmeretenueEtFormee(){
    $active='PME_formee';
    $titre='Liste des entreprises PME formés';
    $active_principal="pme";
    $entreprises=Entreprise::where('entrepriseaop',null)->where("participer_a_la_formation",1)->where("decision_du_comite_phase1","selectionnee")->get();
    return view("souscriptions.prevalidable", compact("entreprises","active","titre","active_principal"));
}
    public function validersouscription(Request $request)
    {
        $id_entreprise= $request->id_entreprise;
        $id_user= $request->id_user;
        //dd($id_user);
        Decision::create([
            'user_id'=>$id_user,
            'entreprise_id'=> $id_entreprise,
            'decision'=> "retenu",
        ]);
        $entreprise = Entreprise::find("$id_entreprise");
        $decisions_retenu= Decision::where("entreprise_id", $entreprise->id)->where("decision", "retenu")->orderBy('updated_at', 'desc')->get();
         if(count($entreprise->decisions)== env("NOMBRE_MEMBRE_COMITE"))
         {
           if ( (count($decisions_retenu) >= (count($entreprise->decisions)/2)) )
           {
             $entreprise->update([
                 "decision_du_comite_phase1"=>"retenu"
             ]);
           }
           else{
             $entreprise->update([
                 "decision_du_comite_phase1"=>"rejetee"
             ]);
           }
         }

            return redirect()->back();
    }
    public function statuersurLasoucriptionPmeParleComitePourLaPhaseFormation(Request $request){
        $id_entreprise= $request->id_entreprise;
        $observation= $request->observation;
        //$tatut la decicision qui ajournée ou selectionnée  recupéré à partir du modal de decision du comité 
        $statut=$request->statut;
        $entreprise = Entreprise::find("$id_entreprise");
            $entreprise->update([
                "decision_du_comite_phase1"=>$statut, 
                "commentaire_membre_comite_phase1"=>$observation,
            ]);
    }
    public function ajournerLasoucriptiondePmeParleComitePourLaPhaseFormation(Request $request){
        $id_entreprise= $request->id_entreprise;
        $entreprise = Entreprise::find("$id_entreprise");
            $entreprise->update([
                "decision_du_comite_phase1"=>"ajournee"
            ]);
    }
    //Fonction permettant aux membre du comité de voter sur les dossier 
    //fonction remplacée par 
    public function statuersouscription(Request $request)
    {
        $id_entreprise= $request->id_entreprise;
        $id_user= $request->id_user;
     
        if($request->raison != null){
               $decision= "ajournee" ;
        }
        else{
            $decision= "selectionnee" ;
        }
        Decision::create([
            'user_id'=>$id_user,
            'entreprise_id'=> $id_entreprise,
            "raison"=> $request->raison,
            'decision'=> $decision,
        ]);

            return redirect()->back();
    }
//fonction lister les souscriptions MPME soumises au comité de selection
   public function souscriptionsAanalyserParLeComite(Request $request){
    $active='souscription_soumis_aucomite';
    $titre="soumises à la validation du comité technique";
    $active_principal="pme";
    $categorieentreprise= $request->typeentreprise;
    ($categorieentreprise=='mpme')?($active='souscription_soumis_aucomite'):($active='aop_soumis_aucomite');
    ($categorieentreprise=='mpme')?($active_principal="pme"):($active_principal='aop');
    ($categorieentreprise=='mpme')?($categorieentreprise=null):($categorieentreprise=1);
    $souscription_tranchee_par_users= Decision::where("user_id",Auth::user()->id)->get();
    $id_entreprises=[];
    $i=0;
    foreach($souscription_tranchee_par_users as $souscription_tranchee_par_user)
    {
        $id_entreprises[$i]= $souscription_tranchee_par_user->entreprise_id;
        $i++;
    }
        $entreprises = Entreprise::where("status",1)->where('entrepriseaop',$categorieentreprise)->where("decision_ugp","!=",null)->where("decision_du_comite_phase1",null)->orderBy('updated_at', 'desc')->get();
        $entreprises= $entreprises->except($id_entreprises);
    return view("souscriptions.prevalidable", compact("entreprises","active","titre","active_principal"));
   }
   public function souscriptionAnalyses_par_lecomite(Request $request)
   {  
        $active="analyse_par_le_comite";
        $active_principal="pme";
        $categorieentreprise= $request->typeentreprise;
        ($categorieentreprise=='mpme')?($active='analyse_par_le_comite'):($active='aop_analyse_par_lecomite');
        ($categorieentreprise=='mpme')?($active_principal="pme"):($active_principal='aop');
        ($categorieentreprise=='mpme')?($categorieentreprise=null):($categorieentreprise=1);
        //dd($categorieentreprise);
        //$entreprises = Entreprise::where("status",1)->where('entrepriseaop',null)->where("decision_du_comite_phase1","!=" ,null)->orderBy('updated_at', 'desc')->get();
        $entreprises = Entreprise::where("status",1)->where('entrepriseaop',$categorieentreprise)->where('decision_ugp','!=',null)->orderBy('updated_at', 'desc')->get();
        $id_entreprises=[];
        $i=0;
        //constitution de la liste des entreprises dont tous les membres n'ont pas statuer
        foreach($entreprises as $entreprise){
                if(!(getnombrededecisiondesmembreducomitedelentreprise($entreprise->id)==env("NOMBRE_MEMBRE_COMITE"))){
                    $id_entreprises[$i]= $entreprise->id;
                        $i++;
                }
                
        }
        //on exclu les entreprise dont tous les membres n'ont pas encore  statuer
        $entreprises= $entreprises->except($id_entreprises);
        return view("souscriptions.listeDesSouscriptionsAnalyseeParLeComite", compact("entreprises","active","active_principal"));
   }
   public function souscriptionsretenues(Request $request)
   {
    $titre="pme_retenu";
    $active_principal="pme";
    $active="pme_retenu";
    $categorieentreprise= $request->typeentreprise;
    ($categorieentreprise=='mpme')?($active='souscription_retenue'):($active='aop_retenu');
    ($categorieentreprise=='mpme')?($active_principal="pme"):($active_principal='aop');
    ($categorieentreprise=='mpme')?($categorieentreprise=null):($categorieentreprise=1);
    $entreprises = Entreprise::where("decision_du_comite_phase1", "selectionnee")->where('entrepriseaop',$categorieentreprise)->orderBy('updated_at', 'desc')->get();
    return view("souscriptions.prevalidable", compact("entreprises", "titre","active","active_principal"));
   }
   public function souscriptionsretenuesParZone(Request $request){
    $categorieentreprise= $request->typeentreprise;
    $titre="de la zone"." ".getlibelle(Auth::user()->zone);
    $active_principal="pme";
    $active="pme_retenu_par_zone";
        $categorieentreprise= $request->typeentreprise;
        ($categorieentreprise=='mpme')?($active='pme_retenu_par_zone'):($active='aop_retenue_par_zone');
        ($categorieentreprise=='mpme')?($active_principal="pme"):($active_principal='aop');
        ($categorieentreprise=='mpme')?($categorieentreprise=null):($categorieentreprise=1);
    $entreprises = Entreprise::where("decision_du_comite_phase1", "selectionnee")->where('entrepriseaop',$categorieentreprise)->where('region', Auth::user()->zone)->orderBy('updated_at', 'desc')->get();
    return view("souscriptions.retenue", compact("entreprises", "titre","active","active_principal"));
   }
   public function souscriptionsrejetes(Request $request){
    $id= $request->id;
        $entreprise=Entreprise::find($id);
        $entreprise->update([
            "status"=>$entreprise->status - 1,
            "raison"=>$request->raison_du_rejet
        ]);
            return redirect()->back();
   }
    public function contactSendMessage(Request $request){
       
        $this->validate($request, [
    		'nom'=> "required",
    		'email'=> "required",
    		'message'=> "required",
    	]);
    	$nom = $request->nom;
    	$email = $request->email;
        $telephone = $request->telephone;
        $region = $request->region;
    	$message = $request->message."."."Je suis dans la zone: ".$region." ."."Mon adresse email est :".$email;
    	$email_equipe = env('EMAIL_CONTACT_SUPPORT');
    	$reponse = env('MESSAGE_ASSISTANCE');

    	Contact::create([
    		'nom'=>$nom,
            //'telephone'=>$telephone,
    		'email'=>$email,
    		'message'=>$message

    	]);

    	//// MAIL POUR L'EQUIPE TECHNIQUE
    	Mail::to($email_equipe)->send( new ContactMail($nom, $message, $telephone,  'mails.contactMail') );
        $contact=Mail::to($email);
    	echo $contact->send(new ContactMail($nom, $reponse, $telephone, 'mails.contactReponse'));
                return 'OK';
    }

    public function send()
    {
    	$e_nom = "SANOU";
    	$e_msg = "Merci de nous avoir écrit. Notre équipe technique vous répondra le plus vite possible. Attention: Ceci n'est pas une souscription. Allez sur le menu souscrire. Pour toute information veillez contacter les chefs de zone aux numéros suivants : Boucle du Mouhoun: 61 35 25 42 Centre: 70 76 73 74 / 72 47 18 86 Hauts Bassins: 76 52 74 00 Nord: 70 78 83 12 ";
    	return view('contacts.reponse', compact('e_msg', 'e_nom'));
    }
    public function saveConformite(Request $request){
            $entreprise = Entreprise::where('id',$request->id_entreprise)->first();
            $entreprise->update([
                'conforme'=>$request->conforme,
            ]);
            return redirect()->back();
    }
    public function save_avis_ugp(Request $request){
        $entreprise = Entreprise::find($request->id_entreprise);
        $entreprise->update([
        'decision_ugp'=>$request->avis,
        'observation_ugp'=>$request->observation
        ]);
        return redirect()->back();
}
public function afficherrechercher(){
    $entreprises = Entreprise::where("status",'!=',0)->orderBy('updated_at', 'desc')->get(); 
    $regions=Valeur::where('parametre_id',1 )->get();
    $secteur_activites= Valeur::where("parametre_id",env('PARAMETRE_SECTEUR_ACTIVITE_ID'))->get();
    $maillon_activites= Valeur::where('parametre_id',7 )->get();
    return view("souscriptions.rechercher", compact("entreprises","maillon_activites","secteur_activites","regions"));
}
public function filtrerdata(Request $request)
{
        $type_entreprise= $request->type_entreprise;
  //dd($type_entreprise);
        $type_entreprise=="null"?$type=null:$type=$type_entreprise;
        $region= $request->region;
        $secteur_activite=$request->secteur_activite;
        $maillon_activite=$request->maillon;
        $entreprises = Entreprise::where('aopOuleader',$type)->where('status',1)->where("secteur_activite", $secteur_activite)->where('maillon_activite',$maillon_activite)->where('region',$region)->orderBy('updated_at', 'desc')->get();
        if($region=='all'){
            $entreprises = Entreprise::where('aopOuleader',$type)->where("secteur_activite", $secteur_activite)->where('maillon_activite',$maillon_activite)->orderBy('updated_at', 'desc')->get();
        }
        if($secteur_activite=='all'){
            $entreprises = Entreprise::where('aopOuleader',$type)->where('maillon_activite',$maillon_activite)->where('region',$region)->orderBy('updated_at', 'desc')->get();  
        }
        if($maillon_activite=='all'){
            $entreprises = Entreprise::where('aopOuleader',$type)->where("secteur_activite", $secteur_activite)->where('region',$region)->orderBy('updated_at', 'desc')->get();
        }
       // if($type_entreprise!=null || $region!=null  $secteur_activite!=null && $maillon_activite!=null ){
        $data=[];
        foreach( $entreprises as $value)
            {
               // dd($entreprises_retenu->denomination);
               $data[] = array('id'=>$value->id,'denomination'=>$value->denomination,'region'=>getlibelle($value->region),'nombre_annee_experience'=>$value->nombre_annee_experience, 'secteur_activite'=>getlibelle($value->secteur_activite),'maillon_activite'=>getlibelle($value->maillon_activite));
            }
          // dd(json_encode($entreprises_retenus));
            return json_encode($data);
       // }
}
public function generer_en_excel(){
    $entreprises=Entreprise::all();
    $fileName = "itemdata-".date('d-m-Y').".xls";

    // Définir les informations d'en-tête pour exporter les données au format Excel
    
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename='.$fileName);
    
    // Défini la variable sur false pour l'en-tête
            $heading = false;
    
    // Ajouter les données de la table MySQL au fichier Excel
            if(!empty($items)) {
        foreach($items as $item) {
        if(!$heading) {
        echo implode("\t", array_keys($item)) . "\n";
        $heading = true;
        }
        echo implode("\t", array_values($item)) . "\n";
        }
        }
        exit();
}
       
    }
