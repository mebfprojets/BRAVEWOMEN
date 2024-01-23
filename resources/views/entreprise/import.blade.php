@extends('layouts.admin')
@section('administration', 'active')
@section('administration-parametre', 'active')
@section('content')
<div class=" col-xs-10 block-content ">
    <div class="block full">
            <!-- Block Tabs Title -->
            <div class="block-title">
                <h2><strong>Importer</strong> les données de mise à jour de géolocalisation</h2>
                <a href={{ asset('/img/import_geo.xlsx') }} class="btn btn-success pull-right"><span><i class="fa fa-plus"></i></span> Télécharger le fichier type</a>

            </div>
        <div class="tab-content" >
        <h3>Importer</h3>

        <p>Sélectionnez un fichier Excel (.xlsx) pour importer les données dans la table "clients".<br><strong>Les colonnes : </strong>name, email, phone, address</p>


        <form method="POST" action="{{ route('excel.import') }}" enctype="multipart/form-data" >

            <!-- CSRF Token -->
            @csrf

            <input type="file" name="fichier" >
            <button type="submit" >Importer</button>
        </form> 
        </div>
    </div>
</div>
@endsection      