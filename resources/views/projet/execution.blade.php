@extends('layouts.admin')
@section('pca', 'active')
@section('analyse', 'active')
@section('content')

<hr>
<div class="row">
    <div class="col-md-6">
        <div class="block">
        <div class="block-title">
            <div class="block-options pull-right">
                <a onclick="window.history.back();" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Fermer</a>
                {{-- @if($projet->statut=='selectionné')
                <a href="#modal-save-desistement" data-toggle="modal" title="Enregistrer un désistement" class="btn btn-md btn-danger"><i class="fa fa-times"></i> Desister </a>
                @endif
                @if($projet->statut=='rejeté')
                  <a href="#modal-save-repeche" data-toggle="modal" title="Enregistrer un désistement" class="btn btn-md btn-danger"><i class="fa fa-times"></i> Repecher le PCA </a>
                @endif --}}
                {{-- <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default toggle-bordered enable-tooltip" data-toggle="button" title="Toggles .form-bordered class"></a> --}}
            </div>
            <h2><strong>Detail</strong> sur le plan de continuité des Activité</h2>
        </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                        <label>Coach :</label>
                        </div>
                        <div class="col-sm-7 mb-3 mb-sm-0">
                        <label class="fb"> {{$projet->coach->nom}} {{$projet->coach->prenom}}</label>
                        </div>
                    </div>
            
                    <div class="form-group row">
                        <div class="col-md-4">
                          <label>Titre du projet :</label>
                        </div>
                        <div class="col-sm-7 mb-3 mb-sm-0">
                          <label class="fb"> {{$projet->titre_du_projet}}</label>
                        </div>
                      </div>

                      <div class="form-group row">
                          <div class="col-sm-4">
                            <label>Coût total du projet :</label>
                          </div>
                          <div class="col-sm-7 mb-3 mb-sm-0">
                            <label class="fb"> {{ format_prix($projet->investissements->sum('montant'))   }} </label>
                          </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-4">
                      <label>Coût total du projet validé:</label>
                    </div>
                    <div class="col-sm-7 mb-3 mb-sm-0">
                      <label class="fb"> {{ format_prix($projet->investissementvalides->sum('montant_valide'))   }} </label>
                    </div>
                </div>
                  <div class="form-group row">
                    <div class="col-sm-4">
                      <label>Subvention demandée:</label>
                    </div>
                    <div class="col-sm-7 mb-3 mb-sm-0">
                      <label class="fb"> {{ format_prix($projet->investissements->sum('subvention_demandee'))   }} </label>
                    </div>
                 </div>
                 <div class="form-group row">
                    <div class="col-sm-4">
                      <label>Apport personnel :</label>
                    </div>
                    <div class="col-sm-7 mb-3 mb-sm-0">
                      <label class="fb"> {{ format_prix($projet->investissements->sum('apport_perso'))   }} </label>
                    </div>
                 </div>
                      <div class="form-group row">
                        <div class="col-sm-4">
                          <label>Les objectifs :</label>
                        </div>
                        <div class="col-sm-8 mb-3 mb-sm-0">
                          <label class="fb"> {{ $projet->objectifs }} </label>
                        </div>
                      </div>
                      
                      <div class="form-group row">
                          <div class="col-sm-4">
                            <label>Les activités ménées :</label>
                          </div>
                          <div class="col-sm-8 mb-3 mb-sm-0">
                            <label class="fb"> {{ $projet->activites_menees }} </label>
                          </div>
                      </div>
                      <div class="form-group row">
                          <div class="col-sm-4">
                            <label>Les Atouts du projet :</label>
                          </div>
                          <div class="col-sm-8 mb-3 mb-sm-0">
                            <label class="fb"> {{  $projet->innovation }}</label>
                          </div>
                      </div>
    </div>
</div>
<div class="col-md-6">
    <div class="block">
    <div class="block-title">
     <table class="table table-vcenter table-condensed table-bordered  valdetail"   >
        <thead>
        <h4>Les investissements</h4>
                <tr
                
                >
                    <th>N°</th>
                    <th>Designation</th>
                    <th>Coût total</th>
                    <th>Subvention Demandée</th>
                    <th>Apport Personnel</th>
                    <th>Coût du projet validé</th>
                    <th>Subvention Accordée</th>
                    <th>Actions</th>
                </tr>
          </thead>
          <tbody id="tbadys">
    @foreach($projet->investissements as $key => $investissement)
    <tr 
        @if($investissement->statut == 'validé' )
        style="color:green;"
        @elseif($investissement->statut == 'rejeté')
        style="color:red;"
        @endif
    >
            <td>
            {{ $key + 1 }}
            </td>
                 <td>
                    {{getlibelle($investissement->designation)}}
                </td>
                <td>
                    {{format_prix($investissement->montant)}}
                </td>
                <td>
                    {{format_prix($investissement->apport_perso)}}
                </td>
                <td>
                    {{format_prix($investissement->subvention_demandee)}}
                </td>
                <td>
                    {{format_prix($investissement->montant_valide)}}
                </td>
                <td>
                    {{format_prix($investissement->subvention_demandee_valide)}}
                </td>
    <td>
        {{-- <a href="#"title="télécharger" class="btn btn-xs btn-default"  target="_blank"><i class="fa fa-download"></i> </a>
        <a href="#"title="Visualiser le document" class="btn btn-xs btn-default" ><i class="fa fa-eye"></i> </a> --}}
    </td>

</tr>
@endforeach
</tbody>
</table>
</div>
</div>                
<hr>
</div>
</div>       
<div class="row">
    <div class="col-md-6">
        <div class="block">
            <div class="block-title">
                <div class="block-options pull-right">
                    <a href="#modal-create-devis" data-toggle="modal" title="Enregistrer un désistement" class="btn btn-md btn-success"><i class="fa fa-plus"></i> Ajouter Devis </a>
                </div>
                <h3>Liste des devis soumis</h3>
          </div>
        <div class="table-responsive">
            <table class="table table-vcenter table-condensed table-bordered listepdf valdetail"   >
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
                        @foreach($devis as $devi)
                        @php
                                   $i++;
                                @endphp
                            <tr>
                                <td>{{ $devi->numero_devis }}</td>
                                <td>{{ $devi->statut }}</td>
                                <td>{{$devi->designation}}</td>
                                <td>{{$devi->prestataire->code_prestaire }} {{$devi->prestataire->nom_responsable }}{{$devi->prestataire->prenom_responsable }}</td>
                                <td>{{format_prix($devi->montant_devis)}}</td>
                                <td class="text-center">
                                        <div class="btn-group">
                                         @if($devi->statut=='rejeté')
                                             <a onclick="edit_devis({{ $devi->id }});" href="#modal-devis-edit" data-toggle="modal"  data-toggle="tooltip" title="Edit" class="btn btn-md btn-default"><i class="fa fa-pencil"></i></a>
                                        @endif
                                        @if($devi->statut=='validé')
                                             <a href="{{ route('facture.liste', $devi) }}" data-toggle="modal"  data-toggle="tooltip" title="Demandes des paiements" class="btn btn-md btn-danger"><i class="fa fa-money"></i></a>
                                        @endif
                                             <a href="{{ route('devi.show', $devi) }}" data-toggle="modal"  data-toggle="tooltip" title="Edit" class="btn btn-md btn-success"><i class="fa fa-eye"></i></a>
                                        </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
    </table>
          </div>
    </div>
</div>
<div class="col-md-6">
    <div class="block">
    <div class="block-title">
        <div class="block-options pull-right">
            <a href="#modal-create-facture" data-toggle="modal" title="Enregistrer un désistement" class="btn btn-md btn-success"><i class="fa fa-plus"></i> Ajouter facture </a>
        </div>
        <h3>Liste des Factures soumises</h3>
  </div>
  
    <div class="table-responsive">
        <table class="table table-vcenter table-condensed table-bordered listepdf valdetail"   >
            <thead>
                <tr>
                    <th style="width: 5%">N</th>
                    <th style="width: 5%">Devis concerne</th>
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
                    <td>{{ $facture->devi->numero_devis }}</td>
                    <td>{{ $facture->num_facture }}</td>
                    <td>{{ $facture->statut }}</td>
                    <td>{{ $facture->mode_de_paiement }}</td>
                    <td>{{format_prix($facture->montant)}}</td>
                    <td class="text-center">
                            <div class="btn-group">
                             @if($facture->statut=='rejeté') 
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
</div>

@endsection
@section('modal_part')
<div id="modal-devis-edit" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Modifier un devis</h2>
            </div>
            <div class="modal-body" style="margin-left:15px;">
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
                <div class="form-group{{ $errors->has('fiche_analyse') ? ' has-error' : '' }} col-md-5" style="margin-left:10px;">
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
                    <textarea name="description" id="description_u" cols="60" rows="4" required></textarea>
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
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-5" style="margin-left:10px;">
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
                        <div id="" class="form-group{{ $errors->has('nbre_paiement') ? ' has-error' : '' }} col-md-4" style="margin-left:10px;">
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
                        <div class="form-group{{ $errors->has('copie_devis') ? ' has-error' : '' }} col-md-7" style="margin-left:10px;">
                            <label class="control-label" for="listedepresence">Joindre le devis <span class="text-danger">*</span></label>
                            <input class="form-control" type="file" name="copie_devis" id="copie_devis" accept=".pdf, .jpeg, .png" onchange="VerifyUploadSizeIsOK_lourd('copie_devis');"   placeholder="Charger une copie de fiche d'analyse des offres" style="width: 100%">
                            @if ($errors->has('copie_devis'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('copie_devis') }}</strong>
                                </span>
                            @endif
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
                <div class="form-group{{ $errors->has('num_compte') ? ' has-error' : '' }} col-md-5" style="margin-left:10px;">
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
<div id="modal-create-devis" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Enregistrer un devis</h2>
            </div>
            <div class="modal-body" style="margin-left:15px;">
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
                <div class="form-group{{ $errors->has('fiche_analyse') ? ' has-error' : '' }} col-md-5" style="margin-left:5px;">
                    <label class="control-label" for="listedepresence">Fiche d'analyse <span class="text-danger">*</span></label>
                        <input class="form-control docsize col-md-6"  type="file" name="fiche_analyse" id="fiche_analyse_c" accept=".pdf, .jpeg, .png"   onchange="VerifyUploadSizeIsOK_lourd('fiche_analyse_c');" placeholder="Charger une copie de fiche d'analyse des offres" required style="100%">
                    @if ($errors->has('fiche_analyse'))
                        <span class="help-block">
                            <strong>{{ $errors->first('fiche_analyse') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('fiche_analyse') ? ' has-error' : '' }} col-md-6" style="margin-left:10px;">
                    <label class="control-label" for="fiche_de_description">Description de l'acquisition <span class="text-danger">*</span></label>
                    <textarea name="description" id="description" cols="60" rows="4" required></textarea>
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
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-5" style="margin-left:10px;">
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
                        <div id="" class="form-group{{ $errors->has('nombre_depaiement') ? ' has-error' : '' }} col-md-4" style="margin-left:10px;">
                            <label class="control-label" for="nombre_depaiement">Nombre de paiement<span class="text-danger">*</span></label>
                            <select   id="nombre_depaiement" name="nombre_depaiement" required class="form-control" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option value="">Selectionner le nombre de paiement souhaité</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option> 
                            </select>
                        </div>
                        <div class="form-group{{ $errors->has('copie_devis') ? ' has-error' : '' }} col-md-7" style="margin-left:10px;">
                            <label class="control-label" for="listedepresence">Joindre le devis <span class="text-danger">*</span></label>
                            <input class="form-control col-md-6" type="file"   name="copie_devis" id="copie_devis_c" accept="image/jpeg,image/gif,image/png,application/pdf"  onchange="VerifyUploadSizeIsOK_lourd('copie_devis_c');"   placeholder="Charger une copie de fiche d'analyse des offres" required style="100%">
                            @if ($errors->has('copie_devis'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('copie_devis') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <input type="hidden" id="montant_devi_cache">
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
                
                <div class="form-group{{ $errors->has('num_compte') ? ' has-error' : '' }} col-md-5" style="margin-left:10px;">
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
                                <input class="form-control col-md-6" type="file" name="copie_devis1" onchange="VerifyUploadSizeIsOK_lourd('copie_devis1_c');"  id="copie_devis1_c" accept=".pdf, .jpeg, .png"   placeholder="Charger une copie de fiche d'analyse des offres" required>
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
                                <input class="form-control" type="file" name="copie_devis2" id="copie_devis2_c" onchange="VerifyUploadSizeIsOK_lourd('copie_devis2_c');"  accept=".pdf, .jpeg, .png"   placeholder="Charger une copie de fiche d'analyse des offres" required>
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

<div id="modal-create-facture" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Enregistrer une demande de paiement</h2>
            </div>
            <div class="modal-body" style="margin-left:15px;">
                <form id="form-validation" method="POST"  action="{{route('facture.store')}}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                    {{ csrf_field() }}
                
            <div class="row"> 
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-8" style="margin-left:0px;">
                    <label class="control-label" for="name">Selectionne le devis concerne : <span class="text-danger">*</span></label> 
                    <select name="devi_id" id="devi_id_create"  class="select-select2" style="width: 100%;">
                        @foreach ($devis as $devi )
                            <option value="{{  $devi->id }}">{{ $devi->numero_devis }} - {{ $devi->designation }} </option>
                        @endforeach
                    </select>
                </div> 
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-6" style="margin-left:0px;">
                    <label class="control-label" for="name">Montant de la facture : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input id="montant" type="text" class="form-control" name="montant_facture" placeholder="Montant de la facture" value="{{ old('montant_facture') }}" required autofocus onChange="verifier_montant('montant','devi_id_create','facture_id_fictif')">
                            <span class="input-group-addon"><i class="gi gi-money"></i></span>
                        @if ($errors->has('designation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('montant_facture') }}</strong>
                        </span>
                        @endif

                    </div>
                <span class='depassement_du_montant_du_devis' style="color:red; display:none;"><p>Bien vouloir verifier le montant! Le total des montants des factures ne doit pas depasser le montant du devis.</p></span>

                </div>
                <div class="form-group col-md-5" style="margin-left: 15px;">
                    <label class="control-label " for="example-chosen">Mode de paiement<span class="text-danger">*</span></label>
                        <select id="mode_de_paiement"  name="mode_de_paiement" class=" form-control select-select2 mode_de_paiement" onchange="changer_mode_de_paiement('mode_de_paiement','champ_paiement_cheque_ou_virement','champ_paiement_mobile','champ_paiement_cheque');" data-placeholder="" style="width: 100%;" required>
                            <option></option>
                            <option value="virement" >Par virement</option>
                            <option value="cheque" >Par chèque</option>
                            <option value="paiement_mobile" >Paiement mobile</option>
                        </select>
                </div>
            </div>
            
                <div class="row champ_paiement_cheque_ou_virement" >
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-6" style="margin-left:0px;">
                        <label class="control-label" for="name">Nom de la banque : <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input id="" type="text" class="form-control" name="nom_de_banque" placeholder="Le nom de la banque du fournisseur" value="{{ old('nom_de_banque') }}" >
                                <span class="input-group-addon"><i class="gi gi-bank"></i></span>
                            @if ($errors->has('nom_de_banque'))
                            <span class="help-block">
                                <strong>{{ $errors->first('nom_de_banque') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-5" style="margin-left:0px;">
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
                    <div class="form-group{{ $errors->has('copie_rib') ? ' has-error' : '' }} col-md-8" style="margin-left:10px;">
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
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-5" style="margin-left:0px;">
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
                            <select id="type_de_paiement_mobile" name="type_de_paiement_mobile" class="select-select2 type_de_paiement_mobile"  data-placeholder="" style="width: 100%;" >
                                <option></option>
                                <option value="coris money" >Coris Money</option>
                                <option value="orange money" >Orange money</option>
                                <option value="mobicash" >Mobicash</option>
                                <option value="wiz all" >Wiz all</option>
                            </select>
                    </div>
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-5" style="margin-left:0px;">
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
    $(document).ready(function() {
      $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    })
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
         function recupererprojet_id(id_projet){
            //alert(id_projet);
            document.getElementById("projet_id").setAttribute("value", id_projet);
            document.getElementById("projet_id_repecher").setAttribute("value", id_projet);
    }
    function statuer_sur_lanalyse_du_pca(){
        $(function(){
            var projet_id= $("#projet_id").val();
            var raison= $("#raison_du_rejet").val();
            var url = "{{ route('pca.valider_analyse') }}";
            $.ajax({
                url: url,
                type:'GET',
                data: {projet_id: projet_id, raison:raison} ,
                error:function(){alert('error');},
                success:function(){
                    $('#modal-confirm-rejet').hide();
                    location.reload();
                }
            });
            });
    }
    function repecher_le_pca(){
        $(function(){
            var projet_id= $("#projet_id_repecher").val();
            var url = "{{ route('pca.repecher') }}";
            $.ajax({
                url: url,
                type:'GET',
                data: {projet_id: projet_id} ,
                error:function(){alert('error');},
                success:function(){
                    $('#modal-confirm-rejet').hide();
                    location.reload();
                }
            });
            });
    }
    function save_decision_comite(avis){
        var projet_id= $("#projet_comite").val();
        var observation= $("#observation").val();
        var url = "{{ route('pca.savedecisioncomite') }}";
        $.ajax({
                url: url,
                type:'GET',
                data: {projet_id: projet_id, observation:observation, avis:avis} ,
                error:function(){alert('error');},
                success:function(){
                    $('#modal-confirm-rejet').hide();
                    location.reload();
                }
            });

    }
    function deux_somme_complementaire(montant1, montant2, somme){
    var valmontant1= $("#"+montant1).val();
    var valsomme= $("#"+somme).val();
    if(valsomme/2 != valmontant1 ){
      $("#tester").prop('disabled', true);
      alert("Attention le montant de la subvention ne doit pas être supérieur au coût du projet et la subvention doit être la moitié du coût total!!!");
      $("#"+montant1).val(' ');
      $("#"+somme).val(' ');
      $("#"+montant2).val(' ');
    }
    else{
       $("#tester").prop('disabled', false);
          var restant= valsomme - valmontant1;
          $("#"+montant2).val(restant);
          format_montant(montant2);
          format_montant(montant1);
          format_montant(somme);
    }
 
  }
 

function verifier_montant_devis(montant_champ, entreprise_id,devi_id){
   var montant= $("#"+montant_champ).val();
   var devi_id= $("#"+devi_id).val();
   var entreprise_id= $("#"+entreprise_id).val();
  // alert(devi_id);
   var url = "{{ route('verifier_montant_devis') }}";
   $.ajax({
            url: url,
             type: 'GET',
             data: {montant: montant, entreprise_id:entreprise_id, devis_id:devi_id},
             dataType: 'json',
             error:function(data){alert("Erreur");},
             success: function (data) {
              if(data==1){

                     $(".depassement_du_montant_du_devis").show();
                       $(".soumettre_facture").prop('disabled', true);
                     format_montant(montant_champ);
              }
              else{
                   $(".depassement_du_montant_du_devis").hide();
                     $(".soumettre_facture").prop('disabled', false);
                     format_montant(montant_champ);
              }
             }
             });

}
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
