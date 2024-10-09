@extends('layouts.admin')
@section('pca', 'active')
@section($type_entreprise, 'active')
@section('all', 'active')
@section('content')
<div class="block full">
    <div class="block-title">
        <h2><strong>Liste</strong> Plans des projets</h2>
        {{-- <a href="{{ route('valeurs.create') }}" class="btn btn-success pull-right"><span><i class="fa fa-plus"></i></span>valeurs</a> --}}
    </div>
    <div class="row">
    </div>

    <div class="table-responsive">
        <table id="listepdf" class="table table-vcenter table-condensed table-bordered listepdf">
            <thead>
                <tr>
                    <th class="text-center">Numero</th>
                    <th class="text-center">Cohorte</th>
                    <th class="text-center">Region</th>
                    <th class="text-center">Province</th>
                    <th class="text-center">Secteur</th>
                    <th class="text-center">Coach</th>
                    <th class="text-center">Code P</th>
                    <th class="text-center">Denomination de l'entreprise</th>
                    <th class="text-center">Banque partenaires</th>
                    <th class="text-center">Nom & Prenom</th>
                    <th class="text-center">Telephone</th>
                    <th class="text-center">Secteur d'activite</th>
                    <th class="text-center">Titre du projet</th>
                    <th class="text-center">Cout total</th>
                    <th class="text-center">Apport Personnel</th>
                    <th class="text-center" >Demande de financement</th>
                    <th class="text-center">Score</th>
                    <th class="text-center">Statut</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody id="tbadys">
                @php
                  $i=0;
                @endphp
                @foreach ($projets as $projet)
                        @php
                           $i++;
                        @endphp
                    <tr>
                        <td class="text-center" style="width: 10%">{{ $i }}</td>
                        <td class="text-center">
                            @if($projet->entreprise->phase_de_souscription==2)
                                Cohorte 2
                            @else
                             Cohorte 1
                            @endif
                        </td>
                        <td class="text-center">{{ getlibelle($projet->entreprise->region)}}</td>
                        <td class="text-center">{{ getlibelle($projet->entreprise->province)}}</td>
                        <td class="text-center">{{ getlibelle($projet->entreprise->arrondissement)}} </td>
                        <td class="text-center">{{ $projet->coach->nom}} {{ $projet->coach->prenom}}</td>
                        <td class="text-center">{{ $projet->entreprise->promotrice->code_promoteur}}</td>
                        <td class="text-center">
                            <a href="{{ route('entreprise.show', $projet->entreprise) }}" target="_blank">{{ $projet->entreprise->denomination }} </a></td>
                        <td class="text-center">{{ $projet->entreprise->banque->nom}}</td>
                        <td class="text-center">{{ $projet->entreprise->promotrice->nom}} {{ $projet->entreprise->promotrice->prenom}}</td>
                        <td class="text-center">{{ $projet->entreprise->promotrice->telephone_promoteur}} </td>
                        <td class="text-center">{{ getlibelle($projet->entreprise->secteur_activite)}} </td>
                        <td class="text-center">{{ $projet->titre_du_projet }}</td>
                        <td class="text-center">{{ format_prix($projet->investissements->sum('montant')) }}</td>
                        <td class="text-center">{{ format_prix($projet->investissements->sum('apport_perso'))}}</td>
                        <td class="text-center">{{ format_prix($projet->investissements->sum('subvention_demandee'))}}</td>
                        <td class="text-center">
                            @if($projet->evaluations)
                                 {{ $projet->evaluations->sum('note')}}
                             @else
                                 Non evalué
                            @endif
                        </td>
                        <td class="text-center">{{ $projet->statut}}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('projet.show',$projet) }}" data-toggle="tooltip" title="Analyser" class="btn btn-md btn-success"><i class="fa fa-eye"></i></a>
                                
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
    function delConfirm(id){
            //alert(id);
            document.getElementById("id_table").setAttribute("value", id);

    }
    function changelistevale()
         {   var idparent_val = $("#parametre").val();
         var url = '{{ route('valeur.listeval') }}';
             $.ajax({
                     url: url,
                     type: 'GET',
                     data: {idparent_val: idparent_val},
                     dataType: 'json',
                     error:function(data){alert("Erreur");},
                     success: function (data) {


                         var options = '';

                         for (var x = 1; x < data.length; x++) {
                             var rout= '{{ route("valeurs.edit",":id")}}';
                             var rout = rout.replace(':id', data[x]['id']);
                             options +='<tr> <td  width="5%" > ' + x + '</td><td width="20%" > ' + data[x]['libelle'] + '</td><td  width="40%"> ' + data[x]['description'] + '  </td> <td  width="15%"><div class="btn-group"><a  onclick="detailvaleur(' + data[x]['id'] + ' );" href="#modal-voir-detail" data-toggle="modal" title="Voir details" class="btn btn-xs btn-default"><i class="fa fa-eye"></i></a><a href="'+rout+'" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a><a href="#modal-confirm-delete" onclick="delConfirm(' + data[x]['id'] + ');" data-toggle="modal" title="Supprimer" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a></div></td></tr>';
                              }
                        $('#tbadys').html(options);
                     }
             });
         }
    </script>

