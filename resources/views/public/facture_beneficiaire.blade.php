@extends("layouts.espace_beneficiaire")
@section('devis', 'active')
@section('content')
<section class="wrapper">
        <h3><i class="fa fa-angle-right"></i> Les demandes de paiements {{ $devi->factures->count() }} </h3>
        @if ($devi->factures_soumis->sum('montant') < $devi->montant_devis)
             <a href="#modal-create-facture" data-toggle="modal"  data-toggle="tooltip" title="Edit" class="btn btn-xs btn-success"><i class="fa fa-plus"></i> Nouvelle demande de paiement</a>  
        @endif
        <div class="row mb">
          <!-- page start-->
          <div class="content-panel">
            <div class="row col-md-offset-2">
                <label class="col-md-7 control-label">Montant du devis : </label> <div class="col-md-5"> <span> {{ format_prix( $devi->montant_devis)  }}</span></div>
            </div>
            <div class="row col-md-offset-2">
                <label class="col-md-7 control-label">Montant des demandes de paiement en cours : </label> <div class="col-md-5"> <span> {{ format_prix($devi->factures_en_cours()->sum("montant")) }}</span></div>
            </div>
            <div class="row col-md-offset-2">
                <label class="col-md-7 control-label">Montant des paiements effectués : </label> <div class="col-md-5"> <span> {{ format_prix($devi->factures_payees()->sum("montant")) }}</span></div>
            </div>
            <div class="row col-md-offset-2">
                <label class="col-md-7 control-label">Reste à payer : </label> <div class="col-md-5"> <span> {{ format_prix( $devi->montant_devis - $devi->factures_payees()->sum("montant") )  }}</span></div>
            </div>
            <div class="adv-table">
        <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
            <thead>
                    <tr>
                        <th style="width: 5%">N</th>
                        <th style="width: 5%">Code facture</th>
                        <th style="width: 5%">Statut</th>
                        <th style="width: 30%">Mode de paiement</th>
                        <th style="width: 30%">Montant</th>
                        <th style="width: 20%">Actions</th>
                    </tr>
            </thead>
            <tbody>
                @php
                  $i=0;
                @endphp
                @foreach($facs as $facture)
                    @php
                        $i++;
                    @endphp
                    <tr>
                        <td>{{ $i}}</td>
                        <td>{{ $facture->num_facture }}</td>
                        <td>{{ $facture->statut }}</td>
                        <td>{{ $facture->mode_de_paiement }}</td>
                        <td>{{format_prix($facture->montant)}}</td>
                        <td class="text-center">
                                <div class="btn-group">
                                 @if($facture->statut=='rejeté') 
                                     {{-- <a onclick="edit_facture({{ $facture->id }});" href="#modal-facture-edit" data-toggle="modal"  data-toggle="tooltip" title="Edit" class="btn btn-md btn-default"><i class="fa fa-pencil"></i></a> --}}
                                     <a href="{{ route('facture.edit', $facture ) }}" class="btn btn-md btn-default"  title="Modifier la facture"><i class="fa fa-pencil"></i></a>
                                 @endif
                                 <a href="{{ route('facture.view', $facture ) }}" class="btn btn-md btn-default"  title="Visualiser la facture"><i class="fa fa-eye"></i></a>
                                </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            </table>
    </div>
</div> 
</div>
</section>
@endsection
@section('modal')
<div id="modal-create-facture" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Soumettre une nouvelle demande de paiement {{ $devi->numero_devis }}</h2>
            </div>
            <div class="modal-body">
                <form id="form-validation" method="POST"  action="{{route('facture.store')}}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="facture_id" id="facture_id_fictif"  value="{{ old('facture_id') }}">
                    <input type="hidden" id='devi_id' name="devi_id" value="{{ $devi->id }}">
            <div class="row">  
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-6" style="margin-left:0px;">
                    <label class="control-label" for="name">Montant de la facture : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input id="montant" type="text" class="form-control" name="montant_facture" placeholder="Montant de la facture" value="{{ old('montant_facture') }}" required autofocus onChange="verifier_montant('montant','devi_id','facture_id_fictif')">
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
                        <select id="mode_de_paiement" name="mode_de_paiement" class="form-control mode_de_paiement" onchange="changer_mode_de_paiement('mode_de_paiement','champ_paiement_cheque_ou_virement','champ_paiement_mobile','champ_paiement_cheque');" data-placeholder="" style="width: 100%;" required>
                            <option></option>
                            <option value="virement" >Par virement</option>
                            <option value="cheque" >Par chèque</option>
                            <option value="paiement_mobile" >Paiement mobile</option>
                        </select>
                </div>
            </div>
            
                <div class="row champ_paiement_cheque_ou_virement" >
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-4" style="margin-left:0px;">
                        <label class="control-label" for="name">Nom de la banque : <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input id="" type="text" class="form-control" name="nom_de_banque" placeholder="Le nom de la banque du fournisseur" value="{{ old('nom_de_banque') }}" >
                                <span class="input-group-addon"><i class="gi gi-user"></i></span>
                            @if ($errors->has('nom_de_banque'))
                            <span class="help-block">
                                <strong>{{ $errors->first('nom_de_banque') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-4" style="margin-left:0px;">
                        <label class="control-label" for="name">Numéro de compte : <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input id="" type="text" class="form-control" name="numero_de_compte" placeholder="Entrez le numéro de compte du fournisseur" value="{{ old('numero_de_compte') }}"  autofocus >
                                <span class="input-group-addon"><i class="gi gi-user"></i></span>
                            @if ($errors->has('designation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('numero_de_compte') }}</strong>
                            </span>
                            @endif
    
                        </div>
    
                    </div>   
                    <div class="form-group{{ $errors->has('copie_rib') ? ' has-error' : '' }} col-md-4" style="margin-left:10px;">
                        <label class="control-label" for="listedepresence">Joindre une copie du RIB <span class="text-danger">*</span></label>
                            <input class="form-control docsize col-md-6"  type="file" name="copie_rib" id="copie_rib" accept=".pdf, .jpeg, .png"   onchange="VerifyUploadSizeIsOK('facture_file');" placeholder="Charger une copie de fiche d'analyse des offres"  style="100%">
                        @if ($errors->has('copie_rib'))
                            <span class="help-block">
                                <strong>{{ $errors->first('copie_rib') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row champ_paiement_cheque">
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-8" style="margin-left:0px;">
                        <label class="control-label" for="name">Identité du bénéficiaire du chèque : <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input id="" type="text" class="form-control" name="identite_beneficiaire" placeholder="entrez l'identité du bénéficiaire du chèque" value="{{ old('identite_beneficiaire') }}" >
                                <span class="input-group-addon"><i class="gi gi-user"></i></span>
                            @if ($errors->has('identite_beneficiaire'))
                            <span class="help-block">
                                <strong>{{ $errors->first('identite_beneficiaire') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row champ_paiement_mobile" style="display: none">
                    <div class="form-group col-md-6" >
                        <label class="control-label " for="example-chosen">Type de paiement mobile<span class="text-danger">*</span></label>
                            <select id="type_de_paiement_mobile" name="type_de_paiement_mobile" class="form-control type_de_paiement_mobile"  data-placeholder="" style="width: 100%;" >
                                <option></option>
                            
                                @if($devi->entreprise->banque_id==2)
                                <option value="coris money" >Coris Money</option>
                                <option value="orange money" >Orange money</option>
                                <option value="mobicash" >Mobicash</option>
                                
                                @elseif($devi->entreprise->banque_id==3)
                                <option value="wiz all" >Wiz all</option>
                                <option value="orange money" >Orange money</option>
                                <option value="mobicash" >Mobicash</option>
                                @else
                                    <option value="orange money" >Orange money</option>
                                    <option value="mobicash" >Mobicash</option>
                                @endif

                            </select>
                    </div>
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-6" style="margin-left:0px;">
                        <label class="control-label" for="name">Numero de télephone : <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input id="" type="text" class="form-control" name="numero_de_telephone" placeholder="Entrez le numéro de téléphone" value="{{ old('numero_de_telephone') }}"  autofocus >
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
                                <input id="" type="text" class="form-control" name="nom_prenom_detenteur" placeholder="Nom et prénom du dententeur du numéro" value="{{ old('nom_prenom_detenteur') }}" >
                                <span class="input-group-addon"><i class="gi gi-user"></i></span>
                            @if ($errors->has('designation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('nom_prenom_detenteur') }}</strong>
                            </span>
                            @endif
    
                        </div>
                   
    
                    </div>
                </div>
                <div class="form-group{{ $errors->has('facture_file') ? ' has-error' : '' }} col-md-10" style="margin-left:10px;">
                    <label class="control-label" for="listedepresence">Copie du dossier de paiement<span class="text-danger">*</span></label>
                        <input class="form-control docsize col-md-6"  type="file" name="facture_file" id="facture_file" accept=".pdf, .jpeg, .png"   onchange="VerifyUploadSizeIsOK('facture_file');" placeholder="Joindre une copie du dossier de demande de paiement" required style="100%">
                    @if ($errors->has('facture_file'))
                        <span class="help-block">
                            <strong>{{ $errors->first('facture_file') }}</strong>
                        </span>
                    @endif
                </div>
        
        <div class="row" style="margin-left:20px">
            <div class="element" style="margin:20px 0px">
                <label>Joindre  l'images des biens-acquis</label>
                <input type="file" name="image1" id="upload_file1" accept=" .jpeg, .png" />
            </div>
            <div id="moreImageUpload"></div>
            <div class="clear"></div>
            <div id="moreImageUploadLink" style="display:none;margin-left: 10px;">
                <a href="javascript:void(0);" id="attachMore">Ajouter d'autres images</a>
            </div>
        </div>
            
            <input type="hidden" id="champ_nombre_dimage" name="champ_nombre_dimage"> 
                <div class="form-group form-actions">
                <div class="col-md-8 col-md-offset-4">
                    <a href="{{ route('profil.mesdevis') }}" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
                    <button type="submit" class="btn btn-sm btn-success soumettre_facture" ><i class="fa fa-arrow-right"></i> Soumettre</button>
                </div>
            </div>
            </form>
            </div>
           
        </div>
    </div>
</div>
<div id="modal-facture-edit" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Modifier la facture</h2>
            </div>
            <div class="modal-body">
                <form id="form-validation" method="POST"  action="{{ route('facture.enrg_modification') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                    {{ csrf_field() }}
                <div class="row">
                <div class="col-md-12">
                    <input type="hidden" name="facture_id" id="facture_id"  value="{{ old('facture_id') }}">
                    <input type="hidden" name="devi_id" value="{{ $devi->id }}">
                    <input type="hidden" name="fac_url" id="fac_url_u">
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-6" >
                        <label class="control-label" for="name">Statut : <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input id="statut" type="text" class="form-control" name="statut" disabled value="{{ old('montant_devis') }}">
                            </div>
                    </div>
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-6" >
                        <label class="control-label" for="name">Motif : <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <textarea id="motif" type="text" rows="2" cols="30" name="motif" disabled value="{{ old('montant_devis') }}"> </textarea>
                            </div>
                    </div>
                
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-6" >
                    <label class="control-label" for="name">Montant de la facture : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input id="montant_u" type="text" class="form-control" name="montant_facture" placeholder="Montant de la facture" value="{{ old('montant_facture') }}" required autofocus onChange="verifier_montant('montant_u','devi_id', 'facture_id')">
                            <span class="input-group-addon"><i class="gi gi-user"></i></span>
                        @if ($errors->has('designation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('montant_facture') }}</strong>
                        </span>
                        @endif
                    </div>
                <span class='depassement_du_montant_du_devis' style="color:red; display:none;"><p>Bien vouloir verifier le montant! Le total des montants des factures ne doit pas depasser le montant du devis.</p></span>
                <span class='condition_paiement_mobile' style="color:red; display:none;"><p>Impossible de faire de ce paiement. Les paiments mobiles ne doivent pas exceder 2 millions.</p></span>
                </div>
                <div class="form-group col-md-6" style="margin-left: 15px;">
                    <label class="control-label " for="example-chosen">Mode de paiement<span class="text-danger">*</span></label>
                        <select id="mode_de_paiement_u" name="mode_de_paiement" class="form-control mode_de_paiement_1"  onchange="changer_mode_de_paiement('mode_de_paiement_1','champ_paiement_cheque_ou_virement_u','champ_paiement_mobile_u');"  style="width: 100%;" required>
                            <option></option>
                            <option value="virement">Par virement</option>
                            <option value="cheque">Par chèque</option>
                            <option value="paiement_mobile" >Paiement mobile</option>
                        </select>
                </div>
                <div class="row champ_paiement_cheque_ou_virement_u" >
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-6" style="margin-left:0px;">
                        <label class="control-label" for="name">Nom de la banque : <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input id="nom_de_banque_u" type="text" class="form-control" name="nom_de_banque" placeholder="Nom et prénom du dententeur du numéro" value="{{ old('nom_de_banque') }}" >
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
                                <input id="numero_de_compte_u" type="text" class="form-control" name="numero_de_compte" placeholder="Entrez le numéro de la banque" value="{{ old('numero_de_compte') }}"  autofocus >
                                <span class="input-group-addon"><i class="gi gi-user"></i></span>
                            @if ($errors->has('designation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('numero_de_compte') }}</strong>
                            </span>
                            @endif
    
                        </div>
    
                    </div>
                    
                    
                </div>
                <div class="row champ_paiement_mobile_u" style="display: none">
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-6" style="margin-left:0px;">
                        <label class="control-label" for="name">Numero de télephone : <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input id="numero_de_telephone_u" type="text" class="form-control" name="numero_de_telephone" placeholder="Entrez le numéro de téléphone" value="{{ old('numero_de_telephone') }}"  autofocus >
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
                                <input id="detenteur_du_numero_u" type="text" class="form-control" name="nom_prenom_detenteur" placeholder="Nom de la banque" >
                                <span class="input-group-addon"><i class="gi gi-user"></i></span>
                            @if ($errors->has('designation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('nom_prenom_detenteur') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('facture_file') ? ' has-error' : '' }} col-md-6" >
                    <label class="control-label" for="listedepresence">Copie du dossier de paiement  <span class="text-success">*</span></label>
                        <input class="form-control docsize"  type="file" name="facture_file_u" id="facture_file_u" accept=".pdf, .jpeg, .png" max="{{ $devi->montant_devis }}"  onchange="VerifyUploadSizeIsOK('facture_file');" placeholder="Charger une copie du dossier de demande de paiement">
                    @if ($errors->has('facture_file_u'))
                        <span class="help-block">
                            <strong>{{ $errors->first('facture_file_u') }}</strong>
                        </span>
                    @endif
                </div>
                
                
            </div> 
            
          
         </div>
        <div class="row">
           
                

         
        </div>
                    <fieldset class="docs">
                        <legend>Visualiser la pièce </legend>
                    </fieldset> 
                   

                <div class="form-group form-actions">
                <div class="col-md-8 col-md-offset-4">
                    <a href="{{ route('profil.mesdevis') }}" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
                    <button type="submit" class="btn btn-sm btn-success soumettre_facture"><i class="fa fa-arrow-right"></i> Soumetter</button>
                </div>
            </div>
            </form>
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
                    {{-- <input type="hidden" id='facture_id' name="facture_id" value="{{ $facture->id }}"> --}}
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
    
   function changer_mode_de_paiement(mode_de_paiement,champ_paiement_cheque_ou_virement,champ_paiement_mobile, champ_paiement_cheque){
       var valeur= $('.'+mode_de_paiement).val();
       var montant= $('#montant').val();

     if(montant >  20000 && valeur=='paiement_mobile'){
        $('.'+condition_paiement_mobile).show();
     }
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
        $('.'+champ_paiement_mobile).hide();
        $('.'+champ_paiement_cheque).show();
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