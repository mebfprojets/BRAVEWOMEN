@extends('layouts.admin')
@section($active_principal, 'active')
@section($active, 'active')
@section('content')
<div class="block full">
    <div class="block-title">
        <h2><strong>Liste</strong> des souscriptions {{ $titre }}</h2>
        @can('user.create', Auth::user())
                            <a href="{{ route('generer.excel') }}" class="btn btn-success pull-right"><span><i class="fa fa-plus"></i></span> Générer en excel</a>
        @endcan
    </div>
    <div class="table-responsive">
        <table id="" class="table table-vcenter table-condensed table-bordered listepdf">
            <thead>
                <tr>
                    <th class="text-center">N°</th>
                    <th class="text-center" style="width:10px;" >Code promoteur</th>
                    <th class="text-center" style="width:10px;" >CNIB</th>
                    <th class="text-center">Région</th>
                    <th class="text-center">Province</th>
                    <th class="text-center">Commune</th>
                    <th class="text-center">Nom & Prénom</th>
                    <th class="text-center">Genre</th>
                    <th class="text-center">Téléphone</th>
                    <th class="text-center">Nom de l'entreprise</th>
                    <th class="text-center">forme juridique</th>
                    <th class="text-center">Secteur d'activité</th>
                    <th class="text-center">Cf.aff.2019</th>
                    <th class="text-center">Cf.aff.2020</th>
                    <th class="text-center">Cf.aff.2021</th>
                    <th class="text-center">Score</th>
                    <th class="text-center">Conformité</th>
                    <th class="text-center">Décision UGP</th>
                    <th class="text-center">Observation UGP</th>
                
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
                    <tr 
                    @if($entreprise->conforme != null && $entreprise->decision_ugp   == null )
                            style="color:orange;"
                    @elseif($entreprise->conforme != null && $entreprise->decision_ugp   != null)
                        style="color:green;"
                        @endif>
                                         <td class="text-center" style="width: 2%">{{ $i }}</td>
                                         <td class="text-center" style="width: 5%;" >
                                            {{ $entreprise->promotrice->code_promoteur }}
                                        </td>
                                        <td class="text-center" style="width: 5%;" >
                                            {{ $entreprise->promotrice->numero_identite }}
                                        </td>
                                         <td class="text-center" style="width: 5%;" >
                                            {{ getlibelle($entreprise->region) }}
                                        </td>
                                        <td class="text-center" style="width: 5%;" >
                                            {{ getlibelle($entreprise->province) }}
                                        </td>
                                        <td class="text-center" style="width: 5%;" >
                                            {{ getlibelle($entreprise->commune) }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">{{ $entreprise->promotrice->nom }} {{ $entreprise->promotrice->prenom }}</td>
                                        <td class="text-center" style="width: 5%;">
                                           @if($entreprise->promotrice->genre==1)
                                                Féminin
                                            @else
                                            Masculin
                                        @endif
                                        </td>
                                        <td class="text-center" style="width: 5%;">{{ $entreprise->promotrice->telephone_promoteur }}</td>
                                        <td class="text-center" style="width: 5%;">
                                            {{-- <a href="{{ route("entreprise.edit", $entreprise) }}"> {{ $entreprise->denomination }} </a> --}}
                                           {{ $entreprise->denomination }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">
                                           {{ getlibelle($entreprise->forme_juridique) }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">
                                            {{ getlibelle($entreprise->secteur_activite) }}
                                        </td>
                                        @foreach ( $entreprise->chiffredaffaires as $chiffredaffaire )
                                        <td class="text-center" style="width: 5%;">
                                            {{ $chiffredaffaire->quantite }}
                                         </td>
                                        @endforeach
                                        <td class="text-center" style="width: 5%;">
                                            {{ $entreprise->noteTotale }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">
                                             @if($entreprise->conforme==1)
                                                Conforme
                                            @elseif ($entreprise->conforme==2)
                                            Non conforme 
                                            @else
                                            Non renseigné
                                            @endif
                                        </td>
                                        <td class="text-center" style="width: 5%;">
                                            {{ $entreprise->decision_ugp }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">
                                            {{ $entreprise->observation_ugp }}
                                        </td>
                                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

<script>
  // ('.avis_ugp').hide();

    function recupererentreprise_id(id_entreprise,conforme){
        
            document.getElementById("id_entreprise").setAttribute("value", id_entreprise);
            document.getElementById("conformite").setAttribute("value", conforme);
    }
    function saveconformite_souscription(){
        $(function(){
            var id_entreprise= $("#id_entreprise").val();
            var conforme= $("#conformite").val();
            var url = "{{ route('souscription.saveconformite') }}";
            $.ajax({
                url: url,
                type:'GET',
                data: {id_entreprise: id_entreprise, conforme : conforme} ,
                error:function(){alert('error');},
                success:function(){
                    $('#modal-confirm-ugp').hide();
                    location.reload();
                    
                }
            });
            });
    }
    function save_avis_ugp(avis){
        var id_entreprise= $("#id_entreprise").val();
        var observation= $("#observation").val();
        var url = "{{ route('souscription.savedecisionugp') }}";
        $.ajax({
                url: url,
                type:'GET',
                data: {id_entreprise: id_entreprise, observation:observation, avis:avis} ,
                error:function(){alert('error');},
                success:function(){
                    $('#modal-decision-de-ugp').hide();
                    location.reload();
                }
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

