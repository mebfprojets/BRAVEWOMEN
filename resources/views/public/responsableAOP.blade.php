@extends("layouts.public")
@section('active_souscription', 'active')
@section('class', 'content')
@section("main-content")
<a href={{ asset('/img/Formulaire_de_candidature_type_BRAVE_WOMEN_aop.pdf') }} download="Formulaire BRAVE WOMEN Burkina.pdf">Télécharger formulaire type</a>
<p style="background-color: rgb(231, 179, 179); color">Les champs marqués d'étoile en <span style="color:red; font-size:15px;">*</span> rouge sont obligatoires</p>
<div class="block">
    <div class="block-title">
        <h2><strong>Enregistrement des informations sur la/ le responsable </h2>
    </div>
        <div class="block-content2">
            <form  id="progress-wizard" action="{{ route("responsableaop.store") }}" method="post" class="form-horizontal form-bordered" style="padding-left: 20px; border:1px solid black;"  enctype="multipart/form-data" >
                @csrf
                            <div class="row">
                                   <p class="message_doublon" style="color: red; display:none;">Désole vous vous êtes déjà enregistré sur la plateforme avec le code promoteur.Votre code promoteur vous sera envoyé par mail. Contacter nos chefs de zone</span> </p>
                               <div class="col-lg-5">
                                         <fieldset>
                                                <legend>Informations générales</legend>
                                                        <div class="form-group">
                                                            <label control-label" for="nom_promoteur">Nom <span class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                                <input type="text" id="nom_promoteur" name="nom_promoteur" class="form-control" style="width: 100%;" value="{{old('nom_promoteur')}}" onchange="this.value = this.value.toUpperCase()" placeholder="Entrez votre nom" title="Ce champ est obligatoire" required >
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
                                                                <input type="text" id="prenom_promoteur" name="prenom_promoteur" class="form-control" value="{{old('prenom_promoteur')}}"placeholder="Entrez le prenom.." required="Ce champ est obligatoire" onchange="this.value = this.value.charAt(0).toUpperCase()+ this.value.substr(1);">
                                                            </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label" for="val_username">Fonction: <span class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                                <input type="text" id="fonction_du_responsable" name="fonction" class="form-control" value="{{old('fonction')}}"placeholder="Entrez la fonction.." required="Ce champ est obligatoire">
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
                                                                <input type="text" id="telephone_promoteur" name="telephone_promoteur" class="form-control masked_phone" value="{{old('telephone_promoteur')}}" placeholder="Votre numéro de télephone" required="Ce champ est obligatoire" onchange="controler_de_doublon_promotrice('telephone_promoteur')">
                                                            </div>
                                                            @if ($errors->has('telephone_promoteur'))
                                                            <span class="help-block text-danger">
                                                                 <strong>Une personne a déja été enregistrée avec ce numéro de telephone</strong>
                                                            </span>
                                                        @endif

                                                    </div>
                                                    <div class="form-group">
                                                        <label class=" control-label" for="val_username">Mobile (WhatsApp)</label>

                                                            <div class="input-group">
                                                                <input type="text" id="mobile_promoteur" name="mobile_promoteur" value="{{old('mobile_promoteur')}}" class="form-control masked_phone" placeholder="Votre numéro de télephone WhatsApp "  onchange="controler_de_doublon_promotrice('mobile_promoteur')">
                                                            </div>

                                                    </div>
                                                    <div class="form-group">
                                                        <label class=" control-label" for="val_email">Email <span class="text-danger">*</span><span data-toggle="tooltip" title="Cet adresse sera utilisé pour les notifications sur votre dossier par email "><i class="fa fa-info-circle"></i></span></label>
                                                            <div class="input-group">
                                                                <input type="email" id="email_promoteur" name="email_promoteur" class="form-control" value="{{old('email_promoteur')}}" placeholder="test@example.com" required="Ce champ est obligatoire" onchange="controler_de_doublon_promotrice('email_promoteur')">
                                                            </div>

                                                    </div>
                                                    </fieldset>
                                                        </div>
                                                        <div class="offset-md-1 col-lg-5">
                                                            <fieldset>
                                                                <legend>Références du document d’identité</legend>
                                                                <div class="form-group select-list">
                                                                    <label class=" control-label" for="example-chosen">Type<span class="text-danger">*</span></label>
                                                                        <select id="type_identite_promoteur" name="type_identite_promoteur" data-placeholder="Choisir type identite" class="select-select2" style="width: 100%;" required>
                                                                            <option></option>
                                                                            <option value="1" {{ old('type_identite_promoteur') == 1 ? 'selected' : '' }} >CNIB</option>
                                                                            <option value="2" {{ old('type_identite_promoteur') == 2 ? 'selected' : '' }}>Passeport</option>
                                                                        </select>

                                                                </div>
                                                                <div class="form-group">
                                                                    <label class=" control-label" for="">Numéro <span class="text-danger">*</span></label>
                                                                    <div class="input-group">
                                                                        <input type="text" id="numero_identite" name="numero_identite" value="{{old('numero_identite')}}" class="form-control" placeholder="numéro.." onchange="controler_de_doublon_promotrice('numero_identite')"  required>
                                                                    </div>
                                                                    @if ($errors->has('numero_identite'))
										                                <span class="help-block text-danger">
										                                     <strong>Une personne a déja été enregistrée avec ce numéro d'identité</strong>
										                                </span>
										                            @endif
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label class=" control-label" for="">Date d'établissement <span class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                                <input type="text" id="date_identification" value="{{old('date_identification')}}" name="date_identification" class="form-control datepicker" data-date-format="dd-mm-yyyy" placeholder="mm/dd/yy"required>
                                                            </div>
                                                            </div>
                                                            <div class="form-group{{ $errors->has('docidentite') ? ' has-error' : '' }}">
                                                                <label class=" control-label" for="docidentite">Joindre une copie<span class="text-danger">*</span></label>
                                                                    <input class="form-control" type="file" name="docidentite" id="docidentite" accept=".pdf, .jpeg, .png"   onchange="VerifyUploadSizeIsOK('docidentite');"  placeholder="Charger une copie du document d'identification" required>
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
                                               <legend>Residence du / de la promoteur</legend>
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
                                            <legend>Competences du responsable</legend>
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
                                  <div class="form-group">
                                        <label class=" control-label" for="">Précisez le domaine  d’étude</label>
                                        <div class="input-group">
                                            <input type="text" name="domaine_detude" class="form-control" placeholder="Précisez autre niveau instruction " value="{{old("autre_niveau_instruction")}}" required>
                                        </div>
                                    </div>  
                              </div>
                            <div class="offset-md-1 col-md-5">
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
                                    <label class="control-label " for="">Nombre d’années d’expérience en tant que resposable <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input id="nombre_annee_experience" type="number" min="0" max="100" name="nombre_annee_experience" class="form-control" data-placeholder="Nombre d'année d'expérience dans l'activité" value="{{old("nombre_annee_experience")}}" required >
                                        </div>
                                </div>
                            </div>

                    </div>
                    <div class="row">
                        @foreach ($proportiondedepences as $proportiondedepence )
                        <div class="col-md-4">
                        <fieldset>
                            <legend>{{ $proportiondedepence->description }} {{ $proportiondedepence->libelle }}  <span data-toggle="tooltip" title="{{$proportiondedepence->description}}"><i class="fa fa-info-circle"></i></span></legend>
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
                                    <input type="submit" id="valider" disabled class="btn btn-sm btn-success"  value="Enregister">
                            </div>            <!-- END Form Buttons -->
                         </form>
                     </div>
                </div>                       <!-- END Wizard with Validation Block -->
@endsection
