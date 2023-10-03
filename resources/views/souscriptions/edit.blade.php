@extends('layouts.admin')
@section('souscription', 'active')
@section('souscription-edit', 'active')
@section('content')
{{-- <p style="background-color: rgb(231, 179, 179); color">Les champs marqué d'étoile en <span style="color:red; font-size:15px;">*</span> rouge sont obligatoires</p> --}}
<div class="col-md-10">
<div class="block">

    <div class="block-title">
        <h2><strong>Modification des données du promoteur</h2>
    </div>
        <div class="block-content2">
            <form id="progress-wizard" action="{{ route("promoteur.update", $promoteur->id) }}" method="post" class="form-horizontal form-bordered" enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}
                                        <div class="row">
                                                        <div class="col-lg-6">
                                                    <fieldset>
                                                        <legend>Information générale</legend>
                                                        <div class="form-group">
                                                            <label class="col-md-4 control-label" for="nom_promoteur">Nom <span class="text-danger">*</span></label>
                                                            <div class="col-md-6">
                                                            <div class="input-group">
                                                                <input type="text" id="nom_promoteur" name="nom_promoteur" class="form-control" value="{{old('nom_promoteur')??$promoteur->nom}}" placeholder="Entrez votre nom" required="Ce champ est obigatoire">
                                                                <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                                                @if ($errors->has('nom'))
										                                <span class="help-block">
										                                     <strong>{{ $errors->first('nom_promoteur') }}</strong>
										                                </span>
										                            @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label" for="val_username">Prénom (s) <span class="text-danger">*</span></label>
                                                        <div class="col-md-6">
                                                            <div class="input-group">
                                                                <input type="text" id="prenom_promoteur" name="prenom_promoteur" class="form-control" value="{{old('prenom_promoteur')??$promoteur->prenom}}" placeholder="Entrez le prenom.." required>
                                                                <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label" for="val_username">Date de naissance<span class="text-danger">*</span></label>
                                                        <div class="col-md-6">
                                                            <div class="input-group">
                                                                <input type="text" id="datenais_promoteur" name="datenais_promoteur" value="{{old('datenais_promoteur')??$promoteur->datenais}}" class="form-control datepicker" data-date-format="dd-mm-yy" placeholder="Entrer votre date de naissance.." required>
                                                                <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label" for="example-chosen">Genre<span class="text-danger">*</span></label>
                                                        <div class="col-md-6">
                                                            <select id="genre" name="genre" class="select-select2" data-placeholder="Choisir le genre" style="width: 100%;" required>
                                                                <option></option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                                                <option value="1" @if ($promoteur->genre==1)
                                                                    selected
                                                                @endif"> Féminin</option>
                                                                <option value="2"
                                                                @if ($promoteur->genre==2)
                                                                    selected
                                                                @endif>Masculin</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label" for="val_username">Télephone:<span class="text-danger">*</span></label>
                                                        <div class="col-md-6">
                                                            <div class="input-group">
                                                                <input type="text" id="telephone_promoteur" name="telephone_promoteur" class="form-control" value="{{old('telephone_promoteur')??$promoteur->telephone_promoteur}}" placeholder="Votre numéro de télephone" required>
                                                                <span class="input-group-addon"><i class="gi gi-earphone"></i></span>
                                                            </div>
                                                            @if ($errors->has('telephone_promoteur'))
                                                            <span class="help-block text-danger">
                                                                 <strong>Un promoteur a déja été enregistré avec ce numéro de telephone</strong>
                                                            </span>
                                                        @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label" for="val_username">Mobile (WhatsApp)</label>
                                                        <div class="col-md-6">
                                                            <div class="input-group">
                                                                <input type="text" id="val_username" name="mobile_promoteur" value="{{old('mobile_promoteur')??$promoteur->mobile_promoteur}}" class="form-control" placeholder="Votre numéro de télephone WhatsApp " >
                                                                <span class="input-group-addon"><i class="gi gi-iphone"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label" for="val_email">Email <span class="text-danger">*</span></label>
                                                        <div class="col-md-6">
                                                            <div class="input-group">
                                                                <input type="email" id="email_promoteur" name="email_promoteur" class="form-control" value="{{old('email_promoteur')??$promoteur->email_promoteur}}" placeholder="test@example.com" required >
                                                                <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </fieldset>


                                                        </div>
                                                        <div class="col-lg-6">
                                                            <fieldset>
                                                                <legend>Référence du document d’identité</legend>
                                                                <div class="form-group">
                                                                    <label class="col-md-4 control-label" for="example-chosen">Type<span class="text-danger">*</span></label>
                                                                    <div class="col-md-6">
                                                                        <select id="type_identite_promoteur" name="type_identite_promoteur" class="select-select2" data-placeholder="Choisir type identite" style="width: 100%;" required>
                                                                            <option></option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                                                            <option value="1"
                                                                            @if ($promoteur->type_identite==1)
                                                                                selected
                                                                            @endif>CNIB</option>
                                                                            <option
                                                                            @if ($promoteur->type_identite==2)
                                                                                selected
                                                                            @endif>Passport</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="col-md-4 control-label" for="">Numéro <span class="text-danger">*</span></label>
                                                                    <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <input type="text" id="numero_identite" name="numero_identite" value="{{old('telephone_promoteur')??$promoteur->telephone_promoteur}}" class="form-control" placeholder="numéro.." required>
                                                                        <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                                                    </div>
                                                                    @if ($errors->has('numero_identite'))
										                                <span class="help-block text-danger">
										                                     <strong>Un promoteur a déja été enregistré avec ce numéro d'identité</strong>
										                                </span>
										                            @endif
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-4 control-label" for="">Date d'établissement <span class="text-danger">*</span></label>
                                                                <div class="col-md-6">
                                                                <div class="input-group">
                                                                    <input type="text" id="date_identification" value="{{old('date_identification')??$promoteur->date_etabli_identite}}" name="date_identification" class="form-control input-datepicker" data-date-format="dd-mm-yy" placeholder="mm/dd/yy" placeholder="numéro.." required>
                                                                    <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-4 control-label" for="">Autorité de délivrance <span class="text-danger">*</span></label>
                                                            <div class="col-md-6">
                                                            <div class="input-group">
                                                                <select id="autorite_delivrance_identification" value="{{old('autorite_delivrance_identification')}}" name="autorite_delivrance_identification" class="select-select2" data-placeholder="Choisir l'autorite de delivrance" style="width: 100%;" required>
                                                                    <option></option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                                                    <option value="1"
                                                                    @if ($promoteur->autorite_delivrance==1)
                                                                                selected
                                                                            @endif>ONI</option>
                                                                    <option value="2" @if ($promoteur->autorite_delivrance==2)
                                                                        selected
                                                                    @endif>Autre</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label" for="">Lieu d'établissement<span class="text-danger">*</span></label>
                                                        <div class="col-md-6">
                                                        <div class="input-group">
                                                            <input type="text" id="lieu_etablissement_identification" name="lieu_etablissement_identification" value="{{old('lieu_etablissement_identification')??$promoteur->lieu_etablissement}}" class="form-control" placeholder="Lieu d'etablissement" required>
                                                            <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group{{ $errors->has('docidentite') ? ' has-error' : '' }}">
                                                    <label class="col-md-4 control-label" for="docidentite">Joindre une copie<span class="text-danger">*</span></label>
                                                    <div class="col-md-6">
                                                        <input class="form-control" type="file" id="docidentite" accept=".pdf, .jpeg, .png" name="docidentite"  placeholder="Charger une copie du document d'identification" required>
                                                    </div>
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
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label" for="example-chosen">Region<span class="text-danger">*</span></label>
                                                    <div class="col-md-6">
                                                        <select id="region_residence" name="region_residence"  value="{{old("region_promoteur")}}" onchange="changeValue('region_residence', 'province_residence', {{ env('PARAMETRE_ID_PROVINCE') }});" class="select-select2" data-placeholder="Choisir votre residence .." style="width: 250px;" required>
                                                            <option></option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                                            @foreach ($regions as $region )
                                                                    <option value="{{ $region->id }}"
                                                                        @if ($promoteur->region_residence==$region->id)
                                                                        selected
                                                                    @endif>{{ $region->libelle }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label" for="example-chosen">Province<span class="text-danger">*</span></label>
                                                    <div class="col-md-6">
                                                        <select id="province_residence" name="province_residence" class="select-select2" value="{{old("province_residence")}}" onchange="changeValue('province_residence', 'commune_residence', {{ env('PARAMETRE_ID_COMMUNE') }});" data-placeholder="Choisir la province" style="width: 100%" required>
                                                            <option value="$promoteur->province_residence">{{ getlibelle($promoteur->province_residence) }}</option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>

                                               <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label" for="example-chosen">Commune/Ville<span class="text-danger">*</span></label>
                                                    <div class="col-md-6">
                                                        <select id="commune_residence" name="commune_residence"  class="select-select2" value="{{old("commune_residence")}}" data-placeholder="Choisir la commune ..." onchange="changeValue('commune_residence', 'arrondissement_residence', {{ env('PARAMETRE_ID_ARRONDISSEMENT') }});" style="width: 250px;" required>
                                                            <option value="$promoteur->commune_residence ">{{ getlibelle($promoteur->commune_residence ) }}</option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label" for="arrondissement_resident">Arrondissement/Village<span class="text-danger">*</span></label>
                                                    <div class="col-md-6">
                                                        <select id="arrondissement_residence" class="select-select2" value="{{old("arrondissement_residence")}}" name="arrondissement_residence"  data-placeholder="Arrondissment ou village" onchange="changeValue('arrondissement_residence', 'secteur_residence', {{ env('PARAMETRE_ID_SECTEUR') }});" style="width: 250px;" required>
                                                            <option value="$promoteur->arrondissement_residence ">{{ getlibelle($promoteur->arrondissement_residence ) }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label" for="example-chosen">Situation résidence<span class="text-danger">*</span></label>
                                                    <div class="col-md-6">
                                                        <select id="example-chosen" name="situation_residence" class="select-select2" value="{{old("situation_residence")}}"  data-placeholder="Choisir le genre" style="width: 100%;" required>
                                                            <option></option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                                            <option value="1"
                                                             @if ($promoteur->situation_residence==1)
                                                                selected
                                                            @endif >Resident</option>
                                                            <option value="2"@if ($promoteur->situation_residence==2)
                                                                selected
                                                            @endif  >Déplacé</option>
                                                        </select>
                                                    </div>
                                                </div>
                                               </div>
                                    </fieldset>


                                    </div>
                                    <div class="row">
                                        <fieldset>
                                            <legend>Competences du promoteur</legend>
                                            <div class="form-group">
                                            <label class="col-md-4 control-label" for="example-chosen">Niveau d’instruction<span class="text-danger">*</span></label>
                                               <div class="col-md-6">
                                                   <select id="niveau_instruction" name="niveau_instruction" class="select-select2" data-placeholder="choisir le niveau d'instruction.."  style="width: 100%;" required>
                                                       <option></option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                                       @foreach ($niveau_instructions as $niveau_instruction )
                                                            <option value="{{ $niveau_instruction->id }}"
                                                                @if ($promoteur->niveau_instruction==$niveau_instruction->id)
                                                                            selected
                                                                        @endif>{{ $niveau_instruction->libelle }}</option>
                                                       @endforeach
                                                   </select>
                                               </div>
                                           </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="">Domaine d'etude <span class="text-danger">*</span></label>
                                            <div class="col-md-6">
                                            <div class="input-group">
                                                <input type="text" id="domaine_etude" name="domaine_etude" class="form-control" value="{{old('domaine_etude')??$promoteur->domaine_etude}}" placeholder="Autre niveau instruction " required>
                                                <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                           <div class="form-group">
                                               <label class="col-md-4 control-label" for="example-chosen">Formation (s) en rapport avec l’activité<span class="text-danger">*</span></label>
                                               <div class="col-md-6">
                                                   <select id="formation_activite" name="formation_activite" class="select-select2" data-placeholder="choisir le niveau d'instruction.." style="width: 100%;" required>
                                                       <option></option>
                                                       <option value="1" @if ($promoteur->formation_en_rapport_avec_activite==1)
                                                        selected
                                                    @endif>Apprentissage sur le tas</option>
                                                       <option value="2" @if ($promoteur->formation_en_rapport_avec_activite==2)
                                                        selected
                                                    @endif>Formation technique</option>
                                                       <option value="3" @if ($promoteur->formation_en_rapport_avec_activite==3)
                                                        selected
                                                    @endif>Autres</option>
                                                   </select>
                                               </div>
                                           </div>

                                           <div class="form-group">
                                               <label class="col-md-4 control-label" for="example-chosen">Occupation professionnelle actuelle<span class="text-danger">*</span></label>
                                               <div class="col-md-6">
                                                   <select id="occupation_pro_actuelle" name="occupation_pro_actuelle" class="select-select2" data-placeholder="Occupation professionnelle actuelle" style="width: 100%;" required="Ce champ est obligatoire">
                                                       <option></option>
                                                       @foreach ($occupation_professionnelle_actuelles as $occupation_professionnelle_actuelle )
                                                       <option value="{{ $occupation_professionnelle_actuelle->id }}"
                                                        @if ($promoteur->occupation_professionnelle_actuelle==$occupation_professionnelle_actuelle->id)
                                                        selected
                                                    @endif>{{ $occupation_professionnelle_actuelle->libelle }}</option>
                                                        @endforeach
                                                   </select>
                                               </div>
                                           </div>

                                           <div class="form-group">
                                               <label class="col-md-4 control-label" for="">Nombre d’années d’expérience <span class="text-danger">*</span></label>
                                               <div class="col-md-6">
                                               <div class="input-group">
                                                   <input type="number" min="0" id="nombre_annee_experience" name="nombre_annee_experience" value="{{old('nombre_annee_experience')??$promoteur->nombre_annee_experience}}" class="form-control" placeholder="Nombre d’années d’expérience dans le domaine d’activité " required>
                                                   <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                                   <div class="form-group">
                                    <label class="col-md-4 control-label" for="example-textarea-input">Citer d'autre activité</label>
                                    <div class="col-md-6">
                                        <textarea id="associations" name="associations" rows="9" class="form-control" placeholder="expérience dans d'autres activités">{{old('associations')??$promoteur->associations}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="arrondissement_resident">Membre d'une association?<span class="text-danger">*</span></label>
                                    <div class="col-md-6">
                                        <select id="membre_ass" class="select-select2" name="membre_ass"  data-placeholder="Ou d'une organisation professionnel" onchange="afficher_citer_association();" style="width: 100%;" required>
                                            <option></option>
                                            <option value="1"
                                            @if ($promoteur->membre_ass==1)
                                                selected
                                            @endif>Oui</option>
                                            <option value="2" @if ($promoteur->membre_ass==2)
                                                selected
                                            @endif>Non</option>
                                        </select>
                                    </div>
                                </div>


                                   <div class="form-group associations">
                                       <label class="col-md-4 control-label" for="example-textarea-input">Citer les associations</label>
                                       <div class="col-md-6">
                                           <textarea id="associations" name="associations" rows="9" class="form-control" value="{{old('telephone_promoteur')??$promoteur->associations}}" placeholder="Content.."></textarea>
                                       </div>
                                   </div>
                                   {{-- <div class="form-group">
                                    <label class="col-md-4 control-label"><a href="#modal-terms" data-toggle="modal">Lire et accepter les conditions</a> <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-md-8">
                                        <label class="switch switch-primary" for="val_terms">
                                            <input type="checkbox" id="val_terms" name="val_terms" value="1" onclick="validerterme()">
                                            <span data-toggle="tooltip" title="Lire et accepter les conditions! Pour lire les conditions cliquer sur le lien<.Vous devez accepter avant de pouvoir enregister les données"></span>
                                        </label>
                                    </div>
                                </div> --}}

                                       </fieldset>

                                    </div>

                                   <div class="col-md-8 col-md-offset-4" style="margin-top:20px">
                                        <input class="btn btn-sm btn-warning" href="#" onclick="window.history.go(-1); return false;" value="ANNULER">
                                         <input type="submit"  class="btn btn-sm btn-success" value="ENREGISTRER MES DONNEES">
                                   </div>            <!-- END Form Buttons -->
                         </form>
                     </div>
                 </div>                         <!-- END Wizard with Validation Block -->
@endsection
