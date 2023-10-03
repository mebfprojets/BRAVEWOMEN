@extends("layouts.espace_beneficiaire")
@section('content_space')
<div class="block">
    <div class="block-title">
        <h2><i class="fa fa-file-o"></i> <strong>Informations sur l'entreprise</strong></h2>
    </div>
<div class="row">
    <div class="col-md-11">
        <div class="col-md-5"><span style="font-weight: bold;">Denomination : </span></div>
        <div class="col-md-7">{{ $entreprise->denomination }}</div>
        <div class="col-md-5"><span style="font-weight: bold;">Secteur d'activite : </span></div>
        <div class="col-md-7">{{ getlibelle($entreprise->secteur_activite) }}</div>
        <div class="col-md-5"><span style="font-weight: bold;">maillon d'activité : </span></div>
        <div class="col-md-7">{{ getlibelle($entreprise->maillon_activite) }}</div>
        @if( $entreprise->formalise==1 )
            <div class="col-md-5"><span class="labdetail" style="font-weight: bold;">Date de formalisation : </span></div>
            <div class="col-md-7">{{ $entreprise->date_de_formalisation  }}</div>
            <div class="col-md-5"><span class="labdetail" style="font-weight: bold;">Références du document : </span></div>
            <div class="col-md-7">{{ $entreprise->num_rccm }}</div>
            <div class="col-md-5"><span class="labdetail" style="font-weight: bold;">Forme juridique : </span></div>
            <div class="col-md-7">{{ getlibelle($entreprise->forme_juridique) }}</div>
        @endif
        <hr>
        <legend style="margin-top:20px; font-weight:bold; ">Adresse l'entreprise</legend>
        <div class="col-md-5"><span class="labdetail" style="font-weight: bold;">Région : </span></div>
        <div class="col-md-7">{{ getlibelle($entreprise->region   ) }}</div>
        <div class="col-md-5"><span class="labdetail" style="font-weight: bold;">Province : </span></div>
        <div class="col-md-7">{{ getlibelle($entreprise->province) }}</div>
        <div class="col-md-5"><span class="labdetail" style="font-weight: bold;">Commune : </span></div>
        <div class="col-md-7">{{ getlibelle($entreprise->commune  ) }}</div>
        <div class="col-md-5"><span class="labdetail" style="font-weight: bold;">Secteur/village : </span></div>
        <div class="col-md-7">{{ getlibelle($entreprise->arrondissement  ) }}</div>
        <div class="col-md-5"><span class="labdetail" style="font-weight: bold;">Email : </span></div>
        <div class="col-md-7">{{ getlibelle($entreprise->email_entreprise  ) }}</div>
    
    <legend style="margin-top:20px; font-weight:bold; ">Activité de l'entreprise</legend>
        <div class="col-md-5"><span class="labdetail" style="font-weight: bold; text-align:justify">Description : </span></div>
        <div class="col-md-7" style="text-align:justify;">{{ $entreprise->description_activite  }}</div>
        <div class="col-md-5"><span class="labdetail" style="font-weight: bold;">Source d'approvisionnement : </span></div>
        <div class="col-md-7">{{ getlibelle($entreprise->source_appro)   }}</div>
        <div class="col-md-5"><span class="labdetail" style="font-weight: bold;">Nature de la clientèle : </span></div>
        <div class="col-md-7">{{ getlibelle($entreprise->nature_client)   }}</div>
    </div>
    <a  href="#modal-user-data" data-toggle="modal" class="btn btn-primary">Modifier mes données</a>
</div>
    
</div>
@endsection