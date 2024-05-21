<?php

namespace App\Providers;

use App\Policies\ParametrePolicy;
use App\Policies\RolePolicy;
use App\Policies\SouscriptionPolicy;
use App\Policies\UserPolicy;
use App\Policies\DevisPolicy; 
use App\Policies\ValeurPolicy;
use App\Policies\ProjetPolicy;
use App\Policies\BanquePolicy;
use App\Policies\FacturePolicy; 
use App\Policies\DocumentPolicy; 

use App\Policies\SuccessStoriesPolicy;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::resource('role', RolePolicy::class);
        Gate::resource('parametre', ParametrePolicy::class);
        Gate::resource('valeur', ValeurPolicy::class);
       // Gate::resource('parametre', 'App\Policies\ParametrePolicy');
        Gate::resource('souscription', SouscriptionPolicy::class);
        Gate::resource('banque', BanquePolicy::class);
        Gate::resource('devis', DevisPolicy::class);
        Gate::resource('facture', FacturePolicy::class);
        Gate::resource('document', DocumentPolicy::class);
        Gate::resource('accompte', AccomptePolicy::class);
        Gate::resource('prestataire', PrestatairePolicy::class);
        Gate::resource('projet', ProjetPolicy::class);
        Gate::resource('prestataire', PrestatairePolicy::class);
        Gate::resource('user', UserPolicy::class);
        Gate::define('souscription.liste', [SouscriptionPolicy::class, 'listerAllsoucription'] );
        Gate::define('souscription.prevalidable',[SouscriptionPolicy::class,'listerprevalidablesouscription'] );
        Gate::define('souscription.soumis_au_comite',[SouscriptionPolicy::class,'listervalidablesouscription'] );
        Gate::define('souscription.statuerSurSouscription',[SouscriptionPolicy::class,'statuerSurSouscription'] );
        Gate::define('souscription.listerRetenues',[SouscriptionPolicy::class,'listerSouscriptionsRetenues'] );
        Gate::define('souscription.listerParZone',[SouscriptionPolicy::class,'listerSouscriptionsParzone'] );
        Gate::define('formation.listerFormation',[SouscriptionPolicy::class,'listerFormation'] );
        Gate::define('formation.modifier',[SouscriptionPolicy::class,'modifierFormation'] );
        Gate::define('formation.all',[SouscriptionPolicy::class,'listerTouteLesFormation'] );
        Gate::define('entreprise.geolocalise',[SouscriptionPolicy::class,'geolocaliser'] );
        Gate::define('tableau.debord',[SouscriptionPolicy::class,'tableauDebord'] );
        Gate::define('dashboard.ugp',[SouscriptionPolicy::class,'tableauDebordUgp'] );
        Gate::define('acceder.aux_decision_du_dossier',[SouscriptionPolicy::class,'acceder_aux_decisions_sur_le_dossier'] );
        Gate::define('avisqualitative_ugp',[SouscriptionPolicy::class,'avisqualitative_ugp'] );
        Gate::define('avisfinal_ugp',[SouscriptionPolicy::class,'avisfinal_ugp'] );
        Gate::define('verdict_comite',[SouscriptionPolicy::class,'verdict_comite'] );
        Gate::define('acceder_souscriptions',[SouscriptionPolicy::class,'acceder_souscriptions'] );
        Gate::define('donner_avis_membre_comite',[SouscriptionPolicy::class,'donner_avis_membre_comite'] );
        Gate::define('lister_devis_soumis',[DevisPolicy::class,'lister_devis_soumis'] );
        Gate::define('lister_devis_transmis_au_pm',[ DevisPolicy::class,'lister_devis_transmis_au_pm'] );
        Gate::define('lister_all_devis',[DevisPolicy::class,'lister_all_devis'] );
        Gate::define('changer_statut_facture_ou_devis',[FacturePolicy::class,'changer_statut_facture_ou_devis'] );
        Gate::define('facture.payer',[FacturePolicy::class,'payer_facture'] );
        Gate::define('lister_facture.a_payer',[FacturePolicy::class,'payer_a_facture'] );
        Gate::define('analyser_devis',[DevisPolicy::class,'analyser_devis'] );
        Gate::define('lister_chef_de_projet',[ProjetPolicy::class,'lister_chef_de_projet'] );
        Gate::define('donne_verdict_du_comite_pca',[ProjetPolicy::class,'verdict_du_comite_pca'] );
        Gate::define('lister_pca_chef_de_zone',[ProjetPolicy::class,'lister_pca_chef_de_zone'] );
        Gate::define('dashboard_bank',[BanquePolicy::class,'dashboard_bank'] );
        Gate::define('lister_client_bank',[BanquePolicy::class,'lister_client_bank'] );
        Gate::define('enregistrer_kyc',[ProjetPolicy::class,'enregistrer_kyc'] );
        Gate::define('enregistrer_contrepartie',[BanquePolicy::class,'enregistrer_contrepartie'] );
        Gate::define('enregistrer_subvention',[BanquePolicy::class,'enregistrer_subvention'] );
        Gate::define('enregistrer_paiement',[BanquePolicy::class,'enregistrer_paiement'] );
        Gate::define('lister_les_mouvements_financiers',[SouscriptionPolicy::class,'lister_les_mouvements_financiers'] );
        Gate::define('valider_analyse_pca',[ProjetPolicy::class,'valider_analyse_pca'] );
        Gate::define('suivre_execution_pca',[ProjetPolicy::class,'suivre_execution_pca'] );
        Gate::define('valider_execution_pca',[ProjetPolicy::class,'valider_execution_pca'] );
        Gate::define('acceder_aux_pca_selectionne',[ProjetPolicy::class,'acceder_pca_selectionnes'] );
        Gate::define('update_suivi_execution_devis',[DevisPolicy::class,'update_devis_execution'] );
        Gate::define('creer_success_stories',[SuccessStoriesPolicy::class,'create'] );
        Gate::define('update_success_stories',[SuccessStoriesPolicy::class,'update'] );
    }
}
