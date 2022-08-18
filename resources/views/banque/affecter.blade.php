@extends('layouts.admin')
@section('administration', 'active')
@section('administration-banque', 'active')
@section('content')
<div class="col-md-6" id="decocherbeneficiaire">
    <!-- Basic Form Elements Title -->

            <!-- Form Validation Example Block -->
            <div class="block">
                <!-- Form Validation Example Title -->
                <div class="block-title">
                    <h2>Liste <strong> des bénéficiaires affiliés à la {{ $banque->nom }}</strong></h2>
                    <input type="hidden" id="banque" value="{{ $banque->id }}">
                    <a   onclick="history.back()" style="margin-left: 10px;" class="btn btn-danger pull-right">Fermer</a>
                        <a  onclick="desaffilier_un_beneficiaire_ala_banque();" class="btn btn-success pull-right"><span></i></span>Enlever de la liste</a>
                </div>
<div class="table-responsive">
<table class="table table-vcenter table-condensed table-bordered listepdf">
    <thead>
            <tr>
                <th>Selectionner</th>
                <th>Denomination</th>
                <th>code_promoteur</th>
                <th>telephone_promoteur</th>
            </tr>
    </thead>
    <tbody>
        @foreach($entreprises_affectee_ala_banque as $entreprise)
            <tr>
                <td>
                    <input type="hidden" id="banque" value="{{ $banque->id }}">
                    <input type="checkbox" name="" id="{{ $entreprise->id }}" value="{{ $entreprise->id }}">
                </td>
                <td>{{$entreprise->denomination}}</td>
                <td>{{$entreprise->promotrice->code_promoteur}}</td>
                <td>{{$entreprise->promotrice->telephone_promoteur}}</td>
            </tr>
        @endforeach
    </tbody>
    </table>
    </div>
</div>
</div>
<div class="col-md-6" id="listebeneficiaire">
    <div class="block">
        <!-- Form Validation Example Title -->
        <div class="block-title">
            <a  onclick="affilier_un_beneficiaire_ala_banque();" class="btn btn-success pull-right" style="margin-left: 10px"><span></i></span>Affilier</a>
            {{-- <a href="#modal-confirm-presence" data-toggle="modal" onclick="present();" class="btn btn-success pull-right" ><span></i></span>Valider la présence</a> --}}
            <h2> Liste des bénéficiaires non affiliés à une banque <strong></strong></h2>
        </div>
<div class="table-responsive">
    <table class="table table-vcenter table-condensed table-bordered listepdf">
    <thead>
        <tr>
            <th>Cocher</th>
            <th>Denomination</th>
            <th>code_promoteur</th>
            <th>telephone_promoteur</th>
        </tr>
</thead>
<tbody>
@foreach($beneficiaire_non_affectees as $beneficiaire_non_affectee)
    <tr>
        <td>
            <input type="checkbox" name="" id="{{ $beneficiaire_non_affectee->id }}" value="{{ $beneficiaire_non_affectee->id }}">
        </td>
        <td>{{$beneficiaire_non_affectee->denomination}}</td>
        <td>{{$beneficiaire_non_affectee->promotrice->code_promoteur}}</td>
        <td>{{$beneficiaire_non_affectee->promotrice->telephone_promoteur}}</td>
    </tr>
@endforeach
    </tbody>
</table>
</div>
</div>
</div>


@endsection
