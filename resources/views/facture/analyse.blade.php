@extends('layouts.admin')
@section('finacement', 'active')
@section('facture_analyse', 'active')
@section('content')

<div class="col-md-4 document_style">
    <a class="" href="#modal-images-biens" data-toggle="modal">
      <span ><img src="{{ asset('img/upload_img.jpeg') }}" alt="" width="35"></span> <span><p>Visualiser les biens acquis en image</p></span>
    </a>
</div>
<div class="col-md-4 document_style">
    <a class="" href="#modal-rapport-suivi" data-toggle="modal">
      <span ><img src="{{ asset('img/upload_img.jpeg') }}" alt="" width="35"></span> <span><p>Visualiser le rapport du dernier suivi</p></span>
    </a>
</div>
<div class="col-md-12">
    <div class="block">
        <!-- Basic Form Elements Title -->
        <div class="block-title">
            <div class="block-options pull-right">
                <a onclick="window.history.back();" class="btn btn-sm btn-success"><i class="fa fa-repeat"></i> Fermer</a>
                {{-- <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default toggle-bordered enable-tooltip" data-toggle="button" title="Toggles .form-bordered class"></a> --}}
            </div>
            <h2><strong>Detail</strong> de la facture</h2>
        </div>
        @if($facture->raison_rejet)
            <div class="row">
                <div class="row col-md-offset-2">
                    <label class="col-md-7 control-label">Motif du rejet : </label> <div class="col-md-5"> <span> {{ getlibelle($facture->raison_rejet)  }} {{ $facture->observation }}</span></div>
                </div>
            </div>
        @endif
        <div class="table-responsive">
                    <div class="col-lg-4">
                        <div class="form-group row">
                            <div class="col-sm-4">
                              <label>Numéro du devis associé:</label>
                            </div>
                            <div class="col-sm-8 mb-3 mb-sm-0">
                                <label class="fb"> <a target="_blank" href="{{ route('devi.show', $facture->devi) }}"> {{ $facture->devi->numero_devis }} </a></label>
                              {{-- <label class="fb"> {{ $facture->devi->numero_devis }}</label> --}}
                            </div>
                          </div>
                            <div class="form-group row">
                              <div class="col-sm-4">
                                <label>Taux de réalisation:</label>
                              </div>
                              <div class="col-sm-8 mb-3 mb-sm-0">
                                <label class="fb"> {{ $facture->devi->taux_de_realisation }} %</label>
                              </div>
                            </div>
                            <div class="form-group row">
                              <div class="col-sm-4">
                                <label>Numéro de la facture:</label>
                              </div>
                              <div class="col-sm-8 mb-3 mb-sm-0">
                                <label class="fb"> {{ $facture->num_facture }}</label>
                              </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-4">
                                  <label>Montant:</label>
                                </div>
                                <div class="col-sm-8 mb-3 mb-sm-0">
                                  <label class="fb"> {{ format_prix($facture->montant) }} </label>
                                </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">
                              <label>Mode de paiement:</label>
                            </div>
                            <div class="col-sm-8 mb-3 mb-sm-0">
                              <label class="fb"> {{ $facture->mode_de_paiement }} </label>
                            </div>
                        </div>
                        @if($facture->mode_de_paiement=='virement')
                        <div class="form-group row">
                            <div class="col-sm-4">
                              <label>Banque:</label>
                            </div>
                            <div class="col-sm-8 mb-3 mb-sm-0">
                              <label class="fb"> {{ $facture->nom_de_banque }} </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">
                              <label>Numero de compte:</label>
                            </div>
                            <div class="col-sm-8 mb-3 mb-sm-0">
                              <label class="fb"> {{ $facture->numero_de_compte }} </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">
                              <label>Télécharger le RIB:</label>
                            </div>
                            <div class="col-sm-8 mb-3 mb-sm-0">
                                <label class="fb"> <a target="_blank" href="{{ route("telechargerfacture", $facture->id)}}?file=rib"> La copie du RIB </a></label>
                            </div>
                        </div>
                        @endif
                        @if($facture->mode_de_paiement=='paiement_mobile')
                        <div class="form-group row">
                            <div class="col-sm-4">
                              <label>Numéro de téléphone:</label>
                            </div>
                            <div class="col-sm-8 mb-3 mb-sm-0">
                              <label class="fb"> {{ $facture->numero_de_telephone }} </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">
                              <label>Moyen de paiement mobile:</label>
                            </div>
                            <div class="col-sm-8 mb-3 mb-sm-0">
                              <label class="fb"> {{ $facture->moyen_de_paiement_mobile }} </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">
                              <label>Détenteur du numéro:</label>
                            </div>
                            <div class="col-sm-8 mb-3 mb-sm-0">
                              <label class="fb"> {{ $facture->detenteur_du_numero }} </label>
                            </div>
                        </div>
 
                        @endif
                        @if($facture->mode_de_paiement=='cheque')
                        <div class="form-group row">
                            <div class="col-sm-4">
                              <label>Identite du bénéficiaire du cheque:</label>
                            </div>
                            <div class="col-sm-8 mb-3 mb-sm-0">
                              <label class="fb"> {{ $facture->identite_beneficiaire }} </label>
                            </div>
                        </div>
                        
                        @endif

                            <hr>
                            @can('changer_statut_facture_ou_devis', Auth::user())
                                @if($facture->statut=='soumis' || $facture->statut=='transmis_au_chef_de_projet')
                                <div class="form-group">
                                    <a href="#modal-rejeter_devis" onclick="affectervaleur_a_unchamp('id_entreprise', {{ $facture->id  }});"  data-toggle="modal" class="btn btn-lg btn-danger"><i class="fa fa-repeat"></i> Rejeter</a>
                                    <a href="#modal-confirm-devis" data-toggle="modal" onclick="affectervaleur_a_unchamp('id_entreprise', {{ $facture->id}});" class="btn btn-lg btn-success"><i class="fa fa-check"></i>Valider</a>
                                    
                                </div>
                                @endif
                        @endcan
                            @can('facture.payer', Auth::user())
                                @if($facture->statut=='validé')
                                    <div class="form-group">
                                        <a href="#modal-rejeter_devis" onclick="affectervaleur_a_unchamp('id_entreprise', {{ $facture->id  }});"  data-toggle="modal" class="btn btn-lg btn-danger"><i class="fa fa-repeat"></i> Rejeter</a>
                                        <a href="#modal-payer-facture" data-toggle="modal" onclick="affectervaleur_a_unchamp('id_entreprise', {{ $facture->id}});" class="btn btn-lg btn-success"><i class="fa fa-repeat"></i>Payer</a>
                                    </div>
                                @endif
                            @endcan
                    </div>
                    <div class="col-lg-8 img-bg" style="cursor: pointer;">
                            <div style="box-shadow: 1px 2px 5px 1px #999">
                              <embed src= "{{ Storage::disk('local')->url($facture->url_fac) }}" height=400 type='application/pdf' style="width: 100%;" />
                        </div>

                     </div>
                    </div>
                </div>
</div>

<div class="col-md-12">
    <div class="block">
    <div class="block-title">
        Historique de traitement
    </div>
    
      <div class="table-responsive">
        <table  class="table table-vcenter table-condensed table-bordered listepdf">
            <thead>
                    <tr>
                        <th>Date</th>
                        <th>Utilisateur</th>
                        <th>statut</th>
                        <th>Observations</th>
                        
                    </tr>
            </thead>
            <tbody>
                @foreach($historiques as $historique)
                    <tr>
                        <td>{{ format_date($historique->date_statut) }}</td>
                        <td>{{ getusername($historique->user_id) }}</td>
                        <td>{{ $historique->statut }}</td>
                        <td>{{ $historique->observation }}</td>
                       
                    </tr>
                @endforeach
            </tbody>
            </table>
        </div>
  
  
  </div>
  </div>
  
@endsection
{{-- <div></div> --}}
<div id="modal-images-biens" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog-lg">
        <div class="modal-content" style="height: 150%">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"> Images des Biens acquis 
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">X</button>
                </h2>
                
            </div>
            <div class="modal-body">

                <div>
                    @foreach ($facture->images_des_biens as $image_de_bien )
                        <div class="col-md-6">  
                            <img class="cadre_image" src= "{{ Storage::disk('local')->url($image_de_bien->url_image) }}" alt="">
                        </div>
                    @endforeach
                </div>
               

            </div>
            <!-- END Modal Body -->
        </div>
    </div>
</div>

<div id="modal-confirm-devis" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Confirmer la validation de la facture</h2>
            </div>
            <div class="modal-body">
                       <input type="hidden" name="id_entreprise" id="id_entreprise">
                        <p>Confirmez-vous la validation de la facture ?</p>
                    <div class="form-group form-actions">
                        <div class="text-right">
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                            <button type="button" class="btn btn-sm btn-primary" onclick="changer_statut_devis();">OUI</button>
                        </div>
                    </div>

            </div>
            <!-- END Modal Body -->
        </div>
    </div>
</div>
<div id="modal-rejeter_devis" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Rejet de la facture</h2>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group">
                        <label class=" control-label" for="">Motifs de rejet <span data-toggle="tooltip" title="Le motif de rejet du devis"></label>
                        <select id="raison_du_rejet" name="motif_de_rejet" class="select-select2" data-placeholder="Selectionner le motif de rejet de la facture" style="width: 80%"  required>
                            @foreach ($motifs_de_rejects as $motifs_de_reject)
                                <option value=""></option>
                                <option value="{{ $motifs_de_reject->id }}">{{ $motifs_de_reject->libelle }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <input type="hidden" name="id_entreprise" id="id_entreprise">
                    <label for="observation">Motif du rejet <span class="text-danger">* </span>: </label><textarea name="observation" id="observation" cols="60" rows="10" placeholder="renseigner le motif du rejet de la facture"></textarea>
                </div>
               
                    <div class="form-group form-actions">
                        <div class="text-right">
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                            <button type="button" class="btn btn-sm btn-primary" onclick="changer_statut_devis();">rejeter</button>
                        </div>
                    </div>
                
            </div>
            <!-- END Modal Body -->
        </div>
    </div>
</div>
<div id="modal-payer-facture" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Enregistrer le paiement de la facture</h2>
            </div>
            <div class="modal-body">
                <form id="form-validation" method="POST"  action="{{ route('facture.storepaiement') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="facture_id" value="{{ $facture->id }}">
                    <input type="hidden" id='facture_date_de_validation' name="facture_date_de_validation" value="{{ $facture->date_de_validation }}">

            <div class="row">
                <div class="form-group{{ $errors->has('recu_de_paiement') ? ' has-error' : '' }} col-md-6" style="margin-left:10px;">
                    <label class="control-label" for="listedepresence">Joindre une copie du recu de paiement <span class="text-danger">*</span></label>
                        <input class="form-control docsize"  type="file" name="recu_de_paiement" id="recu_de_paiement" accept=".pdf, .jpeg, .png"   onchange="VerifyUploadSizeIsOK('recu_de_paiement');" placeholder="Charger une copie de fiche d'analyse des offres">
                    @if ($errors->has('recu_de_paiement'))
                        <span class="help-block">
                            <strong>{{ $errors->first('recu_de_paiement') }}</strong>
                        </span>
                    @endif
                </div>
           
            <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }} col-md-5">
                <label class=" control-label" for="telephone">Date réelle de paiement<span class="text-danger">*</span></label>
                <input id="name" type="text"  class="form-control datepaiement_facture" name="date_paiement" value="{{ old('date_paiement') }}" required autofocus>    
                    @if ($errors->has('date_paiement'))
                    <span class="help-block">
                        <strong>{{ $errors->first('date_paiement') }}</strong>
                    </span>
                    @endif
                </div>
            </div>   
   
                <div class="form-group form-actions">
                <div class="col-md-8 col-md-offset-4">
                    <a href="{{ route('profil.mesdevis') }}" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
                    <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-arrow-right"></i> Valider le paiement</button>
                </div>
            </div>
            </form>
        </div>
            </div>
            <!-- END Modal Body  modal-devis-edit -->
        </div>
</div>
    <div id="modal-rapport-suivi" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog-md">
            <div class="modal-content" style="height: 150%">
                <!-- Modal Header -->
                <div class="modal-header text-center">
                    <h2 class="modal-title"> Images des Biens acquis 
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">X</button>
                    </h2>
                </div>
                <div class="modal-body">
            @if($suiviExecution)
                    <div class='row'>
                        <div class="col-md-6">
                            <div class="col-md-4">
                                <p>Date du suivi : </p>
                            </div>
                            <div class="col-md-8">
                                <p>{{ format_date($suiviExecution->date_visite) }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-4">
                                <p>Taux de réalisation : </p>
                            </div>
                            <div class="col-md-8">
                                <p>{{ $suiviExecution->taux_de_realisation }} %</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-4">
                                <p>Observation: </p>
                            </div>
                            <div class="col-md-8">
                                <p>{{ $suiviExecution->observation }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @foreach ($suiviExecution->images_de_suivis as $images_de_suivi )
                            <div class="col-md-4">  
                                <img class="cadre_image" src= "{{ Storage::disk('local')->url($images_de_suivi->url_image) }}" alt="">
                            </div>
                        @endforeach
                    </div>
                   
                    @else
                        <p>Aucun rapport de suivi n'a été soumis pour ce devis</p>
                     @endif
                </div>
            
    
                <!-- END Modal Body -->
            </div>
        </div>
    </div>
<script>
     function changer_statut_devis(){
        $(function(){
            var facture_id= $("#id_entreprise").val();
            var raison= $("#raison_du_rejet").val();
            var observation= $("#observation").val();
            var url = "{{ route('facture.changerstatus') }}";
            $.ajax({
                url: url,
                type:'GET',
                data: {facture_id: facture_id, raison:raison, observation:observation},
                error:function(){alert('error');},
                success:function(data){
                if(data==0){
                    $("#taux_de_realisation_no_ok").hide();
                   window.location=document.referrer;
                }
                else{
                    window.location=document.referrer;
                   alert("Vous ne pouvez pas valider cette facture Car le taux de réalisation du devis est inférieur à 100%")
                }
                    
                }
            });
            });
    }
</script>
<script>
   
 

</script>