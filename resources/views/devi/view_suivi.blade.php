@extends('layouts.admin')
@section('finacement', 'active')
@section('suivi_devis', 'active')
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <!-- Form Validation Example Block -->
        <div class="block">
            <!-- Form Validation Example Title -->
            <div class="block-title">
                <h2><strong>Visualiser les informations sur le suivi</strong></h2>
            </div>
            <div class="row" >
                <div class="col-md-4">
                    <p>Date du suivi :</p>
                </div>
                <div class="col-md-8">
                    <p>{{ format_date($suiviExecutionDevi->date_visite) }}</p>
                </div>
                <div class="col-md-4">
                    <p>Taux de réalisation:</p>
                </div>
                <div class="col-md-8">
                    <p>{{ $suiviExecutionDevi->taux_de_realisation }}</p>
                </div>
                <div class="col-md-4">
                    <p>Observations:</p>
                </div>
                <div class="col-md-8">
                    <p>{{ $suiviExecutionDevi->observation_type }}  {{  $suiviExecutionDevi->observation }} </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="block">
        <!-- Form Validation Example Title -->
        <div class="block-title">
            <h2> Visualiser <strong>les images du suivi</strong></h2>
        </div>
            <div class="row" >
                @foreach ($suiviExecutionDevi->images_de_suivis as $image_de_suivi )
                    <div class="col-md-4">  
                        <img class="cadre_image" src= "{{ Storage::disk('local')->url($image_de_suivi->url_image) }}" alt="">
                    </div>
                @endforeach
            </div>
   
    </div>
        <a href="{{ route('devis.listerASuivre') }}" class="btn btn-danger pull-right" style="float: right;"><span><i class="fa fa-times"></i></span> Fermer la page</a>
</div>
@endsection

@section('script_additionnel')
<script>
   
    </script>
@endsection


