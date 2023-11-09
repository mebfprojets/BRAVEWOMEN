@extends('layouts.admin')
@section('pca', 'active')
@section($type_entreprise, 'active')
@section('kyc', 'active')
@section('content')
<div class="block full">
    <div class="block-title">
        <h2><strong>Liste</strong> des demandes de KYC</h2>
    
        @can('enregistrer_kyc',Auth::user())
            <a  href="#modal-import-result_kyc" data-toggle="modal" class="btn btn-success"><span></span>Enregistrer Resultat de KYC</a>
            <a  href="#modal-import-creation-ss-compte" data-toggle="modal" class="btn btn-success"><span></span>Charger les dates de création des sous comptes</a>
        @endcan
    
    </div>
    <div class="row">

    </div>

    <div class="table-responsive">
        <table id="listepdf" class="table table-vcenter table-condensed table-bordered listepdf">
            <thead>
                <tr>
                    <th class="text-center">Numero</th>
                    <th class="text-center">Code Promotrice</th>
                    <th class="text-center">Region</th>
                    <th class="text-center">Promotrice</th>
                    <th class="text-center">Denomination de l'entreprise</th> 
                    <th class="text-center">Titre du projet</th>
                    <th class="text-center" >Date de demande </th>
                    <th class="text-center" >Date de resultat</th>
                    <th class="text-center" >Resultat</th>
                    <th class="text-center" >Date de signature de l'accord bénéficiaire </th>
                    <th class="text-center" >Date de création du sous compte</th>
                    <th class="text-center" >Numéro de sous compte</th>


                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody id="tbadys">
                @php
                  $i=0;
                @endphp
                @foreach ($demande_de_kycs as $demande)
                        @php
                           $i++;
                        @endphp
                    <tr>
                        <td class="text-center" style="width: 10%">{{ $i }}</td>
                        <td class="text-center">{{ $demande->code_promoteur }}</td>
                        <td class="text-center">{{ getlibelle($demande->region) }}</td>
                        <td class="text-center">
                            <a href="{{ route('entreprise.show', $demande) }}" target="_blank">{{ $demande->promotrice->nom }} {{ $demande->promotrice->prenom }}
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('entreprise.show', $demande) }}" target="_blank">{{ $demande->denomination }} 
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('projet.show', $demande->projet) }}" target="_blank">{{ $demande->projet->titre_du_projet }} 
                            </a>
                        </td>
                        <td class="text-center">{{ format_date($demande->date_demande_kyc)}}</td>
                        @if($demande->date_realisation_kyc)
                            <td class="text-center">{{ format_date($demande->date_realisation_kyc) }}</td>
                            <td class="text-center">{{ $demande->resultat_kyc}}</td>
                        @else
                            <td class="text-center">Non disponible</td>
                            <td class="text-center">Non disponible</td>
                        @endif
                        <td class="text-center">
                            @if($demande->date_de_signature_accord_beneficiaire)
                                {{ format_date($demande->date_de_signature_accord_beneficiaire) }}

                            @else
                             Non disponible
                            @endif
                        </td>
                        <td class="text-center">
                            @if($demande->date_de_creation_compte)
                                {{ format_date($demande->date_de_creation_compte) }}
                            @else
                                Non disponible {{ $demande->id }}
                            @endif
                        </td>
                        <td class="text-center">
                            @if($demande->date_de_signature_accord_beneficiaire)
                                {{ $demande->num_ss_compte }}
                            @else
                             Non disponible
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="#" data-toggle="tooltip" title="Analyser" class="btn btn-md btn-success"><i class="fa fa-eye"></i></a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
<div id="modal-import-creation-ss-compte" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Importer les dates de création de sous comptes</h2>
            </div>
            <div class="modal-body">
                <p>Sélectionnez un fichier Excel (.xlsx) pour importer les informations sur la création des sous comptes.<br><strong>Les colonnes : </strong>Code_promotrice, date_demande_de_creation, date_création</p>
                <form method="POST" action="{{ route('importer_date_creation_ss_compte') }}" enctype="multipart/form-data" >
                    @csrf
                    <input type="file" name="fichier" >
                    <button type="submit" >Importer</button>
                </form>   
            </div>
        </div>
    </div>
</div>
<div id="modal-import-result_kyc" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Importer le resultat des KYC</h2>
            </div>
            <div class="modal-body">
                <p>Sélectionnez un fichier Excel (.xlsx) pour importer les resultats des KYC.<br><strong>Les colonnes : </strong>Code_promotrice, date_demande_KYC, date_resultat_KYC, Resultat_KYC</p>
                <form method="POST" action="{{ route('importer_resultat_kyc') }}" enctype="multipart/form-data" >
                    @csrf
                    <input type="file" name="fichier" >
                    <button type="submit" >Importer</button>
                </form>   
            </div>
            <!-- END Modal Body -->
        </div>
    </div>
</div>
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

