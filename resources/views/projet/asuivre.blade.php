@extends('layouts.admin')
@section('finacement', 'active')
@section($type_entreprise, 'active')
{{-- @section("asuivre", 'active') --}}
@section('content')
<div class="block full">
    <div class="block-title">
        <h2><strong>Liste</strong> des projets A suivre</h2>
        {{-- <a href="{{ route('valeurs.create') }}" class="btn btn-success pull-right"><span><i class="fa fa-plus"></i></span>valeurs</a> --}}
    </div>
    <div class="row">
   
    </div>

    <div class="table-responsive">
        <table id="listepdf" class="table table-vcenter table-condensed table-bordered listepdf">
            <thead>
                <tr>
                    <th class="text-center">Numero</th>
                    <th class="text-center">Code Promoteur</th>
                    <th class="text-center">Zone</th>
                    <th class="text-center">Nom du promoteur</th>
                    <th class="text-center">Denomination de l'entreprise</th>
                    <th class="text-center">Titre du projet</th>
                    <th class="text-center" >Coût total</th>
                    <th class="text-center" >Coût approuvé du projet soumis</th>
                    <th class="text-center" >Financement approuvé</th>
                    <th class="text-center" >Montant total du plan de financement </th>
                    <th class="text-center" >Coût acquisitions validées</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody id="tbadys">
                @php
                  $i=0;
                @endphp
                @foreach ($entreprises_projets_retenus as $entreprise)
                        @php
                           $i++;
                        @endphp
                    <tr>
                        <td class="text-center" style="width: 10%">{{ $i }}</td>
                        <td class="text-center">{{$entreprise->promotrice->code_promoteur}}
                        <td class="text-center">{{ getlibelle($entreprise->region) }} {{ getlibelle($entreprise->province) }} {{ getlibelle($entreprise->commune) }} </td>
                        <td class="text-center">{{$entreprise->promotrice->nom}} {{$entreprise->promotrice->prenom}}</td>
                        <td class="text-center">
                            <a href="{{ route('entreprise.show', $entreprise) }}" target="_blank">{{ $entreprise->denomination }} </a></td>
                        <td class="text-center">{{ $entreprise->projet->titre_du_projet }}</td>
                        <td class="text-center">{{ format_prix($entreprise->projet->investissements->sum('montant')) }}</td>
                        <td class="text-center">{{ format_prix($entreprise->projet->montant_accorde)}}</td>
                        <td class="text-center">{{ format_prix($entreprise->projet->investissements->sum('subvention_demandee_valide'))}}</td>
                        <td class="text-center">{{ format_prix($entreprise->acquisitions->sum('cout_total'))}}</td>
                        <td class="text-center">{{ format_prix($entreprise->acquisitions_valides->sum('cout_total'))}}</td>
                        <td class="text-center">
                            <div class="btn-group">
                            @can('suivre_execution_pca',Auth::user()) 
                                <a href="{{ route('devis_asuivre_par_projet',$entreprise->projet) }}" data-toggle="tooltip" title="Suivre l'exécution des devis" class="btn btn-md btn-success"><i class="fa fa-info-circle"></i></a>
                                <a href="{{ route('acquisition.par_entreprise',$entreprise) }}" data-toggle="tooltip" title="Lister les acquisitions de l'entreprise" class="btn btn-md btn-warning"><i class="hi hi-shopping-cart"></i></a>
                            @endcan
                       
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

