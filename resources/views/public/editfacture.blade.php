@extends("layouts.espace_beneficiaire")
@section('devis', 'active')
@section('content')
<section class="wrapper">
        <h3><i class="fa fa-angle-right"></i> Modifier la demande de paiement </h3>
        
        <div class="row mb">
          <!-- page start-->
          <div class="content-panel">
            <form id="form-validation" method="POST"  action="{{ route('facture.enrg_modification') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                {{ csrf_field() }}
            <div class="row" style="margin-left:10px;">
            <div class="col-md-6">
                <input type="hidden" name="facture_id" id="facture_id"  value="{{ $facture->id}}">
                <input type="hidden" name="devi_id" id="devi_id" value="{{ $devi->id }}">
                <input type="hidden" name="fac_url" id="fac_url_u">
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-6" >
                    <label class="control-label" for="name">Statut : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input id="statut" type="text" class="form-control" name="statut" disabled value="{{ $facture->statut }}">
                        </div>
                </div>
                @if($facture->statut=='rejeté')
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-6" >
                    <label class="control-label" for="name">Motif : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <textarea id="motif" type="text" rows="2" cols="30" name="motif" disabled value="{{ old('montant_devis') }}">{{ getlibelle($facture->raison_rejet)  }} {{ $facture->observation }}</textarea>
                        </div>
                </div>
                @endif
            
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-6" >
                <label class="control-label" for="name">Montant de la facture : <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input id="montant_u" type="text" class="form-control" name="montant_facture" placeholder="Montant de la facture" value="{{ format_prix($facture->montant) }}" required autofocus onChange="verifier_montant('montant_u','devi_id', 'facture_id')">
                        <span class="input-group-addon"><i class="gi gi-user"></i></span>
                    @if ($errors->has('designation'))
                    <span class="help-block">
                        <strong>{{ $errors->first('montant_facture') }}</strong>
                    </span>
                    @endif
                </div>
            <span class='depassement_du_montant_du_devis' style="color:red; display:none;"><p>Bien vouloir verifier le montant! Le total des montants des factures ne doit pas depasser le montant du devis.</p></span>
            </div>
            <div class="form-group col-md-6" style="margin-left: 15px;">
                <label class="control-label " for="example-chosen">Mode de paiement<span class="text-danger">*</span></label>
                    <select id="mode_de_paiement_u" name="mode_de_paiement" class="form-control mode_de_paiement_1"  onchange="changer_mode_de_paiement('mode_de_paiement_1','champ_paiement_cheque_ou_virement_u','champ_paiement_mobile_u','champ_paiement_cheque_u');"  style="width: 100%;" required>
                        <option></option>
                        <option value="virement" @if($facture->mode_de_paiement=='virement') selected @endif>Par virement</option>
                        <option value="cheque" @if($facture->mode_de_paiement=='cheque') selected @endif>Par chèque</option>
                        <option value="paiement_mobile" @if($facture->mode_de_paiement=='paiement_mobile') selected @endif>Paiement mobile</option>
                    </select>
            </div>
            <div class="row champ_paiement_cheque_ou_virement_u" >
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-6" style="margin-left:0px;">
                    <label class="control-label" for="name">Nom de la banque : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input id="nom_de_banque_u" type="text" class="form-control" name="nom_de_banque" placeholder="Nom et prénom du dententeur du numéro" value="{{ $facture->nom_de_banque }}" >
                            <span class="input-group-addon"><i class="gi gi-user"></i></span>
                        @if ($errors->has('designation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('nom_de_banque') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-6" style="margin-left:0px;">
                    <label class="control-label" for="name">Numéro de compte : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input id="numero_de_compte_u" type="text" class="form-control" name="numero_de_compte" placeholder="Entrez le numéro de la banque" value="{{ $facture->numero_de_compte }}"  autofocus >
                            <span class="input-group-addon"><i class="gi gi-user"></i></span>
                        @if ($errors->has('designation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('numero_de_compte') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('copie_rib') ? ' has-error' : '' }} col-md-6 " >
                    <label class="control-label" for="listedepresence">Joindre une copie du RIB <span class="text-success">*</span></label>
                        <input class="form-control docsize col-md-6"  type="file" name="copie_rib_u" id="copie_rib" accept=".pdf, .jpeg, .png"   onchange="VerifyUploadSizeIsOK('facture_file');" placeholder="Charger une copie de fiche d'analyse des offres"  style="100%">
                    @if ($errors->has('copie_rib_u'))
                        <span class="help-block">
                            <strong>{{ $errors->first('copie_rib_u') }}</strong>
                        </span>
                    @endif
                </div>
                
            </div>
            <div class="row champ_paiement_mobile_u" style="display: none">
                <div class="form-group col-md-6" >
                    <label class="control-label " for="example-chosen">Type de paiement mobile<span class="text-danger">*</span></label>
                        <select id="type_de_paiement_mobile" name="type_de_paiement_mobile" class="form-control type_de_paiement_mobile"  data-placeholder="" style="width: 100%;" >
                            <option></option>
                        {{-- Les moyens de paiement de coris banque internationale --}}
                        <option value="orange money"  @if($facture->moyen_de_paiement_mobile=='orange money') selected @endif>Orange money</option>
                        <option value="mobicash" @if($facture->moyen_de_paiement_mobile=='mobicash') selected @endif >Mobicash</option>
                        @if($devi->entreprise->banque_id==2)
                        <option value="coris money" @if($facture->moyen_de_paiement_mobile=='coris money') selected @endif>Coris Money</option>
                        @elseif($devi->entreprise->banque_id==3)
                            <option value="atlantique money" @if($facture->moyen_de_paiement_mobile=='wiz all') selected @endif>Wiz all</option>
                        @else
                            <option value="boa money"  @if($facture->moyen_de_paiement_mobile=='boa money') selected @endif >Boa Money</option>
                        @endif

                        </select>
                </div>
               
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-6" style="margin-left:0px;">
                    <label class="control-label" for="name">Numero de télephone : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input id="numero_de_telephone_u" type="text" class="form-control" name="numero_de_telephone" placeholder="Entrez le numéro de téléphone" value="{{ $facture->numero_de_telephone }}" autofocus >
                            <span class="input-group-addon"><i class="gi gi-user"></i></span>
                        @if ($errors->has('designation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('numero_de_telephone') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-6" style="margin-left:0px;">
                    <label class="control-label" for="name">Nom & prenom du detenteur : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input id="detenteur_du_numero_u" type="text" class="form-control" name="nom_prenom_detenteur" placeholder="Nom de la banque" value="{{ $facture->detenteur_du_numero}}" >
                            <span class="input-group-addon"><i class="gi gi-user"></i></span>
                        @if ($errors->has('designation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('nom_prenom_detenteur') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="champ_paiement_cheque_u" style="display: none;">
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-10"  >
                    <label class="control-label" for="name">Identité du bénéficiaire du chèque :<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input id="" type="text" class="form-control" name="identite_beneficiaire" placeholder="entrez l'identité du bénéficiaire du chèque" value="{{ $facture->identite_beneficiaire }}"  >
                            <span class="input-group-addon"><i class="gi gi-user"></i></span>
                        @if ($errors->has('identite_beneficiaire'))
                        <span class="help-block">
                            <strong>{{ $errors->first('identite_beneficiaire') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            {{-- <div class="row champ_paiement_cheque_ou_virement_u" >
                <div class="form-group{{ $errors->has('copie_rib') ? ' has-error' : '' }} col-md-6 " >
                    <label class="control-label" for="listedepresence">Joindre une copie du RIB <span class="text-success">*</span></label>
                        <input class="form-control docsize col-md-6"  type="file" name="copie_rib" id="copie_rib" accept=".pdf, .jpeg, .png"   onchange="VerifyUploadSizeIsOK('facture_file');" placeholder="Charger une copie de fiche d'analyse des offres"  style="100%">
                    @if ($errors->has('copie_rib_u'))
                        <span class="help-block">
                            <strong>{{ $errors->first('copie_rib') }}</strong>
                        </span>
                    @endif
                </div>
            </div> --}}
            
            <div class="form-group{{ $errors->has('facture_file') ? ' has-error' : '' }} col-md-6" style="margin-left:15px;">
                <label class="control-label" for="listedepresence">Copie du dossier de demande de paiement <span class="text-success">*</span></label>
                    <input class="form-control docsize"  type="file" name="facture_file_u" id="facture_file_u" accept=".pdf, .jpeg, .png" max="{{ $devi->montant_devis }}"  onchange="VerifyUploadSizeIsOK('facture_file');" placeholder="Joindre une copie du dossier de demande de paiement">
                @if ($errors->has('facture_file_u'))
                    <span class="help-block">
                        <strong>{{ $errors->first('facture_file_u') }}</strong>
                    </span>
                @endif
            </div>
            
        </div> 
        <div class="col-lg-6 img-bg" style="cursor: pointer;">
            <div style="box-shadow: 1px 2px 5px 1px #999">
              <embed src= "{{ Storage::disk('local')->url($facture->url_fac) }}" height=400 type='application/pdf' style="width: 100%;" />
        </div>

     </div>
     </div>
    
    <div class="form-group form-actions">
        <div class="col-md-8 col-md-offset-4">
            <a href="{{ route('facture.liste', $devi) }}" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
            <button type="submit" class="btn btn-sm btn-success soumettre_facture"><i class="fa fa-arrow-right"></i> Soumettre</button>
        </div>
    </div>
                <fieldset class="docs">
                    <legend>Images des biens acquis </legend>
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
                </fieldset> 
                {{-- <fieldset class="image_acquisitions">
                    <a href="#modal-images-biens" data-toggle="modal">Visualiser les images des acquisitions/réalisations</a>
                    <legend> </legend>
                </fieldset> --}}

            
        </form>
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
   function changer_mode_de_paiement(mode_de_paiement,champ_paiement_cheque_ou_virement,champ_paiement_mobile,champ_paiement_cheque){
       var valeur= $('.'+mode_de_paiement).val();
      // alert(valeur);
       if(valeur=='paiement_mobile'){
        $('.'+champ_paiement_cheque_ou_virement).hide();
        $('.'+champ_paiement_cheque).hide();
        $('.'+champ_paiement_mobile).show();
       }
       else if(valeur=='virement'){
        $('.'+champ_paiement_cheque_ou_virement).show();
        $('.'+champ_paiement_cheque).hide();
        $('.'+champ_paiement_mobile).hide();
       }
       else{
        $('.'+champ_paiement_cheque_ou_virement).hide();
        $('.'+champ_paiement_cheque).show();
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