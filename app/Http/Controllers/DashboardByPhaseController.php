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

class DashboardByPhaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['souscriptiongeopresenation','souscriptionparzone','souscriptiongeopresenation','aopparsecteuractivite','entreprisepreselectionneparzone','souscriptionparzone','souscriptionparsecteuractivite','souscriptionretenueparsecteuractivite','aopregisterparzone','enregistreSecteurActiviteZone']);
    }
public function detail_dashboard(Request $request){
    $type_detail= $request->type_detail;
    $phase= $request->phase;
    $contre_partie_mobilise= DB::table('accomptes')
                                        ->join('entreprises','entreprises.id','=','accomptes.entreprise_id')
                                        ->where('entreprises.phase_projet', $phase)
                                        ->sum('montant');
        
    $pca_enregistres= DB::table('projets')
                                    ->join('entreprises','entreprises.id','=','projets.entreprise_id')
                                    ->where('entreprises.phase_projet', $phase)
                                    ->count();
    $subvention_debloque=DB::table('subventions')
                            ->join('entreprises','entreprises.id','=','subventions.entreprise_id')
                            ->where('entreprises.phase_projet', $phase)
                            ->sum('subventions.montant_subvention');

    $nombre_de_pca= $pca_enregistres;
    $fond_mobilise= $contre_partie_mobilise + $subvention_debloque;
    $total_souscription_enregistres=Entreprise::where("status",'!=',0)->where('phase_projet', $phase)->orderBy('updated_at', 'desc')->count();
if($phase==1){
    $dash_phase = 'dashboard_detail_appui_1';
}
else{
    $dash_phase = 'dashboard_detail_appui_2';
}
//dd($dash_phase);
    
  if($type_detail=='mpme'){
    $total_mpme_enregistre=Entreprise::where("status",'!=',0)->orderBy('updated_at', 'desc')->where('entrepriseaop',null)->where('phase_projet', $phase)->count();
    $leader_AOP_formes=Entreprise::where("status",'!=',0)->where('entrepriseaop',1)->where("decision_du_comite_phase1", "selectionnee")->where('participer_a_la_formation', 1)
                                        ->where('phase_projet', $phase)->orderBy('updated_at', 'desc')->get();
    $mpme_formes= Entreprise::where("decision_du_comite_phase1", "selectionnee")->where('participer_a_la_formation', 1)->where('entrepriseaop',null)->where('phase_projet', $phase)->get();
    $total_mpme_enregistre=Entreprise::where("status",'!=',0)->orderBy('updated_at', 'desc')->where('entrepriseaop',null)->where('phase_projet', $phase)->count();
    $total_aop_leader_enregistres=Entreprise::where('entrepriseaop',1)->where("status",'!=',0)->where('phase_projet', $phase)->orderBy('updated_at', 'desc')->count();
    $entreprisesLeaderAOP_aformer=Entreprise::where("status",'!=',0)->where('entrepriseaop',1)->where("decision_du_comite_phase1", "selectionnee")->where('phase_projet', $phase)->count();
    $total_mpme_rejetes= Entreprise::where("decision_du_comite_phase1", "ajournee")->where('entrepriseaop',null)->where('phase_projet', $phase)->count();
    $total_aop_rejetes= Entreprise::where("decision_du_comite_phase1", "ajournee")->where('entrepriseaop',1)->orderBy('updated_at', 'desc')->where('phase_projet', $phase)->count();
    $total_mpme_aformation= Entreprise::where("decision_du_comite_phase1", "selectionnee")->where('entrepriseaop',null)->where('phase_projet', $phase)->count();
    $total_mpme_formes=count($mpme_formes);
    $total_mpme_formees= count($mpme_formes);
    $total_aopleader_formes=count($leader_AOP_formes);
    return view('dashboard.detail_mpme_appui', compact('phase','dash_phase','nombre_de_pca','fond_mobilise','total_mpme_rejetes','total_aop_rejetes','total_mpme_enregistre','total_souscription_enregistres', 'total_aop_leader_enregistres', 'total_mpme_aformation', 'total_mpme_formes','entreprisesLeaderAOP_aformer','total_aopleader_formes'));

  }
  elseif($type_detail=='finance'){
                    $total_subvention_verse=DB::table('subventions')
                                                ->join('entreprises','entreprises.id','=','subventions.entreprise_id')
                                                ->where('entreprises.phase_projet', $phase)
                                                ->sum('subventions.montant_subvention');
                    $total_contrepartie_verse=DB::table('accomptes')
                                                ->join('entreprises','entreprises.id','=','accomptes.entreprise_id')
                                                ->where('entreprises.phase_projet', $phase)
                                                ->sum('accomptes.montant');
                    $nombre_devis_soumis= DB::table('devis')
                                                ->join('entreprises','entreprises.id','=','devis.entreprise_id')
                                                ->where('entreprises.phase_projet', $phase)
                                                ->count();
                    $montant_devis_soumis= DB::table('devis')
                                                ->join('entreprises','entreprises.id','=','devis.entreprise_id')
                                                ->where('statut', '!=', 'soumis')
                                                ->where('entreprises.phase_projet', $phase)
                                                ->sum('montant_devis');
                    $nombre_devi_valide= DB::table('devis')
                                                ->join('entreprises','entreprises.id','=','devis.entreprise_id')
                                                ->where('statut', 'validé')
                                                ->where('entreprises.phase_projet', $phase)
                                                ->sum('montant_devis');
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
                                                    ->where('entreprises.phase_projet', $phase)
                                                    ->groupBy('banques.id',"banques.nom")
                                                    ->select("banques.id","banques.nom", DB::raw("SUM(accomptes.montant)+SUM(subventions.montant_subvention) as montant"))
                                                    ->get();
$subvention_par_banque= DB::table('entreprises')
                                    ->join('banques','entreprises.banque_id','=','banques.id')
                                    ->where('entreprises.phase_projet', $phase)
                                    ->leftjoin('subventions','subventions.entreprise_id','=','entreprises.id')
                                    ->groupBy('banques.id',"banques.nom")
                                    ->select("banques.id","banques.nom", DB::raw("SUM(subventions.montant_subvention) as montant"))
                                    ->get();
$contrepartie_par_banque= DB::table('entreprises')
                                    ->join('banques','entreprises.banque_id','=','banques.id')
                                    ->where('entreprises.phase_projet', $phase)
                                    ->where('entreprises.date_de_signature_accord_beneficiaire','!=', null)
                                    ->leftjoin('accomptes','accomptes.entreprise_id','=','entreprises.id')
                                    ->groupBy('banques.id',"banques.nom")
                                    ->select("banques.id","banques.nom", DB::raw("SUM(accomptes.montant) as montant"))
                                    ->get();
$contrepartie_par_secteur_dactivites= DB::table('entreprises')
                                    ->join('banques','entreprises.banque_id','=','banques.id')
                                    ->where('entreprises.phase_projet', $phase)
                                    ->where('entreprises.date_de_signature_accord_beneficiaire','!=', null)
                                    ->leftjoin('accomptes','accomptes.entreprise_id','=','entreprises.id')
                                    ->leftjoin('valeurs','entreprises.secteur_activite','=','valeurs.id')
                                    ->groupBy("entreprises.secteur_activite","valeurs.libelle")
                                    ->select("entreprises.secteur_activite","valeurs.libelle as secteur", DB::raw("SUM(accomptes.montant) as montant"))
                                    ->get();
$contrepartie_par_region= DB::table('entreprises')
                                ->where('entreprises.date_de_signature_accord_beneficiaire','!=', null)
                                ->where('entreprises.phase_projet', $phase)
                                ->leftjoin('accomptes','accomptes.entreprise_id','=','entreprises.id')
                                ->leftjoin('valeurs','entreprises.region','=','valeurs.id')
                                ->groupBy("entreprises.region","valeurs.libelle")
                                ->select("entreprises.region","valeurs.libelle as region", DB::raw("SUM(accomptes.montant) as montant"))
                                ->get();
$subvention_par_secteur_dactivites= DB::table('entreprises')
                                    ->where('entreprises.phase_projet', $phase)
                                    ->where('entreprises.date_de_signature_accord_beneficiaire','!=', null)
                                    ->leftjoin('subventions','subventions.entreprise_id','=','entreprises.id')
                                    ->leftjoin('valeurs','entreprises.secteur_activite','=','valeurs.id')
                                    ->groupBy("entreprises.secteur_activite","valeurs.libelle")
                                    ->select("entreprises.secteur_activite","valeurs.libelle as secteur", DB::raw("SUM(subventions.montant_subvention) as montant"))
                                    ->get();
$subvention_par_regions= DB::table('entreprises')
                            ->join('banques','entreprises.banque_id','=','banques.id')
                            
                            ->where('entreprises.date_de_signature_accord_beneficiaire','!=', null)
                            ->leftjoin('subventions','subventions.entreprise_id','=','entreprises.id')
                            ->leftjoin('valeurs','entreprises.region','=','valeurs.id')
                            ->where('entreprises.phase_projet', $phase)
                            ->groupBy("entreprises.region","valeurs.libelle")
                            ->select("entreprises.region","valeurs.libelle as region", DB::raw("SUM(subventions.montant_subvention) as montant"))
                            ->get();

$mobilisation_par_categorie= DB::table('entreprises')
                                    ->leftjoin('accomptes','accomptes.entreprise_id','=','entreprises.id')
                                    ->leftjoin('subventions','subventions.entreprise_id','=','entreprises.id')
                                    ->where('entreprises.date_de_signature_accord_beneficiaire','!=', null)
                                    ->where('entreprises.phase_projet', $phase)
                                    ->groupBy('entreprises.aopouleader')
                                    ->select('entreprises.aopOuleader as categorie', DB::raw("SUM(accomptes.montant)+SUM(subventions.montant_subvention) as montant"))
                                    ->get();
    $subvention_par_categorie= DB::table('entreprises')
                                    ->leftjoin('subventions','subventions.entreprise_id','=','entreprises.id')
                                    ->where('entreprises.phase_projet', $phase)
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
                                    ->where('entreprises.phase_projet', $phase)
                                    ->select("banques.id","banques.nom", DB::raw("SUM(devis.montant_devis) as montant"),DB::raw("count(devis.id) as nombre"))
                                    ->groupBy('banques.id',"banques.nom")
                                    ->get();
    $devis_valides_par_categories= DB::table('entreprises')
                                    ->leftjoin('devis',function($join){
                                        $join->on('devis.entreprise_id','=','entreprises.id')
                                        ->where('devis.statut', 'validé');
                                    })
                                    ->where('entreprises.phase_projet', $phase)
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
                                    ->where('entreprises.phase_projet', $phase)
                                    ->select("banques.id","banques.nom", DB::raw("SUM(factures.montant) as montant"),DB::raw("count(factures.id) as nombre"))
                                    ->groupBy('banques.id',"banques.nom")
                                    ->get();

 $paiement_en_attentes= DB::table('entreprises')
                                   ->leftjoin('factures',function($join){
                                        $join->on('factures.entreprise_id','=','entreprises.id')
                                        ->where('factures.statut', 'validé');
                                    })
                                    ->where('entreprises.phase_projet', $phase)
                                    ->rightjoin('banques','entreprises.banque_id','=','banques.id')
                                    ->groupBy('banques.id',"banques.nom")
                                    ->select("banques.id","banques.nom", DB::raw("SUM(factures.montant) as montant"), DB::raw("count(factures.id) as nombre"))
                                    ->get();
$subvention_valide_par_banque= DB::table('entreprises')
                                    ->leftjoin('projets',function($join){
                                        $join->on('projets.entreprise_id','=','entreprises.id')
                                        ->where('entreprises.date_de_signature_accord_beneficiaire','!=', null);
                                    })
                                    ->where('entreprises.phase_projet', $phase)
                                    ->join('investissement_projets','investissement_projets.projet_id','=','projets.id')
                                    ->rightjoin('banques','entreprises.banque_id','=','banques.id')
                                    ->groupBy('banques.nom')
                                    ->select('banques.nom as nom_banque', DB::raw("COUNT(projets.id) as nombre"), DB::raw("SUM(investissement_projets.subvention_demandee_valide) as montant"))
                                    ->get();

                                        //dd($dash_phase);
    return view("dashboard.detail_finance_appui", compact('phase','dash_phase','subvention_par_regions','contrepartie_par_region','devis_valides_par_categories','devis_valides_par_banques','subvention_valide_par_banque','paiement_en_attentes','paiement_par_banque','facture_par_statut','montant_facture_enregistrees','contrepartie_par_categorie','contrepartie_par_banque','subvention_par_banque','subvention_par_categorie',
                                                    'mobilisation_par_categorie','mobilisation_par_banque','nombre_de_pca','fond_mobilise',
                                                    'total_souscription_enregistres','total_contrepartie_verse', 'total_subvention_verse',
                                                    'nombre_devis_soumis', 'montant_devis_soumis', 'montant_devi_valide', 'montant_facture_valide',
                                                    'montant_facture_payee','montant_facture_soumise','contrepartie_par_secteur_dactivites','subvention_par_secteur_dactivites'));
  }
  elseif($type_detail=='pca'){
      $montant_total_pca_enregistre= InvestissementProjet::where('appui',2)->sum('montant');
      $nombre_pca_mpme= DB::table('entreprises')
                            ->join('projets','projets.entreprise_id','=','entreprises.id')
                            ->where('entreprises.entrepriseaop',null)
                            ->where('entreprises.phase_projet', $phase)
                            ->count();
      $nombre_pca_aopleader= DB::table('entreprises')
                            ->join('projets','projets.entreprise_id','=','entreprises.id')
                            ->where('entreprises.entrepriseaop',1)
                            ->where('entreprises.phase_projet', $phase)
                            ->count();
      $montant_subvention_pca_enregistre= InvestissementProjet::sum('subvention_demandee');
      $montant_apport_pca_enregistre= InvestissementProjet::sum('apport_perso');
      $nombre_pca_selelctionnes= DB::table('entreprises')
                                        ->join('projets','projets.entreprise_id','=','entreprises.id')
                                        ->where('statut', 'selectionne')
                                        ->where('entreprises.phase_projet', $phase)
                                        ->count();
     // Projet::where('statut', 'selectionne')->count();
      $nombre_pca_rejete=       DB::table('entreprises')
                                        ->join('projets','projets.entreprise_id','=','entreprises.id')
                                        ->where('statut', 'rejete')
                                        ->where('entreprises.phase_projet', $phase)
                                        ->count();
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
                        ->where('entreprises.phase_projet', $phase)
                        ->groupBy('entreprises.aopOuleader')
                        ->select('entreprises.aopOuleader as categorie', DB::raw("COUNT(projets.id) as nombre"))
                        ->get();
$pca_enregistes_par_banque= DB::table('entreprises')
                            ->join('projets',function($join){
                                $join->on('projets.entreprise_id','=','entreprises.id')
                                ->where('entreprises.entrepriseaop',null);
                            })
                        ->rightjoin('banques','entreprises.banque_id','=','banques.id')
                        ->where('entreprises.phase_projet', $phase)
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
                        ->where('entreprises.phase_projet', $phase)
                        ->groupBy('banques.nom')
                        ->select('banques.nom as nom_banque', DB::raw("COUNT(projets.id) as nombre"), DB::raw("SUM(projets.montant_demande) as montant"))
                        ->get();
$pca_selectionne_par_banque= DB::table('entreprises')
                        ->leftjoin('projets',function($join){
                                $join->on('projets.entreprise_id','=','entreprises.id')
                                ->where('projets.statut', '=', 'selectionné');
                            })
                        ->where('entreprises.entrepriseaop',null)
                        ->where('entreprises.phase_projet', $phase)
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
                        ->where('entreprises.phase_projet', $phase)
                        ->rightjoin('banques','entreprises.banque_id','=','banques.id')
                        ->groupBy('banques.nom')
                        ->select('banques.nom as nom_banque', DB::raw("COUNT(projets.id) as nombre"), DB::raw("SUM(projets.montant_accorde) as montant"))
                        ->get();

$pca_aop_selectionne_par_secteurs= DB::table('entreprises')
                        ->join('projets',function($join){
                            $join->on('projets.entreprise_id','=','entreprises.id')
                            ->where('projets.statut', '=', 'selectionné');
                        })
                        ->where('entreprises.phase_projet', $phase)
                        ->where('entreprises.entrepriseaop',1)
                        ->select( "entreprises.secteur_activite as secteur_dactivite" , DB::raw("COUNT(entreprises.secteur_activite) as nombre"), DB::raw("SUM(projets.montant_demande) as montant"))
                        ->groupBy('entreprises.secteur_activite')
                        ->get();

 $pca_rejetes_par_secteurs= DB::table('entreprises')
                        ->join('projets',function($join){
                            $join->on('projets.entreprise_id','=','entreprises.id')
                            ->where('projets.statut', '=', 'rejeté');
                        })
                        ->where('entreprises.phase_projet', $phase)
                        ->where('entreprises.entrepriseaop',null)
                        ->select( "entreprises.secteur_activite as secteur_dactivite" , DB::raw("COUNT(entreprises.secteur_activite) as nombre"), DB::raw("SUM(projets.montant_demande) as montant"))
                        ->groupBy('entreprises.secteur_activite')
                        ->get();
$pca_aop_rejetes_par_secteurs= DB::table('entreprises')
                        ->join('projets',function($join){
                            $join->on('projets.entreprise_id','=','entreprises.id')
                            ->where('projets.statut', '=', 'rejeté');
                        })
                        ->where('entreprises.phase_projet', $phase)
                        ->where('entreprises.entrepriseaop',1)
                        ->select( "entreprises.secteur_activite as secteur_dactivite" , DB::raw("COUNT(entreprises.secteur_activite) as nombre"), DB::raw("SUM(projets.montant_demande) as montant"))
                        ->groupBy('entreprises.secteur_activite')
                        ->get();
$pca_rejete_par_region= DB::table('entreprises')
                        ->join('projets',function($join){
                            $join->on('projets.entreprise_id','=','entreprises.id')
                            ->where('projets.statut', '=', 'rejeté');
                        })
                        ->where('entreprises.phase_projet', $phase)
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
                        ->where('entreprises.phase_projet', $phase)
                        ->select( "entreprises.region", DB::raw("COUNT(entreprises.id) as nombre", DB::raw("SUM(projets.montant_demande) as montant")))
                        ->groupBy('entreprises.region')
                        ->get();

$pca_selectionne_par_region= DB::table('entreprises')
                        ->join('projets',function($join){
                            $join->on('projets.entreprise_id','=','entreprises.id')
                            ->where('projets.statut', '=', 'selectionné');
                        })
                        ->where('entreprises.entrepriseaop',null)
                        ->where('entreprises.phase_projet', $phase)
                        ->select( "entreprises.region", DB::raw("COUNT(entreprises.id) as nombre"), DB::raw("SUM(projets.montant_accorde) as montant"))
                        ->groupBy('entreprises.region')
                        ->get();
$pca_aop_selectionne_par_region= DB::table('entreprises')
                        ->join('projets',function($join){
                            $join->on('projets.entreprise_id','=','entreprises.id')
                            ->where('projets.statut', '=', 'selectionné');
                        })
                        ->where('entreprises.entrepriseaop',1)
                        ->where('entreprises.phase_projet', $phase)
                        ->select( "entreprises.region", DB::raw("COUNT(entreprises.id) as nombre"), DB::raw("SUM(projets.montant_accorde) as montant"))
                        ->groupBy('entreprises.region')
                        ->get();
               
$pca_selectionne_par_categories = DB::table('entreprises')
                        ->leftjoin('projets',function($join){
                            $join->on('projets.entreprise_id','=','entreprises.id')
                            ->where('projets.statut', '=', 'selectionné');
                        })
                        ->where('entreprises.phase_projet', $phase)
                        ->groupBy('entreprises.aopouleader')
                        ->select('entreprises.aopOuleader as categorie', DB::raw("COUNT(projets.id) as nombre"))
                        ->get();
$pca_ajourne_par_categories = DB::table('entreprises')
                        ->leftjoin('projets',function($join){
                            $join->on('projets.entreprise_id','=','entreprises.id')
                            ->where('projets.statut','rejete');
                        })
                        ->where('entreprises.phase_projet', $phase)
                        ->groupBy('entreprises.aopouleader')
                        ->select('entreprises.aopOuleader as categorie', DB::raw("COUNT(projets.id) as nombre"))
                        ->get();
$demandes_de_KYC =   DB::table('entreprises')
                        ->leftjoin('projets','projets.entreprise_id','=','entreprises.id')
                        ->where('entreprises.date_demande_kyc','!=', null)
                        ->where('entreprises.phase_projet', $phase)
                        ->where('projets.statut','selectionné')
                        ->where('entreprises.entrepriseaop',null)
                        ->get();
$demandes_aop_de_KYC =   DB::table('entreprises')
                        ->leftjoin('projets','projets.entreprise_id','=','entreprises.id')
                        ->where('entreprises.date_demande_kyc','!=', null)
                        ->where('entreprises.entrepriseaop',1)
                        ->where('entreprises.phase_projet', $phase)
                        ->where('projets.statut','selectionné')
                        ->get();
$demandes_de_KYC_concluants = DB::table('entreprises')
                        ->leftjoin('projets','projets.entreprise_id','=','entreprises.id')
                        ->where('entreprises.resultat_kyc', 'concluant')
                        ->where('entreprises.entrepriseaop',null)
                        ->where('entreprises.phase_projet', $phase)
                        ->where('projets.statut','selectionné')
                        ->get();
$demandes_aop_de_KYC_concluants = DB::table('entreprises')
                        ->leftjoin('projets','projets.entreprise_id','=','entreprises.id')
                        ->where('entreprises.resultat_kyc', 'concluant')
                        ->where('entreprises.entrepriseaop',1)
                        ->where('entreprises.phase_projet', $phase)
                        ->where('projets.statut','selectionné')
                        ->get();
$demandes_de_KYC_concluants_par_banque =  DB::table('entreprises')
                                            ->leftjoin('projets',function($join){
                                                $join->on('projets.entreprise_id','=','entreprises.id')
                                                ->where('entreprises.resultat_kyc', 'concluant');
                                            })
                                            ->where('entreprises.entrepriseaop',null)
                                            ->where('entreprises.phase_projet', $phase)
                                            ->rightjoin('banques','entreprises.banque_id','=','banques.id')
                                            ->groupBy('banques.nom')
                                            ->select('banques.nom as nom_banque', DB::raw("COUNT(projets.id) as nombre"), DB::raw("SUM(projets.montant_accorde) as montant"))
                                            ->get();
 $demandes_aop_de_KYC_concluants_par_banque =  DB::table('entreprises')
                                            ->leftjoin('projets',function($join){
                                                $join->on('projets.entreprise_id','=','entreprises.id')
                                                ->where('entreprises.resultat_kyc', 'concluant');
                                            })
                                            ->where('entreprises.phase_projet', $phase)
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
                                    ->where('entreprises.phase_projet', $phase)
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
                                        ->where('entreprises.phase_projet', $phase)
                                        ->rightJoin('banques','entreprises.banque_id','=','banques.id')
                                        ->groupBy('banques.nom')
                                        ->select('banques.nom as nom_banque', DB::raw("COUNT(projets.id) as nombre"), DB::raw("SUM(projets.montant_accorde) as montant"))
                                        ->get();

$accord_beneficiaire_aop_signe_par_banque =DB::table('entreprises')
                                            ->leftjoin('projets',function($join){
                                                $join->on('projets.entreprise_id','=','entreprises.id')
                                                ->where('entreprises.date_de_signature_accord_beneficiaire','!=', null);
                                            })
                                            ->where('entreprises.phase_projet', $phase)
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
                                            ->where('entreprises.phase_projet', $phase)
                                            ->groupBy('valeurs.libelle')
                                            ->select('valeurs.libelle as region', DB::raw("COUNT(projets.id) as nombre"), DB::raw("SUM(projets.montant_accorde) as montant"))
                                            ->get();
$accord_beneficiaire_signe_par_secteur_dactivite = DB::table('entreprises')
                                                    ->join('valeurs','entreprises.secteur_activite','=','valeurs.id')
                                                    ->leftjoin('projets','projets.entreprise_id','=','entreprises.id')
                                                    ->where('entreprises.date_de_signature_accord_beneficiaire','!=', null)
                                                    ->where('entreprises.phase_projet', $phase)
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
// }
// else{

// }

        return view("dashboard.detail_pca_appui",compact('phase','dash_phase','pca_aop_par_region','pca_aop_selectionne_par_secteurs','accord_beneficiaire_signe_par_secteur_dactivite','accord_beneficiaire_signe_par_region','accord_beneficiaire_signe_par_banque','accord_beneficiaire_aop_signe_par_banque','demandes_de_KYC_concluants_par_banque','demandes_aop_de_KYC_concluants_par_banque','demandes_de_KYC_par_banque','demandes_de_KYC_concluants','demandes_aop_de_KYC_concluants','demandes_de_KYC','pca_selectionne_par_region','pca_selectionne_par_secteurs','pca_enregistes_par_banque','pca_aop_enregistes_par_banque','pca_selectionne_par_banque','pca_aop_selectionne_par_banque','pca_ajourne_par_categories','pca_selectionne_par_categories','pca_enregistre_par_categories','nombre_de_pca','total_souscription_enregistres','fond_mobilise','montant_total_pca_enregistre',
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
    return view('dashboard.detail_impact',compact('phase','ind_emp_permanent','ind_emp_temporaire','liste_indicateur_impacts','ind_ressource_mobilise_mpme','ind_ressource_mobilise_aop_el','mobilisation_de_ressource_mpme','mobilisation_de_ressource_aop_el','projet_selectionnes','proportion_de_contrepartie_mobilise','nombre_demploi_par_secteurdactivites','nombre_demploi_par_zones','nombre_de_client_par_zones','nombre_de_client_par_secteurdactivites','total_contrepartie_suplementaire_mobilise','montant_total_des_aquisitions','acquisistions_valides_par_categories','nombre_demploi_permanent_femme_conserves','nombre_demploi_temporaire_femme_conserves','nombre_demploi_permanent_homme_conserves','nombre_demploi_temporaire_homme_conserves','ind_nombre_emploi_cree','leader_AOP_formes','ind_nombre_aop_forme','mpme_formes','ind_nombre_mpme_forme','augmentation_du_chiffre_daffaire','augmentation_du_benefice','nombre_de_nouveaux_clients','nombre_demploi_crees','nombre_demploi_permanent_femme_crees','nombre_demploi_permanent_homme_crees','nombre_demploi_temporaire_femme_crees','nombre_demploi_temporaire_homme_crees','nombre_de_pca','fond_mobilise','total_souscription_enregistres'));
}


}
function dashboard_banque_perform_by_phase(Request $request){
    if(Auth::user()->can('tableau.debord')){ 
        $phase=$request->phase;
        ($request->phase==1)?$page='banque_perform_phase1':$page='banque_perform_phase2';
        $facture_valides_par_banques= DB::table('banques')
                                ->leftjoin('entreprises','entreprises.banque_id','=','banques.id')
                                ->leftjoin('factures',function($join){
                                    $join->on('factures.entreprise_id','=','entreprises.id')
                                    ->whereIn('factures.statut',['payée','validé']);
                                    })
                                ->where('entreprises.phase_projet',$phase)
                                ->select("banques.id","banques.nom as nom_banque", DB::raw("SUM(factures.montant) as montant"),DB::raw("count(factures.id) as nombre"))
                                ->groupBy('banques.id',"banques.nom")
                                ->get();
        $contrepartie_mobilise_par_banques= DB::table('banques')
                                ->leftjoin('entreprises','entreprises.banque_id','=','banques.id')
                                ->leftjoin('accomptes',function($join){
                                    $join->on('accomptes.entreprise_id','=','entreprises.id');
                                    })
                                ->where('entreprises.phase_projet',$phase)
                                ->select("banques.id","banques.nom as nom_banque", DB::raw("SUM(accomptes.montant) as montant"),DB::raw("count(accomptes.id) as nombre"))
                                ->groupBy('banques.id',"banques.nom")
                                ->get(); 
    $subvention_mobilise_par_banques= DB::table('banques')
                                    ->leftjoin('entreprises','entreprises.banque_id','=','banques.id')
                                    ->leftjoin('subventions',function($join){
                                        $join->on('subventions.entreprise_id','=','entreprises.id');
                                        })
                                    ->where('entreprises.phase_projet',$phase)
                                    ->select("banques.id","banques.nom as nom_banque", DB::raw("SUM(subventions.montant_subvention) as montant"),DB::raw("count(subventions.id) as nombre"))
                                    ->groupBy('banques.id',"banques.nom")
                                    ->get();
            
        $facture_a_payees_par_banques= DB::table('banques')
                                        ->leftjoin('entreprises','entreprises.banque_id','=','banques.id')
                                        ->leftjoin('factures',function($join){
                                            $join->on('factures.entreprise_id','=','entreprises.id')
                                            ->where('factures.statut','=','validé');
                                        })
                                        ->where('entreprises.phase_projet',$phase)
                                        ->select("banques.id","banques.nom as nom_banque", DB::raw("SUM(factures.montant) as montant"),DB::raw("count(factures.id) as nombre"))
                                        ->groupBy('banques.id',"banques.nom")
                                        ->get();
        $facture_soumis_par_banques= DB::table('banques')
                                        ->leftjoin('entreprises','entreprises.banque_id','=','banques.id')
                                        ->leftjoin('factures',function($join){
                                            $join->on('factures.entreprise_id','=','entreprises.id')
                                            ->whereIn('factures.statut',['validé','payée']);
                                        })
                                        ->where('entreprises.phase_projet',$phase)
                                        ->select("banques.id","banques.nom as nom_banque", DB::raw("SUM(factures.montant) as montant"),DB::raw("count(factures.id) as nombre"))
                                        ->groupBy('banques.id',"banques.nom")
                                        ->get();
        $facture_payes_par_banques= DB::table('banques')
                                        ->leftjoin('entreprises','entreprises.banque_id','=','banques.id')
                                        ->leftjoin('factures',function($join){
                                            $join->on('factures.entreprise_id','=','entreprises.id')
                                            ->where('factures.statut', 'payée');
                                        })
                                        ->where('entreprises.phase_projet',$phase)
                                        ->select("banques.id","banques.nom as nom_banque", DB::raw("SUM(factures.montant) as montant"),DB::raw("count(factures.id) as nombre"))
                                        ->groupBy('banques.id',"banques.nom")
                                        ->get();
         $montant_a_mobilise_par_banque= DB::table('entreprises')
                                    ->leftjoin('projets',function($join){
                                        $join->on('projets.entreprise_id','=','entreprises.id')
                                        ->where('entreprises.date_de_signature_accord_beneficiaire','!=', null);
                                    })
                                    ->where('entreprises.phase_projet',$phase)
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
                                    ->where('entreprises.phase_projet',$phase)
                                    ->rightjoin('banques','entreprises.banque_id','=','banques.id')
                                    ->groupBy('banques.id','banques.nom')
                                    ->select('banques.nom as nom_banque', DB::raw("COUNT(projets.id) as nombre"), DB::raw("SUM(projets.montant_accorde) as montant"))
                                    ->get();
    
    $taux_de_consommation_par_banque= DB::table('entreprises')
                                    ->leftjoin('projets',function($join){
                                        $join->on('projets.entreprise_id','=','entreprises.id')
                                        ->where('projets.statut', 'selectionné');
                                    })
                                    ->where('entreprises.phase_projet',$phase)
                                    ->leftjoin('factures',function($join){
                                        $join->on('factures.entreprise_id','=','entreprises.id')
                                        ->where('factures.statut', 'payée');
                                    })
                                    ->rightjoin('banques','entreprises.banque_id','=','banques.id')
                                    ->groupBy('banques.id','banques.nom')
                                    ->select('banques.nom as nom_banque' ,DB::raw("count(factures.id) as nbre_facture_payee"), DB::raw("SUM(factures.montant) as montant_decaisse"), DB::raw("SUM(projets.montant_accorde)/2 as montant_a_mobilise"))
                                    ->get();
                                   
    $financement_par_banks= DB::select('select  b.nom as nom_banque, b.id, SUM(s.montant_subvention) as montant_subvention,
                                    SUM(a.montant) AS montant_contrepartie from banques b LEFT JOIN entreprises e ON e.banque_id = b.id
                                    LEFT JOIN accomptes a ON a.entreprise_id=e.id
                                    LEFT JOIN subventions s ON s.entreprise_id=e.id where e.phase_projet=?
                                    GROUP BY b.id, b.nom',[$phase]);
           
                    return view('dashboard.banque_perform_anglais', compact('phase','page','facture_soumis_par_banques','montant_projet_valide_par_comites','contrepartie_mobilise_par_banques','subvention_mobilise_par_banques','financement_par_banks','facture_valides_par_banques','facture_payes_par_banques','financement_par_banks','montant_a_mobilise_par_banque','facture_a_payees_par_banques','taux_de_consommation_par_banque'));
                  
    }
    else
    {
        flash("Vous n'avez pas ce droit. Bien vouloir contacter l'administrateur")->error();
        return redirect()->back();
    }
    }
}
