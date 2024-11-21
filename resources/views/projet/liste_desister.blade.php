@extends('layouts.admin')
@section('pca', 'active')
@section($type_entreprise, 'active')
@section($page, 'active')
@section('content')
<div class="block full">
    <div class="block-title">
        <h2><strong>Liste</strong> des projets {{ $texte }}</h2>
        
    </div>
    <div class="row">
    </div>
    <div class="table-responsive">
        <table id="listepdf" class="table table-vcenter table-condensed table-bordered listepdf">
            <thead>
                <tr>
                    <th class="text-center">Numero</th>
                    <th class="text-center">Cohore</th>
                    <th class="text-center">Code promoteur</th>
                    <th class="text-center">Zone</th>
                    <th class="text-center">Nom du promoteur</th>
                    <th class="text-center">Denomination de l'entreprise</th>
                    <th class="text-center">Titre du projet</th>
                    <th class="text-center">Cout total</th>
                    <th class="text-center">Apport Personnel</th>
                    <th class="text-center">Demande de financement</th>
                    <th class="text-center">Score</th>
                    <th class="text-center">Statut</th>
                    <th class="text-center">Commentaire</th>
                    <th class="text-center">Contacts</th>
                    <th class="text-center">Banque partenaire</th>
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
                    <tr

                    @if ($projet->statut=='analyse'&& $projet->avis_chefdezone ==null)
                            style="color:orange;"
                    @elseif($projet->statut=='a_affecter_au_membre_du_comite'&& $projet->avis_ugp ==null)
                        style="color:orange;"
                    @elseif($projet->statut=='soumis'&& $projet->motif_du_rejet_de_lanalyse !=null)
                        style="color:red;"
                    @endif>
                        <td class="text-center" style="width: 10%">{{ $i }}</td>
                        <td class="text-center">
                            @if($projet->entreprise->phase_de_souscription!=2) 
                                Cohorte 1
                            @else
                                Cohorte 2
                            @endif
                        </td>
                        <td class="text-center">{{$projet->entreprise->promotrice->code_promoteur}} </td>
                        <td class="text-center">{{ getlibelle($projet->entreprise->region) }} {{ getlibelle($projet->entreprise->province) }} {{ getlibelle($projet->entreprise->commune) }} </td>
                        
                        <td class="text-center">{{$projet->entreprise->promotrice->nom}} {{$projet->entreprise->promotrice->prenom}}</td>
                        <td class="text-center">
                            <a href="{{ route('entreprise.show', $projet->entreprise) }}" target="_blank">{{ $projet->entreprise->denomination }} </a></td>
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
                        <td class="text-center">{{ $projet->observations}}</td>
                        <td class="text-center">{{ $projet->entreprise->promotrice->telephone_promoteur}} / {{$projet->entreprise->telephone_entreprise}}</td>
                        <td class="text-center">{{ $projet->entreprise->banque->nom}}</td>

                        <td class="text-center"> 
                            <div class="btn-group">
                                <a href="{{ route('projet.analyse',$projet) }}" data-toggle="tooltip" title="Analyser" class="btn btn-md btn-success"><i class="fa fa-eye"></i></a>
                        
                            
                           
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
      function recupererentreprise_id(entreprise){
            document.getElementById("id_entreprise").setAttribute("value", entreprise);
            document.getElementById("id_entreprise_2").setAttribute("value", entreprise);
            document.getElementById("id_entreprise_beneficaire").setAttribute("value", entreprise);
            document.getElementById("id_entreprise_demmande_ss_compte").setAttribute("value", entreprise);
            document.getElementById("id_entreprise_creation_ss_compte").setAttribute("value", entreprise);

            

    }
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

