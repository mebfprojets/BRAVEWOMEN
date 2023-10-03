@extends("layouts.espace_beneficiaire")
@section('devis', 'active')
@section('content')
<section class="wrapper">
        <h3><i class="fa fa-angle-right"></i> Visualiser la demande de paiement </h3>
        
        <div class="row mb">
          <!-- page start-->
          <div class="content-panel">
            <div class="row">
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
                                                  <label>Taux de réalisation:</label>
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
                                            <div class="form-group row">
                                                <div class="col-sm-4">
                                                  <label>Paiement par:</label>
                                                </div>
                                                <div class="col-sm-8 mb-3 mb-sm-0">
                                                  <label class="fb"> <strong>{{ $facture->mode_de_paiement }}</strong> 
                                                    @if($facture->mode_de_paiement=='virement')
                                                        à la banque {{ $facture->nom_de_banque }} sur le compte N {{ $facture->numero_de_compte }}
                                                        
                                                    @elseif($facture->mode_de_paiement=='cheque')
                                                     au nom de : {{ $facture->identite_beneficiaire }}
                                                     @else
                                                     Au numero : {{ $facture->numero_de_telephone }} avec  {{ $facture->moyen_de_paiement_mobile }} au nom de : {{ $facture->detenteur_du_numero }}
                                                    @endif

                                                    
                                                </label>
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
                                            
                                            {{-- @if($facture->statut=='soumis' || $facture->statut=='transmis_au_chef_de_projet')
                                            <div class="form-group">
                                                <a href="#modal-confirm-devis" data-toggle="modal" onclick="affectervaleur_a_unchamp('id_entreprise', {{ $facture->id}});" class="btn btn-lg btn-success"><i class="fa fa-repeat"></i>Valider</a>
                                                <a href="#modal-rejeter_devis" onclick="affectervaleur_a_unchamp('id_entreprise', {{ $facture->id  }});"  data-toggle="modal" class="btn btn-lg btn-danger"><i class="fa fa-repeat"></i> Rejeter</a>
                                            </div>
                                            @endif --}}
                
                                    </div>
                                    <div class="col-lg-8 img-bg" style="cursor: pointer;">
                                            <div style="box-shadow: 1px 2px 5px 1px #999">
                                              <embed src= "{{ Storage::disk('local')->url($facture->url_fac ) }}" height=400 type='application/pdf' style="width: 100%;" />
                                        </div>
                
                                    </div>
                
                        </div>
                    </div>

                </div> 
</div> 
<div class="row" style="margin-left:10px">
    <h2>Images des acquisitions/réalisations</h2>
    <div>
        @foreach ($facture->images_des_biens as $image_de_bien )
            <div class="col-md-4" >
                <img class="cadre_image"  src= "{{ Storage::disk('local')->url($image_de_bien->url_image ) }}" alt="" width="100%">
        </div>
        @endforeach
    </div>
</div>
</div>
</section>
@endsection
@section('modal')
<div id="modal-images-biens" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog-md">
        <div class="modal-content" style="height: 150%">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"> Images des Biens acquis 
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">X</button>
                </h2>
                
            </div>
            <div class="modal-body">
                <div class="row" style="text-align: center; font-size:14px">
                        <a  href="#modal-add-images-biens" data-toggle="modal"> <i class="fa fa-plus"></i> Ajouter d'autres images</a>
                </div>
                <div style="height: 150%">
                    @foreach ($facture->images_des_biens as $image_de_bien )
                        <div class="col-md-4" >
                            <a  href="#modal-modif-image"  data-toggle="modal"  onclick="setid_image({{ $image_de_bien->id }})"> <i class="fa fa-pencil"></i> Changer l'image</a>
                            <img   class="cadre_image"  src= "{{ Storage::disk('local')->url($image_de_bien->url_image ) }}" alt="" width="100%">
                           
                            
                       
                        
                    </div>
                    
                    
                    @endforeach
                </div>
               

            </div>
            <!-- END Modal Body -->
        </div>
    </div>
</div>
<div id="modal-add-images-biens" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-add"></i> Changer une autre image</h2>
            </div>
            <div class="modal-body">
                <form id="form-validation" method="POST"  action="{{route('image_bien_acquis.store')}}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" id='facture_id' name="facture_id" value="{{ $facture->id }}">
            <div class="row">
                <div class="form-group{{ $errors->has('piece_file') ? ' has-error' : '' }} col-md-10" style="margin-left:10px;">
                    <label  class="control-label col-md-4"  class="control-label" for="piece_file">Joindre la nouvelle piece jointe <span class="text-danger">*</span></label>
                    <div class="input-group col-md-6">
                        <input class="form-control docsize"  type="file" name="image_bien" id="piece_file" accept=".pdf, .jpeg, .png"   onchange="VerifyUploadSizeIsOK('piece_file');" placeholder="Charger la nouvelle piece">
                        <span class="input-group-addon"><a href="#" class="empty_field" onclick="empty_input_file('piece_file')">Vider le champ</a></span>
                    </div>
                    @if ($errors->has('piece_file'))
                        <span class="help-block">
                            <strong>{{ $errors->first('piece_file') }}</strong>
                        </span>
                    @endif
                </div>
            </div> 
           
                <div class="form-group form-actions">
                <div class="col-md-8 col-md-offset-4">
                    <button type="button" onclick="reload()" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-sm btn-success" ><i class="fa fa-arrow-right"></i> Valider</button>

                </div>
            </div>
            </form>
            </div>
        </div>   
        </div>
    </div>
<div id="modal-modif-image" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Changer l'image de l'acquisition</h2>
            </div>
            <div class="modal-body">
                <form id="form-validation" method="POST"  action="{{route('image_bien_acquis.modifier')}}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" id='image_id' name="image_id" value="">
                   
            <div class="row">
                <div class="form-group{{ $errors->has('piece_file') ? ' has-error' : '' }} col-md-10" style="margin-left:10px;">
                    <label  class="control-label col-md-4"  class="control-label" for="piece_file">Joindre la nouvelle piece jointe <span class="text-danger">*</span></label>
                    <div class="input-group col-md-6">
                        <input class="form-control docsize"  type="file" name="image_bien" id="piece_file" accept=".jpg, .jpeg, .png"   onchange="VerifyUploadSizeIsOK('piece_file');" placeholder="Charger la nouvelle piece">
                        <span class="input-group-addon"><a href="#" class="empty_field" onclick="empty_input_file('piece_file')">Vider le champ</a></span>
                    </div>
                    @if ($errors->has('piece_file'))
                        <span class="help-block">
                            <strong>{{ $errors->first('piece_file') }}</strong>
                        </span>
                    @endif
                </div>
            </div> 
           
                <div class="form-group form-actions">
                <div class="col-md-8 col-md-offset-4">
                    <button type="button" onclick="reload()" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-sm btn-success" ><i class="fa fa-arrow-right"></i> Valider</button>

                </div>
            </div>
            </form>
            </div>
        </div>   
        </div>
    </div>
<div id="modal-facture-details" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
           
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Detail sur la facture</h2>
            </div>
            <div class="modal-body">
                <div class="row col-md-offset-2">
                    <label class="col-md-3 control-label">Statut : </label> <div class="col-md-8"><span id="statut_v"></span></div>
                </div>
                <div class="row col-md-offset-2">
                    <label class="col-md-3 control-label">Motif : </label> <div class="col-md-8"><span id="motif_v"></span></div>
                </div>

                <div class="row col-md-offset-2">
                    <label class="col-md-3 control-label">Montant : </label> <div class="col-md-8"> <span  id="montant_v"></span></div>
                </div>

                <div class="row col-md-offset-2">
                        <label class="col-md-3 control-label">Mode de paiement : </label> <div class="col-md-8"> <span  id="mode_de_paiement_v"></span></div>
                </div>
               
                
                <fieldset class="docs">
                    <legend>Visualiser les documents</legend>
                </fieldset>
                <fieldset class="image_acquisition">
                    <a href="#modal-images-biens" data-toggle="modal">Visualiser les images des acquisitions/réalisations</a>
                    <legend></legend>
                </fieldset>
                    <div class="text-right">
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                    </div>
            </div>
            <!-- END Modal Body -->
        </div>
    </div>
</div>
@endsection

<script>
   function changer_mode_de_paiement(mode_de_paiement,champ_paiement_cheque_ou_virement,champ_paiement_mobile){
       var valeur= $('.'+mode_de_paiement).val();
      // alert(valeur);
       if(valeur=='paiement_mobile'){
        $('.'+champ_paiement_cheque_ou_virement).hide();
        $('.'+champ_paiement_mobile).show();
       }
       else if(valeur=='virement'){
        $('.'+champ_paiement_cheque_ou_virement).show();
        $('.'+champ_paiement_mobile).hide();
       }
       else{
        $('.'+champ_paiement_cheque_ou_virement).hide();
        $('.'+champ_paiement_mobile).hide();
       }
   }
</script>
<script>
    function setid_image(id){
        $('#image_id').val(id);
    }
</script>
<script>
    function edit_facture(id){
                var id=id;
                var url = "{{ route('facture.modif') }}";
                $.ajax({
                    url: url,
                    type:'GET',
                    dataType:'json',
                    data: {id: id} ,
                    error:function(){alert('error');},
                    success:function(data){
                        var motif= data.motif+' '+ data.observation;
                        $("#facture_id").val(data.id);
                       $("#montant_u").val(data.montant_facture);
                       $("#mode_de_paiement_u").val(data.mode_de_paiement);
                       $("#numero_de_telephone_u").val(data.numero_de_telephone);
                       $("#numero_de_compte_u").val(data.numero_de_compte);
                       $("#nom_de_banque_u").val(data.nom_de_banque);
                       $("#detenteur_du_numero_u").val(data.detenteur_du_numero);
                       $("#statut").val(data.statut);
                       $("#motif").val(motif);
                       $("#fac_url_u").val(data.copie_facture); 
                       var url=  $("#fac_url_u").val();
                       $("#facture_id").val(data.id);
                       $("#montant_v").text(data.montant_facture);
                       $("#mode_de_paiement_v").text(data.mode_de_paiement);
                       $("#statut_v").text(data.statut);
                       $("#motif_v").val(motif);
                       var rout_facture= '{{ route("telechargerfacture",":url")}}?file=facture';
                       var rout_recu_de_paiement= '{{ route("telechargerfacture",":url")}}?file=recu_depaiement';
                       var rout_facture = rout_facture.replace(':url', data.id);
                       var rout_recu_de_paiement = rout_recu_de_paiement.replace(':url', data.id);
                       p1 = '<p style="color:green">'  + '<a href="'+rout_facture+'" data-toggle="tooltip" title="Telecharger" target="_blank">Visualiser la facture</a>';
                       p2 = '<p>'  + '<a href="'+rout_recu_de_paiement+'" data-toggle="tooltip" title="Telecharger" target="_blank">Le reçu de paiement </a>';
                       $('.docs').append(p1);
                       $('.docs').append(p2);
                    
                       if($("#mode_de_paiement_u").val()=='virement'){
                            $('.champ_paiement_cheque_ou_virement_u').show()
                            $('.champ_paiement_mobile_u').hide()

                       }
                       else if($("#mode_de_paiement_u").val()=='paiement_mobile'){
                            $('.champ_paiement_cheque_ou_virement_u').hide()
                            $('.champ_paiement_mobile_u').show()
                       }
                       else{
                             $('.champ_paiement_cheque_ou_virement_u').hide()
                            $('.champ_paiement_mobile_u').hide()
                       }
                    }
                });
        }
</script>