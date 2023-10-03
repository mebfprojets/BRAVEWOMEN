@extends("layouts.public")
@section('active_souscription', 'active')
@section('class', 'content')
@section("main-content")
<a href={{ asset('/img/Formulaire_de_candidature_type_BRAVE_WOMEN.pdf') }} download="Formulaire BRAVE WOMEN Burkina.png">Télécharger formulaire type</a>
<p style="background-color: rgb(231, 179, 179); color">Les champs marqués d'étoile en <span style="color:red; font-size:15px;">*</span> rouge sont obligatoires</p>
<div class="block">
    <div class="block-title">
        <h2><strong>Enregistrement des données personnelles du promoteur</h2>
    </div>
        <div class="block-content2">
            <form  id="progress-wizard" action="{{ route("promoteur.store") }}" method="post" class="form-horizontal form-bordered" style="padding-left: 20px; border:1px solid black;" enctype="multipart/form-data" >
                @csrf
                            <div class="row">
                               <div class="col-lg-5">
                                         <fieldset>
                                                <legend>Informations générales</legend>
                                                        <div class="form-group">
                                                            <label class="control-label" for="nom_promoteur">Nom <span class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                                <input type="text" id="nom_promoteur" name="nom_promoteur" class="form-control" style="width: 100%;" value="{{old('nom_promoteur')}}" placeholder="Entrez votre nom" title="Ce champ est obligatoire" required >
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
                                                                <input type="text" id="prenom_promoteur" name="prenom_promoteur" class="form-control" value="{{old('prenom_promoteur')}}"placeholder="Entrez le prenom.." required="Ce champ est obligatoire">
                                                            </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label" for="val_username">Date de naissance<span class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                                <input type="text" id="datenais_promoteur" name="datenais_promoteur" value="{{old('datenais_promoteur')}}" class="form-control datepicker" data-date-format="dd-mm-yyyy" placeholder="Entrer votre date de naissance.." required="Ce champ est obligatoire">
                                                            </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class=" control-label" for="example-chosen">Genre<span class="text-danger">*</span></label>
                                                            <select id="genre" name="genre" class="select-select2" data-placeholder="Choisir le genre" style="width: 100%;" required="Ce champ est obligatoire" title="Ce champ est obligatoire">
                                                                <option></option>
                                                                <option value="1" {{ old('genre') == 1 ? 'selected' : '' }}>Féminin</option>
                                                                <option value="2" {{ old('genre') == 2 ? 'selected' : '' }}>Masculin</option>
                                                            </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class=" control-label" for="val_username">Télephone Principal:<span class="text-danger">*</span><span data-toggle="tooltip" title="Ce numéro de téléphone ne sera pas utilise pour d'autre souscription"><i class="fa fa-info-circle"></i></span></label>
                                                            <div class="input-group">
                                                                <input type="text" id="telephone_promoteur" name="telephone_promoteur" class="form-control masked_phone" value="{{old('telephone_promoteur')}}" placeholder="Votre numéro de télephone" required="Ce champ est obligatoire">
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
                                                                <input type="text" id="mobile_promoteur" name="mobile_promoteur" value="{{old('mobile_promoteur')}}" class="form-control masked_phone" placeholder="Votre numéro de télephone WhatsApp " >
                                                            </div>

                                                    </div>
                                                    <div class="form-group">
                                                        <label class=" control-label" for="val_email">Email <span class="text-danger">*</span><span data-toggle="tooltip" title="Cet adresse sera utilisé pour les notifications sur votre dossier par email "><i class="fa fa-info-circle"></i></span></label>
                                                            <div class="input-group">
                                                                <input type="email" id="email_promoteur" name="email_promoteur" class="form-control" value="{{old('email_promoteur')}}" placeholder="test@example.com" required="Ce champ est obligatoire" >
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
                                                                            <option value="1" {{ old('type_identite_promoteur') == 1 ? 'selected' : '' }} >CNIB</option>
                                                                            <option value="2" {{ old('type_identite_promoteur') == 2 ? 'selected' : '' }}>Passport</option>
                                                                        </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class=" control-label" for="">Numéro <span class="text-danger">*</span></label>
                                                                    <div class="input-group">
                                                                        <input type="text" id="numero_identite" name="numero_identite" value="{{old('numero_identite')}}" class="form-control" placeholder="numéro.." required>

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
                                                                <input type="text" id="date_identification" value="{{old('date_identification')}}" name="date_identification" class="form-control datepicker" data-date-format="dd-mm-yyyy" placeholder="mm/dd/yy"required>
                                                        </div>
                                                            </div>
                                                        {{-- <div class="form-group">
                                                            <label class=" control-label" for="">Autorité de délivrance <span class="text-danger">*</span></label>

                                                            <div class="input-group">
                                                                <select id="autorite_delivrance_identification" value="{{old('autorite_delivrance_identification')}}" name="autorite_delivrance_identification" class="select-select2" data-placeholder="Choisir l'autorite de delivrance" style="width: 100%;" required>
                                                                    <option></option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                                                    <option value="1" {{ old('autorite_delivrance_identification') == 1 ? 'selected' : '' }} >ONI</option>
                                                                    <option value="2" {{ old('autorite_delivrance_identification') == 2 ? 'selected' : '' }}>Autre</option>
                                                                </select>
                                                            </div>
                                                    </div> --}}
                                                    {{-- <div class="form-group">
                                                        <label class=" control-label" for="">Lieu d'établissement<span class="text-danger">*</span></label>

                                                        <div class="input-group">
                                                            <input type="text" id="lieu_etablissement_identification" name="lieu_etablissement_identification" value="{{old("lieu_etablissement_identification")}}" class="form-control" placeholder="Lieu d'etablissement" required>

                                                        </div>

                                                </div> --}}
                                                <div class="form-group{{ $errors->has('docidentite') ? ' has-error' : '' }}">
                                                    <label class=" control-label" for="docidentite">Joindre une copie<span class="text-danger">*</span></label>
                                                        <input class="form-control" type="file" name="docidentite" id="docidentite" accept=".pdf, .jpeg, .png"   placeholder="Charger une copie du document d'identification" required>
                                                    @if ($errors->has('docidentite'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('docidentite') }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                            </fieldset>
                                            </div>
                                        </div>
                                    <div class="row">
                                    <fieldset>
                                               <legend>Residence du promoteur</legend>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class=" control-label" for="example-chosen">Region<span class="text-danger">*</span></label>
                                                        <select id="region_residence" name="region_residence"  value="{{old("region_promoteur")}}" onchange="changeValue('region_residence', 'province_residence', {{ env('PARAMETRE_ID_PROVINCE') }});" class="select-select2" data-placeholder="Selectionnez votre région de residence .." style="width: 100%;" required>
                                                            <option></option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                                            @foreach ($regions as $region )
                                                                    <option value="{{ $region->id  }}" {{ old('region_residence') == $region->id ? 'selected' : '' }}>{{ $region->libelle }}</option>
                                                            @endforeach
                                                        </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class=" control-label" for="example-chosen">Province<span class="text-danger">*</span></label>
                                                        <select id="province_residence" name="province_residence" class="select-select2"  onchange="changeValue('province_residence', 'commune_residence', {{ env('PARAMETRE_ID_COMMUNE') }});" data-placeholder="Selectionnez votre province de residence .." style="width: 100%" required>
                                                            <option  value="{{ old('province_residence') }}" {{ old('province_residence') == old('province_residence') ? 'selected' : '' }}>{{ getlibelle(old('province_residence')) }}</option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                                        </select>
                                                </div>
                                            </div>
                                               <div class="offset-md-1 col-lg-5">
                                                <div class="form-group">
                                                    <label class=" control-label" for="example-chosen">Commune/Ville<span class="text-danger">*</span></label>
                                                        <select id="commune_residence" name="commune_residence"  class="select-select2" value="{{old("commune_residence")}}" data-placeholder="Selectionnez votre commune de residence .." onchange="changeValue('commune_residence', 'arrondissement_residence', {{ env('PARAMETRE_ID_ARRONDISSEMENT') }});" style="width: 100%;" required>
                                                            <option value="{{ old('commune_residence') }}" {{ old('commune_residence') == old('commune_residence') ? 'selected' : '' }}>{{ getlibelle(old('commune_residence')) }}</option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                                        </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class=" control-label" for="arrondissement_resident">Secteur/Village<span class="text-danger">*</span></label>
                                                        <select id="arrondissement_residence" class="select-select2" value="{{old("arrondissement_residence")}}" name="arrondissement_residence"  data-placeholder="Selectionnez votre village ou secteur de residence .." onchange="changeValue('arrondissement_residence', 'secteur_residence', {{ env('PARAMETRE_ID_SECTEUR') }});" style="width: 100%;" required>
                                                            <option value="{{ old('arrondissement_residence') }}" {{ old('arrondissement_residence') == old('arrondissement_residence') ? 'selected' : '' }}>{{ getlibelle(old('arrondissement_residence')) }}</option>
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
                                    </fieldset>
                                    </div>

                                        <fieldset>
                                            <legend>Competences du promoteur</legend>
                    <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class=" control-label" for="example-chosen">Niveau d’instruction<span class="text-danger">*</span></label>
                                           <select id="niveau_instruction" name="niveau_instruction" class="select-select2" data-placeholder="Quel est votre niveau d'instruction.."  style="width: 100%;" onchange="afficherautre('niveau_instruction',  {{ env('VALEUR_ID_AUTRE_NIVEAU_INSTRUCTION') }} ,'autre_niveau_instruction');" required>
                                               <option></option>
                                               @foreach ($niveau_instructions as $niveau_instruction )
                                                    <option value="{{ $niveau_instruction->id  }}" {{ old('niveau_instruction') == $niveau_instruction->id ? 'selected' : '' }}>{{ $niveau_instruction->libelle }}</option>
                                               @endforeach
                                           </select>
                                   </div>
                                   {{-- <div class="form-group" id="autre_niveau_instruction">
                                        <label class=" control-label" for="">Précisez</label>
                                        <div class="input-group">
                                            <input type="text" name="autre_niveau_instruction" class="form-control" placeholder="Précisez autre niveau instruction " value="{{old("autre_niveau_instruction")}}" required>

                                        </div>

                                    </div> --}}
                                    <div class="form-group">
                                        <label class=" control-label" for="example-chosen">Formation (s) en rapport avec l’activité<span class="text-danger">*</span><span data-toggle="tooltip" title="Comment vous vous êtes formé sur l'activité que vous menez comme activité de l'entreprise "><i class="fa fa-info-circle"></i></span></label>
                                            <select id="formation_activite" name="formation_activite" class="select-select2" data-placeholder="Le mode de formation en relation avec l'activite" style="width: 100%;" required onchange="afficherautre('formation_activite',  2 ,'domaine_formation');">
                                                <option></option>
                                                <option value="1" {{ old('formation_activite') == 1 ? 'selected' : '' }}>Apprentissage sur le tas</option>
                                                <option value="2" {{ old('formation_activite') == 2 ? 'selected' : '' }}>Formation Formelle</option>
                                                <option value="3" {{ old('formation_activite') == 3 ? 'selected' : '' }}>Aucun</option>
                                            </select>
                                    </div>
                                    <div class="form-group" id="domaine_formation">
                                        <label class="control-label" for="">Précisez le domaine ou thème</label>
                                        <div class="input-group">
                                            <input type="text"  name="domaine_formation" class="form-control" data-placeholder=""="Précisez le domaine de formation " value="{{old("domaine_formation")}}" required>
                                            <span class="input-group-addon"><i class="gi gi-learning"></i></span>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="control-label " for="">Nombre d’années d’expérience dans le domaine d'activite <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input id="nombre_annee_experience" type="number" min="0" max="100" name="nombre_annee_experience" class="form-control" data-placeholder="Nombre d'année d'expérience dans l'activité" value="{{old("nombre_annee_experience")}}" required >
                                            </div>
                                    </div>
                              </div>
                            <div class="offset-md-1 col-md-5">
                                    <div class="form-group">
                                        <label class="control-label" for="compte personnel">Disposez-vous d’un compte bancaire?<span class="text-danger">*</span><span data-toggle="tooltip" title="Disposez-vous d’un compte personnel dans une institution financière (Banques ou structures de microfinance)"><i class="fa fa-info-circle"></i></span></label>
                                        <div class="input-group">
                                            <select id="compte_perso_existe" class="select-select2" name="compte_perso_existe" data-placeholder="Un compte dans une banque ou dans une institution financière" title="Un compte personnel dans une banque ou dans une institution financière" onchange="afficher_nombanque();" style="width: 100%;" required>
                                                <option></option>
                                                <option value="oui" {{ old('compte_perso_existe') == "oui"? 'selected' : '' }}>Oui</option>
                                                <option value="non" {{ old('compte_perso_existe') == "oui" ? 'selected' : '' }}>Non</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" id="nom_structure">
                                        <label class=" control-label" for="">Précisez le nom de la structure </label>
                                            <div class="input-group">
                                                <input type="text" name="structure_financiere_personne" class="form-control" style="width: 100%;" data-placeholder="Précisez le nom de la structure financière" value="{{old("structure_financiere_personne")}}" required title="Ce champ est obligatoire">
                                            </div>
                                    </div>
                                        <div class="form-group">
                                            <label class=" control-label" for="arrondissement_resident">Membre d'une association?<span class="text-danger">*</span><span data-toggle="tooltip" title="Etes-vous membre d’une association ou d’une organisation professionnelle? "><i class="fa fa-info-circle"></i></span></label>
                                                <select id="membre_ass" class="select-select2" name="membre_ass"  data-placeholder="Ou d'une organisation professionnel" onchange="afficher_citer_association();" style="width: 100%;" required>
                                                    <option></option>
                                                    <option value="1" {{ old('membre_ass') == 1 ? 'selected' : '' }}>Oui</option>
                                                    <option value="2" {{ old('membre_ass') == 2 ? 'selected' : '' }}>Non</option>
                                                </select>
                                        </div>
                                        <div class="form-group associations">
                                            <label class=" control-label" for="example-textarea-input">Citer les associations <span data-toggle="tooltip" title="Citer les associations dont vous êtes membre "><i class="fa fa-info-circle"></i></span></label>
                                                <textarea id="associations" name="associations" rows="9" class="form-control" placeholder="citer les associations..">{{old('associations') }}</textarea>
                                        </div>
                                        
                            </div>

                    </div>
                    <div class="row">
                        @foreach ($proportiondedepences as $proportiondedepence )
                        <div class="col-md-4">
                        <fieldset>
                            <legend>{{ $proportiondedepence->description }} {{ $proportiondedepence->libelle }}<span data-toggle="tooltip" title="{{$proportiondedepence->description}}"><i class="fa fa-info-circle"></i></span></legend>
                            @foreach ($annees as $annee)
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="val_email">En {{ $annee->libelle }}<span class="text-danger">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input type="number" min=0 max=100 id="num_rccm" name="{{ $proportiondedepence->id }}{{$annee->id }}" value="{{old('{!! $proportiondedepence->id !!}{!! $annee->id !!}')}}" class="form-control" placeholder="Entrez le pourcentage" autofocus required title="Ce champ est obligatoire et doit être compris entre 0 et 100.">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </fieldset>
                        </div>
                        @endforeach
                    </div>
                    <hr>
                    <div class="row">
                        <div class="offset-md-1 col-md-10">
                            <div class="form-group">
                                <label class="col-md-4 control-label"><a href="#modal-terms" data-toggle="modal">Lire et accepter les conditions</a> <span class="text-danger">*</span>
                                </label>
                                <div class="col-md-7">
                                    <label class="switch switch-primary" for="val_terms">
                                        <input type="checkbox" id="val_terms" name="val_terms" value="1" onclick="validerterme()">
                                        <span data-toggle="tooltip" title="Lire et accepter les conditions! Pour lire les conditions cliquer sur le lien<.Vous devez accepter avant de pouvoir enregister les données"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                       </fieldset>
                            <div class="col-md-8 col-md-offset-4" style="margin-top:20px">
                                <input type="reset" class="btn btn-sm btn-warning"  value="Annuler">
                                    <input   onclick="return VerifyUploadSizeIsOK()" type="submit" id="valider" disabled class="btn btn-sm btn-success"  value="Enregister">
                            </div>            <!-- END Form Buttons -->
                         </form>
                     </div>
                </div>                       <!-- END Wizard with Validation Block -->
@endsection
