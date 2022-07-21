@extends('layouts.admin')
@section($active_principal, 'active')
@section($active, 'active')


@section('content')
<div class="block full">
    <div class="block-title">
        <h2><strong>Liste</strong> des souscriptions {{ $titre }}</h2>
    </div>

    <div class="table-responsive">
        <table id="" class="table table-vcenter table-condensed table-bordered listepdf">
            <thead>
                <tr>
                    <th class="text-center">N°</th>
                    <th class="text-center">Région</th>
                    <th class="text-center" style="width:10px;" >Code promoteur</th>
                    <th class="text-center">Entreprise</th>
                    <th class="text-center">sct activite</th>
                    <th class="text-center">mll activite</th>
                    <th class="text-center" style="width:5%">nbre d'année existence(an)</th>
                    <th class="text-center">Télephone</th>
                    <th class="text-center" style="width:15%">   Actions</th>
                   
                </tr>
            </thead>
            <tbody>
                @php
                  $i=0;
                @endphp
                @foreach ($entreprises as $entreprise)
                        @php
                           $i++;
                        @endphp
                    <tr>
                         <td class="text-center" style="width: 10%">{{ $i }}</td>
                         <td class="text-center">
                            {{-- <a href="{{ route("entreprise.edit", $entreprise) }}"> {{ $entreprise->denomination }} </a> --}}
                           {{ getlibelle($entreprise->region) }}
                        </td>
                        <td class="text-center" style="width: 5%;" >
                            {{ $entreprise->promotrice->code_promoteur }}
                        </td>
                        <td class="text-center"> <strong>{{ $entreprise->denomination }}</strong> </td>
                        <td class="text-center"> {{ getlibelle($entreprise->secteur_activite) }}</td>
                        <td class="text-center"> {{ getlibelle($entreprise->maillon_activite) }}</td>
                        <td class="text-center"> {{ $entreprise->nombre_annee_existence }}</td>
                        <td class="text-center">{{ $entreprise->promotrice->telephone_promoteur }}</td>
                       
                        {{-- <td class="text-center">{{ $entreprise->secteur_activite }}</td> --}}
                        {{-- <td class="text-center">
                            <a href="{{ route("projet.edit",$entreprise->projet->id) }}">Detail sur le projet</a>
                        </td> --}}
                        <td class="text-center">
                            <div class="btn-group">
                                {{-- <a href="" data-toggle="tooltip" title="Editer" class="btn btn-md btn-default"><i class="fa fa-pencil"></i></a> --}}
                                <a href="{{ route("entreprise.show",$entreprise) }}" data-toggle="tooltip" title="Visualiser" class="btn btn-md btn-primary"><i class="fa fa-eye"></i></a>
                               
                                @if(Auth::user()->zone== $entreprise->region)
                                    <a href="{{ route("generer.recepisse", $entreprise->promotrice->slug) }}" data-toggle="tooltip" title="Imprimer le recepissé" class="btn btn-md btn-default"><i class="fa fa-print"></i></a>
                                    <a href="#modal-confirm-send_synthese" onclick="delConfirm({{ $entreprise->id }});" data-toggle="modal" title="Envoyer la fiche de synthèse" class="btn btn-md btn-primary"><i class="fa fa-paper-plane"></i></a>
                                    @can('entreprise.geolocalise', Auth::user())
                                    @if ($entreprise->decision_du_comite_phase1== null and $entreprise->longitude == null)
                                        <a href="#" class="btn btn-md btn-default" onclick="localiser({{ $entreprise->id }});"><i class="fa fa-map-marker"></i></a>
                                    @endif
                                    @endcan
                                @endif
                                {{-- <a href="" data-toggle="tooltip" title="Imprimer" class="btn btn-md btn-default"><i class="fa fa-print"></i></a> --}}
                             
                             @can('souscription.statuerSurSouscription', Auth::user())
                                <a href="#modal-confirm-rejet" data-toggle="modal" onclick="confirmChangeStatus1({{$entreprise->id}}, {{ Auth::user()->id }})" title="Ajournée" class="btn btn-md btn-danger"><i class="fa fa-times"></i></a>
                                <a href="#modal-confirm-changestatus" data-toggle="modal" onclick="confirmChangeStatus1({{$entreprise->id}}, {{ Auth::user()->id }})" title="Selectionnée" class="btn btn-md btn-success"><i class="fa fa-check"></i></a>
                            @endcan
                            <a href="{{ route("promotrice.completeinfo", $entreprise->id) }}" data-toggle="tooltip" title="Completer les informations" class="btn btn-md btn-default"><i class="fa fa-print"></i></a>

                            
                                {{-- Bouttons de validation des membres du comité --}}
                                {{-- <a href="#modal-rejet-comite" data-toggle="modal" onclick="confirmChangeStatus1({{$entreprise->id}}, {{ Auth::user()->id }})" title="Ajournée" class="btn btn-md btn-danger"><i class="fa fa-times"></i></a> --}}
                            
                                {{-- <a  href="#modal-confirm-delete" onclick="delConfirm({{ $parametre->id }});" data-toggle="modal" title="Supprimer" class="btn btn-md btn-danger"><i class="fa fa-times"></i></a> --}}
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
<script>
   

    </script>

