@extends("layouts.espace_beneficiaire")
@section('devis', 'active')
@section('content')
<section class="wrapper">
        <h3><i class="fa fa-angle-right"></i> Mes devis</h3>
            <a href="#modal-create-devis" data-toggle="modal"  data-toggle="tooltip" title="Edit" class="btn btn-xs btn-success"><i class="fa fa-plus"></i>Nouveau devis</a>
        <div class="row mb">
          <!-- page start-->
          <div class="content-panel">
            <div class="adv-table">
        <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
            <thead>
                    <tr>
                        <th style="width: 5%">Numéro</th>
                        <th style="width: 5%">Statut</th>
                        <th style="width: 30%">Désignation</th>
                        <th style="width: 20%">Nom du presatataire</th>
                        <th style="width: 25%">Montant</th>
                        <th style="width: 15%">Actions</th>
                    </tr>
            </thead>
            <tbody>
                @php
                  $i=0;
                @endphp
                @foreach($devis as $devis)
                @php
                           $i++;
                        @endphp
                    <tr>
                        <td>{{ $devis->numero_devis }}</td>
                        <td>{{ $devis->statut }}</td>
                        <td>{{$devis->designation}}</td>
                        <td>{{$devis->prestataire->code_prestaire }} {{$devis->prestataire->nom_responsable }}{{$devis->prestataire->prenom_responsable }}</td>
                        <td>{{format_prix($devis->montant_devis)}}</td>
                        <td class="text-center">
                                <div class="btn-group">
                                 @if($devis->statut=='rejeté')
                                     <a onclick="edit_devis({{ $devis->id }});" href="#modal-devis-edit" data-toggle="modal"  data-toggle="tooltip" title="Edit" class="btn btn-md btn-default"><i class="fa fa-pencil"></i></a>
                                @endif
                                @if($devis->statut=='validé')
                                     <a href="{{ route('facture.liste', $devis) }}" data-toggle="modal"  data-toggle="tooltip" title="Demandes des paiements" class="btn btn-md btn-danger"><i class="fa fa-money"></i></a>
                                @endif
                                     <a onclick="edit_devis({{ $devis->id }});" href="#modal-devis-details" data-toggle="modal"  data-toggle="tooltip" title="Edit" class="btn btn-md btn-success"><i class="fa fa-eye"></i></a>
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
<div id="modal-create-devis" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Soumettre un nouveau devis</h2>
            </div>
            <div class="modal-body">
                <form id="form-validation" method="POST"  action="{{route('devi.store')}}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" id='entreprise_id' name="entreprise_id" value="{{ $entreprise->id }}">
            <div class="row">
                
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-6" style="margin-left:0px;">
                    <label class="control-label" for="name">Objet  : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input id="designation" type="text" class="form-control" name="designation" placeholder="Objet du devis" value="{{ old('montant_devis') }}" required autofocus>
                            <span class="input-group-addon"><i class="gi gi-user"></i></span>
                        @if ($errors->has('designation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('designation') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('fiche_analyse') ? ' has-error' : '' }} col-md-6" style="margin-left:10px;">
                    <label class="control-label" for="listedepresence">Fiche d'analyse <span class="text-danger">*</span></label>
                        <input class="form-control docsize col-md-6"  type="file" name="fiche_analyse" id="fiche_analyse" accept=".pdf, .jpeg, .png"   onchange="VerifyUploadSizeIsOK_lourd('fiche_analyse');" placeholder="Charger une copie de fiche d'analyse des offres" required style="100%">
                    @if ($errors->has('fiche_analyse'))
                        <span class="help-block">
                            <strong>{{ $errors->first('fiche_analyse') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('fiche_analyse') ? ' has-error' : '' }} col-md-6" style="margin-left:10px;">
                    <label class="control-label" for="fiche_de_description">Description de l'acquisition <span class="text-danger">*</span></label>
                    <textarea name="description" id="" cols="60" rows="4" required></textarea>
                    @if ($errors->has('description'))
                        <span class="help-block">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
                </div>
            
            </div>
            <fieldset >
                        <legend>Prestataire designé</legend>
                    <div class="row">
                        
                        <div class="form-group col-md-6" style="margin-left:10px;">
                                <label class=" control-label" for="example-chosen">Prestataires<span class="text-danger">*</span></label>
                                <div class="input-group col-md-12">
                                    <select  class="form-control select-select2" name="prestataire"  data-placeholder="Selectionner le prestataire .." style="width: 100%;" required>
                                        {{-- <option value="">Selectionner le prestataire</option><!-- Required for data-placeholder attribute to work with Chosen plugin --> --}}
                                        @foreach ($prestataires as  $prestataire)
                                            <option></option>
                                            <option value="{{ $prestataire->id  }}" {{ old('prestatataire') == $prestataire->id ? 'selected' : '' }}
                                                   > {{ $prestataire->nom_responsable }} {{ $prestataire->prenom_responsable }} / {{ $prestataire->code_prestaire }} </option>
                                        @endforeach
                                    </select>
                                  </div>
                        </div>
 
                        <div class="form-group{{ $errors->has('copie_devis') ? ' has-error' : '' }} col-md-6" style="margin-left:10px;">
                            <label class="control-label" for="listedepresence">Joindre le devis <span class="text-danger">*</span></label>
                            <input class="form-control col-md-6" type="file"   name="copie_devis" id="copie_devis" accept="image/jpeg,image/gif,image/png,application/pdf"  onchange="VerifyUploadSizeIsOK_lourd('copie_devis');"   placeholder="Charger une copie de fiche d'analyse des offres" required style="100%">
                            @if ($errors->has('copie_devis'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('copie_devis') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-6" style="margin-left:10px;">
                            <label class="control-label" for="name">Montant du devis<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input id="montant_devis" type="text" class="form-control" name="montant_devis" placeholder="Saisir le montant" value="{{ old('montant_devis') }}" onchange="verifier_montant_devis('montant_devis','entreprise_id')"  required autofocus>
                                    <span class="input-group-addon"><i class="gi gi-money"></i></span>
                                @if ($errors->has('montant_devis'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('montant_devis') }}</strong>
                                </span>
                                @endif
                            </div>
                            <span class='depassement_du_montant_du_devis' style="color:red; display:none;"><p>Vous ne pouvez plus deposer un devis de ce montant. Verifier la disponibilité des fond à votre niveau: le paiement de l'accompte</p></span>
                        </div>
                        <input type="hidden" id="montant_devi_cache">
                        {{-- <div id="avance_exige_div" class="form-group{{ $errors->has('avance_exige') ? ' has-error' : '' }} col-md-6" style="margin-left:10px;">
                            <label class="control-label" for="avance_exige">Avance demandée<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input id="avance_exige" type="text"  class="form-control" name="avance_exige" placeholder="Renseigner l'avance demandée par le prestataire" value="{{ old('avance_exige') }}" onchange="calculer_pourcentage('avance_exige','montant_devis','montant_devi_cache','avance_exige_div')" required autofocus>
                                    <span class="input-group-addon"><i class="gi gi-money"></i></span>
                                @if ($errors->has('avance_exige'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('avance_exige') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div> --}}
                    <div id="" class="form-group{{ $errors->has('nombre_depaiement') ? ' has-error' : '' }} col-md-6" style="margin-left:10px;">
                        <label class="control-label" for="nombre_depaiement">Nombre de paiement<span class="text-danger">*</span></label>
                        <select   id="nombre_depaiement" name="nombre_depaiement" required class="form-control" style="width: 100%;" tabindex="-1" aria-hidden="true">
                            <option value="">Selectionner le nombre de paiement souhaité</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            {{-- <option value="3">3</option> --}}
                        </select>
                           
                    </div>
                    
                    <div class="form-group{{ $errors->has('avance_exige') ? ' has-error' : '' }} col-md-6" style="margin-left:10px;">
                        <label class="control-label" for="nom_bank_prestataire">Banque du prestataire<span class="text-success">*</span></label>
                            <div class="input-group">
                                <input id="nom_bank_prestataire" type="text" class="form-control" name="nom_bank_prestataire" placeholder="Le nom de la banque du prestataire" value="{{ old('nom_bank_prestataire') }}"  >
                                <span class="input-group-addon"><i class="gi gi-user"></i></span>
                            @if ($errors->has('avance_exige'))
                            <span class="help-block">
                                <strong>{{ $errors->first('avance_exige') }}</strong>
                            </span>
                            @endif
                        </div>
                </div> 
                
                <div class="form-group{{ $errors->has('num_compte') ? ' has-error' : '' }} col-md-6" style="margin-left:10px;">
                    <label class="control-label" for="num_compte">Numéro de compte<span class="text-sucess">*</span></label>
                        <div class="input-group">
                            <input id="compte_bank_prestataire" type="text" class="form-control" name="compte_bank_prestataire" placeholder="Le numéro de compte du prestataire" value="{{ old('num_compte') }}" >
                            <span class="input-group-addon"><i class="gi gi-user"></i></span>
                        @if ($errors->has('compte_bank_prestataire'))
                        <span class="help-block">
                            <strong>{{ $errors->first('compte_bank_prestataire') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                    </div>           
                    </fieldset>
                    <fieldset>
                        <legend>Autre devis</legend>
                    <div class="row">
                        <div class="form-group{{ $errors->has('copie_devis1') ? ' has-error' : '' }} col-md-6" style="margin-left:10px;">
                            <label class="control-label" for="listedepresence">Joindre le devis 1 <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input class="form-control col-md-6" type="file" name="copie_devis1" onchange="VerifyUploadSizeIsOK_lourd('copie_devis1');"  id="copie_devis1" accept=".pdf, .jpeg, .png"   placeholder="Charger une copie de fiche d'analyse des offres" required>
                                <span class="input-group-addon"><i class="gi gi-user"></i></span>
                            </div>
                            @if ($errors->has('copie_devis1'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('copie_devis1') }}</strong>
                                </span>
                                @endif
                        </div>
                        <div class="form-group{{ $errors->has('copie_devis2') ? ' has-error' : '' }} col-md-5" style="margin-left:10px;">
                            <label class="control-label" for="listedepresence">Joindre le devis 2 <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input class="form-control" type="file" name="copie_devis2" id="copie_devis2" onchange="VerifyUploadSizeIsOK_lourd('copie_devis2');"  accept=".pdf, .jpeg, .png"   placeholder="Charger une copie de fiche d'analyse des offres" required>
                                <span class="input-group-addon"><i class="gi gi-user"></i></span>
                            </div>
                            @if ($errors->has('copie_devis2'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('copie_devis2') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                        
                    </fieldset>
                    
                <div class="form-group form-actions">
                <div class="col-md-8 col-md-offset-4">
                    <a href="{{ route('profil.mesdevis') }}" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
                    <button type="submit" class="btn btn-sm btn-success soumettre_facture"><i class="fa fa-arrow-right"></i> Soumettre</button>
                </div>
            </div>
            </form>
            </div>
            <!-- END Modal Body  modal-devis-edit -->
        </div>
    </div>
</div>
<div id="modal-devis-edit" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Modifier le devis</h2>
            </div>
            <div class="modal-body">
                <form id="form-validation" method="POST"  action="{{ route('devi.enrg_modification') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="devi_id" id="devi_id"  value="{{ old('devi_id') }}">
                    <input type="hidden" name="entreprise_id" id="entreprise_id_u"  value="{{$entreprise->id}}">
            <div class="row">
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-6" style="margin-left:0px;">
                    <label class="control-label" for="name">Statut : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input id="statut" type="text" class="form-control" name="statut" disabled value="{{ old('montant_devis') }}">
                        </div>
                </div>
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-6" style="margin-left:0px;">
                    <label class="control-label" for="name">Motif : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <textarea id="motif" type="text" rows="2" cols="55" name="motif" disabled value="{{ old('montant_devis') }}"> </textarea>
                        </div>
                </div>
                {{-- <div class="form-group col-md-4" style="margin-left:10px;">
                    <label class=" control-label" for="example-chosen">Investissement<span class="text-danger">*</span></label>
                    <div class="input-group col-md-12">
                        <select id='valeur_id'class=" form-control" tabindex="-1" aria-hidden="true" name="ligne_invest" required>
                            <option value="">Selectionner la ligne concernée</option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                            @foreach ($ligne_projets as  $ligne_projet)
                                    <option value="{{ $ligne_projet->id  }}" {{ old('prestatataire') == $ligne_projet->id ? 'selected' : '' }}
                                     > {{ getlibelle($ligne_projet->designation)}}</option>
                            @endforeach
                        </select>
                      </div>
                 </div> --}}
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-6" style="margin-left:0px;">
                    <label class="control-label" for="name">Objet : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input id="designation_u" type="text" class="form-control" name="designation" placeholder="Objet du devis" value="{{ old('montant_devis') }}" required autofocus>
                            <span class="input-group-addon"><i class="gi gi-user"></i></span>
                        @if ($errors->has('designation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('designation') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('fiche_analyse') ? ' has-error' : '' }} col-md-6" style="margin-left:10px;">
                    <label class="control-label" for="listedepresence">Fiche d'analyse <span class="text-danger">*</span></label>
                        <input class="form-control docsize"   type="file" name="fiche_analyse" id="fiche_analyse"    onchange="VerifyUploadSizeIsOK_lourd('fiche_analyse');" placeholder="Charger une copie de fiche d'analyse des offres">
                    @if ($errors->has('fiche_analyse'))
                        <span class="help-block">
                            <strong>{{ $errors->first('fiche_analyse') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('fiche_analyse') ? ' has-error' : '' }} col-md-6" style="margin-left:10px;">
                    <label class="control-label" for="fiche_de_description">Description de l'acquisition <span class="text-danger">*</span></label>
                    <textarea name="description" id="" cols="60" rows="4" required></textarea>
                    @if ($errors->has('description'))
                        <span class="help-block">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <fieldset >
                        <legend>Prestataire designé</legend>
                    <div class="row">
                        <div class="form-group col-md-6"   style="margin-left:10px;">
                            <label class=" control-label" for="example-chosen">Prestataires<span class="text-danger">*</span></label>
                            <div class="input-group col-md-12">
                                <select   id="pres" name="prestataire" required class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                    <option value="">Selectionner le prestataire</option>
                                    @foreach ($prestataires as  $prestataire)
                                            <option value="{{ $prestataire->id }}"> {{ $prestataire->nom_responsable }} {{ $prestataire->prenom_responsable }} / {{ $prestataire->code_prestaire }} </option>
                                    @endforeach
                                </select>
                              </div>
                        </div>
                        <div class="form-group{{ $errors->has('copie_devis') ? ' has-error' : '' }} col-md-6" style="margin-left:10px;">
                            <label class="control-label" for="listedepresence">Joindre le devis <span class="text-danger">*</span></label>
                            <input class="form-control" type="file" name="copie_devis" id="copie_devis" accept=".pdf, .jpeg, .png" onchange="VerifyUploadSizeIsOK_lourd('copie_devis');"   placeholder="Charger une copie de fiche d'analyse des offres" style="width: 100%">
                            @if ($errors->has('copie_devis'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('copie_devis') }}</strong>
                                </span>
                            @endif
                        
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-6" style="margin-left:10px;">
                            <label class="control-label" for="name">Montant du devis<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input id="montant_devis_u" type="text" class="form-control" name="montant_devis" placeholder="Saisir le montant" value="{{ old('montant_devis') }}" onchange="verifier_montant_devis('montant_devis_u','entreprise_id_u','devi_id')"  required autofocus>
                                    <span class="input-group-addon"><i class="gi gi-money"></i></span>
                                @if ($errors->has('montant_devis'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('montant_devis_u') }}</strong>
                                </span>
                                @endif
                            </div>
                            <span class='depassement_du_montant_du_devis' style="color:red; display:none;"><p>Vous ne pouvez plus deposer un devis de ce montant. Verifier la disponibilité des fond à votre niveau: le paiement de l'accompte</p></span>
                        </div>
                        {{-- <div id="avance" class="form-group{{ $errors->has('avance_exige') ? ' has-error' : '' }} col-md-6" style="margin-left:10px;">
                            <label class="control-label" for="avance_exige">Avance demandée<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input id="avance_exige_u" type="text" class="form-control money" name="avance_exige" onchange="calculer_pourcentage('avance_exige_u','montant_devis_u','montant_devis_cache','avance')" placeholder="Renseigner l'avance demandée par le prestataire" value="{{ old('avance_exige') }}" required autofocus>
                                    <span class="input-group-addon"><i class="gi gi-money"></i></span>
                                @if ($errors->has('avance_exige'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('avance_exige') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div> --}}
                    <div id="" class="form-group{{ $errors->has('nbre_paiement') ? ' has-error' : '' }} col-md-6" style="margin-left:10px;">
                        <label class="control-label" for="nbre_paiement">Nombre de paiement<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input id="nbre_paiement_u" type="number" min="0" max="3" class="form-control" name="nbre_paiement" placeholder="Le nombre de paiement souhaité " required autofocus>
                            <span class="input-group-addon"><i class="gi gi-user"></i></span>
                            @if ($errors->has('nbre_paiement'))
                            <span class="help-block">
                                <strong>{{ $errors->first('nbre_paiement') }}</strong>
                            </span>
                        @endif
                        </div>
           
                </div>
                    <div class="form-group{{ $errors->has('avance_exige') ? ' has-error' : '' }} col-md-6" style="margin-left:10px;">
                        <label class="control-label" for="nom_bank_prestataire">Banque du prestataires<span class="text-success">*</span></label>
                            <div class="input-group">
                                <input id="nom_bank_prestataire_u" type="text" class="form-control" name="nom_bank_prestataire" placeholder="Le nom de la banque du prestataire"   >
                                <span class="input-group-addon"><i class="gi gi-user"></i></span>
                            @if ($errors->has('nom_bank_prestataire'))
                            <span class="help-block">
                                <strong>{{ $errors->first('nom_bank_prestataire') }}</strong>
                            </span>
                            @endif
                        </div>
                </div>
                <input type="hidden" id="montant_devis_cache">
                <div class="form-group{{ $errors->has('num_compte') ? ' has-error' : '' }} col-md-6" style="margin-left:10px;">
                    <label class="control-label" for="num_compte">Numéro de compte<span class="text-sucess">*</span></label>
                        <div class="input-group">
                            <input id="compte_bank_prestataire_u" type="text" class="form-control" name="compte_bank_prestataire" placeholder="Le numéro de compte du prestataire" value="{{ old('num_compte') }}" >
                            <span class="input-group-addon"><i class="gi gi-user"></i></span>
                        @if ($errors->has('compte_bank_prestataire'))
                        <span class="help-block">
                            <strong>{{ $errors->first('compte_bank_prestataire') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                    </div>           
                    </fieldset>
                    <fieldset>
                        <legend>Autre devis</legend>
                    <div class="row">
                        <div class="form-group{{ $errors->has('copie_devis1') ? ' has-error' : '' }} col-md-6" style="margin-left:10px;">
                            <label class="control-label" for="listedepresence">Joindre le devis 1 <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input class="form-control col-md-6" type="file" name="copie_devis1" onchange="VerifyUploadSizeIsOK_lourd('copie_devis1');"  id="copie_devis1" accept=".pdf, .jpeg, .png"   placeholder="Charger une copie de fiche d'analyse des offres">
                                <span class="input-group-addon"><i class="gi gi-user"></i></span>
                            </div>
                            @if ($errors->has('copie_devis1'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('copie_devis1') }}</strong>
                                </span>
                                @endif
                        </div>
                        <div class="form-group{{ $errors->has('copie_devis2') ? ' has-error' : '' }} col-md-5" style="margin-left:10px;">
                            <label class="control-label" for="listedepresence">Joindre le devis 2 <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input class="form-control" type="file" name="copie_devis2" id="copie_devis2" onchange="VerifyUploadSizeIsOK_lourd('copie_devis2');"  accept=".pdf, .jpeg, .png"   placeholder="Charger une copie de fiche d'analyse des offres">
                                <span class="input-group-addon"><i class="gi gi-user"></i></span>
                            </div>
                            @if ($errors->has('copie_devis2'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('copie_devis2') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    </fieldset>
                    <fieldset class="docs">
                        <legend>Visualiser les documents</legend>
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
<div id="modal-devis-details" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Detail sur le devis</h2>
            </div>
            <div class="modal-body">
                <div class="row col-md-offset-2">
                    <label class="col-md-3 control-label">Désignation : </label> <div class="col-md-8"><span id="designation_v"></span></div>
                </div>
                <div class="row col-md-offset-2">
                    <label class="col-md-3 control-label">Description : </label> <div class="col-md-8"><span id="description_v"></span></div>
                </div>

                <div class="row col-md-offset-2">
                    <label class="col-md-3 control-label">Pestataire : </label> <div class="col-md-8"> <span  id="nom_prestataire_v"></span></div>
                </div>

                <div class="row col-md-offset-2">
                        <label class="col-md-3 control-label">Montant du devis : </label> <div class="col-md-8"> <span  id="montant_devis_cache_v"></span></div>
                </div>
                <div class="row col-md-offset-2">
                        <label class="col-md-3 control-label">Avance demandée : </label> <div class="col-md-8"> <span  id="avance_exige_v"></span></div>
                </div>
                <div class="row col-md-offset-2">
                    <label class="col-md-3 control-label">Nom de la Banque : </label> <div class="col-md-8"> <span  id="nom_bank_prestataire_v"></span></div>
            </div>

                <div class="row col-md-offset-2">
                        <label class="col-md-3 control-label">Num de compte : </label> <div class="col-md-8"> <span  id="compte_bank_prestataire_v"></span></div>
                </div>
                <fieldset class="docs">
                    <legend>Visualiser les documents</legend>
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
function update_champ(valeur_id, montant_devis){
   var invest_id = $("#"+valeur_id).val();
    var url = "{{ route('devi.get_montant') }}";
                $.ajax({
                    url: url,
                    type:'GET',
                    dataType:'json',
                    data: {invest_id: invest_id} ,
                    error:function(){alert('error');},
                    success:function(data){
                        $("#"+montant_devis).val(data);
                    }
                });
}
    function edit_devis(id){
                var id=id;
                var url = "{{ route('devi.modif') }}";
                $.ajax({
                    url: url,
                    type:'GET',
                    dataType:'json',
                    data: {id: id} ,
                    error:function(){alert('error');},
                    success:function(data){
                        $("#devi_id").val(data.id);
                       $("#designation_u").val(data.designation);
                       var prestataire_id= data.prestataire;
                       $("#pres option[value="+prestataire_id+"]").attr('selected', 'selected');
                       $('.select2').select2({
                        });
                       $('#val').text(data.nom_complet);
                       $("#montant_devis_u").val(data.montant_devis);
                       $("#montant_devis_cache").val(data.montant_devis_cache);
                       $("#avance_exige_u").val(data.montant_avance);
                       $("#nbre_paiement_u").val(data.nbre_paiement);
                       $("#compte_bank_prestataire_u").val(data.compte_bank_prestataire);
                       $("#nom_bank_prestataire_u").val(data.nom_bank_prestataire);
                       $("#description_u").val(data.description);
                       $("#statut").val(data.statut);
                       $("#motif").val(data.motif+' '+ data.observation);
                        $('#pres option[value="' + prestataire_id +'"]').attr('selected', true);
                       var rout_fiche= '{{ route("telechargerdevis",":url")}}?file=fiche';
                       var rout_devi= '{{ route("telechargerdevis",":url")}}?file=devi';
                       var rout_devi1= '{{ route("telechargerdevis",":url")}}?file=devi1';
                       var rout_devi2= '{{ route("telechargerdevis",":url")}}?file=devi2';
                       var rout_fiche = rout_fiche.replace(':url', data.id);
                       var rout_devi = rout_devi.replace(':url', data.id);
                       var rout_devi1 = rout_devi1.replace(':url', data.id);
                       var rout_devi2 = rout_devi2.replace(':url', data.id);
                       p1 = '<p style="color:green">'  + '<a href="'+rout_fiche+'" data-toggle="tooltip" title="Telecharger" target="_blank">Visuliser la fiche analyse</a>';
                       p2 = '<p>'  + '<a href="'+rout_devi+'" data-toggle="tooltip" title="Telecharger" target="_blank">Visuliser la devis preferé </a>';
                        p3 = '<p>'  + '<a href="'+rout_devi1+'" data-toggle="tooltip" title="Telecharger" target="_blank">Visuliser le premier devis</a>';
                        p4 = '<p>'  + '<a href="'+rout_devi2+'" data-toggle="tooltip" title="Telecharger" target="_blank">Visuliser le deuxième devis</a>';
                        $('.docs').append(p1);
                        $('.docs').append(p2);
                        $('.docs').append(p3);
                        $('.docs').append(p4);
                       $("#designation_v").text(data.designation);
                       $("#nom_prestataire_v").text(data.nom_prestataire);
                       $("#montant_devis_v").text(data.montant_devis);
                       $("#montant_devis_cache_v").text(data.montant_devis_cache);
                       $("#avance_exige_v").text(data.montant_avance);
                       $("#description_v").text(data.description);
                       $("#compte_bank_prestataire_v").text(data.compte_bank_prestataire);
                       $("#nom_bank_prestataire_v").text(data.nom_bank_prestataire);
                       $("#statut_v").text(data.statut);
                       $("#motif_v").text(data.motif);
                     
                    }
                });
        }
</script>