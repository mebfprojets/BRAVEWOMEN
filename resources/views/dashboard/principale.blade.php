@extends('layouts.principale_dash')
@section('dashboard', 'active')
@section('dashboard_view', 'active')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-lg-4">
            <!-- Widget -->
            <a href="page_ready_article.html" class="widget widget-hover-effect1">
                <div class="widget-simple">
                   
                    <h3 class="widget-content text-right animation-pullDown">
                      Budget de la subvention<br>
                       <hr>
                       <center><strong>{{ format_prix(return_info_enveloppe()[0])}} FCFA</strong></center>
                    </h3>
                </div>
            </a>
            <!-- END Widget -->
        </div>
        <div class="col-sm-6 col-lg-4">
            <!-- Widget -->
            <a href="page_comp_charts.html" class="widget widget-hover-effect1">
                <div class="widget-simple">
                   
                    <h3 class="widget-content text-right animation-pullDown">
                        Montant de la subvention accordé<br>
                        <hr>
                        <center><strong>{{ format_prix(return_info_enveloppe()[1])}} FCFA</strong></center>
                     </h3>
                </div>
            </a>
            <!-- END Widget -->
        </div>
        <div class="col-sm-6 col-lg-4">
            <!-- Widget -->
            <a href="page_ready_inbox.html" class="widget widget-hover-effect1">
                <div class="widget-simple">
                    <h3 class="widget-content text-right animation-pullDown">
                        Montant de la subvention restant<br>
                        <hr>
                        <center><strong>{{ format_prix(return_info_enveloppe()[2])}} FCFA</strong></center>
                    </h3>
                </div>
            </a>
            <!-- END Widget -->
        </div>
    </div>
    <hr>
<div class="row">
    <div class="col-md-6" id="indicateur1">
    </div>
    <div class="col-md-6" id="indicateur2">
    </div>
</div>
   
    <div id="map" class="row">
        
    </div>

</div>

@endsection