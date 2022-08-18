@extends("layouts.public")
@section("main-content")
@section("class", "content")

<div class="col-lg-4 ">
    <div class="block" style="border-right: 1px solid rgb(197, 194, 194);">
        <!-- Customer Info Title -->
        <div class="block-title">
            <h2><i class="fa fa-file-o"></i> <strong>Promotrice</strong> </h2>
        </div>
        <div class="block-section text-center">
            <a href="javascript:void(0)">
                <img src="{{ asset('img/placeholders/avatars/avatar4@2x.jpg') }}" alt="avatar" class="img-circle">
            </a>
            <h3>
                <strong>{{ Auth::user()->name }} {{ Auth::user()->prenom }}</strong><br><small></small>
            </h3>
        </div>
        <table class="table table-borderless table-striped table-vcenter">
            <tbody>
                <tr>
                    <td class="text-right" style="width: 50%;"><strong>Code</strong></td>
                    <td>{{ Auth::user()->code_promoteur }}</td>
                </tr>
                
            </tbody>
        </table>
        <!-- END Customer Info -->
        <div class="row">
        <nav class ="navbar bg-light">
            <ul class ="nav navbar-nav">
            <li class ="nav-item" >
            <a class ="nav-link"  href="{{ route('profil.beneficiaire') }}"><span><i class="gi gi-user"></i></span> Mon Profil </a>
            </li>
            <li class ="nav-item">
                <a class ="nav-link text-right" href="#"><span><i class="gi gi-user"></i></span> Details sur entreprise </a>
            </li>
            <li class ="nav-item">
                <a class ="nav-link" href="#"><span><i class="gi gi-user"></i></span> Situation financiaire </a>
            </li>
            <li class ="nav-item">
                <a class ="nav-link" href="#"><span><i class="gi gi-user"></i></span> Me Deconnecter </a>
            </li>
            </ul>
            </nav>
        
        </div>
        {{-- <a  href="#modal-user-data" data-toggle="modal" class="btn btn-primary">Modifier mes données</a> --}}
    </div>
</div>
<div class="col-md-8">
    @yield('content_space')
    </div> 
    <div> 
</div>
@endsection
<div id="modal-user-data" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Modifier mes données</h2>
            </div>
            <!-- END Modal Header -->

            <!-- Modal Body -->
            <div class="modal-body">
                <form  id="form-validation" action="{{route('updateprofilbeneficiaire',$promotrice)}}" method="get"  class="form-horizontal form-bordered">
                    <fieldset>
                        <legend>Infos personnelles</legend>
                    
                        <div class="row">
                            <div class="col-lg-5">
                                      <fieldset>
                                             <legend>Informations générales</legend>
                                                     <div class="form-group">
                                                         <label class="control-label" for="nom_promoteur">Nom <span class="text-danger">*</span></label>
                                                         <div class="input-group">
                                                             <input type="text" id="nom_promoteur" name="nom_promoteur" class="form-control" style="width: 100%;" value="{{$promotrice->nom}}" placeholder="Entrez votre nom" title="Ce champ est obligatoire" required >
                                                             @if ($errors->has('nom'))
                                                                     <span class="help-block">
                                                                          <strong>{{ $errors->first('nom_promoteur') }}</strong>
                                                                     </span>
                                                             @endif
                                                         </div>
                                                 </div>
                                                 <div class="form-group">
                                                     <label class="control-label" for="val_username">Prénom (s) <span class="text-danger">*</span></label>
                                                         <div class="input-group">
                                                             <input type="text" id="prenom_promoteur" name="prenom_promoteur" class="form-control" value="{{$promotrice->prenom}}" placeholder="Entrez le prenom.." required="Ce champ est obligatoire">
                                                         </div>
                                                 </div>
                                                 <div class="form-group">
                                                     <label class="control-label" for="val_username">Date de naissance<span class="text-danger">*</span></label>
                                                         <div class="input-group">
                                                             <input type="text" id="datenais_promoteur" name="datenais_promoteur" value="{{format_date($promotrice->datenais)}}" class="form-control datepicker" data-date-format="dd-mm-yyyy" placeholder="Entrer votre date de naissance.." required="Ce champ est obligatoire">
                                                         </div>
                                                 </div>
                                                 <div class="form-group">
                                                     <label class=" control-label" for="example-chosen">Genre<span class="text-danger">*</span></label>
                                                         <select id="genre" name="genre" class="select-select2" data-placeholder="Choisir le genre" style="width: 100%;" required="Ce champ est obligatoire" title="Ce champ est obligatoire">
                                                             <option></option>
                                                             <option value="1" @if($promotrice->genre==1)
                                                                 selected
                                                             @endif>Féminin</option>
                                                             <option value="2"  @if($promotrice->genre==2)
                                                                selected
                                                            @endif>Masculin</option>
                                                         </select>
                                                 </div>
                                                 <div class="form-group">
                                                     <label class=" control-label" for="val_username">Télephone Principal:<span class="text-danger">*</span><span data-toggle="tooltip" title="Ce numéro de téléphone ne sera pas utilise pour d'autre souscription"><i class="fa fa-info-circle"></i></span></label>
                                                         <div class="input-group">
                                                             <input type="text" id="telephone_promoteur" name="telephone_promoteur" class="form-control masked_phone" value="{{format_date($promotrice->telephone_promoteur)}}" placeholder="Votre numéro de télephone" required="Ce champ est obligatoire">
                                                         </div>
                                                         @if ($errors->has('telephone_promoteur'))
                                                         <span class="help-block text-danger">
                                                              <strong>Un promoteur a déja été enregistré avec ce numéro de telephone</strong>
                                                         </span>
                                                     @endif
                                                 </div>
                                                 <div class="form-group">
                                                     <label class=" control-label" for="val_username">Mobile (WhatsApp)</label>
                                                         <div class="input-group">
                                                             <input type="text" id="mobile_promoteur" name="mobile_promoteur" value="{{format_date($promotrice->mobile_promoteur )}}" class="form-control masked_phone" placeholder="Votre numéro de télephone WhatsApp " >
                                                         </div>
                                                 </div>
                                                 <div class="form-group">
                                                     <label class=" control-label" for="val_email">Email <span class="text-danger">*</span><span data-toggle="tooltip" title="Cet adresse sera utilisé pour les notifications sur votre dossier par email "><i class="fa fa-info-circle"></i></span></label>
                                                         <div class="input-group">
                                                             <input type="email" id="email_promoteur" name="email_promoteur" class="form-control" value="{{Auth::user()->email}}" placeholder="test@example.com" required="Ce champ est obligatoire" >
                                                         </div>
                                                 </div>
                                                 </fieldset>
                                                     </div>
                                                     <div class="offset-md-1 col-lg-5">
                                                        <fieldset>
                                                             <legend>Référence du document d’identité</legend>
                                                             <div class="form-group select-list">
                                                                 <label class=" control-label" for="example-chosen">Type<span class="text-danger">*</span></label>
                                                                     <select id="type_identite_promoteur" name="type_identite_promoteur" data-placeholder="Choisir type identite" class="select-select2" style="width: 100%;" required>
                                                                         <option></option>
                                                                         <option value="1" @if($promotrice->ype_identite ==1)
                                                                             selected
                                                                         @endif >CNIB</option>
                                                                         <option value="2" @if($promotrice->ype_identite ==2)
                                                                            selected
                                                                        @endif>Passport</option>
                                                                     </select>
                                                             </div>
                                                             <div class="form-group">
                                                                 <label class=" control-label" for="">Numéro <span class="text-danger">*</span></label>
                                                                 <div class="input-group">
                                                                     <input type="text" id="numero_identite" name="numero_identite" value="{{ $promotrice->numero_identite }}" class="form-control" placeholder="numéro.." required>
                                                                 </div>
                                                                 @if ($errors->has('numero_identite'))
                                                                     <span class="help-block text-danger">
                                                                          <strong>Un promoteur a déja été enregistré avec ce numéro d'identité</strong>
                                                                     </span>
                                                                 @endif
                                                         </div>
                                                         <div class="form-group">
                                                             <label class=" control-label" for="">Date d'établissement <span class="text-danger">*</span></label>
                                                         <div class="input-group">
                                                             <input type="text" id="date_identification" value="{{ format_date($promotrice->date_etabli_identite) }}" name="date_identification" class="form-control datepicker" data-date-format="dd-mm-yyyy" placeholder="mm/dd/yy"required>
                                                     </div>
                                            </div>
                                             <div class="form-group{{ $errors->has('docidentite') ? ' has-error' : '' }}">
                                                 <label class=" control-label" for="docidentite">Joindre une copie<span class="text-danger">*</span></label>
                                                     <input class="form-control" type="file" name="docidentite" id="docidentite" accept=".pdf, .jpeg, .png"   placeholder="Charger une copie du document d'identification" >
                                                 @if ($errors->has('docidentite'))
                                                     <span class="help-block">
                                                         <strong>{{ $errors->first('docidentite') }}</strong>
                                                     </span>
                                                 @endif
                                         </div>
                                         <legend>Compétence</legend>
                                         <div class="form-group">
                                            <label class=" control-label" for="example-chosen">Niveau d'instruction<span class="text-danger">*</span></label>
                                                <select id="niveau_instruction" name="niveau_instruction"  value="{{old("region_promoteur")}}"  class="select-select2" data-placeholder="Selectionnez votre région de residence .." style="width: 100%;" required>
                                                    <option></option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                                    @foreach ($niveau_instructions as  $niveau_instruction )
                                                            <option value="{{ $niveau_instruction->id  }}" {{ old('niveau_instruction') == $niveau_instruction->id ? 'selected' : '' }}
                                                                @if($promotrice->niveau_instruction ==$niveau_instruction->id)
                                                                    selected
                                                                @endif>{{ $niveau_instruction->libelle }}</option>
                                                    @endforeach
                                                </select>
                                        </div>
                                        <div class="form-group">
                                            <label class=" control-label" for="example-chosen">Formation (s) en rapport avec l’activité<span class="text-danger">*</span><span data-toggle="tooltip" title="Comment vous vous êtes formé sur l'activité que vous menez comme activité de l'entreprise "><i class="fa fa-info-circle"></i></span></label>
                                                <select id="formation_activite" name="formation_activite" class="select-select2" data-placeholder="Le mode de formation en relation avec l'activite" style="width: 100%;" required onchange="afficherautre('formation_activite',  2 ,'domaine_formation');">
                                                    <option></option>
                                                    <option value="1" @if($promotrice->formation_en_rapport_avec_activite==1)
                                                        selected
                                                    @endif>Apprentissage sur le tas</option>
                                                    <option value="2" @if($promotrice->formation_en_rapport_avec_activite==2)
                                                        selected
                                                    @endif>Formation Formelle</option>
                                                    <option value="3"@if($promotrice->formation_en_rapport_avec_activite==3)
                                                        selected
                                                    @endif>Aucun</option>
                                                </select>
                                        </div>
                                        <div class="form-group" id="domaine_formation">
                                            <label class="control-label" for="">Précisez le domaine ou thème</label>
                                            <div class="input-group">
                                                <input type="text"  name="domaine_formation" class="form-control" data-placeholder=""="Précisez le domaine de formation " value="{{old("domaine_formation")}}" >
                                                <span class="input-group-addon"><i class="gi gi-learning"></i></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class=" control-label" for="">Expérience <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="text" id="expérience" name="nombre_annee_experience" value="{{ $promotrice->nombre_annee_experience  }}" class="form-control" placeholder="nombre d'expérience.." required>
                                            </div>
                                            @if ($errors->has('numero_identite'))
                                                <span class="help-block text-danger">
                                                     <strong>Un promoteur a déja été enregistré avec ce numéro d'identité</strong>
                                                </span>
                                            @endif
                                    </div>
                                         </fieldset> 
                                         </div>
                                     </div>
                    <div class="row">
                        <legend>Lieu de residence</legend>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class=" control-label" for="example-chosen">Region<span class="text-danger">*</span></label>
                                    <select id="region_residence" name="region_residence"  value="{{old("region_promoteur")}}" onchange="changeValue('region_residence', 'province_residence', {{ env('PARAMETRE_ID_PROVINCE') }});" class="select-select2" data-placeholder="Selectionnez votre région de residence .." style="width: 100%;" required>
                                        <option></option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                        @foreach ($regions as $region )
                                                <option value="{{ $region->id  }}" {{ old('region_residence') == $region->id ? 'selected' : '' }}
                                                    @if($promotrice->region_residence==$region->id)
                                                        selected
                                                    @endif>{{ $region->libelle }}</option>
                                        @endforeach
                                    </select>
                            </div>
                            <div class="form-group">
                                <label class=" control-label" for="example-chosen">Province<span class="text-danger">*</span></label>
                                    <select id="province_residence" name="province_residence" class="select-select2"  onchange="changeValue('province_residence', 'commune_residence', {{ env('PARAMETRE_ID_COMMUNE') }});" data-placeholder="Selectionnez votre province de residence .." style="width: 100%" required>
                                        <option value="{{$promotrice->province_residence }}" selected >{{ getlibelle($promotrice->province_residence ) }}</option>
                                        {{-- <option  value="{{ old('province_residence') }}" {{ old('province_residence') == old('province_residence') ? 'selected' : '' }}>{{ getlibelle(old('province_residence')) }}</option><!-- Required for data-placeholder attribute to work with Chosen plugin --> --}}
                                    </select>
                            </div>
                        </div>
                        <div class=" offset-md-1 col-md-5">
                            <div class="form-group">
                                <label class=" control-label" for="example-chosen">Commune/Ville<span class="text-danger">*</span></label>
                                    <select id="commune_residence" name="commune_residence"  class="select-select2" value="{{old("commune_residence")}}" data-placeholder="Selectionnez votre commune de residence .." onchange="changeValue('commune_residence', 'arrondissement_residence', {{ env('PARAMETRE_ID_ARRONDISSEMENT') }});" style="width: 100%;" required>
                                        <option value="{{$promotrice->commune_residence }}" selected>{{ getlibelle($promotrice->commune_residence) }}</option>

                                        {{-- <option value="{{ old('commune_residence') }}" {{ old('commune_residence') == old('commune_residence') ? 'selected' : '' }}>{{ getlibelle(old('commune_residence')) }}</option> --}}
                                    </select>
                            </div>
                            <div class="form-group">
                                <label class=" control-label" for="arrondissement_resident">Secteur/Village<span class="text-danger">*</span></label>
                                    <select id="arrondissement_residence" class="select-select2" value="{{old("arrondissement_residence")}}" name="arrondissement_residence"  data-placeholder="Selectionnez votre village ou secteur de residence .." onchange="changeValue('arrondissement_residence', 'secteur_residence', {{ env('PARAMETRE_ID_SECTEUR') }});" style="width: 100%;" required>
                                        <option value="{{$promotrice->arrondissement_residence }}" selected>{{ getlibelle($promotrice->arrondissement_residence) }}</option>
                                       
                                        {{-- <option value="{{ old('arrondissement_residence') }}" {{ old('arrondissement_residence') == old('arrondissement_residence') ? 'selected' : '' }}>{{ getlibelle(old('arrondissement_residence')) }}</option> --}}
                                    </select>
                            </div>
                            <div class="form-group">
                                <label class=" control-label" for="example-chosen">Situation résidence<span class="text-danger">*</span></label>
                                    <select id="example-chosen" name="situation_residence" class="select-select2" value="{{old("situation_residence")}}"  data-placeholder="Quelle est votre situation de residence .." style="width: 100%;" required>
                                        <option></option>
                                        <option value="1" {{ old('situation_residence') == 1 ? 'selected' : '' }}>Resident</option>
                                        <option value="2" {{ old('situation_residence') == 2 ? 'selected' : '' }}>Déplacé</option>
                                    </select>
                            </div>
                        </div>
                    </div>
                        
                        
                   
                        
                    </fieldset>
                    <fieldset>
                        <legend>Changer le mot de passe</legend>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="user-old-password">Ancien mot de Passe</label>
                            <div class="col-md-8">
                                <input type="password" id="user-old-password" name="old_password" class="form-control" placeholder="SVP entrez votre actuel mot de passe">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="user-settings-password">Nouveau Mot de Passe</label>
                            <div class="col-md-8">
                                <input type="password" id="val_password" name="password" class="form-control" placeholder="SVP entrez un mot de passe complexe">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="user-settings-repassword">Confirmer le Nouveau Mot de Passe</label>
                            <div class="col-md-8">
                                <input type="password" id="val_confirm_password" name="password_confirmation" class="form-control" placeholder="Et confirmer le ...">
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-group form-actions">
                        <div class="col-xs-12 text-right">
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-sm btn-primary">Enregistrer</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- END Modal Body -->
        </div>
    </div>
</div>