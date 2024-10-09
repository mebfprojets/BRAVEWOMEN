<?php

namespace App\Http\Controllers;

use App\Models\Entreprise;
use App\Models\Promotrice;
use App\Models\User;
use App\Models\Valeur;
use Illuminate\Http\Request;
use App\Models\Proportion_de_depense_promotrice;
use Illuminate\Support\Facades\Auth;
use App\Models\Piecejointe;
use App\Models\Projet;
use App\Models\Projetinfo;
use App\Models\Entreprise_activite;
use App\Models\Entreprise_activite_invest;
use App\Models\Evaluation;
use App\Models\Coach;
use App\Models\Banque;
use App\Models\Infoeffectifentreprise;
use App\Models\Infoentreprise;

class BeneficiaireController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function updateIndicateur($indicateur, $annee, $quantite){
       $indicateur= Infoentreprise::where('indicateur',$indicateur)->where('annee', $annee)->first();
        $indicateur->update([
            'quantite'=> $quantite
        ]);

    }
   public function gotoEspaceBeneficiaire(){
       $entreprise= Entreprise::where('code_promoteur', Auth::user()->code_promoteur)->first();
       //dd($entreprise);
       return view('public.espace_beneficiaire',compact("entreprise"));
   }
   public function showprofil(Entreprise $entreprise){
    $promotrice= Promotrice::where('code_promoteur', Auth::user()->code_promoteur)->first();
    $projet=Projet::where('entreprise_id', $entreprise->id)->first();
    if($projet){
        $montant_du_plan_soumis=$projet->investissements->sum('montant');
        $total_a_mobiliser=$projet->investissementvalides->sum('montant_valide');
        $projet_piecejointes=Piecejointe::where("entreprise_id",$projet->entreprise->id)->whereIn('type_piece', [env("VALEUR_ID_DOCUMENT_PCA"), env("VALEUR_ID_DOCUMENT_SYNTHESE_PCA"), env("VALEUR_ID_DOCUMENT_DEVIS"),env("VALEUR_ID_DOCUMENT_FONCIER"),env("VALEUR_ID_DOCUMENT_ATTESTATION")])->orderBy('updated_at', 'desc')->get();
        $projet_piecejointes_appuis2=Piecejointe::where("entreprise_id",$projet->entreprise->id)->whereIn('type_piece', [env("VALEUR_ID_DOCUMENT_FONCIER_REVU"),env("VALEUR_ID_DOCUMENT_DEVIS_REVU"),env("VALEUR_ID_DOCUMENT_SYNTHESE_PCA_REVU"),env("VALEUR_ID_DOCUMENT_PCA_REVU")])->orderBy('updated_at', 'desc')->get();

    }
    else{
        $total_a_mobiliser=null;
        $projet_piecejointes=null;
        $montant_du_plan_soumis=null;
    }
    $regions=Valeur::where('parametre_id',env('PARAMETRE_ID_REGION'))->get();
    $total_avoir= $entreprise->accomptes->sum('montant') + $entreprise->subventions->sum('montant_subvention');
    $total_engage= $entreprise->devis_valides->sum('montant_devis');
    $pourcentages= Valeur::where('parametre_id', env('PARAMETRE_POURCENTAGE_ID') )->get();
    $secteur_activites= Valeur::where('parametre_id', env('PARAMETRE_SECTEUR_ACTIVITE_ID') )->get();
    $nb_annee_activites= Valeur::where('parametre_id', env('PARAMETRE_NB_ANNEE_EXISTENCE_ENT') )->get();
    $maillon_activites=Valeur::where('parametre_id',7 )->get();
    $source_appros=Valeur::where('parametre_id',12 )->get();
    $sys_suivi_activites=Valeur::where('parametre_id',13 )->get();
    $nature_clienteles=Valeur::where('parametre_id',10 )->get();
    $techno_utilisees= Valeur::where('parametre_id', env('PARAMETRE_TECHNO_UTILISE_ENTREPRISE_ID') )->get();
    $niveau_instructions=Valeur::where("parametre_id", env('PARAMETRE_NIVEAU_D_INSTRUCTION'))->get();
    $nb_annee_experience=Valeur::where("parametre_id", env('PARAMETRE_TRANCHE_EXPERIENCE'))->get();
    $piecejointes=Piecejointe::where("entreprise_id",$entreprise->id)->orWhere("promotrice_id", $entreprise->promotrice->id )->orderBy('updated_at', 'desc')->get();
    $effectif_permanent_entreprises= Infoeffectifentreprise::where("entreprise_id",$entreprise->id)->where("effectif",env("VALEUR_EFFECTIF_PERMANENENT"))->get();
    $effectif_temporaire_entreprises= Infoeffectifentreprise::where("entreprise_id",$entreprise->id)->where("effectif",env("VALEUR_EFFECTIF_TEMPORAIRE"))->get();
    $chiffre_daffaire= Infoentreprise::where("entreprise_id",$entreprise->id)->where("indicateur",env("VALEUR_CHIFFRE_D_AFFAIRE"))->get();
    $produit_vendus= Infoentreprise::where("entreprise_id",$entreprise->id)->where("indicateur",env("VALEUR_PRODUIT_VENDU"))->get();
    $benefice_nets= Infoentreprise::where("entreprise_id",$entreprise->id)->where("indicateur",env("VALEUR_BENEFICE_NET"))->get();
    $salaire_annuelles= Infoentreprise::where("entreprise_id",$entreprise->id)->where('indicateur', env("VALEUR_SALAIRE_MOYEN_ANNUEL") )->get();
    $nombre_nouveau_marche=Infoentreprise::where("entreprise_id",$entreprise->id)->where('indicateur', 6714 )->get();
    $nombre_nouveau_produit=Infoentreprise::where("entreprise_id",$entreprise->id)->where('indicateur', 6715)->get();
    $nombre_total_client=Infoentreprise::where("entreprise_id",$entreprise->id)->where('indicateur', env("VALEUR_NOMBRE_CLIENT") )->get();
    $nombre_innovation=Infoentreprise::where("entreprise_id",$entreprise->id)->where('indicateur', 6713 )->get();
    $proportion_de_depense_education= Proportion_de_depense_promotrice::where("promotrice_id",$entreprise->promotrice->id)->where('proportion_id',env("VALEUR_PROPORTION_BIEN") )->get();
    //dd($proportion_de_depense_education);
    $proportion_de_depense_sante= Proportion_de_depense_promotrice::where("promotrice_id",$entreprise->promotrice->id)->where('proportion_id',env("VALEUR_PROPORTION_SANTE"))->get();
    $proportion_de_depense_bien_materiel= Proportion_de_depense_promotrice::where("promotrice_id",$entreprise->promotrice->id)->where('proportion_id',env("VALEUR_PROPORTION_BIEN"))->get();
    $forme_juridiques=Valeur::where('parametre_id',8 )->get();
    $categorie_investissments=Valeur::where('parametre_id', 38)->get();
    $coachs= Coach::all();
    $banques= Banque::all(); 
    $projet_type_pieces= Valeur::whereIn('id',[env('VALEUR_ID_DOCUMENT_DEVIS'),env('VALEUR_ID_DOCUMENT_FONCIER')])->get();
        if($entreprise->aopOuleader=='aop' || $entreprise->aopOuleader=='leader'){
           $activite_verticale_devs= Entreprise_activite::where('entreprise_id',$entreprise->id)->where('type','verticale')->get();
           $activite_verticale_invests= Entreprise_activite_invest::where('entreprise_id',$entreprise->id)->where('type','verticale')->get();
           $activite_horizontale_devs=Entreprise_activite::where('entreprise_id',$entreprise->id)->where('type','horizontale')->get();
           $activite_horizontale_invests=  Entreprise_activite_invest::where('entreprise_id',$entreprise->id)->where('type','horizontale')->get();
           $nombre_de_pme_partenaires= Infoentreprise::where("entreprise_id",$entreprise->id)->where('indicateur', 7100)->get();
           $montant_des_achats_aupres_des_mpme_des_femmes= Infoentreprise::where("entreprise_id",$entreprise->id)->where('indicateur', 7102)->get();
	        $nombre_de_pme_partenaires_de_la_zones= Infoentreprise::where("entreprise_id",$entreprise->id)->where('indicateur', 7116)->get();
	        $montant_obtenu_aupres_des_institutions_financiaires=Infoentreprise::where("entreprise_id",$entreprise->id)->where('indicateur', 7102)->get();
            $total_engage= $entreprise->devis_valides->sum('montant_devis');
            $nombre_membres= Infoentreprise::where("entreprise_id",$entreprise->id)->where('indicateur', 7098)->get();
            $pourcentage_femmes= Infoentreprise::where("entreprise_id",$entreprise->id)->where('indicateur', 7099)->get();
            return view("public.profilbeneficiaire",compact('projet_piecejointes_appuis2','projet_type_pieces','montant_du_plan_soumis','banques','coachs','categorie_investissments','projet_piecejointes','total_a_mobiliser','forme_juridiques','total_avoir','total_engage','techno_utilisees','nature_clienteles','nb_annee_activites',"source_appros" ,"maillon_activites",'secteur_activites',"regions","nb_annee_experience","niveau_instructions","promotrice","nombre_de_pme_partenaires_de_la_zones","montant_obtenu_aupres_des_institutions_financiaires","montant_des_achats_aupres_des_mpme_des_femmes","nombre_de_pme_partenaires","nombre_membres","pourcentage_femmes","entreprise","nombre_total_client",'proportion_de_depense_education','proportion_de_depense_sante','proportion_de_depense_bien_materiel','nombre_innovation','nombre_nouveau_marche','nombre_nouveau_produit',"piecejointes","chiffre_daffaire","produit_vendus", "benefice_nets","salaire_annuelles","effectif_permanent_entreprises","effectif_temporaire_entreprises","activite_horizontale_devs","activite_verticale_invests","activite_horizontale_invests"));
           }
           else{
           
                return view("public.profilbeneficiaire",compact('projet_piecejointes_appuis2','projet_type_pieces','montant_du_plan_soumis',"projet_piecejointes",'forme_juridiques','total_engage','total_avoir','banques','coachs','categorie_investissments','projet_piecejointes','total_a_mobiliser','techno_utilisees','nature_clienteles','nb_annee_activites',"source_appros","maillon_activites","secteur_activites","regions","nb_annee_experience","niveau_instructions","promotrice","entreprise","nombre_total_client",'proportion_de_depense_education','proportion_de_depense_sante','proportion_de_depense_bien_materiel','nombre_innovation','nombre_nouveau_marche','nombre_nouveau_produit',"piecejointes","chiffre_daffaire","produit_vendus", "benefice_nets","salaire_annuelles","effectif_permanent_entreprises","effectif_temporaire_entreprises"));
        }
      
    //return view('public.profilbeneficiaire', compact("proportion_de_depense_education","proportion_de_depense_sante","proportion_de_depense_bien_materiel","entreprise" ,"promotrice", "niveau_instructions","nb_annee_experience","regions"));
   }
   public function showentreprisedata(){
        $promotrice= Promotrice::where('code_promoteur', Auth::user()->code_promoteur)->first();
        $entreprise= Entreprise::where('code_promoteur', Auth::user()->code_promoteur)->where('decision_du_comite_phase1','selectionnee')->first();   
        return view('public.infoentreprise', compact('entreprise') );
   }
   public function updatebeneficiare(Request $request, Promotrice $promotrice){
    $datenaiss= date('Y-m-d', strtotime($request->datenais_promoteur));
    $date_etabli_identite= date('Y-m-d', strtotime($request->date_identification));
        $promotrice->update([
            'nom' => $request->nom_promoteur,
            'prenom' => $request->prenom_promoteur,
            'datenais' => $datenaiss,
            'genre' => $request->genre,
            'fonction'=>$request->fonction,
            'telephone_promoteur' => $request->telephone_promoteur,
            'email_promoteur' => $request->email_promoteur,
            'type_identite' => $request->type_identite_promoteur,
            'numero_identite' => $request->numero_identite,
            'date_etabli_identite' => $date_etabli_identite,
            'mobile_promoteur' => $request->mobile_promoteur,
            'region_residence' => $request->region_residence,
            'province_residence' => $request->province_residence,
            'commune_residence' => $request->commune_residence,
            'situation_residence' => $request->situation_residence,
            'arrondissement_residence' => $request->arrondissement_residence,
            'niveau_instruction' => $request->niveau_instruction,
            'domaine_formation'=> $request->domaine_formation,
            'nombre_annee_experience'=> $request->nombre_annee_experience,
            'formation_en_rapport_avec_activite' => $request->formation_activite,
            'occupation_professionnelle_actuelle' => $request->occupation_pro_actuelle,
        ]);
        $user= User::find(Auth::user()->id);
        $user->update([
            'name'=>$request->nom_promoteur,
            'prenom' => $request->prenom_promoteur,
            'email' => $request->email_promoteur,
        ]);
        if(!empty($request['password'])){
            $user->update([
                'password' => bcrypt($request['password'])
            ]);
        }
        return redirect()->back();

   }
   public function updateEntrepriseBeneficiaire(Request $request, Entreprise $entreprise)
   { 
     if ($request->hasFile('doc_formalisation')) {
        $urldocrccm= $request->doc_formalisation->store('public/docrccm');
        Piecejointe::create([
            'type_piece'=>env("VALEUR_ID_DOCUMENT_RCCM"),
              'entreprise_id'=>$entreprise->id,
              'url'=>$urldocrccm,
          ]);
    }
    else{
        $urldocrccm=null;
    }
    $date_de_formalisation= date('Y-m-d', strtotime($request->date_de_formalisation));
    $entreprise->update([
        'denomination'=>$request->denomination,
        'region'=>$request->region_residence,
        'province'=>$request->province_residence,
        'commune'=>$request->commune_residence,
        'arrondissement'=>$request->arrondissement_residence,
        'telephone_entreprise'=>$request->telephone_entreprise,
        'email_entreprise'=>$request->email_entreprise,
        'secteur_activite'=>$request->secteur_dactivite,
        'nombre_annee_existence'=>$request->nb_annee_activite,
        'maillon_activite'=>$request->maillon_dactivite,
        'formalise'=>$request->formalise,
        'date_de_formalisation'=>$date_de_formalisation,
        'num_rccm'=>$request->num_rccm,
        'forme_juridique'=>$request->forme_juridique,
        'techno_utilise'=>$request->techno_utilise,
        // 'num_rccm'=>$request->num_rccm,
        // 'agrement_exige'=>$request->agrement_exige,
        // 'banque_entreprise'=>$request->structure_financiere_entreprise,
        // 'compte_dispo'=>$request->compte_dispo,
        // 'beneficier_credit'=>$request->beneficier_credit,
        // 'source_appro'=>$request->source_appro,
        // 'techno_utilise'=>$request->techno_utilisee,
        // 'description_activite'=>$request->description_activite,
        // 'provenance_clientele'=>$request->provenance_clientele,
        // 'nature_client'=>$request->nature_client,
        // 'systeme_suivi'=>$request->systeme_suivi,
        // 'type_sys_suivi'=>$request->type_de_systeme_suivi,
        // 'code_promoteur'=>$request->code_promoteur,
        // 'promotrice_id'=>$promoteur->id,
        // 'affecte_par_covid'=>$request->affecte_par_covid,
        // 'description_effect_covid'=>$request->description_effect_covid,
        // 'affecte_par_securite'=>$request->affecte_par_securite,
        // 'description_effet_securite'=>$request->description_effet_securite,
        // 'niveau_resilience'=>$request->niveau_resilience,
        // 'mobililise_contrepartie'=>$request->mobililise_contrepartie,
        
    ]);
    return redirect()->back();
   }

   public function devissoumisparpromotrice(){
       
   }
}
