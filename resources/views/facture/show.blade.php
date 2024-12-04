@extends('layouts.admin')
@section('finacement', 'active')
@section('facture', 'active')
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
<div class="row">
    @if($facture->statut=='payée')
        <div class="col-md-3 document_style">
        <a  target="_blank"  href="{{ route("telechargerfacture", $facture->id) }}?file=recu_paiement">
            <span ><img src="{{ asset('img/upload_img.jpeg') }}" alt="" width="35"></span> <span><p>Visualiser le recu de paiement</p></span>
        </a>
        </div>
    @endif
</div>
<div class="col-md-12">
    <div class="block">
        <!-- Basic Form Elements Title -->
        <div class="block-title">
            {{-- <a href="{{ route('facture.rejete',$facture) }}" data-toggle="tooltip" title="Visualiser" class="btn btn-lg btn-danger"><i class="fa fa-times"></i></a> --}}
            <div class="block-options pull-right">
                <a onclick="window.history.back();" class="btn btn-sm btn-success"><i class="fa fa-repeat"></i> Fermer</a>

                {{-- <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default toggle-bordered enable-tooltip" data-toggle="button" title="Toggles .form-bordered class"></a> --}}
            </div>
            <h2><strong>Detail</strong> de la facture</h2>
        </div>
        <div class="table-responsive">
                    <div class="col-lg-4">
                            <!-- Nom document -->
                            <div class="form-group row">
                              <div class="col-sm-4">
                                <label>Numéro du devis associé:</label>
                              </div>
                              <div class="col-sm-8 mb-3 mb-sm-0">
                                <label class="fb"> <a target="_blank" href="{{ route('devi.show', $facture->devi) }}"> {{ $facture->devi->numero_devis }} </a></label>
                              </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-4">
                                  <label>Taux de réalisation :</label>
                                </div>
                                <div class="col-sm-8 mb-3 mb-sm-0">
                                  <label class="fb"> {{ $facture->devi->taux_de_realisation }}</label>
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

                            <hr>
                            @if ($facture->date_de_validation)
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                    <label>Date de validation:</label>
                                    </div>
                                    <div class="col-sm-8 mb-3 mb-sm-0">
                                    <label class="fb"> {{ format_date($facture->date_de_validation) }} </label>
                                    </div>
                                </div>
                            @endif
                            @if ($facture->date_de_paiement)
                            <div class="form-group row">
                                <div class="col-sm-4">
                                  <label>Date de paiement:</label>
                                </div>
                                <div class="col-sm-8 mb-3 mb-sm-0">
                                  <label class="fb"> {{ format_date($facture->date_de_paiement) }} </label>
                                </div>
                            </div>
                            
                            @endif
                                <div class="form-group">
                                    <a href="#modal-recharger-facture" data-toggle="modal" onclick="affectervaleur_a_unchamp('facture_id', {{ $facture->id}});" class="btn btn-lg btn-success"><i class="fa fa-repeat"></i>Recharger le dossier de paiement</a>
                                </div>

                    </div>
                    <div class="col-lg-8 img-bg" style="cursor: pointer;">
                            <div style="box-shadow: 1px 2px 5px 1px #999">
                              <embed src= "{{ Storage::disk('local')->url($facture->url_fac ) }}" height=400 type='application/pdf' style="width: 100%;" />
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
                        <th>Num</th>
                        <th>Utilisateur</th>
                        <th>statut</th>
                        <th>Observations</th>
                        <th>Date</th>
                    </tr>
            </thead>
            <tbody>
                    @php
                        $i=0;
                    @endphp
                @foreach($historiques as $historique)
                    @php
                        $i++;
                    @endphp
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ getusername($historique->user_id) }}</td>
                        <td>{{ $historique->statut }}</td>
                        <td>{{ $historique->observation }}</td>
                        <td>{{ format_date($historique->date_statut) }}</td>
                    </tr>
                @endforeach
            </tbody>
            </table>
        </div>
  
  
  </div>
  </div>
@endsection
@section('modal_part')
<div id="modal-recharger-facture" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Recharger le dossier de paiement</h2>
            </div>
            <div class="modal-body">
                <form id="form-validation" method="POST"  action="{{ route('facture.storepaiement_file') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="facture_id" value="{{ $facture->id }}">
            <div class="row">
                <div class="form-group{{ $errors->has('dossier_de_paiement') ? ' has-error' : '' }} col-md-6" style="margin-left:10px;">
                    <label class="control-label" for="dossier_de_paiement">Joindre le dossier de paiement <span class="text-danger">*</span></label>
                        <input class="form-control docsize"  type="file" name="dossier_de_paiement" id="dossier_de_paiement" accept=".pdf, .jpeg, .png"   onchange="VerifyUploadSizeIsOK('dossier_de_paiement');" placeholder="Charger le dossier de paiement ">
                    @if ($errors->has('dossier_de_paiement'))
                        <span class="help-block">
                            <strong>{{ $errors->first('dossier_de_paiement') }}</strong>
                        </span>
                    @endif
                </div>
            </div>   
   
                <div class="form-group form-actions">
                <div class="col-md-8 col-md-offset-4">
                    <a href="#" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
                    <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-arrow-right"></i> Valider le paiement</button>
                </div>
            </div>
            </form>
        </div>
            </div>
            <!-- END Modal Body  modal-devis-edit -->
        </div>
</div>

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
                   {{count($facture->images_des_biens) }}
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
<div id="modal-confirm-devis" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Confirmer la validation du devis</h2>
            </div>
            <div class="modal-body">
                       <input type="hidden" name="id_entreprise" id="id_entreprise">
                        <p>Confirmez-vous la validation du devis ?</p>
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
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Rejet du devis</h2>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="id_entreprise" id="id_entreprise">
                    <label for="raison_du_rejet">Motif du rejet <span class="text-danger">* </span>: </label><textarea name="raison_du_rejet" id="raison_du_rejet" cols="60" rows="10" placeholder="renseigner le motif du rejet du devis"></textarea>
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
@endsection
<script>
     function changer_statut_devis(){
        $(function(){
            var facture_id= $("#id_entreprise").val();
            var raison= $("#raison_du_rejet").val();
            //alert(raison);
            var url = "{{ route('facture.changerstatus') }}";
            $.ajax({
                url: url,
                type:'GET',
                data: {facture_id: facture_id, raison:raison} ,
                error:function(){alert('error');},
                success:function(){
                    $('#modal-confirm-rejet').hide();
                    location.reload();
                }
            });
            });
    }
</script>