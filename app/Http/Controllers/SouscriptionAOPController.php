<?php

namespace App\Http\Controllers;

use App\Models\Decision;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SouscriptionAOPController extends Controller
{
    public function listerallsouscriptionAOPtermine(){
        $active='aop_enregistre';
        $active_principal='aop';
        $titre="aop_enregistre";
        $entreprises = Entreprise::where("status",'!=',0)->where('entrepriseaop',1)->orderBy('updated_at', 'desc')->get();
        return view("souscriptions.prevalidable", compact("entreprises","active","titre","active_principal"));
    }
public function souscriptionaopsAanalyserParLeComite(){
        $active='aop_soumis_aucomite';
        $active_principal='aop';
        $titre="soumises à la validation du comité technique";
        $souscription_tranchee_par_users= Decision::where("user_id",Auth::user()->id)->get();
        $id_entreprises=[];
        $i=0;
        foreach($souscription_tranchee_par_users as $souscription_tranchee_par_user)
        {
            $id_entreprises[$i]= $souscription_tranchee_par_user->entreprise_id;
            $i++;
        }
            $entreprises = Entreprise::where("status",1)->where('entrepriseaop',1)->where("decision_du_comite_phase1",null)->orderBy('updated_at', 'desc')->get();
           // dd($entreprises );
            $entreprises= $entreprises->except($id_entreprises);
        return view("souscriptions.prevalidable", compact("entreprises","active","titre","active_principal"));
       }
       public function aopretenues(){
        $active='aop_retenu';
        $active_principal="aop";
        $titre="aop_retenu";
        $entreprises = Entreprise::where("decision_du_comite_phase1", "selectionnee")->orderBy('updated_at', 'desc')->get();
        return view("souscriptions.retenue", compact("entreprises", "titre","active","active_principal"));
       }
       public function souscriptionaopAnalyses_par_lecomite()
   {  $active="aop_analyse_par_lecomite";
        $active_principal="aop";
        $entreprises = Entreprise::where("status",1)->where('entrepriseaop',1)->where("decision_du_comite_phase1","!=" ,null)->orderBy('updated_at', 'desc')->get();
      return view("souscriptions.listeDesSouscriptionsAnalyseeParLeComite", compact("entreprises","active","active_principal"));
   }
   public function souscriptionsaopretenues(){
    $titre="aop_retenu";
    $active_principal="aop";
    $active="aop_retenu";
    $entreprises = Entreprise::where("decision_du_comite_phase1", "selectionnee")->where('entrepriseaop',1)->orderBy('updated_at', 'desc')->get();
    return view("souscriptions.retenue", compact("entreprises", "titre","active","active_principal"));
   }
   public function completerPoportiondeDepensedupromoteur($id_promoteur){
            return view("entreprise.completerProportiondepensedupromoteur", compact("id_promoteur"));
   }

}
