@extends('layouts.admin')
@section('gestion', 'active')
@section('souscription-edit', 'active')
    @section('content')
    @section('blank')
    <li>Accueil</li>
    <li>Souscription</li>
    <li><a href="">Détails</a></li>
@endsection
@section('content')
            <div class="col-xs-12 block-content" >
                @if($entreprise->conforme== null)
                @can('avisqualitative_ugp', Auth::user())
                    <a href="#modal-confirm-ugp" data-toggle="modal" onclick="recupererentreprise_id({{$entreprise->id}}, 2)" title="non conforme" class="btn btn-md btn-warning">Inéligible<i class="gi gi-remove_2"></i></a>
                    <a href="#modal-confirm-ugp" data-toggle="modal" onclick="recupererentreprise_id({{$entreprise->id}}, 1)"  title="conforme" class="btn btn-md btn-success">Eligible<i class="fa fa-check"></i></a>
                @endcan
                @endif
        @if($entreprise->conforme!=null && ($entreprise->note_critere_qualitatif === null)) 
            @can('avisqualitative_ugp', Auth::user()) 
                <a href="#modal-note-critere-qualitatif-de-ugp" data-toggle="modal" onclick="recupererentreprise_id({{$entreprise->id}})" title="Noter les critères qualitatifs" class="btn btn-md btn-danger ">Noter les critères qualitatifs<i class="fa fa-check-square-o"></i></a>
             @endcan
        @endif
             @if(!($entreprise->note_critere_qualitatif === null) && $entreprise->decision_ugp==null) 
             @can('avisfinal_ugp', Auth::user()) 
                <a href="#modal-decision-de-ugp" data-toggle="modal" onclick="recupererentreprise_id({{$entreprise->id}})" title="La décision de l'ugp" class="btn btn-md btn-danger avis_ugp">Avis final UGP<i class="fa fa-check-square-o"></i></a>
             @endcan 
           @endif 
        {{-- @can('donner_avis_membre_comite', Auth::user())
            @if(!$aStatuer && $entreprise->conforme!=null)
                <a href="#modal-confirm-rejet" data-toggle="modal" onclick="confirmChangeStatus1({{$entreprise->id}}, {{ Auth::user()->id }})" title="rejeter" class="btn btn-md btn-danger">Défavorable<i class="fa fa-times"></i></a>
                <a href="#modal-confirm-changestatus" data-toggle="modal" onclick="confirmChangeStatus1({{$entreprise->id}}, {{ Auth::user()->id }})" title="Valider" class="btn btn-md btn-success">Favorable<i class="fa fa-check"></i></a>
           @endif 
       @endcan --}}

                            <div class="block full">
                                <!-- Block Tabs Title -->
                                <div class="block-title">

                                    <ul class="nav nav-tabs" data-toggle="tabs">
                                        <li class="active"><a href="#example-tabs2-activity">Identication de la promotrice</a></li>
                                        <li><a href="#example-tabs2-profile">Identification de l'entreprise </a></li>
                                        <li><a href="#indicateurs-entreprise">Indicateurs de l'entreprise </a></li>
                                        <li><a href="#example-tabs2-options" data-toggle="tooltip" title="Les details de l'entreprise"> Details du projet</a></li>
                                        <li><a href="#example-tabs2-pieces">Pièces Jointes</a></li>
                                    @can('acceder.aux_decision_du_dossier', Auth::user()) 
                                         <li><a href="#example-tabs2-decisions">Les decisions</a></li>
                                    @endcan
                                         <a onclick="history.back()" class="btn btn-success pull-right" style="float: right;"><span><i class="fa fa-repeat"></i></span> Fermer </a>
                                    </ul>
                                </div>
                                <div class="tab-content" >
                            <div class="tab-pane  active" id="example-tabs2-activity" style="height:200%;background: #fff">
                                <div class="row" style="text-align: justify;">
                                    <div class="col-md-6">
                                        <div  id="condanation" class="form-group row ">
                                            <p class="col-md-4 control-label labdetail"> <span class="labdetail">Code Promoteur : </span> </p>
                                            <p class="col-md-6" >
                                            <span class="valdetail">
                                                @empty($entreprise->promotrice->code_promoteur)
                                                    Informations non disponible
                                                @endempty
                                                {{$entreprise->promotrice->code_promoteur}}
                                            </span>
                                        </p>
                                    </div>
                                            <div  class="form-group row">
                                                <p class="col-md-4 control-label labdetail"> <span >Nom :  </span> </p>
                                                <p class="col-md-6" >
                                                    <span class="valdetail">
                                                        @empty($entreprise->promotrice->nom)
                                                        Informations non disponible
                                                        @endempty
                                                        {{$entreprise->promotrice->nom}}
                                                    </span>
                                                 </p>
                                            </div>
                                    <div  id="condanation" class="form-group row" >
                                        <p class="col-md-4 control-label labdetail"> <span >Prenom : </span> </p>
                                        <p class="col-md-6" >
                                        <span class="valdetail">
                                            @empty($entreprise->promotrice->prenom)
                                                    Informations non disponible
                                                    @endempty
                                            {{$entreprise->promotrice->prenom}}
                                    </span></p>
                                    </div>

                                <div  id="condanation" class="form-group row">
                                    <p class="col-md-4 control-label labdetail"><span class=""> Genre : </span> </p>
                                        <p class="col-md-6" >
                                        <span class="valdetail">
                                        @empty($entreprise->promotrice->prenom)
                                                    Informations non disponible
                                                    @endempty
                                                    @if ($entreprise->promotrice->type_identite==1)
                                                    Féminin
                                                @endif
                                                  @if ($entreprise->promotrice->type_identite==2)
                                                   Masculin
                                                @endif
                                    </span></p>
                                </div>
                                <div  id="condanation" class="form-group row " >
                                    <p class="col-md-4 control-label"> <span class="labdetail">Date de naissance : </span></p>
                                    <p class="col-md-6" >
                                        <span class="valdetail">
                                        @empty($entreprise->promotrice->datenais)
                                                    Informations non disponible
                                                    @endempty
                                            {{format_date($entreprise->promotrice->datenais)}}
                                    </span>
                                </p>
                                </div>
                                <div  id="condanation" class="form-group row " >
                                    <p class="col-md-4 control-label"> <span class="labdetail">Téléphone : </span></p>
                                    <p class="col-md-6" >
                                        <span class="valdetail">
                                        @empty($entreprise->promotrice->telephone_promoteur)
                                                    Informations non disponible
                                                    @endempty
                                            {{$entreprise->promotrice->telephone_promoteur}}
                                    </span>
                                </p>
                                </div>
                                <div  id="condanation" class="form-group row" >
                                    <p class="col-md-4 control-label"> <span class="labdetail">Mobile(whatsAp) : </span> </p>
                                    <p class="col-md-6" >
                                        <span class="valdetail">
                                        @empty($entreprise->promotrice->mobile_promoteur)
                                                    Informations non disponible
                                                    @endempty
                                            {{$entreprise->promotrice->mobile_promoteur}}
                                </span></p>
                                </div>
                                <div  id="condanation" class="form-group row" >
                                    <p class="col-md-4 control-label labdetail"> <span class="">Email : </span> </p>
                                    <p class="col-md-6" >
                                    <span class="valdetail">
                                        @empty($entreprise->promotrice->email_promoteur)
                                                    Informations non disponible
                                                    @endempty
                                            {{$entreprise->promotrice->email_promoteur}}
                                </span></p>
                                </div>
                                <hr>
                                <div  id="condanation" class="form-group row" >
                                    <p class="col-md-4 control-label labdetail"> <span class="">Region de residence : </span> </p>
                                    <p class="col-md-6" >
                                    <span class="valdetail">
                                        @empty($entreprise->promotrice->region_residence)
                                                    Informations non disponible
                                                    @endempty
                                            {{getlibelle($entreprise->promotrice->region_residence)}}
                                </span></p>
                                </div>
                                <div  id="condanation" class="form-group row " >
                                    <p class="col-md-4 control-label labdetail"> <span class="">Province de residence : </span> </p>
                                    <p class="col-md-6" >
                                    <span class="valdetail">
                                        @empty($entreprise->promotrice->province_residence)
                                                    Informations non disponible
                                                    @endempty
                                            {{getlibelle($entreprise->promotrice->province_residence)}}
                                </span></p>
                                </div>

                            <div  id="condanation" class="form-group row" >
                                <p class="col-md-4 control-label labdetail"> <span class="">Commune de residence : </span> </p>
                                <p class="col-md-6" >
                                <span class="valdetail">
                                    @empty($entreprise->promotrice->commune_residence)
                                                Informations non disponible
                                                @endempty
                                        {{getlibelle($entreprise->promotrice->commune_residence)}}
                            </span></p>
                            </div>
                            <div  id="condanation" class="form-group row" >
                                <p class="col-md-4 control-label labdetail"> <span class="">Secteur/village : </span> </p>
                                <p class="col-md-6" >
                                <span class="valdetail">
                                    @empty($entreprise->promotrice->arrondissement_residence)
                                                Informations non disponible
                                                @endempty
                                        {{getlibelle($entreprise->promotrice->arrondissement_residence)}}
                            </span></p>
                            </div>
                            <div  id="condanation" class="form-group row" >
                                <p class="col-md-4 control-label labdetail"> <span class="">Situation residence : </span> </p>
                                <p class="col-md-6" >
                                <span class="valdetail">
                                    @empty($entreprise->promotrice->situation_residence)
                                                Informations non disponible
                                                @endempty
                                    @if($entreprise->promotrice->situation_residence=1)
                                        Resident
                                    @else
                                        Déplacé
                                    @endif
                            </span></p>
                            </div>

                        </div>
                            <div class="col-md-6">
                                <div  id="condanation" class="form-group row">
                                    <p class="col-md-4 control-label labdetail"> <span class="">Type document identite : </span> </p>
                                    <p class="col-md-6" >
                                        <span class="valdetail">
                                  @empty($entreprise->promotrice->type_identite)
                                        Informations non disponible
                                    @endempty
                                    @if ($entreprise->promotrice->type_identite==1)
                                        CNIB
                                    @endif
                                      @if ($entreprise->promotrice->type_identite==2)
                                        Passport
                                    @endif
                                </span>
                                </p>
                                </div>

                        <div  id="" class="form-group row" >
                            <p class="col-md-4 control-label labdetail"> <span> Réf. d'identite : </span> </p>
                                <p class="col-md-6" >
                                <span class="valdetail">
                                    @empty($entreprise->promotrice->numero_identite)
                                    Informations non disponible
                                    @endempty
                                    {{$entreprise->promotrice->numero_identite}}
                                </span></p>
                        </div>
                            <div  id="" class="form-group row" >
                                <p class="col-md-4 control-label labdetail"> <span>Date d'etablissement : </span> </p>
                                    <p class="col-md-6" >
                                    <span class="valdetail">
                                    @empty($entreprise->promotrice->date_etabli_identite)
                                                    Informations non disponible
                                                    @endempty
                                     {{$entreprise->promotrice->date_etabli_identite}}
                                    </span></p>
                            </div>
                       
                        <div  id="" class="form-group row">
                                <p class="col-md-4 control-label labdetail"> <span class="">Niveau d'instruction</span></p>
                                <p class="col-md-6" >
                                    <span class="valdetail">
                                        @empty($entreprise->promotrice->niveau_instruction)
                                                    Informations non disponible
                                                    @endempty
                                            {{getlibelle($entreprise->promotrice->niveau_instruction)}}
                                    </span>
                                </p>
                        </div>

                        <div  id="" class="form-group row">
                            <p class="col-md-4 control-label labdetail"> <span>Formation en rapport avec l'activité : </span> </p>
                            <div class="col-md-6">
                                <span class="valdetail">
                                    @empty($entreprise->promotrice->formation_en_rapport_avec_activite)
                                                Informations non disponible
                                                @endempty
                                    @if($entreprise->promotrice->formation_en_rapport_avec_activite==1)
                                                Apprentissage sur le tas
                                    @elseif($entreprise->promotrice->formation_en_rapport_avec_activite==2)
                                                Formation Formelle dans le domaine/thème : {{ $entreprise->promotrice->domaine_formation }}
                                    @else
                                        Autre
                                    @endif
                            </span>
                        </div>
                        </div>
                       
                        {{-- <div  id="" class="form-group row" >
                            <p class="col-md-4 control-label labdetail"> <span class="">Compte bancaire?</span></p>
                            <p class="col-md-6" >
                                <span class="valdetail">
                                    @empty($entreprise->promotrice->compte_perso_existe)
                                        Informations non disponible
                                    @endempty
                        @if($entreprise->promotrice->compte_perso_existe=="oui")
                                    Oui à la {{ $entreprise->promotrice->structure_financiere_personne }}
                            @else
                                Non
                            @endif
                                </span>
                            </p>
                    </div> --}}

                        {{-- <div  id="" class="row form-group row">
                            <p class="col-md-6 control-label labdetail"> <span>Membre d'une association : </span> </p>
                            <p class="col-md-6">
                            <span class="valdetail">
                                @empty($entreprise->promotrice->membre_ass)
                                            Informations non disponible
                                            @endempty
                                @if($entreprise->promotrice->membre_ass==1)
                                            Oui à {{ $entreprise->promotrice->associations }}
                                    @else
                                        Non
                                    @endif
                            </span>
                            </p>
                        </div> --}}
                    </div>
                     </div>
                    @if(count($proportion_de_depense_education)!=0)
                     <div class="row">
                        <div class="col-md-4">
                            <h4 class="labdetail">Proportion des dépenses du promoteur dans l'éduction  </h4>
                            <table class="table table-condensed table-bordered" style="text-align: center">
                               <thead style="text-align: center !important">
                                           <tr>
                                               <th style="text-align: center; width:5%">Annee</th>
                                               <th style="text-align: center; width:5%">Pourcentage</th>
       
                                           </tr>
                                     </thead>
                                     <tbody id="tbadys">
                               @foreach($proportion_de_depense_education as $key => $proportion_de_depense_education)
                               <tr>
       
                                            <td>
                                               {{getlibelle($proportion_de_depense_education->annee_id)}}
                                           </td>
                                           <td>
                                               {{$proportion_de_depense_education->pourcentage."%"}}
                                           </td>
                               </tr>
                               @endforeach
                           </tbody>
                           </table>
                        </div>
                        <div class="col-md-4">
                            <h4  class="labdetail">Proportion des dépenses du promoteur dans la santé  </h4>
                            <table class="table table-condensed table-bordered" style="text-align: center">
                               <thead style="text-align: center !important">
                                           <tr>
                                               <th style="text-align: center; width:5%">Annee</th>
                                               <th style="text-align: center; width:5%">Pourcentage</th>
                                           </tr>
                                     </thead>
                                     <tbody id="tbadys">
                               @foreach($proportion_de_depense_sante as $key => $proportion_de_depense_sante)
                               <tr>
                                            <td>
                                               {{getlibelle($proportion_de_depense_sante->annee_id)}}
                                           </td>
                                           <td>
                                               {{$proportion_de_depense_sante->pourcentage."%"}}
                                           </td>
                                           
                               </tr>
                               @endforeach
                           </tbody>
                           </table>
                        </div>
                        <div class="col-md-4">
                            <h4 class="labdetail">Proportion des dépenses du promoteur dans les biens et materiel  </h4>
                            <table class="table table-condensed table-bordered" style="text-align: center">
                               <thead style="text-align: center !important">
                                           <tr>
                                               <th style="text-align: center; width:5%">Annee</th>
                                               <th style="text-align: center; width:5%">Pourcentage</th>
       
                                           </tr>
                                     </thead>
                                     <tbody id="tbadys">
                               @foreach($proportion_de_depense_bien_materiel as $key => $proportion_de_depense_bien_materiel)
                               <tr>
       
                                            <td>
                                               {{getlibelle($proportion_de_depense_bien_materiel->annee_id)}}
                                           </td>
                                           <td>
                                               {{$proportion_de_depense_bien_materiel->pourcentage."%"}}
                                           </td>
                                           
       
                               </tr>
                               @endforeach
                           </tbody>
                           </table>
                        </div>
                     </div>
                     @endif
                          </div>
                               <div class="tab-pane" id="example-tabs2-profile" style="height:300%;background: #fff">
                                        <div class="row" style="text-align: justify;">
                                            <div class="col-md-6">
                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-6 control-label labdetail"><span class="">Denomination de l'entreprise : </span> </p>
                                                        <p class="col-md-6" >
                                                        <span class="valdetail">
                                                        @empty($entreprise->denomination)
                                                                 Informations non disponible
                                                        @endempty
                                                             {{$entreprise->denomination}}
                                                    </span></p>
                                                </div>
                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-6 control-label labdetail"><span class="">Banque partenaire choisi : </span> </p>
                                                        <p class="col-md-6" >
                                                        <span class="valdetail">
                                                            @empty($entreprise->banque_id)
                                                            Informations non disponible
                                                   @else
                                                   {{$entreprise->banque->nom}}
                                                   @endempty
                                                    </span></p>
                                                </div>
                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-6 control-label labdetail"><span class="">Catégorie de l'entreprise : </span> </p>
                                                        <p class="col-md-6" >
                                                        <span class="valdetail">
                                                        @empty($entreprise->aopOuleader)
                                                                 Informations non disponible
                                                        @endempty
                                                             {{$entreprise->aopOuleader}}
                                                    </span></p>
                                                </div>
                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-6 control-label labdetail"><span class="">Email : </span> </p>
                                                        <p class="col-md-6" >
                                                        <span class="valdetail">
                                                        @empty($entreprise->email_entreprise)
                                                                            Informations non disponible
                                                        @endempty
                                                             {{$entreprise->email_entreprise}}
                                                    </span></p>
                                                </div>
                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-6 control-label labdetail"><span class="">Téléphone : </span> </p>
                                                        <p class="col-md-6" >
                                                        <span class="valdetail">
                                                        @empty($entreprise->telephone_entreprise)
                                                                Informations non disponible
                                                                            @endempty
                                                             {{$entreprise->telephone_entreprise}}
                                                    </span></p>
                                                </div>
                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-6 control-label labdetail"><span class="">Region : </span> </p>
                                                        <p class="col-md-6" >
                                                        <span class="valdetail">
                                                        @empty($entreprise->region)
                                                                Informations non disponible
                                                                            @endempty
                                                             {{getlibelle($entreprise->region)}}
                                                    </span></p>
                                                </div>
                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-6 control-label labdetail"><span class="">Province : </span> </p>
                                                        <p class="col-md-6" >
                                                        <span class="valdetail">
                                                        @empty($entreprise->region)
                                                            Informations non disponible
                                                                            @endempty
                                                             {{getlibelle($entreprise->province)}}
                                                    </span></p>
                                                </div>

                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-6 control-label labdetail"><span class="">Commune : </span> </p>
                                                        <p class="col-md-6" >
                                                        <span class="valdetail">
                                                        @empty($entreprise->commune)
                                                              Informations non disponible
                                                                            @endempty
                                                             {{getlibelle($entreprise->commune)}}
                                                    </span></p>
                                                </div>
                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-6 control-label labdetail"><span class="">Secteur/village: </span> </p>
                                                        <p class="col-md-6" >
                                                        <span class="valdetail">
                                                        @empty($entreprise->arrondissement)
                                                                Informations non disponible
                                                                            @endempty
                                                             {{getlibelle($entreprise->arrondissement)}}
                                                    </span></p>
                                                </div>
                                            @if( $entreprise->banque)
                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-6 control-label labdetail"><span class="">Banque partenaire: </span> </p>
                                                        <p class="col-md-6" >
                                                        <span class="valdetail">
                                                        @empty( $entreprise->banque->nom)
                                                                Informations non disponible
                                                                            @endempty
                                                             {{ $entreprise->banque->nom}}
                                                    </span></p>
                                                </div>
                                            @endif
                                               
                                                <div  id="condanation" class="form-group">
                                                    <p class="col-md-6 control-label labdetail"><span class="">Formalisé? : </span> </p>
                                                        <p class="col-md-6" >
                                                        <span class="valdetail">
                                                        @empty($entreprise->formalise)
                                                                            Informations non disponible
                                                            @endempty
                                                        @if($entreprise->formalise==1)
                                                                Oui le {{ $entreprise->date_de_formalisation }} sous la forme juridique {{ getlibelle($entreprise->forme_juridique)}}  avec le {{ getlibelle($entreprise->type_document_de_formalisation) }}  numéro du document: {{ $entreprise->num_rccm }} 
                                                        @else
                                                             Non
                                                        @endif
                                                    </span></p>
                                                </div>
                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-6 control-label labdetail"><span class="">Agrément exigé? : </span> </p>
                                                        <p class="col-md-6" >
                                                        <span class="valdetail">
                                                        @empty($entreprise->agrement_exige)
                                                                Informations non disponible
                                                            @endempty
                                                        @if($entreprise->agrement_exige==1)
                                                                Oui 
                                                        @else
                                                             Non
                                                        @endif
                                                    </span></p>
                                                </div>
                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-6 control-label labdetail"><span class="">Entreprise affectée par la COVID? : </span> </p>
                                                        <p class="col-md-6" >
                                                        <span class="valdetail">
                                                        @empty($entreprise->affecte_par_covid)
                                                                Informations non disponible
                                                            @endempty
                                                        {{ getlibelle($entreprise->affecte_par_covid)  }}
                                                    </span></p>
                                                </div>
                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-6 control-label labdetail">Effet de la COVID :  </p>
                                                        <p class="col-md-6" >
                                                        <span class="valdetail" style="text-justify: auto;">
                                                        @empty($entreprise->description_effect_covid)
                                                                Informations non disponible
                                                            @endempty
                                                        {{ $entreprise->description_effect_covid }}
                                                    </span></p>
                                                </div>
                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-6 control-label labdetail"><span class="">Entreprise affectée par la sécurité? : </span> </p>
                                                        <p class="col-md-6" >
                                                        <span class="valdetail">
                                                        @empty($entreprise->affecte_par_securite)
                                                                Informations non disponible
                                                            @endempty
                                                        {{ getlibelle($entreprise->affecte_par_securite)  }}
                                                    </span></p>
                                                </div> 
                                                <div  id="condanation" class="form-group">
                                                    <p class="col-md-6 control-label labdetail"><span class="">Description de l'effet de la sécurité : </span> </p>
                                                        <p class="col-md-6" >
                                                        <span class="valdetail">
                                                        @empty($entreprise->description_effet_securite)
                                                                Informations non disponible
                                                            @endempty
                                                        {{ $entreprise->description_effet_securite }}
                                                    </span></p>
                                                </div>
                                                @isset($entreprise->capital_detenu_par_femme)
                                                <div  id="condanation" class="form-group">
                                                    <p class="col-md-6 control-label labdetail"><span class="">Compostion : </span> </p>
                                                        <p class="col-md-6" >
                                                        <span class="valdetail">
                                                            {{ getlibelle($entreprise->capital_detenu_par_femme)}} du capital est detenu par des femmes et {{ getlibelle($entreprise->femme_au_ca)}} de femme siègent au CA
                                                    </span></p>
                                                </div>
                                                @endisset
                                                @isset($entreprise->nbre_homme)
                                                <div  id="condanation" class="form-group">
                                                    <p class="col-md-6 control-label labdetail"><span class="">Composé de  : </span> </p>
                                                        <p class="col-md-6" >
                                                        <span class="valdetail">
                                                            {{ $entreprise->nbre_homme}} d'hommes et de {{ $entreprise->nbre_femme}} femmes 
                                                    </span></p>
                                                </div>
                                                @endisset

                                            </div>
                                            <div class="col-md-6 ">
                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-4 control-label labdetail"><span class="">Secteur d'activite : </span> </p>
                                                        <p class="col-md-8" >
                                                        <span class="valdetail">
                                                        @empty($entreprise->secteur_activite)
                                                                            Informations non disponible
                                                                            @endempty
                                                             {{getlibelle($entreprise->secteur_activite)}}
                                                    </span></p>
                                                </div>
                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-4 control-label labdetail"><span class="">Chaine de valeur : </span> </p>
                                                        <p class="col-md-8" >
                                                        <span class="valdetail">
                                                        @empty($entreprise->chaine_de_valeur)
                                                                            Pas de chaine de valeur
                                                                            @endempty
                                                             {{getlibelle($entreprise->chaine_de_valeur)}}
                                                    </span></p>
                                                </div>
                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-4 control-label labdetail"><span class="">Maillon d'activite : </span> </p>
                                                        <p class="col-md-8" >
                                                        <span class="valdetail">
                                                        @empty($entreprise->maillon_activite)
                                                                            Informations non disponible
                                                                            @endempty
                                                             {{getlibelle($entreprise->maillon_activite)}}
                                                    </span></p>
                                                </div>
                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-4 control-label labdetail"><span class="">Nombre d'annee d'activite : </span> </p>
                                                        <p class="col-md-8" >
                                                        <span class="valdetail">
                                                        @empty($entreprise->nombre_annee_existence)
                                                                            Informations non disponible
                                                                            @endempty
                                                             {{$entreprise->nombre_annee_existence}} ans
                                                    </span></p>
                                                </div>
                                                @if($entreprise->aopOuleader=='leader')
                                                    <div  id="condanation" class="form-group row">
                                                        <p class="col-md-4 control-label labdetail"><span class="">Membre d'association : </span> </p>
                                                            <p class="col-md-8" >
                                                            <span class="valdetail">
                                                            @if($entreprise->membre_ass==1)
                                                                Oui {{ $entreprise->ass_de_entreprise_leader}}
                                                            @else
                                                                Non
                                                            @endif       
                                                        </span></p>
                                                    </div>
                                                @endif
                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-4 control-label labdetail"><span class="">Provenance de la clientèle : </span> </p>
                                                        <p class="col-md-8" >
                                                        <span class="valdetail">
                                                        @empty($entreprise->provenance_clientele)
                                                                            Informations non disponible
                                                                            @endempty
                                                             {{getlibelle($entreprise->provenance_clientele)}}
                                                    </span></p>
                                                </div>
                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-4 control-label labdetail"><span class="">Type de la clientele : </span> </p>
                                                        <p class="col-md-8" >
                                                        <span class="valdetail">
                                                        @empty($entreprise->nature_client)
                                                                            Informations non disponible
                                                                            @endempty
                                                             {{getlibelle($entreprise->nature_client)}}
                                                    </span></p>
                                                </div>
                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-4 control-label labdetail"><span class="">Description de l'activite : </span> </p>
                                                        <p class="col-md-8" >
                                                        <span class="valdetail">
                                                        @empty($entreprise->description_activite)
                                                                 Informations non disponible
                                                                            @endempty
                                                             {{$entreprise->description_activite}}
                                                    </span></p>
                                                </div>
                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-4 control-label labdetail"><span class="">Les produits vendus: </span> </p>
                                                        <p class="col-md-8" >
                                                        <span class="valdetail">
                                                        @empty($entreprise->description_activite)
                                                                 Informations non disponible
                                                                            @endempty
                                                             {{$entreprise->description_activite}}
                                                    </span></p>
                                                </div>
                                                
                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-4 control-label labdetail"><span class="">Source d'approvisionnement: </span> </p>
                                                        <p class="col-md-8" >
                                                        <span class="valdetail">
                                                        @empty($entreprise->source_appro)
                                                                            Informations non disponible
                                                                            @endempty
                                                             {{getlibelle($entreprise->source_appro)}}
                                                    </span></p>
                                                </div>
                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-4 control-label labdetail"><span class="">Technologie Utilisée: </span> </p>
                                                        <p class="col-md-8" >
                                                        <span class="valdetail">
                                                        @empty($entreprise->techno_utilise)
                                                                    Informations non disponible
                                                        @endempty
                                                             {{getlibelle($entreprise->techno_utilise)}}
                                                    </span></p>
                                                </div> 
                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-4 control-label labdetail"><span class="">Activités verticales dévéloppées : </span> </p>
                                                        <p class="col-md-8" >
                                                        <span class="valdetail">
                                                        @empty($activite_verticale_devs)
                                                                            Informations non disponible
                                                                            @endempty
                                                            @foreach ($activite_verticale_devs as $activite_verticale_dev )
                                                                    {{getlibelle($activite_verticale_dev->activite)}},
                                                            @endforeach
                                                             
                                                    </span></p>
                                                </div>
                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-4 control-label labdetail"><span class="">Activités verticales à investir : </span> </p>
                                                        <p class="col-md-8" >
                                                        <span class="valdetail">
                                                        @empty($activite_verticale_invests)
                                                                            Informations non disponible
                                                                            @endempty
                                                            @foreach ($activite_verticale_invests as $activite_verticale_invest )
                                                                    {{getlibelle($activite_verticale_invest->activite)}},
                                                            @endforeach
                                                             
                                                    </span></p>
                                                </div>
                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-4 control-label labdetail"><span class="">Activités horizontales dévéloppées : </span> </p>
                                                        <p class="col-md-8" >
                                                        <span class="valdetail">
                                                        @empty($activite_horizontale_devs)
                                                                            Informations non disponible
                                                                            @endempty
                                                            @foreach ($activite_horizontale_devs as $activite_horizontale_dev )
                                                                    {{getlibelle($activite_horizontale_dev->activite)}},
                                                            @endforeach
                                                    </span></p>
                                                </div>
                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-4 control-label labdetail"><span class="">Activités horizontales à investir : </span> </p>
                                                        <p class="col-md-8" >
                                                        <span class="valdetail">
                                                        @empty($activite_horizontale_invests)
                                                                            Informations non disponible
                                                                            @endempty
                                                            @foreach ($activite_horizontale_invests as $activite_horizontale_invest )
                                                                    {{getlibelle($activite_horizontale_invest->activite)}},
                                                            @endforeach
                                                             
                                                    </span></p>
                                                </div>
                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-4 control-label labdetail"><span class="">Niveau de resilience: </span> </p>
                                                        <p class="col-md-8" >
                                                        <span class="valdetail">
                                                        @empty($entreprise->niveau_resilience)
                                                                            Informations non disponible
                                                                            @endempty
                                                             {{getlibelle($entreprise->niveau_resilience)}}
                                                    </span></p>
                                                </div>
                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-4 control-label labdetail"><span class="">Mobilisation de la contrepartie: </span> </p>
                                                        <p class="col-md-8" >
                                                        <span class="valdetail">
                                                        @empty($entreprise->mobililise_contrepartie)
                                                                            Informations non disponible
                                                        @endempty
                                                             {{$entreprise->mobililise_contrepartie}}
                                                    </span></p>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>

                                    </div>
                                    <div class="tab-pane" id="indicateurs-entreprise" style="height:200%;">
                                        <div class="row mt-6" >
                                   @if($entreprise->aopOuleader=='aop')
                                   <div class="col-md-3 ">
                                    <h4>Nombre de membres dans l’AOP</h4>
                                    <table class="table table-condensed table-bordered" style="text-align: center">
                                    <thead style="text-align: center !important">
                                            <tr>
                                                <th style="text-align: center; width:5%">Annee</th>
                                                <th style="text-align: center; width:5%">Nombre</th>
                                            </tr>
                                    </thead>
                                    <tbody id="tbadys">
                                @foreach($nombre_membres as $key => $nombre_membre)
                                <tr>

                                            <td>
                                                {{getlibelle($nombre_membre->annee)}}
                                            </td>
                                            <td>
                                                {{$nombre_membre->quantite}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                </table>
                            </div>
                            <div class="col-md-3 ">
                                <h4>Pourcentage de femmes dans l’AOP</h4>
                                <table class="table table-condensed table-bordered" style="text-align: center">
                                <thead style="text-align: center !important">
                                        <tr>
                                            <th style="text-align: center; width:5%">Annee</th>
                                            <th style="text-align: center; width:5%">Pourcentage</th>
                                        </tr>
                                </thead>
                                <tbody id="tbadys">
                            @foreach($pourcentage_femmes as $key => $pourcentage_femme)
                            <tr>

                                        <td>
                                            {{getlibelle($pourcentage_femme->annee)}}
                                        </td>
                                        <td>
                                            {{$pourcentage_femme->quantite}}%
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            </table>
                        </div>
                                   @endif 
                                   <div class="col-md-3 ">
                                    <h4>Nombre de PME partenaires</h4>
                                    <table class="table table-condensed table-bordered" style="text-align: center">
                                    <thead style="text-align: center !important">
                                            <tr>
                                                <th style="text-align: center; width:5%">Annee</th>
                                                <th style="text-align: center; width:5%">Nombre</th>
                                            </tr>
                                    </thead>
                                    <tbody id="tbadys">
                                @foreach($nombre_de_pme_partenaires as $key => $nombre_de_pme_partenaire)
                                <tr>
    
                                            <td>
                                                {{getlibelle($nombre_de_pme_partenaire->annee)}}
                                            </td>
                                            <td>
                                                {{$nombre_de_pme_partenaire->quantite}} MPME
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                </table>
                            </div>
<div class="col-md-3 ">
                                    <h4>Montant de vos achats auprès d'autres PME détenues par des femmes</h4>
                                    <table class="table table-condensed table-bordered" style="text-align: center">
                                    <thead style="text-align: center !important">
                                            <tr>
                                                <th style="text-align: center; width:5%">Annee</th>
                                                <th style="text-align: center; width:5%">Nombre</th>
                                            </tr>
                                    </thead>
                                    <tbody id="tbadys">
                                @foreach($nombre_de_pme_partenaires_de_la_zones as $key => $nombre_de_pme_partenaires_de_la_zone)
                                <tr>
    
                                            <td>
                                                {{getlibelle($nombre_de_pme_partenaires_de_la_zone->annee)}}
                                            </td>
                                            <td>
                                                {{format_prix($nombre_de_pme_partenaires_de_la_zone->quantite)}} 
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                </table>
                            </div>

                            <div class="col-md-3 ">
                                <h4>Montant des achats auprès des MPME des femmes</h4>
                                <table class="table table-condensed table-bordered" style="text-align: center">
                                <thead style="text-align: center !important">
                                        <tr>
                                            <th style="text-align: center; width:5%">Annee</th>
                                            <th style="text-align: center; width:5%">Montant</th>
                                        </tr>
                                </thead>
                                <tbody id="tbadys">
                            @foreach($montant_des_achats_aupres_des_mpme_des_femmes as $key => $montant_des_achats_aupres_des_mpme_des_femme)
                            <tr>

                                        <td>
                                            {{getlibelle($montant_des_achats_aupres_des_mpme_des_femme->annee)}}
                                        </td>
                                        <td>
                                            {{ format_prix($montant_des_achats_aupres_des_mpme_des_femme->quantite)}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            </table>
                        </div>
   <div class="col-md-3 ">
                                <h4>Montant de financement obtenu auprès des institutions financières</h4>
                                <table class="table table-condensed table-bordered" style="text-align: center">
                                <thead style="text-align: center !important">
                                        <tr>
                                            <th style="text-align: center; width:5%">Annee</th>
                                            <th style="text-align: center; width:5%">Montant</th>
                                        </tr>
                                </thead>
                                <tbody id="tbadys">
                            @foreach($montant_obtenu_aupres_des_institutions_financiaires as $key => $montant_obtenu_aupres_des_institutions_financiaire)
                            <tr>

                                        <td>
                                            {{getlibelle($montant_obtenu_aupres_des_institutions_financiaire->annee)}}
                                        </td>
                                        <td>
                                            {{ format_prix($montant_obtenu_aupres_des_institutions_financiaire->quantite)}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            </table>
                        </div>
                                    <div class="col-md-3 ">
                                        <h4>Chiffre d'affaire</h4>
                                        <table class="table table-condensed table-bordered" style="text-align: center">
                                        <thead style="text-align: center !important">
                                                <tr>
                                                    <th style="text-align: center; width:5%">Annee</th>
                                                    <th style="text-align: center; width:5%">Montant</th>
                                                </tr>
                                        </thead>
                                        <tbody id="tbadys">
                                    @foreach($chiffre_daffaire as $key => $chiffre_daffaire)
                                    <tr>
                                                <td>
                                                    {{getlibelle($chiffre_daffaire->annee)}}
                                                </td>
                                                <td>
                                                    {{format_prix($chiffre_daffaire->quantite)}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    </table>
                                </div>

                 <div class="col-md-3">
                    <h4>Benefice Net Réalisé</h4>
                    <table class="table table-condensed table-bordered" style="text-align: center">
                       <thead style="text-align: center !important">
                                   <tr>
                                       <th style="text-align: center; width:5%">Annee</th>
                                       <th style="text-align: center; width:5%">Montant</th>
                                   </tr>
                        </thead>
                             <tbody id="tbadys">
                       @foreach($benefice_nets as $key => $benefice_nets)
                       <tr>
                           <td>
                                 {{getlibelle($benefice_nets->annee)}}
                            </td>
                            <td>
                                {{format_prix($benefice_nets->quantite)}}
                             </td>
                       </tr>
                       @endforeach
                   </tbody>
                   </table>
                </div>
                <div class="col-md-3">
                    <h4>Salaire Moyen Annuel</h4>
                    <table class="table table-condensed table-bordered" style="text-align: center">
                       <thead style="text-align: center !important">
                                   <tr>
                                       <th style="text-align: center; width:1%">Annee</th>
                                       <th style="text-align: center; width:1%">Montant</th>
                                   </tr>
                             </thead>
                             <tbody id="tbadys">
                       @foreach($salaire_annuelles as $key => $salaire_annuelle)
                       <tr>
                           <td>
                                 {{getlibelle($salaire_annuelle->annee)}}
                            </td>
                            <td>
                                {{format_prix($salaire_annuelle->quantite)}}
                             </td>
                       </tr>
                       @endforeach
                   </tbody>
                   </table>
                </div>
                 </div>
                        <div class="row mt-6" >
                            <div class="col-md-3">
                                <h4>Nombre d'innovation</h4>
                                <table class="table table-condensed table-bordered" style="text-align: center">
                                   <thead style="text-align: center !important">
                                               <tr>
                                                   <th style="text-align: center; width:1%">Annee</th>
                                                   <th style="text-align: center; width:1%">Montant</th>
                                               </tr>
                                         </thead>
                                         <tbody id="tbadys">
                                   @foreach($nombre_innovation as $key => $nombre_innovation)
                                   <tr>
                                       <td>
                                             {{getlibelle($nombre_innovation->annee)}}
                                        </td>
                                        <td>
                                            {{$nombre_innovation->quantite}}
                                         </td>
                                   </tr>
                                   @endforeach
                               </tbody>
                               </table>
                            </div>
                            <div class="col-md-3">
                                <h4>Nombre de nouveau marché</h4>
                                <table class="table table-condensed table-bordered" style="text-align: center">
                                   <thead style="text-align: center !important">
                                               <tr>
                                                   <th style="text-align: center; width:1%">Annee</th>
                                                   <th style="text-align: center; width:1%">Montant</th>
                                               </tr>
                                         </thead>
                                         <tbody id="tbadys">
                                   @foreach($nombre_nouveau_marche as $key => $nombre_nouveau_marche)
                                   <tr>
                                       <td>
                                             {{getlibelle($nombre_nouveau_marche->annee)}}
                                        </td>
                                        <td>
                                            {{$nombre_nouveau_marche->quantite}}
                                         </td>
                                   </tr>
                                   @endforeach
                               </tbody>
                               </table>
                            </div>
                            <div class="col-md-3">
                                <h4>Nombre de produit/service lancé</h4>
                                <table class="table table-condensed table-bordered" style="text-align: center">
                                   <thead style="text-align: center !important">
                                               <tr>
            
                                                   <th style="text-align: center; width:1%">Annee</th>
                                                   <th style="text-align: center; width:1%">Montant</th>
                                               </tr>
                                         </thead>
                                         <tbody id="tbadys">
                                   @foreach($nombre_nouveau_produit as $key => $nombre_nouveau_produit)
                                   <tr>
                                       <td>
                                             {{getlibelle($nombre_nouveau_produit->annee)}}
                                        </td>
                                        <td>
                                            {{$nombre_nouveau_produit->quantite}}
                                         </td>
                                   </tr>
                                   @endforeach
                               </tbody>
                               </table>
                            </div>
                            @if(count($nombre_total_client)!=0)
                            <div class="col-md-3">
                                <h4>Nombre total client</h4>
                                <table class="table table-condensed table-bordered" style="text-align: center">
                                   <thead style="text-align: center !important">
                                               <tr>
            
                                                   <th style="text-align: center; width:1%">Annee</th>
                                                   <th style="text-align: center; width:1%">Montant</th>
                                               </tr>
                                         </thead>
                                         <tbody id="tbadys">
                                   @foreach($nombre_total_client as $key => $nombre_total_client)
                                   <tr>
                                       <td>
                                             {{getlibelle($nombre_total_client->annee)}}
                                        </td>
                                        <td>
                                            {{$nombre_total_client->quantite}}
                                         </td>
                                   </tr>
                                   @endforeach
                               </tbody>
                               </table>
                            </div>
                        @endif
                        </div>
                          
                        
                         <div class="row mt-6" >

                        </div>

            <div class="row mt-6" >
                <div class="col-md-6">
                    <h4>Effectif Temporaire du personnel</h4>
                    <table class="table table-condensed table-bordered" style="text-align: center">
                    <thead style="text-align: center !important">
                            <tr>

                                <th style="text-align: center; width:5%">Annee</th>
                                <th style="text-align: center; width:5%">Homme</th>
                                <th style="text-align: center; width:5%">Femme</th>
                                <th style="text-align: center; width:5%">Total</th>
                            </tr>
                      </thead>
                      <tbody id="tbadys">
                @foreach($effectif_temporaire_entreprises as $key => $effectif_temporaire_entreprise)
                <tr>

                             <td>
                                {{getlibelle($effectif_temporaire_entreprise->annee)}}
                            </td>
                            <td>
                                {{$effectif_temporaire_entreprise->homme}}
                            </td>
                            <td>
                                {{$effectif_temporaire_entreprise->femme}}
                            </td>
                            <td>
                                {{$effectif_temporaire_entreprise->femme + $effectif_temporaire_entreprise->homme }}
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                    </table>
                </div>
            <div class="col-md-6">
                <h4>Effectif Permanent du personnel</h4>
                <table class="table table-condensed table-bordered" style="text-align: center">
                <thead style="text-align: center !important">
                        <tr>

                            <th style="text-align: center; width:5%">Annee</th>
                            <th style="text-align: center; width:5%">Homme</th>
                            <th style="text-align: center; width:5%">Femme</th>
                            <th style="text-align: center; width:5%">Total</th>
                        </tr>
                  </thead>
                  <tbody id="tbadys">
            @foreach($effectif_permanent_entreprises as $key => $effectif_permanent_entreprise)
            <tr>

                         <td>
                            {{getlibelle($effectif_permanent_entreprise->annee)}}
                        </td>
                        <td>
                            {{$effectif_permanent_entreprise->homme}}
                        </td>
                        <td>
                            {{$effectif_permanent_entreprise->femme}}
                        </td>
                        <td>
                            {{$effectif_permanent_entreprise->femme + $effectif_permanent_entreprise->homme }}
                        </td>

                    </tr>
             @endforeach
            </tbody>
            </table>
        </div>
    </div>
            </div>
                            <div class="tab-pane" id="example-tabs2-options" style="height:100%;">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div  id="condanation" class="form-group">
                                                    <p class="col-md-3 control-label"><span class="labdetail">L'idée de projet : </span> </p>
                                                        <p class="col-md-9" style="text-align: justify;">
                                                        <span style="text-align: justify;" class="valdetail">
                                                        @empty($entreprise->description_du_projet)
                                                                Informations non disponible
                                                        @endempty
                                                             {{$entreprise->description_du_projet}}
                                                    </span></p>
                                                </div>
                                            </div>
                                            <div class="col-md-10">
                                                <div  id="condanation" class="form-group">
                                                    <p class="col-md-3 control-label"><span class="labdetail">Cout du projet : </span> </p>
                                                        <p class="col-md-9" style="text-align: justify;">
                                                        <span style="text-align: justify;" class="valdetail">
                                                        @empty($entreprise->cout_projet )
                                                                Informations non disponible
                                                                            @endempty
                                                             {{ format_prix($entreprise->cout_projet)}}
                                                    </span></p>
                                                </div>
                                            </div>
                                            <div class="col-md-10">
                                                <div  id="condanation" class="form-group">
                                                    <p class="col-md-3 control-label"><span class="labdetail">Montant subvention demandée : </span> </p>
                                                        <p class="col-md-9" style="text-align: justify;">
                                                        <span style="text-align: justify;" class="valdetail">
                                                        @empty($entreprise->montant_subvention )
                                                                Informations non disponible
                                                                            @endempty
                                                             {{ format_prix($entreprise->montant_subvention)}}
                                                    </span></p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane" id="example-tabs2-pieces" style="height:800px;">
                                    <div class="control-label">
                                        <h1 class="labdetail">Pièces jointes</h1>
                                        <table class="table table-vcenter table-condensed table-bordered listepdf valdetail"   >
                                                <thead>
                                                        <tr>
                                                            <th>N°</th>
                                                            <th>Type</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                  </thead>
                                                  <tbody id="tbadys">
                                            @foreach($piecejointes as $key => $piecejointe)
                                            <tr>
                                                    <td>
                                                    {{ $key + 1 }}
                                                    </td>
                                                         <td>
                                                            {{getlibelle($piecejointe->type_piece)}}
                                                        </td>
                                            <td>
                                                <a href="{{ route('telechargerpiecejointe',$piecejointe->id)}}"title="télécharger" class="btn btn-xs btn-default"  target="_blank"><i class="fa fa-download"></i> </a>
                                                <a href="{{ route('detaildocument',$piecejointe->id)}}"title="Visualiser le document" class="btn btn-xs btn-default" ><i class="fa fa-eye"></i> </a>
                                            </td>

                                        </tr>
                                    @endforeach
                                 </tbody>
                                </table>
                            </div>
                                    </div>
                                <div class="tab-pane" id="example-tabs2-decisions" style="height:500px;">
                                    <div class="col-md-6">
                                        <h4>Notation</h4>
                                    @foreach ( $entreprise->evaluations as $evaluation )
                                        <div class="row">
                                            <div  id="condanation" class="form-group">
                                                <p class="col-md-7 control-label labdetail"><span class="">{{ $evaluation->indicateur }} : </span> </p>
                                                    <p class="col-md-5" >
                                                    <span class="valdetail">
                                                    @empty($evaluation->note)
                                                    @endempty
                                                        {{$evaluation->note}}
                                                </span></p>
                                            </div>
                                        </div>
                                    @endforeach
                                        <div  id="condanation" class="form-group">
                                            <p class="col-md-7 control-label labdetail"><span class="">Note totale critères quantitatifs : </span> </p>
                                                <p class="col-md-5" >
                                                <span class="valdetail">
                                                @empty($entreprise->noteTotale)
                                                     Informations non disponible
                                                        @endempty
                                                    {{$entreprise->noteTotale}}
                                            </span></p>
                                        </div>
                                        <div  id="condanation" class="form-group">
                                            <p class="col-md-7 control-label labdetail"><span class="">Note critères qualitatifs : </span> </p>
                                                <p class="col-md-5" >
                                                <span class="valdetail">
                                                @empty($entreprise->note_critere_qualitatif)
                                                     Informations non disponible
                                                        @endempty
                                                    {{$entreprise->note_critere_qualitatif}}
                                            </span></p>
                                        </div>
                                        <div  id="condanation" class="form-group">
                                            <p class="col-md-7 control-label labdetail"><span class="">Note totale : </span> </p>
                                                <p class="col-md-5" >
                                                <span class="valdetail">
                                                @empty($entreprise->note_critere_qualitatif)
                                                     Informations non disponible
                                                        @endempty
                                                    {{$entreprise->note_critere_qualitatif +  $entreprise->noteTotale}} 
                                            </span></p>
                                        </div>

                                </div>
                                <div class="col-md-6">
                                    <div  id="condanation" class="form-group">
                                        <p class="col-md-6 control-label labdetail"><span class="">Eligibilité : </span> </p>
                                            <p class="col-md-6" >
                                            <span class="valdetail">
                                            @empty($entreprise->conforme)
                                                Information non disponible
                                            @else
                                            @if($entreprise->conforme==1)
                                                 Eligible
                                            @endif
                                            @if($entreprise->conforme==2)
                                                Inéligible
                                            @endif
                                            @endempty
                                        </span></p>
                                    </div>
                                    <div  id="condanation" class="form-group">
                                        <p class="col-md-6 control-label labdetail"><span class="">Avis de l'UGP : </span> </p>
                                            <p class="col-md-6" >
                                            <span class="valdetail">
                                            @empty($entreprise->decision_ugp)
                                                Informations non disponible
                                             @else
                                             @if ($entreprise->decision_ugp='éligible')
                                                        Favorable
                                            @else
                                                    Défavorable
                                            @endif
                                             @endempty
                                        </span></p>
                                    </div>
                                <div  id="condanation" class="form-group">
                                        <p class="col-md-6 control-label labdetail"><span class="">Observations de l'UGP : </span> </p>
                                            <p class="col-md-6" >
                                            <span class="valdetail">
                                            @empty($entreprise->observation_ugp )
                                                Informations non disponible
                                                @else
                                                 {{$entreprise->observation_ugp}} 
                                             @endempty
                                        </span></p>
                                    </div>
                                    <div  id="condanation" class="form-group">
                                        <p class="col-md-6 control-label labdetail"><span class="">Decison du comité : </span> </p>
                                            <p class="col-md-6" >
                                            <span class="valdetail">
                                            @empty($entreprise->decision_du_comite_phase1)
                                                                Informations non disponible
                                            @else
                                                    {{$entreprise->decision_du_comite_phase1}}
                                             @endempty
                                        </span></p>
                                    </div>
                                @if($entreprise->projet)
                                        <div  id="condanation" class="form-group">
                                            <p class="col-md-6 control-label labdetail"><span class="">Decision du comité sur projet: </span> </p>
                                                <p class="col-md-6" >
                                                <span class="valdetail">
                                                @empty($entreprise->projet->statut)
                                                                    Informations non disponible
                                                @else               
                                                     {{$entreprise->projet->statut}}
                                                @endempty
                                            </span></p>
                                        </div>
                                @if($entreprise->projet->statut=='selectionné')
                                        <div  id="condanation" class="form-group">
                                            <p class="col-md-6 control-label labdetail"><span class="">Date de demande de KYC: </span> </p>
                                                <p class="col-md-6" >
                                                <span class="valdetail">
                                                @empty($entreprise->projet->statut)
                                                                    Informations non disponible
                                                @else          
                                                     {{format_date($entreprise->date_demande_kyc)}}
                                                @endempty
                                            </span></p>
                                        </div>
                                        <div  id="condanation" class="form-group">
                                            <p class="col-md-6 control-label labdetail"><span class="">Date de validation du KYC: </span> </p>
                                                <p class="col-md-6" >
                                                <span class="valdetail">
                                                @empty($entreprise->date_realisation_kyc)
                                                                    Informations non disponible
                                                @else          
                                                     {{ format_date($entreprise->date_realisation_kyc)}}
                                                @endempty
                                            </span></p>
                                        </div>
                                        <div  id="condanation" class="form-group">
                                            <p class="col-md-6 control-label labdetail"><span class="">Resultat du KYC: </span> </p>
                                                <p class="col-md-6" >
                                                <span class="valdetail">
                                                @empty($entreprise->resultat_kyc)
                                                                    Informations non disponible
                                                @else
                                                     {{$entreprise->resultat_kyc}}
                                             @endempty
                                            </span></p>
                                        </div>
                                        <div  id="condanation" class="form-group">
                                            <p class="col-md-6 control-label labdetail"><span class="">Date de signature de l'accord bénéficiare: </span> </p>
                                                <p class="col-md-6" >
                                                <span class="valdetail">
                                                @empty($entreprise->date_de_signature_accord_beneficiaire)
                                                                    Informations non disponible
                                                                   
                                            @else
                                                     {{ format_date($entreprise->date_de_signature_accord_beneficiaire)}} 
                                            @endempty
                                            </span></p>
                                        </div>
                                @endif
                            @endif
                                </div>
                        </div>
                        <div style="clear:bot"></div>
                                </div>
                                <div style="clear:bot"></div>
                            </div>
            <div style="clear:bot"></div>
    </div>
<script src={{ asset("js/vendor/jquery.min.js") }}></script>

@stop




{{-- modal de transmission --}}
{{-- <div id="modal-confirm-etape" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center">
                    <h2 class="modal-title"><i class="fa fa-pencil"></i> Confirmation</h2>
                </div>
                <!-- END Modal Header -->

                <!-- Modal Body -->
                <div class="modal-body">
                           <input type="hidden" name="id_table" id="id_table">
                            <p>Voulez-vous vraiment transmettre le dossier ?</p>
                        <div class="form-group form-actions">
                            <div class="text-right">
                                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-sm btn-primary" onclick="trans_id();">OUI</button>
                            </div>
                        </div>

                </div>
                <!-- END Modal Body -->
            </div>
        </div>
</div> --}}
<div id="modal-decision-de-ugp" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-check"></i> Avis de l'UGP</h2>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_entreprise" id="id_entreprise1">
                <div class="form-group">
                  <label for="">Entrez les observations :</label>
                  <textarea id="observation" name="observation" placeholder="Observation" id="" cols="60" rows="10" onchange="activerbtn('btn_desactive','observation')" aria-describedby="helpId"></textarea>
                </div>
            <div class="form-group form-actions">
                <div class="text-right">
                    <button  class="btn btn-md btn-danger btn_desactive" onclick="save_avis_ugp('inéligible');" disabled>Inéligible</button>
                    <button class="btn btn-md btn-success btn_desactive" onclick="save_avis_ugp('éligible');" disabled>Eligible</button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
            <!-- END Modal Body -->
        </div>
    </div>
</div> 
<div id="modal-note-critere-qualitatif-de-ugp" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-check"></i> Notation</h2>
            </div>
            <div class="modal-body">
                <input type="hidden" name="entreprise" id="entreprise" value="{{ $entreprise->id }}">
                <div class="form-group">
                    <label class=" control-label" for="val_username">Note critère quantitatif</label>
                        <div class="input-group">
                            <input type="number" id="" name="date_de_formalisation" class="form-control"  disabled value="{{ $entreprise->noteTotale }}" >
                        </div>
                </div>
                <div class="form-group">
                    <label class=" control-label" for="val_username">Note critère quantitatif</label>
                        <div class="input-group">
                            <input type="number" id="note_qualitatif" max="100" name="Entre la note qualitatif de l'UGP sur 100" class="form-control"   onchange="activerbtn('btn_valider_note','note_qualitatif')"  >
                        </div>
                </div>
                <p id="note_total"></p>
            <div class="form-group form-actions">
                <div class="text-right">
                    <button  class="btn btn-md btn-danger btn_valider_note" onclick="save_note_qualitatif();"  disabled>Valider</button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
            <!-- END Modal Body -->
        </div>
    </div>
</div>


{{-- modal de transmission --}}


<!-- debut Modal Chambre concerné. -->




<!-- debut Modal Valider Etat juge. -->



<!-- debut Modal Valider Conseiller rapporteur. -->

<!-- Modal de génération de convocation -->



<!-- Modal d'enregistrement de decision -->



<!-- debut Modal Valider Avocat général. -->



<script>
     function recupererentreprise_id(id_entreprise,conforme){
            document.getElementById("id_entreprise").setAttribute("value", id_entreprise);
            document.getElementById("conformite").setAttribute("value", conforme);
    }
    function saveconformite_souscription(){
        $(function(){
            var id_entreprise= $("#id_entreprise").val();
            var conforme= $("#conformite").val();
            var url = "{{ route('souscription.saveconformite') }}";
            $.ajax({
                url: url,
                type:'GET',
                data: {id_entreprise: id_entreprise, conforme : conforme} ,
                error:function(){alert('error');},
                success:function(){
                    $('#modal-confirm-changestatus').hide();
                    location.reload();
                }
            });
            });
    }
    function save_avis_ugp(avis){
        var id_entreprise= $("#id_entreprise").val();
        var observation= $("#observation").val();
        var url = "{{ route('souscription.savedecisionugp') }}";
        $.ajax({
                url: url,
                type:'GET',
                data: {id_entreprise: id_entreprise, observation:observation, avis:avis} ,
                error:function(){alert('error');},
                success:function(){
                    $('#modal-confirm-rejet').hide();
                    location.reload();
                }
            });

    }
    
    function confirmChangeStatus1(id_entreprise, id_user){
            document.getElementById("id_entreprise").setAttribute("value", id_entreprise);
            document.getElementById("id_user").setAttribute("value", id_user);
    }
    function validerdossier(){
        $(function(){
            var id_entreprise= $("#id_entreprise").val();
            var id_user= $("#id_user").val();
            var url = "{{ route('entreprise.statuermembrecomite') }}";
            $.ajax({
                url: url,
                type:'GET',
                data: {id_entreprise: id_entreprise, id_user : id_user} ,
                error:function(){alert('error');},
                success:function(){
                    $('#modal-confirm-changestatus').hide();
                    location.reload();
                }
            });
            });
    }

    function rejeterdossier(){
        $(function(){
            var id_entreprise= $("#id_entreprise").val();
            var id_user= $("#id_user").val();
            var raison= $("#raison_du_rejet").val();
            var url = "{{ route('entreprise.statuermembrecomite') }}";
            $.ajax({
                url: url,
                type:'GET',
                data: {id_entreprise: id_entreprise, id_user : id_user, raison:raison} ,
                error:function(){alert('error');},
                success:function(){
                    $('#modal-confirm-rejet').hide();
                    location.reload();
                }
            });
            });
    }
   function calculer_total(){
    var note_quantitatif= parseInt($("#note_quantitatif").val());
    var note_quanlitatif= parseInt($("#note_quanlitatif").val());

    }
</script>
