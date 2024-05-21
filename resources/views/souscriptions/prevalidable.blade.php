@extends('layouts.admin')
@section('souscription', 'active')
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
                    <th class="text-center">Phase de souscription</th>
                    <th class="text-center">Type d'entreprise</th>
                    <th class="text-center" style="width:10px;" >Code promoteur</th>
                    <th class="text-center">Region</th>
                    <th class="text-center">Province</th>
                    <th class="text-center">Commune</th>
                    <th class="text-center">Secteur</th>
                    <th class="text-center">Nom & Prenom</th>
                    <th class="text-center">Télephone</th>
                    <th class="text-center">Entreprise</th>
                    <th class="text-center">Score</th>
                    <th class="text-center">Avis de l'UGP</th>
                    <th class="text-center">Commentaire de l'UGP</th>
                    <th class="text-center">Actions</th>
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
                         <td class="text-center" style="width: 2%">{{ $i }}</td>
                         <td class="text-center" style="width: 10%">
                            @if ( $entreprise->phase_de_souscription ==2 )
                                Phase 2
                            @else
                                Phase 1
                            @endif
                        </td>
                        <td class="text-center" style="width: 10%">
                            @if ($entreprise->aopOuleader =="aop" )
                                AOP
                            @elseif($entreprise->aopOuleader =="leader")
                                Entreprise leader
                            @else
                             MPME
                            @endif
                        </td>
                        <td class="text-center" style="width: 5%;" >
                            {{ $entreprise->promotrice->code_promoteur }}
                        </td>
                        <td class="text-center" style="width: 5%;" >
                            {{ getlibelle($entreprise->region) }}
                        </td><td class="text-center" style="width: 5%;" >
                            {{ getlibelle($entreprise->province) }}
                        </td><td class="text-center" style="width: 5%;" >
                            {{ getlibelle($entreprise->commune) }}
                        </td>
                        </td><td class="text-center" style="width: 5%;" >
                            {{ getlibelle($entreprise->arrondissement) }}
                        </td>
                        <td class="text-center" style="width: 5%;">{{ $entreprise->promotrice->nom }} {{ $entreprise->promotrice->prenom }}</td>
                        <td class="text-center" style="width: 5%;">{{ $entreprise->promotrice->telephone_promoteur }}</td>
                        <td class="text-center" style="width: 5%;">
                           {{ $entreprise->denomination }}
                        </td>
                        <td class="text-center" style="width: 5%;">
                            {{ $entreprise->noteTotale  + $entreprise->note_critere_qualitatif}} 
                        </td>
                        <td class="text-center">{{ $entreprise->decision_ugp }}</td>
                        <td class="text-center">{{ $entreprise->observation_ugp }}</td>
                         
                        <td class="text-center" style="width: 7%;">
                            <div class="btn-group">
                                {{-- <a href="" data-toggle="tooltip" title="Editer" class="btn btn-md btn-default"><i class="fa fa-pencil"></i></a> --}}
                                <a href="{{ route("entreprise.show",$entreprise) }}" data-toggle="tooltip" title="Visualiser" class="btn btn-md btn-primary"><i class="fa fa-eye"></i></a>
                                {{-- <a href="{{ route("entreprise.show",$entreprise) }}" data-toggle="tooltip" title="Générer en Excel" class="btn btn-md btn-primary"><i class="fa fa-eye"></i></a> --}}

                                @if(Auth::user()->zone== $entreprise->region)
                                    <a href="{{ route("generer.recepisse", $entreprise->promotrice->slug) }}" data-toggle="tooltip" title="Imprimer le recepissé" class="btn btn-md btn-default"><i class="fa fa-print"></i></a>
                                    <a href="#modal-confirm-send_synthese" onclick="delConfirm({{ $entreprise->id }});" data-toggle="modal" title="Envoyer la fiche de synthèse" class="btn btn-md btn-primary"><i class="fa fa-paper-plane"></i></a>
                                     @can('entreprise.geolocalise', Auth::user()) 
                                        <a href="#" class=" btn btn-md btn-default text-center" onclick="localiser({{ $entreprise->id }});"><i class="fa fa-map-marker"></i></a>
                                     @endcan
                                @endif
                                {{-- <a href="" data-toggle="tooltip" title="Imprimer" class="btn btn-md btn-default"><i class="fa fa-print"></i></a> --}}
                                {{-- @can('souscription.statuerSurSouscription', Auth::user())
                                    <a href="#modal-confirm-rejet" data-toggle="modal" onclick="confirmChangeStatus1({{$entreprise->id}}, {{ Auth::user()->id }})" title="rejeter" class="btn btn-md btn-danger"><i class="fa fa-times"></i></a>
                                    <a href="#modal-confirm-changestatus" data-toggle="modal" onclick="confirmChangeStatus1({{$entreprise->id}}, {{ Auth::user()->id }})" title="Valider" class="btn btn-md btn-success"><i class="fa fa-check"></i></a>
                                @endcan --}}
                                    {{-- <a href="#modal-decision-de-ugp" data-toggle="modal" onclick="confirmChangeStatus1({{$entreprise->id}})" title="La décision de l'ugp" class="btn btn-md btn-danger"><i class="fa fa-check"></i></a>   --}}

                                @if(proportionpromoteur_enregistre($entreprise->promotrice->id)==1 && Auth::user()->zone== $entreprise->region)
                                    <a href="{{ route("promotrice.completeinfo", $entreprise) }}" data-toggle="tooltip" title="Completer les informations" class="btn btn-md btn-default"><i class="fa fa-info"></i></a>
                                @endif
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
    function confirmChangeStatus1(id_entreprise, id_user){
            document.getElementById("id_entreprise").setAttribute("value", id_entreprise);
            document.getElementById("id_user").setAttribute("value", id_user);
    }
    function validerdossier(){
        $(function(){
            var id_entreprise= $("#id_entreprise").val();
            var id_user= $("#id_user").val();
            var url = "{{ route('entreprise.statuermembrecomite') }}";
            $.ajax({
                url: url,
                type:'GET',
                data: {id_entreprise: id_entreprise, id_user : id_user} ,
                error:function(){alert('error');},
                success:function(){
                    $('#modal-confirm-changestatus').hide();
                    location.reload();
                }
            });
            });
    }
    function rejeterdossier(){
        $(function(){
            var id_entreprise= $("#id_entreprise").val();
            var id_user= $("#id_user").val();
            var raison= $("#raison_du_rejet").val();
            var url = "{{ route('entreprise.statuermembrecomite') }}";
            $.ajax({
                url: url,
                type:'GET',
                data: {id_entreprise: id_entreprise, id_user : id_user, raison:raison} ,
                error:function(){alert('error');},
                success:function(){
                    $('#modal-confirm-rejet').hide();
                    location.reload();
                }
            });
            });
    }

    </script>

