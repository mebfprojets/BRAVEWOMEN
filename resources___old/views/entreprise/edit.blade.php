@extends('layouts.admin')
@section('administration', 'active')
@section('administration-parametre', 'active')
@section('content')
{{-- <p style="background-color: rgb(231, 179, 179); color">Les champs marqué d'étoile en <span style="color:red; font-size:15px;">*</span> rouge sont obligatoires</p> --}}
<div class="col-md-10">
    <div class="block">
        <!-- Basic Form Elements Title -->
        <div class="block-title">
            <div class="block-options pull-right">
                <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default toggle-bordered enable-tooltip" data-toggle="button" title="Toggles .form-bordered class">No Borders</a>
            </div>
            <h2><strong>Modification</strong>des données de l'entreprise</h2>
        </div>
    <form class="form-horizontal form-bordered" id="progress-wizard" action="{{ route("entreprise.update",$entreprise) }}" method="post" enctype="multipart/form-data" >
        @csrf
        {{ method_field('PUT') }}
        <div class="progress progress-striped active">
            <div id="progress-bar-wizard" class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0"></div>
        </div>
                     <div id="progress-first" class="step">                     <!-- END Step Info -->
                                <div class="row">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="val_denomination">Dénomination<span class="text-danger">*</span></label>
                                        <div class="col-md-6">
                                        <div class="input-group">
                                            <input type="text" id="denomination" name="denomination" class="form-control" value="{{ $entreprise->denomination }}" required onchange="unique();">
                                            <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                        </div>
                                        <p id="error" style="background-color: rgb(231, 179, 179); color">Une entreprise est déja enregistrée sous cette dénomination.Merci de changer le nom de l'entreprise pour pouvoir remplir les autres champs</p>
                                        @if ($errors->has('denomination'))
                                                            <span class="help-block text-danger">
                                                                 <strong>Une entreprise a déja été enregistrée avec ce nom. </strong>
                                                            </span>
                                                    @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                            <fieldset>
                                                <legend>Localisation sur l'entreprise</legend>
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label" for="region">Region<span class="text-danger">*</span></label>
                                                    <div class="col-md-6">
                                                        <select id="region_residence" name="region" class="select-select2" data-placeholder="Choisir votre residence .." value="{{old("region")}}" onchange="changeValue('region_residence', 'province_residence', {{ env('PARAMETRE_ID_PROVINCE') }});"   style="width: 250px;" required>
                                                            <option></option><!-- Required for data-placeholder attribute to work with select2 plugin -->
                                                            @foreach ($regions as $region )
                                                                    <option value="{!!old('region') ?? $region->id!!}"
                                                                        @if ($entreprise->region==$region->id)
                                                                            selected
                                                                        @endif
                                                            >{{ $region->libelle }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label" for="province_residence">Province<span class="text-danger">*</span></label>
                                                    <div class="col-md-6">
                                                        <select id="province_residence" name="province" class="select-select2" onchange="changeValue('province_residence', 'commune_residence', {{ env('PARAMETRE_ID_COMMUNE') }});" data-placeholder="Choisir la province" style="width: 250px;">
                                                            <option value="$entreprise->province">{{ getlibelle($entreprise->province) }}</option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label" for="example-chosen">Commune/Ville<span class="text-danger">*</span></label>
                                                    <div class="col-md-6">
                                                        <select id="commune_residence" name="commune" class="select-select2" data-placeholder="Choisir la commune ..." onchange="changeValue('commune_residence', 'arrondissement_residence', {{ env('PARAMETRE_ID_ARRONDISSEMENT') }});" style="width: 250px;" required>
                                                            <option value="$entreprise->commune">{{ getlibelle($entreprise->commune) }}</option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label" for="arrondissement">Arrondissement/Village<span class="text-danger">*</span></label>
                                                    <div class="col-md-6">
                                                        <select id="arrondissement_residence" class="select-select2" name="arrondissement"  data-placeholder="Arrondissment ou village" onchange="changeValue('arrondissement_residence', 'secteur_residence', {{ env('PARAMETRE_ID_SECTEUR') }});" style="width: 250px;" required>
                                                            <option value="$entreprise->arrondissement">{{ getlibelle($entreprise->arrondissement) }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                         <div class="col-lg-6">
                                            </fieldset>
                                                    <fieldset>
                                                        <legend>Contact</legend>
                                                        <div class="form-group">
                                                            <label class="col-md-4 control-label" for="email_entreprise">Email <span class="text-danger">*</span></label>
                                                            <div class="col-md-6">
                                                                <div class="input-group">
                                                                    <input  type="email" id="email_entreprise" name="email_entreprise" value="{{old('email_entreprise')??$entreprise->email_entreprise}}" class="form-control" placeholder="test@example.com" required >
                                                                    <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-4 control-label" for="val_email">Telephone <span class="text-danger">*</span></label>
                                                            <div class="col-md-6">
                                                                <div class="input-group">
                                                                    <input type="text" id="val_email" name="telephone_entreprise" value="{{old('telephone_entreprise')??$entreprise->telephone_entreprise}}" class="form-control" placeholder="numéro de téléphone de l'entreprise" required >
                                                                    <span class="input-group-addon"><i class="gi gi-earphone"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        <div class="row">
                            <fieldset>
                                <legend>Informations sur l'activite</legend>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-5 control-label" for="val_email">Secteur d'activite <span class="text-danger">*</span></label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <input type="text" id="secteur_activite" name="secteur_activite" value="{{old('secteur_activite')??$entreprise->secteur_activite}}" class="form-control" placeholder="Secteur d'activite" required >
                                                    <span class="input-group-addon"><i class="gi gi-year"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-5 control-label" for="val_email">Nombre d'annee d'activite <span class="text-danger">*</span></label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <input type="number" min=0 id="nombre_annee_existence" name="nombre_annee_existence" value="{{old('nombre_annee_existence')??$entreprise->nombre_annee_existence}}" class="form-control" placeholder="numéro de téléphone de l'entreprise" required >

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-5 control-label" for="example-chosen">Maillon d'activité<span class="text-danger">*</span></label>
                                            <div class="col-md-6">
                                                <select id="maillon_activite" name="maillon_activite" class="select-select2" data-placeholder="Choisir le maillon d'activite" style="width: 250px;" required>
                                                    <option></option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                                    @foreach ($maillon_activites as $maillon_activite )
                                                        <option value="{!!old('maillon_activite') ?? $maillon_activite->id!!}"
                                                            @if ($entreprise->maillon_activite==$maillon_activite->id)
                                                                selected
                                                            @endif>{{ $maillon_activite->libelle }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-5 control-label" for="example-chosen">Entreprise est-elle formalisée <span class="text-danger">*</span></label>
                                            <div class="col-md-6">
                                                <select id="formalise" name="formalise" class="select-select2" onchange="afficher();" data-placeholder="formalisée?" style="width: 100%;" required>
                                                    <option></option>
                                                    <option value="1"
                                                    @if ($entreprise->formalise==1)
                                                        selected
                                                    @endif>Oui</option>
                                                    <option value="2"
                                                    @if ($entreprise->formalise==2)
                                                        selected
                                                    @endif
                                                    >Non</option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group entreformalise">
                                            <label class="col-md-5 control-label" for="val_username">Date de formalisation</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <input type="text" id="example-datepicker" value="{{old('date_de_formalisation')??$entreprise->date_de_formalisation}}" name="date_de_formalisation" class="form-control datepicker" data-date-format="dd-mm-yy" placeholder="Date de formalisation de l'entreprise ..">
                                                    <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group entreformalise">
                                            <label class="col-md-5 control-label" for="val_email">Numéro RCCM</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <input type="text" id="num_rccm" name="num_rccm" value="{{old('date_de_formalisation')??$entreprise->date_de_formalisation}}" class="form-control" placeholder="numéro RCCM" >
                                                    <span class="input-group-addon"><i class="gi gi-year"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group entreformalise">
                                            <label class="col-md-5 control-label" for="example-chosen">Choisir la forme juridique</label>
                                            <div class="col-md-6">
                                                <select id="forme_juridique" name="forme_juridique" class="select-chosen" data-placeholder="Choisir la forme juridique" style="width: 250px;">
                                                    <option></option>
                                                    @foreach ($forme_juridiques as $forme_juridique)
                                                        <option value="{{ $forme_juridique->id }}">{{ $forme_juridique->libelle }}</option>
                                                    @endforeach<!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="entreformalise form-group{{ $errors->has('docrccm') ? ' has-error' : '' }}">
                                            <label class="col-md-5 control-label" for="docidentite">Joindre une copie du RCCM</label>
                                            <div class="col-md-6">
                                                <input class="form-control" type="file" id="docrccm" accept=".pdf, .jpeg, .png" name="docrccm"  placeholder="Charger une copie du RCCM" required>
                                            </div>
                                            @if ($errors->has('docrccm'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('docrccm') }}</strong>
                                                </span>
                                                @endif
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-5 control-label" for="example-chosen">Exigence d'agrement ? <span class="text-danger">*</span></label>
                                            <div class="col-md-6">
                                                <select id="agrement_exige" name="agrement_exige" class="select-select2" onchange="afficher2()" data-placeholder="Choisir le genre" style="width: 250px;" required>
                                                    <option></option>
                                                    <option value="1"
                                                    @if ($entreprise->agrement_exige==1)
                                                        selected
                                                    @endif>Oui</option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                                    <option value="2"
                                                    @if ($entreprise->agrement_exige==2)
                                                        selected
                                                    @endif>Non</option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group aggremendispo">
                                            <label class="col-md-5 control-label" for="example-chosen">Agrement disponible?</label>
                                            <div class="col-md-6">
                                                <select id="agrement_dispo" name="agrement_dispo" class="select-chosen"  data-placeholder="Choisir le genre" style="width: 250px;" >
                                                    <option value="1"
                                                    @if ($entreprise->agrement_dispo==1)
                                                    selected
                                                @endif>Oui</option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                                    <option value="2"
                                                @if ($entreprise->agrement_dispo==2)
                                                    selected
                                                @endif>Non</option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                            </fieldset>
                        </div>
                     </div>
                     <div id="progress-second" class="step">
                            <div class="row">
                                <fieldset>
                                    <legend>Informations sur l'activite</legend>
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label class="col-md-5 control-label" for="example-chosen">Provenance de la clientele<span class="text-danger">*</span></label>
                                            <div class="col-md-6">
                                                <select id="provenance_clientele" name="provenance_clientele" class="select-select2" data-placeholder="Choisir le genre" style="width: 250px;" required>
                                                    <option></option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                                    @foreach ($provenance_clients as $provenance_client )
                                                        <option value="{!!old('provenance_clientele') ?? $provenance_client->id!!}""
                                                            @if ($entreprise->provenance_clientele==$provenance_client->id)
                                                                            selected
                                                                        @endif
                                                            >{{ $provenance_client->libelle }}</option>
                                                    @endforeach <!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-5 control-label" for="example-chosen">Nature clientèle<span class="text-danger">*</span></label>
                                            <div class="col-md-6">
                                                <select id="nature_client" name="nature_client" class="select-select2" data-placeholder="Choisir le genre" style="width: 250px;" required >
                                                    <option></option>
                                                    @foreach ($nature_clienteles as $nature_clientele )
                                                        <option value="{{ $provenance_client->id }}"
                                                            @if ($entreprise->nature_clientele==$nature_clientele->id)
                                                                            selected
                                                                        @endif
                                                            >{{ $nature_clientele->libelle }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-5 control-label" for="example-chosen">Utilisez-vous un systeme suivi <span class="text-danger">*</span></label>
                                            <div class="col-md-6">
                                                <select id="systeme_suivi" name="systeme_suivi" class="select-select2" data-placeholder="En disposez-vous" onchange="cachertypeSystem();" style="width: 250px;" autofocus required title="Ce champ est obligatoire" >
                                                    <option></option>
                                                    <option value="1"
                                                    @if ($entreprise->systeme_suivi==1)
                                                        selected
                                                    @endif>Oui</option>
                                                    <option value="2"
                                                    @if ($entreprise->systeme_suivi==2)
                                                    selected
                                                @endif>Non</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group" id="typesyssuivi">
                                            <label class="col-md-5 control-label" for="example-select2">Type de système</label>
                                            <div class="col-md-6">
                                                <select id="type_sys_suivi" name="type_sys_suivi" class="select-select2" data-placeholder="Choisir le type de systeme de suivi" style="width: 250px;"  >
                                                    <option></option>
                                                    @foreach ($sys_suivi_activites as $sys_suivi_activite )
                                                        <option value="{{ $sys_suivi_activite->id }}"
                                                            @if ($entreprise->type_sys_suivi==$sys_suivi_activite->id)
                                                            selected
                                                        @endif>{{ $sys_suivi_activite->libelle }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-5 control-label" for="compte_dispo">Compte bancaire disponible<span class="text-danger">*</span></label>
                                            <div class="col-md-6">
                                                <select id="compte_dispo" name="compte_dispo" class="select-select2" data-placeholder="Compte bancaire disponible" style="width: 250px;"  autofocus required title="Ce champ est obligatoire">
                                                    <option></option>
                                                    <option value="1"
                                                    @if ($entreprise->compte_dispo==1)
                                                        selected
                                                    @endif>Oui</option>
                                                    <option value="2"
                                                    @if ($entreprise->compte_dispo==2)
                                                        selected
                                                    @endif>Non</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-5 control-label" for="example-select2">Source d'approvisionement <span class="text-danger">*</span> </label>
                                            <div class="col-md-6">
                                                <select id="source_appro" name="source_appro" class="select-select2" data-placeholder="Choisir la source" style="width: 250px;" autofocus required title="Ce champ est obligatoire" >
                                                    <option></option>
                                                    @foreach ($source_appros as $source_appro )
                                                         <option value="{{ $source_appro->id }}"
                                                            @if ($entreprise->source_appro==$source_appro->id)
                                                            selected
                                                        @endif>{{ $source_appro->libelle }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-5 control-label" for="example-textarea-input">Décrire l'activé<span class="text-danger">*</span> </label>
                                            <div class="col-md-6">
                                                <textarea id="description_activite" name="description_activite" rows="9" class="form-control" placeholder="Content.." autofocus required title="Ce champ est obligatoire">{{ $entreprise->description_activite }}</textarea>
                                            </div>
                                        </div>

                                    </div>
                                </fieldset>
                            </div>
                        <div class="row">
                            @foreach ($entrepriseInfos as $entrepriseInfo )
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="my-input">{{ getlibelle($entrepriseInfo->indicateur) }} en {{ getlibelle($entrepriseInfo->annee)}}</label>
                                    <input id="my-input" class="form-control" type="text" name="" value="{{ $entrepriseInfo->quantite  }}">
                                </div>
                            {{-- <fieldset>
                                <legend>{{ $rentabilite_critere->libelle }} </legend>
                                @foreach ($annees as $annee )
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="val_email">En {{ $annee->libelle }}<span class="text-danger">*</span></label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <input type="number" min=0 id="num_rccm" name="{{ $rentabilite_critere->id }}{{$annee->id }}" class="form-control" placeholder=" Saisir la quantité" autofocus required title="Ce champ est obligatoire.">
                                                <span class="input-group-addon"><i class="gi gi-year"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </fieldset> --}}
                            </div>
                            @endforeach
                        </div>

                     </div>
                    <div id="progress-third" class="step">

                    <div class="row">
                        @foreach ($effectifs as $effectif )
                        <div class="col-md-6">
                        <fieldset>
                            <legend>{{ $effectif->libelle }} </legend>
                            @foreach ($annees as $annee )
                                <p>En {{ $annee->libelle }} </p>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="num_rccm">Homme<span class="text-danger">*</span></label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <input type="number" min="0" id="num_rccm" name="{{ $effectif->id }}{{$annee->id }}homme" class="form-control" placeholder=" Saisir l'effectif" autofocus required title="Ce champ est obligatoire">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="effectif">Femme<span class="text-danger">*</span></label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <input type="number" min="0" id="effectif" name="{{ $effectif->id }}{{$annee->id }}femme" class="form-control" placeholder=" Saisir l'effectif" autofocus required title="Ce champ est obligatoire" >
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                        </fieldset>
                        </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <fieldset>
                            <legend>Les principaux investissements en lien avec l’activité existants</legend>
                            <div id="infra" class="col-md-6">
                                <p>Infrastructures existantes</p>
                                <div class="field_wrapper">
                                    <div>
                                        <label for="">Designation</label> <input type="text" name="infrastructure_designation[]" value="" placeholder="designation"/>
                                        <label for="">Quantite</label> <input type="number" name="infrastructure_quantite[]" value="" placeholder="quantite" />
                                        <a href="javascript:void(0);" class="add_button" title="Add field"><span><i class="gi gi-plus"></i></span></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <p>Matériels et équipements existants</p>
                                <div class="field_wrapper2">
                                    <div>
                                        <label for="">Designation</label> <input type="text" name="materiel_designation[]" value="" placeholder="designation"/>
                                        <label for="">Quantite</label> <input type="number" name="materiel_quantite[]" value="" placeholder="quantite" />
                                        <a href="javascript:void(0);" class="add_button2" title="Add field"><span><i class="gi gi-plus"></i></span></a>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                        <div class="form-group form-actions" id="bouton">
                            <div class="col-md-5 col-md-offset-4">
                                <input  type="reset"  class="btn btn-sm btn-warning" id="back3" value="Back">
                                <input type="submit" class="btn btn-sm btn-success" id="next3"  value="Next" >
                            </div>
                        </div>
                                            {{-- <div class="col-md-8 col-md-offset-4">
                                                <input type="reset" class="btn btn-sm btn-warning"  value="ANNULER">
                                                <input type="submit" class="btn btn-sm btn-success" value="ENREGISTRER LES DONNEES">
                                            </div> --}}

                                        <!-- END Form Buttons -->
                                    </form>
                                    <!-- END Wizard with Validation Content -->
                                </div>
                                <!-- END Wizard with Validation Block -->


    </div>
</div>
@endsection
