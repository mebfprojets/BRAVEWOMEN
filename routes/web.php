<?php

use App\Http\Controllers\AccompteController;
use App\Http\Controllers\BanqueController;
use App\Http\Controllers\BaremeController;
use App\Http\Controllers\BeneficiaireController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\DashboradController;
use App\Http\Controllers\DeviController;
use App\Http\Controllers\EntrepriseaopController;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\FinancementController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\ParametreController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\PromotriceController;
use App\Http\Controllers\ResponsableaopController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SouscriptionAOPController;
use App\Http\Controllers\SouscriptionController;
use App\Http\Controllers\SubventionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ValeurController;
use App\Http\Controllers\PrestataireController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\ActiviteController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\AcquisitionController;
use App\Http\Controllers\ImpactController;

use App\Http\Controllers\SimpleExcelController;
use App\Models\Entreprise;
use App\Models\Formation;
use App\Http\Controllers\GrilleEvalController;
use App\Http\Controllers\SucessStorieController;
use App\Models\Parametre;
use App\Models\Valeur;
use App\Models\SucessStorie;

use App\Policies\SouscriptionPolicy;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('accueil');
});
Route::get('/accueil', function () {
    return view('accueil');
})->name("accueil");
Route::group(['prefix'=>'administrator'], function(){
    Route::get("edit/accoussnt/",[AccompteController::class,'editer'])->name('entreprise.accompte.edit');
    Route::post("modifier/assccount/",[AccompteController::class,'modifier'])->name('accompte.modif');
    Route::resource("parametres",ParametreController::class);
    Route::resource("valeurs", ValeurController::class);
    Route::get('/valeur', [ValeurController::class, 'selection'])->name("valeur.selection");
    Route::resource('baremes', BaremeController::class);
    Route::get("/souscription/reparties_par_chef_de_zone", [SouscriptionController::class, 'listersouscriptionParZone'])->name("souscription__reparties_par_zone");
    Route::get("/souscription/soumises_au_comite_technique", [SouscriptionController::class, 'souscriptionsAanalyserParLeComite'])->name("soumises_au_comite_technique");
    Route::get("/souscription/re_tenues", [SouscriptionController::class, 'souscriptionsretenues'])->name("souscription_retenue");
    Route::get('/updateByUser/{user}',[UserController::class, 'updateuser'])->name('updateByUser');
    Route::get('telechargerpiece/{piecejointe}', [EntrepriseController::class,'telecharger'])->name('telechargerpiecejointe');
    Route::get('detail/{piecejointe}', [EntrepriseController::class,'detaildocument'])->name('detaildocument');
    Route::get("/soucription_retenue_par_zone",[SouscriptionController::class, 'souscriptionsretenuesParZone'])->name("souscription_retenue_par_zone");
    Route::resource("formation", FormationController::class);
    Route::get("/lister/all/formation", [FormationController::class, 'liste_formation'])->name('formation.all');
    Route::get('liste_presence/telecharger/{formation}', [FormationController::class,'telechargerlalistedepresence'])->name('listedepresence.telecharger');
    Route::get("/ajouter/participant/{formation}",[FormationController::class, 'ajouter_participants'])->name("ajouter.participants");
    Route::get("auter/store/participant", [FormationController::class, 'storeparticipant'])->name("storeparticipant");
    Route::get("formation/enlever/participant", [FormationController::class, 'supprimerparticipant'])->name("supprimerparticipant");
    Route::get("formation/participant/valide_la_presence", [FormationController::class, 'validerpresenceparticipant'])->name("validerpresenceparticipant");
    Route::get("pme/formees", [SouscriptionController::class, 'listerlespmeretenueEtFormee'])->name("pme.formee");
    Route::resource('user', UserController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource("role",RoleController::class);
    Route::get('/listeval', [ValeurController::class,"listevakeur"])->name("valeur.listeval");
    Route::get("/souscription/terminees",[SouscriptionController::class, 'listerallsouscriptiontermine'] )->name("souscription.terminee");
    Route::get('send/synthese',[EntrepriseController::class, 'sendSyntheseToComite'])->name("send.synthese");
    Route::get('conformite/souscription',[SouscriptionController::class, 'saveConformite'])->name("souscription.saveconformite");
    Route::get('souscription/save/decision',[SouscriptionController::class, 'save_avis_ugp'])->name("souscription.savedecisionugp");
    route::get("/save/note_critere_qualitatif", [SouscriptionController::class, 'savenote_qualitatif'])->name("souscription.savenote_qualitatif");
    Route::resource('banque', BanqueController::class);
    Route::get('banque/affecter/beneficiaire/{banque}', [BanqueController::class, 'affecter_des_beneficiaire'])->name("banque.affecter");
    Route::get('banks/affecter/beneficiaire/store', [BanqueController::class, 'store_affifiation_beneficiaire_banque'])->name("banque.storeaffiliation");
    Route::get('bank/affecter/beneficiaire/destore', [BanqueController::class, 'annuler_affifiation_beneficiaire_banque'])->name("banque.supprimeraffiliation");
    Route::get('Beneficary/bank/list', [BanqueController::class, 'liste_des_beneficiaires_de_la_banque'])->name("banque.beneficiaires");
    Route::get('Mobilisation/bank', [BanqueController::class, 'mobilisation_de_fond_par_banque'])->name("mobilisation.par_banque");
    Route::get('demande_de_payement/bank', [BanqueController::class, 'demande_de_payement_par_banque'])->name("demande_de_paiement.par_banque");
    Route::get('resume/souscription/print/{promotrice}', [EntrepriseaopController::class, 'print_resume_souscription'])->name("resume_souscription.print");
    Route::get('subscribe/excel', [SouscriptionController::class, 'exportEntreprise'])->name("generer.excel"); 
    Route::get("create/account/forbeneficiary/{entreprise}",[AccompteController::class,'create_for_beneficiary'])->name('entreprise.accompte.create');
    

    Route::get("list/account/forbeneficiary/{entreprise}",[AccompteController::class,'accompte_de_la_beneficiaire'])->name('entreprise.accompte');
    Route::resource("accompte",AccompteController::class);
    Route::get("recu/versement_account/{accompt}",[AccompteController::class,'get_recu'])->name('account.getRecu');
    Route::get("create/subvention/forbeneficiary/{entreprise}",[SubventionController::class,'create_for_beneficiary'])->name('entreprise.subvention.create');
    Route::get("list/subvention/forbeneficiary/{entreprise}",[SubventionController::class,'subvention_de_la_beneficiaire'])->name('entreprise.subvention');
    Route::get("/subvention/valider_montant",[SubventionController::class,'valider_montant'])->name('valider_montant');
    Route::get("edit/account/",[SubventionController::class,'editer'])->name('subvention.editer');
    Route::post("modifier/account/",[SubventionController::class,'modifier'])->name('subvention.modifier');
    Route::resource("subvention",SubventionController::class);
    Route::get("versement_account/{accompt}",[AccompteController::class,'get_recu'])->name('subvention.getRecu');
    Route::get('/get_view', [EntrepriseController::class, "return_view"])->name('form.import');
    Route::post("simple-excel/import",  [EntrepriseController::class, "chargerGeoData"])->name('excel.import');
    Route::get('Lister/factures/parZone', [FactureController::class, 'facture_soumises'])->name('facture.mazone');
    Route::get('visualiser/facture/{facture}', [FactureController::class, 'show'])->name('facture.show');
    Route::get("changerStatus/facture", [FactureController::class, 'changerStatus'])->name('facture.changerstatus');
    Route::get("devi/demazone", [DeviController::class, 'devis_de_ma_zone'])->name('devi.de_mazone');
    Route::get("devi/analyse", [DeviController::class, 'analyse_de_devis'])->name('devi.aanalyse');
    Route::get("facture/analyse", [FactureController::class, 'analyse_de_facture'])->name('facture.aanalyse');
    Route::get("Liste/des_factures", [FactureController::class, 'index'])->name('facture.index');
    Route::get('Liste_facture_validee_par_banque', [FactureController::class, 'facture_valide_par_banque'])->name('facture.a_payer_de_par_banque');
    Route::post('store/paiement/facture', [FactureController::class, 'store_paiement'])->name('facture.storepaiement');
    Route::resource('prestataire', PrestataireController::class);
    Route::get('er/modif',[PrestataireController::class, 'modifier'] )->name('prestataire.modif');
    Route::post('prestataire/store_modif',[PrestataireController::class, 'modifierstore'] )->name('prestataire.storemodif');
    Route::resource('grille', GrilleEvalController::class);
    Route::get('gril/modif',[GrilleEvalController::class, 'modifier'] )->name('grille.modif');
    Route::post('gri/store_modif',[GrilleEvalController::class, 'modifierstore'] )->name('grille.storemodif');
    Route::post('pca_eval/store',[ProjetController::class, 'storeaval'] )->name('pca.evaluation');
    Route::get('lister_les_pca', [ProjetController::class, 'lister'])->name('projet.liste');
    Route::get('analyser_pca/{projet}', [ProjetController::class, 'analyser'])->name('projet.analyse');
    Route::post('/save/fiche_danalyse', [ProjetController::class, 'save_fiche_danalyse'])->name('save.fiche_danalyse');
    Route::post('/valider/investissements', [ProjetController::class, 'valider_investissement'])->name('save.ivestissement_valide');
    Route::post('/rejetter/investissements', [ProjetController::class, 'rejetter_investissement'])->name('rejeter.investissement');
    Route::post('add/investissement', [ProjetController::class, 'add_investissement'])->name('add.investissement'); 
    Route::get('/pca/valider/analyse', [ProjetController::class, 'valider_analyse'])->name('pca.valider_analyse');
    Route::get('/save/pca_statut/comite', [ProjetController::class, 'savedecisioncomite'])->name('pca.savedecisioncomite');
    Route::get('/liste_dattente/pca/comite', [ProjetController::class, 'put_pca_to_liste_dattente'])->name('pca.liste_dattente');
    Route::get('/pca/liste_dattente', [ProjetController::class, 'lister_pca_liste_dattente'])->name('pca.lister_liste_dattente');
    
    Route::get('/pca/avis_chefdezone', [ProjetController::class, 'pca_save_avis_chefdezone'])->name('pca.save_devis_chefdezone');
    Route::get('/pca/avis_ugp', [ProjetController::class, 'pca_save_avis_ugp'])->name('pca.save_avis_ugp');
    Route::get('/pca/selectionne/zone', [ProjetController::class, 'lister_pca_selectionne_par_zone'])->name('pca.selectionneparzone');
    Route::post('/demande_kyc/save/', [ProjetController::class, 'save_de_demande_kyc'])->name('save_de_demande_kyc');
    Route::post('/save_date_demande_creation_compte/save/', [ProjetController::class, 'save_date_demande_creation_compte'])->name('save_date_demande_creation_compte');
    Route::post('/store_creation_compte/save/', [ProjetController::class, 'save_date_creation_compte'])->name('save_date_creation_compte');
    Route::post('/resultat/kyc/', [ProjetController::class, 'save_result_kyc'])->name('save_result_kyc');
    Route::post('/import/resultat/kyc', [ProjetController::class,'importer_result_kyc'])->name('importer_resultat_kyc');
    Route::post('/import/dates/creation_compte', [ProjetController::class,'importer_date_creation_ss_compte'])->name('importer_date_creation_ss_compte');

    Route::get('demande/kyc', [ProjetController::class, 'lister_les_demandes_de_kyc'] )->name('liste_demande_kyc');
    Route::post('/enregistrer/accord/beneficaire', [ProjetController::class, 'save_accord_beneficiaire'])->name('save_accord_beneficiaire');
    Route::resource('coach', CoachController::class);
    Route::get('/scoach/modif/', [CoachController::class, 'modif'])->name('coach.modif');
    Route::post('/coach/save/modif/', [CoachController::class, 'enremodif'])->name('coach.enremodif');
    Route::get('/investissment',[ProjetController::class, 'invest_modif'])->name('investissement.modif');
    Route::post('/investissment/modifier',[ProjetController::class, 'invest_modifier'])->name('investissement.modifier');
    Route::get('/pca/modif',[ProjetController::class, 'pca_modif'])->name('pca.modif');
    Route::post('/pca/modifier',[ProjetController::class, 'pca_modifier'])->name('pca.modifier');
    Route::get('/piecejointe/modif',[ProjetController::class, 'modif_piecej'])->name('piece.modif');
    Route::post('/piecejointe/modifier',[ProjetController::class, 'modifier_piecej'])->name('piecejointe.modifier');
    Route::post('/image_bien_acquis/modifier',[FactureController::class, 'modifier_image_bien_acquis'])->name('image_bien_acquis.modifier');
    Route::post('/image_bien_acquis/store',[FactureController::class, 'ajouter_image_bien_acquis'])->name('image_bien_acquis.store');
    Route::post('/image_suivi_modifier/modifier',[DeviController::class, 'modifier_suivi_image'])->name('image_suivi.modifier');
    Route::post('/suivi_image/store',[DeviController::class, 'ajouter_image_suivi'])->name('image_suivi.store');

    Route::get('/projet/asuivre', [ProjetController::class, 'liste_des_projets_asuivre'])->name("projet.asuivre");
    Route::get('/devis/asuivre/projet/{projet}', [ProjetController::class, 'liste_des_devis_asuivre_par_projet'])->name("devis_asuivre_par_projet");
    Route::post('/acquisition/store/', [AcquisitionController::class, 'store'])->name("acquisition.store");
    Route::get('/acquisition/create_view/', [AcquisitionController::class, 'create'])->name("acquisition.create");
    Route::get('/acquisition/par_entreprise/{entreprise}', [AcquisitionController::class, 'par_entreprise'])->name("acquisition.par_entreprise");
    Route::get('/acquisition/valider/', [AcquisitionController::class, 'valider_acquisition'])->name("acquisition.valider");
    Route::get('/indicateurs', [ImpactController::class, 'liste_indicateur'] )->name("indicateur.index");
    Route::get('indicateur/modif',[ImpactController::class, 'modifier'] )->name('indicateur.modifier');
    Route::post('/indicateur/store', [ImpactController::class, 'store_indicateur'] )->name("indicateur.store");
    Route::post('/indicateur/update/', [ImpactController::class, 'update_indicateur'] )->name("indicateur.update");
    Route::get('impact/modif',[ImpactController::class, 'modifier_impact'] )->name('impact.modif');
    Route::post('/impact/update/', [ImpactController::class, 'updateImpact'] )->name("impact.modifier");
    Route::get('/impact/liste/', [ImpactController::class, 'index'] )->name("impact.index");
    Route::resource('impact', ImpactController::class);
    Route::get('/emploi/par/secteur_dactivite', [ImpactController::class, 'emploi_par_secteurdactivite'] )->name("impact.emploi_par_secteurdactivite");
    Route::get('/beneficiaire/ayant/augmente/personnel', [ImpactController::class, 'beneficiaires_ayant_cree_emplois'] )->name("impact.baneficaire_ayant_cree_emplois");
    Route::get('/emplois/cree/par/zone', [ImpactController::class, 'emploi_par_zone'] )->name("impact.emploi_par_zone");
    Route::get('/donnees/indicateur/par/secteur_dactivite', [ImpactController::class, 'indicateur_par_secteurdactivite'] )->name("impact.donnees_par_secteurdactivite");
    Route::get('/donnees/indicateur/par/zone', [ImpactController::class, 'indicateur_par_zone'] )->name("impact.donnees_par_zone");
    Route::resource('sucessStorie', SucessStorieController::class);
    Route::get('/trouvesucessStorie/get', [SucessStorieController::class, 'get_success_storie'] )->name("successStorie.get");
    Route::post('/modifiersucessStorie', [SucessStorieController::class, 'modifier_success_storie'] )->name("sucessStorie.modifier");
    Route::post('/supprimersucessStorie', [SucessStorieController::class, 'supprimer_success_storie'] )->name("sucessStorie.supprimer");
    

});
Route::get("/new/souscription", [PromotriceController::class, 'create'])->name("souscription");
Route::resource("promoteur", PromotriceController::class);
Route::resource('projet', ProjetController::class);
Route::resource("entreprise",EntrepriseController::class);
Route::post("creation",[EntrepriseController::class, 'creation'])->name("entreprise.creation");
Route::get("/verifierentreprise",[EntrepriseController::class, 'verifierentreprise'] )->name("verifierentreprise");
Route::post("/creerEntreprise/{code}",[EntrepriseController::class, 'create'])->name("entreprise.cree");
Route::get("/validation/souscription",[SouscriptionController::class, 'validersouscription'] )->name("entreprise.valider");
Route::get("/rejet/souscription",[SouscriptionController::class, 'statuersouscription'] )->name("entreprise.statuermembrecomite");
Route::get("/PME/valider/comite_technique/formation",[SouscriptionController::class, 'statuersurLasoucriptionPmeParleComitePourLaPhaseFormation'] )->name("entreprise.statuercomitetechniquepmephase1");
Route::get("/PME/rejeter/comite_technique/formation",[SouscriptionController::class, 'ajournerLasoucriptiondePmeParleComitePourLaPhaseFormation'] )->name("entreprise.rejetercomitetechnique");
Route::get("/souscription/analyserParLeComite", [SouscriptionController::class,'souscriptionAnalyses_par_lecomite'])->name("souscription.analyseParComite");
Route::get("store/second/entreprise/{promoteur}", [EntrepriseController::class, 'create2'])->name("secondEntreprise.store");
//Route::post("/projet", [EntrepriseController::class, 'saveProjet'])->name("projet.save");
Route::get("recepisse/print/{promoteur}",[EntrepriseController::class,'genereRecpisse'])->name("generer.recepisse");
Route::get("/souscription/poursuivre/",[PromotriceController::class, 'afficherform'])->name("afficherform");
Route::post("/pousuivre", [PromotriceController::class, 'search'])->name("search");
Route::get("/souscription/result", [PromotriceController::class, 'result'])->name("result");
Route::get("/planDecontinutePME/{idpromoteur}", [EntrepriseController::class, 'addPlanDeContinute'])->name("add.planDeContinute");
Route::get("/listerlesentreprise/retenues/parpromoteur", [PromotriceController::class, 'entrepriseRetenuParPromoteur'])->name("entrepriseRetenuParPromoteur");
Route::get("/tableau_de_detail", [DashboradController::class, 'dashboard'])->name("dashboard");
//Les details du tableau de bord
Route::get("/detail_dashboard", [DashboradController::class, 'detail_dashboard'])->name("detail_dashboard");
Route::get('dashboard/subvention_debloque_par_banque',  [DashboradController::class, 'situation_des_subventions_debloque_par_banque'])->name('situation_des_subventions_debloque_par_banque');
Route::get('dashboard/contrepartie/banque',[DashboradController::class, 'mobilisation_dela_contrepartie_par_banque'])->name("contrepartie.parbanque");
Route::get('dashboard/subvention/banque',[DashboradController::class, 'mobilisation_dela_subvention_par_banque'])->name("subvention.parbanque");

Route::get('dashboard/situation_des_paiements_par_banque',  [DashboradController::class, 'situation_des_paiements_par_banque'])->name('situation_des_paiements_par_banque');
Route::get("/dashboard/subvention_debloque_par_localite", [DashboradController::class, 'situation_subvention_par_zone'])->name("situation_subvention_par_zone");
Route::get("/dashboard/contrepartie_mobilisee_par_localite", [DashboradController::class, 'contrepartie_mobilisee_par_localite'])->name("contrepartie_mobilisee_par_localite");
Route::get('dashboard/contrepartie_verse_parmois',  [DashboradController::class, 'versement_contre_partie_par_periode'])->name('contrepartie_versee_par_periode');
Route::get("/dashboard/parsecteur", [DashboradController::class, 'souscriptionparsecteuractivite'])->name("souscriptionparsecteuractivite");
Route::get("/dashboard/retunu_parsecteur", [DashboradController::class, 'souscriptionretenueparsecteuractivite'])->name("souscriptionretenueparsecteuractivite");
Route::get("/dashboard/parzone", [DashboradController::class, 'souscriptionparzone'])->name("souscriptionparzone");
Route::get("/dashboard/entrepriseprelectionneparzone", [DashboradController::class, 'entreprisepreselectionneparzone'])->name("entreprise.preselectionneparzone");
Route::get("/dashboard/aopprelectionneparzone", [DashboradController::class, 'aopregisterparzone'])->name("aopleader.enregistreparzone");
Route::get("/dashboard/aop/enregistreParSecteurdactivite", [DashboradController::class, 'aopparsecteuractivite'])->name("aopleader.enregistreparsecteuractivite");
Route::get("/dashboard/listeEntrpriseRetenu", [DashboradController::class, 'souscriptionparzone'])->name("souscriptionparzone");
Route::get("/dashboard/enregistre_par_zone_par_secteur_d_activite", [DashboradController::class, 'enregistreSecteurActiviteZone'])->name("enregistreSecteurActiviteZone");
Route::get("/dashboard/entreprises/listepresentation", [DashboradController::class, 'dashboardliste'])->name("dashboardliste");
Route::get('/dashboard/entreprise_dashboard_detail/{id}',[DashboradController::class, 'entreprise_detail'])->name("dashboard.entreprise_detail");
Route::get("/dashboard/entreprises/retenue", [DashboradController::class, 'entreprise_retenues'])->name("entreprise_retenues");
Route::get('/dashboard/bank',[DashboradController::class, 'dashboard_bank'])->name("dashboad_banque");
Route::get("/financements/enregistres", [FinancementController::class, 'enregistre'])->name("financement.enregistres");
Route::get("updatelocalisation/", [EntrepriseController::class, 'updatelocalisationentreprise'])->name("localisation.entreprise");
Route::get("/dashboard/entreprises/geopresentation", [DashboradController::class, 'souscriptiongeopresenation'])->name("souscriptiongeopresenation");
Route::get("/dashboard/entreprises/listepresentation", [DashboradController::class, 'dashboardliste'])->name("dashboardliste");
Route::get("/promoteur/complement/{entreprise}", [EntrepriseController::class, 'completerPoportiondeDepensedupromoteur'])->name("promotrice.completeinfo");
Route::post("/store/complement/", [EntrepriseController::class, 'storePoportiondeDepensedupromoteur'])->name("proportiondedepense.enr");
Route::get("/dashboard/listeallsouscription", [DashboradController::class, 'listerallsouscription'])->name("listeallensouscription");
Route::get("/souscription/view/{id}", [EntrepriseController::class, 'view'])->name('entreprise.view');
Route::get("/souscription/rechercher", [SouscriptionController::class, 'afficherrechercher'])->name("souscription.rechercher");
Route::get("rechercher/filtre/", [SouscriptionController::class,'filtrerdata'])->name("filtrerdata");
Route::get("/pca/par_secteur_dactivite",[DashboarController::class,'pca_par_secteur_dactivite'])->name("pca.par_secteur_dactivite");
Route::resource("activites", ActiviteController::class);
Route::get('/activite/import/view', [ActiviteController::class, "return_view_import"])->name('activite.import_view');
Route::post("activite/import/store",  [ActiviteController::class, "chargerActivite"])->name('activite.import_store');
Route::get("tableau_de_bord/activites",  [ActiviteController::class, "liste_activite"])->name('activite.liste');
Route::resource("budgets", BudgetController::class);
Route::get('/budget/import/view', [BudgetController::class, "return_view_import"])->name('budget.import_view');
Route::post("budget/import/store",  [BudgetController::class, "chargerBudget"])->name('budget.import_store');
Route::post("budget/import/prevision/store",  [BudgetController::class, "chargerPrevisionBudget"])->name('budget.import_prevision_store');
Route::post("budget/import/cashflow/store",  [BudgetController::class, "chargerCashflow"])->name('budget.import_cashflow_store');
Route::get('/verifier/denomination_prestataire', [PrestataireController::class, 'verifier_denomination'])->name('prestataire.verifierDenomination');

Route::get("tableau_de_bord/budgets",  [BudgetController::class, "liste_budget"])->name('budget.liste');
Route::get("/commentSouscrire",function () {
    return view('commentSouscrire');
})->name("commentsouscrire");

Route::post("/contact/message/", [SouscriptionController::class, "contactSendMessage"])->name("contact");
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard',[DashboradController::class, 'principal_dashboard'])->name('dashboad_pricipale');
Route::get('/dashboardgeo', [DashboradController::class, 'dashboardgeo'])->name('dashboardgeo');
Route::get("/responsableaop", [ResponsableaopController::class,'create'])->name("responsableaop.create");
Route::post("/responsableaop/store", [ResponsableaopController::class,'store'])->name("responsableaop.store");
Route::get("/new/entreprise/AOP-L/{code}",[EntrepriseaopController::class, 'create'])->name("entrepriseaopl.new");
Route::post("/store/entreprises/AOP-Ls/store",[EntrepriseaopController::class, 'store'])->name("entrepriseaopl.store");
Route::get("/complete/responsableAOPLeader/{code}", [ResponsableaopController::class,'completeview'])->name("completeresponsableaop.view");
Route::post("/complete/store/responsableAOPLeader", [ResponsableaopController::class,'storecompleteresponsableaop'])->name("completeresponsableaop.store");
Route::get("/all/aop/", [SouscriptionAOPController::class, 'listerallsouscriptionAOPtermine'] )->name("listeAllAOP");
Route::get("/AOP/soumises_au_comite_technique", [SouscriptionAOPController::class, 'souscriptionaopsAanalyserParLeComite'])->name("AOPsoumises_au_comite_technique");
//Route::get("/aop/retenus/formation",[SouscriptionAOPController::class, 'aopretenues'] )->name("listeAOPretenu");
Route::get("/aop/analyseParLeComite", [SouscriptionAOPController::class,'souscriptionaopAnalyses_par_lecomite'])->name("aop.analyseParComite");
Route::get("/aop/retenu", [SouscriptionAOPController::class,'souscriptionsaopretenues'])->name("aop.retenu");
Route::get('/beneficiaire_login_form', [UserController::class, 'login_form_beneficiaire'])->name('login_beneficiaire');
route::post("/create/compte/beneficiaire/",[UserController::class,'storecomptePromoteur'])->name('storecompte.promoteur');
route::get("/verifier_promoteur/compte/",[UserController::class,'verifier_conformite_cpt'])->name('verifier_validite_cpt_promo');
Route::get("/espace/beneficiaire/",[BeneficiaireController::class,'gotoEspaceBeneficiaire'])->name('espace.beneficiaires');
Route::post('logout', [UserController::class, 'logout'])->name('logout');
Route::get("/beneficiciare/myprofil",[BeneficiaireController::class, 'showprofil'])->name("profil.beneficiaire");
Route::get('/beneficiciare/entreprise', [BeneficiaireController::class, 'showentreprisedata'])->name("profil.entreprise");
Route::get('/beneficiciare/devis', [DeviController::class, 'liste_devis_par_promoteur'])->name("profil.mesdevis");
Route::get('/devis/get_montant/', [DeviController::class, 'get_montant'])->name("devi.get_montant");
Route::post("/projet/add/piecejointe/",[ProjetController::class,'add_piecej_to_projet'])->name('add.piecetoprojet');

Route::get("/beneficiciare/myentreprise",[BeneficiaireController::class, 'showentreprise'])->name("entreprise.beneficiaire");
Route::get('/beneficiciare/updatedate/{promotrice}',[BeneficiaireController::class, 'updatebeneficiare'])->name('updateprofilbeneficiaire');
Route::get('/beneficiciare/updateentreprise/{entreprise}',[BeneficiaireController::class, 'updateEntrepriseBeneficiaire'])->name('updateEntrepriseBeneficiaire');
Route::get('souscriptions/listepostepreanalyse', [SouscriptionController::class, 'listersouscriptionpostpreanalyse'])->name("liste.postpreanalyse");
Route::resource('devi', DeviController::class);
Route::get('dee/modif',[DeviController::class, 'modifier'] )->name('devi.modif');
Route::post('dee/modifier',[DeviController::class, 'enr_modification'] )->name('devi.enrg_modification');
Route::get("/charger/devis/{url}", [DeviController::class, 'telechargerdevis'])->name('telechargerdevis');
Route::get("/charger/doc/{url}", [FactureController::class, 'telechargerfacture'])->name('telechargerfacture');
Route::get("changerStatus/devis", [DeviController::class, 'changerStatus'])->name('devi.changerstatus');
Route::get("/factures/{devi}", [FactureController::class, 'facture_dun_devis'])->name('facture.liste');
Route::post("/facture/store", [FactureController::class, 'store'])->name('facture.store');
Route::get("/facture/show/{facture}", [FactureController::class, 'view_beneficiaire'])->name('facture.view');

Route::get('facture/modif',[FactureController::class, 'modifier'] )->name('facture.modif');
Route::post('facture/modifier',[FactureController::class, 'enr_modification'] )->name('facture.enrg_modification');
Route::get('/facture/verifier_montant',[FactureController::class, 'verifier_montant'] )->name('verifier_montant');
Route::get('/devis/verifier_montant',[DeviController::class, 'verifier_montant_devis'] )->name('verifier_montant_devis');
Route::get('/accompte/verifier_montant',[AccompteController::class, 'verifier_montant'] )->name('verifier_montant_accompte');
Route::get('/show/factureById/{id}',[FactureController::class, 'showById'] )->name('facture.showById');
Route::post("simple-excel/export", [SimpleExcelController::class, "export"])->name('excel.export');
Route::get('ture/par/statut/banque',[FactureController::class, 'factureparstatutparbanque'] )->name('facture.parstatut');
Route::get('/dash/banque/perform',[DashboradController::class, 'dashboard_banque_perform'] )->name('dash.banque_perform');
Route::get('/liste/devis/suivre',[DeviController::class, 'listerASuivre'] )->name('devis.listerASuivre');
Route::get('/devis/suivre/{devis}',[DeviController::class, 'suivreDevis'] )->name('devis.suivre');
Route::post('store/suivi_devis', [DeviController::class, 'store_suiviDevis'])->name('suivreDevis.store');
Route::get('/suivis/devis/',[DeviController::class, 'suivi_devis_modif'] )->name('suivi_devis.modif');
Route::post("suivis/devis/modifier", [DeviController::class, "suivi_devis_modifier"])->name('suivi_devis.modifier');
Route::get('telechargerimagesuivi/{suiviExecutionDevi}', [DeviController::class,'edit_de_suivi'])->name('edit_de_suivi');
Route::get('visualiserimagesuivi/{suiviExecutionDevi}', [DeviController::class,'visualiser_image_de_suivi'])->name('visualiser_image_de_suivi');
Route::get('visualiserdetailSuivi/{suiviExecutionDevi}', [DeviController::class,'visualiser_details_de_suivi'])->name('visualiser_detail_suivi');

Route::get('/facture/delais_de_paiment', [FactureController::class, 'group_by_delais_de_paiement'])->name('facture.groupbydelaidetraitement');
Route::get('/facture/edit/{facture}', [FactureController::class, 'edit'])->name('facture.edit');

Route::get('/activity_all/liste', [ActiviteController::class, 'liste_activity'])->name('activity.liste');
Route::get('/all_activity/json', [ActiviteController::class, 'activity_all'])->name('all.activity');





