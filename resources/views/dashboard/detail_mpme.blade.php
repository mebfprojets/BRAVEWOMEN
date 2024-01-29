@extends('layouts.principale_dash')
@section('dashboard', 'active')
@section('dashboard_view', 'active')
@section('content')
<div class="col-md-12 col-md-offset-1 block full" style="margin-left: 10px;">

<div class="row">
    <div class="col-md-6 ">
        <div class="block">
            <!-- Quick Stats Title -->
            <div class="block-title">
                <h2 class="compteur">  Total souscriptions enregistrées: {{ $total_mpme_enregistre + $total_aop_leader_enregistres}}  <strong></strong></h2>
            </div>
        <a href="javascript:void(0)" onclick="dashboardaopenregistre('mpme', 'nostatut');" class="widget widget-hover-effect2 themed-background-muted-light">
                <div class="widget-simple">
                    <h4 class="text-left text-danger compteur">
                        <strong >{{ $total_mpme_enregistre }}</strong><br><small>Souscriptions Catégorie MPME</small>
                    </h4>
                </div>
            </a>
            
            <a href="javascript:void(0)" onclick="dashboardaopenregistre('aop', 'nostatut');"  class="widget widget-hover-effect2 themed-background-muted-light">
                <div class="widget-simple">
                   
                    <h4 class="text-left text-danger compteur">
                        <strong> {{ $total_aop_leader_enregistres }} </strong><br><small>Souscriptions Catégorie AOP/Entreprise Leader</small>
                    </h4>
                </div>
            </a>
            <a  href="javascript:void(0)" onclick="dashboardaopenregistre('aop', 'rejette');" class="widget widget-hover-effect2 themed-background-muted-light">
                <div class="widget-simple">
                   
                    <h4 class="text-left text-danger compteur">
                        <strong>{{ $total_aop_rejetes }}</strong><br><small>Nombre de AOP/Leader ajournées</small>
                    </h4>
                </div>
            </a>
            <a href="javascript:void(0)" onclick="dashboardaopenregistre('mpme', 'rejette');" class="widget widget-hover-effect2 themed-background-muted-light">
                <div class="widget-simple">
                    
                    <h4 class="text-left text-danger compteur">
                        <strong>{{ $total_mpme_rejetes }}</strong><br><small>Souscriptions ajournées Catégorie MPME </small>
                    </h4>
                </div>
            </a>
            <!-- END Quick Stats Content -->
        </div>   
    </div>
    <div class="col-md-6">
        <div class="block">
            <div class="block-title">
                <h2 class="compteur"> Total entreprise Préselectionnées : {{ $total_mpme_aformation + $entreprisesLeaderAOP_aformer}}  <strong></strong></h2>
            </div>
            
        <a onclick="entreprise_aformer('mpme',0);" href="javascript:void(0)" class="widget widget-hover-effect2 themed-background-muted-light">
                <div class="widget-simple">
                    
                    <h4 class="text-left text-danger compteur">
                        <strong>{{ $total_mpme_aformation }}</strong><br><small> MPME préseletionnées </small>
                    </h4>
                </div>
            </a>
           
            <a  onclick="entreprise_aformer('aop', 0);" href="javascript:void(0)" class="widget widget-hover-effect2 themed-background-muted-light">
                <div class="widget-simple">
                    {{-- <div class="widget-icon pull-right themed-background-danger">
                        <i class="fa fa-heart"></i>
                    </div> --}}
                    <h4 class="text-left text-danger compteur">
                        <strong>{{ $entreprisesLeaderAOP_aformer }}</strong><br><small> AOP/Entreprise leader préseletionnées  </small>
                    </h4>
                </div>
            </a>
            <a  onclick="entreprise_aformer('mpme',1);" href="javascript:void(0)" class="widget widget-hover-effect2 themed-background-muted-light">
                <div class="widget-simple">
                    {{-- <div class="widget-icon pull-right themed-background-muted">
                        <i class="fa fa-ticket"></i>
                    </div> --}}
                    <h4 class="text-left text-danger compteur">
                        <strong>{{ $total_mpme_formes }}</strong><br><small> MPME Formées</small>
                    </h4>
                </div>
            </a>
            <a onclick="entreprise_aformer('aop',1);" href="javascript:void(0)" class="widget widget-hover-effect2 themed-background-muted-light">
                <div class="widget-simple">
                   
                    <h4 class="text-left text-danger compteur">
                        <strong>{{ $total_aopleader_formes }}</strong><br><small>AOP/Entreprise leader Formées</small>
                    </h4>
                </div>
            </a>
  
        </div>   
    </div>
    
</div>
           
    {{-- <div class="row">
        <div class="col-md-6">
            <ul class="nav nav-pills nav-stacked">
            <h1> Total souscriptions enregistrées: {{ $total_mpme_enregistre + $total_aop_leader_enregistres}} </h1>
                <li>
                    <a href="javascript:void(0)" onclick="dashboardaopenregistre('mpme', 'nostatut');">
                        <span class="badge pull-right">{{ $total_mpme_enregistre }}</span>
                        <i class="fa fa-tag fa-fw text-success"></i> <strong>Nombre de souscription MPME</strong>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" onclick="dashboardaopenregistre('aop', 'nostatut');">
                        <span class="badge pull-right">{{ $total_aop_leader_enregistres }}</span>
                        <i class="fa fa-tag fa-fw text-warning"></i> <strong>Nombre de souscriptions Leader/AOP </strong>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" onclick="dashboardaopenregistre('aop', 'rejette');">
                        <span class="badge pull-right">{{ $total_aop_rejetes }}</span>
                        <i class="fa fa-tag fa-fw text-danger"></i> <strong>Nombre de AOP/Leader  ajournées</strong>
                    </a>
                </li>
                
                <li>
                    <a href="javascript:void(0)" onclick="dashboardaopenregistre('mpme', 'rejette');">
                        <span class="badge pull-right">{{ $total_mpme_rejetes }}</span>
                        <i class="fa fa-tag fa-fw text-warning"></i> <strong>Nombre de MPME rejetés à phase formation </strong>
                    </a>
                </li>
            </ul>
            
        </div>

        <div class="col-md-6">
            <ul class="nav nav-pills nav-stacked">
                <h1> Total entreprise Préselectionnées : {{ $total_mpme_aformation + $entreprisesLeaderAOP_aformer}} </h1>
                <li>
                    <a href="javascript:void(0)" onclick="entreprise_aformer('mpme',0);">
                        <span class="badge pull-right">{{ $total_mpme_aformation }}</span>
                        <i class="fa fa-tag fa-fw text-warning"></i> <strong>Nombre de MPME selectionnées pour la  formation</strong>
                    </a>
                </li>
                  <li>
                      <a href="javascript:void(0)" onclick="entreprise_aformer('aop', 0);">
                          <span class="badge pull-right">{{ $entreprisesLeaderAOP_aformer }}</span>
                          <i class="fa fa-tag fa-fw text-danger"></i> <strong>Nombre de Leader/AOP selectionnées pour la  formation</strong>
                      </a>
                  </li>
                  <li>
                    <a href="javascript:void(0)" onclick="entreprise_aformer('mpme',1);">
                        <span class="badge pull-right">{{ $total_mpme_formes }}</span>
                        <i class="fa fa-tag fa-fw text-warning"></i> <strong>Nombre de MPME formées</strong>
                    </a>
                </li>
                  <li>
                      <a href="javascript:void(0)" onclick="entreprise_aformer('aop',1);">
                          <span class="badge pull-right">{{ $total_aopleader_formes }}</span>
                          <i class="fa fa-tag fa-fw text-danger"></i> <strong>Nombre de AOP/Entreprises Leader formées</strong>
                      </a>
                  </li>
                
            </ul>

        </div> 
    </div> --}}
    <hr>
    <div class="row">
        <div class="col-md-6" id="indicateur1">

        </div>
        <div class="col-md-6" id="indicateur2">

        </div>
    </div>
    
</div>
@endsection