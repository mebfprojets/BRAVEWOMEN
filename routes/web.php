<?php

use App\Http\Controllers\AccompteController;
use App\Http\Controllers\BanqueController;
use App\Http\Controllers\BaremeController;
use App\Http\Controllers\DashboradController;
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
use App\Models\Entreprise;
use App\Models\Formation;
use App\Models\Parametre;
use App\Models\Valeur;
use App\Policies\SouscriptionPolicy;
use Illuminate\Support\Facades\Route;

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
    Route::resource('banque', BanqueController::class);
    Route::get('banque/affecter/beneficiaire/{banque}', [BanqueController::class, 'affecter_des_beneficiaire'])->name("banque.affecter");
    Route::get('banks/affecter/beneficiaire/store', [BanqueController::class, 'store_affifiation_beneficiaire_banque'])->name("banque.storeaffiliation");
    Route::get('bank/affecter/beneficiaire/destore', [BanqueController::class, 'annuler_affifiation_beneficiaire_banque'])->name("banque.supprimeraffiliation");
    Route::get('Beneficary/bank/list', [BanqueController::class, 'liste_des_beneficiaires_de_la_banque'])->name("banque.beneficiaires");
    Route::get('subscribe/excel', [SouscriptionController::class, 'generer_en_excel'])->name("generer.excel"); 
    Route::get("create/account/forbeneficiary/{entreprise}",[AccompteController::class,'create_for_beneficiary'])->name('entreprise.accompte.create');
    Route::get("list/account/forbeneficiary/{entreprise}",[AccompteController::class,'accompte_de_la_beneficiaire'])->name('entreprise.accompte');
    Route::resource("accompte",AccompteController::class);
    Route::get("recu/versement_account/{accompt}",[AccompteController::class,'get_recu'])->name('account.getRecu');
    Route::get("create/subvention/forbeneficiary/{entreprise}",[SubventionController::class,'create_for_beneficiary'])->name('entreprise.subvention.create');
    Route::get("list/subvention/forbeneficiary/{entreprise}",[SubventionController::class,'subvention_de_la_beneficiaire'])->name('entreprise.subvention');
    Route::get("/subvention/valider_montant",[SubventionController::class,'valider_montant'])->name('valider_montant');
    
    Route::resource("subvention",SubventionController::class);
    Route::get("versement_account/{accompt}",[AccompteController::class,'get_recu'])->name('subvention.getRecu');

});
Route::get("/new/souscription", [PromotriceController::class, 'create'])->name("souscription");
Route::resource("promoteur", PromotriceController::class);
Route::resource('projet', ProjetController::class);
Route::resource("entreprise",EntrepriseController::class);
Route::get("/verifierentreprise",[EntrepriseController::class, 'verifierentreprise'] )->name("verifierentreprise");
Route::post("/creerEntreprise/{code}",[EntrepriseController::class, 'create'])->name("entreprise.cree");
Route::get("/validation/souscription",[SouscriptionController::class, 'validersouscription'] )->name("entreprise.valider");
Route::get("/rejet/souscription",[SouscriptionController::class, 'statuersouscription'] )->name("entreprise.statuermembrecomite");
Route::get("/PME/valider/comite_technique/formation",[SouscriptionController::class, 'statuersurLasoucriptionPmeParleComitePourLaPhaseFormation'] )->name("entreprise.statuercomitetechniquepmephase1");
Route::get("/PME/rejeter/comite_technique/formation",[SouscriptionController::class, 'ajournerLasoucriptiondePmeParleComitePourLaPhaseFormation'] )->name("entreprise.rejetercomitetechnique");
Route::get("/souscription/analyserParLeComite", [SouscriptionController::class,'souscriptionAnalyses_par_lecomite'])->name("souscription.analyseParComite");
Route::get("store/second/entreprise/{promoteur}", [EntrepriseController::class, 'create2'])->name("secondEntreprise.store");
Route::post("/projet", [EntrepriseController::class, 'saveProjet'])->name("projet.save");
Route::get("recepisse/print/{promoteur}",[EntrepriseController::class,'genereRecpisse'])->name("generer.recepisse");
Route::get("/souscription/poursuivre/",[PromotriceController::class, 'afficherform'])->name("afficherform");
Route::post("/pousuivre", [PromotriceController::class, 'search'])->name("search");
Route::get("/souscription/result", [PromotriceController::class, 'result'])->name("result");
Route::get("/planDecontinutePME/{idpromoteur}", [EntrepriseController::class, 'addPlanDeContinute'])->name("add.planDeContinute");
Route::get("/listerlesentreprise/retenues/parpromoteur", [PromotriceController::class, 'entrepriseRetenuParPromoteur'])->name("entrepriseRetenuParPromoteur");
Route::get("/dashboard/parsecteur", [DashboradController::class, 'souscriptionparsecteuractivite'])->name("souscriptionparsecteuractivite");
Route::get("/dashboard/retunu_parsecteur", [DashboradController::class, 'souscriptionretenueparsecteuractivite'])->name("souscriptionretenueparsecteuractivite");
Route::get("/dashboard/parzone", [DashboradController::class, 'souscriptionparzone'])->name("souscriptionparzone");
Route::get("/dashboard/mpmeprelectionneparzone", [DashboradController::class, 'mpemepreselectionneparzone'])->name("mpeme.preselectionneparzone");
Route::get("/dashboard/aopprelectionneparzone", [DashboradController::class, 'aopregisterparzone'])->name("aopleader.enregistreparzone");
Route::get("/dashboard/aop/enregistreParSecteurdactivite", [DashboradController::class, 'aopparsecteuractivite'])->name("aopleader.enregistreparsecteuractivite");
Route::get("/dashboard/listeEntrpriseRetenu", [DashboradController::class, 'souscriptionparzone'])->name("souscriptionparzone");
Route::get("/dashboard/enregistre_par_zone_par_secteur_d_activite", [DashboradController::class, 'enregistreSecteurActiviteZone'])->name("enregistreSecteurActiviteZone");
Route::get("/dashboard/entreprises/listepresentation", [DashboradController::class, 'dashboardliste'])->name("dashboardliste");
Route::get("/dashboard/entreprises/retenue", [DashboradController::class, 'entreprise_retenues'])->name("entreprise_retenues");
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
Route::get("/commentSouscrire",function () {
    return view('commentSouscrire');
})->name("commentsouscrire");
Route::post("/contact/message/", [SouscriptionController::class, "contactSendMessage"])->name("contact");
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard',[DashboradController::class, 'dashboard'])->name('dashboard');
Route::get('/dashboardgeo', [DashboradController::class, 'dashboardgeo'])->name('dashboardgeo');
// AOP Routes 
Route::get("/responsableaop", [ResponsableaopController::class,'create'])->name("responsableaop.create");
Route::post("/responsableaop/store", [ResponsableaopController::class,'store'])->name("responsableaop.store");
Route::get("/new/entreprise/AOP-L/{code}",[EntrepriseaopController::class, 'create'])->name("entrepriseaopl.new");
Route::post("/store/entreprises/AOP-Ls/store",[EntrepriseaopController::class, 'store'])->name("entrepriseaopl.store");
Route::get("/complete/responsableAOPLeader/{code}", [ResponsableaopController::class,'completeview'])->name("completeresponsableaop.view");
Route::post("/complete/store/responsableAOPLeader", [ResponsableaopController::class,'storecompleteresponsableaop'])->name("completeresponsableaop.store");
Route::get("/all/aop/", [SouscriptionAOPController::class, 'listerallsouscriptionAOPtermine'] )->name("listeAllAOP");
Route::get("/AOP/soumises_au_comite_technique", [SouscriptionAOPController::class, 'souscriptionaopsAanalyserParLeComite'])->name("AOPsoumises_au_comite_technique");
Route::get("/aop/retenus/formation",[SouscriptionAOPController::class, 'aopretenues'] )->name("listeAOPretenu");
Route::get("/aop/analyseParLeComite", [SouscriptionAOPController::class,'souscriptionaopAnalyses_par_lecomite'])->name("aop.analyseParComite");
Route::get("/aop/retenu", [SouscriptionAOPController::class,'souscriptionsaopretenues'])->name("aop.retenu");



