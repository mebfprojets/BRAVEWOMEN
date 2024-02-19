@extends('layouts.admin')
@section('pca', 'active')
@section($type_entreprise, 'active')
@section($page, 'active')
@section('content')
<div class="block full">
    <div class="block-title">
        <h2><strong>Liste</strong> des projets {{ $texte }} </h2>
    </div>
    <div class="row">
   
    </div>

    <div class="table-responsive">
        <table id="listepdf" class="table table-vcenter table-condensed table-bordered listepdf">
            <thead>
                <tr>
                    <th class="text-center">Numero</th>
                    <th class="text-center">Region</th>
                    <th class="text-center">Province</th>
                    <th class="text-center">Commune</th>
                    <th class="text-center">Secteur</th>
                    <th class="text-center">Code promoteur</th>
                    <th class="text-center">Nom du promoteur</th>
                    <th class="text-center">Contacts</th>
                    <th class="text-center">Denomination de l'entreprise</th>
                    <th class="text-center">Numéro RCCM</th>
                    <th class="text-center">Secteur d'activité</th>
                    <th class="text-center">Titre du projet</th>
                    <th class="text-center">Coût du projet</th>
                    <th class="text-center">Apport Personnel</th>
                    <th class="text-center">Demande de financement</th>
                    <th class="text-center">Coût accordé</th>
                    <th class="text-center">Subvention aprouvée</th>
                    <th class="text-center">Banque partenaire</th>
                    <th class="text-center">Décision du comite</th>
                    <th class="text-center">Observation du comité</th>
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
                        <td class="text-center">{{ getlibelle($projet->entreprise->region) }} </td>
                        <td class="text-center">{{ getlibelle($projet->entreprise->province) }} </td>
                        <td class="text-center"> {{ getlibelle($projet->entreprise->commune) }} </td>
                        <td class="text-center"> {{ getlibelle($projet->entreprise->arrondissement) }}</td>
                        <td class="text-center">{{$projet->entreprise->promotrice->code_promoteur}}</td>
                        <td class="text-center">{{$projet->entreprise->promotrice->nom}} {{$projet->entreprise->promotrice->prenom}}</td>
                        <td class="text-center">{{$projet->entreprise->promotrice->telephone_promoteur}} / {{$projet->entreprise->telephone_entreprise}} </td>
                        <td class="text-center"><a href="{{ route('entreprise.show', $projet->entreprise) }}" target="_blank">{{ $projet->entreprise->denomination }} </a></td>
                        <td class="text-center">{{ $projet->entreprise->num_rccm}}</td> 
                        <td class="text-center">{{ getlibelle($projet->entreprise->secteur_activite)}}</td>
                        <td class="text-center">{{ $projet->titre_du_projet }}</td>
                        <td class="text-center">{{ format_prix($projet->investissements->sum('montant')) }}</td>
                        <td class="text-center">{{ format_prix($projet->investissements->sum('apport_perso'))}}</td>
                        <td class="text-center">{{ format_prix($projet->investissements->sum('subvention_demandee'))}}</td>
                        <td class="text-center">{{ format_prix($projet->montant_accorde)}}</td>
                        <td class="text-center">{{ format_prix($projet->investissements->sum('subvention_demandee_valide'))}}</td>
                        <td class="text-center">{{$projet->entreprise->banque->nom}}</td>
                        <td class="text-center">
                            @if($projet->statut=='selectionné')
                               Selectionné
                           @elseif($projet->statut=='rejeté')
                                Réjeté
                            @endif
                        </td>
                        <td class="text-center">{{ $projet->observations}}</td>
                        <td class="text-center"> 
                            <div class="btn-group">
                                
                                <a href="{{ route('projet.show',$projet) }}" data-toggle="tooltip" title="Afficher les details" class="btn btn-md btn-success"><i class="fa fa-eye"></i></a>
                          @can('enregistrer_kyc',Auth::user())
                            @if ($projet->statut=='selectionné' && $projet->entreprise->date_demande_kyc==null)
                                <a  href="#modal-demande-de-kyc" data-toggle="modal"title="Enregistrer une demande de KYC"  onclick="recupererentreprise_id({{ $projet->entreprise->id }});" class="btn btn-md btn-warning" ><i class="gi gi-direction"></i> </a>
                            @endif
                            @if ($projet->statut=='selectionné' && $projet->entreprise->date_demande_kyc!=null && $projet->entreprise->date_realisation_kyc==null)
                                <a  href="#modal-result-kyc" data-toggle="modal"title="Enregistrer le Resultat de la KYC"  onclick="recupererentreprise_id({{ $projet->entreprise->id }});" class="btn btn-md btn-danger" ><i class="gi gi-bookmark"></i> </a>
                            @endif
                            <a  href="#modal-signature-accord-beneficaire" data-toggle="modal"title="Enregistrer la signature de l'accord bénéficaiaire"  onclick="recupererentreprise_id({{ $projet->entreprise->id }});" class="btn btn-md btn-default" ><i class="fa fa-pencil-square-o"></i> </a>
                            @if ($projet->entreprise->resultat_kyc=='concluant' && $projet->entreprise->date_de_signature_accord_beneficiaire==null)
                                <a  href="#modal-signature-accord-beneficaire" data-toggle="modal"title="Enregistrer la signature de l'accord bénéficaiaire"  onclick="recupererentreprise_id({{ $projet->entreprise->id }});" class="btn btn-md btn-default" ><i class="fa fa-pencil-square-o"></i> </a>
                            @endif
                            @if ($projet->entreprise->date_de_demande_creation_compte==null && $projet->entreprise->date_de_signature_accord_beneficiaire!= null)
                                <a  href="#modal-demande-de-creation-sous-compte" data-toggle="modal"title="Enregistrer la date de demande de création de sous compte"  onclick="recupererentreprise_id({{ $projet->entreprise->id }});" class="btn btn-md btn-default" ><i class="fa fa-pencil-square-o"></i> </a>
                            @endif
                            @if ($projet->entreprise->date_de_demande_creation_compte!=null && $projet->entreprise->date_de_creation_compte== null)
                                <a  href="#modal-creation-sous-compte" data-toggle="modal"title="Enregistrer la date de création de sous compte"  onclick="recupererentreprise_id({{ $projet->entreprise->id }});" class="btn btn-md btn-default" ><i class="fa fa-pencil-square-o"></i> </a>
                            @endif
                            
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
@section('modal_part')

<div id="modal-signature-accord-beneficaire" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Enregistrement de l'accord bénéficiaire</h2>
            </div>
            <div class="modal-body" style="margin-left:15px;">
                <form id="form-validation" method="POST"  action="{{ route('save_accord_beneficiaire') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="entreprise" id="id_entreprise_beneficaires" >
            <div class="row">
                <div class="form-group col-md-6">
                    <label class=" control-label" for="example-chosen">Selectionner la banque<span class="text-success">*</span></label>
                        <select id="coach" name="banque"  value="{{old("banque")}}"  class="form-control" data-placeholder="Selectionner le banque ayant appuyer à l'elaboration du PCA .." style="width: 80%;">
                            <option></option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                            @foreach ($banques as $banque )
                                    <option value="{{ $banque->id  }}" {{ old('banque') == $banque->id ? 'selected' : '' }}>{{ $banque->nom }} </option>
                            @endforeach
                        </select>
                </div>
            <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }} col-md-5">
                <label class=" control-label" for="telephone">Date de signature de l'accord<span class="text-danger">*</span></label>
                <input id="name" type="text"  class="form-control datepicker" data-date-format="dd-mm-yyyy" name="date_de_signature"  placeholder="Entrer la date de signature de l'accord bénéficiaire ..." required autofocus>    
                    @if ($errors->has('date_de_signature'))
                    <span class="help-block">
                        <strong>{{ $errors->first('date_de_signature') }}</strong>
                    </span>
                    @endif
            </div>
            <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }} col-md-8">
                <label class=" control-label" for="accord_beneficiaire">Joindre une copie de l'accord bénéficaire<span class="text-danger">*</span></label>
                <input class="form-control col-md-6" type="file" name="accord_beneficiaire" id="accord_beneficiaire" accept=".pdf, .jpeg, .png" onchange="VerifyUploadSizeIsOK_lourd('accord_beneficiaire');"   placeholder="Joindre une copie de l'accord bénéficiaire" required>  
                    @if ($errors->has('accord_beneficiaire'))
                    <span class="help-block">
                        <strong>{{ $errors->first('accord_beneficiaire') }}</strong>
                    </span>
                    @endif
            </div>
            </div>   
                <div class="form-group form-actions">
                <div class="col-md-8 col-md-offset-4">
                    <a href="#" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
                    <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-arrow-right"></i> Enregistrer</button>
                </div>
            </div>
            </form>
        </div>
            </div>
            <!-- END Modal Body  modal-devis-edit -->
        </div>
    </div>
    <div id="modal-demande-de-creation-sous-compte" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center">
                    <h2 class="modal-title"><i class="fa fa-pencil"></i> Enregistrer la demande de création de sous compte</h2>
                </div>
                <div class="modal-body" style="margin-left:15px;">
                    <form id="form-validation" method="POST"  action="{{ route('save_date_demande_creation_compte') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="entreprise" id="id_entreprise_demmande_ss_compte" value="">
                <div class="row">
               
                <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }} col-md-6">
                    <label class=" control-label" for="telephone">Date de demande de création de sous compte<span class="text-danger">*</span></label>
                    <input id="name" type="text" class="form-control datepicker" data-date-format="dd-mm-yyyy"  name="date_demande_creation_compte"  placeholder="Entrer la date de demande de création de sous compte ..." value="" required autofocus>    
                        @if ($errors->has('date_demande_creation_compte'))
                        <span class="help-block">
                            <strong>{{ $errors->first('date_demande_creation_compte') }}</strong>
                        </span>
                        @endif
                </div>
                </div>   
                    <div class="form-group form-actions">
                    <div class="col-md-8 col-md-offset-4">
                        <a href="#" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-arrow-right"></i> Enregistrer</button>
                    </div>
                </div>
                </form>
            </div>
                </div>
                <!-- END Modal Body  modal-devis-edit -->
            </div>
    </div>
    <div id="modal-creation-sous-compte" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center">
                    <h2 class="modal-title"><i class="fa fa-pencil"></i> Enregistrer la création de sous compte</h2>
                </div>
                <div class="modal-body" style="margin-left:15px;">
                    <form id="form-validation" method="POST"  action="{{ route('save_date_creation_compte') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="entreprise" id="id_entreprise_creation_ss_compte" value="">
                <div class="row">
               
                <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }} col-md-6">
                    <label class=" control-label" for="telephone">Date de création de sous compte<span class="text-danger">*</span></label>
                    <input id="name" type="text" class="form-control datepicker" data-date-format="dd-mm-yyyy"  name="date_creation_compte"  placeholder="Entrer la date de création de sous compte ..." value="" required autofocus>    
                        @if ($errors->has('date_creation_compte'))
                        <span class="help-block">
                            <strong>{{ $errors->first('date_creation_compte') }}</strong>
                        </span>
                        @endif
                </div>
                </div>   
                    <div class="form-group form-actions">
                    <div class="col-md-8 col-md-offset-4">
                        <a href="#" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-arrow-right"></i> Enregistrer</button>
                    </div>
                </div>
                </form>
            </div>
                </div>
                <!-- END Modal Body  modal-devis-edit -->
            </div>
    </div>
<div id="modal-demande-de-kyc" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Enregistrer la demande de KYC</h2>
            </div>
            <div class="modal-body" style="margin-left:15px;">
                <form id="form-validation" method="POST"  action="{{ route('save_de_demande_kyc') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="entreprise" id="id_entreprise" value="">
            <div class="row">
           
            <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }} col-md-6">
                <label class=" control-label" for="telephone">Date de demande de KYC<span class="text-danger">*</span></label>
                <input id="name" type="text" class="form-control datepicker" data-date-format="dd-mm-yyyy"  name="date_demande_kyc"  placeholder="Entrer la date de demande de KYC ..." value="" required autofocus>    
                    @if ($errors->has('date_demande_kyc'))
                    <span class="help-block">
                        <strong>{{ $errors->first('date_demande_kyc') }}</strong>
                    </span>
                    @endif
            </div>
            </div>   
                <div class="form-group form-actions">
                <div class="col-md-8 col-md-offset-4">
                    <a href="#" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
                    <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-arrow-right"></i> Enregistrer</button>
                </div>
            </div>
            </form>
        </div>
            </div>
            <!-- END Modal Body  modal-devis-edit -->
        </div>
    </div>

    <div id="modal-result-kyc" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center">
                    <h2 class="modal-title"><i class="fa fa-pencil"></i> Enregistrer le resultat de la KYC</h2>
                </div>
                <div class="modal-body" style="margin-left:15px;">
                    <form id="form-validation" method="POST"  action="{{ route('save_result_kyc') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="entreprise" id="id_entreprise_2" value="">
                <div class="row">
               
                <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }} col-md-6">
                    <label class=" control-label" for="telephone">Date de réalisation de KYC<span class="text-danger">*</span></label>
                    <input id="name" type="text"  class="form-control datepicker" data-date-format="dd-mm-yyyy" name="date_result_kyc"    placeholder="Entrer la date du resultat du KYC.." value="" required autofocus>    
                        @if ($errors->has('date_result_kyc'))
                        <span class="help-block">
                            <strong>{{ $errors->first('date_result_kyc') }}</strong>
                        </span>
                        @endif
                </div>
                <div class="form-group col-md-6" >
                    <label class="control-label " for="example-chosen">Resultat du KYC<span class="text-danger">*</span></label>
                        <select id="" name="result_kyc" class="form-control" data-placeholder="Resultat du KYC" style="width: 100%;" required>
                            <option value="concluant">Concluant</option>
                            <option value="Non concluant">Non Concluant</option>
                        </select>
                </div>
                </div>   
                    <div class="form-group form-actions">
                    <div class="col-md-8 col-md-offset-4">
                        <a href="#" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-arrow-right"></i> Enregistrer</button>
                    </div>
                </div>
                </form>
            </div>
                </div>
                <!-- END Modal Body  modal-devis-edit -->
            </div>
        </div>
@endsection
<script>
      function recupererentreprise_id(entreprise){
            document.getElementById("id_entreprise").setAttribute("value", entreprise);
            document.getElementById("id_entreprise_2").setAttribute("value", entreprise);
            document.getElementById("id_entreprise_beneficaires").setAttribute("value", entreprise);
          
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

