<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use App\Models\Infoentreprise;
use App\Models\Banque;
use App\Models\Entreprise;
use App\Models\InvestissementProjet;
use App\Models\Promotrice;
use App\Models\Valeur;
use App\Models\Coach;
use App\Models\Devi;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Proportion_de_depense_promotrice;
use Illuminate\Support\Facades\Auth;
use App\Models\Piecejointe;
use App\Models\GrilleEval;
use App\Models\EvaluationPca;
use Spatie\SimpleExcel\SimpleExcelReader;

class ProjetController extends Controller
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
    public function supprimer_doublon_de_pj($entreprise_id, $type_doc){
        $priece_a_supprimer= Piecejointe::where(['type_piece'=>$type_doc, 'entreprise_id'=>$entreprise_id])->first();
        if($priece_a_supprimer){
            $priece_a_supprimer->delete();
        }
    }
    public function index(Request $request)
    {
    if (Auth::user()->can('acceder_aux_pca_selectionne')) { 
        if($request->type_entreprise=='mpme'){
            $projets= Projet::where('type_entreprise','mpme')->get();
            $type_entreprise='pca_mpme';
        }
        else{
            $projets= Projet::whereIn('type_entreprise',['leader','aop'])->get();
            $type_entreprise='pca_aop';
        }
        
        return view('projet.index', compact('projets','type_entreprise'));
    }
    else{
        flash("Vous ne disposez pas du droit d'access à cette liste. Bien vouloir contacter l'administrateur")->error(); 
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
       $proportiondedepences= Valeur::where('parametre_id', 31)->get();
       $categorie_investissments=Valeur::where('parametre_id', 38)->get();
       $promoteur = Promotrice::where('code_promoteur',Auth::user()->code_promoteur)->first();
       $nombre_de_clients= Valeur::where('id', 7085)->get();
       $entreprise = Entreprise::where('code_promoteur', $promoteur->code_promoteur)->where('participer_a_la_formation', 1)->first();
       $projet= Projet::where('entreprise_id', $entreprise->id )->first();
       $coachs= Coach::all();
       $banques= Banque::all();
       $proportiondedepence=Proportion_de_depense_promotrice::where('promotrice_id', $promoteur->id )->get();
            (count($proportiondedepence) == 0)?($afficherproportion=1):($afficherproportion=0);
        $annees=Valeur::where('parametre_id',16 )->get();
            if(!$projet){
            return view('projet.create', compact('coachs','categorie_investissments','proportiondedepences', "nombre_de_clients", 'annees', 'afficherproportion', 'entreprise','banques'));
            }
            else{
                flash("Vous avez déjà soumis votre Plan de continuté des activité. Veillez contacter l'administrateur!!!")->error();
                return redirect()->back();
            }
    }
    public function lister(Request $request){
        $banques= Banque::all();
        $type_entreprise=$request->type_entreprise;
            if($request->statut=='soumis'){
                if($type_entreprise=='mpme'){
                    $projets = Projet::whereIn('statut',['soumis','analyse'])->where('avis_chefdezone',null)->where('type_entreprise', 'mpme')->where('zone_affectation', Auth::user()->zone)->orderBy('updated_at', 'desc')->get();
                    $type_entreprise='pca_mpme';
                }
                else{
                    $projets = Projet::whereIn('statut',['soumis','analyse'])->where('avis_chefdezone',null)->whereIn('type_entreprise',['leader','aop'])->where('zone_affectation', Auth::user()->zone)->orderBy('updated_at', 'desc')->get();
                    $type_entreprise='pca_aop';
                }
                $texte= 'à évaluer par le chef de zone';
                $page='liste_analyse';
            }
            elseif($request->statut=='analyse'){
                if($type_entreprise=='mpme'){
                    $projets = Projet::whereIn('statut' ,['a_affecter_au_membre_du_comite','analyse'])->where('type_entreprise','mpme')->where('avis_chefdezone','!=',null)->where('avis_ugp',null)->orderBy('updated_at', 'desc')->get();
                    //$projets = Projet::whereIn('statut',['soumis','analyse'])->where('avis_chefdezone',null)->where('type_entreprise', 'mpme')->whereIn('type_entreprise','mpme')->where('zone_affectation', Auth::user()->zone)->orderBy('updated_at', 'desc')->get();
                    $type_entreprise='pca_mpme';
                }
                else{
                    $projets = Projet::whereIn('statut' ,['a_affecter_au_membre_du_comite','analyse'])->whereIn('type_entreprise',['leader','aop'])->where('avis_chefdezone','!=',null)->where('avis_ugp',null)->orderBy('updated_at', 'desc')->get();
                    //$projets = Projet::whereIn('statut',['soumis','analyse'])->where('avis_chefdezone',null)->whereIn('type_entreprise',['leader','aop'])->where('zone_affectation', Auth::user()->zone)->orderBy('updated_at', 'desc')->get();
                    $type_entreprise='pca_aop';
                }
                $texte= 'a valider par la cheffe de projet';
                $page= 'analyse';
            }
            elseif($request->statut=='a_affecter_au_membre_du_comite'){
                if($type_entreprise=='mpme'){
                    $projets = Projet::whereIn('statut', ['a_affecter_au_membre_du_comite'])->where('type_entreprise', 'mpme')->where('avis_ugp','!=',null)->where('liste_dattente_observations',null)->orderBy('updated_at', 'desc')->get();
                    $type_entreprise='pca_mpme';
                }
                else{
                    $projets = Projet::whereIn('statut', ['a_affecter_au_membre_du_comite'])->where('avis_ugp','!=',null)->whereIn('type_entreprise',['leader','aop'])->where('liste_dattente_observations',null)->orderBy('updated_at', 'desc')->get();
                   $type_entreprise='pca_aop';
                }
                $texte= "PCA/PA soumis à l'appreciation des membres du comité";
               // $projets = Projet::whereIn('statut', ['a_affecter_au_membre_du_comite'])->where('avis_ugp','!=',null)->orderBy('updated_at', 'desc')->get();
                $page= 'a_affecter_au_membre_du_comite';
            }
            elseif($request->statut=='soumis_au_comite'){
                if($type_entreprise=='mpme'){
                    $projets = Projet::whereIn('statut', ['a_affecter_au_membre_du_comite'])->where('avis_ugp','favorable')->where('type_entreprise','mpme')->orderBy('updated_at', 'desc')->get(); 
                    $type_entreprise='pca_mpme';
                }
                else{
                    $projets = Projet::whereIn('statut', ['a_affecter_au_membre_du_comite'])->where('avis_ugp','favorable')->whereIn('type_entreprise',['leader','aop'])->orderBy('updated_at', 'desc')->get(); 
                   // $projets = Projet::whereIn('statut', ['a_affecter_au_membre_du_comite'])->where('avis_ugp','!=',null)->whereIn('type_entreprise',['leader','aop'])->orderBy('updated_at', 'desc')->get();
                   // $projets = Projet::whereIn('statut' ,['a_affecter_au_membre_du_comite','analyse'])->whereIn('type_entreprise',['leader','aop'])->where('avis_chefdezone','!=',null)->where('avis_ugp',null)->orderBy('updated_at', 'desc')->get();
                   $type_entreprise='pca_aop';
                }
                $texte= "PCA/PA soumis à l'appreciation des membres du comité avec avis favorable de l'UGP";
                $page= 'soumis_comite';
              //  return view("projet.liste_selectionne", compact('projets','banques','page','texte'));
            }
            elseif($request->statut=='analyse_par_le_comite'){
                if($type_entreprise=='mpme'){
                    $projets = Projet::whereIn('statut', ['selectionne','rejete'])->where('type_entreprise','mpme')->whereBetween('updated_at', ['2023-11-27 00-00-00', '2023-11-28 00-00-00'])->orderBy('updated_at', 'desc')->get(); 
                    $type_entreprise='pca_mpme';
                }
                else{
                    $projets = Projet::whereIn('statut', ['selectionne','rejete'])->whereIn('type_entreprise',['leader','aop'])->whereBetween('updated_at', ['2023-11-27 00-00-00', '2023-11-28 00-00-00'])->orderBy('updated_at', 'desc')->get(); 
                    $type_entreprise='pca_aop';
                }
                $texte= "/PCA/PA analysés par le comité";
                $page= 'analyse_par_le_comite';
                return view("projet.liste_selectionne", compact('projets','banques','page','texte','type_entreprise'));
            }
            return view("projet.liste_analyse", compact('projets','banques','page','texte','type_entreprise'));
    }
    public function lister_pca_liste_dattente(Request $request){
        if (Auth::user()->can('acceder_aux_pca_selectionne')) { 
         $banques= Banque::all();
         $type_entreprise= $request->type_entreprise;
        if($type_entreprise=='mpme'){
            $projets = Projet::whereIn('statut', ['a_affecter_au_membre_du_comite'])->where('type_entreprise', 'mpme')->where('avis_ugp','!=',null)->where('liste_dattente_observations','!=',null)->orderBy('updated_at', 'desc')->get();
            $type_entreprise='pca_mpme';
        }
        else{
           $projets = Projet::whereIn('statut', ['a_affecter_au_membre_du_comite'])->where('avis_ugp','!=',null)->whereIn('type_entreprise',['leader','aop'])->where('liste_dattente_observations','!=',null)->orderBy('updated_at', 'desc')->get();
           $type_entreprise='pca_aop';
        }
        $texte= "Liste d'attente des PCA/PA ";
        $page= 'liste_dattente';
        return view("projet.liste_analyse", compact('projets','banques','page','texte','type_entreprise'));
     }
     else{
        flash("Vous ne disposez pas du droit d'access à cette liste. Bien vouloir contacter l'administrateur")->error(); 
        return redirect()->back();
    }
    }
    public function liste_des_projets_asuivre(Request $request){
        if (Auth::user()->can('suivre_execution_pca')) {
        if($request->type_entreprise=='mpme'){
            if(Auth::user()->zone==100){
                $entreprises_projets_retenus= Entreprise::where("date_de_creation_compte",'!=',null)->where('aopOuleader','mpme')->get();
            }
            else{
                $entreprises_projets_retenus= Entreprise::where("date_de_creation_compte",'!=',null)->where('region', Auth::user()->zone)->orWhere('region_affectation', Auth::user()->zone)->where('aopOuleader','mpme')->get();
            }
            $type_entreprise='suivi_physique_mpme';
        }
        else{
            if(Auth::user()->zone==100){
                $entreprises_projets_retenus= Entreprise::where("date_de_creation_compte",'!=',null)->whereIn('aopOuleader',['leader','aop'])->get();
            }
            else{
                $entreprises_projets_retenus= Entreprise::where("date_de_creation_compte",'!=',null)->where('region', Auth::user()->zone)->orWhere('region_affectation', Auth::user()->zone)->whereIn('aopOuleader',['leader','aop'])->get();
            }
             $type_entreprise='suivi_physique_aop';
        }
        return view('projet.asuivre', compact('entreprises_projets_retenus','type_entreprise'));
    }
    else{
        flash("Vous ne disposez pas du droit d'access à cette liste. Bien vouloir contacter l'administrateur")->error(); 
        return redirect()->back();
    }
    }
public function lister_pca_selectionne_par_zone(Request $request){
    if (Auth::user()->can('acceder_aux_pca_selectionne')) { 
         $banques= Banque::all();
        $type_entreprise= $request->type_entreprise;
        $page='selectionnes';
        $texte= 'Selectionnés par le comité technique';
        if(Auth::user()->zone!= 100){ 
            if($type_entreprise=='mpme') {
                $projets = Projet::where('statut','selectionné')->where('type_entreprise', 'mpme')->where('zone_affectation', Auth::user()->zone)->get();
                $type_entreprise='pca_mpme';
            }
            else{
                $projets = Projet::where('statut','selectionné')->where('type_entreprise','aop')->orWhere('type_entreprise','leader')->where('zone_affectation', Auth::user()->zone)->get();
                $type_entreprise='pca_aop';
            }     
            return view("projet.liste_selectionne", compact('projets','banques','page','texte','type_entreprise'));
        }
    //Si user connecté est dans une zone afficher toutes les entreprises dont le projet est selectionné dans sa zone
        else{
         if($type_entreprise =='mpme') {
            $projets = Projet::where('statut','selectionné')->where('type_entreprise','mpme')->get();
            $type_entreprise='pca_mpme';
         }
         else{
            $projets = Projet::where('statut','selectionné')->whereIn('type_entreprise',['aop','leader'])->get();
            $type_entreprise='pca_aop';
         }
        }   
            return view("projet.liste_selectionne", compact('projets','banques','page','texte','type_entreprise'));
        }
        else{
            flash("Vous n'avez pas ce droit d'access bien vouloir contacter l'administrateur !!!")->error();
            return redirect()->back();
        }
    }
    public function save_de_demande_kyc(Request $request){
            $entreprise= Entreprise::find($request->entreprise);
            $date_demande_kyc= date('Y-m-d', strtotime($request->date_demande_kyc));
            $entreprise->update([
                    'date_demande_kyc'=>$date_demande_kyc
            ]);
            return redirect()->back();
    }
public function save_date_demande_creation_compte(Request $request){
    $entreprise= Entreprise::find($request->entreprise);
    $date_demande_creation_compte= date('Y-m-d', strtotime($request->date_demande_creation_compte));
    $entreprise->update([
            'date_de_demande_creation_compte'=>$date_demande_creation_compte
    ]);
    flash("La demande de création de sous compte a été enregistrée avec success")->success(); 
    return redirect()->back();
}
public function importer_result_kyc(Request $request){
    $this->validate($request, [
        'fichier' => 'bail|required|file|mimes:xlsx'
    ]);
    // 2. On déplace le fichier uploadé vers le dossier "public" pour le lire
    $fichier = $request->fichier->move(public_path(), $request->fichier->hashName());
    // 3. $reader : L'instance Spatie\SimpleExcel\SimpleExcelReader
    $reader = SimpleExcelReader::create($fichier);
     // On récupère le contenu (les lignes) du fichier
    $rows = $reader->getRows();

//vider la table activité 
$ids=[];
$i=0;
foreach($rows as $row){
    $datas[]= array('code_promoteur'=>$row['code_promoteur'],'date_de_demande'=>$row['date_demande_kyc'], 'date_du_resultat'=>$row['date_resultat_kyc'], 'resultat'=>$row['resultat']);
}
//Supprimer les anciennes données avant l'import 
foreach($datas as $data){
    $entreprise=Entreprise::where('code_promoteur', $data['code_promoteur'])->where("participer_a_la_formation",1)->first();
    $pj= Projet::where('entreprise_id',$entreprise->id)->first();
if($pj){
    $st=$pj->statut;
if($st=='selectionné'){
    $entreprise->update([
        'date_demande_kyc'=> $data['date_de_demande'],
        'date_realisation_kyc'=> $data['date_du_resultat'],
        'resultat_kyc'=>$data['resultat'],
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
        flash("Import effectué avec success")->success();
        return back()->withMsg("Importation réussie !");
    } else { abort(500); }

}
public function importer_date_creation_ss_compte(Request $request){
    $this->validate($request, [
        'fichier' => 'bail|required|file|mimes:xlsx'
    ]);
    // 2. On déplace le fichier uploadé vers le dossier "public" pour le lire
    $fichier = $request->fichier->move(public_path(), $request->fichier->hashName());
    // 3. $reader : L'instance Spatie\SimpleExcel\SimpleExcelReader
    $reader = SimpleExcelReader::create($fichier);
     // On récupère le contenu (les lignes) du fichier
    $rows = $reader->getRows();

//vider la table activité 
$ids=[];
$i=0;
foreach($rows as $row){
    $datas[]= array('code_promoteur'=>$row['code_promoteur'],'date_demande_de_creation'=>$row['date_demande_de_creation'], 'date_creation'=>$row['date_creation'],'num_ss_compte'=>$row['num_ss_compte']);
}
//Supprimer les anciennes données avant l'import 
foreach($datas as $data){
    
    $entreprise=Entreprise::where('code_promoteur', $data['code_promoteur'],)->where("participer_a_la_formation",1)->first();
    $pj= Projet::where('entreprise_id',$entreprise->id)->first();
if($pj){
    $st=$pj->statut;
if($st=='selectionné' && $entreprise->date_de_signature_accord_beneficiaire!=null)
{
    $entreprise->update([
        'date_de_demande_creation_compte'=> $data['date_demande_de_creation'],
        'date_de_creation_compte'=> $data['date_creation'],
        'num_ss_compte'=> $data['num_ss_compte'],
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
        flash("Import effectué avec success")->success();
        return back()->withMsg("Importation réussie !");
    } else { abort(500); }

}
public function save_date_creation_compte(Request $request){
    $entreprise= Entreprise::find($request->entreprise);
    $date_creation_compte= date('Y-m-d', strtotime($request->date_demande_creation_compte));
    $entreprise->update([
            'date_de_creation_compte'=>$date_creation_compte
    ]);
    flash("La  création de sous compte a été enregistrée avec success")->success(); 
    return redirect()->back();
}
public function save_accord_beneficiaire(Request $request){
    if ($request->hasFile('accord_beneficiaire')) {
        $entreprise= Entreprise::find($request->entreprise);
        $date_de_signature= date('Y-m-d', strtotime($request->date_de_signature));
        if($request->banque!=''){
           $banque= $request->banque;
        }else{
            $banque= $entreprise->banque_id;
        }
        $entreprise->update([
            'date_de_signature_accord_beneficiaire'=>$date_de_signature,
            'banque_id' => $banque,
        ]);
            $file = $request->file('accord_beneficiaire');
            $extension=$file->getClientOriginalExtension();
            $fileName = $entreprise->code_promoteur.'.'.$extension;
            $emplacement='public/accord_beneficiaire'; 
            $accord_beneficiaire= $request['accord_beneficiaire']->storeAs($emplacement, $fileName);
           // $accord_beneficiaire= $request->accord_beneficiaire->store('public/accord_beneficiaire');
     $this->supprimer_doublon_de_pj($entreprise->id, env("VALEUR_PIECE_ACCORD_BENEFICIAIRE"));
            Piecejointe::create([
                'type_piece'=>env("VALEUR_PIECE_ACCORD_BENEFICIAIRE"),
                  'entreprise_id'=>$entreprise->id,
                  'url'=>$accord_beneficiaire,
              ]);
        }
            return redirect()->back();

 }
    public function save_result_kyc(Request $request){
        $entreprise= Entreprise::find($request->entreprise);
        $date_result_kyc= date('Y-m-d', strtotime($request->date_result_kyc));
        $entreprise->update([
                'date_realisation_kyc'=> $date_result_kyc,
                'resultat_kyc'=>$request->result_kyc 
        ]);
        return redirect()->back();
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->validate($request, [
    		'entreprise_id'=>'unique:projets,entreprise_id',
    	]);
        $designations = $request->designation;
        $couts = $request->cout;
        $montant_total= 0;
        $entreprise= Entreprise::find($request->entreprise);
        foreach($couts as $cout){
                $montant_total = $montant_total + reformater_montant2($cout);
        }
    //dd($montant_total);
    //Contrôle pour le montant maximum 
if($request->hasFile('synthese_plan_de_continute')&& $request->hasFile('attestation_de_formation')&&$request->hasFile('synthese_plan_de_continute')){
   if((($entreprise->aopOuleader=='aop' ||$entreprise->aopOuleader=='leader') && $montant_total >60000000) || ($entreprise->aopOuleader=='mpme' && $montant_total >18000000)  )
        {
            flash("Verifier le montant du projet. Il ne doit pas être supérieur au plafond accordé par le projet")->error();
            return redirect()->back();
        }
    elseif((($entreprise->aopOuleader=='aop' || $entreprise->aopOuleader=='leader') && $montant_total < 18000000)|| ($entreprise->aopOuleader=='mpme' && $montant_total <6000000)  )
    {
        flash("Verifier le montant du projet. Il ne doit pas être inférieur au planché accordé par le projet suivant la catégorie de votre entreprise !!!")->error();
        return redirect()->back();
    }
        else{
            ($entreprise->region_affectation == null )?($zone= $entreprise->region):($zone=$entreprise->region_affectation );
            $promoteur = Promotrice::where('code_promoteur',Auth::user()->code_promoteur)->first();
            $proportiondedepence=Proportion_de_depense_promotrice::where('promotrice_id', $promoteur->id )->get();
            $annees=Valeur::where('parametre_id',16 )->get();
            $entreprise->update([
                'banque_id' => $request->banque_choisi
             ]);
            $projet = Projet::create([
                'entreprise_id' => $request->entreprise,
                'coach_id' => $request->coach,
                'zone_affectation'=> $zone,
                'titre_du_projet' => $request->titre_du_projet,
                'objectifs'  => $request->titre_du_projet,
                'activites_menees'  => $request->activite_menee,
                'atouts_promoteur'  => $request->atouts_entreprise,
                'innovation'  =>$request->innovations_apportes,
                'statut'  =>"soumis",
                'type_entreprise' =>$entreprise->aopOuleader
            ]);
            for($i=0; $i<count($designations); $i++){
                     if($designations[$i]!="" && $couts[$i]!="" && reformater_montant2($request->subvention[$i])!=null){
                        InvestissementProjet::create([
                            "projet_id"=>$projet->id,
                            "designation"=>$designations[$i],
                            "montant"=>reformater_montant2($couts[$i]),
                            "apport_perso"=>reformater_montant2($request->apport_perso[$i]),
                            "subvention_demandee"=>reformater_montant2($request->subvention[$i])
                        ]);
                   }
            }
            $projet->update([
                'montant_demande'=>$projet->investissements->sum('montant')
            ]);
               if ($request->hasFile('plan_de_continute')) {
                $this->supprimer_doublon_de_pj($entreprise->id, env("VALEUR_ID_DOCUMENT_PCA"));
                $file = $request->file('plan_de_continute');
                $extension=$file->getClientOriginalExtension();
                $fileName = $entreprise->code_promoteur.'_'.'plan_de_continute'.'.'.$extension;
                $emplacement='public/pca'; 
                $urlplan_de_continute= $request['plan_de_continute']->storeAs($emplacement, $fileName);
                Piecejointe::create([
                    'type_piece'=>env("VALEUR_ID_DOCUMENT_PCA"),
                    'entreprise_id'=>$request->entreprise,
                    'url'=>$urlplan_de_continute,
                  ]);
            }
            else{
                $urlplan_de_continute=null;
            }
            if ($request->hasFile('synthese_plan_de_continute')) {
                $this->supprimer_doublon_de_pj($entreprise->id, env("VALEUR_ID_DOCUMENT_SYNTHESE_PCA"));
                $file = $request->file('synthese_plan_de_continute');
                $extension=$file->getClientOriginalExtension();
                $fileName = $entreprise->code_promoteur.'_'.'synthese_plan_de_continute'.'.'.$extension;
                $emplacement='public/synthese_pca'; 
                $urlsynthese_plan_de_continute= $request['synthese_plan_de_continute']->storeAs($emplacement, $fileName);
                Piecejointe::create([
                    'type_piece'=>env("VALEUR_ID_DOCUMENT_SYNTHESE_PCA"),
                      'entreprise_id'=>$request->entreprise,
                      'url'=>$urlsynthese_plan_de_continute,
                  ]);
            }
            else{
                $urlsynthese_plan_de_continute=null;
            }
            if ($request->hasFile('devis_des_investissements')) {
                $this->supprimer_doublon_de_pj($entreprise->id, env("VALEUR_ID_DOCUMENT_DEVIS"));
                $file = $request->file('devis_des_investissements');
                $extension=$file->getClientOriginalExtension();
                $fileName = $entreprise->code_promoteur.'_'.'devis_des_investissements'.'.'.$extension;
                $emplacement='public/devis_des_investissement_ala_soumission'; 
                $urldevis_des_investissements= $request['devis_des_investissements']->storeAs($emplacement, $fileName);
                Piecejointe::create([
                    'type_piece'=>env("VALEUR_ID_DOCUMENT_DEVIS"),
                      'entreprise_id'=>$request->entreprise,
                      'url'=>$urldevis_des_investissements,
                  ]);
            }
            else{
                $urldevis_des_investissements=null;
            }
            if ($request->hasFile('copie_document_foncier')) {
                $this->supprimer_doublon_de_pj($entreprise->id, env("VALEUR_ID_DOCUMENT_FONCIER"));
                $file = $request->file('copie_document_foncier');
                $extension=$file->getClientOriginalExtension();
                $fileName = $entreprise->code_promoteur.'_'.'copie_document_foncier'.'.'.$extension;
                $emplacement='public/foncier'; 
                $urlcopie_document_foncier= $request['copie_document_foncier']->storeAs($emplacement, $fileName);
                Piecejointe::create([
                    'type_piece'=>env("VALEUR_ID_DOCUMENT_FONCIER"),
                      'entreprise_id'=>$request->entreprise,
                      'url'=>$urlcopie_document_foncier,
                  ]);
            }
            else{
                $urlcopie_document_foncier=null;
            }
            if ($request->hasFile('attestation_de_formation')) {
                $this->supprimer_doublon_de_pj($entreprise->id, env("VALEUR_ID_DOCUMENT_ATTESTATION"));
                $file = $request->file('attestation_de_formation');
                $extension=$file->getClientOriginalExtension();
                $fileName = $entreprise->code_promoteur.'_'.'attestation_de_formation'.'.'.$extension;
                $emplacement='public/attestation_de_formation'; 
                $urlattestation_de_formation= $request['attestation_de_formation']->storeAs($emplacement, $fileName);
                Piecejointe::create([
                    'type_piece'=>env("VALEUR_ID_DOCUMENT_ATTESTATION"),
                      'entreprise_id'=>$request->entreprise,
                      'url'=>$urlattestation_de_formation,
                  ]);
            }
            else{
                $urlattestation_de_formation=null;
            }
               if($request->afficherproportion == 1){
                $proportiondedepences= Valeur::where('parametre_id', 31)->get();
                $nombre_de_clients= Valeur::where('id', 7085)->get();
                $annees=Valeur::where('parametre_id',16 )->get();
                foreach($proportiondedepences as $proportion){
                    foreach($annees as $annee){
                        $variable=$proportion->id.$annee->id;
                $nombre_proportion_depenses=  Proportion_de_depense_promotrice::where(['promotrice_id'=>$promoteur->id,'proportion_id'=>$proportion->id,'annee_id'=>$annee->id ])->count();
                    if($nombre_proportion_depenses == 0){
                        Proportion_de_depense_promotrice::create([
                            "proportion_id"=>$proportion->id,
                            "annee_id"=>$annee->id,
                            "pourcentage"=>$request->$variable,
                            "promotrice_id"=>$promoteur->id,
                        ]);
                    }
                       
                    }
                }
                foreach($nombre_de_clients as $nombre_de_client){
                    foreach($annees as $annee){
                        $variable=$nombre_de_client->id.$annee->id;
                        $nombre_de_ligne_de_nombre_de_client=  Infoentreprise::where(['entreprise_id'=>$request->entreprise,'indicateur'=>$nombre_de_client->id,'annee'=>$annee->id ])->count();
                    if($nombre_de_ligne_de_nombre_de_client ==0){
                        Infoentreprise::create([
                            "indicateur"=>$nombre_de_client->id,
                            "annee"=>$annee->id,
                            "quantite"=>$request->$variable,
                            "entreprise_id"=>$request->entreprise,
                            "code_promoteur"=>$promoteur->code_promoteur,
                        ]);
                    }
                      
                    }
                }
            }

        flash("Projet soumis avec success !!!")->success();
               return redirect()->route('profil.beneficiaire');
        }
    }
    else{
        flash("Erreur de chargement des pieces jointes.Bien vouloir reprendre la création du projet !!!")->error();
               return redirect()->route('profil.beneficiaire');
    }
       
    }
public function lister_les_demandes_de_kyc(Request $request){
    if($request->type_entreprise=='mpme'){
        $demande_de_kycs= Entreprise::where('date_demande_kyc','!=',null)->where('aopOuleader','mpme')->get();
        $type_entreprise='pca_mpme';
    }
    else{
        $demande_de_kycs= Entreprise::where('date_demande_kyc','!=',null)->whereIn('aopOuleader',['aop','leader'])->get();
        $type_entreprise='pca_aop';
    }
    
    return view('projet.demande_kyc', compact('demande_de_kycs','type_entreprise'));
}
public function save_fiche_danalyse(Request $request){
    $fiche_danalyse= Piecejointe::where('type_piece',env("VALEUR_ID_FICHE_DANALYSE"))->where('entreprise_id',$request->entreprise )->first();
    if($fiche_danalyse){
        $fiche_danalyse->delete();
    }
        if ($request->hasFile('fiche_danalyse')) {
            $file = $request->file('fiche_danalyse');
            $extension=$file->getClientOriginalExtension();
            $fileName = $entreprise->code_promoteur.'_'.'fiche_danalyse'.'.'.$extension;
            $emplacement='public/fiche_danalyse_de_PCA'; 
            $urlfiche_danalyse= $request['fiche_danalyse']->storeAs($emplacement, $fileName);
            Piecejointe::create([
              'type_piece'=>env("VALEUR_ID_FICHE_DANALYSE"),
                'entreprise_id'=>$request->entreprise,
                'url'=>$urlfiche_danalyse,
             ]);
            $projet = Projet::find($request->projet);
            $projet->update([
                'statut'=>'analyse',
                'motif_du_rejet_de_lanalyse'=>''
             ]);
        }
        return redirect('/administrator/lister_les_pca?statut=soumis');
}
public function valider_analyse(Request $request){
if (Auth::user()->can('valider_analyse_pca')) {
    $projet= Projet::find($request->projet_id);
    if($request->raison){
      $ok=  $projet->update([
            'motif_du_rejet_de_lanalyse'=>$request->raison,
            'statut'=>'soumis',
            'avis_chefdezone'=>null,
            'observation_chefdezone'=>null
        ]);
        EvaluationPca::where('projet_id', $projet->id)->delete();
       $grille= Piecejointe::where('type_piece',env("VALEUR_ID_DOCUMENT_GRILLEEVAL"))->where('entreprise_id',$projet->entreprise->id)->first();
       if($grille){
            $grille->delete();
       }

     
    }
    else{
        $projet->update([
            'motif_du_rejet_de_lanalyse'=>'',
            'statut'=>'a_affecter_au_membre_du_comite'
        ]);
    }
    
    return redirect('/administrator/lister_les_pca?statut=analyse');
}
else{
    flash("Vous n'avez pas ce droit d'access bien vouloir contacter l'administrateur !!!")->error();
    return redirect()->back();
 }
}
// Cette fonction permet au chef de zone de donner son avis sur un pca
public function pca_save_avis_chefdezone(Request $request){
    $projet= Projet::find($request->projet_id);
        $projet->update([
            'avis_chefdezone'=>$request->avis,
            'observation_chefdezone'=>$request->observation,
        ]);
    return redirect('/administrator/lister_les_pca?statut=analyse');
}
public function pca_save_avis_ugp(Request $request){
    $projet= Projet::find($request->projet_id);
        $projet->update([
            'avis_ugp'=>$request->avis,
            'observation_ugp'=>$request->observation,
        ]);
    return redirect('/administrator/lister_les_pca?statut=analyse');
}
public function put_pca_to_liste_dattente(Request $request){
    $projet=Projet::find($request->projet_id);
    $projet->update([
        'liste_dattente_observations'=>$request->observation,
    ]);
}
public function savedecisioncomite(Request $request){
    $projet=Projet::find($request->projet_id);
//En cas de validation sans statuer sur les lignes dinvestissments toutes les lignes sont automatiquement validées
    if($request->avis=='selectionné'){
       // dd($projet->investissements);
        foreach($projet->investissements as $investissement){
            if($investissement->statut==null){
                $investissement->update([
                    'statut'=>'validé',
                    'montant_valide'=>$investissement->montant,
                    'apport_perso_valide'=> $investissement->apport_perso,
                    'subvention_demandee_valide'=> $investissement->subvention_demandee,
                ]);
               
            }
        }
    }else{
        foreach($projet->investissements as $investissement){
            if($investissement->statut==null){
                $investissement->update([
                    'statut'=>'rejeté'
                ]);
            }
        }

    }
    $projet->update([
        'statut'=>$request->avis,
        'observations'=>$request->observation,
        'montant_accorde'=>$projet->investissementvalides->sum('montant_valide')
    ]);
$entreprise= $projet->entreprise;
$entreprise->update([
    'verdit_pca'=>$request->avis,
   
]);


return redirect('administrator/lister_les_pca?statut=a_affecter_au_membre_du_comite');
}


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function analyser(Projet $projet)
    {
        $piecejointes=Piecejointe::where("entreprise_id",$projet->entreprise->id)->whereIn('type_piece', [env("VALEUR_ID_DOCUMENT_PCA"), env("VALEUR_ID_DOCUMENT_SYNTHESE_PCA"), env("VALEUR_ID_DOCUMENT_DEVIS"),env("VALEUR_ID_DOCUMENT_FONCIER"),env("VALEUR_ID_DOCUMENT_ATTESTATION"), env("VALEUR_ID_FICHE_DANALYSE"), env("VALEUR_ID_DOCUMENT_GRILLEEVAL")])->orderBy('updated_at', 'desc')->get();
        $piecejointes= $piecejointes->unique('type_piece');
        $categorie_investissments=Valeur::where('parametre_id', 38)->get();
    if($projet->entreprise->aopOuleader=='aop'|| $projet->entreprise->aopOuleader=='leader'){
        $criteres= GrilleEval::where('categorie','pa')->get();
    }
    else{
        $criteres= GrilleEval::where('categorie','PCA')->get();
    }
        return view("projet.analyse", compact('projet', 'piecejointes', 'criteres', 'categorie_investissments'));
    }

    public function show(Projet $projet)
    {
        $piecejointes=Piecejointe::where("entreprise_id",$projet->entreprise->id)->whereIn('type_piece', [env("VALEUR_ID_DOCUMENT_PCA"), env("VALEUR_ID_DOCUMENT_SYNTHESE_PCA"), env("VALEUR_ID_DOCUMENT_DEVIS"),env("VALEUR_ID_DOCUMENT_FONCIER"),env("VALEUR_ID_DOCUMENT_ATTESTATION"), env("VALEUR_ID_FICHE_DANALYSE")])->orderBy('updated_at', 'desc')->get();
        $piecejointes= $piecejointes->unique('type_piece');
    if($projet->entreprise->aopOuleader=='aop'|| $projet->entreprise->aopOuleader=='leader'){
        $criteres= GrilleEval::where('categorie','pa')->get();
    }
    else{
        $criteres= GrilleEval::where('categorie','PCA')->get();
    }
    //dd($criteres);
        return view("projet.show", compact('projet', 'piecejointes', 'criteres'));
    }
public function valider_investissement(Request $request)
{
    $invest= InvestissementProjet::find($request->invest_id);
    $entreprise= $invest->projet->entreprise;
    $projet= $invest->projet;
    $montant_total_valide= $projet->investissements->sum('montant_valide')  + reformater_montant2($request->cout);
    $montant_total= ($projet->investissements->sum('montant_valide') ) + reformater_montant2($request->cout);
    $ligne_investissement_sans_statuts= InvestissementProjet::where('projet_id',$invest->projet->id)->where('statut',null)->get();
    $nombre_ligne_investissement_sans_statuts = count($ligne_investissement_sans_statuts);
if((($entreprise->aopOuleader=='aop' ||$entreprise->aopOuleader=='leader') && $montant_total_valide > 60000000)|| ($entreprise->aopOuleader=='mpme' && $montant_total_valide >18000000)  )
{
        flash("Verifier le montant du projet. Il ne doit pas être supérieur au plafond accordé par le projet")->error();
        return redirect()->back();
}
elseif((($entreprise->aopOuleader=='aop' ||$entreprise->aopOuleader=='leader') && $montant_total < 9000000 &&  $nombre_ligne_investissement_sans_statuts==1 )|| ($entreprise->aopOuleader=='mpme' && $montant_total < 6000000 &&  $nombre_ligne_investissement_sans_statuts==1 )  )
{
    flash("Verifier le montant du projet. Il ne doit pas être inférieur au planché accordé par le projet suivant la catégorie de votre entreprise !!!")->error();
    return redirect()->back();
}
    else{
    $invest->update([
        'designation'=> $request->designation,
        'montant_valide'=> reformater_montant2($request->cout),
        'apport_perso_valide'=> reformater_montant2($request->apport_perso),
        'subvention_demandee_valide'=> reformater_montant2($request->subvention),
        'statut' => 'validé'
    ]);
    // $projet->update([
    //     'montant_accorde'=>$projet->investissementvalides->sum('montant')
    //  ]);
    flash("Lignes d'investissement validée avec success !!!")->success();
    return redirect()->back();
}
}
public function add_investissement(Request $request){
$projet= Projet::find($request->projet_id);
$projet_montant= $projet->investissements->sum('montant')  + reformater_montant2($request->cout);
if((($projet->entreprise->aopOuleader=='aop' ||$projet->entreprise->aopOuleader=='leader') && $projet_montant >60000000)|| ($projet->entreprise->aopOuleader=='mpme' && $projet_montant >18000000)  )
    {
        flash("Verifier le montant du projet. Il ne doit pas être supérieur au plafond accordé par le projet")->error();
        return redirect()->back();
    }
    elseif((($projet->entreprise->aopOuleader=='aop' ||$projet->entreprise->aopOuleader=='leader') && $projet_montant < 18000000)|| ($projet->entreprise->aopOuleader=='mpme' && $projet_montant <6000000)  )
    {
    flash("Verifier le montant du projet. Il ne doit pas être inférieur au planché accordé par le projet suivant la catégorie de votre entreprise !!!")->error();
    return redirect()->back();
    }
else{   
    InvestissementProjet::create([
        'projet_id'=>$request->projet_id,
        'designation'=>$request->designation,
        'montant'=>reformater_montant2($request->cout),
        'subvention_demandee'=>reformater_montant2($request->subvention),
        'apport_perso'=>reformater_montant2($request->apport_perso),
    ]);
    return redirect()->back();
}
}
public function rejetter_investissement(Request $request){
    //dd($request->all());
    $invest= InvestissementProjet::find($request->invest_id);
    $invest->update([
        'statut' => 'rejeté'
    ]);
    return redirect()->back();

}
public function invest_modif(Request $request){
    $investissement= InvestissementProjet::find($request->id);
    $data = array(
     'id'=>$investissement->id,
     'categorie'=>$investissement->designation,
     'cout'=>$investissement->montant,
     'subvention'=>$investissement->subvention_demandee,
     'apport_perso'=>$investissement->apport_perso,
 );
 return json_encode($data);
}
public function invest_modifier(Request $request){
    $invest= InvestissementProjet::find($request->invest_id);
    $projet= Projet::find($invest->projet_id);
$projet_montant= $projet->investissements->sum('montant') -  $invest->montant + reformater_montant2($request->cout);
if((($projet->entreprise->aopOuleader=='aop' ||$projet->entreprise->aopOuleader=='leader') && $projet_montant >60000000)|| ($projet->entreprise->aopOuleader=='mpme' && $projet_montant >18000000)  )
{
    flash("Verifier le montant du projet. Il ne doit pas être supérieur au plafond accordé par le projet")->error();
    return redirect()->back();
}
elseif((($projet->entreprise->aopOuleader=='aop' ||$projet->entreprise->aopOuleader=='leader') && $projet_montant < 18000000)|| ($projet->entreprise->aopOuleader=='mpme' && $projet_montant <6000000)  )
{
flash("Verifier le montant du projet. Il ne doit pas être inférieur au planché accordé par le projet suivant la catégorie de votre entreprise !!!")->error();
return redirect()->back();
}
else{
    $invest->update([
        'designation' => $request->designation,
        'montant'=> reformater_montant2($request->cout),
        'apport_perso'=> reformater_montant2($request->apport_perso),
        'subvention_demandee'=> reformater_montant2($request->subvention)
    ]);

    $projet->update([
        'montant_demande' => $projet->investissements->sum('montant')
    ]);
    flash("La ligne d'investissement a été modifié avec success")->success();
    return redirect()->back();
}
    
       
}
public function pca_modif(Request $request){
    $projet= Projet::find($request->id);
    $data = array(
     'id'=>$projet->id,
     'banque_id' => $projet->entreprise->banque_id,
     'coach_id' => $projet->coach_id,
     'titre_du_projet'=>$projet->titre_du_projet,
     'objectifs'=>$projet->objectifs,
     'activites_menees'=>$projet->activites_menees,
     'atout_promoteur'=>$projet->atouts_promoteur,
     'innovation'=>$projet->innovation,
 );
 return json_encode($data);
}
public function pca_modifier(Request $request){
    $projet= Projet::find($request->pca_id);
        $projet->update([
            'coach_id' => $request->coach,
            'titre_du_projet' => $request->titre_projet,
            'objectifs' => $request->objectifs,
            'activites_menees'  => $request->activite_menee,
            'atouts_promoteur'  => $request->atouts_entreprise,
            'innovation'  =>$request->innovations_apportes,
        ]);
    $projet->entreprise->update([
        'banque_id'=>$request->banque_choisi,
    ]);
        return redirect()->back();
}
public function storeaval(Request $request){

if (Auth::user()->can('lister_pca_chef_de_zone')) {
    $projet= Projet::find( $request->projet);
    if ($request->hasFile('grille_devaluation')) {
        $file = $request->file('grille_devaluation');
        $extension=$file->getClientOriginalExtension();
        $fileName = $projet->entreprise->code_promoteur.'_'.'fiche_devaluation'.'.'.$extension;
        $emplacement='public/grilleEval'; 
        $urlpiece= $request['grille_devaluation']->storeAs($emplacement, $fileName);
      $pj=  Piecejointe::create([
          'type_piece'=> env("VALEUR_ID_DOCUMENT_GRILLEEVAL"),
            'entreprise_id'=>$projet->entreprise->id,
            'url'=>$urlpiece,
        ]);
    }

if($pj){

    if($projet->entreprise->aopOuleader=='aop'|| $projet->entreprise->aopOuleader=='leader'){
        $criteres= GrilleEval::where('categorie','PA')->get();
    }
    else{
        $criteres= GrilleEval::where('categorie','PCA')->get();
    }
    foreach($criteres as $critere){
        $note= $critere->id;
    //S'assurer de l'unicité de l'evaluation par projet et par critere
    $nombre_devaluation_du_projet = EvaluationPca::where(['projet_id'=>$request->projet,'grilleeval_id'=> $critere->id,])->count();
    if($nombre_devaluation_du_projet==0){
        EvaluationPca::create([
            'projet_id'=> $request->projet,
            'grilleeval_id'=> $critere->id,
            'note'=> $request->$note
    ]);
    }        
    }
    
    $projet->update([
        'statut'=>'analyse',
        'motif_du_rejet_de_lanalyse'=>''
     ]);
     flash("Le Dossier a été évalué avec success")->success();
     return redirect()->route('projet.liste', array('statut' => 'soumis'));
}
else{
    flash("Bien vouloir joindre la grille d'evaluation !!!")->error();
    return redirect()->back();
}
}
else{
    flash("Vous n'avez pas ce droit d'acces bien vouloir contacter l'administrateur !!!")->error();
    return redirect()->back();
}

}
public function add_piecej_to_projet(Request $request){
   // dd($request->projet_id);
    $projet= Projet::find($request->projet_id);
    $type_piece=$request->type_piece;
if($type_piece==env('VALEUR_ID_DOCUMENT_DEVIS')){
    $file = $request->file('piece_file');
    $extension=$file->getClientOriginalExtension();
    $fileName = Auth::user()->code_promoteur.'_'.'devis_des_investissements'.'.'.$extension;
    $chaine='public/devis_des_investissement_ala_soumission'; 
}
elseif( $type_piece==env('VALEUR_ID_DOCUMENT_PCA')){
    $file = $request->file('piece_file');
    $extension=$file->getClientOriginalExtension();
    $fileName = Auth::user()->code_promoteur.'_'.'plan_de_continute'.'.'.$extension;
    $chaine='public/pca';
}
elseif( $type_piece==env('VALEUR_ID_DOCUMENT_SYNTHESE_PCA')){
    $file = $request->file('piece_file');
    $extension=$file->getClientOriginalExtension();
    $fileName = Auth::user()->code_promoteur.'_'.'synthese_plan_de_continute'.'.'.$extension;
    $chaine='public/synthese_pca'; 
}
elseif($type_piece==env('VALEUR_ID_DOCUMENT_FONCIER')){
    $file = $request->file('piece_file');
    $extension=$file->getClientOriginalExtension();
    $fileName = Auth::user()->code_promoteur.'_'.'copie_document_foncier'.'.'.$extension;
    $chaine='public/foncier';

}
elseif($type_piece==env('VALEUR_ID_DOCUMENT_ATTESTATION')){
    $file = $request->file('piece_file');
    $extension=$file->getClientOriginalExtension();
    $fileName = Auth::user()->code_promoteur.'_'.'attestation_de_formation'.'.'.$extension;
    $chaine='public/attestation_de_formation';

}
    $urlpiece= $request['piece_file']->storeAs($chaine, $fileName);
if ($request->hasFile('piece_file')) {
          Piecejointe::create([
            'type_piece'=>$type_piece,
              'entreprise_id'=>$projet->entreprise->id,
              'url'=>$urlpiece,
          ]);
 }
return redirect()->back();

}

public function modif_piecej(Request $request){
    $piecejointe= Piecejointe::find($request->id);
    $data = array(
     'id'=>$piecejointe->id,
     'type_piece'=>$piecejointe->type_piece
 );
 return json_encode($data);

}
public function modifier_piecej(Request $request){
    $piecejointe= Piecejointe::find($request->piece_id);
    $piecejointe_type=$piecejointe->type_piece;
if($piecejointe->type_piece==env('VALEUR_ID_DOCUMENT_DEVIS')){
    $file = $request->file('piece_file');
    $extension=$file->getClientOriginalExtension();
    $fileName = Auth::user()->code_promoteur.'_'.'devis_des_investissements'.'.'.$extension;
    $chaine='public/devis_des_investissement_ala_soumission'; 
}
elseif( $piecejointe->type_piece==env('VALEUR_ID_DOCUMENT_PCA')){
    $file = $request->file('piece_file');
    $extension=$file->getClientOriginalExtension();
    $fileName = Auth::user()->code_promoteur.'_'.'plan_de_continute'.'.'.$extension;
    $chaine='public/pca';
}
elseif( $piecejointe->type_piece==env('VALEUR_ID_DOCUMENT_SYNTHESE_PCA')){
    $file = $request->file('piece_file');
    $extension=$file->getClientOriginalExtension();
    $fileName = Auth::user()->code_promoteur.'_'.'synthese_plan_de_continute'.'.'.$extension;
    $chaine='public/synthese_pca'; 
}
elseif($piecejointe->type_piece==env('VALEUR_ID_DOCUMENT_FONCIER')){
    $file = $request->file('piece_file');
    $extension=$file->getClientOriginalExtension();
    $fileName = Auth::user()->code_promoteur.'_'.'copie_document_foncier'.'.'.$extension;
    $chaine='public/foncier';

}
elseif($piecejointe->type_piece==env('VALEUR_ID_DOCUMENT_ATTESTATION')){
    $file = $request->file('piece_file');
    $extension=$file->getClientOriginalExtension();
    $fileName = Auth::user()->code_promoteur.'_'.'attestation_de_formation'.'.'.$extension;
    $chaine='public/attestation_de_formation';
}
    if ($request->hasFile('piece_file')) {
        $urlpiece= $request->piece_file->storeAs($chaine,$fileName);
        $piecejointe->update([
              'url'=>$urlpiece,
          ]);
    }
return redirect()->back();
}
public function liste_des_devis_asuivre_par_projet(Projet $projet){
    $devis = Devi::where('entreprise_id', $projet->entreprise->id)->get();
    return view('devi.listeasuivre',compact('devis'));
}

public function save_desistement_projet(Projet $projet, Request $request){
    //dd($projet);
if($projet->entreprise->accomptes()->sum('montant') == 0){
    $file = $request->file('declaration_desistement');
    $extension=$file->getClientOriginalExtension();
    $fileName = $projet->entreprise->code_promoteur.'.'.$extension;
    $chaine='public/declaration_desistement';
    $chaine= $request['declaration_desistement']->storeAs($chaine, $fileName);

    Piecejointe::create([
        'type_piece'=>env("VALEUR_PIECE_DECLARATION_DESISTEMENT"),
          'entreprise_id'=>$projet->entreprise->id,
          'url'=>$chaine,
      ]);
      foreach($projet->investissements as $investissement){
       // dd($investissement);
            $investissement->update([
                'statut'=>'rejeté',
                'montant_valide'=>0,
                'apport_perso_valide'=> 0,
                'subvention_demandee_valide'=>0,
            ]);
           
    }
    $projet->update([
            'desister'=>1, 
            'montant_accorde'=>0,
            'statut'=>'rejeté'
    ]);
    flash("Le desistement a ete enregistre avec success !!!")->success();
    return redirect()->back();
}
else{
    flash("Impossible d'enregistrer un desistement pour ce projet car un versement a ete fait par la promotrice !!!")->error();
    return redirect()->back();
} 
    
}
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $projet=Projet::find($id);
       dd($projet);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}