@extends("layouts.espace_beneficiaire")
@section('content_space')
<div class="block">
    <div class="block-title">
        <h2><i class="fa fa-file-o"></i> <strong>Informations sur la promotrice</strong></h2>
    </div>
<div class="row">
    <div class="col-md-8">
        <div class="col-md-5"><span style="font-weight: bold;">Code : </span></div>
        <div class="col-md-7">{{ $promotrice->code_promoteur }}</div>
        <div class="col-md-5"><span style="font-weight: bold;">Nom : </span></div>
        <div class="col-md-7">{{ $promotrice->nom }}</div>
        <div class="col-md-5"><span style="font-weight: bold;">Prénom : </span></div>
        <div class="col-md-7">{{ $promotrice->prenom }}</div>
        <div class="col-md-5"><span class="labdetail" style="font-weight: bold;">Date de naissance : </span></div>
        <div class="col-md-7">{{ format_date($promotrice->datenais) }}</div>
        <div class="col-md-5"><span style="font-weight: bold;">Genre : </span></div>
        <div class="col-md-7">
            @if($promotrice->datenais==1)
            Masculin
                @else
                Féminin
            @endif
        </div>
        <div class="col-md-5"><span class="labdetail" style="font-weight: bold;">Téléphone principal : </span></div>
        <div class="col-md-7">{{ $promotrice->telephone_promoteur  }}</div>
        <div class="col-md-5"><span class="labdetail" style="font-weight: bold;">Téléphone secondaire : </span></div>
        <div class="col-md-7">{{ $promotrice->mobile_promoteur   }}</div>
        <div class="col-md-5"><span class="labdetail" style="font-weight: bold;">Email : </span></div>
        <div class="col-md-7">{{ Auth::user()->email }}</div>
        <hr>
        <legend style="margin-top:20px; font-weight:bold; ">Residence du promoteur</legend>
       
        <div class="col-md-5"><span class="labdetail" style="font-weight: bold;">Région : </span></div>
        <div class="col-md-7">{{ getlibelle($promotrice->region_residence   ) }}</div>
        <div class="col-md-5"><span class="labdetail" style="font-weight: bold;">Province : </span></div>
        <div class="col-md-7">{{ getlibelle($promotrice->province_residence   ) }}</div>
        <div class="col-md-5"><span class="labdetail" style="font-weight: bold;">Commune : </span></div>
        <div class="col-md-7">{{ getlibelle($promotrice->commune_residence  ) }}</div>
        <div class="col-md-5"><span class="labdetail" style="font-weight: bold;">Secteur/village : </span></div>
        <div class="col-md-7">{{ getlibelle($promotrice->arrondissement_residence  ) }}</div>
        <div class="col-md-5"><span class="labdetail" style="font-weight: bold;">Situation : </span></div>
        <div class="col-md-7">
            @if($promotrice->situation_residence==1)
            Résident
                @else
            Deplacé
            @endif
        </div>
     
        <legend style="margin-top:20px; font-weight:bold; ">Document d'identite</legend>

        <div class="col-md-5"><span class="labdetail" style="font-weight: bold;">Type : </span></div>
        <div class="col-md-7">
            @if ($promotrice->type_identite==1)
                CNIB
            @else
                Passeport
            @endif
        </div>
        <div class="col-md-5"><span class="labdetail" style="font-weight: bold;">Numéro : </span></div>
        <div class="col-md-7">{{ $promotrice->numero_identite }}</div>
        <div class="col-md-5"><span class="labdetail" style="font-weight: bold;">Date de delivrance : </span></div>
        <div class="col-md-7">{{ format_date($promotrice->date_etabli_identite) }}</div>

        <legend style="margin-top:20px; font-weight:bold; ">Compétence</legend>

        <div class="col-md-5"><span class="labdetail" style="font-weight: bold;">Niveau d'etude : </span></div>
        <div class="col-md-7">{{ getlibelle($promotrice->niveau_instruction) }}</div>
        <div class="col-md-5"><span class="labdetail" style="font-weight: bold;">Expérience : </span></div>
        <div class="col-md-7">{{ $promotrice->nombre_annee_experience  }}</div>
    </div>
    <a  href="#modal-user-data" data-toggle="modal" class="btn btn-primary">Modifier mes données</a>
</div>
    
</div>
@endsection