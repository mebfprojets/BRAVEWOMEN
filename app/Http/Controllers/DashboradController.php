<?php

namespace App\Http\Controllers;

use App\Models\Entreprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class DashboradController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function dashboardgeo(){
        $entreprises=Entreprise::where("status",'!=',0)->where('entrepriseaop',null)->orderBy('updated_at', 'desc')->get();
        $decisions_retenu= Entreprise::where("decision_du_comite_phase1", "retenu")->orderBy('updated_at', 'desc')->get();
        $entreprisesAOP=Entreprise::where("status",'!=',0)->where('entrepriseaop',1)->orderBy('updated_at', 'desc')->get();
        $decisions_retenu= count($decisions_retenu);
        $entreprisesLeaderAOP=count($entreprisesAOP);
        $totalenregistres= count($entreprises);
        return view("dashboardgeo",compact("totalenregistres","decisions_retenu",'entreprisesLeaderAOP'));
    }
    public function dashboard(){
        //Verifier si l'utilisateur est un membre de commission 
        $entreprises=Entreprise::where("status",'!=',0)->orderBy('updated_at', 'desc')->where('entrepriseaop',null)->get();
        $entreprisesAOP=Entreprise::where("status",'!=',0)->where('entrepriseaop',1)->orderBy('updated_at', 'desc')->get();
        $decisions_retenu= Entreprise::where("decision_du_comite_phase1", "selectionnee")->where('entrepriseaop',null)->orderBy('updated_at', 'desc')->get();
        $decisions_retenu= count($decisions_retenu);
        $totalenregistres= count($entreprises);
        $entreprisesLeaderAOP=count($entreprisesAOP);
        if(Auth::user()->structure_represente == null && Auth::user()->banque_id==null && Auth::user()->code_promoteur == null ){
            return view("dashboard",compact("totalenregistres","decisions_retenu","entreprisesLeaderAOP"));
        }
        elseif(Auth::user()->structure_represente == null && Auth::user()->banque_id!=null ){
            return redirect()->route("banque.beneficiaires");
        }
        elseif(Auth::user()->code_promoteur != null){
            return redirect()->route("profil.beneficiaire");
        }
        else{
            return redirect()->route("soumises_au_comite_technique");
        }
        
    }
    public function dashboardliste()
    {
        $entreprises=Entreprise::where("status",'!=',0)->where('entrepriseaop',null)->orderBy('updated_at', 'desc')->get();
        $decisions_retenu= Entreprise::where("decision_du_comite_phase1", "selectionnee")->where('entrepriseaop',null)->orderBy('updated_at', 'desc')->get();
        $aopaformer= Entreprise::where("decision_du_comite_phase1", "selectionnee")->where('entrepriseaop',1)->orderBy('updated_at', 'desc')->get();
        $entreprisesAOP=Entreprise::where("status",'!=',0)->where('entrepriseaop',1)->orderBy('updated_at', 'desc')->get();
        //dd($entreprisesAOP);
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
               $toutesouscriptions[] = array('id'=>$value->id,'denomination'=>$value->denomination,'region'=>getlibelle($value->region),'nombre_annee_experience'=>$value->nombre_annee_experience, 'secteur_activite'=>getlibelle($value->secteur_activite),'maillon_activite'=>getlibelle($value->maillon_activite));
            }
           //dd($toutesouscriptions);
        return json_encode($toutesouscriptions);
    }
    public function entreprise_retenues( Request $request)
    {
        $categorieentreprise= $request->typeentreprise;
        ($categorieentreprise=='mpme')?($categorieentreprise=null):($categorieentreprise=1);
        //$entreprises_retenus=DB::select("select e.denomination, e.region, p.nombre_annee_experience, e.secteur_activite, e.maillon_activite FROM entreprises e , valeurs v, promotrices p where e.decision_du_comite_phase1= 'retenu' and e.region = v.id and e.entrepriseaop IS NULL ");
        $entreprises_retenus = Entreprise::where("decision_du_comite_phase1", "selectionnee")->where('entrepriseaop',$categorieentreprise)->orderBy('updated_at', 'desc')->get();
        $entreprises_retenu=[];
        foreach( $entreprises_retenus as $value)
            {
               // dd($entreprises_retenu->denomination);
               $entreprises_retenu[] = array('id'=>$value->id,'denomination'=>$value->denomination,'region'=>getlibelle($value->region),'nombre_annee_experience'=>$value->nombre_annee_experience, 'secteur_activite'=>getlibelle($value->secteur_activite),'maillon_activite'=>getlibelle($value->maillon_activite));
            }
          // dd(json_encode($entreprises_retenus));
        return json_encode($entreprises_retenu);
    }
   
    // Cette fonction gere la partie graphique
    public function souscriptionretenueparsecteuractivite()
    {
        $entreprises_retenus=DB::select("select  e.secteur_activite, v.libelle, COUNT(e.id) as nombre FROM entreprises e , valeurs v where e.decision_du_comite_phase1= 'selectionnee' and e.secteur_activite = v.id and e.entrepriseaop IS NULL  GROUP by e.secteur_activite, v.libelle");
         Entreprise::where("decision_du_comite_phase1", "selectionnee")->where('entrepriseaop',null)->orderBy('updated_at', 'desc')->get();
        foreach( $entreprises_retenus as $value)
            {
               $souscriptionreteunuephase1[] = array('secteur'=>$value->libelle, 'nombre'=>$value->nombre);
            }
        return json_encode($souscriptionreteunuephase1);
    }
    public function souscriptionparsecteuractivite(){
        //select  p.categorie_id, v.libelle, SUM(l.quantite) as quantiteCmde FROM ligne_de_commandes l , produits p, valeurs v where p.categorie_id = v.id and l.produit_id = p.id GROUP by p.categorie_id, v.libelle;
        
       //$souscriptionsParsecteur= DB::select("select  e.secteur_activite, v.libelle, COUNT(distinct(e.id)) as nombre FROM entreprises e , valeurs v where e.secteur_activite = v.id and e.entrepriseaop IS NULL and e.updated_at BETWEEN '2022-05-27 00-00-00' AND '2022-07-01 00-00-00' AND e.status=1 GROUP by e.secteur_activite, v.libelle");
       $souscriptionsParsecteur= DB::select('select  e.secteur_activite, v.libelle, COUNT(e.id) as nombre FROM entreprises e , valeurs v where e.secteur_activite = v.id and e.entrepriseaop IS NULL GROUP by e.secteur_activite, v.libelle');

        $datacategorie=[];
            foreach( $souscriptionsParsecteur as $value)
            {
               $datacategorie[] = array('secteur'=>$value->libelle, 'nombre'=>$value->nombre);
            }
            return json_encode($datacategorie);
}
// Fonction d'affichage des satitistique des aop enregistrer par secteur d'activivite
public function aopparsecteuractivite(){
    //select  p.categorie_id, v.libelle, SUM(l.quantite) as quantiteCmde FROM ligne_de_commandes l , produits p, valeurs v where p.categorie_id = v.id and l.produit_id = p.id GROUP by p.categorie_id, v.libelle;
   $souscriptionsParsecteur= DB::select('select  e.secteur_activite, v.libelle, COUNT(e.id) as nombre FROM entreprises e , valeurs v where e.secteur_activite = v.id and e.entrepriseaop=1 and e.description_du_projet IS NOT NULL GROUP by e.secteur_activite, v.libelle');
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
  // $souscriptionsParsecteur= DB::select("select  e.region, v.libelle, COUNT(e.id) as nombre FROM entreprises e , valeurs v where e.region = v.id and e.entrepriseaop IS NULL and e.updated_at BETWEEN '2022-05-27 00-00-00' AND '2022-07-01 00-00-00' and e.status=1  GROUP by e.region, v.libelle");
    
   $souscriptionsParsecteur= DB::select('select  e.region, v.libelle, COUNT(e.id) as nombre FROM entreprises e , valeurs v where e.region = v.id and e.entrepriseaop IS NULL and e.status=1  GROUP by e.region, v.libelle');
    $datacategorie=[];
        foreach( $souscriptionsParsecteur as $value)
        {
           $datacategorie[] = array('region'=>$value->libelle, 'nombre'=>$value->nombre);
        }
        return json_encode($datacategorie);
}
public function aopregisterparzone(Request $request)
{ 
   $souscriptionsParzone= DB::select('select  e.region, v.libelle, COUNT(e.id) as nombre FROM entreprises e , valeurs v where e.region = v.id and e.entrepriseaop= 1 and e.status=1  GROUP by e.region, v.libelle');
    $datacategorie=[];
        foreach( $souscriptionsParzone as $value)
        {
           $datacategorie[] = array('region'=>$value->libelle, 'nombre'=>$value->nombre);
        }
        return json_encode($datacategorie);
}
public function mpemepreselectionneparzone()
{
   $souscriptionsParsecteur= DB::select("select  e.region, v.libelle, COUNT(e.id) as nombre FROM entreprises e , valeurs v where e.region = v.id and e.entrepriseaop IS NULL and e.status=1 AND e.decision_du_comite_phase1='selectionnee' GROUP by e.region, v.libelle");
    $dataregion=[];
        foreach( $souscriptionsParsecteur as $value)
        {
           $dataregion[] = array('region'=>$value->libelle, 'nombre'=>$value->nombre);
        }
        //dd($dataregion);
        return json_encode($dataregion);
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
public function souscriptiongeopresenation()
{
   $souscriptionsgeo= DB::select('select e.denomination, e.longitude, e.latitude, e.telephone_entreprise FROM entreprises e where e.entrepriseaop IS NULL and e.status=1');
    $datageo=[];
        foreach( $souscriptionsgeo as $value)
        {
           $datageo[] = array('denomination'=>$value->denomination,'telephone'=>$value->telephone_entreprise, 'longitude'=>$value->longitude, 'latitude'=>$value->latitude);
        }
        return json_encode($datageo);
}
}
