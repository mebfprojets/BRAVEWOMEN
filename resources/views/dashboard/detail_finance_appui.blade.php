@extends('layouts.principale_dash')
@section('dashboard', 'active')
@section($dash_phase, 'active')
@section('content')
<div class="row" >
    <div class="row text-center">
        <div class="col-sm-6 col-lg-3">
            <a onclick="change_view('global','contrepartie','facture','autre','subvention')" href="javascript:void(0)" class="widget widget-hover-effect2">
                <div class="widget-extra themed-background mobilisation-b1">
                    <h4 class="widget-content-light"><strong>Subvention </strong> Mobilisée</h4>
                </div>
                <div class="widget-extra-full"><span class="h2 animation-expandOpen">{{ format_prix($total_subvention_verse) }}F CFA</span></div>
            </a>
        </div>
        <div class="col-sm-6 col-lg-3">
            <a onclick="change_view('global','subvention','facture','autre','contrepartie')" href="javascript:void(0)" class="widget widget-hover-effect2">
                <div class="widget-extra themed-background mobilisation-b2">
                    <h4 class="widget-content-light"><strong>Contre partie</strong> Mobilisée </h4>
                </div>
                <div class="widget-extra-full"><span class="h2 themed-color-dark animation-expandOpen"> {{ format_prix($total_contrepartie_verse) }}F CFA</span></div>
            </a>
        </div>
        <div class="col-sm-6 col-lg-3">
            <a onclick="change_view('global','subvention','contrepartie','facture', 'autre')" href="javascript:void(0)" class="widget widget-hover-effect2">
                <div class="widget-extra themed-background mobilisation-b3">
                    <h4 class="widget-content-light"><strong>Devis validés</strong></h4>
                </div>
                <div class="widget-extra-full"><span class="h2 themed-color-dark animation-expandOpen">{{ format_prix($montant_devi_valide) }} FCFA</span></div>
            </a>
        </div>
        <div class="col-sm-6 col-lg-3 ">
            <a onclick="change_view('global','subvention','contrepartie','autre','facture')"  href="javascript:void(0)" class="widget widget-hover-effect2">
                <div class="widget-extra themed-background mobilisation-b4">
                    <h4 class="widget-content-light"><strong>Factures</strong> enregistrées</h4>
                </div>
                <div class="widget-extra-full"><span class="h2 themed-color-dark animation-expandOpen">{{ format_prix($montant_facture_enregistrees) }} FCFA</span></div>
            </a>
        </div>
        
    </div>
</div>
<div class="block global">
    <!-- Referred Members Title -->
    <div class="block-title">
        <h2><i class="fa fa-line-chart"></i> <strong>Mobilisation des fonds</strong> par banque </h2>
    </div>
    <div class="row">
    @foreach ($mobilisation_par_banque as $mobilisation)
            <div class="col-lg-4">
                <a href="javascript:void(0)" class="widget widget-hover-effect2 themed-background-muted-light">
                    <div class="widget-simple">
                        <img src="img/placeholders/avatars/avatar12.jpg" alt="avatar" class="widget-image img-circle pull-left">
                        <h4 class="widget-content text-right">
                            <strong>{{ return_sigle_bank($mobilisation->nom)}}</strong>
                            <small>Montant mobilisé: <strong>{{ format_prix($mobilisation->montant) }} F CFA</strong></small>
                        </h4>
                    </div>
                </a>
            </div>
    @endforeach  
    </div>
</div>
<div class="block global">
    <!-- Referred Members Title -->
    <div class="block-title">
        <h2><i class="fa fa-line-chart"></i> <strong>Mobilisation des fonds</strong> par cible </h2>
    </div>
    <!-- END Referred Members Title -->

    <!-- Referred Members Content -->
    <div class="row">
    @foreach ($mobilisation_par_categorie as $mobilisation_par_cat )
            <div class="col-lg-4">
                <a href="javascript:void(0)" class="widget widget-hover-effect2 themed-background-muted-light">
                    <div class="widget-simple">
                        <img src="img/placeholders/avatars/avatar12.jpg" alt="avatar" class="widget-image img-circle pull-left">
                        <h4 class="widget-content text-right">
                            <strong>{{ return_categorie_entreprise($mobilisation_par_cat->categorie) }}</strong>
                            <small>Montant mobilisé: <strong>{{ format_prix($mobilisation_par_cat->montant) }} FCFA</strong></small>
                        </h4>
                    </div>
                </a>
            </div>
    @endforeach
</div>
</div>
<div class="block subvention" style="display: none">
    <!-- Referred Members Title -->
    <div class="block-title">
        <h2><i class="fa fa-line-chart"></i> <strong>Mobilisation de la subvention</strong> Par banque </h2>
    </div>
    <!-- END Referred Members Title -->

    <!-- Referred Members Content -->
    <div class="row">
    @foreach ($subvention_par_banque as $subvention)
            <div class="col-lg-4">
                <a href="javascript:void(0)" class="widget widget-hover-effect2 themed-background-muted-light">
                    <div class="widget-simple">
                        <img src="img/placeholders/avatars/avatar12.jpg" alt="avatar" class="widget-image img-circle pull-left">
                        <h4 class="widget-content text-right">
                            <strong>{{ return_sigle_bank($subvention->nom)}}</strong>
                            <small>Montant: <strong>{{ format_prix($subvention->montant) }} F CFA</strong></small>
                        </h4>
                    </div>
                </a>
            </div>
    @endforeach
       
        
    </div>
    <!-- END Referred Members Content -->
</div>
<div class="block subvention" style="display: none">
    <!-- Referred Members Title -->
    <div class="block-title">
        <h2><i class="fa fa-line-chart"></i> <strong>Mobilisation de la subvention</strong> Categorie d'entreprise </h2>
    </div>
    <!-- END Referred Members Title -->

    <!-- Referred Members Content -->
    <div class="row">
    @foreach ($subvention_par_categorie as $subvention_par_cat )
            <div class="col-lg-4">
                <a href="javascript:void(0)" class="widget widget-hover-effect2 themed-background-muted-light">
                    <div class="widget-simple">
                        <img src="img/placeholders/avatars/avatar12.jpg" alt="avatar" class="widget-image img-circle pull-left">
                        <h4 class="widget-content text-right">
                            <strong>{{ return_categorie_entreprise($subvention_par_cat->categorie) }}</strong>
                            <small>Montant mobilisé: <strong>{{ format_prix($subvention_par_cat->montant) }} F CFA</strong></small>
                        </h4>
                    </div>
                </a>
            </div>
    @endforeach
        
    <!-- END Referred Members Content -->
</div>
</div>
<div class="block contrepartie" style="display: none">
    <!-- Referred Members Title -->
    <div class="block-title">
        <h2><i class="fa fa-line-chart"></i> <strong>Mobilisation de la contrepartie</strong> par banque </h2>
    </div>

    <div class="row">
    @foreach ($contrepartie_par_banque as $contrepartie_par_bank )
            <div class="col-lg-4">
                <a href="javascript:void(0)" class="widget widget-hover-effect2 themed-background-muted-light">
                    <div class="widget-simple">
                        <img src="img/placeholders/avatars/avatar12.jpg" alt="avatar" class="widget-image img-circle pull-left">
                        <h4 class="widget-content text-right">
                            <strong>{{ return_sigle_bank($contrepartie_par_bank->nom) }}</strong>
                            <small>Montant mobilisé: <strong>{{ format_prix($contrepartie_par_bank->montant) }} F CFA</strong></small>
                        </h4>
                    </div>
                </a>
            </div>
    @endforeach
        
    <!-- END Referred Members Content -->
</div>
</div>
<div class="block contrepartie" style="display: none">
    <!-- Referred Members Title -->
    <div class="block-title">
        <h2><i class="fa fa-line-chart"></i> <strong>Mobilisation de la contrepartie</strong> Categorie d'entreprise </h2>
    </div>
    <!-- END Referred Members Title -->

    <!-- Referred Members Content -->
    <div class="row">
    @foreach ($contrepartie_par_categorie as $contrepartie_par_cat )
            <div class="col-lg-4">
                <a href="javascript:void(0)" class="widget widget-hover-effect2 themed-background-muted-light">
                    <div class="widget-simple">
                        <img src="img/placeholders/avatars/avatar12.jpg" alt="avatar" class="widget-image img-circle pull-left">
                        <h4 class="widget-content text-right">
                            <strong>{{ return_categorie_entreprise($contrepartie_par_cat->categorie) }}</strong>
                            <small>Montant mobilisé: <strong>{{ format_prix($contrepartie_par_cat->montant) }} F CFA</strong></small>
                        </h4>
                    </div>
                </a>
            </div>
    @endforeach
        
    <!-- END Referred Members Content -->
</div>
</div>

<div class="block autre" style="display: none">
    <!-- Referred Members Title -->
    <div class="block-title">
        <h2><i class="fa fa-line-chart"></i> <strong>Devis validés</strong> Par banque </h2>
    </div>
    <!-- END Referred Members Title -->

    <!-- Referred Members Content -->
    <div class="row">
    @foreach ($devis_valides_par_banques as $devis_valides_par_banque )
            <div class="col-lg-4">
                <a href="javascript:void(0)" class="widget widget-hover-effect2 themed-background-muted-light">
                    <div class="widget-simple">
                        <img src="img/placeholders/avatars/avatar12.jpg" alt="avatar" class="widget-image img-circle pull-left">
                        <h4 class="widget-content text-right">
                            <strong>{{ return_sigle_bank($devis_valides_par_banque->nom) }}</strong>
                            <small>Nombre: <strong>{{ $devis_valides_par_banque->nombre}}</strong></small>
                            <small>Montant: <strong>{{ format_prix($devis_valides_par_banque->montant) }} F CFA</strong></small>
                        </h4>
                    </div>
                </a>
            </div>
    @endforeach
        
    <!-- END Referred Members Content -->
</div>
</div>
<div class="block autre" style="display: none">
    <!-- Referred Members Title -->
    <div class="block-title">
        <h2><i class="fa fa-line-chart"></i> <strong>Devis validés</strong> par cible </h2>
    </div>
    <!-- END Referred Members Title -->

    <!-- Referred Members Content -->
    <div class="row">
    @foreach ($devis_valides_par_categories as $devis_valides_par_categorie )
            <div class="col-lg-4">
                <a href="javascript:void(0)" class="widget widget-hover-effect2 themed-background-muted-light">
                    <div class="widget-simple">
                        <img src="img/placeholders/avatars/avatar12.jpg" alt="avatar" class="widget-image img-circle pull-left">
                        <h4 class="widget-content text-right">
                            <strong style="text-transform: uppercase">{{ return_categorie_entreprise($devis_valides_par_categorie->categorie) }}</strong>
                            <small>Nombre: <strong>{{ $devis_valides_par_categorie->nombre}}</strong></small>
                            <small>Montant: <strong>{{ format_prix($devis_valides_par_categorie->montant) }}</strong></small>
                        </h4>
                    </div>
                </a>
            </div>
    @endforeach
        
    <!-- END Referred Members Content -->
</div>
</div>
<div class="block facture" style="display: none">
    <!-- Referred Members Title -->
    <div class="block-title">
        <h2><i class="fa fa-line-chart"></i> <strong>Facture en attente de Paiements</strong> par banque</h2>
    </div>
    <!-- END Referred Members Title -->

    <!-- Referred Members Content -->
    <div class="row">
    @foreach ($paiement_en_attentes as $factures_val )
            <div class="col-lg-4">
                <a href="javascript:void(0)" class="widget widget-hover-effect2 themed-background-muted-light">
                    <div class="widget-simple">
                        <img src="img/placeholders/avatars/avatar12.jpg" alt="avatar" class="widget-image img-circle pull-left">
                        <h4 class="widget-content text-right">
                            <strong>{{ return_sigle_bank($factures_val->nom) }}</strong>
                            <small>Nombre: <strong>{{ $factures_val->nombre}}</strong></small><small>Montant: <strong>{{ format_prix($factures_val->montant) }}</strong></small>
                        </h4>
                    </div>
                </a>
            </div>
    @endforeach
        
    <!-- END Referred Members Content -->
</div>
</div>
<div class="block facture" style="display: none">
    <!-- Referred Members Title -->
    <div class="block-title">
        <h2><i class="fa fa-line-chart"></i> <strong>Factures payées</strong> par banque</h2>
    </div>
    <!-- END Referred Members Title -->

    <!-- Referred Members Content -->
    <div class="row">
    @foreach ($paiement_par_banque as $paiement_par_k )
            <div class="col-lg-4">
                <a href="javascript:void(0)" class="widget widget-hover-effect2 themed-background-muted-light">
                    <div class="widget-simple">
                        <img src="img/placeholders/avatars/avatar12.jpg" alt="avatar" class="widget-image img-circle pull-left">
                        <h4 class="widget-content text-right">
                            <strong>{{ return_sigle_bank($paiement_par_k->nom) }}</strong>
                            <small>Nombre: <strong>{{ $paiement_par_k->nombre}}</strong></small><small>Montant payé: <strong>{{ format_prix($paiement_par_k->montant) }}</strong></small>
                        </h4>
                    </div>
                </a>
            </div>
    @endforeach
        
    <!-- END Referred Members Content -->
</div>
</div>

<div class="block facture" style="display: none">
    <!-- Referred Members Title -->
    <div class="block-title">
        <h2><i class="fa fa-line-chart"></i> <strong>Situation des factures</strong> par statut </h2>
    </div>
    <!-- END Referred Members Title -->

    <!-- Referred Members Content -->
    <div class="row">
    @foreach ($facture_par_statut as $facture_par_stat )
            <div class="col-lg-4">
                <a href="javascript:void(0)" class="widget widget-hover-effect2 themed-background-muted-light">
                    <div class="widget-simple">
                        <img src="img/placeholders/avatars/avatar12.jpg" alt="avatar" class="widget-image img-circle pull-left">
                        <h4 class="widget-content text-right">
                            <strong>{{ return_status_facture($facture_par_stat->statut) }}</strong>
                            <small>Nombre: <strong>{{ $facture_par_stat->nombre}}</strong></small>
                            <small>Montant mobilisé: <strong>{{ format_prix($facture_par_stat->montant) }}</strong></small>
                        </h4>
                    </div>
                </a>
            </div>
    @endforeach
        
    <!-- END Referred Members Content -->
</div>
</div>


<div  class="col-md-12 col-md-offset-1 block full" style="margin-left: 10px;">
    <!-- Your Plan Widget -->
    
          <!-- Tags Title -->
          <div class="block-title">
              <div class="block-options pull-right">
                  <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="Add Tag"><i class="fa fa-plus"></i></a>
              </div>
              <h2> <i class="fa fa-tags"></i> Details sur les Mouvements financiers  <strong></strong></h2>
          </div>
          <!-- END Tags Title -->

          <!-- Tags Content -->
        
          <div class="row">
            <div class="col-md-6" id="indicateur3">
    
            </div>
            <div class="col-md-6" id="indicateur4">
    
            </div>
        </div>
        <hr>
    <div class="row">
        <div class="col-md-6 divscrolable">
                <p style="border-bottom: 1px solid black">Situation des subventions débloquées par région </p>
                <div class='divscrolable'>
                    <table class="styled-table">
                        <tr>
                        <th >Région</th>
                        @foreach($subvention_par_regions as $subvention_par_region)
                           <td>{{ $subvention_par_region->region }}</td> 
                       @endforeach
                        
                        </tr>
                        <tr>
                        <tr>
                            <th>Montant des subventions debloquées</th>
                            @foreach($subvention_par_regions as $subvention_par_region)
                              <td style="text-align:right">{{ format_prix($subvention_par_region->montant) }}</td> 
                            @endforeach
                        </tr>
                    </table>
                </div>
        </div>
        <div class="col-md-6 divscrolable">
            <p style="border-bottom: 1px solid black">Situation de la contrepartie mobilisée par region </p>
            <div class='divscrolable'>
                <table class="styled-table">
                    <tr>
                    <th>Région</th>
                       @foreach($contrepartie_par_region as $contrepartie_par_secteur_dactivite)
                           <td>{{ $contrepartie_par_secteur_dactivite->region }}</td> 
                       @endforeach
                    </tr>
                    <tr>
                    <tr>
                        <th>Montant contrepartie mobilisée</th>
                        @foreach($contrepartie_par_region as $contrepartie_par_secteur_dactivite)
                           <td style="text-align:right">{{ format_prix($contrepartie_par_secteur_dactivite->montant) }}</td> 
                       @endforeach
                    </tr>
                </table>
            </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 divscrolable">
            <p style="border-bottom: 1px solid black">Situation des subventions debloquees </p>
            <div class='divscrolable'>
                <table class="styled-table">
                    <tr>
                    <th >Secteur d'activité</th>
                    @foreach($subvention_par_secteur_dactivites as $subvention_par_secteur_dactivite)
                       <td >{{ $subvention_par_secteur_dactivite->secteur }}</td> 
                   @endforeach
                    
                    </tr>
                    <tr>
                    <tr>
                        <th>Total des subventions debloquees</th>
                        @foreach($subvention_par_secteur_dactivites as $subvention_par_secteur_dactivite)
                          <td style="text-align:right">{{ format_prix($subvention_par_secteur_dactivite->montant) }}</td> 
                        @endforeach
                    </tr>
                </table>
            </div>
    </div>
    <div class="col-md-6 divscrolable">
        <p style="border-bottom: 1px solid black">Situation de la contrepartie mobilisee par secteur d'activite </p>
        <div class='divscrolable'>
            <table class="styled-table">
                <tr>
                <th >Secteur d'activité</th>
                   @foreach($contrepartie_par_secteur_dactivites as $contrepartie_par_secteur_dactivite)
                       <td>{{ $contrepartie_par_secteur_dactivite->secteur }}</td> 
                   @endforeach
                </tr>
                <tr>
                <tr>
                    <th>Total contrepartie</th>
                    @foreach($contrepartie_par_secteur_dactivites as $contrepartie_par_secteur_dactivite)
                       <td style="text-align:right">{{ format_prix($contrepartie_par_secteur_dactivite->montant) }}</td> 
                   @endforeach
                </tr>
            </table>
        </div>
</div>
</div>
<hr>
    
    
</div>
@endsection
@section('script_add')
<script>
    function change_view(class_cache1, class_cache2, class_cache3,class_cache4,class_affiche){
        $("."+class_cache1).hide();
        $("."+class_cache2).hide();
        $("."+class_cache3).hide();
        $("."+class_cache4).hide();
        $("."+class_affiche).show();

    }
</script>
@endsection
