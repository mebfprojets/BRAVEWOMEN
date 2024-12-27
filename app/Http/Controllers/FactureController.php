<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\Valeur;
use App\Models\Entreprise;
use App\Models\Historiquefacture;
use App\Models\Devi;
use App\Models\SuiviExecutionDevi;
use App\Models\FactureImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AnalyseMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PDF;    
class FactureController extends Controller
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
    public function get_file_emplacement($code_promoteur, $input_name,$file,$devi,$num){
        $devi_designation=Devi::find($devi)->designation;
        $year=date("Y");
        $extension=$file->getClientOriginalExtension();
        $fileName = $num.'_'.$devi_designation.'.'.$extension;
        $emplacement='public/'.$year.'/'.$input_name.'/'.$code_promoteur; 
        $url_store= $file->storeAs($emplacement, $fileName);
        return $url_store;
    }
    public function create_historique($facture_id, $statut,$motif, $observation, ){
        $datedujour = new \DateTime();
        $date= $datedujour->format('Y-m-d');
        Historiquefacture::create([
                'facture_id'=> $facture_id,
                'user_id'=>Auth::user() ->id,
                'statut'=>$statut,
                'date_statut'=>$date,
                'observation'=>$observation, 
                'motif'=>$motif
        ]);
    }

    public function index()
    {
        $factures = Facture::orderBy('updated_at', 'desc')->get();
        
        return view("facture.index", compact('factures'));
    }
public function facture_dun_devis(Devi $devi){
    $facs= Facture::where('devi_id',$devi->id)->orderBy('updated_at', 'desc')->get();
    return view('public.facture_beneficiaire', compact('devi','facs'));
}
public function facture_soumises(){
    $entreprises= Entreprise::where('region', Auth::user()->zone)->orWhere('region_affectation', Auth::user()->zone)->orderBy('updated_at', 'desc')->get('id');
     $factures= Facture::whereIn('entreprise_id', $entreprises)->where('statut', 'soumis')->orderBy('updated_at', 'desc')->get();
    return view('facture.aanalyser', compact('factures'));
}
public function facture_de_ma_zone(){
    $entreprises= Entreprise::where('region', Auth::user()->zone)->orWhere('region_affectation', Auth::user()->zone)->get('id');
    $devis = Devi::whereIn('entreprise_id', $entreprises)->where('statut', 'soumis')->get();
    return view("facture.aanalyser", compact('devis'));
 }
 public function confirmer_facture(Request $request){
        $facture= Facture::find($request->facture_id);
        $facture->update([
            "conforme" =>1,
            "user_confirm" =>Auth::user()->id
        ]);
        return 1;
 }
 public function analyse_de_facture(Request $request){
    $statut= $request->statut;
    if($statut){
        $factures = Facture::orderBy('updated_at', 'asc')->where('statut',$statut)->get();
    }
    else{
        $factures = Facture::orderBy('updated_at', 'asc')->get();
    }
    return view("facture.aanalyser", compact('factures'));

 }
 public function facture_valide_par_banque(Entreprise $entreprise){
if(Auth::user()->banque_id){
    $facture_ids= DB::table('factures')
            ->join('entreprises',function($join){
                $join->on('factures.entreprise_id','=','entreprises.id')
                ->where('factures.statut', 'validé');
            })
            ->where('entreprises.banque_id', Auth::user()->banque_id)
            ->select('factures.id as facture_id')
            ->orderBy('factures.updated_at', 'asc')
            ->get();
           

}else{
    $facture_ids= DB::table('factures')
                ->join('entreprises',function($join){
                    $join->on('factures.entreprise_id','=','entreprises.id')
                    ->where('factures.statut', 'validé');
                })
                ->select('factures.id as facture_id','factures.updated_at')
                ->orderBy('factures.date_de_validation', 'desc')
                ->get();
}
    $factures=[];
    foreach($facture_ids as $fact){
        $facture= Facture::find($fact->facture_id);
        $factures[]= $facture;
    }
        return view('facture.apayer', compact('factures'));
 }
public function generer_lettre_de_paiement2(Facture $facture){
    $devi= Devi::find($facture->devi_id);
    $entreprise= Entreprise::find($devi->entreprise_id);
   
    $pdf = PDF::loadView('pdf.lettre_de_paiement', compact('facture', 'devi', 'entreprise'));
    return  $pdf->download('Lettre de demande de paiement .pdf');
}
public function generer_lettre_de_paiement(Facture $facture){
    $devi= Devi::find($facture->devi_id);
    $entreprise= Entreprise::find($devi->entreprise_id);
    $facture->update([
        'paiement_print'=>1,
    ]);
    $denomination_prestataire= htmlspecialchars($devi->prestataire->denomination_entreprise);
    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('/var/www/bravewomen.bf/templatesWord/demande_de_paiement.docx');
    $templateProcessor->setValue('NomDeLaBanque', $entreprise->banque->nom);
    $templateProcessor->setValue('NomDeLaPromotrice', $entreprise->promotrice->nom);
    $templateProcessor->setValue('PrenomDeLaPromotrice', htmlspecialchars($entreprise->promotrice->prenom));
    $templateProcessor->setValue('NomDelentreprise', htmlspecialchars($devi->entreprise->denomination));
    $templateProcessor->setValue('PrenomDeLaPromotrice', htmlspecialchars($entreprise->banque->nom));
    $templateProcessor->setValue('designationDuDevi', htmlspecialchars($devi->designation));
    $templateProcessor->setValue('MontantDelaFactureEnLettre',int2str($facture->montant));
    $templateProcessor->setValue('MontantDelaFacture',  format_prix($facture->montant));
    $templateProcessor->setValue('PourcentageDepaiement',  $facture->montant/$devi->montant_devis*100);
    $templateProcessor->setValue('NomDeprestataire',$denomination_prestataire);
    header('Content-Type: application/octet-stream');
    header("Content-Disposition: attachment; filename= lettre_de_demande.docx");
    $templateProcessor->saveAs('php://output');
}

public function store_paiement_file(Request $request){
    $facture=Facture::find($request->facture_id);
    $devi= $facture->devi;
    //dd( $devi);
    if($request->hasFile('dossier_de_paiement')){
        $facture_file=$this->get_file_emplacement($devi->entreprise->code_promoteur,'facture_file',$request->file('dossier_de_paiement'),$devi->id,$facture->num_facture);
     }
     $facture->update([
        'url_fac'=>$facture_file,
     ]);
    return redirect()->back();
}
 public function store_paiement(Request $request){
    if(Auth::user()->can('enregistrer_paiement')){
        $facture = Facture::find($request->facture_id);
        $date_paiement= date('Y-m-d', strtotime($request->date_paiement));
        if($request->hasFile('recu_de_paiement')){
            $recu_de_paiement= $request->recu_de_paiement->store('public/recu_paiemen_facture');
        }
        (return_diffdate($facture->date_de_validation, today()) > env('NBRE_JR_DE_PAIEMENT_DES_FACTURES'))?$delais="En retard":$delais="Dans les delais";
        // Définition des delais de traitement des factures par les banques 
         $nombre_de_jour_de_retard= return_diffdate($facture->date_de_validation, $request->date_paiement) - env('NBRE_JR_DE_PAIEMENT_DES_FACTURES') ;
        if($nombre_de_jour_de_retard== 0 || $nombre_de_jour_de_retard < 0 ){
            $delais= 'Dans les delais';
        }
        elseif($nombre_de_jour_de_retard > 0 && ($nombre_de_jour_de_retard < 3 || $nombre_de_jour_de_retard == 3) ){
            $delais= 'Retard [0,3] jrs';
        }
        elseif($nombre_de_jour_de_retard > 3  && ($nombre_de_jour_de_retard  < 7|| $nombre_de_jour_de_retard == 7) ){
            $delais= 'Retard ]3,7] jrs';
        }
        elseif($nombre_de_jour_de_retard > 7  && ($nombre_de_jour_de_retard  < 10 || $nombre_de_jour_de_retard == 10) ){
            $delais= 'Retard ]7,10] jrs';
        }
        elseif($nombre_de_jour_de_retard > 10){
            $delais= 'Retard 10 jours et plus';
        }
        $facture->update([
            'url_recu_paiement'=>$recu_de_paiement,
            'date_de_paiement'=>$date_paiement,
            'statut'=>'payée',
            'statut_paiement'=>$delais,
            'nbre_de_jour_de_paiement'=> return_diffdate($facture->date_de_validation, $request->date_paiement)
        ]);
        $this->create_historique($facture->id, 'payee', null, null);
        Insertion_Journal('Factures','Modification');
        Insertion_Journal('Factures','payé');

        flash("Paiement de facture effectué avec success !!!")->success();
        return redirect()->back();
    }
    else{
        flash("Vous n'avez pas le droit sur cette action. Bien vouloir contacter l'admnistrateur")->success();
        return redirect()->back();
    }
 }
 public function factureparstatutparbanque(Request $request){
    //dd($request->all());
    $banque_id= $request->banque_id;
   
    $facture_par_statut=            DB::table('factures')
                                        ->leftjoin('entreprises','factures.entreprise_id','=','entreprises.id')
                                        ->where('entreprises.banque_id','=', $banque_id)
                                        ->groupBy('factures.statut')
                                        ->where('factures.statut','!=', 'transmis_au_chef_de_projet')
                                        ->select("factures.statut",DB::raw("COUNT(factures.id) as nombre"), DB::raw("SUM(factures.montant) as montant"))
                                        ->get();
        return json_encode($facture_par_statut);
 }
 public function group_by_delais_de_paiement(Request $request){
    $banque_id= $request->banque_id;
    $phase=$request->phase;
        if($request->phase){
                    $facture_par_delais= DB::table('entreprises')
                                        ->rightJoin('factures',function($join){
                                            $join->on('factures.entreprise_id','=','entreprises.id');
                                        })
                                        ->where('factures.statut_paiement','!=',null)
                                        ->where('entreprises.banque_id','=', $banque_id)
                                        ->where('entreprises.phase_projet',$phase)
                                        ->groupBy('factures.statut_paiement')
                                        ->select("factures.statut_paiement",DB::raw("COUNT(factures.id) as nombre"), DB::raw("SUM(factures.montant) as montant"))
                                        ->orderBy('factures.statut_paiement','asc')
                                        ->get();

        }else{
            $facture_par_delais= DB::table('entreprises')
                                        ->rightJoin('factures',function($join){
                                            $join->on('factures.entreprise_id','=','entreprises.id');
                                        })
                                        ->where('factures.statut_paiement','!=',null)
                                        ->where('entreprises.banque_id','=', $banque_id)
                                        ->groupBy('factures.statut_paiement')
                                        ->select("factures.statut_paiement",DB::raw("COUNT(factures.id) as nombre"), DB::raw("SUM(factures.montant) as montant"))
                                        ->orderBy('factures.statut_paiement','asc')
                                        ->get();
        }
                    
                                    return json_encode($facture_par_delais);
 }
 public function situation_des_factures_par_statut(Request $request){
    //dd($request->phase);
        if($request->phase){
            $phase=$request->phase;
            $facture_par_status = DB::table('entreprises')
            ->leftjoin('factures',function($join){
                $join->on('factures.entreprise_id','=','entreprises.id');
            })
            ->where('entreprises.phase_projet',$phase)
            ->rightJoin('banques',function($join){
                $join->on('entreprises.banque_id','=','banques.id');
            })
            ->groupBy('banques.id','banques.nom')
            ->select('banques.nom as nom_banque' ,
                    DB::raw("sum(CASE WHEN factures.statut='payée' OR factures.statut='validé' THEN 1 else 0 end) as nbre_facture_soumis_aux_bank"),
                    DB::raw("sum(CASE WHEN factures.statut='validé' THEN 1 else 0 end) as nbre_facture_en_attente"),
                    DB::raw("sum(CASE WHEN factures.statut='payée' THEN 1 else 0 end) as nbre_facture_payee"),)
            ->get();
        }
        else{
            $facture_par_status = DB::table('entreprises')
                                        ->leftjoin('factures',function($join){
                                            $join->on('factures.entreprise_id','=','entreprises.id');
                                        })
                                        ->rightJoin('banques',function($join){
                                            $join->on('entreprises.banque_id','=','banques.id');
                                        })
                                        ->groupBy('banques.id','banques.nom')
                                        ->select('banques.nom as nom_banque' ,
                                                DB::raw("sum(CASE WHEN factures.statut='payée' OR factures.statut='validé' THEN 1 else 0 end) as nbre_facture_soumis_aux_bank"),
                                                DB::raw("sum(CASE WHEN factures.statut='validé' THEN 1 else 0 end) as nbre_facture_en_attente"),
                                                DB::raw("sum(CASE WHEN factures.statut='payée' THEN 1 else 0 end) as nbre_facture_payee"),)
                                        ->get();
        }
                
                                    return json_encode($facture_par_status);
 }

 public function demande_de_paiement_rejete_par_banque(Request $request){
    $nombre_de_dossier_rejete_par_les_banques = DB::table('historiquefactures')
                                                ->leftjoin('users',function($join){
                                                    $join->on('historiquefactures.user_id','=','users.id')
                                                    ->where('historiquefactures.statut', 'transmis_au_chef_de_projet');
                                                })
                                                ->rightJoin('banques',function($join){
                                                    $join->on('users.banque_id','=','banques.id')
                                                    ->where('users.banque_id', '!=', null);
                                                })
                                                ->join('factures','historiquefactures.facture_id','=','factures.id')
                                                ->groupBy('banques.id','banques.nom')
                                                ->select('banques.nom as nom_banque' , DB::raw("Count(factures.id) as nombre_de_facture"))
                                                ->get();
                                    return json_encode($nombre_de_dossier_rejete_par_les_banques);
 }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Devi $devi)
    {
        return view('facture.create', compact('devi'));
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $year=date("Y");
        $images = $request->images;
        $champ_nombre_dimage = $request->champ_nombre_dimage;
        $devi=Devi::find($request->devi_id);
        if(Auth::user()->code_promoteur==null){
            $statut= 'transmis_au_chef_de_projet';
        }else{
            $statut= 'soumis';
        }
    if($devi->factures->sum('montant') + reformater_montant2($request->montant_facture) > $devi->montant_devis){
        flash("Cette facture ne peut pas etre soumis pour depassement du montant du devis !")->error();
        return redirect()->back();
    }
    else{
        $lastOne = DB::table('factures')->latest('id')->first();
        if($lastOne){
            $num_fact="BWBF-FAC-000". $lastOne->id+1;

        }
        else{
            $num_fact= "BWBF-FAC-000". '0';
        }
        $copie_rib=null;
        if($request->hasFile('facture_file')){
           $facture_file=$this->get_file_emplacement($devi->entreprise->code_promoteur,'facture_file',$request->file('facture_file'),$request->devi_id,$num_fact);
        }
        if($request->hasFile('copie_rib')){
           $copie_rib=$this->get_file_emplacement($devi->entreprise->code_promoteur,'copie_rib',$request->file('copie_rib'),$request->devi_id,$num_fact);
        }
      
       $facture= Facture::create([
            'devi_id'=>$request->devi_id,
            'entreprise_id'=>$devi->entreprise->id,
            'url_fac'=>$facture_file,
            'num_facture'=>$num_fact,
            'numero_de_telephone'=>$request->numero_de_telephone,
            'numero_de_compte'=>$request->numero_de_compte,
            'nom_de_banque'=>$request->nom_de_banque,
            'detenteur_du_numero'=>$request->nom_prenom_detenteur,
            'mode_de_paiement'=>$request->mode_de_paiement,
            'montant' => reformater_montant2($request->montant_facture), 
            'url_copie_rib'=> $copie_rib,
            'identite_beneficiaire'=> $request->identite_beneficiaire,
            'moyen_de_paiement_mobile'=> $request->type_de_paiement_mobile,
            'statut'=>$statut,
        ]);
        $emplacement='public/image_aquisitions/'.$devi->entreprise->code_promoteur;
        //Stocker les images de la facture
        for($i=1; $i<$champ_nombre_dimage+1; $i++){
            if($request->hasFile('image'.$i)){
                $inputname='image'.$i;
                $file = $request->file($inputname);
                $fileName = $file->getClientOriginalName();
                //Definir l'emplacement de sorte à créer un sous repertoire pour chaque entreprise
                $emplacement='public/'.$year.'/'.'image_aquisitions/'.$devi->entreprise->code_promoteur.'/'.$facture->num_facture; 
                $image_acquisition= $request[$inputname]->storeAs($emplacement, $fileName);
                FactureImage::create([
                    'facture_id'=>  $facture->id,
                    'url_image'=>  $image_acquisition,
                ]);

            }
                Insertion_Journal('Factures','Création');
        }
        $mail_promotrice=$facture->entreprise->promotrice->email_promoteur;
        $chef_de_zone= User::where('zone', $facture->entreprise->region)->orWhere('zone', $facture->entreprise->region_affectation)->first();
        $e_msg="Vous avez des factures qui sont en attentes de validation.";
        $titre='Chef de Zone';
        $mail=$chef_de_zone->email;
        $typeelt='facture';
        Mail::to($mail)->queue(new AnalyseMail($titre, $e_msg, 'mails.analyseMail',$facture->id,$typeelt));
        $this->create_historique($facture->id, "soumis", null, null );
        flash("La facture été soumise avec  success !!!")->success();
        return redirect()->back();
    }
}
    public function modifier(Request $request){
        $facture= Facture::find($request->id);
        ($facture->observation == null )?($bservation=' '):($bservation=$facture->observation );
        $data = array(
         'id'=>$facture->id,
         'montant_facture'=>format_prix($facture->montant),
         'mode_de_paiement'=>$facture->mode_de_paiement,
         'copie_facture'=>$facture->url_fac,
         'numero_de_telephone'=>$facture->numero_de_telephone,
         'numero_de_compte'=>$facture->numero_de_compte,
         'nom_de_banque'=> $facture->nom_de_banque,
         'detenteur_du_numero'=>$facture->nom_prenom_detenteur,
         'statut'=>$facture->statut,
         'motif'=> getlibelle($facture->raison_rejet),
         'observation'=>$bservation
     );
     return json_encode($data);
 }

 public function enr_modification(Request $request){
   $facture= facture::find($request->facture_id);
   $copie_rib=null;
    if($request->facture_file_u){
        $facture_file=$this->get_file_emplacement($facture->entreprise->code_promoteur,'facture_file00',$request->file('facture_file_u'),$facture->devi_id,$facture->num_facture);
        $facture->update([
            'url_fac'=>$facture_file,
        ]);
      
    }
    if($request->hasFile('copie_rib_u')){
        $copie_rib=$this->get_file_emplacement($facture->entreprise->code_promoteur,'copie_rib',$request->file('copie_rib_u'),$facture->devi_id,$facture->num_facture);
    }
    if(Auth::user()->code_promoteur==null){
        $statut= 'transmis_au_chef_de_projet';
    }else{
        $statut= 'soumis';
    }
    $devi=$facture->devi;
   
    $facture->update([
        'montant'=>reformater_montant2($request->montant_facture),
        'mode_de_paiement'=>$request->mode_de_paiement,
        'statut'=>$statut,
        'numero_de_telephone'=>$request->numero_de_telephone,
         'numero_de_compte'=>$request->numero_de_compte,
         'nom_de_banque'=>$request->nom_de_banque,
         'detenteur_du_numero'=>$request->nom_prenom_detenteur,
         'url_copie_rib'=> $copie_rib,
         'identite_beneficiaire'=> $request->identite_beneficiaire,
         'moyen_de_paiement_mobile'=> $request->type_de_paiement_mobile,
         'observation'=>'',
         'raison_rejet'=>'',
    ]);
    Insertion_Journal('factures','modification');
    $chef_de_zone= User::where('zone', $facture->entreprise->region)->orWhere('zone', $facture->entreprise->region_affectation)->first();
        $e_msg="Vous avez des factures qui sont en attentes de validation.";
        $titre='Chef de Zone';
        $mail=$chef_de_zone->email;
        $typeelt='facture';
        Mail::to($mail)->queue(new AnalyseMail($titre, $e_msg, 'mails.analyseMail',$facture->id,$typeelt));
        $this->create_historique($facture->id, "soumis", null, null );
      flash("La facture a été modifié et soumise avec  success !!!")->success();
      if(Auth::user()->code_promoteur==null){
        return redirect()->route('executer.pca',[$facture->entreprise]);
      }
      else{
        return redirect()->route('facture.liste',[$devi]);

      }
       
}
//Cette fonction permet de verifier si le montant de la facture soumise ne depasse pas le montant du devis 
// et si un paiement total du devis est demande de s'assurer si le taux de realisation du devis est à 100%
public function verifier_montant(Request $request){
    $montant= $request->montant;
    $devi_id= $request->devi_id;

    $facture_id= $request->facture_id;
    $devi= Devi::find($devi_id);
   
    if($facture_id){
        $facture= Facture::find($facture_id);
        $total_facture_soumis= $devi->factures()->sum('montant') - $facture->montant;
    }
    else{
        $total_facture_soumis= $devi->factures()->sum('montant');
    }
    
 return (($total_facture_soumis + $montant > $devi->montant_devis) || (($devi->factures->count()+1== $devi->nombre_de_paiement)&&($devi->montant_devis > $devi->factures()->sum('montant') + $montant)) || (($devi->factures->count()== $devi->nombre_de_paiement)&&($devi->montant_devis > $devi->factures()->sum('montant') + $montant))  ) ? 1 : 0; 
}

public function changerStatus(Request $request){
    $facture=Facture::find($request->facture_id);
    $devi= Devi::find($facture->devi_id);
    $total_facture_soumis= $devi->factures()->sum('montant');
    $date = new \DateTime();
    $mail_promotrice=$facture->entreprise->promotrice->email_promoteur;
    $chef_de_zone= User::where('zone', $facture->entreprise->region)->orWhere('zone', $facture->entreprise->region_affectation)->first();
    $e_msg="Vous avez des factures qui sont en attente de validation.";
    $titre='Chef de Zone';
    $typeelt='facture';
    $mail=$chef_de_zone->email;
    $new_statut=$facture->statut;
    $date= $date->format('Y-m-d');
    ($facture->statut =='soumis')?($action='chef_de_zone'):($action='autre');
    if($request->raison || $request->observation){
        if($facture->statut=='transmis_au_chef_de_projet' && return_role_adequat(env('ID_ROLE_CHEF_DE_PROJET'))){
            $new_statut='soumis';
        }
        elseif($facture->statut=='validé' && return_role_adequat(env('ID_ROLE_BANQUE_PARTENAIRE'))){
            $new_statut='transmis_au_chef_de_projet';  
        }
        elseif($facture->statut=='soumis' && return_role_adequat(env('ID_ROLE_CHEF_DE_ZONE'))){
            $new_statut='rejeté';
            $mail= $mail_promotrice;
            $e_msg="Une de vos demandes de paiement à été rejetée. Merci de prendre en compte les observations.";
        }
           $facture->update([
               'statut'=>$new_statut,
               'raison_rejet'=>$request->raison,
               'observation'=>$request->observation
           ]);
        $this->create_historique($facture->id, $new_statut, $request->raison, $request->observation );
    }
    else{
       if (($total_facture_soumis == $devi->montant_devis)&& ($devi->taux_de_realisation < 100))
       {
            return 1;
       }
       else{
        if($facture->statut=='soumis' && return_role_adequat(env('ID_ROLE_CHEF_DE_ZONE'))){
            $new_statut='transmis_au_chef_de_projet';
            $mail= env('emailChefdeProjet');
         Mail::to($mail)->queue(new AnalyseMail($titre, $e_msg, 'mails.analyseMail',$facture->id,$typeelt));
        }
        elseif($facture->statut=='transmis_au_chef_de_projet' && return_role_adequat(env('ID_ROLE_CHEF_DE_PROJET'))){
            $entreprise= $facture->devi->entreprise;
            $new_statut='validé';
            $banque_users = User::where('banque_id',$entreprise->banque_id)->get();
            foreach($banque_users as $banque_user){
                $liste_roles= $banque_user->roles;
                foreach($liste_roles as $role)
                {
                    if($role->id==env('ID_ROLE_BANQUE_PARTENAIRE')){
                        $res= true;
                    }
                }
                if($res==true){
                     Mail::to($banque_user->email)->queue(new AnalyseMail($titre, $e_msg, 'mails.analyseMail',$facture->id,$typeelt));
                }
            }
        }
        $facture->update([
            'statut'=>$new_statut, 
            'date_de_validation'=>$date,
        ]);
        $this->create_historique($facture->id, $new_statut, null, null);
        Insertion_Journal('factures','modification');
       }
                      
    }
 
        return 0;
}
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function show(Facture $facture, Request $request)
    {       
       // dd($facture->images_des_biens);
        $historiques = Historiquefacture::where('facture_id', $facture->id)->orderBy('created_at', 'asc')->get();
       
        $devi= $facture->devi;
        $suiviExecution = SuiviExecutionDevi::where('devi_id', $devi->id)->orderBy('date_visite','desc')->first();
       // dd($suiviExecution);
        $motifs_de_rejects=Valeur::where('parametre_id', 37 )->get();
        if($request->action=='analyser'){
            //dd($facture->images_des_biens);
            return view('facture.analyse', compact('facture','historiques', 'motifs_de_rejects','suiviExecution' ));
        }
        else{
            return view('facture.show', compact('facture', 'historiques','suiviExecution'));
        }
        Insertion_Journal('factures','visualisation');
    }
    public function view_beneficiaire(Facture $facture){
        return view('public.view_facture',compact('facture'));
    }
    public function showById($id)
    {
        $facture= Facture::find($id);
        $devi= $facture->devi;
        $suiviExecution = SuiviExecutionDevi::where('devi_id', $devi->id)->orderBy('date_visite','desc')->first();
        $historiques = Historiquefacture::where('facture_id', $facture->id)->orderBy('created_at', 'desc')->get();
            return view('facture.show', compact('facture', 'historiques','suiviExecution'));
    }
    public function telechargerfacture(Request $request, $id){ 
        if($request->file=='recu_paiement'){
            $facture= Facture::find($id);
            return $path = Storage::download($facture->url_recu_paiement);
        }
        if($request->file=='facture'){
            $facture= Facture::find($id);
            return $path = Storage::download($facture->url_fac);
        }
        if($request->file=='image_biens'){
           $factureimage= FactureImage::find($id);
           return $path = Storage::download($factureimage->url_image);

        }
        if($request->file=='rib'){
            $facture= Facture::find($id);
            return $path = Storage::download($facture->url_copie_rib);
            
         }
        Insertion_Journal('factures','visualisation');
    }
    
   public function modifier_image_bien_acquis(Request $request){
        $year=date("Y");
        $factureimage= FactureImage::find($request->image_id);
        $devi= $factureimage->facture->devi;
    if($request->hasFile('image_bien')){
        $file = $request->file('image_bien');
        $fileName = $file->getClientOriginalName();
        //Definir l'emplacement de sorte à créer un sous repertoire pour chaque entreprise
        $emplacement='public/'.$year.'/'.'image_aquisitions/'.$devi->entreprise->code_promoteur; 
        $image_acquisition= $request['image_bien']->storeAs($emplacement, $fileName);
        $factureimage->update([
            'url_image' =>$image_acquisition
        ]);
    }
        return redirect()->back();
   }
   public function ajouter_image_bien_acquis(Request $request){
    $year=date("Y");
    $facture= Facture::find($request->facture_id);
    if($request->hasFile('image_bien')){
        $file = $request->file('image_bien');
        $fileName = $file->getClientOriginalName();
        //Definir l'emplacement de sorte à créer un sous repertoire pour chaque entreprise
        $emplacement='public/'.$year.'/'.'image_aquisitions/'.$facture->devi->entreprise->code_promoteur; 
        $image_acquisition= $request['image_bien']->storeAs($emplacement, $fileName);
        FactureImage::create([
            'facture_id'=>  $facture->id,
            'url_image'=>  $image_acquisition,
        ]);
        Insertion_Journal('Facture_images','création');
    }
    return redirect()->back();
   }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function edit(Facture $facture)
    {
        $devi= $facture->devi;
        if(Auth::user()->code_promoteur==null){
            return view('facture.modifier',compact('facture','devi'));
        }else{
            return view('public.editfacture',compact('facture','devi'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Facture $facture)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function destroy(Facture $facture)
    {
        //
    }
    public function rejeter_la_facture_apres_validation(Facture $facture)
    {
        if (Auth::user()->can('parametre.create')) {
            $facture->update([
                'statut'=>'rejeté'
            ]);
            $this->create_historique($facture->id,'rejeté', null,'suite pour correction');
            
            flash("La facture a éte rejetée  . !!!")->success();
            return redirect()->back();
        }
            else{
                flash("Desolé vous n'avez pas les droits requis pour faire cette action. !!!")->error();
                return redirect()->back();
            }
        }
    public function facture_payes(){
        if(Auth::user()->banque_id){
            $facture_ids= DB::table('factures')
                ->join('entreprises',function($join){
                    $join->on('factures.entreprise_id','=','entreprises.id')
                    ->where('factures.statut', 'payee');
                })
                ->where('entreprises.banque_id', Auth::user()->banque_id)
                ->select('factures.id as facture_id')
                ->orderBy('factures.updated_at', 'asc')
                ->get();

        }
        else{
            $facture_ids= DB::table('factures')
            ->join('entreprises',function($join){
                $join->on('factures.entreprise_id','=','entreprises.id')
                ->where('factures.statut', 'payee');
            })
            ->select('factures.id as facture_id')
            ->orderBy('factures.updated_at', 'asc')
            ->get();
        }
        $factures=[];
        foreach($facture_ids as $fact){
            $facture= Facture::find($fact->facture_id);
            $factures[]= $facture;
        }
        return view('facture.payees', compact('factures'));
        }
    
}
