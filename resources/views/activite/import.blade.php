@extends('layouts.admin')
@section('administration', 'active')
@section('administration-parametre', 'active')
@section('content')
<div class=" col-xs-10 block-content ">
    <div class="block full">
            <!-- Block Tabs Title -->
            <div class="block-title">
                <h2><strong>Importer</strong> Les activités</h2>
                <a href={{ asset('/img/import_activite.xlsx') }} class="btn btn-success pull-right"><span><i class="fa fa-plus"></i></span> Télécharger le fichier type</a>

            </div>
        <div class="tab-content" >
        <h3>Importer</h3>

        <p>Sélectionnez un fichier Excel (.xlsx) pour importer les activités.<br><strong>Les colonnes : </strong>activite, montant_budgetise, montant_depense, montant_depense_annee_n-2,montant_depense_annee_n-1,montant_depense_annee_n</p>

        <form method="POST" action="{{ route('activite.import_store') }}" enctype="multipart/form-data" >
            @csrf

            <input type="file" name="fichier" >
            <button type="submit" >Importer</button>
        </form> 
        </div>
    </div>
</div>
@endsection      