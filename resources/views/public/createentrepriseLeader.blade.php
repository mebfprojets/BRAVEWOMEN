@extends("layouts.public")
@section('active_menu', 'active')
@section("main-content")
@section("class", "content")
<p style="background-color: rgb(231, 179, 179); color">Les champs marqué d'étoile en <span style="color:red; font-size:15px;">*</span> rouge sont obligatoires</p>
<div class="block">
    <!-- Wizard with Validation Title -->
    <div class="block-title">
        <h2><strong>Enregistrement des données de l'entreprise / Organisation</h2>
    </div>
    <form class="form-horizontal form-bordered" style="padding-left: 20px"; id="progress-wizard" action="{{ route("entrepriseaopl.store") }}" method="post" enctype="multipart/form-data" >
        @csrf
        <input type="hidden" id="code_promoteur" name="code_promoteur" value="{{ $promoteur_code }}"> 
        <input type="hidden" id="cat_entreprise" name="cat_entreprise" value="{{ $cat_entreprise }}"> 
        <div class="progress progress-striped active">
            <div id="progress-bar-wizard" class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0"></div>
        </div>
                     <div id="progress-first" class="step">                     <!-- END Step Info -->
                                <div class="row">
                                   <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="denomination">Dénomination <span class="text-danger">*</span></label>
                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <input type="text" id="denomination" name="denomination" class="form-control" placeholder="Denomination de l'entreprise/Entreprise Leader..">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            <div class="row">
                                <div class="col-lg-5">
                                            <fieldset>
                                                <legend>Localisation de l'entreprise</legend>
                                                <div class="form-group">
                                                    <label class="control-label" for="region">Region de l'entreprise<span class="text-danger">*</span></label>
                                                        <select id="region_residence" name="region" class="select-select2" data-placeholder="Chosir Region de l'entreprise .." value="{{old("region")}}" onchange="changeValue('region_residence', 'province_residence', {{ env('PARAMETRE_ID_PROVINCE') }});"   style="width:100%;" required>
                                                            <option></option><!-- Required for data-placeholder attribute to work with select2 plugin -->
                                                            @foreach ($regions as $region )
                                                                    <option value="{{ $region->id  }}" {{ old('region') == $region->id ? 'selected' : '' }}>{{ $region->libelle }}</option>
                                                            @endforeach
                                                        </select>

                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label" for="province_residence">Province de l'entreprise<span class="text-danger">*</span></label>
                                                        <select id="province_residence" name="province" class="select-select2" onchange="changeValue('province_residence', 'commune_residence', {{ env('PARAMETRE_ID_COMMUNE') }});" data-placeholder="Chosir la province de l'entreprise .."  style="width: 100%;">
                                                            <option  value="{{ old('province') }}" {{ old('province') == old('province') ? 'selected' : '' }}>{{ getlibelle(old('province')) }}</option>
                                                        </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label" for="example-chosen">Commune/Ville de l'entreprise<span class="text-danger">*</span></label>
                                                        <select id="commune_residence" name="commune" class="select-select2" data-placeholder="Chosir la commune de l'entreprise ..." onchange="changeValue('commune_residence', 'arrondissement_residence', {{ env('PARAMETRE_ID_ARRONDISSEMENT') }});" style="width: 100%;" required>
                                                            <option  value="{{ old('commune') }}" {{ old('commune') == old('commune') ? 'selected' : '' }}>{{ getlibelle(old('commune')) }}</option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                                        </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label" for="arrondissement">Secteur/Village de l'entreprise<span class="text-danger">*</span></label>
                                                        <select id="arrondissement_residence" class="select-select2" name="arrondissement"  data-placeholder="Chosir le village ou le secteur de l'entreprise .." onchange="changeValue('arrondissement_residence', 'secteur_residence', {{ env('PARAMETRE_ID_SECTEUR') }});" style="width: 100%;" required>
                                                            <option  value="{{ old('arrondissement') }}" {{ old('arrondissement') == old('arrondissement') ? 'selected' : '' }}>{{ getlibelle(old('arrondissement')) }}</option>
                                                        </select>
                                                </div>
                                            </div>

                                         <div class="offset-md-1 col-lg-5">
                                            </fieldset>
                                                    <fieldset>
                                                        <legend>Contact de l'entreprise</legend>
                                                        <div class="form-group">
                                                            <label class="control-label" for="email_entreprise">Email <span class="text-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <input  type="email" id="email_entreprise" name="email_entreprise" class="form-control" value="{{old("email_entreprise")}}" placeholder="test@example.com" required >
                                                                </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label" for="val_email">Telephone<span class="text-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <input type="text" id="val_email" name="telephone_entreprise" class="form-control masked_phone" placeholder="numéro de téléphone de l'entreprise" value="{{old("telephone_entreprise")}}" required >
                                                                </div>
                                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        <div class="row">
                            <fieldset>
                                <legend>Informations sur l'activite de l'entreprise</legend>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="control-label" for="val_email">Secteur d'activité de l'entreprise <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <select id="secteur_activite" name="secteur_activite" class="select-select2" data-placeholder="Renseigner le secteur d'activite de votre entreprise" value="{{old("region")}}"   style="width:100%;" required>
                                                        <option></option><!-- Required for data-placeholder attribute to work with select2 plugin -->
                                                        @foreach ($secteur_activites as $secteur_activite )
                                                                <option value="{{ $secteur_activite->id  }}" {{ old('secteur_activite') == $secteur_activite->id ? 'selected' : '' }}>{{ $secteur_activite->libelle }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                        </div>
                                        <div class="form-group">
                                            <label class=" control-label" for="example-chosen">l'entreprise intervient-elle dans une chaîne de valeur? <span class="text-danger">*</span></label>
                                                <select id="inter_chaine_de_valeur" name="dans_une_chaine_de_valeur" class="select-select2" data-placeholder="Intervenez vous dans une chaine de valeur" style="width: 100%;" required onchange="afficherSiOui('inter_chaine_de_valeur','chaine_de_valeur');">
                                                    <option></option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                                   <option value="1">Oui</option>
                                                   <option value="0">Non</option>
                                                </select>
                                        </div>
                                        <div class="form-group chaine_de_valeur" style="display: none">
                                            <label class="control-label " for="">Préciser la chaine de valeur<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input id="" type="text" name="chaine_de_valeur" class="form-control" data-placeholder="Précisez la chaine de valeur" value="{{old("chaine_de_valeur")}}" required >
                                                </div>
                                        </div>
                                        <div class="form-group">
                                            <label class=" control-label" for="example-chosen">Maillon d'activité de la chaîne de valeur<span class="text-danger">*</span></label>
                                                <select id="maillon_activite" name="maillon_activite" class="select-select2" data-placeholder="Choisir le maillon d'activite" style="width: 100%;" required onchange="afficherautre('maillon_activite',  {{ env('VALEUR_ID_AUTRE_MAILLON_ACTIVITE') }} ,'autre_maillon_activite');">
                                                    <option></option>
                                                    @foreach ($maillon_activites as $maillon_activite )
                                                        <option value="{{ $maillon_activite->id  }}" {{ old('maillon_activite') == $maillon_activite->id ? 'selected' : '' }} value="{{ $maillon_activite->id }}">{{ $maillon_activite->libelle }}</option>
                                                    @endforeach
                                                </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label " for="">Nombre d'annee d'existence de l'entreprise<span class="text-danger">*</span><span data-toggle="tooltip" title="Le nombre d'année d'existance de l'entreprise est différent de la date de formalisation de l'entreprise."><i class="fa fa-info-circle"></i></span></label>
                                                <div class="input-group">
                                                    <input id="nombre_annee_existence" type="number" min="0" max="100" name="nombre_annee_existence" class="form-control" data-placeholder="Nombre d'année d'expérience dans l'activité" value="{{old("nombre_annee_existence")}}" required >
                                                </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="example-chosen">l'entreprise est-elle formalisée?<span class="text-danger">*</span></label>
                                                <select id="formalise" name="formalise" class="select-select2" onchange="afficher();" data-placeholder="formalisée?" style="width: 100%;" required>
                                                    <option></option>
                                                    <option value="1" {{ old('formalise') == 1 ? 'selected' : '' }}>Oui</option>
                                                    <option value="2" {{ old('formalise') == 2 ? 'selected' : '' }}>Non</option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                                </select>
                                        </div>
                                </div>
                                    <div class="offset-md-1 col-md-5">
                                        <div class="form-group entreformalise">
                                            <label class=" control-label" for="example-chosen">Type de document de formalisation</label>
                                                <select id="type_document_de_formalisation" name="type_document_de_formalisation" class="select-chosen" data-placeholder="Choisir Le type de document de formalisation" style="width: 100%;" onchange="afficherautre('forme_juridique',  {{ env('VALEUR_ID_AUTRE_FORME_JURIDIQUE') }} ,'autre_forme_juridique');">
                                                    <option></option>
                                                    @foreach ($type_document_formalisations as $type_document_formalisation)
                                                        <option value="{{ $type_document_formalisation->id  }}" {{ old('type_document_de_formalisation') == $type_document_formalisation->id ? 'selected' : '' }} value="{{ $type_document_formalisation->id }}">{{ $type_document_formalisation->libelle }}</option>
                                                    @endforeach
                                                </select>
                                        </div>
                                        <div class="form-group entreformalise">
                                            <label class=" control-label" for="example-chosen">La forme juridique de l'entreprise</label>
                                                <select id="forme_juridique" name="forme_juridique" class="select-chosen" data-placeholder="Choisir la forme juridique" style="width: 100%;" onchange="afficherautre('forme_juridique',  {{ env('VALEUR_ID_AUTRE_FORME_JURIDIQUE') }} ,'autre_forme_juridique');">
                                                    <option></option>
                                                    @foreach ($forme_juridiques_leader as $forme_juridique)
                                                        <option value="{{ $forme_juridique->id  }}" {{ old('forme_juridique') == $forme_juridique->id ? 'selected' : '' }} value="{{ $forme_juridique->id }}">{{ $forme_juridique->libelle }}</option>
                                                    @endforeach
                                                </select>
                                        </div>
                                        <div class="form-group entreformalise">
                                            <label class=" control-label" for="val_email">Référence du document de formalisation </label>
                                                <div class="input-group">
                                                    <input type="text" id="num_rccm" name="num_rccm" class="form-control" placeholder="Entrez la référence du document de formalisation" value="{{old('num_rccm')}}" >
                                                </div>
                                        </div>
                                        <div class="form-group entreformalise">
                                            <label class=" control-label" for="val_username">Date de formalisation</label>
                                                <div class="input-group">
                                                    <input type="text" id="" name="date_de_formalisation" class="form-control datepicker" data-date-format="dd-mm-yyyy" placeholder="Date de formalisation de l'entreprise .." value="{{old('date_de_formalisation')}}" >
                                                </div>
                                        </div>
                                        <div class="entreformalise form-group{{ $errors->has('docrccm') ? ' has-error' : '' }}">
                                            <label class=" control-label" for="docrccm">Joindre une copie du document</label>
                                                <input class="form-control" type="file" id="docrccm" accept=".pdf, .jpeg, .png" name="docrccm"  onchange="VerifyUploadSizeIsOK('docrccm');" placeholder="Charger une copie du RCCM" required>
                                            @if ($errors->has('docrccm'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('docrccm') }}</strong>
                                                </span>
                                                @endif
                                        </div>
                                        <div class="form-group">
                                            <label class=" control-label" for="example-chosen">Un agrément ou une autorisation est-il exigé pour votre activité ?<span class="text-danger">*</span></label>
                                                <select id="agrement_exige" name="agrement_exige" class="select-select2" onchange="afficherSiOui('agrement_exige','aggrementdoc');" data-placeholder="Aggrément exigé pour l'activite?" style="width: 100%;" required>
                                                    <option></option>
                                                    <option value="1" {{ old('agrement_exige') == 1 ? 'selected' : '' }}>Oui</option>
                                                    <option value="2" {{ old('agrement_exige') == 2 ? 'selected' : '' }}>Non</option>
                                                </select>
                                        </div>
                                        <div class="aggrementdoc form-group{{ $errors->has('docagrement') ? ' has-error' : '' }}">
                                            <label class=" control-label" for="docagrement">Joindre le document exigé</label>
                                                <input class="form-control" type="file" id="docagrement" accept=".pdf, .jpeg, .png" name="docagrement" onchange="VerifyUploadSizeIsOK('docagrement');" placeholder="Joindre une copie de l'agrement" required>
                                            @if ($errors->has('docagrement'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('docagrement') }}</strong>
                                                </span>
                                                @endif
                                        </div>
                                        <div class="form-group">
                                            <label class=" control-label" for="example-chosen"> Etes-vous membre d’une association ou d’une organisation professionnelle ? <span class="text-danger">*</span></label>
                                                <select id="membre_ass" name="membre_ass" class="select-select2" data-placeholder="L'entreprise est-elle membre d’une association ou d’une organisation professionnelle ? " style="width: 100%;" required onchange="afficherSiOui('membre_ass','association');">
                                                    <option></option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                                   <option value="1">Oui</option>
                                                   <option value="0">Non</option>
                                                </select>
                                        </div>
                                        <div class="form-group association" style="display: none;">
                                            <label class=" control-label" for="example-textarea-input">Noms des associations et les postes occupés par l'entreprise<span class="text-danger">*</span></label>
                                                <textarea id="ass_de_entreprise_leader" name="ass_de_entreprise_leader" maxlength="500" rows="9" class="form-control" placeholder="Préciser le ou les noms des associations, ainsi que le poste que votre entreprise occupe" autofocus required title="Ce champ est obligatoire">{{old('ass_de_entreprise_leader') }}</textarea>
                                        </div>
                                    </div>
                            </fieldset>
                        </div>
                     </div>
                     <div id="progress-second" class="step">
                            <div class="row">
                                <fieldset>
                                    <legend>Informations sur l'activite</legend>
                                    <div class="col-md-5">
                                    <div class="form-group">
                                        <label class=" control-label" for="compte_dispo">L’AOP dispose-t-elle d’un compte bancaire?<span class="text-danger">*</span><span data-toggle="tooltip" title="L’AOP dispose-t-elle d’un compte dans une institution financière (Banques ou structures de microfinance?"><i class="fa fa-info-circle"></i></span></label>
                                            <select id="compte_dispo" name="compte_dispo" class="select-select2" data-placeholder="L'entreprise dispose t-elle d’un compte dans une banque ou une institution?" style="width: 100%;"  autofocus required title="Ce champ est obligatoire" onchange="afficherSiOui('compte_dispo', 'nom_structure')">
                                                <option></option>
                                                <option value="1" {{ old('compte_dispo') == 1 ? 'selected' : '' }}>Oui</option>
                                                <option value="2" {{ old('compte_dispo') == 2 ? 'selected' : '' }}>Non</option>
                                            </select>
                                    </div>
                                    <div class="form-group nom_structure" >
                                        <label class=" control-label" for="">Précisez le nom de l'institution financiaire</label>
                                            <div class="input-group">
                                                <input type="text" name="structure_financiere_entreprise" class="form-control" placeholder="Précisez le nom de la structure financière" value="{{old("structure_financiere_personne")}}">
                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <label class=" control-label" for="compte_dispo">Avez-vous déjà obtenu un financement(crédit)?<span class="text-danger">*</span><span data-toggle="tooltip" title="l'entreprise a t-elle déjà beneficier d'un prêt auprès d'une institution financière ?"><i class="fa fa-info-circle"></i></span></label>
                                            <select id="beneficier_credit" name="beneficier_credit" class="select-select2" data-placeholder="Avez-vous déjà obtenu un financement des institutions financières?" style="width: 100%;"  autofocus required title="Ce champ est obligatoire">
                                                <option></option>
                                                <option value="1" {{ old('beneficier_credit') == 1 ? 'selected' : '' }}>Oui</option>
                                                <option value="2" {{ old('beneficier_credit') == 2 ? 'selected' : '' }}>Non</option>
                                            </select>
                                    </div>
                                    <div class="form-group">
                                        <label class=" control-label" for="example-textarea-input">Brève description de l'activité<span class="text-danger">*</span></label>
                                            <textarea id="description_activite" name="description_activite" maxlength="500" rows="9" class="form-control" placeholder="en quoi consiste votre activité ? 500 caractères" autofocus required title="Ce champ est obligatoire">{{old('description_activite') }}</textarea>
                                    </div>
                                    <div class="form-group" >
                                        <label class=" control-label" for="">Produits proposés ou vendus</label>
                                            <div class="input-group">
                                                <input type="text" name="produit_vendus" class="form-control" placeholder="préciser les produits proposés par l’entreprise" value="{{old("produit_vendus")}}">
                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <label class=" control-label" for="example-select2">Source d'approvisionement <span class="text-danger">*</span> </label>
                                            <select id="source_appro" name="source_appro" class="select-select2" data-placeholder="Choisir la source" style="width:100%;" autofocus required title="Ce champ est obligatoire" >
                                                <option></option>
                                                @foreach ($source_appros as $source_appro )
                                                    <option value="{{$source_appro->id  }}" {{ old('source_appro') == $source_appro->id ? 'selected' : '' }} value="{{ $source_appro->id }}">{{ $source_appro->libelle }}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                    <div class="form-group">
                                        <label class=" control-label" for="example-select2">Technologie utilisée <span class="text-danger">*</span> </label>
                                            <select id="techno_utilisee" name="techno_utilisee" class="select-select2" data-placeholder="Choisir la technologie utilisée" style="width:100%;" autofocus required title="Ce champ est obligatoire" >
                                                <option></option>
                                                @foreach ($techno_utilisees as $techno_utilisee )
                                                    <option value="{{$techno_utilisee->id  }}" {{ old('techno_utilisee') == $techno_utilisee->id ? 'selected' : '' }} value="{{ $techno_utilisee->id }}">{{ $techno_utilisee->libelle }}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                    <div class="form-group">
                                        <label class=" control-label" for="example-chosen">Provenance de la clientele<span class="text-danger">*</span></label>
                                            <select id="provenance_clientele" name="provenance_clientele" class="select-select2" data-placeholder="Choisir la provenance de votre clientèle" style="width: 100%;" required onchange="afficherautre('provenance_clientele',  {{ env('VALEUR_ID_AUTRE_PROVENANCE_CLIENTELE') }} ,'autre_provenance_clientele');">
                                                <option></option>
                                                @foreach ($provenance_clients as $provenance_client )
                                                <option value="{{$provenance_client->id  }}" {{ old('provenance_clientele') == $provenance_client->id ? 'selected' : '' }} value="{{ $provenance_client->id }}">{{ $provenance_client->libelle }}</option>
                                                @endforeach <!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                            </select>
                                    </div>
                                   
                                    <div class="form-group">
                                        <label class=" control-label" for="example-chosen">Nature de la clientèle<span class="text-danger">*</span></label>
                                            <select id="nature_client" name="nature_client" class="select-select2" data-placeholder="La nature de la clientèle" style="width: 100%;" onchange="afficherautre('nature_client',  {{ env('VALEUR_ID_AUTRE_NATURE_CLIENTELE') }} ,'autre_nature_clientele');" required >
                                                <option></option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                                @foreach ($nature_clienteles as $nature_clientele )
                                                <option value="{{$nature_clientele->id  }}" {{ old('nature_client') == $nature_clientele->id ? 'selected' : '' }} value="{{ $nature_clientele->id }}">{{ $nature_clientele->libelle }}</option>
                                                @endforeach
                                            </select>
                                    </div>

                                    <div class="form-group">
                                        <label class=" control-label" for="example-chosen">Utilisez-vous un un outil de gestion?<span class="text-danger">*</span><span data-toggle="tooltip" title="Disposez-vous d'un outil/système de gestion de votre activité "><i class="fa fa-info-circle"></i></span></label>
                                            <select id="systeme_suivi" name="systeme_suivi" class="select-select2" data-placeholder="Disposez-vous d'un système de suivi" onchange="cachertypeSystem();" style="width: 100%;" autofocus required title="Ce champ est obligatoire" >
                                                <option></option>
                                                <option value="1" {{ old('systeme_suivi') == 1 ? 'selected' : '' }}>Oui</option>
                                                <option value="2" {{ old('systeme_suivi') == 2 ? 'selected' : '' }}>Non</option>

                                            </select>
                                    </div>
                                    <div class="form-group" id="typesyssuivi">
                                        <label class="control-label" for="example-select2">Précisez l’outil ou le système <span data-toggle="tooltip" title="Indiquez le type de système de suivi financière et comptable que vous utilisez "><i class="fa fa-info-circle"></i></span></label>
                                            <select id="type_de_systeme_suivi" name="type_de_systeme_suivi" class="select-select2" data-placeholder="Choisir le type de systeme de suivi" style="width: 100%;" onchange="afficherautre('type_de_systeme_suivi',  {{ env('VALEUR_ID_AUTRE_SYSTEME_DE_SUIVI_ACTIVITE') }} ,'autre_systeme_de_suivi');" >
                                                <option></option>
                                                @foreach ($sys_suivi_activites as $sys_suivi_activite )
                                                    <option value="{{$sys_suivi_activite->id  }}" {{ old('systeme_suivi') == $sys_suivi_activite->id ? 'selected' : '' }} value="{{ $sys_suivi_activite->id }}">{{ $sys_suivi_activite->libelle }}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                   
            
                                    
                                </div>
                                    <div class="offset-md-1 col-md-5">
                                            <div class="form-group">
                                                <label class=" control-label" for="">Cocher les activités verticales développées par l'entreprise? <span data-toggle="tooltip" title="Parmi les activités verticales ci-après, quelles sont les activités menées par votre entreprise ou AOP au profit des membres ou d’autres entreprises de femmes? Cochez les"><i class="fa fa-info-circle"></i></span> </label>
                                                    @foreach ($activites_verticales as $activites_verticale)
                                                    <div class="col-lg-6 checkbox">
                                                        <label><input type="checkbox" name='activites_verticales[]' value="{{ $activites_verticale->id }}"> {{ $activites_verticale->libelle }}</label>
                                                    </div>
                                                    @endforeach
                                                </select>
                                                </div>
                                        <div class="form-group">
                                            <label class=" control-label" for="">Pensez-vous investir dans quelles activités verticales?<span data-toggle="tooltip" title="Parmi les activités horizontales ci-après, Quelles sont les activités que vous menez en sinergie avec d’autres acteurs de votre chaine de valeur ? Cochez les"><i class="fa fa-info-circle"></i></span> </label>
                                                @foreach ($activites_verticales as $activites_verticale)
                                                <div class="col-lg-6 checkbox">
                                                    <label><input type="checkbox" name='activites_verticales_invests[]' value="{{ $activites_verticale->id }}"> {{ $activites_verticale->libelle }}</label>
                                                </div>
                                                @endforeach
                                            </select>
                                    </div>
                                    {{-- <div class="form-group">
                                        <label class=" control-label" for="">Quelles sont les activités horizontales développées? <span data-toggle="tooltip" title="les activités horizontales sont des activités qui permettent à chaque acteur (producteur, transformateur, etc) de renforcer sa position ( dans la chaîne de valeur)"><i class="fa fa-info-circle"></i></span></label>
                                        <select id="example-chosen-multiple" name="activites_horizotales[]" class="select-chosen" data-placeholder="Selectionner les activités horizontales.." style="width: 250px;" multiple>
                                            @foreach ($activites_horizotales as $activites_horizotale)
                                            <option value="{{ $activites_horizotale->id }}">{{ $activites_horizotale->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                    <div class="form-group">
                                        <label class=" control-label" for="">Cocher les activités horizontales développées par l'entreprise? <span data-toggle="tooltip" title="les activités horizontales sont des activités qui permettent à chaque acteur (producteur, transformateur, etc) de renforcer sa position ( dans la chaîne de valeur)"><i class="fa fa-info-circle"></i></span></label>
                                            @foreach ($activites_horizotales as $activites_horizotale)
                                            <div class="col-lg-6 checkbox">
                                                <label><input type="checkbox" name='activites_horizotales[]' value="{{ $activites_horizotale->id }}"> {{ $activites_horizotale->libelle }}</label>
                                            </div>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class=" control-label" for="">Dans quelles activités horizontales l'entreprise va investir?<span data-toggle="tooltip" title="Cochez les activités horizontales dans lesquelles vous comptez investir dans les trois prochaines années"><i class="fa fa-info-circle"></i></span> </label>
                                            @foreach ($activites_horizotales as $activites_horizotale)
                                            <div class="col-lg-6 checkbox">
                                                <label><input type="checkbox" name='activites_horizotales_invests[]' value="{{ $activites_horizotale->id }}"> {{ $activites_horizotale->libelle }}</label>
                                            </div>
                                            @endforeach
                                        </select>
                                    </div>
                                </fieldset>
                            </div>
                        <div class="row">
                            @foreach ($rentabilite_criteres as $rentabilite_critere )
                            <div class="col-md-6">
                            <fieldset>
                                <legend>{{ $rentabilite_critere->libelle }} </legend>
                            @if($rentabilite_critere->id== 41)
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="unite_de_mesure">Unité de mesure<span class="text-danger">*</span><span data-toggle="tooltip" title="Préciser l'unité(tonne, nombre de plat, nombre de tête d'animaux, ...) de mesure de la quantite de produit vendus?"><i class="fa fa-info-circle"></i></span></label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input type="text"  name="unite_de_mesure" value="" class="form-control" placeholder=" renseigner l'unite de mesure" autofocus required title="Ce champ est obligatoire.">
                                        </div>
                                    </div>
                                </div>
                            @endif
                                @foreach ($annees as $annee )
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="val_email">En {{ $annee->libelle }}<span class="text-danger">*</span></label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <input type="number" min=0 id="num_rccm" name="{{ $rentabilite_critere->id }}{{$annee->id }}" value="{{old('{!! $rentabilite_critere->id !!}{!! $annee->id !!}')}}" class="form-control" placeholder=" Saisir la quantité" autofocus required title="Ce champ est obligatoire.">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </fieldset>
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
                                                <input type="number" min="0" id="num_rccm" name="{{ $effectif->id }}{{$annee->id }}homme"  value="{{old('{!! $effectif->id !!}{!! $annee->id !!}homme')}}" class="form-control" placeholder=" Saisir l'effectif" autofocus required title="Ce champ est obligatoire">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="effectif">Femme<span class="text-danger">*</span></label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <input type="number" min="0" id="effectif" name="{{ $effectif->id }}{{$annee->id }}femme" class="form-control" placeholder=" Saisir l'effectif" value="{{old('{!! $effectif->id !!}{!! $annee->id !!}femme')}}" autofocus required title="Ce champ est obligatoire" >
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
                        @foreach ($nouveaute_entreprises as $nouveaute_entreprise )
                        <div class="col-md-4">
                        <fieldset>
                            <legend>{{ $nouveaute_entreprise->libelle }} <span data-toggle="tooltip" title="{{$nouveaute_entreprise->description}}"><i class="fa fa-info-circle"></i></span></legend>
                            @foreach ($annees as $annee)
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="val_email">En {{ $annee->libelle }}<span class="text-danger">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input type="number" min=0 id="num_rccm" name="{{ $nouveaute_entreprise->id }}{{$annee->id }}" value="{{old('{!! $nouveaute_entreprise->id !!}{!! $annee->id !!}')}}" class="form-control" placeholder=" Saisir la quantité" autofocus required title="Ce champ est obligatoire.">

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </fieldset>
                        </div>
                        @endforeach
                    </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="control-label" for="example-chosen">Entreprise affectée par la covid? <span class="text-danger">*</span></label>
                                <select id="affecte_par_covid" name="affecte_par_covid" class="select-select2" onchange="afficher();" data-placeholder="Entreprise affectée par la covid?" style="width: 100%;" required>
                                    <option></option>
                                    @foreach ($ouinon_reponses as $ouinon_reponse )
                                        <option value="{{$ouinon_reponse->id  }}" {{ old('affecte_par_covid') == $ouinon_reponse->id ? 'selected' : '' }} value="{{ $ouinon_reponse->id }}">{{ $ouinon_reponse->libelle }}</option>
                                    @endforeach
                                </select>
               </div>
                        <div class="form-group">
                            <label class=" control-label" for="example-textarea-input">Décrire les effects de COVID-19 sur l'activite<span data-toggle="tooltip" title="Décrivez brièvement comment votre entreprise a été affectée par la pandémie de COVID-19"><i class="fa fa-info-circle"></i></span> </label>
                                <textarea id="description_effect_covid" maxlength="500"  name="description_effect_covid" rows="9" class="form-control" placeholder="Décrivez brièvement comment votre entreprise a été affectée par la pandémie de COVID-19" autofocus required title="Ce champ est obligatoire">{{old('description_activite') }}</textarea>
                        </div>

                    </div>
                    <div class="offset-md-1 col-md-5">
                            <div class="form-group">
                                <label class="control-label" for="example-chosen">Entreprise affectée par la crise sécuritaire? <span class="text-danger">*</span> <span data-toggle="tooltip" title="Votre entreprise a-t-elle été affectée par la pandémie de COVID-19 ? "><i class="fa fa-info-circle"></i></span></label>
                                    <select id="affecte_par_securite" name="affecte_par_securite" class="select-select2" onchange="afficher();" data-placeholder="Affectée par la crise securitaire?" style="width: 100%;" required>
                                        <option></option>
                                        @foreach ($ouinon_reponses as $ouinon_reponse )
                                            <option value="{{$ouinon_reponse->id  }}" {{ old('affecte_par_securite') == $ouinon_reponse->id ? 'selected' : '' }} value="{{ $ouinon_reponse->id }}">{{ $ouinon_reponse->libelle }}</option>
                                        @endforeach<!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                    </select>
                            </div>
                            <div class="form-group">
                                <label class=" control-label" for="example-textarea-input">Décrire les effects de la crise sécuritaire sur l'activite <span data-toggle="tooltip" title="Décrivez brièvement comment votre entreprise a été affectée par la crise securitaire"><i class="fa fa-info-circle"></i></span> </label>
                                    <textarea id="description_effet_securite" name="description_effet_securite" maxlength="300"  rows="9" class="form-control" placeholder="Décrivez brièvement comment votre entreprise a été affectée par la crise securitaire" autofocus required title="Ce champ est obligatoire">{{old('description_activite') }}</textarea>
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                    <label class="control-label" for="example-chosen">Niveau de resilience <span class="text-danger">*</span><span data-toggle="tooltip" title="Une entreprise résiliente est une entreprise solide et flexible. Elle peut se remettre des difficultés, faire face aux risques et surmonter les obstacles. C'est une survivante"><i class="fa fa-info-circle"></i></span></label>
                                <select id="niveau_resilience" name="niveau_resilience" class="select-select2" onchange="afficher();" data-placeholder="Entreprise affectée par la covid?" style="width: 100%;" required>
                                    <option></option>
                                    @foreach ($niveau_resiliences as $niveau_resilience )
                                        <option value="{{$niveau_resilience->id  }}" {{ old('niveau_resilience') == $niveau_resilience->id ? 'selected' : '' }} value="{{ $niveau_resilience->id }}">{{ $niveau_resilience->libelle }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="offset-md-1 col-md-5">
                        <div class="form-group">
                            <label class="control-label" for="example-chosen">Pouvez-vous mobiliser la contrepartie? <span class="text-danger">*</span><span data-toggle="tooltip" title="Pouvez-vous mobiliser une somme d’au moins 24 000 000 FCFA  comme subvention de contrepartie pour financer vos relations de partenariat décrites plus haut?"><i class="fa fa-info-circle"></i></span></label>
                                <select id="mobililise_contrepartie" name="mobililise_contrepartie" class="select-select2" onchange="afficher();" data-placeholder="Pouvez-vous mobiliser une somme d’au moins 9 000 000 FCFA  comme contrepartie pour financer votre entreprise " style="width: 100%;" required>
                                    <option></option>
                                    <option value="Oui" {{ old('mobililise_contrepartie') == 'oui' ? 'selected' : '' }}>Oui</option>
                                    <option value="Non" {{ old('mobililise_contrepartie') == 'oui' ? 'selected' : '' }}>Non</option>
                                </select>
                        </div>
                    </div>
                </div>
                    {{-- <div class="row">
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
                    </div> --}}
                </div>
                        <div class="form-group form-actions" id="bouton">
                            <div class="col-md-5 col-md-offset-4">
                                <input type="reset" class="btn btn-sm btn-warning" id="back3" value="Back">
                                <input type="submit" class="btn btn-sm btn-success" id="next3"  value="Next" >
                            </div>
                        </div>

                                    </form>

            </div>


    </div>
</div>
@endsection
