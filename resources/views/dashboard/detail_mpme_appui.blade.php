@extends('layouts.principale_dash_appui')
@section('dashboard', 'active')
@section($dash_phase, 'active')
@section('content')
<div class="col-md-12 col-md-offset-1 block full" style="margin-left: 10px;">
<div class="row">
    <div class="col-md-6 ">
        <div class="block">
            <!-- Quick Stats Title -->
            <div class="block-title">
                <h2 class="compteur">Total souscriptions enregistrées: {{ $total_mpme_enregistre + $total_aop_leader_enregistres}}  <strong></strong></h2>
            </div>
        <a href="javascript:void(0)" onclick="dashboardaopenregistre('mpme', 'nostatut');" class="widget widget-hover-effect2 themed-background-muted-light">
                <div class="widget-simple">
                    <h4 class="text-left text-danger compteur">
                        <strong >{{ $total_mpme_enregistre }}</strong> </small><br><small> Nombre des souscriptions MPME</small>
                    </h4>
                </div>
            </a>
            
            <a href="javascript:void(0)" onclick="dashboardaopenregistre('aop', 'nostatut');"  class="widget widget-hover-effect2 themed-background-muted-light">
                <div class="widget-simple">
                    <h4 class="text-left text-danger compteur">
                        <strong> {{ $total_aop_leader_enregistres }}</strong> <br><small>Nombre des souscriptions AOP/Entreprise Leader</small>
                    </h4>
                </div>
            </a>
            <a  href="javascript:void(0)" onclick="dashboardaopenregistre('aop', 'rejette');" class="widget widget-hover-effect2 themed-background-muted-light">
                <div class="widget-simple">
                   
                    <h4 class="text-left text-danger compteur">
                        <strong>{{ $total_aop_rejetes }}</strong><br><small>Nombre des AOP/ Entreprise Leader ajournées</small>
                    </h4>
                </div>
            </a>
            <a href="javascript:void(0)" onclick="dashboardaopenregistre('mpme', 'rejette');" class="widget widget-hover-effect2 themed-background-muted-light">
                <div class="widget-simple">
                    
                    <h4 class="text-left text-danger compteur">
                        <strong>{{ $total_mpme_rejetes }}</strong><br><small>Nombre des MPME ajournées</small>
                    </h4>
                </div>
            </a>
            <!-- END Quick Stats Content -->
        </div>   
    </div>
    <div class="col-md-6">
        <div class="block">
            <div class="block-title">
                <h2 class="compteur"> Total des préselections : {{ $total_mpme_aformation + $entreprisesLeaderAOP_aformer}}  <strong></strong></h2>
            </div>
            
        <a onclick="entreprise_aformer('mpme',0);" href="javascript:void(0)" class="widget widget-hover-effect2 themed-background-muted-light">
                <div class="widget-simple">
                    
                    <h4 class="text-left text-danger compteur">
                        <strong>{{ $total_mpme_aformation }}</strong><br><small> Nombre des MPME préseletionnées </small>
                    </h4>
                </div>
            </a>
           
            <a  onclick="entreprise_aformer('aop', 0);" href="javascript:void(0)" class="widget widget-hover-effect2 themed-background-muted-light">
                <div class="widget-simple">
                   
                    <h4 class="text-left text-danger compteur">
                        <strong>{{ $entreprisesLeaderAOP_aformer }}</strong><br><small> Nombre des AOP/Entreprise leader préseletionnées  </small>
                    </h4>
                </div>
            </a>
            <a  onclick="entreprise_aformer('mpme',1);" href="javascript:void(0)" class="widget widget-hover-effect2 themed-background-muted-light">
                <div class="widget-simple">
                    {{-- <div class="widget-icon pull-right themed-background-muted">
                        <i class="fa fa-ticket"></i>
                    </div> --}}
                    <h4 class="text-left text-danger compteur">
                        <strong>{{ $total_mpme_formes }}</strong><br><small> Nombre des MPME Formées</small>
                    </h4>
                </div>
            </a>
            <a onclick="entreprise_aformer('aop',1);" href="javascript:void(0)" class="widget widget-hover-effect2 themed-background-muted-light">
                <div class="widget-simple">
                   
                    <h4 class="text-left text-danger compteur">
                        <strong>{{ $total_aopleader_formes }}</strong><br><small>Nombre des AOP/Entreprise leader Formées</small>
                    </h4>
                </div>
            </a>
  
        </div>   
    </div>
    
</div>
           
    <hr>
    <div class="row">
        <div class="col-md-6" id="indicateur1">

        </div>
        <div class="col-md-6" id="indicateur2">

        </div>
    </div>
    
</div>
@endsection