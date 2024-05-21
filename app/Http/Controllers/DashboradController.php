<?php

namespace App\Http\Controllers;

use App\Models\Entreprise;
use App\Models\Piecejointe;
use App\Models\InvestissementProjet;
use App\Models\Impact;
use App\Models\Accompte;
use App\Models\Subvention;
use App\Models\Facture;
use App\Models\Indicateur;
use App\Models\Projet;
use App\Models\Devi;
use App\Models\Acquisition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class DashboradController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['souscriptiongeopresenation','souscriptionparzone','souscriptiongeopresenation','aopparsecteuractivite','entreprisepreselectionneparzone','souscriptionparzone','souscriptionparsecteuractivite','souscriptionretenueparsecteuractivite','aopregisterparzone','enregistreSecteurActiviteZone']);
    }
public function versement_contre_partie_par_periode(){
    $les_mois_de_versement=DB::select("select DISTINCT DATE_FORMAT(date_versement, '%M %Y') as mois from accomptes ORDER BY date_versement ASC" );
    $versement_de_lacontrepatie_boa= DB::select("select b.nom as nom_banque,  SUM(a.montant) as total, DATE_FORMAT(a.date_versement, '%M %Y') AS versement_month, nom FROM banques b, entreprises e,
     accomptes a WHERE a.entreprise_id=e.id
     and b.id=e.banque_id and b.id=2 GROUP BY b.id, b.nom, versement_month ORDER BY  date_versement ASC");
     $rows1 = array();
     $j=0;
     $rows1['name'] = 'BOA';
if($les_mois_de_versement){
    foreach($les_mois_de_versement as $les_mois_de_versement){
        $t=null;
        for($i=0; $i< count($versement_de_lacontrepatie_boa); $i++)
        {
          $val=($les_mois_de_versement->mois  == $versement_de_lacontrepatie_boa[$i]->versement_month);

            if($val){
                $t= $versement_de_lacontrepatie_boa[$i]->total;
                $tir[]=$t;
               }
    }
    $mois[]= $les_mois_de_versement->mois;
    $rows1['data'][]=$t;
}
}
else{
    $mois[]=null;
}

$rows1['mois']= $mois;
$les_mois_de_versement=DB::select("select DISTINCT DATE_FORMAT(date_versement, '%M %Y') as mois from accomptes ORDER BY date_versement ASC " );
     $versement_de_lacontrepatie_coris= DB::select("select b.nom as nom_banque,  SUM(a.montant) as total, DATE_FORMAT(a.date_versement, '%M %Y') AS versement_month, nom FROM banques b, entreprises e,
     accomptes a WHERE a.entreprise_id=e.id
     and b.id=e.banque_id and  b.id=2  GROUP BY b.id, b.nom, versement_month ORDER BY date_versement ASC");
     $rows2 = array();
     $rows2['name'] = 'CORIS';
     $j=0;
     foreach($les_mois_de_versement as $les_mois_de_versement){
        $t=null;

        for($i=0; $i< count($versement_de_lacontrepatie_coris); $i++)
        {
          $val=( $les_mois_de_versement->mois == $versement_de_lacontrepatie_coris[$i]->versement_month);
            if($val){
                $t= $versement_de_lacontrepatie_coris[$i]->total;
                $tir[]=$t;
            }
    }
    $rows2['data'][]=$t;
}
$rows2['mois']= $mois;

     $result = array();
        array_push($result,$rows1);
        array_push($result,$rows2);

        return json_encode($result);
}
public function situation_subvention_par_zone(){
   $subvention_debloque_par_zone= DB::select('select e.region, v.libelle, SUM(s.montant_subvention) as montant_debloque FROM entreprises e , valeurs v, subventions s where s.entreprise_id=e.id and e.region = v.id  GROUP by e.region, v.libelle');
   if($subvention_debloque_par_zone){
    foreach( $subvention_debloque_par_zone as $value)
    {
       $subventionparlocalite[] = array('region'=>$value->libelle, 'montant_debloque'=>$value->montant_debloque);
    }
    return json_encode($subventionparlocalite);
}
 else
 return $subventionparlocalite=0;
}
public function contrepartie_mobilisee_par_localite(){
    $montant_mobilise_par_zone= DB::select('select e.region, v.libelle, SUM(a.montant) as montant_mobilise FROM entreprises e , valeurs v, accomptes a where a.entreprise_id=e.id and e.region = v.id  GROUP by e.region, v.libelle');
    if($montant_mobilise_par_zone){
     foreach( $montant_mobilise_par_zone as $value)
     {
        $contrepartieparlocalite[] = array('region'=>$value->libelle, 'montant_mobilise'=>$value->montant_mobilise);
     }
     return json_encode($contrepartieparlocalite);
 }
  else
  return $contrepartieparlocalite=0;

 }

 public function mobilisation_dela_contrepartie_par_banque(){
    $contrepartie_par_banque= DB::table('entreprises')
                                    ->join('banques','entreprises.banque_id','=','banques.id')
                                    ->leftjoin('accomptes','accomptes.entreprise_id','=','entreprises.id')
                                    ->where('entreprises.date_de_signature_accord_beneficiaire','!=', null)
                                    ->groupBy('banques.id',"banques.nom")
                                    ->select("banques.id","banques.nom as nom_banque", DB::raw("SUM(accomptes.montant) as montant"))
                                    ->get();
    if($contrepartie_par_banque){
              foreach( $contrepartie_par_banque as $value)
                    {
                        $contrepartieparbanque[] = array('nom_banque'=>$value->nom_banque, 'montant_mobilise'=>$value->montant);
                    }
                    return json_encode($contrepartieparbanque);
     }
     else
        return $contrepartieparbanque=0;
 }
 public function mobilisation_dela_subvention_par_banque(){
    $subvention_par_banque= DB::table('entreprises')
                                    ->join('banques','entreprises.banque_id','=','banques.id')
                                    ->leftjoin('subventions','subventions.entreprise_id','=','entreprises.id')
                                    ->where('entreprises.date_de_signature_accord_beneficiaire','!=', null)
                                    ->groupBy('banques.id',"banques.nom")
                                    ->select("banques.id","banques.nom as nom_banque", DB::raw("SUM(subventions.montant_subvention) as montant"))
                                    ->get();
    if($subvention_par_banque){
              foreach( $subvention_par_banque as $value)
                    {
                        $subventionparbanque[] = array('nom_banque'=>$value->nom_banque, 'montant_mobilise'=>$value->montant);
                    }
                    return json_encode($subventionparbanque);
     }
     else
        return $subventionparbanque=0;
 }
public function situation_des_subventions_debloque_par_banque()
{
    $les_mois_de_deblocages=DB::select("select DISTINCT DATE_FORMAT(date_subvention, '%M %Y') as mois from subventions as s ORDER BY date_subvention ASC" );
    $situation_subvention_debloque_boa= DB::select("select b.nom as nom_banque,  SUM(s.montant_subvention) as total_subvention, DATE_FORMAT(s.date_subvention, '%M %Y') AS versement_month, nom FROM banques b, entreprises e,
     subventions s WHERE s.entreprise_id=e.id
     and b.id=e.banque_id and  b.id=3 GROUP BY b.id, b.nom, versement_month ORDER BY  date_subvention ASC");
     $rows1 = array();
     $j=0;
     $rows1['name'] = 'BOA';
if($les_mois_de_deblocages){
    foreach($les_mois_de_deblocages as $les_mois_de_deblocage){
        $t=null;
        for($i=0; $i< count($situation_subvention_debloque_boa); $i++)
        {
          $val=($les_mois_de_deblocage->mois == $situation_subvention_debloque_boa[$i]->versement_month);

            if($val){
                $t= $situation_subvention_debloque_boa[$i]->total_subvention;
                $tir[]=$t;
               }
     }
    $mois[]= $les_mois_de_deblocage->mois;
    $rows1['data'][]=$t;
}
}
else{
    $mois[]=null;
}

$rows1['mois']= $mois;
$les_mois_de_versement=DB::select("select DISTINCT DATE_FORMAT(date_subvention, '%M %Y') as mois from subventions ORDER BY date_subvention ASC " );
     $situation_subvention_debloque_coris= DB::select("select b.nom as nom_banque,  SUM(s.montant_subvention) as total_subvention, DATE_FORMAT(s.date_subvention, '%M %Y') AS versement_month, nom FROM banques b, entreprises e,
     subventions s WHERE s.entreprise_id=e.id
     and b.id=e.banque_id and b.id=2 GROUP BY b.id, b.nom, versement_month ORDER BY  date_subvention ASC");
     $rows2 = array();
     $rows2['name'] = 'CORIS';
     $j=0;
     foreach($les_mois_de_versement as $les_mois_de_versement){
        $t=null;
        for($i=0; $i< count($situation_subvention_debloque_coris); $i++)
        {
          $val=( $les_mois_de_versement->mois == $situation_subvention_debloque_coris[$i]->versement_month);
            if($val){
                $t= $situation_subvention_debloque_coris[$i]->total_subvention;
                $tir[]=$t;
               }
    }
    $rows2['data'][]=$t;
}
     $rows2['mois']= $mois;
     $result = array();
        array_push($result,$rows1);
        array_push($result,$rows2);
        return json_encode($result);
}
public function situation_des_paiements_par_banque( Request $request)
{
    $statut=$request->statut;

    $les_mois_de_paiements=DB::select("select DISTINCT DATE_FORMAT(date_de_paiement, '%M %Y') as mois from factures as f ORDER BY mois ASC" );
    $situation_paiement_fait_boa= DB::select("select b.nom as nom_banque,  SUM(f.montant) as total_paiement, DATE_FORMAT(f.date_de_paiement, '%M %Y') AS paiement_month, nom FROM banques b, entreprises e,
     factures f WHERE f.entreprise_id=e.id
     and b.id=e.banque_id and f.statut=$statut and b.id=3 GROUP BY b.id, b.nom, paiement_month ORDER BY  paiement_month ASC");
     $rows1 = array();
     $j=0;
     $rows1['name'] = 'BOA';
    if($les_mois_de_paiements){
        foreach($les_mois_de_paiements as $les_mois_de_paiement){
            $t=null;
            for($i=0; $i< count($situation_paiement_fait_boa); $i++)
            {
              $val=($les_mois_de_paiement->mois == $situation_paiement_fait_boa[$i]->paiement_month);

                if($val){
                    $t= intval($situation_paiement_fait_boa[$i]->total_paiement);
                   // $tir[]=intval($t);
                   }
         }
         //dd($t);
        $mois[]= $les_mois_de_paiement->mois;
        $rows1['data'][]=$t;
        }
    }
   else{
    $mois[]=null;
   }
$rows1['mois']= $mois;
//dd($rows1);
    $les_mois_de_paiements=DB::select("select DISTINCT DATE_FORMAT(date_de_paiement, '%M %Y') as mois from factures as f ORDER BY date_de_paiement ASC" );
     $situation_paiement_fait_coris= DB::select("select b.nom as nom_banque,  SUM(f.montant) as total_paiement, DATE_FORMAT(f.date_de_paiement, '%M %Y') AS paiement_month, nom FROM banques b, entreprises e,
     factures f WHERE f.entreprise_id=e.id
     and b.id=e.banque_id and f.statut= 'payée' and b.id=1 GROUP BY b.id, b.nom, paiement_month ORDER BY  date_de_paiement ASC");
     $rows2 = array();
     $rows2['name'] = 'CORIS';
     $j=0;
     foreach($les_mois_de_paiements as $les_mois_de_paiement){
        $t=null;

        for($i=0; $i< count($situation_paiement_fait_coris); $i++)
        {
          $val=( $les_mois_de_paiement->mois == $situation_paiement_fait_coris[$i]->paiement_month);
            if($val){
                $t= intval($situation_paiement_fait_coris[$i]->total_paiement);
                $tir[]=$t;
               }
    }
    $mois[]= $les_mois_de_paiement->mois;
    $rows2['data'][]=$t;
}
     $rows2['mois']= $mois;
     $result = array();
        array_push($result,$rows1);
        array_push($result,$rows2);
        return json_encode($result);
}

// Situation des factures en attente de paiement par les banques partenaire



    public function principal_dashboard(){
        $entreprises=Entreprise::where("status",'!=',0)->orderBy('updated_at', 'desc')->get();
        $pca_enregistres= Projet::all();
        $nombre_de_pca= count($pca_enregistres);
        $entreprisesAOP=Entreprise::where("status",'!=',0)->where('entrepriseaop',1)->orderBy('updated_at', 'desc')->get();
        $contre_partie_mobilise=Accompte::sum('montant');
        $subvention_debloque=Subvention::sum('montant_subvention');
        $fond_mobilise= $contre_partie_mobilise + $subvention_debloque;
        $total_souscription_enregistres= count($entreprises);
        $entreprisesLeaderAOP=count($entreprisesAOP);
        if(Auth::user()->structure_represente == null && Auth::user()->banque_id==null && Auth::user()->code_promoteur == null ){
            if(Auth::user()->can('tableau.debord')){
                return view('dashboard.principale', compact('nombre_de_pca','total_souscription_enregistres', 'fond_mobilise',  'entreprisesLeaderAOP')) ;
            }
            else{
                flash("Vous n'avez pas ce droit. Bien vouloir contacter l'administrateur")->error();
                return redirect()->back();
            }
        }
        elseif(Auth::user()->structure_represente == null && Auth::user()->banque_id!=null ){
         if(Auth::user()->can('dashboard_bank')){
            return redirect()->route("dashboad_banque");
        }
        else{
            flash("Vous n'avez pas ce droit. Bien vouloir contacter l'administrateur")->error();
            return redirect()->back();
        }
        }
        elseif(Auth::user()->code_promoteur != null){
            return redirect()->route("profil.beneficiaire", return_liste_entreprise_par_user(Auth::user()->id)[0]);
        }
        else{
            return redirect()->route("soumises_au_comite_technique");
        }
    }

public function detail_dashboard(Request $request){
    $type_detail= $request->type_detail;
    $all_souscriptions=Entreprise::where("status",'!=',0)->orderBy('updated_at', 'desc')->get();
    $total_souscription_enregistres= count($all_souscriptions);
    $contre_partie_mobilise=Accompte::sum('montant');
    $subvention_debloque=Subvention::sum('montant_subvention');
    $pca_enregistres= Projet::all();
    $nombre_de_pca= count($pca_enregistres);
    $fond_mobilise= $contre_partie_mobilise + $subvention_debloque;
    $mpme_formes= Entreprise::where("decision_du_comite_phase1", "selectionnee")->where('participer_a_la_formation', 1)->where('entrepriseaop',null)->orderBy('updated_at', 'desc')->get();
    $leader_AOP_formes=Entreprise::where("status",'!=',0)->where('entrepriseaop',1)->where("decision_du_comite_phase1", "selectionnee")->where('participer_a_la_formation', 1)->orderBy('updated_at', 'desc')->get();

  if($type_detail=='mpme'){
   
    $total_mpme_enregistre=Entreprise::where("status",'!=',0)->orderBy('updated_at', 'desc')->where('entrepriseaop',null)->count();
    $total_aop_leader_enregistres=Entreprise::where('entrepriseaop',1)->where("status",'!=',0)->orderBy('updated_at', 'desc')->count();

    $total_aop_enregistres=Entreprise::where('aopOuleader','aop')->where("status",'!=',0)->orderBy('updated_at', 'desc')->count();
    $total_leader_enregistres=Entreprise::where('aopOuleader','leader')->where("status",'!=',0)->orderBy('updated_at', 'desc')->count();
    $total_mpme_rejetes= Entreprise::where("decision_du_comite_phase1", "ajournee")->where('entrepriseaop',null)->orderBy('updated_at', 'desc')->count();
    $total_aop_rejetes= Entreprise::where("decision_du_comite_phase1", "ajournee")->where('entrepriseaop',1)->orderBy('updated_at', 'desc')->count();
    $total_mpme_aformation= Entreprise::where("decision_du_comite_phase1", "selectionnee")->where('entrepriseaop',null)->orderBy('updated_at', 'desc')->count();
    $entreprisesLeaderAOP_aformer=Entreprise::where("status",'!=',0)->where('entrepriseaop',1)->where("decision_du_comite_phase1", "selectionnee")->orderBy('updated_at', 'desc')->count();
    
    //$total_souscription_enregistres= count($all_souscriptions);
    $total_mpme_formes=count($mpme_formes);

    $total_mpme_formees= count($mpme_formes);
    $total_aopleader_formes=count($leader_AOP_formes);
    return view('dashboard.detail_mpme', compact('nombre_de_pca','fond_mobilise','total_mpme_rejetes','total_aop_rejetes','total_mpme_enregistre','total_souscription_enregistres', 'total_aop_leader_enregistres','total_aop_enregistres','total_leader_enregistres', 'total_mpme_aformation', 'total_mpme_formes','entreprisesLeaderAOP_aformer','total_aopleader_formes'));

  }
  elseif($type_detail=='finance'){
    $total_contrepartie_verse=Accompte::sum('montant');
    $total_subvention_verse= Subvention::sum('montant_subvention');
    $nombre_devis_soumis= Devi::where('statut', 'soumis')->count();
    $montant_devis_soumis= Devi::where('statut', '!=', 'soumis')->sum('montant_devis');
    $nombre_devi_valide= Devi::where('statut', 'validé')->count();
    $montant_devi_valide= Devi::where('statut', 'validé')->sum('montant_devis');
    $nombre_facture_soumises= Facture::where('statut', 'soumis')->count();
    $montant_facture_enregistrees= Facture::sum('montant');
    $montant_facture_soumise= Facture::where('statut', 'soumis')->orWhere('statut','transmis_au_chef_de_projet')->sum('montant');
    $montant_facture_valide= Facture::where('statut', 'validée')->sum('montant');
    $montant_facture_payee= Facture::where('statut', 'payée')->sum('montant');
    $mobilisation_par_banque= DB::table('entreprises')
                                    ->join('banques','entreprises.banque_id','=','banques.id')
                                    ->where('entreprises.date_de_signature_accord_beneficiaire','!=', null)
                                    ->leftjoin('accomptes','accomptes.entreprise_id','=','entreprises.id')
                                    ->leftjoin('subventions','subventions.entreprise_id','=','entreprises.id')
                                    ->groupBy('banques.id',"banques.nom")
                                    ->select("banques.id","banques.nom", DB::raw("SUM(accomptes.montant)+SUM(subventions.montant_subvention) as montant"))
                                    ->get();
$subvention_par_banque= DB::table('entreprises')
                                    ->join('banques','entreprises.banque_id','=','banques.id')
                                    ->leftjoin('subventions','subventions.entreprise_id','=','entreprises.id')
                                    ->groupBy('banques.id',"banques.nom")
                                    ->select("banques.id","banques.nom", DB::raw("SUM(subventions.montant_subvention) as montant"))
                                    ->get();
$contrepartie_par_banque= DB::table('entreprises')
                                    ->join('banques','entreprises.banque_id','=','banques.id')
                                    ->where('entreprises.date_de_signature_accord_beneficiaire','!=', null)
                                    ->leftjoin('accomptes','accomptes.entreprise_id','=','entreprises.id')
                                    ->groupBy('banques.id',"banques.nom")
                                    ->select("banques.id","banques.nom", DB::raw("SUM(accomptes.montant) as montant"))
                                    ->get();
$contrepartie_par_secteur_dactivites= DB::table('entreprises')
                                    ->join('banques','entreprises.banque_id','=','banques.id')
                                    ->where('entreprises.date_de_signature_accord_beneficiaire','!=', null)
                                    ->leftjoin('accomptes','accomptes.entreprise_id','=','entreprises.id')
                                    ->leftjoin('valeurs','entreprises.secteur_activite','=','valeurs.id')
                                    ->groupBy("entreprises.secteur_activite","valeurs.libelle")
                                    ->select("entreprises.secteur_activite","valeurs.libelle as secteur", DB::raw("SUM(accomptes.montant) as montant"))
                                    ->get();
$subvention_par_secteur_dactivites= DB::table('entreprises')
                                    ->join('banques','entreprises.banque_id','=','banques.id')
                                    ->where('entreprises.date_de_signature_accord_beneficiaire','!=', null)
                                    ->leftjoin('subventions','subventions.entreprise_id','=','entreprises.id')
                                    ->leftjoin('valeurs','entreprises.secteur_activite','=','valeurs.id')
                                    ->groupBy("entreprises.secteur_activite","valeurs.libelle")
                                    ->select("entreprises.secteur_activite","valeurs.libelle as secteur", DB::raw("SUM(subventions.montant_subvention) as montant"))
                                    ->get();

    $mobilisation_par_categorie= DB::table('entreprises')
                                    ->leftjoin('accomptes','accomptes.entreprise_id','=','entreprises.id')
                                    ->leftjoin('subventions','subventions.entreprise_id','=','entreprises.id')
                                    ->where('entreprises.date_de_signature_accord_beneficiaire','!=', null)
                                    ->groupBy('entreprises.aopouleader')
                                    ->select('entreprises.aopOuleader as categorie', DB::raw("SUM(accomptes.montant)+SUM(subventions.montant_subvention) as montant"))
                                    ->get();
    $subvention_par_categorie= DB::table('entreprises')
                                    ->leftjoin('subventions','subventions.entreprise_id','=','entreprises.id')
                                     ->where('entreprises.date_de_signature_accord_beneficiaire','!=', null)
                                    ->groupBy('entreprises.aopouleader')
                                    ->select('entreprises.aopOuleader as categorie', DB::raw("SUM(subventions.montant_subvention) as montant"))
                                    ->get();
    $contrepartie_par_categorie= DB::table('entreprises')
                                    ->leftjoin('accomptes','accomptes.entreprise_id','=','entreprises.id')
                                    ->where('entreprises.date_de_signature_accord_beneficiaire','!=', null)
                                    ->groupBy('entreprises.aopouleader')
                                    ->select('entreprises.aopOuleader as categorie', DB::raw("SUM(accomptes.montant) as montant"))
                                    ->get();
    $devis_valides_par_banques= DB::table('banques')
                                    ->leftjoin('entreprises','entreprises.banque_id','=','banques.id')
                                    ->leftjoin('devis',function($join){
                                        $join->on('devis.entreprise_id','=','entreprises.id')
                                        ->where('devis.statut', 'validé');
                                    })
                                    ->select("banques.id","banques.nom", DB::raw("SUM(devis.montant_devis) as montant"),DB::raw("count(devis.id) as nombre"))
                                    ->groupBy('banques.id',"banques.nom")
                                    ->get();
    $devis_valides_par_categories= DB::table('entreprises')
                                    ->leftjoin('devis',function($join){
                                        $join->on('devis.entreprise_id','=','entreprises.id')
                                        ->where('devis.statut', 'validé');
                                    })
                                    ->select("entreprises.aopOuleader as categorie" , DB::raw("SUM(devis.montant_devis) as montant"),DB::raw("count(devis.id) as nombre"))
                                    ->groupBy('entreprises.aopOuleader')
                                    ->get();
                                    
 $facture_par_statut= DB::table('factures')
                                    ->groupBy('factures.statut')
                                    ->where('factures.statut','!=', 'transmis_au_chef_de_projet')
                                    ->select("factures.statut",DB::raw("COUNT(factures.id) as nombre"), DB::raw("SUM(factures.montant) as montant"))
                                    ->get();

$paiement_par_banque= DB::table('banques')
                                    ->leftjoin('entreprises','entreprises.banque_id','=','banques.id')
                                    ->leftjoin('factures',function($join){
                                        $join->on('factures.entreprise_id','=','entreprises.id')
                                        ->where('factures.statut', 'payée');
                                    })
                                    ->select("banques.id","banques.nom", DB::raw("SUM(factures.montant) as montant"),DB::raw("count(factures.id) as nombre"))
                                    ->groupBy('banques.id',"banques.nom")
                                    ->get();

 $paiement_en_attentes= DB::table('entreprises')
                                   ->leftjoin('factures',function($join){
                                        $join->on('factures.entreprise_id','=','entreprises.id')
                                        ->where('factures.statut', 'validé');
                                    })
                                    ->rightjoin('banques','entreprises.banque_id','=','banques.id')
                                    ->groupBy('banques.id',"banques.nom")
                                    ->select("banques.id","banques.nom", DB::raw("SUM(factures.montant) as montant"), DB::raw("count(factures.id) as nombre"))
                                    ->get();
$subvention_valide_par_banque= DB::table('entreprises')
                                    ->leftjoin('projets',function($join){
                                        $join->on('projets.entreprise_id','=','entreprises.id')
                                        ->where('entreprises.date_de_signature_accord_beneficiaire','!=', null);
                                    })
                                    ->join('investissement_projets','investissement_projets.projet_id','=','projets.id')
                                    ->rightjoin('banques','entreprises.banque_id','=','banques.id')
                                    ->groupBy('banques.nom')
                                    ->select('banques.nom as nom_banque', DB::raw("COUNT(projets.id) as nombre"), DB::raw("SUM(investissement_projets.subvention_demandee_valide) as montant"))
                                    ->get();

    return view("dashboard.detail_finance", compact('devis_valides_par_categories','devis_valides_par_banques','subvention_valide_par_banque','paiement_en_attentes','paiement_par_banque','facture_par_statut','montant_facture_enregistrees','contrepartie_par_categorie','contrepartie_par_banque','subvention_par_banque','subvention_par_categorie',
                                                    'mobilisation_par_categorie','mobilisation_par_banque','nombre_de_pca','fond_mobilise',
                                                    'total_souscription_enregistres','total_contrepartie_verse', 'total_subvention_verse',
                                                    'nombre_devis_soumis', 'montant_devis_soumis', 'montant_devi_valide', 'montant_facture_valide',
                                                    'montant_facture_payee','montant_facture_soumise','contrepartie_par_secteur_dactivites','subvention_par_secteur_dactivites'));
  }
  elseif($type_detail=='pca'){
   // $investissment
      $montant_total_pca_enregistre= InvestissementProjet::sum('montant');
      $montant_subvention_pca_enregistre= InvestissementProjet::sum('subvention_demandee');
      $montant_apport_pca_enregistre= InvestissementProjet::sum('apport_perso');
     $nombre_pca_selelctionnes= Projet::where('statut', 'selectionne')->count();
     $nombre_pca_mpme= DB::table('entreprises')
                        ->join('projets','projets.entreprise_id','=','entreprises.id')
                        ->where('entreprises.entrepriseaop',null)
                        ->count();
    $nombre_pca_aopleader= DB::table('entreprises')
                        ->join('projets','projets.entreprise_id','=','entreprises.id')
                        ->where('entreprises.entrepriseaop',1)
                        ->count();

     $nombre_pca_rejete= Projet::where('statut', 'rejete')->count();
     $montant_pca_rejete= DB::table('projets')
                        ->join('investissement_projets','investissement_projets.projet_id','=','projets.id')
                        ->where('projets.statut','rejete')
                        ->sum('investissement_projets.montant');
      $montant_pca_selectionne= DB::table('projets')
                        ->join('investissement_projets','investissement_projets.projet_id','=','projets.id')
                        ->where('projets.statut','selectionne')
                        ->sum('investissement_projets.montant');
    $pca_par_region= DB::table('entreprises')
                        ->join('projets','projets.entreprise_id','=','entreprises.id')
                        ->select("entreprises.region", DB::raw("COUNT(entreprises.region) as nombre"), DB::raw("SUM(projets.montant_demande) as montant"))
                        ->where('entreprises.entrepriseaop',null)
                        ->groupBy('entreprises.region')
                        ->get();
    $pca_aop_par_region= DB::table('entreprises')
                        ->join('projets','projets.entreprise_id','=','entreprises.id')
                        ->select("entreprises.region", DB::raw("COUNT(entreprises.region) as nombre"), DB::raw("SUM(projets.montant_demande) as montant"))
                        ->where('entreprises.entrepriseaop',1)
                        ->groupBy('entreprises.region')
                        ->get();

$pca_selectionne_par_region= DB::table('entreprises')
                        ->join('projets',function($join){
                            $join->on('projets.entreprise_id','=','entreprises.id')
                            ->where('projets.statut', '=', 'selectionné');
                        })
                        ->where('entreprises.entrepriseaop',null)
                        ->select( "entreprises.region", DB::raw("COUNT(entreprises.id) as nombre"), DB::raw("SUM(projets.montant_demande) as montant"))
                        ->groupBy('entreprises.region')
                        ->get();
$pca_aop_selectionne_par_region= DB::table('entreprises')
                        ->join('projets',function($join){
                            $join->on('projets.entreprise_id','=','entreprises.id')
                            ->where('projets.statut', '=', 'selectionné');
                        })
                        ->where('entreprises.entrepriseaop',1)
                        ->select( "entreprises.region", DB::raw("COUNT(entreprises.id) as nombre"), DB::raw("SUM(projets.montant_demande) as montant"))
                        ->groupBy('entreprises.region')
                        ->get();

$pca_selectionne_par_secteurs= DB::table('entreprises')
                        ->join('projets',function($join){
                            $join->on('projets.entreprise_id','=','entreprises.id')
                            ->where('projets.statut', '=', 'selectionné');
                        })
                        ->where('entreprises.entrepriseaop',null)
                        ->select( "entreprises.secteur_activite as secteur_dactivite" , DB::raw("COUNT(entreprises.secteur_activite) as nombre"), DB::raw("SUM(projets.montant_accorde) as montant"))
                        ->groupBy('entreprises.secteur_activite')
                        ->get();
    //dd($pca_selectionne_par_secteurs);
$pca_aop_selectionne_par_secteurs= DB::table('entreprises')
                        ->join('projets',function($join){
                            $join->on('projets.entreprise_id','=','entreprises.id')
                            ->where('projets.statut', '=', 'selectionné');
                        })
                        ->where('entreprises.entrepriseaop',1)
                        ->select( "entreprises.secteur_activite as secteur_dactivite" , DB::raw("COUNT(entreprises.secteur_activite) as nombre"), DB::raw("SUM(projets.montant_accorde) as montant"))
                        ->groupBy('entreprises.secteur_activite')
                        ->get();
 $pca_par_secteurs= DB::table('entreprises')
                        ->join('projets','projets.entreprise_id','=','entreprises.id')
                        ->select( "entreprises.secteur_activite as secteur_dactivite" , DB::raw("COUNT(entreprises.secteur_activite) as nombre"), DB::raw("SUM(projets.montant_demande) as montant"))
                        ->where('entreprises.entrepriseaop',null)
                        ->groupBy('entreprises.secteur_activite')
                        ->get();
 $pca_aop_par_secteurs= DB::table('entreprises')
                        ->join('projets','projets.entreprise_id','=','entreprises.id')
                        ->select( "entreprises.secteur_activite as secteur_dactivite" , DB::raw("COUNT(entreprises.secteur_activite) as nombre"), DB::raw("SUM(projets.montant_demande) as montant"))
                        ->where('entreprises.entrepriseaop',1)
                        ->groupBy('entreprises.secteur_activite')
                        ->get();
$pca_enregistre_par_categories= DB::table('entreprises')
                        ->leftjoin('projets','projets.entreprise_id','=','entreprises.id')
                        ->groupBy('entreprises.aopOuleader')
                        ->select('entreprises.aopOuleader as categorie', DB::raw("COUNT(projets.id) as nombre"))
                        ->get();
$pca_enregistes_par_banque= DB::table('entreprises')
                            ->join('projets',function($join){
                                $join->on('projets.entreprise_id','=','entreprises.id')
                                ->where('entreprises.entrepriseaop',null);
                            })
                        ->rightjoin('banques','entreprises.banque_id','=','banques.id')
                        ->groupBy('banques.nom')
                        ->select('banques.nom as nom_banque', DB::raw("COUNT(projets.id) as nombre"), DB::raw("SUM(projets.montant_demande) as montant"))
                        ->get();
                     
$pca_aop_enregistes_par_banque= DB::table('entreprises')
                                ->join('projets',function($join){
                                    $join->on('projets.entreprise_id','=','entreprises.id')
                                    ->where('entreprises.entrepriseaop',1);
                                })
                        ->rightjoin('banques','entreprises.banque_id','=','banques.id')
                        ->where('entreprises.entrepriseaop',1)
                        ->groupBy('banques.nom')
                        ->select('banques.nom as nom_banque', DB::raw("COUNT(projets.id) as nombre"), DB::raw("SUM(projets.montant_demande) as montant"))
                        ->get();
$pca_selectionne_par_banque= DB::table('entreprises')
                        ->leftjoin('projets',function($join){
                                $join->on('projets.entreprise_id','=','entreprises.id')
                                ->where('projets.statut', '=', 'selectionné');
                            })
                        ->where('entreprises.entrepriseaop',null)
                        ->rightjoin('banques','entreprises.banque_id','=','banques.id')
                        ->groupBy('banques.nom')
                        ->select('banques.nom as nom_banque', DB::raw("COUNT(projets.id) as nombre"), DB::raw("SUM(projets.montant_accorde) as montant"))
                        ->get();
$pca_aop_selectionne_par_banque= DB::table('entreprises')
                        ->leftjoin('projets',function($join){
                                $join->on('projets.entreprise_id','=','entreprises.id')
                                ->where('projets.statut', '=', 'selectionné');
                            })
                        ->where('entreprises.entrepriseaop',1)
                        ->rightjoin('banques','entreprises.banque_id','=','banques.id')
                        ->groupBy('banques.nom')
                        ->select('banques.nom as nom_banque', DB::raw("COUNT(projets.id) as nombre"), DB::raw("SUM(projets.montant_accorde) as montant"))
                        ->get();
// $pca_selectionne_par_secteurs= DB::table('entreprises')
//                         ->join('projets',function($join){
//                             $join->on('projets.entreprise_id','=','entreprises.id')
//                             ->where('projets.statut', '=', 'selectionné');
//                         })
//                         ->where('entreprises.entrepriseaop',null)
//                         ->select( "entreprises.secteur_activite as secteur_dactivite" , DB::raw("COUNT(entreprises.secteur_activite) as nombre"), DB::raw("SUM(projets.montant_demande) as montant"))
//                         ->groupBy('entreprises.secteur_activite')
//                         ->get();
$pca_aop_selectionne_par_secteurs= DB::table('entreprises')
                        ->join('projets',function($join){
                            $join->on('projets.entreprise_id','=','entreprises.id')
                            ->where('projets.statut', '=', 'selectionné');
                        })
                        ->where('entreprises.entrepriseaop',1)
                        ->select( "entreprises.secteur_activite as secteur_dactivite" , DB::raw("COUNT(entreprises.secteur_activite) as nombre"), DB::raw("SUM(projets.montant_demande) as montant"))
                        ->groupBy('entreprises.secteur_activite')
                        ->get();

 $pca_rejetes_par_secteurs= DB::table('entreprises')
                        ->join('projets',function($join){
                            $join->on('projets.entreprise_id','=','entreprises.id')
                            ->where('projets.statut', '=', 'rejeté');
                        })
                        ->where('entreprises.entrepriseaop',null)
                        ->select( "entreprises.secteur_activite as secteur_dactivite" , DB::raw("COUNT(entreprises.secteur_activite) as nombre"), DB::raw("SUM(projets.montant_demande) as montant"))
                        ->groupBy('entreprises.secteur_activite')
                        ->get();
$pca_aop_rejetes_par_secteurs= DB::table('entreprises')
                        ->join('projets',function($join){
                            $join->on('projets.entreprise_id','=','entreprises.id')
                            ->where('projets.statut', '=', 'rejeté');
                        })
                        ->where('entreprises.entrepriseaop',1)
                        ->select( "entreprises.secteur_activite as secteur_dactivite" , DB::raw("COUNT(entreprises.secteur_activite) as nombre"), DB::raw("SUM(projets.montant_demande) as montant"))
                        ->groupBy('entreprises.secteur_activite')
                        ->get();
$pca_rejete_par_region= DB::table('entreprises')
                        ->join('projets',function($join){
                            $join->on('projets.entreprise_id','=','entreprises.id')
                            ->where('projets.statut', '=', 'rejeté');
                        })
                        ->where('entreprises.entrepriseaop',null)
                        ->select( "entreprises.region", DB::raw("COUNT(entreprises.id) as nombre"), DB::raw("SUM(projets.montant_demande) as montant"))
                        ->groupBy('entreprises.region')
                        ->get();
$pca_aop_rejete_par_region= DB::table('entreprises')
                        ->join('projets',function($join){
                            $join->on('projets.entreprise_id','=','entreprises.id')
                            ->where('projets.statut', '=', 'rejeté');
                        })
                        ->where('entreprises.entrepriseaop',1)
                        ->select( "entreprises.region", DB::raw("COUNT(entreprises.id) as nombre", DB::raw("SUM(projets.montant_demande) as montant")))
                        ->groupBy('entreprises.region')
                        ->get();

$pca_selectionne_par_region= DB::table('entreprises')
                        ->join('projets',function($join){
                            $join->on('projets.entreprise_id','=','entreprises.id')
                            ->where('projets.statut', '=', 'selectionné');
                        })
                        ->where('entreprises.entrepriseaop',null)
                        ->select( "entreprises.region", DB::raw("COUNT(entreprises.id) as nombre"), DB::raw("SUM(projets.montant_accorde) as montant"))
                        ->groupBy('entreprises.region')
                        ->get();
$pca_aop_selectionne_par_region= DB::table('entreprises')
                        ->join('projets',function($join){
                            $join->on('projets.entreprise_id','=','entreprises.id')
                            ->where('projets.statut', '=', 'selectionné');
                        })
                        ->where('entreprises.entrepriseaop',1)
                        ->select( "entreprises.region", DB::raw("COUNT(entreprises.id) as nombre"), DB::raw("SUM(projets.montant_accorde) as montant"))
                        ->groupBy('entreprises.region')
                        ->get();
               
$pca_selectionne_par_categories = DB::table('entreprises')
                        ->leftjoin('projets',function($join){
                            $join->on('projets.entreprise_id','=','entreprises.id')
                            ->where('projets.statut', '=', 'selectionné');
                        })
                        ->groupBy('entreprises.aopouleader')
                        ->select('entreprises.aopOuleader as categorie', DB::raw("COUNT(projets.id) as nombre"))
                        ->get();
$pca_ajourne_par_categories = DB::table('entreprises')
                        ->leftjoin('projets',function($join){
                            $join->on('projets.entreprise_id','=','entreprises.id')
                            ->where('projets.statut','rejete');
                        })
                        ->groupBy('entreprises.aopouleader')
                        ->select('entreprises.aopOuleader as categorie', DB::raw("COUNT(projets.id) as nombre"))
                        ->get();
$demandes_de_KYC =   DB::table('entreprises')
                        ->leftjoin('projets','projets.entreprise_id','=','entreprises.id')
                        ->where('entreprises.date_demande_kyc','!=', null)
                        ->where('projets.statut','selectionné')
                        ->where('entreprises.entrepriseaop',null)
                        ->get();
$demandes_aop_de_KYC =   DB::table('entreprises')
                        ->leftjoin('projets','projets.entreprise_id','=','entreprises.id')
                        ->where('entreprises.date_demande_kyc','!=', null)
                        ->where('entreprises.entrepriseaop',1)
                        ->where('projets.statut','selectionné')
                        ->get();
$demandes_de_KYC_concluants = DB::table('entreprises')
                        ->leftjoin('projets','projets.entreprise_id','=','entreprises.id')
                        ->where('entreprises.resultat_kyc', 'concluant')
                        ->where('entreprises.entrepriseaop',null)
                        ->where('projets.statut','selectionné')
                        ->get();
$demandes_aop_de_KYC_concluants = DB::table('entreprises')
                        ->leftjoin('projets','projets.entreprise_id','=','entreprises.id')
                        ->where('entreprises.resultat_kyc', 'concluant')
                        ->where('entreprises.entrepriseaop',1)
                        ->where('projets.statut','selectionné')
                        ->get();
$demandes_de_KYC_concluants_par_banque =  DB::table('entreprises')
                                            ->leftjoin('projets',function($join){
                                                $join->on('projets.entreprise_id','=','entreprises.id')
                                                ->where('entreprises.resultat_kyc', 'concluant');
                                            })
                                            ->where('entreprises.entrepriseaop',null)
                                            ->rightjoin('banques','entreprises.banque_id','=','banques.id')
                                            ->groupBy('banques.nom')
                                            ->select('banques.nom as nom_banque', DB::raw("COUNT(projets.id) as nombre"), DB::raw("SUM(projets.montant_accorde) as montant"))
                                            ->get();
 $demandes_aop_de_KYC_concluants_par_banque =  DB::table('entreprises')
                                            ->leftjoin('projets',function($join){
                                                $join->on('projets.entreprise_id','=','entreprises.id')
                                                ->where('entreprises.resultat_kyc', 'concluant');
                                            })
                                            ->where('entreprises.entrepriseaop',1)
                                            ->rightjoin('banques','entreprises.banque_id','=','banques.id')
                                            ->groupBy('banques.nom')
                                            ->select('banques.nom as nom_banque', DB::raw("COUNT(projets.id) as nombre"), DB::raw("SUM(projets.montant_accorde) as montant"))
                                            ->get();
$demandes_de_KYC_par_banque =   DB::table('entreprises')
                                    ->leftjoin('projets',function($join){
                                        $join->on('projets.entreprise_id','=','entreprises.id')
                                        ->where('entreprises.date_demande_kyc','!=', null);
                                    })
                                    ->rightjoin('banques','entreprises.banque_id','=','banques.id')
                                    ->groupBy('banques.nom')
                                    ->select('banques.nom as nom_banque', DB::raw("COUNT(projets.id) as nombre"), DB::raw("SUM(projets.montant_accorde) as montant"))
                                    ->get();
$accord_beneficiaire_signe_par_banque=DB::table('entreprises')
                                        ->leftjoin('projets',function($join){
                                            $join->on('projets.entreprise_id','=','entreprises.id')
                                            ->where('entreprises.date_de_signature_accord_beneficiaire','!=', null)
                                            ->where('entreprises.entrepriseaop',null);
                                        })
                                        ->rightJoin('banques','entreprises.banque_id','=','banques.id')
                                        ->groupBy('banques.nom')
                                        ->select('banques.nom as nom_banque', DB::raw("COUNT(projets.id) as nombre"), DB::raw("SUM(projets.montant_accorde) as montant"))
                                        ->get();

$accord_beneficiaire_aop_signe_par_banque =DB::table('entreprises')
                                            ->leftjoin('projets',function($join){
                                                $join->on('projets.entreprise_id','=','entreprises.id')
                                                ->where('entreprises.date_de_signature_accord_beneficiaire','!=', null);
                                            })
                                            ->where('entreprises.entrepriseaop',1)
                                            ->rightjoin('banques','entreprises.banque_id','=','banques.id')
                                            ->groupBy('banques.nom')
                                            ->select('banques.nom as nom_banque', DB::raw("COUNT(projets.id) as nombre"), DB::raw("SUM(projets.montant_accorde) as montant"))
                                            ->get();
$accord_beneficiaire_signe_par_region =   DB::table('entreprises')
                                            ->join('valeurs','entreprises.region','=','valeurs.id')
                                            ->leftjoin('projets','projets.entreprise_id','=','entreprises.id')
                                            ->where('entreprises.date_de_signature_accord_beneficiaire','!=', null)
                                            ->where('entreprises.entrepriseaop',null)
                                            ->groupBy('valeurs.libelle')
                                            ->select('valeurs.libelle as region', DB::raw("COUNT(projets.id) as nombre"), DB::raw("SUM(projets.montant_accorde) as montant"))
                                            ->get();
$accord_beneficiaire_signe_par_secteur_dactivite = DB::table('entreprises')
                                                    ->join('valeurs','entreprises.secteur_activite','=','valeurs.id')
                                                    ->leftjoin('projets','projets.entreprise_id','=','entreprises.id')
                                                    ->where('entreprises.date_de_signature_accord_beneficiaire','!=', null)
                                                    ->groupBy('valeurs.libelle')
                                                    ->select('valeurs.libelle as secteur_activite', DB::raw("COUNT(projets.id) as nombre"), DB::raw("SUM(projets.montant_accorde) as montant"))
                                                    ->get();
// PCA par secteur d'activité et par region
$region_concernes=DB::select("select distinct region from entreprises");
$secteur_activites_concernes=DB::select("select distinct(secteur_activite)from entreprises");
//dd($secteur_activites_concernes);
$rows = array();
     $j=0;
     $i=0;
     $t=0;
     $k=0;
     $result = array();
foreach($secteur_activites_concernes as $secteur_activites_concerne){
   //dd($secteur_activites_concerne->secteur_activite);
   $rows = array();
  $secteur= intval($secteur_activites_concerne->secteur_activite);
    $rows['name']=getlibelle(intval($secteur));
    $pca_par_secteur=DB::select("select e.region as zone, count(e.id) as total from entreprises e INNER JOIN projets p on p.entreprise_id = e.id   AND e.secteur_activite=$secteur GROUP BY zone ");
    $tir=[];
    //dd($region_concernes);
    $p='';
for($k=0; $k< count($region_concernes); $k++){
        if($pca_par_secteur){

            for($j=0; $j< count($pca_par_secteur); $j++){

                $val=( $region_concernes[$k]->region == $pca_par_secteur[$j]->zone);
                if($val){

                        $t= intval($pca_par_secteur[$j]->total);
                    }
                else{
                       $t=0;
                    }

                }
                $p=$t.$p;
        }

       $tir[]=$t;
    }
   // dd($p);
    $rows['data']=$tir;
    array_push($result,$rows);
}
    // dd($result);

        return view("dashboard.detail_pca",compact('pca_aop_par_region','pca_aop_selectionne_par_secteurs','accord_beneficiaire_signe_par_secteur_dactivite','accord_beneficiaire_signe_par_region','accord_beneficiaire_signe_par_banque','accord_beneficiaire_aop_signe_par_banque','demandes_de_KYC_concluants_par_banque','demandes_aop_de_KYC_concluants_par_banque','demandes_de_KYC_par_banque','demandes_de_KYC_concluants','demandes_aop_de_KYC_concluants','demandes_de_KYC','pca_selectionne_par_region','pca_selectionne_par_secteurs','pca_enregistes_par_banque','pca_aop_enregistes_par_banque','pca_selectionne_par_banque','pca_aop_selectionne_par_banque','pca_ajourne_par_categories','pca_selectionne_par_categories','pca_enregistre_par_categories','nombre_de_pca','total_souscription_enregistres','fond_mobilise','montant_total_pca_enregistre',
                                                    'montant_subvention_pca_enregistre','montant_apport_pca_enregistre','nombre_pca_rejete',
                                                    'nombre_pca_selelctionnes','montant_pca_rejete','montant_pca_selectionne',
                                                    'nombre_pca_mpme', 'nombre_pca_aopleader', 'pca_par_region','pca_par_secteurs','pca_aop_par_secteurs', 'result','pca_aop_selectionne_par_region','pca_rejetes_par_secteurs','pca_aop_rejetes_par_secteurs','pca_aop_rejete_par_region','pca_rejete_par_region'));
}
elseif($type_detail=='impact'){
    $nombre_demploi_crees= Impact::whereIn('indicateur_id',[env('INDICATEURNBREEMPPF'),env('INDICATEURNBREEMPTF'),env('INDICATEURNBREEMPPH'),env('INDICATEURNBREEMPTH')])->sum('valeur_creee');
    $nombre_demploi_permanent_femme_crees= Impact::where('indicateur_id',env('INDICATEURNBREEMPPF'))->sum('valeur_creee');
    $nombre_demploi_temporaire_femme_crees= Impact::where('indicateur_id',env('INDICATEURNBREEMPTF'))->sum('valeur_creee');
    $nombre_demploi_permanent_homme_crees= Impact::where('indicateur_id',env('INDICATEURNBREEMPPH'))->sum('valeur_creee');
    $nombre_demploi_temporaire_homme_crees= Impact::where('indicateur_id',env('INDICATEURNBREEMPTH'))->sum('valeur_creee');
    $nombre_demploi_permanent_femme_conserves= Impact::where('indicateur_id',env('INDICATEURNBREEMPPF'))->sum('valeur_ref');
    $nombre_demploi_temporaire_femme_conserves= Impact::where('indicateur_id',env('INDICATEURNBREEMPTF'))->sum('valeur_ref');
    $nombre_demploi_permanent_homme_conserves= Impact::where('indicateur_id',env('INDICATEURNBREEMPPH'))->sum('valeur_ref');
    $nombre_demploi_temporaire_homme_conserves= Impact::where('indicateur_id',env('INDICATEURNBREEMPTH'))->sum('valeur_ref');
    $nombre_demploi_crees= $nombre_demploi_permanent_femme_crees+$nombre_demploi_temporaire_femme_crees+$nombre_demploi_temporaire_homme_crees+$nombre_demploi_permanent_homme_crees;
    $nombre_de_nouveaux_clients= Impact::where('indicateur_id',env('IDINDICATEUNEWCLIENT'))->sum('valeur_creee');
    $augmentation_du_chiffre_daffaire= Impact::where('indicateur_id',env('IDINDICATEURCHIFFREDAFFAIRE'))->sum('valeur_creee');
    $augmentation_du_benefice= Impact::where('indicateur_id',env('IDINDICATEURBENEFICE'))->sum('valeur_creee');
    $ind_nombre_mpme_forme = Indicateur::find(13);
    $ind_ressource_mobilise_mpme = Indicateur::find(env('IDINDICATEURRESMOBMPME'));
    $ind_ressource_mobilise_aop_el = Indicateur::find(env('IDINDICATEURRESMOBAOPEL'));
    $ind_nombre_aop_forme = Indicateur::find(12);
    $ind_nombre_emploi_cree = Indicateur::find(14);
    $acquisistions_valides_par_categories= DB::table('acquisitions')
                                            ->leftjoin('valeurs','acquisitions.categorie_invest','=','valeurs.id')
                                            ->where('acquisitions.acquis',1)
                                            ->select("valeurs.libelle as categorie","valeurs.description as description", DB::raw("SUM(acquisitions.cout_total) as montant"),DB::raw("count(acquisitions.id) as nombre"))
                                            ->groupBy('acquisitions.categorie_invest','valeurs.libelle','valeurs.description')
                                            ->get();
    $montant_total_des_aquisitions= Acquisition::where('acquis',1)->sum('cout_total');
    $acquisistions_valides_par_categories= DB::table('acquisitions')
                                                ->leftjoin('valeurs','acquisitions.categorie_invest','=','valeurs.id')
                                                ->where('acquisitions.acquis',1)
                                                ->select("valeurs.libelle as categorie","valeurs.description as description", DB::raw("SUM(acquisitions.cout_total) as montant"),DB::raw("count(acquisitions.id) as nombre"))
                                                ->groupBy('acquisitions.categorie_invest','valeurs.libelle','valeurs.description')
                                                ->get();
    $projet_selectionnes= Projet::where('statut', 'selectionné')->get();
            $total_contrepartie_suplementaire_mobilise= 0;
            $valeur=0;
        foreach($projet_selectionnes as $projet_selectionne){
            $total_de_la_contrepartie_mobilise= $projet_selectionne->entreprise->accomptes->sum('montant');
            $total_de_la_contrepartie_valide= $projet_selectionne->investissementvalides->sum('apport_perso');
            //la somme des contreparties à mobiliser et la somme mobilisé
             if( $total_de_la_contrepartie_mobilise > $total_de_la_contrepartie_valide ){
               $valeur= $total_de_la_contrepartie_mobilise - $total_de_la_contrepartie_valide;
              // dd($projet_selectionne);
              $total_contrepartie_suplementaire_mobilise = $total_contrepartie_suplementaire_mobilise+$valeur;
             }
             
        }
$contrepartie_mobilise= DB::table('entreprises')
                                            ->join('accomptes',function($join){
                                                $join->on('accomptes.entreprise_id','=','entreprises.id');
                                            })
                                            ->get();
$subvention_mobilise= DB::table('entreprises')
                                            ->join('subventions',function($join){
                                                $join->on('subventions.entreprise_id','=','entreprises.id');
                                            })
                                            ->get();
$mobilisation_de_ressource_mpme = $contrepartie_mobilise->where('aopOuleader','mpme')->sum('montant') + $subvention_mobilise->where('aopOuleader','mpme')->sum('montant_subvention'); 
$mobilisation_de_ressource_aop_el= $contrepartie_mobilise->where('aopOuleader','!=','mpme')->sum('montant') + $subvention_mobilise->where('aopOuleader','!=','mpme')->sum('montant_subvention'); 
$total_contrepartie_mobilise = Accompte::all()->sum('montant');
$total_subvention_mobilise = Subvention::all()->sum('montant_subvention');
$montant_total_mobilise=$total_contrepartie_mobilise + $total_subvention_mobilise;
if($montant_total_mobilise > 0 ){
    $proportion_de_contrepartie_mobilise = $total_contrepartie_mobilise/($montant_total_mobilise )*100;
}
else
 $proportion_de_contrepartie_mobilise =0;

$proportion_de_contrepartie_mobilise = round($proportion_de_contrepartie_mobilise,2);
$nombre_de_client_par_secteurdactivites = DB::table('entreprises')
                                            ->join('impacts',function($join){
                                                $join->on('impacts.entreprise_id','=','entreprises.id')
                                                ->where('impacts.indicateur_id',env('IDINDICATEUNEWCLIENT'));
                                            })
                                            ->leftJoin('valeurs','valeurs.id','=','entreprises.secteur_activite')
                                            ->groupBy('entreprises.secteur_activite','valeurs.libelle'  )
                                            ->select("valeurs.libelle as secteur_dactivite", DB::raw("SUM(impacts.valeur_ref) as nombre_avant"),DB::raw("SUM(impacts.valeur_resultat) as nombre_apres"))
                                            ->get();
$nombre_de_client_par_zones=  DB::table('entreprises')
                                            ->join('impacts',function($join){
                                                $join->on('impacts.entreprise_id','=','entreprises.id')
                                                ->where('impacts.indicateur_id',env('IDINDICATEUNEWCLIENT'));
                                            })
                                            ->leftJoin('valeurs','valeurs.id','=','entreprises.region')
                                            ->groupBy('entreprises.region','valeurs.libelle'  )
                                            ->select("valeurs.libelle as zone", DB::raw("SUM(impacts.valeur_ref) as nombre_avant"),DB::raw("SUM(impacts.valeur_resultat) as nombre_apres"))
                                            ->get();
$nombre_demploi_par_secteurdactivites= DB::table('entreprises')
                                            ->join('impacts',function($join){
                                                $join->on('impacts.entreprise_id','=','entreprises.id')
                                                ->whereIn('impacts.indicateur_id',[env('INDICATEURNBREEMPTF'),env('INDICATEURNBREEMPPH'),env('INDICATEURNBREEMPTH'),env('INDICATEURNBREEMPPF')]);
                                            })
                                            ->leftJoin('valeurs','valeurs.id','=','entreprises.secteur_activite')
                                            ->groupBy('entreprises.secteur_activite','valeurs.libelle'  )
                                            ->select("valeurs.libelle as secteur_dactivite", DB::raw("SUM(impacts.valeur_ref) as nombre_avant"),DB::raw("SUM(impacts.valeur_resultat) as nombre_apres"))
                                            ->get();
$nombre_demploi_par_zones = DB::table('entreprises')  
                                            ->join('impacts',function($join){
                                                $join->on('impacts.entreprise_id','=','entreprises.id')
                                                ->whereIn('impacts.indicateur_id',[env('INDICATEURNBREEMPTF'),env('INDICATEURNBREEMPPH'),env('INDICATEURNBREEMPTH'),env('INDICATEURNBREEMPPF')]);
                                            })
                                            ->leftJoin('valeurs','valeurs.id','=','entreprises.region')
                                            ->groupBy('entreprises.region','valeurs.libelle'  )
                                            ->select("valeurs.libelle as zone", DB::raw("SUM(impacts.valeur_ref) as nombre_avant"),DB::raw("SUM(impacts.valeur_resultat) as nombre_apres"))
                                            ->get();
      $ind_emp_permanent=  Indicateur::find(env('INDICATEURNBREEMPP'));
      $ind_emp_temporaire=  Indicateur::find(env('INDICATEURNBREEMPT'));

     $liste_indicateur_impacts= Indicateur::whereIn('id',[env('IDINDICATEURBENEFICE'),env('IDINDICATEURCHIFFREDAFFAIRE'),env('IDINDICATEUNEWCLIENT'),env('IDINDICATEURSALAUGMENTE')]) ->get();

                                // dd(count($beneficiaire_ayant_augmente_benefice));
    return view('dashboard.detail_impact',compact('ind_emp_permanent','ind_emp_temporaire','liste_indicateur_impacts','ind_ressource_mobilise_mpme','ind_ressource_mobilise_aop_el','mobilisation_de_ressource_mpme','mobilisation_de_ressource_aop_el','projet_selectionnes','proportion_de_contrepartie_mobilise','nombre_demploi_par_secteurdactivites','nombre_demploi_par_zones','nombre_de_client_par_zones','nombre_de_client_par_secteurdactivites','total_contrepartie_suplementaire_mobilise','montant_total_des_aquisitions','acquisistions_valides_par_categories','nombre_demploi_permanent_femme_conserves','nombre_demploi_temporaire_femme_conserves','nombre_demploi_permanent_homme_conserves','nombre_demploi_temporaire_homme_conserves','ind_nombre_emploi_cree','leader_AOP_formes','ind_nombre_aop_forme','mpme_formes','ind_nombre_mpme_forme','augmentation_du_chiffre_daffaire','augmentation_du_benefice','nombre_de_nouveaux_clients','nombre_demploi_crees','nombre_demploi_permanent_femme_crees','nombre_demploi_permanent_homme_crees','nombre_demploi_temporaire_femme_crees','nombre_demploi_temporaire_homme_crees','nombre_de_pca','fond_mobilise','total_souscription_enregistres'));
}


}

    public function dashboardgeo(){
        $entreprises=Entreprise::where("status",'!=',0)->orderBy('updated_at', 'desc')->where('entrepriseaop',null)->get();
        $entreprisesAOP=Entreprise::where("status",'!=',0)->where('entrepriseaop',1)->orderBy('updated_at', 'desc')->get();
        $entreprisesAOP_aformer=Entreprise::where("status",'!=',0)->where('entrepriseaop',1)->where("decision_du_comite_phase1", "selectionnee")->orderBy('updated_at', 'desc')->get();
        $decisions_retenu= Entreprise::where("decision_du_comite_phase1", "selectionnee")->where('entrepriseaop',null)->orderBy('updated_at', 'desc')->get();
        $mpme_formes= Entreprise::where("decision_du_comite_phase1", "selectionnee")->where('participer_a_la_formation', 1)->where('entrepriseaop',null)->orderBy('updated_at', 'desc')->get();
        $leader_AOP_formes=Entreprise::where("status",'!=',0)->where('entrepriseaop',1)->where("decision_du_comite_phase1", "selectionnee")->where('participer_a_la_formation', 1)->orderBy('updated_at', 'desc')->get();
        $total_mpme_formes=count($mpme_formes);
        $total_aop_leader_formes= count($leader_AOP_formes);
        $total_mpme_aformer= count($decisions_retenu);
        $total_mpme_enregistre= count($entreprises);
        $entreprisesLeaderAOP=count($entreprisesAOP);
        $nb_entreprisesAOP_aformer=count($entreprisesAOP_aformer);
        return view("dashboardgeo",compact("totalenregistres","decisions_retenu",'entreprisesLeaderAOP'));
    }
    public function dashboard( Request $request){
        $type_tableau_de_bord= $request->type_tableau_de_bord;
        //Verifier si l'utilisateur est un membre de commission
        $entreprises=Entreprise::where("status",'!=',0)->orderBy('updated_at', 'desc')->where('entrepriseaop',null)->get();
        $entreprisesAOP=Entreprise::where("status",'!=',0)->where('entrepriseaop',1)->orderBy('updated_at', 'desc')->get();
        $entreprisesAOP_aformer=Entreprise::where("status",'!=',0)->where('entrepriseaop',1)->where("decision_du_comite_phase1", "selectionnee")->orderBy('updated_at', 'desc')->get();
        $decisions_retenu= Entreprise::where("decision_du_comite_phase1", "selectionnee")->where('entrepriseaop',null)->orderBy('updated_at', 'desc')->get();
        $mpme_formes= Entreprise::where("decision_du_comite_phase1", "selectionnee")->where('participer_a_la_formation', 1)->where('entrepriseaop',null)->orderBy('updated_at', 'desc')->get();
        $leader_AOP_formes=Entreprise::where("status",'!=',0)->where('entrepriseaop',1)->where("decision_du_comite_phase1", "selectionnee")->where('participer_a_la_formation', 1)->orderBy('updated_at', 'desc')->get();
        $total_mpme_formes=count($mpme_formes);
        $total_aop_leader_formes= count($leader_AOP_formes);
        $total_mpme_aformer= count($decisions_retenu);
        $total_mpme_enregistre= count($entreprises);
        $entreprisesLeaderAOP=count($entreprisesAOP);
        $nb_entreprisesAOP_aformer=count($entreprisesAOP_aformer);

        //if(Auth::user()->structure_represente == null && Auth::user()->banque_id==null && Auth::user()->code_promoteur == null ){
           if($type_tableau_de_bord=='dashboard'){
                 return view("dashboard",compact("total_mpme_formes","total_aop_leader_formes","total_mpme_enregistre","total_mpme_aformer","entreprisesLeaderAOP","nb_entreprisesAOP_aformer"));
           }
           elseif($type_tableau_de_bord=='geodashboard'){
                return view("dashboardgeo",compact("total_mpme_formes","total_aop_leader_formes","total_mpme_enregistre","total_mpme_aformer","entreprisesLeaderAOP","nb_entreprisesAOP_aformer"));
           }
           else {
            return view("dashboardliste",compact("entreprises", "total_mpme_formes","total_aop_leader_formes","total_mpme_enregistre","total_mpme_aformer","entreprisesLeaderAOP","nb_entreprisesAOP_aformer"));

           }

    }
    public function dashboardliste()
    {
        $entreprises=Entreprise::where("status",'!=',0)->where('entrepriseaop',null)->orderBy('updated_at', 'desc')->get();
        $decisions_retenu= Entreprise::where("decision_du_comite_phase1", "selectionnee")->where('entrepriseaop',null)->orderBy('updated_at', 'desc')->get();
        $aopaformer= Entreprise::where("decision_du_comite_phase1", "selectionnee")->where('entrepriseaop',1)->orderBy('updated_at', 'desc')->get();
        $entreprisesAOP=Entreprise::where("status",'!=',0)->where('entrepriseaop',1)->orderBy('updated_at', 'desc')->get();
        $entreprisesLeaderAOP=count($entreprisesAOP);
        $decisions_retenu= count($decisions_retenu);
        $totalenregistres= count($entreprises);
        $nbaopaformer=count($aopaformer);
        return view("dashboardliste",compact("entreprises","totalenregistres","nbaopaformer","decisions_retenu","entreprisesLeaderAOP"));
    }
    public function listerallsouscription(Request $request){
        $categorieentreprise= $request->typeentreprise;
        ///dd($categorieentreprise);
        ($categorieentreprise=='mpme')?($categorieentreprise=null):($categorieentreprise=1);
        //$entreprises=Entreprise::where("status",'!=',0)->where('entrepriseaop',null)->orderBy('updated_at', 'desc')->get();

        $allsouscriptions = Entreprise::where("status",'!=',0)->where('entrepriseaop',$categorieentreprise)->orderBy('updated_at', 'desc')->get();
        foreach( $allsouscriptions as $value)
            {
               $toutesouscriptions[] = array('id'=>$value->id,'denomination'=>$value->denomination,'region'=>getlibelle($value->region),'province'=>getlibelle($value->province),'commune'=>getlibelle($value->commune),'arrondissement'=>getlibelle($value->arrondissement),'code_promoteur'=>$value->code_promoteur,'nombre_annee_experience'=>$value->nombre_annee_experience, 'secteur_activite'=>getlibelle($value->secteur_activite),'maillon_activite'=>getlibelle($value->maillon_activite));
            }
           //dd($toutesouscriptions);
        return json_encode($toutesouscriptions);
    }
    public function entreprise_retenues( Request $request)
    {
        //dd('oko');
        $categorieentreprise= $request->typeentreprise;
        $entreprise_formees= $request->forme;
       // ($request->forme==1)?($entreprise_formees=1):($entreprise_formees=0);
        ($categorieentreprise=='mpme')?($categorieentreprise=null):($categorieentreprise=1);
        //$entreprises_retenus=DB::select("select e.denomination, e.region, p.nombre_annee_experience, e.secteur_activite, e.maillon_activite FROM entreprises e , valeurs v, promotrices p where e.decision_du_comite_phase1= 'retenu' and e.region = v.id and e.entrepriseaop IS NULL ");
        $decisions_retenu= Entreprise::where("decision_du_comite_phase1", "selectionnee")->where('entrepriseaop',null)->orderBy('updated_at', 'desc')->get();
        if($entreprise_formees==0){
            $entreprises_retenus = Entreprise::where("decision_du_comite_phase1", "selectionnee")->where('entrepriseaop',$categorieentreprise)->orderBy('updated_at', 'desc')->get();
        }
        else{
            $entreprises_retenus = Entreprise::where("decision_du_comite_phase1", "selectionnee")->where('entrepriseaop',$categorieentreprise)->where('participer_a_la_formation',$entreprise_formees)->orderBy('updated_at', 'desc')->get();

        }
        $entreprises_retenu=[];
        foreach( $entreprises_retenus as $value)
            {
               // dd($entreprises_retenu->denomination);
               $entreprises_retenu[] = array('id'=>$value->id,'denomination'=>$value->denomination,'region'=>getlibelle($value->region),'province'=>getlibelle($value->province),'commune'=>getlibelle($value->commune),'arrondissement'=>getlibelle($value->arrondissement),'code_promoteur'=>$value->code_promoteur,'nombre_annee_experience'=>$value->nombre_annee_experience, 'secteur_activite'=>getlibelle($value->secteur_activite),'maillon_activite'=>getlibelle($value->maillon_activite));
            }
           // dd( $entreprises_retenu);
          // dd(json_encode($entreprises_retenus));
        return json_encode($entreprises_retenu);
    }

    // Cette fonction gere la partie graphique
    public function souscriptionretenueparsecteuractivite(Request $request)
    {
        $type_entreprise= $request->type_entreprise;
        $valeur_de_forme= $request->valeur_de_forme;
    if($valeur_de_forme==0){
        if($type_entreprise=='mpme'){
            $entreprises_retenus=DB::select("select  e.secteur_activite, v.libelle, COUNT(e.id) as nombre FROM entreprises e , valeurs v where e.decision_du_comite_phase1= 'selectionnee' and e.secteur_activite = v.id and e.entrepriseaop IS NULL GROUP by e.secteur_activite, v.libelle");
        }
        else{
            $entreprises_retenus=DB::select("select  e.secteur_activite, v.libelle, COUNT(e.id) as nombre FROM entreprises e , valeurs v where e.decision_du_comite_phase1= 'selectionnee' and e.secteur_activite = v.id and e.entrepriseaop IS NOT NULL GROUP by e.secteur_activite, v.libelle");
        }

    }
    else{
        if($type_entreprise=='mpme'){
            $entreprises_retenus=DB::select("select  e.secteur_activite, v.libelle, COUNT(e.id) as nombre FROM entreprises e , valeurs v where e.decision_du_comite_phase1= 'selectionnee' and e.secteur_activite = v.id and e.entrepriseaop IS NULL and e.participer_a_la_formation= $valeur_de_forme GROUP by e.secteur_activite, v.libelle");
        }
        else{
            $entreprises_retenus=DB::select("select  e.secteur_activite, v.libelle, COUNT(e.id) as nombre FROM entreprises e , valeurs v where e.decision_du_comite_phase1= 'selectionnee' and e.secteur_activite = v.id and e.entrepriseaop IS NOT NULL and e.participer_a_la_formation= $valeur_de_forme GROUP by e.secteur_activite, v.libelle");
        }

    }
         //Entreprise:: $valeur_de_forme=$request->valeur_de_forme;where("decision_du_comite_phase1", "selectionnee")->where('entrepriseaop',null)->orderBy('updated_at', 'desc')->get();
        if($entreprises_retenus){
            foreach( $entreprises_retenus as $value)
            {
               $souscriptionreteunuephase1[] = array('secteur'=>$value->libelle, 'nombre'=>$value->nombre);
            }
            return json_encode($souscriptionreteunuephase1);
        }
         else
         return $souscriptionreteunuephase1=0;
    }
    public function souscriptionparsecteuractivite(){
        //select  p.categorie_id, v.libelle, SUM(l.quantite) as quantiteCmde FROM ligne_de_commandes l , produits p, valeurs v where p.categorie_id = v.id and l.produit_id = p.id GROUP by p.categorie_id, v.libelle;
       //$souscriptionsParsecteur= DB::select("select  e.secteur_activite, v.libelle, COUNT(distinct(e.id)) as nombre FROM entreprises e , valeurs v where e.secteur_activite = v.id and e.entrepriseaop IS NULL and e.updated_at BETWEEN '2022-05-27 00-00-00' AND '2022-07-01 00-00-00' AND e.status=1 GROUP by e.secteur_activite, v.libelle");
       $souscriptionsParsecteur= DB::select('select  e.secteur_activite, v.libelle, COUNT(e.id) as nombre FROM entreprises e , valeurs v where e.secteur_activite = v.id  and e.status=1 GROUP by e.secteur_activite, v.libelle');
        $datacategorie=[];
            foreach( $souscriptionsParsecteur as $value)
            {
               $datacategorie[] = array('secteur'=>$value->libelle, 'nombre'=>$value->nombre);
            }
            return json_encode($datacategorie);
}


// Fonction d'affichage des satitistique des aop enregistrer par secteur d'activivite
public function aopparsecteuractivite(Request $request){
    $type_entreprise= $request->type_entreprise;
    $statut= $request->statut;
    if($type_entreprise=='mpme'&& $statut=='nostatut'){
        $souscriptionsParsecteur= DB::select('select  e.secteur_activite, v.libelle, COUNT(e.id) as nombre FROM entreprises e , valeurs v where e.secteur_activite = v.id and e.entrepriseaop is NULL and e.description_du_projet IS NOT NULL GROUP by e.secteur_activite, v.libelle');
    }
    elseif($type_entreprise=='aop'&& $statut=='nostatut'){
    $souscriptionsParsecteur= DB::select('select  e.secteur_activite, v.libelle, COUNT(e.id) as nombre FROM entreprises e , valeurs v where e.secteur_activite = v.id and e.entrepriseaop=1 and e.description_du_projet IS NOT NULL GROUP by e.secteur_activite, v.libelle');
    }
    elseif($type_entreprise=='mpme'&& $statut=='rejette'){
        $souscriptionsParsecteur= DB::select("select  e.secteur_activite, v.libelle, COUNT(e.id) as nombre FROM entreprises e , valeurs v where e.secteur_activite = v.id and e.entrepriseaop  is NULL and e.decision_du_comite_phase1='ajournee' and e.description_du_projet IS NOT NULL GROUP by e.secteur_activite, v.libelle");
    }
    else{
        $souscriptionsParsecteur= DB::select("select  e.secteur_activite, v.libelle, COUNT(e.id) as nombre FROM entreprises e , valeurs v where e.secteur_activite = v.id and e.entrepriseaop=1 and e.decision_du_comite_phase1='ajournee' and e.description_du_projet IS NOT NULL GROUP by e.secteur_activite, v.libelle");

    }
    //select  p.categorie_id, v.libelle, SUM(l.quantite) as quantiteCmde FROM ligne_de_commandes l , produits p, valeurs v where p.categorie_id = v.id and l.produit_id = p.id GROUP by p.categorie_id, v.libelle;
    $datacategorie=[];
        foreach( $souscriptionsParsecteur as $value)
        {
           $datacategorie[] = array('secteur'=>$value->libelle, 'nombre'=>$value->nombre);
        }
        return json_encode($datacategorie);
}

public function enregistreSecteurActiviteZone()
{
   $souscriptionsParsecteur= DB::select('select  e.region, e.secteur_activite,  COUNT(e.id) as nombre FROM entreprises e  where e.entrepriseaop IS NULL and e.status=1 GROUP by e.secteur_activite, e.region ORDER BY e.region');

        foreach( $souscriptionsParsecteur as $value)
        {
           $datasecteurregion[] = array('region'=>getlibelle($value->region), 'nombre'=>$value->nombre, 'secteur'=>getlibelle($value->secteur_activite));
        }
        return json_encode($datasecteurregion);
}
//fonction pour le représentation graphique de souscriptions enregistrées par zone
public function souscriptionparzone(Request $request)
{
   $souscriptionsParsecteur= DB::select('select  e.region, v.libelle, COUNT(e.id) as nombre FROM entreprises e , valeurs v where e.region = v.id  and e.status=1  GROUP by e.region, v.libelle');
    $datacategorie=[];
        foreach( $souscriptionsParsecteur as $value)
        {
           $datacategorie[] = array('region'=>$value->libelle, 'nombre'=>$value->nombre);
        }
        return json_encode($datacategorie);
}
public function aopregisterparzone(Request $request)
{  $type_entreprise= $request->type_entreprise;
    $statut= $request->statut;
    if($request->type_entreprise=='mpme' && $statut=='nostatut'){
            $souscriptionsParzone= DB::select('select  e.region, v.libelle, COUNT(e.id) as nombre FROM entreprises e , valeurs v where e.region = v.id and e.entrepriseaop is null and e.status=1  GROUP by e.region, v.libelle');
    }
    elseif($request->type_entreprise=='aop' && $statut=='nostatut'){
        $souscriptionsParzone= DB::select('select  e.region, v.libelle, COUNT(e.id) as nombre FROM entreprises e , valeurs v where e.region = v.id and e.entrepriseaop= 1 and e.status=1  GROUP by e.region, v.libelle');
    }
    elseif($request->type_entreprise=='aop' && $statut=='rejette'){
        $souscriptionsParzone= DB::select("select  e.region, v.libelle, COUNT(e.id) as nombre FROM entreprises e , valeurs v where e.region = v.id and e.entrepriseaop= 1 and e.decision_du_comite_phase1='ajournee' and e.status=1  GROUP by e.region, v.libelle");
    }
    elseif($request->type_entreprise=='mpme' && $statut=='rejette'){
        $souscriptionsParzone= DB::select("select  e.region, v.libelle, COUNT(e.id) as nombre FROM entreprises e , valeurs v where e.region = v.id and  e.decision_du_comite_phase1='ajournee' and e.entrepriseaop IS NULL and e.status=1  GROUP by e.region, v.libelle");

    }
    $datacategorie=[];
        foreach( $souscriptionsParzone as $value)
        {
           $datacategorie[] = array('region'=>$value->libelle, 'nombre'=>$value->nombre);
        }
        return json_encode($datacategorie);
}
public function entreprisepreselectionneparzone(Request $request)
{
    $type_entreprise= $request->type_entreprise;
    $valeur_de_forme= $request->valeur_de_forme;
 if($valeur_de_forme==0){
        if($type_entreprise=='mpme'){
            $souscriptionsParsecteur= DB::select("select  e.region, v.libelle, COUNT(e.id) as nombre FROM entreprises e , valeurs v where e.region = v.id and e.entrepriseaop IS NULL and e.status=1 AND e.decision_du_comite_phase1='selectionnee'  GROUP by e.region, v.libelle");
        }
        else{
            $souscriptionsParsecteur= DB::select("select  e.region, v.libelle, COUNT(e.id) as nombre FROM entreprises e , valeurs v where e.region = v.id and e.entrepriseaop IS NOT NULL and e.status=1 AND e.decision_du_comite_phase1='selectionnee'  GROUP by e.region, v.libelle");

        }
    }
    else{
        if($type_entreprise=='mpme'){
            $souscriptionsParsecteur= DB::select("select  e.region, v.libelle, COUNT(e.id) as nombre FROM entreprises e , valeurs v where e.region = v.id and e.entrepriseaop IS NULL and e.status=1 AND e.decision_du_comite_phase1='selectionnee' and e.participer_a_la_formation= $valeur_de_forme GROUP by e.region, v.libelle");
        }
        else{
            $souscriptionsParsecteur= DB::select("select  e.region, v.libelle, COUNT(e.id) as nombre FROM entreprises e , valeurs v where e.region = v.id and e.entrepriseaop IS NOT NULL and e.status=1 AND e.decision_du_comite_phase1='selectionnee' and e.participer_a_la_formation= $valeur_de_forme GROUP by e.region, v.libelle");

        }
}
    $dataregion=[];
    if($souscriptionsParsecteur){
        foreach( $souscriptionsParsecteur as $value)
        {
           $dataregion[] = array('region'=>$value->libelle, 'nombre'=>$value->nombre);
        }
        //dd($dataregion);
        return json_encode($dataregion);
    }
        else
         return $dataregion=0;
}
//selection des aop ou leader enregistés pour la phase de formation par région
public function aoppreselectionneparzone()
{
   $souscriptionsParsecteur= DB::select("select  e.region, v.libelle, COUNT(e.id) as nombre FROM entreprises e , valeurs v where e.region = v.id and e.entrepriseaop=1 and e.status=1 AND e.decision_du_comite_phase1='selectionnee' GROUP by e.region, v.libelle");
    $datacategorie=[];
        foreach( $souscriptionsParsecteur as $value)
        {
           $dataregion[] = array('region'=>$value->libelle, 'nombre'=>$value->nombre);
        }
        return json_encode($dataregion);
}
//La géoprésentation des MPME enregistés
public function beneficiairegeopresenation(Request $request )
{
   $type_entreprise= $request->type_entreprise;
   $souscriptionsgeo= Entreprise::where("aopOuleader",$type_entreprise)->get();
    $datageo=[];
        foreach( $souscriptionsgeo as $value)
        {
           $datageo[] = array('id'=>$value->id,'denomination'=>$value->denomination,'telephone'=>$value->telephone_entreprise, 'longitude'=>$value->longitude, 'latitude'=>$value->latitude, 'secteur_activite'=> getlibelle($value->secteur_activite),'region'=>getlibelle($value->region) );
        }
        return json_encode($datageo);

}
public function souscriptiongeopresenation()
{
  // $souscriptionsgeo= Entreprise::where("decision_du_comite_phase1","selectionnee")->get();
   $souscriptionsgeo= Entreprise::all();

    $datageo=[];
        foreach( $souscriptionsgeo as $value)
        {
           $datageo[] = array('id'=>$value->id,'denomination'=>$value->denomination,'telephone'=>$value->telephone_entreprise, 'longitude'=>$value->longitude, 'latitude'=>$value->latitude, 'secteur_activite'=> getlibelle($value->secteur_activite),'region'=>getlibelle($value->region) );
        }
        return json_encode($datageo);

}
public function entreprise_forme_geopresenation(Request $request )
{
   $type_entreprise= $request->type_entreprise;
   $forme= $request->valeur_de_forme;
   if($forme==1){
    $souscriptionsgeo= Entreprise::where("aopOuleader",$type_entreprise)->where("decision_du_comite_phase1","selectionnee")->where('participer_a_la_formation',$forme)->get();
   }
   else{
    $souscriptionsgeo= Entreprise::where("aopOuleader",$type_entreprise)->where("decision_du_comite_phase1","selectionnee")->get();
   }
    $datageo=[];
        foreach( $souscriptionsgeo as $value)
        {
           $datageo[] = array('id'=>$value->id,'denomination'=>$value->denomination,'telephone'=>$value->telephone_entreprise, 'longitude'=>$value->longitude, 'latitude'=>$value->latitude, 'secteur_activite'=> getlibelle($value->secteur_activite),'region'=>getlibelle($value->region) );
        }

        return json_encode($datageo);
}
public function entreprise_detail($id){

   $entreprise= Entreprise::find($id);
   $piecejointes=Piecejointe::where('entreprise_id', $entreprise->id)->get();
   return view('dashboard.detail_entreprise', compact('entreprise','piecejointes'));
}
public function dashboard_bank(){
if(Auth::user()->can('dashboard_bank')){ 
    $nombre_facture_a_paye= DB::table('factures')
                            ->join('entreprises','factures.entreprise_id','=','entreprises.id')
                            ->where('factures.statut','validé')
                            ->where('entreprises.banque_id',Auth::user()->banque_id)
                            ->count();
    $montant_des_projets_de_la_banque= DB::table('entreprises')
                                ->leftjoin('projets',function($join){
                                    $join->on('projets.entreprise_id','=','entreprises.id')
                                    ->where('entreprises.date_de_signature_accord_beneficiaire','!=', null);
                                })
                            ->where('entreprises.banque_id',Auth::user()->banque_id)
                            ->sum('projets.montant_accorde');
    $nombre_facture_payes= DB::table('factures')
                            ->join('entreprises','factures.entreprise_id','=','entreprises.id')
                            ->where('factures.statut','payée')
                            ->where('entreprises.banque_id',Auth::user()->banque_id)
                            ->count();
   $montant_contrepartie_par_bank= DB::table('accomptes')
                            ->join('entreprises','accomptes.entreprise_id','=','entreprises.id')
                            ->join('banques','entreprises.banque_id','=','banques.id')
                            ->where('entreprises.banque_id',Auth::user()->banque_id)
                            ->sum('accomptes.montant');

    $montant_subvention_par_bank= DB::table('subventions')
                            ->join('entreprises','subventions.entreprise_id','=','entreprises.id')
                            ->join('banques','entreprises.banque_id','=','banques.id')
                            ->where('entreprises.banque_id',Auth::user()->banque_id)
                            ->sum('subventions.montant_subvention');
    $factures_validees= DB::table('factures')
                            ->join('entreprises','factures.entreprise_id','=','entreprises.id')
                            ->where('entreprises.banque_id',Auth::user()->banque_id)
                            ->where('factures.statut','validé')
                            ->select('factures.id as facture_id', 'factures.montant' , 'factures.mode_de_paiement',  'factures.date_de_validation', 'factures.date_de_paiement', 'factures.num_facture', 'entreprises.telephone_entreprise', 'entreprises.denomination', 'factures.num_facture')
                            ->get();
    $factures_payees= DB::table('factures')
                            ->join('entreprises','factures.entreprise_id','=','entreprises.id')
                            ->where('entreprises.banque_id',Auth::user()->banque_id)
                            ->where('factures.statut','payée')
                            ->select('factures.id as facture_id', 'factures.montant as montant' , 'factures.mode_de_paiement', 'factures.num_facture', 'factures.date_de_paiement','factures.date_de_validation' ,'entreprises.telephone_entreprise', 'entreprises.denomination', 'factures.num_facture')
                            ->get();


    $beneficiaire_par_banks= Entreprise::where("date_de_signature_accord_beneficiaire",'!=',null)->where("date_de_creation_compte",'!=',null)->where('entreprises.banque_id',Auth::user()->banque_id)->get();
    $contrepartie_par_banks= DB::table('accomptes')
                            ->join('entreprises',function($join){
                                $join->on('accomptes.entreprise_id','=','entreprises.id')
                                ->where('entreprises.banque_id',Auth::user()->banque_id);
                                })
                            ->where("date_de_signature_accord_beneficiaire",'!=',null)
                            ->get();
    $subvention_par_banks= DB::table('subventions')
                        ->join('entreprises','subventions.entreprise_id','=','entreprises.id')
                        ->where("banque_id",Auth::user()->banque_id)
                        ->where("date_de_signature_accord_beneficiaire",'!=',null)
                        ->select('subventions.montant_subvention as montant' , 'subventions.date_subvention as date_subvention', 'entreprises.denomination', 'entreprises.telephone_entreprise')
                        ->get();
  // dd($contrepartie_par_banks);
    $montant_total_mobilise_par_banque= $contrepartie_par_banks->sum('montant') + $subvention_par_banks->sum('montant');
    return view('banque.dashboard', compact('montant_des_projets_de_la_banque','contrepartie_par_banks','subvention_par_banks','factures_validees','factures_payees','beneficiaire_par_banks','nombre_facture_a_paye','nombre_facture_payes','montant_total_mobilise_par_banque', 'beneficiaire_par_banks') );
}
else{
    flash("Vous n'avez pas ce droit. Bien vouloir contacter l'administrateur")->error();
    return redirect()->back();
}

}

function dashboard_banque_perform(){
if(Auth::user()->can('tableau.debord')){ 
    $facture_valides_par_banques= DB::table('banques')
                            ->leftjoin('entreprises','entreprises.banque_id','=','banques.id')
                            ->leftjoin('factures',function($join){
                                $join->on('factures.entreprise_id','=','entreprises.id')
                           // ->where('factures.statut','=','validé')
                                ->whereIn('factures.statut',['payée','validé']);
                                })
                            ->select("banques.id","banques.nom as nom_banque", DB::raw("SUM(factures.montant) as montant"),DB::raw("count(factures.id) as nombre"))
                            ->groupBy('banques.id',"banques.nom")
                            ->get();
$contrepartie_mobilise_par_banques= DB::table('banques')
                            ->leftjoin('entreprises','entreprises.banque_id','=','banques.id')
                            ->leftjoin('accomptes',function($join){
                                $join->on('accomptes.entreprise_id','=','entreprises.id');
                                })
                            ->select("banques.id","banques.nom as nom_banque", DB::raw("SUM(accomptes.montant) as montant"),DB::raw("count(accomptes.id) as nombre"))
                            ->groupBy('banques.id',"banques.nom")
                            ->get(); 
$subvention_mobilise_par_banques= DB::table('banques')
                                ->leftjoin('entreprises','entreprises.banque_id','=','banques.id')
                                ->leftjoin('subventions',function($join){
                                    $join->on('subventions.entreprise_id','=','entreprises.id');
                                    })
                                ->select("banques.id","banques.nom as nom_banque", DB::raw("SUM(subventions.montant_subvention) as montant"),DB::raw("count(subventions.id) as nombre"))
                                ->groupBy('banques.id',"banques.nom")
                                ->get();
        
    $facture_a_payees_par_banques= DB::table('banques')
                                    ->leftjoin('entreprises','entreprises.banque_id','=','banques.id')
                                    ->leftjoin('factures',function($join){
                                        $join->on('factures.entreprise_id','=','entreprises.id')
                                        ->where('factures.statut','=','validé');
                                    })
                                    ->select("banques.id","banques.nom as nom_banque", DB::raw("SUM(factures.montant) as montant"),DB::raw("count(factures.id) as nombre"))
                                    ->groupBy('banques.id',"banques.nom")
                                    ->get();
    $facture_payes_par_banques= DB::table('banques')
                                    ->leftjoin('entreprises','entreprises.banque_id','=','banques.id')
                                    ->leftjoin('factures',function($join){
                                        $join->on('factures.entreprise_id','=','entreprises.id')
                                        ->where('factures.statut', 'payée');
                                    })
                                    ->select("banques.id","banques.nom as nom_banque", DB::raw("SUM(factures.montant) as montant"),DB::raw("count(factures.id) as nombre"))
                                    ->groupBy('banques.id',"banques.nom")
                                    ->get();
     $montant_a_mobilise_par_banque= DB::table('entreprises')
                                ->leftjoin('projets',function($join){
                                    $join->on('projets.entreprise_id','=','entreprises.id')
                                    ->where('entreprises.date_de_signature_accord_beneficiaire','!=', null);
                                })
                                ->rightjoin('banques','entreprises.banque_id','=','banques.id')
                                ->groupBy('banques.id','banques.nom')
                                ->select('banques.nom as nom_banque', DB::raw("COUNT(projets.id) as nombre"), DB::raw("SUM(projets.montant_accorde) as montant"))
                                ->get();
//dd(($subvention_mobilise_par_banques->sum('montant') + $contrepartie_mobilise_par_banques->sum('montant')));

$montant_projet_valide_par_comites= DB::table('entreprises')
                                ->leftjoin('projets',function($join){
                                    $join->on('projets.entreprise_id','=','entreprises.id')
                                    ->where('projets.statut', 'selectionné');
                                })
                                ->rightjoin('banques','entreprises.banque_id','=','banques.id')
                                ->groupBy('banques.id','banques.nom')
                                ->select('banques.nom as nom_banque', DB::raw("COUNT(projets.id) as nombre"), DB::raw("SUM(projets.montant_accorde) as montant"))
                                ->get();

$taux_de_consommation_par_banque= DB::table('entreprises')
                                ->leftjoin('projets',function($join){
                                    $join->on('projets.entreprise_id','=','entreprises.id')
                                    ->where('entreprises.date_de_signature_accord_beneficiaire','!=', null);
                                })
                                ->leftjoin('factures',function($join){
                                    $join->on('factures.entreprise_id','=','entreprises.id')
                                    ->where('factures.statut', 'payée');
                                })
                                ->rightjoin('banques','entreprises.banque_id','=','banques.id')
                                ->groupBy('banques.id','banques.nom')
                                ->select('banques.nom as nom_banque' , DB::raw("SUM(factures.montant) as montant_decaisse"), DB::raw("SUM(projets.montant_accorde) as montant_a_mobilise"))
                                ->get();
                               
    $financement_par_banks= DB::select('select  b.nom as nom_banque, b.id, SUM(s.montant_subvention) as montant_subvention,
                                SUM(a.montant) AS montant_contrepartie from banques b LEFT JOIN entreprises e ON e.banque_id = b.id
                                LEFT JOIN accomptes a ON a.entreprise_id=e.id
                                LEFT JOIN subventions s ON s.entreprise_id=e.id
                                GROUP BY b.id, b.nom');

    
                                                //dd($nombre_de_dossier_rejete_par_les_banques);
              
    return view('dashboard.banque_perform', compact('montant_projet_valide_par_comites','contrepartie_mobilise_par_banques','subvention_mobilise_par_banques','financement_par_banks','facture_valides_par_banques','facture_payes_par_banques','financement_par_banks','montant_a_mobilise_par_banque','facture_a_payees_par_banques','taux_de_consommation_par_banque'));
}
else
{
    flash("Vous n'avez pas ce droit. Bien vouloir contacter l'administrateur")->error();
    return redirect()->back();
}
}

}
