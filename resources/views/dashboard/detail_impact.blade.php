@extends('layouts.principale_dash')
@section('dashboard', 'active')
@section('dashboard_view', 'active')
@section('content')
<div class="row">
    <div class="card card-primary card-outline card-tabs">
      <div class="card-header p-0 pt-1 border-bottom-0">
        <ul class="nav nav-tabs" data-toggle="tabs">
          <li class="nav-item">
            <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Impact Global</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="custom-tabs-three-messages-tab" data-toggle="pill" href="#custom-tabs-three-messages" role="tab" aria-controls="custom-tabs-three-messages" aria-selected="false">Resultats</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">Emplois</a>
          </li>
          
          <li class="nav-item">
            <a class="nav-link" id="custom-tabs-three-settings-tab" data-toggle="pill" href="#custom-tabs-three-settings" role="tab" aria-controls="custom-tabs-three-settings" aria-selected="false">Investissements</a>
          </li>
        </ul>
      </div>
      <div class="card-body">
        <div class="tab-content" id="custom-tabs-three-tabContent">
          <div class="tab-pane active" id="custom-tabs-three-home">
            <div class="tableFixHead">
                <table class="table table-striped table-vcenter">
                        <thead>
                                <tr>
                                    <th style="width: 5%">Numero </th>
                                    <th style="width: 25%">Indicateurs </th>
                                    <th style="width: 15%">Cible </th>
                                    <th style="width: 15%">Valeur </th>
                                    <th style="width: 10%">Taux réalisé</th>
                                    <th style="width: 20%">Commentaires </th>
                                </tr>
                        </thead>
                        <tbody>
                            
                                <tr>
                                    <td>1</td>
                                    <td>{{ $ind_nombre_mpme_forme->libelle }}</td>
                                    <td>{{ $ind_nombre_mpme_forme->cible }}</td>
                                    <td>{{ count($mpme_formes) }}</td>
                                    <td>{{ count($mpme_formes)/ $ind_nombre_mpme_forme->cible *100 }}%</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>{{ $ind_nombre_aop_forme->libelle }}</td>
                                    <td>{{ $ind_nombre_aop_forme->cible }}</td>
                                    <td>{{ count($leader_AOP_formes) }}</td>
                                    <td>{{ count($leader_AOP_formes)/ $ind_nombre_aop_forme->cible *100 }}%</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>{{ $ind_nombre_emploi_cree->libelle }}</td>
                                    <td>{{ $ind_nombre_emploi_cree->cible }}</td>
                                    <td>{{ $nombre_demploi_crees }}</td>
                                    <td>{{ $nombre_demploi_crees/ $ind_nombre_emploi_cree->cible *100 }}%</td>
                                    <td></td>
                                </tr>
                                
                        </tbody>
                </table>
            </div>
          </div>
          <div class="tab-pane" id="custom-tabs-three-profile" >
            <div >
                <p class="entete-block-impact"> Impact sur les emplois</p>
                <div class="row mb-2">
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box bg-danger">
                          <span class="info-box-icon"><i class="far fa-thumbs-up"></i></span>
            
                          <div class="info-box-content">
                            <span class="info-box-text">EMPLOIS DIRECTS CREES</span>
                            <span class="info-box-number">{{$nombre_demploi_temporaire_homme_crees +$nombre_demploi_temporaire_femme_crees + $nombre_demploi_permanent_homme_crees +$nombre_demploi_permanent_femme_crees  }}</span>
            
                            <div class="progress">
                              <div class="progress-bar" style="width: 80%"></div>
                            </div>
                            <span class="progress-description">
                                <span>(</span>{{ $nombre_demploi_permanent_homme_crees +$nombre_demploi_permanent_femme_crees  }}<span>)Permanents - </span> <span>(</span>{{$nombre_demploi_temporaire_homme_crees + $nombre_demploi_temporaire_femme_crees  }}<span>)Temporaires</span>
                            </span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                      </div>
                      <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box bg-warning">
                          <span class="info-box-icon"><i class="far fa-thumbs-up"></i></span>
            
                          <div class="info-box-content">
                            <span class="info-box-text">EMPLOIS DIRECTS CREES HOMMES</span>
                            <span class="info-box-number">{{ $nombre_demploi_temporaire_homme_crees + $nombre_demploi_permanent_homme_crees }}</span>
            
                            <div class="progress">
                              <div class="progress-bar" style="width: 50%"></div>
                            </div>
                            <span class="progress-description">
                                <span>(</span>{{ $nombre_demploi_permanent_homme_crees  }}<span>)Permanents - </span> <span>(</span>{{ $nombre_demploi_temporaire_homme_crees  }}<span>)Temporaires</span>
                            </span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                      </div>
                      <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box bg-success">
                          <span class="info-box-icon"><i class="far fa-thumbs-up"></i></span>
            
                          <div class="info-box-content">
                            <span class="info-box-text">EMPLOIS DIRECTS CREES FEMMMES</span>
                            <span class="info-box-number">{{ $nombre_demploi_temporaire_femme_crees + $nombre_demploi_permanent_femme_crees }}</span>
                            <div class="progress">
                              <div class="progress-bar" style="width: 70%"></div>
                            </div>
                            <span class="progress-description">
                                <span>(</span>{{ $nombre_demploi_permanent_femme_crees  }}<span>)Permanents - </span> <span>(</span>{{ $nombre_demploi_temporaire_femme_crees  }}<span>)Temporaires</span>
                            </span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                      </div>
                      
                </div>
                
                <div class="row">
                    <div class="col-md-7">
                            <div class="card card-outline card-success">
                              <div class="card-header">
                                <h3 class="card-title">Nombre de Bénéficiaires ayant augmenté l'effectif de leur personnel par secteur d'activité</h3>
                
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                              </div>
                              <!-- /.card-header -->
                              <div class="card-body">
                                    <div class="chart" >
                                        <canvas id="beneficiaire_ayant_declare_creation_demploi" class="" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                    </div>
                              </div>
                              
                              <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        
                    </div>
                    
                    <div class="col-md-5">   
                        <div class="card">
                            <div class="card-header border-transparent">
                            <h3 class="card-title"> Situation des emplois soutenus</h3>
                    
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                                </button>
                               
                            </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                            <div class="table-responsive">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                      <a href="#" class="nav-link">
                                        Permanents <span class="float-right badge bg-success">{{ $nombre_demploi_permanent_femme_conserves + $nombre_demploi_permanent_homme_conserves }}</span>
                                      </a>
                                    </li>
                                    
                                    <li class="nav-item">
                                      <a href="#" class="nav-link">
                                        Temporaires<span class="float-right badge bg-success">{{ $nombre_demploi_temporaire_femme_conserves + $nombre_demploi_temporaire_homme_conserves}} </span>
                                      </a>
                                    </li>
                    
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                          Total <span class="float-right badge bg-danger">{{ $nombre_demploi_permanent_femme_conserves + $nombre_demploi_permanent_homme_conserves +  $nombre_demploi_temporaire_femme_conserves + $nombre_demploi_temporaire_homme_conserves }}</span>
                                        </a>
                                    </li>
                                  </ul>
                            </div>
                            <!-- /.table-responsive -->
                            </div>
                            {{-- <!-- /.card-body -->
                            <div class="card-footer clearfix">
                            <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a>
                            <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a>
                            </div>
                            <!-- /.card-footer --> --}}
                        </div>
                        <!-- /.widget-user -->
                      </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-success">
                            <div class="card-header">
                              <h3 class="card-title">Evolution du nombre d'employés par secteur d'activité</h3>
                              <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                  <i class="fas fa-minus"></i>
                                </button>
                               
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;" >
                                <ul>
                                    @foreach ($nombre_demploi_par_secteurdactivites as $nombre_demploi_par_secteurdactivite )
                                        <li style="padding-bottom:5px !important;">
                                            <a href="#">
                                                {{ $nombre_demploi_par_secteurdactivite->secteur_dactivite }}<span  style="width: 70%" class="float-right badge bg-green">Avant {{ format_prix($nombre_demploi_par_secteurdactivite->nombre_avant) }} | Après {{ format_prix($nombre_demploi_par_secteurdactivite->nombre_apres) }} </span>
                                            </a>
                                        </li>
                                    @endforeach
                                    <li>
                                        <a href="#">
                                            Total <span  style="width: 70%" class="float-right badge bg-red">Avant {{ format_prix($nombre_demploi_par_secteurdactivites->sum('nombre_avant')) }} | Après {{ format_prix($nombre_demploi_par_secteurdactivites->sum('nombre_apres')) }} </span>
                                        </a>
                                    </li>
                                </ul>
                              </div>
                            </div>
                          </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-success">
                            <div class="card-header">
                              <h3 class="card-title">Augmentation du nombre d'employés par secteur d'activité</h3>
                              <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                  <i class="fas fa-minus"></i>
                                </button>
                               
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;" >
                                <ul>
                                    @foreach ($nombre_demploi_par_zones as $nombre_demploi_par_zone )
                                        <li style="padding-bottom:5px !important;">
                                            <a href="#">
                                                {{ $nombre_demploi_par_zone->zone }}<span  style="width: 70%" class="float-right badge bg-green">Avant {{ format_prix($nombre_demploi_par_zone->nombre_avant) }} | Après {{ format_prix($nombre_demploi_par_zone->nombre_apres) }} </span>
                                            </a>
                                        </li>
                                    @endforeach
                                    <li>
                                        <a href="#">
                                            Total <span  style="width: 70%" class="float-right badge bg-red">Avant {{ format_prix($nombre_demploi_par_zones->sum('nombre_avant')) }} | Après {{ format_prix($nombre_demploi_par_zones->sum('nombre_apres')) }} </span>
                                        </a>
                                    </li>
                                </ul>
                              </div>
                            </div>
                          </div>
                    </div>
                </div>
                <div class="col-md-12 col-md-offset-1 block full" style="margin-left: 10px;">
                    <div class="row">
                        <div class="form-group col-md-10">
                            <label class="control-label " for="example-chosen">Filtre par Categorie<span class="text-danger">*</span></label>
                                <select id="categorie_entreprise_id" name="categorie_entreprise" class="form-control select-select2"  onchange="emploi_par_secteurdactivite();"   style="width: 100%;" required>
                                    <option></option>
                                    <option value="all" selected>Toute Categorie</option>
                                    <option value="mpme">Categorie MPME</option>
                                    <option value="aopouleader">Categorie AOP/Leader</option>
                                </select>
                        </div> 
                    </div>
                    
                </div>
                <!-- /.card -->
                </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-success">
                        <div class="card-header">
                        <h3 class="card-title"><strong>Nombre d'Emplois directs créés par secteur d'activité</strong></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                            </button>
                            
                        </div>
                        </div>
                        <div class="card-body">
                        <div class="chart">
                            <canvas id="emploi_secteur_dactivite" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                        </div>
                        
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-success">
                        <div class="card-header">
                        <h3 class="card-title"><strong>Nombre d'Emplois directs créés par zone </strong></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                            </button>
                        </div>
                        </div>
                        <div class="card-body">
                        <div class="chart">
                            <canvas id="emploi_zone" class="" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            <div class="row">
                <div class="col-md-11">
                    <div class="card card-success">
                        <div class="card-header">
                        <h3 class="card-title"><strong>Nombre de bénéficiaires dont le Salaire Moyen a evolué par secteur d'activité </strong></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                            </button>
                        </div>
                        </div>
                        <div class="card-body">
                        <div class="chart">
                            <canvas id="graph_salaire_moyen" class="" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                
            </div>
            <div class="row">
                <div class="col-md-11">
                    <div class="card card-success">
                        <div class="card-header">
                        <h3 class="card-title"><strong>Nombre de bénéficiaires dont le Salaire Moyen a evolué par zone </strong></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                            </button>
                        </div>
                        </div>
                        <div class="card-body">
                        <div class="chart">
                            <canvas id="graph_salaire_moyen_zone" class="" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                
            </div>
                
            </div>
        </div>
    <div class="tab-pane" id="custom-tabs-three-messages">
           
    <div class="row">
        <!-- /.col -->
        <div class="col-md-3">
        <a onclick="change_block('block-new-client','block-nombre-produit','block-chiffre-daffaire','block-benefice-net','NCLT','client','graph_secteur_dactivite_client','graph_zone_client')"  href="javascript:void(0)" class="widget widget-hover-effect2">
          <div class="info-box mb-3 shadow">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
              <span class="info-box-text"><Strong> {{ return_taux_des_beneficiaire_ayant_evolue_sur_indicateur('NCLT') }} % </Strong> ont augmenté </span>
              <span class="info-box-text"> leur clientèle</span>
            </div>
          </div>
          <!-- /.info-box -->
    </a>
        </div>
        <div class="col-md-3">
    <a onclick="change_block('block-chiffre-daffaire','block-new-client','block-nombre-produit','block-benefice-net','CA','client','graph_secteur_dactivite_ca','graph_zone_ca')"  href="javascript:void(0)" class="widget widget-hover-effect2">
          <div class="info-box mb-3 shadow">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
            <div class="info-box-content">
              <span class="info-box-text"> <strong>{{ return_taux_des_beneficiaire_ayant_evolue_sur_indicateur('CA') }} %</strong> ont augmenté  </span>
              <span class="info-box-text">leur chiffre d'affaire</span>
            </div>
          </div>
    </a>
        </div>
        <!-- /.col -->
        <div class="col-md-3">
        <a onclick="change_block('block-benefice-net','block-new-client','block-chiffre-daffaire','block-nombre-produit','BENEF','benef','graph_secteur_dactivite_benef','graph_zone_benef')" href="javascript:void(0)" class="widget widget-hover-effect2">
          <div class="info-box mb-3 shadow">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-money"></i></span>
            <div class="info-box-content">
              <span class="info-box-text"><strong>{{ return_taux_des_beneficiaire_ayant_evolue_sur_indicateur('BENEF') }} %</strong> ont augmenté</span>
              <span class="info-box-text">leur Bénéfice Net</span>
            </div>
          </div>
     </a>
          <!-- /.info-box -->
        </div>
        <div class="col-md-3">
            <a onclick="change_block('block-nombre-produit','block-chiffre-daffaire','block-new-client','block-benefice-net','NPDTS','produits','graph_secteur_dactivite_produit','graph_zone_produit')" href="javascript:void(0)" class="widget widget-hover-effect2">
                  <div class="info-box shadow">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-briefcase"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text"><strong>{{ return_taux_des_beneficiaire_ayant_evolue_sur_indicateur('NPDTS') }} %</strong> ont </span>
                      <span class="info-box-text">
                        Nombre de produits/service
                      </span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </a>
            </div>
        
      </div>
<div class="block-nombre-produit" style="display:none;">
    <p class="entete-block-impact">Impact sur l'augmentation du nombre de produit/service</p>
    {{-- <div class="row">
        <div class="form-group col-md-10">
            <label class="control-label " for="example-chosen">Filtre par Categorie<span class="text-danger">*</span></label>
                <select id="client" name="categorie_entreprise" class="form-control client select-select2"  onchange="graphique_suivant_lindicateur('SALM', 'salaire');"   style="width: 100%;" required>
                    <option></option>
                    <option value="all" selected>Toute Categorie</option>
                    <option value="mpme">Categorie MPME</option>
                    <option value="aopouleader">Categorie AOP/Leader</option>
                </select>
        </div>
</div> --}}
    <div class="row">
        <div class="col-md-6">
            <div class="block">
                <div class="block-title">
                    <div class="block-options pull-right">
                        <span class="label label-success"><strong></strong></span>
                    </div>
                    <h2><i class="fa fa-money"></i> <strong>Nombre de Bénéficiaires ayant augmenté leur nombre de produits/services par secteur d'activité</strong>  </h2>
                </div>
        <table class="table table-bordered table-striped table-vcenter ">
                <tr style="background-color: #52836338">
                    <th>Secteur d'activite</th>
                    <th>Valeur</th>
                </tr>
            <tbody class="tbadys_secteur">
                
            </tbody>
        </table>
        </div>
    </div> 
    <div class="col-md-6">
        <div class="block">
            <div class="block-title">
                <div class="block-options pull-right">
                    <span class="label label-success"><strong></strong></span>
                </div>
                <h2><i class="fa fa-money"></i> <strong>Nombre de Bénéficiaires ayant augmenté leur nombre de produits/services par zone</strong>  </h2>
            </div>
    <table class="table table-bordered table-striped table-vcenter ">
    
            <tr style="background-color: #52836338">
                <th>Zone</th>
                <th>Valeurs</th>
            </tr>
        <tbody class="tbadys_zone">
        
        </tbody>
    </table>
    </div>
</div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card card-success">
            <div class="card-header">
              <h3 class="card-title">Augmentation du nombre de services/produits par secteur d'activité</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                
              </div>
            </div>
            <div class="card-body">
              <div class="chart">
                <canvas id="graph_zone_produit"  class="" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
    </div>
    <div class="col-md-6">
        <div class="card card-success">
            <div class="card-header">
              <h3 class="card-title">Augmentation du nombre de services/produits par zone</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                
              </div>
            </div>
            <div class="card-body">
              <div class="chart" >
                <canvas id="graph_secteur_dactivite_produit"   class="" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
            </div>
          </div>
    </div>
</div>
</div>
    
<div class="block-new-client" style="display:none;">
        <p class="entete-block-impact">Impact sur <span></span> l'acces aux nouveaux clients</p> 
    {{-- <div class="row">
        <div class="form-group col-md-10">
            <label class="control-label " for="example-chosen">Filtre par Categorie<span class="text-danger">*</span></label>
                <select id="client" name="categorie_entreprise" class="form-control client select-select2"  onchange="graphique_suivant_lindicateur('NCLT', 'client');"   style="width: 100%;" required>
                    <option></option>
                    <option value="all" selected>Toute Categorie</option>
                    <option value="mpme">Categorie MPME</option>
                    <option value="aopouleader">Categorie AOP/Leader</option>
                </select>
        </div>
</div> --}}
    <div class="row">
        <div class="col-md-6">
            <div class="block">
                <div class="block-title">
                    <div class="block-options pull-right">
                        <span class="label label-success"><strong></strong></span>
                    </div>
                    <h2><i class="fa fa-money"></i> <strong>Nombre de Bénéficiaires ayant augmenté la clientèle par Secteur d'activité</strong>  </h2>
                </div>
        <table class="table table-bordered table-striped table-vcenter ">
                <tr style="background-color: #52836338">
                    <th>Secteur d'activite</th>
                    <th>Valeur</th>
                </tr>
            <tbody class="tbadys_secteur">
                
            </tbody>
        </table>
        </div>
    </div> 
    <div class="col-md-6">
        <div class="block">
            <div class="block-title">
                <div class="block-options pull-right">
                    <span class="label label-success"><strong></strong></span>
                </div>
                <h2><i class="fa fa-money"></i> <strong>Nombre de Bénéficiaires ayant augmenté la clientèle  par zone</strong>  </h2>
            </div>
    <table class="table table-bordered table-striped table-vcenter ">
    
            <tr style="background-color: #52836338">
                <th>Zone</th>
                <th>Valeurs</th>
            </tr>
        <tbody class="tbadys_zone">
        
        </tbody>
    </table>
    </div>
</div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card card-success">
            <div class="card-header">
              <h3 class="card-title">Bénéficiaires ayant connu une augmentation de leur clientèle</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="chart">
                <canvas id="graph_zone_client"  class="" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
    </div>
    <div class="col-md-6">
        <div class="card card-success">
            <div class="card-header">
              <h3 class="card-title">Bénéficiaires ayant connu une augmentation de leur clientèle</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                
              </div>
            </div>
            <div class="card-body">
              <div class="chart" >
                <canvas  id="graph_secteur_dactivite_client"   class="" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
            </div>
          </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card card-success">
            <div class="card-header">
              <h3 class="card-title">Augmentation du nombre de client par secteur d'activité</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
               
              </div>
            </div>
            <div class="card-body">
              <div class="chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;" >
                <ul>
                    @foreach ($nombre_de_client_par_secteurdactivites as $nombre_de_client_par_secteurdactivite )
                        <li style="padding-bottom:5px !important;">
                            <a href="#">
                                {{ $nombre_de_client_par_secteurdactivite->secteur_dactivite }}<span  style="width: 70%" class="float-right badge bg-green">Avant {{ format_prix($nombre_de_client_par_secteurdactivite->nombre_avant) }} | Après {{ format_prix($nombre_de_client_par_secteurdactivite->nombre_apres) }} </span>
                            </a>
                        </li>
                    @endforeach
                    <li>
                        <a href="#">
                            Total <span  style="width: 70%" class="float-right badge bg-red">Avant {{ format_prix($nombre_de_client_par_secteurdactivites->sum('nombre_avant')) }} | Après {{ format_prix($nombre_de_client_par_secteurdactivites->sum('nombre_apres')) }} </span>
                        </a>
                    </li>
                </ul>
              </div>
            </div>
          </div>
    </div>
    <div class="col-md-6">
        <div class="card card-success">
            <div class="card-header">
              <h3 class="card-title">Augmentation du nombre de client par Zone</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
               
              </div>
            </div>
            <div class="card-body">
              <div class="chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;" >
                <table style="width: 100%">
               
                    <ul>
                    @foreach ($nombre_de_client_par_zones as $nombre_de_client_par_zone )
                        <li style="padding-bottom:5px !important;"> <a href="#">
                                 {{ $nombre_de_client_par_zone->zone }} <span  style="width: 70%" class="float-right badge bg-green">Avant  {{ format_prix($nombre_de_client_par_zone->nombre_avant) }}  |  Après  {{ format_prix($nombre_de_client_par_zone->nombre_apres) }}</span>
                            </a> 
                        </li>
                    @endforeach
                    <li>
                        <a href="#">
                            Total <span  style="width: 70%" class="float-right badge bg-red">Avant {{ format_prix($nombre_de_client_par_zones->sum('nombre_avant')) }} | Après {{ format_prix($nombre_de_client_par_zones->sum('nombre_apres')) }} </span>
                        </a>
                    </li>
                    
                    </ul>
                
                </table>
                
                   
              </div>
            </div>
          </div>
    </div>
</div>
</div>
<div class="block-chiffre-daffaire" style="display:none;">
    <p class="entete-block-impact">Impact sur le chiffre d'affaire</p> 
{{-- <div class="row">
    <div class="form-group col-md-10">
        <label class="control-label " for="example-chosen">Filtre par Categorie<span class="text-danger">*</span></label>
            <select id="chiffre" name="categorie_entreprise" class="form-control  select-select2 "  onchange="graphique_suivant_lindicateur('CA','chiffre');"   style="width: 100%;" required>
                <option></option>
                <option value="all" selected>Toute Categorie</option>
                <option value="mpme">Categorie MPME</option>
                <option value="aopouleader">Categorie AOP/Leader</option>
            </select>
    </div> 
</div> --}}
<div class="row">
    <div class="col-md-6">
        <div class="block">
            <div class="block-title">
                <div class="block-options pull-right">
                    <span class="label label-success"><strong></strong></span>
                </div>
                <h2><i class="fa fa-money"></i> <strong>Bénéficiaires ayant augmenté le chiffre d'affaire par Secteur d'activité</strong>  </h2>
            </div>
    <table class="table table-bordered table-striped table-vcenter ">
            <tr style="background-color: #52836338">
                <th>Secteur d'activite</th>
                <th>Nombre</th>
            </tr>
        <tbody class="tbadys_secteur">
            
        </tbody>
    </table>
    </div>
</div> 
<div class="col-md-6">
    <div class="block">
        <div class="block-title">
            <div class="block-options pull-right">
                <span class="label label-success"><strong></strong></span>
            </div>
            <h2><i class="fa fa-money"></i> <strong> Bénéficiaires ayant augmenté le chiffre d'affaire par zone</strong>  </h2>
        </div>
<table class="table table-bordered table-striped table-vcenter ">
   
        <tr style="background-color: #52836338">
            <th>Zone</th>
            <th>Nombre</th>
        </tr>
    <tbody class="tbadys_zone">
       
    </tbody>
</table>
</div>
</div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card card-success">
            <div class="card-header">
              <h3 class="card-title">Bénéficiaires ayant augmenté leur chiffre d'affaire</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="chart">
                <canvas  id="graph_zone_ca"  class="" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
            </div>
          </div>
    </div>
    <div class="col-md-6">
        <div class="card card-success">
            <div class="card-header">
              <h3 class="card-title">Bénéficiaires ayant augmenté leur chiffre d'affaire</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="chart" >
                <canvas id="graph_secteur_dactivite_ca"   class="" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
    </div>
    
</div>

</div>

<div class="block-benefice-net" style="display:none;">
    <p class="entete-block-impact">Impact sur le bénéfice net</p>
{{-- <div class="row"> 
    <div class="form-group col-md-10">
        <label class="control-label " for="example-chosen">Filtre par Categorie<span class="text-danger">*</span></label>
            <select id="benef" name="categorie_entreprise" class="form-control select-select2"  onchange="graphique_suivant_lindicateur('BENEF', 'benef');"   style="width: 100%;" required>
                <option></option>
                <option value="all" selected>Toute Categorie</option>
                <option value="mpme">Categorie MPME</option>
                <option value="aopouleader">Categorie AOP/Leader</option>
            </select>
    </div> 
</div> --}}
<div class="row">
    <div class="col-md-6">
        <div class="block">
            <div class="block-title">
                <div class="block-options pull-right">
                    <span class="label label-success"><strong></strong></span>
                </div>
                <h2><i class="fa fa-money"></i> <strong>Nombre de bénéficiaires ayant augmenté leur bénéfice net par Secteur d'activité</strong>  </h2>
            </div>
    <table class="table table-bordered table-striped table-vcenter ">
            <tr style="background-color: #52836338">
                <th>Secteur d'activite</th>
                <th>Valeur</th>
            </tr>
        <tbody class="tbadys_secteur">
            
        </tbody>
    </table>
    </div>
</div> 
<div class="col-md-6">
    <div class="block">
        <div class="block-title">
            <div class="block-options pull-right">
                <span class="label label-success"><strong></strong></span>
            </div>
            <h2><i class="fa fa-money"></i> <strong>Nombre de bénéficiaires ayant augmenté leur bénéfice net par zone</strong>  </h2>
        </div>
<table class="table table-bordered table-striped table-vcenter ">
        <tr style="background-color: #52836338">
            <th>Zone</th>
            <th>Valeurs</th>
        </tr>
    <tbody class="tbadys_zone">
       
    </tbody>
</table>
</div>
</div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card card-success">
            <div class="card-header">
              <h3 class="card-title">Bénéficiaires ayant augmenté leur bénéfice Net</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="chart">
                <canvas id="graph_zone_benef"  class="" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
    </div>
    <div class="col-md-6">
        <div class="card card-success">
            <div class="card-header">
              <h3 class="card-title">Bénéficaire ayant augmenté leur bénéfice Net</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="chart" >
                <canvas id="graph_secteur_dactivite_benef"    class="" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
    </div>
    
</div>
</div>


          </div>
          <div class="tab-pane" id="custom-tabs-three-settings" role="tabpanel" aria-labelledby="custom-tabs-three-settings-tab">
            <div class="row">
                <div class="col-md-4">
                    <a href="#modal-details-montant_mobilise" data-toggle="modal" class="widget widget-hover-effect2">
                          <div class="info-box shadow">
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-money"></i></span>
                            <div class="info-box-content">
                              <span class="info-box-text"><strong>Montant Suplémentaire Mobilisé </strong>  </span>
                              <span class="info-box-text">
                               <strong> {{ format_prix($total_contrepartie_suplementaire_mobilise) }} Fcfa</strong>
                              </span>
                            </div>
                            <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a onclick="" href="javascript:void(0)" class="widget widget-hover-effect2">
                              <div class="info-box shadow">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-shopping-cart"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">
                                        Montant Total des acquisitions réalisé
                                    </span>
                                  <span class="info-box-text"><strong>{{ format_prix($montant_total_des_aquisitions) }} Fcfa</strong> </span>
                                 
                                </div>
                                <!-- /.info-box-content -->
                              </div>
                              <!-- /.info-box -->
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a onclick="" href="javascript:void(0)" class="widget widget-hover-effect2">
                                  <div class="info-box shadow">
                                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-money"></i></span>
                                    <div class="info-box-content">
                                      <span class="info-box-text"><strong>{{$proportion_de_contrepartie_mobilise}} %</strong> mobilisés </span>
                                      <span class="info-box-text">
                                        par les bénéficiaires
                                      </span>
                                    </div>
                                    <!-- /.info-box-content -->
                                  </div>
                                  <!-- /.info-box -->
                                </a>
                            </div>
                    <hr>
            </div>
            <div class="row">
                <div class="col-md-11">
                    <div class="block">
                        <div class="block-title">
                            <div class="block-options pull-right">
                                <span class="label label-success"><strong></strong></span>
                            </div>
                            <h2><i class="fa fa-money"></i> <strong>Situation des investissments par catégorie </strong>  </h2>
                        </div>
                <table class="table table-bordered table-striped table-vcenter ">
                        <tr style="background-color: #52836338">
                            <th>Catégorie</th>
                            <th>Description</th>
                            <th>Nombre de réalisation</th>
                            <th>Total réalisé</th>
                            <th>Taux</th>
                        </tr>
                    <tbody>
                        @foreach ($acquisistions_valides_par_categories as $acquisistion )
                            <tr>
                                <td>{{ $acquisistion->categorie }}</td>
                                <td>{{ $acquisistion->description }}</td>
                                <td>{{ $acquisistion->nombre }}</td>
                                <td>{{ format_prix($acquisistion->montant) }}</td>
                                <td>{{arrondir_taux($acquisistion->montant/$montant_total_des_aquisitions * 100) }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div> 
            </div>
        </div>
        <div class="row">
            
        </div>
        </div>
      </div>
      <!-- /.card -->
    </div>
  </div>
  








@endsection
@section('modal_part')

@endsection
@section('script_add')
{{-- <script src='{{ asset("js/plugins/jquery/jquery.min.js") }}'></script> --}}
<script src='{{ asset("js/plugins/bootstrap/js/bootstrap.bundle.min.js") }}'></script> 
<script src='{{ asset("js/plugins/chart.js/Chart.js") }}'></script> 
<script src='{{ asset("js/adminlte.js") }}'></script>


    <script>

      function affiche(affiche1,affiche2){
            $("#"+affiche1).show();
            $('#'+affiche2).hide();
        }
   
    </script>
<script>
function change_block(block1,block2,block3,block4,indicateur_graph,cat_entreprise,zone_graph_id,secteur_activite_graph_id){
    $('.'+block1).show();
    $('.'+block2).hide();
    $('.'+block3).hide();
    $('.'+block4).hide();
   
    if(indicateur_graph){
            graphique_suivant_lindicateur(indicateur_graph,cat_entreprise,zone_graph_id,secteur_activite_graph_id)
    }
}
function graphique_salaire_moyen(indicateur,select_concerne){
        var url = "{{ route('impact.donnees_par_secteurdactivite') }}"
        var url2 = "{{ route('impact.donnees_par_zone') }}"
        var categorie= $('#'+select_concerne).val();
        $.ajax({
                     url: url,
                     type: 'GET',
                     dataType: 'json',
                     data: {categorie:categorie, indicateur:indicateur},
                     error:function(data){if (xhr.status == 401) {
                        window.location.href = 'https://www.bravewomen.bf/login';
                    }},
                     success: function (data) {
                        var table_line = '';
                        var donnee= data[0];
                        var donnee1= data[1];
                        var temp0= 0;  
                        var temp1= 0;
                        for (var x = 0; x < donnee.length; x++) {
                            console.log(donnee[x]);
                             var y=  donnee[x].secteur_dactivite; 
                             var nombre=parseInt(donnee[x].nombre);
                             table_line +='<tr> <td > ' + y + '</td><td > ' + nombre + '</td></tr>';
                             }
                       $('.tbadys_secteur').html(table_line); 
                            var donnch= new Array();
                            var donnch1= new Array();
                            var secteurdactivites = new Array();
                            for(var i=0; i<donnee.length; i++)
                                {
                                        donnch.push({
                                            y:  parseInt(donnee[i].nombre)
                                        });
                                }
                                for(var i=0; i<donnee1.length; i++)
                                {
                                        donnch1.push({
                                            y:  parseInt(donnee1[i].nombre)
                                        });
                                }
                       
                        for(var i=0; i<donnee.length; i++)
                            {
                                secteurdactivites[i] = donnee[i].secteur_dactivite
                            }
                        var areaChartData = {
                                    labels  : secteurdactivites,
                                    datasets: [
                                        {
                                        label               : 'ayant evolué',
                                        backgroundColor     : '#3DB75A',
                                        borderColor         : 'rgba(60,141,188,0.8)',
                                        pointRadius          : false,
                                        pointColor          : '#3b8bba',
                                        pointStrokeColor    : 'rgba(60,141,188,1)',
                                        pointHighlightFill  : '#fff',
                                        pointHighlightStroke: 'rgba(60,141,188,1)',
                                        data                : donnch
                                        },
                                        {
                                        label               : "n'ayant pas evolué",
                                        backgroundColor     : '#E13350',
                                        borderColor         : 'rgba(210, 214, 222, 1)',
                                        pointRadius         : false,
                                        pointColor          : 'rgba(210, 214, 222, 1)',
                                        pointStrokeColor    : '#c1c7d1',
                                        pointHighlightFill  : '#fff',
                                        pointHighlightStroke: 'rgba(220,220,220,1)',
                                        data                : donnch1
                                        },
                                    ]
                                    }
                                    
                       var barChartCanvas = $('#graph_salaire_moyen').get(0).getContext('2d')
                            var barChartData = $.extend(true, {}, areaChartData)
                             temp0 = areaChartData.datasets[0]
                             temp1 = areaChartData.datasets[1]
                            barChartData.datasets[0] = temp1
                            barChartData.datasets[1] = temp0
                            var barChartOptions = {
                            responsive              : true,
                            maintainAspectRatio     : false,
                            datasetFill             : false,
                            scales: {
                                    yAxes: [{
                                    ticks: {
                                    beginAtZero: true,
                                    steps: 1,
                                    min:0,
                                    stepValue: 1,
                                    max: 60 //max value for the chart is 60
                                    }
                                }]
                                                        
                            }
                            }
                            new Chart(barChartCanvas, {
                            type: 'bar',
                            data: barChartData,
                            options: barChartOptions
                            })

    }
    
    });
    $.ajax({
                
                     url: url2,
                     type: 'GET',
                     dataType: 'json',
                    data: {categorie:categorie, indicateur:indicateur},
                     error:function(data){if (xhr.status == 401) {
                        window.location.href = 'https://www.bravewomen.bf/login';
                    }},
                     success: function (data) {
                        var donnee= data[0];
                        var donnee1= data[1];
                            var table_line = '';
                        for (var x = 0; x < donnee.length; x++) {
                            console.log(donnee[x]);
                                var y=  donnee[x].zone; 
                                var nombre=parseInt(donnee[x].nombre);
                            table_line +='<tr> <td > ' + y + '</td><td > ' + nombre + '</td></tr>';
                                }
                        $('.tbadys_zone').html(table_line); 
                            var donnch= new Array();
                            var donnch1= new Array();
                            var zones = new Array();
                            for(var i=0; i<donnee.length; i++)
                                {
                                    donnch.push({
                                        name: donnee[i].zone,
                                        y:  parseInt(donnee[i].nombre)
                                    });
                                }
                                for(var i=0; i<donnee1.length; i++)
                                {
                                        donnch1.push({
                                            y:  parseInt(donnee1[i].nombre)
                                        });
                                }
                                console.log('okok')
                                console.log(donnch)
                        for(var i=0; i<donnee.length; i++)
                            {
                                zones[i] = donnee[i].zone
                            }
                        console.log('ici la zone')
                        console.log(zones);
                        var areaChartData = {
                                    labels  : zones,
                                    datasets: [
                                        {
                                        label               : 'ayant evolué',
                                        backgroundColor     : '#3DB75A',
                                        borderColor         : 'rgba(60,141,188,0.8)',
                                        pointRadius          : false,
                                        pointColor          : '#3b8bba',
                                        pointStrokeColor    : 'rgba(60,141,188,1)',
                                        pointHighlightFill  : '#fff',
                                        pointHighlightStroke: 'rgba(60,141,188,1)',
                                        data                : donnch
                                        },
                                        {
                                        label               : "n'ayant pas evolué",
                                        backgroundColor     : '#E13350',
                                        borderColor         : 'rgba(210, 214, 222, 1)',
                                        pointRadius         : false,
                                        pointColor          : 'rgba(210, 214, 222, 1)',
                                        pointStrokeColor    : '#c1c7d1',
                                        pointHighlightFill  : '#fff',
                                        pointHighlightStroke: 'rgba(220,220,220,1)',
                                        data                : donnch1
                                        },
                                    ]
                                    }
                                    
                            var barChartCanvas = $('#graph_salaire_moyen_zone').get(0).getContext('2d')
                            var barChartData = $.extend(true, {}, areaChartData)
                            var temp0 = areaChartData.datasets[0]
                            var temp1 = areaChartData.datasets[1]
                            barChartData.datasets[0] = temp1
                            barChartData.datasets[1] = temp0
                            var barChartOptions = {
                                        responsive              : true,
                                        maintainAspectRatio     : false,
                                        scales: {
                                            yAxes: [{
                                            ticks: {
                                            beginAtZero: true,
                                            steps: 1,
                                            min:0,
                                            stepValue: 1,
                                            max: 60 //max value for the chart is 60
                                            }
                                        }]
                                                        
                                        }
                            
                            }
                            var can= new Chart(barChartCanvas, {
                            type: 'bar',
                            data: barChartData,
                            options: barChartOptions
                            })
                            can.update();
                            var can= new Chart(barChartCanvas, {
                            type: 'bar',
                            data: barChartData,
                            options: barChartOptions
                            })

    }
    
    });
    
}
function graphique_suivant_lindicateur(indicateur,select_concerne,zone_graph_id,secteur_dactivite_graph_id ){
        var url = "{{ route('impact.donnees_par_secteurdactivite') }}"
        var url2 = "{{ route('impact.donnees_par_zone') }}"
        var categorie= $('#'+select_concerne).val();
        $.ajax({
                     url: url,
                     type: 'GET',
                     dataType: 'json',
                     data: {categorie:categorie, indicateur:indicateur},
                     error:function(data){if (xhr.status == 401) {
                        window.location.href = 'https://www.bravewomen.bf/login';
                    }},
                     success: function (data) {
                        var table_line = '';
                        var donnee= data[0];
                        var donnee1= data[1];
                        var temp0= 0;  
                        var temp1= 0;
                        for (var x = 0; x < donnee.length; x++) {
                            console.log(donnee[x]);
                             var y=  donnee[x].secteur_dactivite; 
                             var nombre=parseInt(donnee[x].nombre);
                             table_line +='<tr> <td > ' + y + '</td><td > ' + nombre + '</td></tr>';
                             }
                       $('.tbadys_secteur').html(table_line); 
                            var donnch= new Array();
                            var donnch1= new Array();
                            var secteurdactivites = [];
                            for(var i=0; i<donnee.length; i++)
                                {
                                        donnch.push({
                                            y:  parseInt(donnee[i].nombre)
                                        });
                                }
                                for(var i=0; i<donnee1.length; i++)
                                {
                                        donnch1.push({
                                            y:  parseInt(donnee1[i].nombre)
                                        });
                                }
                       
                        for(var i=0; i<donnee.length; i++)
                            {
                                secteurdactivites[i] = donnee[i].secteur_dactivite
                            }
                        console.log(secteurdactivites);
                        var areaChartData = {
                                    labels  : secteurdactivites,
                                    datasets: [
                                        {
                                        label               : 'ayant evolué',
                                        backgroundColor     : '#3DB75A',
                                        borderColor         : 'rgba(60,141,188,0.8)',
                                        pointRadius          : false,
                                        pointColor          : '#3b8bba',
                                        pointStrokeColor    : 'rgba(60,141,188,1)',
                                        pointHighlightFill  : '#fff',
                                        pointHighlightStroke: 'rgba(60,141,188,1)',
                                        data                : donnch
                                        },
                                        {
                                        label               : "n'ayant pas evolué",
                                        backgroundColor     : '#E13350',
                                        borderColor         : 'rgba(210, 214, 222, 1)',
                                        pointRadius         : false,
                                        pointColor          : 'rgba(210, 214, 222, 1)',
                                        pointStrokeColor    : '#c1c7d1',
                                        pointHighlightFill  : '#fff',
                                        pointHighlightStroke: 'rgba(220,220,220,1)',
                                        data                : donnch1
                                        },
                                    ]
                                    }

                            
                       var barChartCanvas = $('#'+secteur_dactivite_graph_id).get(0).getContext('2d')
                      // var barChartCanvas = $('#graph_secteur_dactivite').get(0).getContext('2d')
                            var barChartData = $.extend(true, {}, areaChartData)
                             temp0 = areaChartData.datasets[0]
                             temp1 = areaChartData.datasets[1]
                            barChartData.datasets[0] = temp1
                            barChartData.datasets[1] = temp0
                            var barChartOptions = {
                            responsive              : true,
                            maintainAspectRatio     : false,
                            scales: {
                                yAxes: [{
                                ticks: {
                                beginAtZero: true,
                                steps: 1,
                                min:0,
                                stepValue: 1,
                                max: 6 //max value for the chart is 60
                                }
                            }]
                                               
                                }
                            }
                            
                         
                            var can= new Chart(barChartCanvas, {
                            type: 'bar',
                            data: barChartData,
                            options: barChartOptions
                            })
                           
    }
    
    });
    $.ajax({
                
                     url: url2,
                     type: 'GET',
                     dataType: 'json',
                    data: {categorie:categorie, indicateur:indicateur},
                     error:function(data){if (xhr.status == 401) {
                        window.location.href = 'https://www.bravewomen.bf/login';
                    }},
                     success: function (data) {
                        var donnee= data[0];
                        var donnee1= data[1];
                            var table_line = '';
                        for (var x = 0; x < donnee.length; x++) {
                            console.log(donnee[x]);
                             var y=  donnee[x].zone; 
                             var nombre=parseInt(donnee[x].nombre);
                            table_line +='<tr> <td > ' + y + '</td><td > ' + nombre + '</td></tr>';
                             }
                       $('.tbadys_zone').html(table_line); 
                            var donnch= new Array();
                            var donnch1= new Array();
                            var zones = new Array();
                            for(var i=0; i<donnee.length; i++)
                                {
                                    donnch.push({
                                        name: donnee[i].zone,
                                        y:  parseInt(donnee[i].nombre)
                                    });
                                }
                                for(var i=0; i<donnee1.length; i++)
                                {
                                        donnch1.push({
                                            y:  parseInt(donnee1[i].nombre)
                                        });
                                }
                                console.log('okok')
                                console.log(donnch)
                        for(var i=0; i<donnee.length; i++)
                            {
                                zones[i] = donnee[i].zone
                            }
                        console.log('ici la zone')
                        console.log(zones);
                        var areaChartData = {
                                    labels  : zones,
                                    datasets: [
                                        {
                                        label               : 'ayant evolué',
                                        backgroundColor     : '#3DB75A',
                                        borderColor         : 'rgba(60,141,188,0.8)',
                                        pointRadius          : false,
                                        pointColor          : '#3b8bba',
                                        pointStrokeColor    : 'rgba(60,141,188,1)',
                                        pointHighlightFill  : '#fff',
                                        pointHighlightStroke: 'rgba(60,141,188,1)',
                                        data                : donnch
                                        },
                                        {
                                        label               : "n'ayant pas evolué",
                                        backgroundColor     : '#E13350',
                                        borderColor         : 'rgba(210, 214, 222, 1)',
                                        pointRadius         : false,
                                        pointColor          : 'rgba(210, 214, 222, 1)',
                                        pointStrokeColor    : '#c1c7d1',
                                        pointHighlightFill  : '#fff',
                                        pointHighlightStroke: 'rgba(220,220,220,1)',
                                        data                : donnch1
                                        },
                                    ]
                                    }
                                    
                            var barChartCanvas = $('#'+zone_graph_id).get(0).getContext('2d')
                           // barChartCanvas.clear();
                           // var barChartCanvas = $('#graph_zone').get(0).getContext('2d')
                            var barChartData = $.extend(true, {}, areaChartData)
                            var temp0 = areaChartData.datasets[0]
                            var temp1 = areaChartData.datasets[1]
                            barChartData.datasets[0] = temp1
                            barChartData.datasets[1] = temp0
                            var barChartOptions = {
                                        responsive              : true,
                                        maintainAspectRatio     : false,
                                        scales: {
                                            yAxes: [{
                                            ticks: {
                                            beginAtZero: true,
                                            steps: 1,
                                            min:0,
                                            stepValue: 1,
                                            max: 6 //max value for the chart is 60
                                            }
                                        }]
                                                        
                                        }
                            
                            }
                           var can= new Chart(barChartCanvas, {
                            type: 'bar',
                            data: barChartData,
                            options: barChartOptions
                            })
                            can.update();
                            var can= new Chart(barChartCanvas, {
                            type: 'bar',
                            data: barChartData,
                            options: barChartOptions
                            })

    }
    
    });
    
} 
function emploi_par_secteurdactivite(){
        var url = "{{ route('impact.emploi_par_secteurdactivite') }}"
        var url2 = "{{ route('impact.emploi_par_zone') }}"
        var categorie= $('#categorie_entreprise_id').val();
        graphique_salaire_moyen('SALM','categorie_entreprise_id');
        $.ajax({
                     url: url,
                     type: 'GET',
                     dataType: 'json',
                    data: {categorie:categorie},
                     error:function(data){if (xhr.status == 401) {
                        window.location.href = 'https://www.bravewomen.bf/login';
                    }},
                     success: function (data) {
                            var emp_permanent= new Array();
                            var emp_temporaire= new Array();
                            var secteurdactivites = new Array();
                            donnee=data[0];
                            donnee1=data[1];
                            for(var i=0; i<donnee.length; i++)
                                {
                                    emp_permanent.push({
                                            y:  parseInt(donnee[i].nombre)
                                        });
                                }
                                for(var i=0; i<donnee1.length; i++)
                                {
                                    emp_temporaire.push({
                                            y:  parseInt(donnee1[i].nombre)
                                        });
                                }
                        
                        for(var i=0; i<donnee.length; i++)
                            {
                                secteurdactivites[i] = donnee[i].secteur_dactivite
                            }
                       // console.log(secteurdactivites);
                        var areaChartData = {
                                    labels  : secteurdactivites,
                                    datasets: [
                                        {
                                        label               : 'Emplois permanents',
                                        backgroundColor     : 'rgba(60,141,188,0.9)',
                                        borderColor         : 'rgba(60,141,188,0.8)',
                                        pointRadius          : false,
                                        pointColor          : '#3b8bba',
                                        pointStrokeColor    : 'rgba(60,141,188,1)',
                                        pointHighlightFill  : '#fff',
                                        pointHighlightStroke: 'rgba(60,141,188,1)',
                                        data                : emp_permanent
                                        },
                                        {
                                        label               : 'Emplois temporaires',
                                        backgroundColor     : 'rgba(210, 214, 222, 1)',
                                        borderColor         : 'rgba(210, 214, 222, 1)',
                                        pointRadius         : false,
                                        pointColor          : 'rgba(210, 214, 222, 1)',
                                        pointStrokeColor    : '#c1c7d1',
                                        pointHighlightFill  : '#fff',
                                        pointHighlightStroke: 'rgba(220,220,220,1)',
                                        data                : emp_temporaire
                                        },
                                    ]
                                    }
                       var barChartCanvas = $('#emploi_secteur_dactivite').get(0).getContext('2d')
                            var barChartData = $.extend(true, {}, areaChartData)
                            var temp0 = areaChartData.datasets[0]
                            var temp1 = areaChartData.datasets[1]
                            barChartData.datasets[0] = temp1
                            barChartData.datasets[1] = temp0
                            var barChartOptions = {
                            responsive              : true,
                            maintainAspectRatio     : false,
                            datasetFill             : false,
                            scales: {
                                            yAxes: [{
                                            ticks: {
                                            beginAtZero: true,
                                            steps: 1,
                                            min:0,
                                            stepValue: 1,
                                            max: 60 //max value for the chart is 60
                                            }
                                        }]
                                                        
                                        }
                            }
                            new Chart(barChartCanvas, {
                            type: 'bar',
                            data: barChartData,
                            options: barChartOptions
                            })
    }
    
    });
            $.ajax({
                             url: url2,
                             type: 'GET',
                             dataType: 'json',
                            data: {categorie:categorie},
                             error:function(data){
                            if (xhr.status == 401) {
                                window.location.href = 'https://www.bravewomen.bf/login';
                            }},
                             success: function (data) {
                                    var emp_permanent= new Array();
                                    var emp_temporaire= new Array();
                                    donnee=data[0];
                                    donnee1=data[1]
                                    var zones = new Array();
                                    for(var i=0; i<donnee.length; i++)
                                        {
                                            emp_permanent.push({
                                                    y:  parseInt(donnee[i].nombre)
                                                });
                                        }
                                console.log(emp_permanent);
                                for(var i=0; i<donnee1.length; i++)
                                        {
                                            emp_temporaire.push({
                                                    y:  parseInt(donnee1[i].nombre)
                                                });
                                        }

                                for(var i=0; i<donnee.length; i++)
                                    {
                                        zones[i] = donnee[i].zone
                                    }
                                
                               console.log('zones')
                                console.log(zones);
                                var areaChartData = {
                                    labels  : zones,
                                    datasets: [
                                        {
                                        label               : 'Emplois permanents',
                                        backgroundColor     : 'rgba(60,141,188,0.9)',
                                        borderColor         : 'rgba(60,141,188,0.8)',
                                        pointRadius          : false,
                                        pointColor          : '#3b8bba',
                                        pointStrokeColor    : 'rgba(60,141,188,1)',
                                        pointHighlightFill  : '#fff',
                                        pointHighlightStroke: 'rgba(60,141,188,1)',
                                        data                : emp_permanent
                                        },
                                        {
                                        label               : 'Emplois temporaires',
                                        backgroundColor     : 'rgba(210, 214, 222, 1)',
                                        borderColor         : 'rgba(210, 214, 222, 1)',
                                        pointRadius         : false,
                                        pointColor          : 'rgba(210, 214, 222, 1)',
                                        pointStrokeColor    : '#c1c7d1',
                                        pointHighlightFill  : '#fff',
                                        pointHighlightStroke: 'rgba(220,220,220,1)',
                                        data                : emp_temporaire
                                        },
                                    ]
                                    }
                                    var areaChartOptions = {
                                            maintainAspectRatio : false,
                                            responsive : true,
                                            legend: {
                                                display: false
                                            },
                                            scales: {
                                                xAxes: [{
                                                gridLines : {
                                                    display : false,
                                                },
                                                barPercentage: 0.1
                                                }],
                                                yAxes: [{
                                                gridLines : {
                                                    display : false,
                                                }
                                                }]
                                            }
                                            }
                       var barChartCanvas = $('#emploi_zone').get(0).getContext('2d')
                            var barChartData = $.extend(true, {}, areaChartData)
                            var temp0 = areaChartData.datasets[0]
                            var temp1 = areaChartData.datasets[1]
                            barChartData.datasets[0] = temp1
                            barChartData.datasets[1] = temp0
                            var barChartOptions = {
                            responsive              : true,
                            maintainAspectRatio     : false,
                            datasetFill             : false,
                            scales: {
                                            yAxes: [{
                                            ticks: {
                                            beginAtZero: true,
                                            steps: 1,
                                            min:0,
                                            stepValue: 1,
                                            max: 60 //max value for the chart is 60
                                            }
                                        }]
                                                        
                                        }
                            }
                            new Chart(barChartCanvas, {
                            type: 'bar',
                            data: barChartData,
                            options: barChartOptions
                            })
                        }
            });
            
    } 
    //beneficiaire_ayant_declare_creation_demploi
    function beneficiaire_ayant_declare_augmente_effectif_par_secteurdactivite(){ 
        var url= "{{ route('impact.baneficaire_ayant_cree_emplois') }}"
        var categorie= $('#categorie_entreprise_id').val();
        $.ajax({
                     url: url,
                     type: 'GET',
                     dataType: 'json',
                    data: {categorie:categorie},
                     error:function(data){if (xhr.status == 401) {
                        window.location.href = 'https://www.bravewomen.bf/login';
                    }},
                     success: function (data) {
                            var benef_ayant_cree= new Array();
                            var benef_nayant_pas_cree= new Array();
                            var secteurdactivites = new Array();
                            donnee=data[0];
                            donnee1=data[1];
                            for(var i=0; i<donnee.length; i++)
                                {
                                    benef_ayant_cree.push({
                                            y:  parseInt(donnee[i].nombre)
                                        });
                                }
                                for(var i=0; i<donnee1.length; i++)
                                {
                                    benef_nayant_pas_cree.push({
                                            y:  parseInt(donnee1[i].nombre)
                                        });
                                }
                        
                        for(var i=0; i<donnee.length; i++)
                            {
                                secteurdactivites[i] = donnee[i].secteur_dactivite
                            }
                            var areaChartData = {
                                    labels  : secteurdactivites,
                                    datasets: [
                                        {
                                        label               : 'Personnel ayant evolué',
                                        backgroundColor     : '#3DB75A',
                                        borderColor         : 'rgba(60,141,188,0.8)',
                                        pointRadius          : false,
                                        pointColor          : '#3b8bba',
                                        pointStrokeColor    : 'rgba(60,141,188,1)',
                                        pointHighlightFill  : '#fff',
                                        pointHighlightStroke: 'rgba(60,141,188,1)',
                                        data                : benef_ayant_cree
                                        },
                                        {
                                        label               : 'Personnel stable',
                                        backgroundColor     : '#E13350',
                                        borderColor         : 'rgba(210, 214, 222, 1)',
                                        pointRadius         : false,
                                        pointColor          : 'rgba(210, 214, 222, 1)',
                                        pointStrokeColor    : '#c1c7d1',
                                        pointHighlightFill  : '#fff',
                                        pointHighlightStroke: 'rgba(220,220,220,1)',
                                        data                : benef_nayant_pas_cree
                                        },
                                       
                                    ]
                                    }
                           var barChartCanvas = $('#beneficiaire_ayant_declare_creation_demploi').get(0).getContext('2d')
                            var barChartData = $.extend(true, {}, areaChartData)
                            var temp0 = areaChartData.datasets[0]
                            var temp1 = areaChartData.datasets[1]
                            barChartData.datasets[0] = temp1
                            barChartData.datasets[1] = temp0
                            var barChartOptions = {
                            responsive              : true,
                            maintainAspectRatio     : false,
                            datasetFill             : false,
                            scales: {
                                            yAxes: [{
                                            ticks: {
                                            beginAtZero: true,
                                            steps: 1,
                                            min:0,
                                            stepValue: 1,
                                            max: 60 //max value for the chart is 60
                                            }
                                        }]               
                                 }
                            }
                            new Chart(barChartCanvas, {
                            type: 'bar',
                            data: barChartData,
                            options: barChartOptions
                            })
    }
    
    });
  
            
    }


$(document).ready(function(){
    emploi_par_secteurdactivite();
    graphique_salaire_moyen('SALM','all');
    beneficiaire_ayant_declare_augmente_effectif_par_secteurdactivite();
    change_block('block-new-client','block-emploi','block-chiffre-daffaire','block-benefice-net','NCLT','client', 'graph_secteur_dactivite_client','graph_zone_client')
});
</script>


<script>
    $(function (){})
</script>
@endsection