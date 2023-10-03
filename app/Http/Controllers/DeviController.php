<?php

namespace App\Http\Controllers;

use App\Models\Devi;
use App\Models\User;
use App\Models\Valeur;
use App\Models\Entreprise;
use App\Models\Piecejointe;
use App\Models\Accompte;
use App\Models\Projet; 
use App\Models\ImageSuivi; 
use App\Models\Prestataire;
use App\Models\Historiquedevi;
use App\Models\SuiviExecutionDevi;
use Illuminate\Http\Request;
use App\Models\InvestissementProjet;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Mail\AnalyseMail;
use function Ramsey\Uuid\v1;

class DeviController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function create_historique($devi_id, $statut, $motif, $observation){
        $date = new \DateTime();
        $date= $date->format('Y-m-d');
        Historiquedevi::create([
                'devis_id'=> $devi_id,
                'user_id'=>Auth::user()->id,
                'statut'=>$statut,
                'date_statut'=>$date,
                'motif'=>$motif,
                'observation'=>$observation
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // Liste de tous les devis
    public function index()
    {
        if (Auth::user()->can('analyser_devis')) {
            $devis = Devi::orderBy('updated_at', 'desc')->get();

            return view("devi.index", compact('devis'));
        }
        else{
            flash("Vous n'avez pas le droit d'acceder à cette resource. Veillez contacter l'administrateur!!!")->error();
            return redirect()->back();
        }

    }
 public function liste_devis_par_promoteur(){
    $prestataires= Prestataire::all();
    $entreprise= Entreprise::where('code_promoteur', Auth::user()->code_promoteur)->where('decision_du_comite_phase1','selectionnee')->first();   
    $devis= Devi::where('user_id', Auth::user()->id)->orderBy('updated_at', 'desc')->get();
    //dd( $entreprise->projet);
    $ligne_projets= InvestissementProjet::where('statut','validé')->where('projet_id', $entreprise->projet->id)->get();
    //dd($ligne_projets);
     return view('public.devis_beneficiaire',compact('ligne_projets',"devis",'entreprise','prestataires','ligne_projets'));
 }
 public function get_montant(Request $request){
    $invest=InvestissementProjet::find($request->invest_id)->montant_valide;
    return  $invest;
 }
 public function devis_de_ma_zone(){
    //Selectionner les entreprises relevants de ma zone et
    // pour les AOP/leader qui sont hors de la zone de couverture du projet les devis sont affectés au chef de zone de Ouaga 
    if (Auth::user()->can('analyser_devis')) {
    $entreprises= Entreprise::where('region', Auth::user()->zone)->orWhere('region_affectation', Auth::user()->zone)->orderBy('updated_at', 'desc')->get('id');
    $devis = Devi::whereIn('entreprise_id', $entreprises)->where('statut', 'soumis')->orderBy('updated_at', 'desc')->get();
    return view("devi.aanalyser", compact('devis'));
}
else{
    flash("Vous n'avez pas le droit d'acceder à cette resource. Veillez contacter l'administrateur!!!")->error();
    return redirect()->back();
}
    
 }
 public function analyse_de_devis(Request $request){
    $statut= $request->statut;
    if($statut){
        $devis = Devi::orderBy('updated_at', 'desc')->where('statut',$statut)->get();
    }
    else{
        $devis = Devi::orderBy('updated_at', 'desc')->get();
    }

    return view("devi.aanalyser", compact('devis'));

 }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('public.create_devis',compact('entreprise'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // dd($request->all());
        if ($request->hasFile('copie_devis') && $request->hasFile('fiche_analyse') && $request->hasFile('copie_devis2') && $request->hasFile('copie_devis1'))  {
            $copie_devis= $request->copie_devis->store('public/devis');
            $fiche_analyse= $request->fiche_analyse->store('public/fiche_danalyse_devis');
            $copie_devis1= $request->copie_devis1->store('public/devis');
            $copie_devis2= $request->copie_devis2->store('public/devis');
        }
        $lastOne = DB::table('devis')->latest('id')->first();
        if($lastOne){
        $code_devis="BWBF-DEV-000". $lastOne->id+1;}
        else{
            $code_devis="BWBF-DEV-000".'0';
        }
        //Faire le point sur la somme des devis de la ligne soumis le montant à soumettre
      // $montant_engange_sur_la_lignedinvestissment= Devi::where('investissement_projets_id',$request->ligne_invest)->sum('montant_devis') +  reformater_montant2($request->montant_devis);
       //Recuperer la ligne d'investissment
   
    //    $ligne_dinvestissement= InvestissementProjet::find($request->ligne_invest);
      // dd($ligne_dinvestissement);
    // if($ligne_dinvestissement->montant_valide >$montant_engange_sur_la_lignedinvestissment || $ligne_dinvestissement->montant_valide ==$montant_engange_sur_la_lignedinvestissment){
        
        $devi=Devi::create([
           // 'investissement_projets_id'=>$request->ligne_invest,
            'designation'=>$request->designation,
            'description'=>$request->description,
            'copie_fiche_analyse'=>$fiche_analyse,
            'prestataire_id'=>$request->prestataire,
            'nom_bank_prestataire'=>$request->nom_bank_prestataire,
            'compte_bank_prestataire'=>$request->compte_bank_prestataire,
            'copie_devis_prefere'=>$copie_devis,
            'montant_devis'=>reformater_montant2($request->montant_devis),
            'montant_avance'=>0,
            'entreprise_id'=>$request->entreprise_id,
            'user_id'=>Auth::user()->id,
            'statut'=>'soumis',
            'nombre_de_paiement'=>$request->nombre_depaiement,
            'copie_devis_1'=>$copie_devis1,
            'copie_devis_2'=>$copie_devis2,
            "numero_devis"=>$code_devis
        ]);
        Insertion_Journal('Devis','Création');

        $chef_de_zone= User::where('zone', $devi->entreprise->region)->orWhere('zone', $devi->entreprise->region_affectation)->first();
        $e_msg="Vous avez des devis qui sont en attentes de validation.";
        $titre='Chef de Zone';
        $mail=$chef_de_zone->email;
        Mail::to($chef_de_zone->email)->queue(new AnalyseMail($titre, $e_msg, 'mails.analyseMail'));
            $this->create_historique($devi->id,'soumis', null,null);
            flash("Devis soumis avec succès avec success !!!")->success();
        return redirect()->route('profil.mesdevis');
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Devi  $devi
     * @return \Illuminate\Http\Response
     */
    public function show(Devi $devi, Request $request)
    {
        Insertion_Journal('Devis','Visualisation');
        $historiques = Historiquedevi::where('devis_id', $devi->id)->orderBy('created_at', 'desc')->get();
        if($request->action=='analyser'){
            $motifs_de_rejects=Valeur::where('parametre_id', 37 )->get();
            return view("devi.analyse", compact("devi", 'historiques','motifs_de_rejects'));
        }
        else{
            return view("devi.show", compact("devi", 'historiques'));
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Devi  $devi
     * @return \Illuminate\Http\Response
     */
    public function edit(Devi $devi)
    {
        dd($devi);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Devi  $devi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Devi $devi)
    {
    }
    public function enr_modification(Request $request){
       
        $devi= Devi::find($request->devi_id);
        
        if($request->fiche_analyse){
            
            $fiche_analyse= $request->fiche_analyse->store('public/fiche_danalyse_devis');
            $devi->update([
                'copie_fiche_analyse'=>$fiche_analyse,
            ]);
        }
        if($request->hasFile('copie_devis2')){
            $copie_devis2= $request->copie_devis2->store('public/devis');
            $devi->update([
                'copie_devis_2'=>$copie_devis2,
            ]);
        }
        if($request->hasFile('copie_devis1')){
            $copie_devis1= $request->copie_devis1->store('public/devis');
            $devi->update([
                'copie_devis_1'=>$copie_devis1,
            ]);
        }
        if($request->hasFile('copie_devis')){
            $copie_devis= $request->copie_devis->store('public/devis');
            $devi->update([
                'copie_devis_prefere'=>$copie_devis,
            ]);
        }
      
        $devi->update([
           // 'investissement_projets_id'=>$request->ligne_invest,
            'designation'=>$request->designation,
            'description'=>$request->description,
            'prestataire_id'=>$request->prestataire,
            'nom_bank_prestataire'=>$request->nom_bank_prestataire,
            'compte_bank_prestataire'=>$request->compte_bank_prestataire,
            'montant_devis'=>reformater_montant2($request->montant_devis),
            'nombre_de_paiement'=>$request->nbre_paiement,
            //'montant_avance'=>reformater_montant2($request->avance_exige),
            'statut'=>"soumis"
        ]);
        Insertion_Journal('Devis','Modification');
       
        $chef_de_zone= User::where('zone', $devi->entreprise->region)->orWhere('zone', $devi->entreprise->region_affectation)->first();
        $e_msg="Vous avez des devis qui sont en attentes de validation.";
        $titre='Chef de Zone';
        $mail=$chef_de_zone->email;
        Mail::to($chef_de_zone->email)->queue(new AnalyseMail($titre, $e_msg, 'mails.analyseMail'));
        flash("Devis modifié avec succès avec success !!!")->success();
        return redirect()->route('profil.mesdevis');
    //  }
    //  else{
    //     flash("Vous avez depassé le montant de la ligne d'investissement !!!")->error();
    //     return redirect()->route('profil.mesdevis');
    // }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Devi  $devi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Devi $devi)
    {
        //
    }
    public function telechargerdevis( Request $request, $url)
    { 
        $devi= Devi::find($url);
        if($request->file=='fiche'){
            return $path = Storage::download($devi->copie_fiche_analyse);
        }
        if($request->file=='devi'){
            return $path = Storage::download($devi->copie_devis_prefere);
        }
        if($request->file=='devi1'){
            return $path = Storage::download($devi->copie_devis_1);
        }
        if($request->file=='devi2'){
            return $path = Storage::download($devi->copie_devis_2);
        }
        
    }
    public function modifier(Request $request){
           $devi= Devi::find($request->id);
           ($devi->observation == null )?($bservation=' '):($bservation=$devi->observation );
           $data = array(
            'id'=>$devi->id,
            'designation'=>$devi->designation,
            'description'=>$devi->description,
            'prestataire_id' => $devi->prestataire->id,
            // 'nom_complet' => $devi->prestataire->nom_responsable ." ".$devi->prestataire->prenom_responsable. " " .$devi->prestataire->code_prestaire,
            'montant_devis'=>format_prix($devi->montant_devis),
            'montant_devis_cache'=>$devi->montant_devis,
            'montant_avance'=>format_prix($devi->montant_avance),
            'prestataire'=>$devi->prestataire->id,
            'nom_bank_prestataire'=>$devi->nom_bank_prestataire,
            'compte_bank_prestataire'=>$devi->compte_bank_prestataire,
            'url_fiche_analyse'=>$devi->copie_fiche_analyse,
            'copie_devis_prefere'=>$devi->copie_devis_prefere,
            'copie_devis_1'=>$devi->copie_devis_1,
            'copie_devis_2'=>$devi->copie_devis_2,
            'nbre_paiement'=>$devi->nombre_de_paiement,
            'statut'=>$devi->statut,
            'observation'=>$bservation,
            'description'=>$devi->description,
            'motif'=>getlibelle($devi->motif_du_rejet),
        );
        return json_encode($data);
    }
    public function changerStatus(Request $request)
    {
    if (Auth::user()->can('analyser_devis')) {
        $id_devi= $request->devi_id;
        $devi=Devi::find($id_devi);
        //Ici nous Verifions si le totale de la contre partie a été versée avant de valider le devis
        $montant_total_des_accomptes_verses_par_entreprise=Accompte::where('entreprise_id', $devi->entreprise->id)->sum('montant');
        $montant_total_accorde_du_projet_de_lentreprise=Projet::where('entreprise_id', $devi->entreprise->id)->sum('montant_accorde');

        $mail_promotrice=$devi->entreprise->promotrice->email_promoteur;
        $chef_de_zone= User::where('zone', $devi->entreprise->region)->orWhere('zone', $devi->entreprise->region_affectation)->first();
        $e_msg="Vous avez des devis qui sont en attentes de validation.";
        $titre='Chef de Zone';
        $mail=$chef_de_zone->email;
       // $e_msg="Vous avez des devis qui sont en attentes de validation.";
        ($devi->statut == 'soumis')?($action='chef_de_zone'):($action='autre');
        if($request->raison || $request->observation){
            if($devi->statut=='transmis_au_chef_de_projet'){
                $new_statut='soumis';
                $titre='Chef de Zone';
                //$mail= $mail_chef_de_zone;
            }
            else{
                $new_statut='rejeté';
                $titre='Promotrice';
                $e_msg="Votre devis à été rejeté. Bien vouloir prendre en compte les amendements et les resoumettre";
                $mail=$mail_promotrice;
            }
               $devi->update([
                   'statut'=>$new_statut,
                   'motif_du_rejet'=>$request->raison, 
                   'observation'=> $request->observation,  
               ]);
            $this->create_historique($devi->id, $new_statut, $request->raison, $request->observation );
        }
        else{
            if($devi->statut=='soumis'){
                $new_statut='transmis_au_chef_de_projet';
                $titre='Chef de projet';
                $mail= env('emailChefdeProjet');
            }
            elseif($devi->statut =='transmis_au_chef_de_projet'){
                if($montant_total_accorde_du_projet_de_lentreprise > $montant_total_des_accomptes_verses_par_entreprise *2){
                    flash("Ce devis ne peut etre validé car la mobilisation de la contrepartie n'est pas terminée !!!")->error();
                    return 0;
                }
                else{
                    $new_statut='validé';
                    $titre='Chef de Zone';
                    $e_msg="Votre devis à été validée. Merci de consulter la plateforme.";
                    $mail=$mail_promotrice;
                    
                }
            }
            
        
            $devi->update([
                'statut'=>$new_statut
            ]);
            Insertion_Journal('Devis','Modification');
            $this->create_historique($devi->id, $new_statut, null, null);
        }
        Mail::to($mail)->queue(new AnalyseMail($titre, $e_msg, 'mails.analyseMail'));
        flash("Devis validée avec succès avec success !!!")->success();
        return $action;
    }
    else{
        flash("Vous n'avez pas le droit d'acceder à cette resource. Veillez contacter l'administrateur!!!")->error();
        return redirect()->back();
    }
    
    }
public function listerASuivre(){
    $entreprises= Entreprise::where('region', Auth::user()->zone)->orWhere('region_affectation', Auth::user()->zone)->orderBy('updated_at', 'desc')->get('id');
    $devis = Devi::where('statut', 'validé')->orderBy('updated_at', 'desc')->get();
    return view('devi.listeasuivre',compact('devis'));
}
public function suivreDevis(Devi $devis){
if(Auth::user()->can('update_suivi_execution_devis')){
   $suivi_devis= SuiviExecutionDevi::where('devi_id',$devis->id)->get();
   $observation_types=Valeur::where('parametre_id', 42 )->get();
   return view('devi.suivis', compact('suivi_devis','devis','observation_types'));
}
else{
    flash("Desolé vous n'avez pas les droits requis pour faire cette action. !!!")->error();
    return redirect()->back();
}
}
public function store_suiviDevis(Request $request){

if(Auth::user()->can('update_suivi_execution_devis')){
    $champ_nombre_dimage = $request->champ_nombre_dimage;
    $date_visite= date('Y-m-d', strtotime($request->date_visite));
    $devis= Devi::find($request->devis_id);
    $suivi_devis=  SuiviExecutionDevi::create([
        'devi_id' => $request->devis_id,
        'taux_de_realisation' => $request->taux_de_realisation,
        'date_visite' =>  $date_visite,
        'observation_type' => $request->observation_type,
        'observation'=> $request->observation
    ]);   
for($i=1; $i<$champ_nombre_dimage+1; $i++){
    if($request->hasFile('image'.$i)){
        $inputname='image'.$i;
        if($request->hasFile($inputname)){
            $file = $request->file($inputname);
            $fileName = $file->getClientOriginalName();
            //Definir l'emplacement de sorte à créer un sous repertoire pour chaque entreprise
            $emplacement='public/images_suivi/'.$devis->entreprise->code_promoteur; 
            $image_suivi= $request[$inputname]->storeAs($emplacement, $fileName);
            ImageSuivi::create([
                'suivi_execution_devi_id'=>  $suivi_devis->id,
                'url_image'=>  $image_suivi,
            ]);
        }
    }
}
$suivi_devis->devis->update([
    'taux_de_realisation'=> $request->taux_de_realisation
]);
    Insertion_Journal('suivi_execution_devis','Modification');

    flash("Suivi enregistré avec success. !!!")->success();
    return redirect()->back();
}
else{
    flash("Desolé vous n'avez pas les droits requis pour faire cette action. !!!")->error();
    return redirect()->back();
}
}
public function modifier_suivi_image(Request $request){
    $suivimage= ImageSuivi::find($request->image_id);
    $devi= $suivimage->suivi->devis;
if($request->hasFile('image_bien')){
    $file = $request->file('image_bien');
    $fileName = $file->getClientOriginalName();
    //Definir l'emplacement de sorte à créer un sous repertoire pour chaque entreprise
    $emplacement='public/images_suivi/'.$devi->entreprise->code_promoteur; 
    $image_acquisition= $request['image_bien']->storeAs($emplacement, $fileName);
    $suivimage->update([
        'url_image' =>$image_acquisition
    ]);
}
Insertion_Journal('image_suivis','Modification');

    return redirect()->back();
}
public function suivi_devis_modif(Request $request){
    $suivi_modif= SuiviExecutionDevi::find($request->id);
    $data = array(
        'id'=>$suivi_modif->id, 
        'taux_de_realisation'=>$suivi_modif->taux_de_realisation, 
        'date_visite'=> format_date($suivi_modif->date_visite), 
        'observation'=> $suivi_modif->observation
    );
    return json_encode($data);
}
public function ajouter_image_suivi(Request $request){
    $suivi= SuiviExecutionDevi::find($request->suivi_id);
    $devi= $suivi->devis;
    if($request->hasFile('image_suivi')){
        $file = $request->file('image_suivi');
        $fileName = $file->getClientOriginalName();
        $emplacement='public/images_suivi/'.$devi->entreprise->code_promoteur; 
        $image_suivi= $request['image_suivi']->storeAs($emplacement, $fileName);
        ImageSuivi::create([
            'suivi_execution_devi_id'=>  $suivi->id,
            'url_image'=>  $image_suivi,
        ]);

    }
    return redirect()->back();
   }
public function suivi_devis_modifier(Request $request){
   // dd($request->all());
if(Auth::user()->can('update_suivi_execution_devis')){
    $suivi_modif= SuiviExecutionDevi::find($request->suivi);
    $date_visite= date('Y-m-d', strtotime($request->date_visite));
    $devis= $suivi_modif->devis;
    if($request->hasFile('image_visite')){
        $image_visite= $request->image_visite->store('public/visite_image');
        Piecejointe::create([
            'type_piece'=>env("VALEUR_ID_DOCUMENT_SUIVI_EXECUTION_DEVIS"),
            'entreprise_id'=>$devis->entreprise->id,
            'url'=>$image_visite,
          ]);
    }
    else{
        $image_visite=$suivi_modif->image_realisation;
    }

    $suivi_modif->update([
        'taux_de_realisation' => $request->taux_de_realisation,
        'date_visite' => $date_visite,
        'image_realisation'=> $image_visite,
        'observation_type'=> $request->observation_type,
        'observation'=> $request->observation
    ]);

$suivi_modif->devis->update([
    'taux_de_realisation'=> $request->taux_de_realisation
]);
Insertion_Journal('suivi_execution_devis','Modification');
    flash("Suivi modifié avec success. !!!")->success();
    return redirect()->back();
}
else{
    flash("Desolé vous n'avez pas les droits requis pour faire cette action. !!!")->error();
    return redirect()->back();
}
}
public function edit_de_suivi(SuiviExecutionDevi $suiviExecutionDevi)
{
   $observation_types=Valeur::where('parametre_id', 42 )->get();
    return view('devi.edit_suivi_execution', compact('suiviExecutionDevi','observation_types'));
  // return $path = Storage::download($suiviExecutionDevi->image_realisation);
}
public function visualiser_details_de_suivi(SuiviExecutionDevi $suiviExecutionDevi)
{
    return view('devi.view_suivi', compact('suiviExecutionDevi'));
}

public function verifier_montant_devis(Request $request){
        $montant= $request->montant;
        $entreprise_id= $request->entreprise_id;
        $devis_id= $request->devis_id;
        $entreprise= Entreprise::find($entreprise_id);
        $total_montant_accompte_verse= $entreprise->accomptes()->sum('montant');
        if($devis_id){
            $devi= Devi::find($devis_id);
            $montant_total_devissoumis_par_entreprise = $entreprise->devis()->sum('montant_devis') - $devi->montant_devis;
        }
        else{
            $montant_total_devissoumis_par_entreprise = $entreprise->devis()->sum('montant_devis');
        }
        return ($montant_total_devissoumis_par_entreprise + $montant > $total_montant_accompte_verse * 2) ? 1 : 0; 
    }
   
    
}
