<?php

namespace App\Providers;

use App\Policies\ParametrePolicy;
use App\Policies\RolePolicy;
use App\Policies\SouscriptionPolicy;
use App\Policies\UserPolicy;
use App\Policies\ValeurPolicy;
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
        Gate::resource('user', UserPolicy::class);
        Gate::define('souscription.liste', [SouscriptionPolicy::class, 'listerAllsoucription'] );
        Gate::define('souscription.prevalidable',[SouscriptionPolicy::class,'listerprevalidablesouscription'] );
        Gate::define('souscription.soumis_au_comite',[SouscriptionPolicy::class,'listervalidablesouscription'] );
        Gate::define('souscription.statuerSurSouscription',[SouscriptionPolicy::class,'statuerSurSouscription'] );
        Gate::define('souscription.listerRetenues',[SouscriptionPolicy::class,'listerSouscriptionsRetenues'] );
        Gate::define('souscription.listerParZone',[SouscriptionPolicy::class,'listerSouscriptionsParzone'] );
        Gate::define('formation.listerFormation',[SouscriptionPolicy::class,'listerFormation'] );
        Gate::define('formation.modifier',[SouscriptionPolicy::class,'modifierFormation'] );
        Gate::define('entreprise.geolocalise',[SouscriptionPolicy::class,'geolocaliser'] );
        Gate::define('tableau.debord',[SouscriptionPolicy::class,'tableauDebord'] );
        Gate::define('avisqualitative_ugp',[SouscriptionPolicy::class,'avisqualitative_ugp'] );
        Gate::define('avisfinal_ugp',[SouscriptionPolicy::class,'avisfinal_ugp'] );
        Gate::define('verdict_comite',[SouscriptionPolicy::class,'verdict_comite'] );
        Gate::define('acceder_souscriptions',[SouscriptionPolicy::class,'acceder_souscriptions'] );
    }
}
