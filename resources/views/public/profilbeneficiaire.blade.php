@extends("layouts.espace_beneficiaire")
@section('profil', 'active')
@section('content')
<section class="wrapper site-min-height">
<div class="row mt" style="height: 120px;" >
    <div class="col-lg-12">
        <div class="row content-panel">
            <div class="col-md-3 profile-text mt mb centered">
                <div class="right-divider hidden-sm hidden-xs">
                  
                    <h4>@if($entreprise->projet)
                    {{ format_prix($montant_du_plan_soumis) }}</h4>
                    <h6>MONTANT DU PLAN SOUMIS</h6>
                    
                    @endif
                  
                  @if($entreprise->resultat_kyc)
                  <h4 style="color: red">{{ $entreprise->resultat_kyc }}</h4>
                  @else
                  <h4 style="color: red">NON DISPONIBLE</h4>
                  @endif
                  <h6>RESULTAT DU KYC</h6>
                </div>
              </div>
              <!-- /col-md-4 -->
              <div class="col-md-6 profile-text mt mb centered">
                <div class="right-divider hidden-sm hidden-xs">
                <h3>{{ $entreprise->promotrice->nom }} {{ $entreprise->promotrice->prenom }}</h3>
                <div class="row">
                    <div class="col-md-10">
                        <div class="col-md-5"><span style="font-weight: bold;">Code : </span></div>
                        <div class="col-md-7">{{ $entreprise->promotrice->code_promoteur }}</div>
                        <div class="col-md-5"><span style="font-weight: bold;">Nom : </span></div>
                        <div class="col-md-7">{{ $entreprise->promotrice->nom }}</div>
                        <div class="col-md-5"><span style="font-weight: bold;">Prénom : </span></div>
                        <div class="col-md-7">{{ $entreprise->promotrice->prenom }}</div>
                    </div>
                    
                </div>
               
                <br>
                </div> 
            </div>  
              <div class="col-md-3 profile-text mt mb centered">
                    <h4>@if($entreprise->projet)
                    {{ format_prix($total_a_mobiliser) }}</h4>
                 @else
                 0
                 @endif
                  <h6>MONTANT DU PLAN VALIDE</h6>
                  <h4>{{ format_prix($total_avoir) }}</h4>
                  <h6>FOND DISPONIBLE</h6>
                  <h4>{{ format_prix($total_engage) }}</h4>
                  <h6>ENGAGE</h6>
                </div>
              </div>
                  
        </div>
      </div>
</div>
<div class="col-lg-12 mt">
    <div class="row content-panel">
      <div class="panel-heading">
        <ul class="nav nav-tabs nav-justified">
          <li class="active">
            <a data-toggle="tab" href="#overview">Infos personnelles</a>
          </li>
          <li>
            <a data-toggle="tab" href="#contact" class="contact-map">Mon Entreprise</a>
          </li>
          <li>
            <a data-toggle="tab" href="#chiffre" class="contact-map">Mes chiffres</a>
          </li>
          <li>
            <a data-toggle="tab" href="#projet" >Mon projet</a>
          </li>
        </ul>
      </div>
      <!-- /panel-heading -->
      <div class="panel-body">
        <div class="tab-content">
          <div id="overview" class="tab-pane active">
            <div class="row">
              <div class="col-md-6">
                {{-- <textarea rows="3" class="form-control" placeholder="Whats on your mind?"></textarea> --}}
                <div  id="condanation" class="form-group row" >
                  <p class="col-md-4 control-label labdetail"> <span >Nom : </span> </p>
                  <p class="col-md-6" >
                  <span class="valdetail">
                      @empty($entreprise->promotrice->nom)
                              Informations non disponible
                              @endempty
                      {{$entreprise->promotrice->nom}}
              </span></p>
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
          <div  id="condanation" class="form-group row" >
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
              <!-- /col-md-6 -->
              <div class="col-md-6 detailed">
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
     
      <div  id="" class="form-group row" >
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
  </div>

      <div  id="" class="row form-group row">
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
      <a href="#modal-user-data" data-toggle="modal"  class="btn btn-primary btn-lg ">Modifier</a>

              </div>
              <!-- /col-md-6 -->
            </div>
            <!-- /OVERVIEW -->
          </div>
          <!-- /tab-pane -->
          <div id="contact" class="tab-pane">
            <div class="row">
              <div class="col-md-6">
                <div id="condanation" class="form-group row">
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
                                                    <p class="col-md-6 control-label labdetail"><span class="">Catégorie d'entreprise : </span> </p>
                                                        <p class="col-md-6" >
                                                        <span class="valdetail">
                                                        @empty($entreprise->aopOuleader)
                                                                            Informations non disponible
                                                        @else
                                                            {{$entreprise->aopOuleader}}
                                                        @endempty
                                                            
                                                    </span></p>
                                                </div>
                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-6 control-label labdetail"><span class="">Email : </span> </p>
                                                        <p class="col-md-6" >
                                                        <span class="valdetail">
                                                        @empty($entreprise->email_entreprise)
                                                                            Informations non disponible
                                                        @else
                                                        {{$entreprise->email_entreprise}}
                                                        @endempty
                                                             
                                                    </span></p>
                                                </div>
                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-6 control-label labdetail"><span class="">Téléphone : </span> </p>
                                                        <p class="col-md-6" >
                                                        <span class="valdetail">
                                                        @empty($entreprise->telephone_entreprise)
                                                                Informations non disponible
                                                                @else
                                                                {{$entreprise->telephone_entreprise}}
                                                        @endempty
                                                             
                                                    </span></p>
                                                </div>

                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-6 control-label labdetail"><span class="">Region : </span> </p>
                                                        <p class="col-md-6" >
                                                        <span class="valdetail">
                                                        @empty($entreprise->region)
                                                                Informations non disponible
                                                        @else
                                                             {{getlibelle($entreprise->region)}}
                                                        @endempty
                                                    </span></p>
                                                </div>
                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-6 control-label labdetail"><span class="">Province : </span> </p>
                                                        <p class="col-md-6" >
                                                        <span class="valdetail">
                                                        @empty($entreprise->region)
                                                            Informations non disponible
                                                                         @else  
                                                             {{getlibelle($entreprise->province)}}
                                                             @endempty
                                                    </span></p>
                                                </div>

                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-6 control-label labdetail"><span class="">Commune : </span> </p>
                                                        <p class="col-md-6" >
                                                        <span class="valdetail">
                                                        @empty($entreprise->commune)
                                                              Informations non disponible
                                                        @else
                                                             {{getlibelle($entreprise->commune)}}
                                                     @endempty
                                                    </span></p>
                                                </div>
                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-6 control-label labdetail"><span class="">Secteur/village: </span> </p>
                                                        <p class="col-md-6" >
                                                        <span class="valdetail">
                                                        @empty($entreprise->arrondissement)
                                                                Informations non disponible
                                                        @else
                                                             {{getlibelle($entreprise->arrondissement)}}
                                                        @endempty
                                                    </span></p>
                                                </div>
                                            @if($entreprise->banque)
                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-6 control-label labdetail"><span class="">Banque partenaire : </span> </p>
                                                        <p class="col-md-6" >
                                                        <span class="valdetail">
                                                    
                                                        @empty($entreprise->banque->nom)
                                                                            Informations non disponible
                                                        @endempty
                                                             {{$entreprise->banque->nom}}
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
                                                                Oui le {{ $entreprise->date_de_formalisation }} sous la forme juridique {{ $entreprise->forme_juridique }}  avec le numéro RCCM : {{ $entreprise->num_rccm }} 
                                                        @else
                                                             Non
                                                        @endif
                                                    </span></p>
                                                </div>
                                                <div  id="condanation" class="form-group">
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
                                                <div  id="condanation" class="form-group">
                                                    <p class="col-md-6 control-label labdetail"><span class="">Entreprise affectée par la COVID? : </span> </p>
                                                        <p class="col-md-6" >
                                                        <span class="valdetail">
                                                        @empty($entreprise->affecte_par_covid)
                                                                Informations non disponible
                                                            @endempty
                                                        {{ getlibelle($entreprise->affecte_par_covid)  }}
                                                    </span></p>
                                                </div>
                                                <div  id="condanation" class="form-group">
                                                    <p class="col-md-6 control-label labdetail"><span class="">Description de l'effet de la COVID : </span> </p>
                                                        <p class="col-md-6" >
                                                        <span class="valdetail">
                                                        @empty($entreprise->description_effect_covid)
                                                                Informations non disponible
                                                            @endempty
                                                        {{ $entreprise->description_effect_covid }}
                                                    </span></p>
                                                </div>
                                                <div  id="condanation" class="form-group">
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
                                                    <p class="col-md-4 control-label labdetail"><span class="">Nombre d'annee d'activite : </span> </p>
                                                        <p class="col-md-8" >
                                                        <span class="valdetail">
                                                        @empty($entreprise->nombre_annee_existence)
                                                                            Informations non disponible
                                                                            @endempty
                                                             {{getlibelle($entreprise->nombre_annee_existence)}}
                                                    </span></p>
                                                </div>
                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-4 control-label labdetail"><span class="">Nature clientèle : </span> </p>
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
                                                    <p class="col-md-4 control-label labdetail"><span class="">Technologie Utilisée : </span> </p>
                                                        <p class="col-md-8" >
                                                        <span class="valdetail">
                                                        @empty($entreprise->source_appro)
                                                                            Informations non disponible
                                                                            @endempty
                                                             {{getlibelle($entreprise->source_appro)}}
                                                    </span></p>
                                                </div>
                                                <div  id="condanation" class="form-group row">
                                                    <p class="col-md-4 control-label labdetail"><span class="">Nature de la clientele : </span> </p>
                                                        <p class="col-md-8" >
                                                        <span class="valdetail">
                                                        @empty($entreprise->nature_client)
                                                                            Informations non disponible
                                                                            @endempty
                                                             {{getlibelle($entreprise->nature_client)}}
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

      <a href="#modal-entreprise-data" data-toggle="modal"  class="btn btn-primary btn-lg ">Modifier l'entreprise </a>
                        
              </div>
              <!-- /col-md-6 -->
              <div class="col-md-6 detailed">
                
              </div>
              <!-- /col-md-6 -->
            </div>
            <!-- /row -->
          </div>
          <div id="projet" class="tab-pane">
            @if($projet)
            <div class="row">
              <div class="col-md-5">
                <div  id="condanation" class="form-group row">
                
                    <p class="col-md-4 control-label labdetail"><span class="">Titre du projet: </span> </p>
                        <p class="col-md-8" >
                        <span class="valdetail">
                        @empty($projet->titre_du_projet)
                                            Informations non disponible
                                            @endempty
                             {{$projet->titre_du_projet}}
                    </span></p>
                </div>
                <div  id="condanation" class="form-group row">
                    <p class="col-md-4 control-label labdetail"><span class="">Montant du projet: </span> </p>
                        <p class="col-md-8" >
                        <span class="valdetail">
                        @empty($projet->titre_du_projet)
                                            Informations non disponible
                                            @endempty
                            {{ format_prix($projet->investissements->sum('montant')) }}
                    </span></p>
                </div> 
                <div  id="condanation" class="form-group row">
                    <p class="col-md-4 control-label labdetail"><span class="">Subvention demandée: </span> </p>
                        <p class="col-md-8" >
                        <span class="valdetail">
                        @empty($projet->titre_du_projet)
                                            Informations non disponible
                                            @endempty
                            {{ format_prix($projet->investissements->sum('subvention_demandee')) }}
                    </span></p>
                </div> 
                <div  id="condanation" class="form-group row">
                    <p class="col-md-4 control-label labdetail"><span class="">Contrepartie à mobiliser: </span> </p>
                        <p class="col-md-8" >
                        <span class="valdetail">
                        @empty($projet->titre_du_projet)
                                            Informations non disponible
                                            @endempty
                            {{ format_prix($projet->investissements->sum('apport_perso')) }}
                    </span></p>
                </div> 
                <div  id="condanation" class="form-group row">
                    <p class="col-md-4 control-label labdetail"  style="text-align: justify;"><span class="">Objectifs du projet: </span> </p>
                        <p class="col-md-8" >
                        <span class="valdetail">
                        @empty($projet->objectifs)
                                            Informations non disponible
                                            @endempty
                             {{$projet->objectifs}}
                    </span></p>
                </div>
                <div  id="condanation" class="form-group row">
                    <p class="col-md-4 control-label labdetail"  style="text-align: justify;"><span class="">Activité Ménée: </span> </p>
                        <p class="col-md-8" >
                        <span class="valdetail">
                        @empty($projet->activites_menees)
                                            Informations non disponible
                                            @endempty
                             {{$projet->activites_menees}}
                    </span></p>
                </div>
                <div  id="condanation" class="form-group row">
                    <p class="col-md-4 control-label labdetail"><span class="">Mes Atouts: </span> </p>
                        <p class="col-md-8" >
                        <span class="valdetail">
                        @empty($projet->atouts_promoteur)
                                            Informations non disponible
                                            @endempty
                             {{$projet->atouts_promoteur}}
                    </span></p>
                </div>
                <div  id="condanation" class="form-group row">
                    <p class="col-md-4 control-label labdetail"><span class="">Innovations: </span> </p>
                        <p class="col-md-8" >
                        <span class="valdetail">
                        @empty($projet->innovation)
                                            Informations non disponible
                                            @endempty
                             {{$projet->innovation}}
                    </span></p>
                </div>
                @if ($projet->statut == 'soumis')
                    <a href="#modal-pca-update" data-toggle="modal" onclick="edit_pca({{ $projet->id }})"  class="btn btn-success btn-lg ">Modifier le PCA </a>
                @endif
              </div>
              <!-- /col-md-6 -->
            <div class="col-md-7 detailed">
                    <h4>Plan d'investissement Soumis @if ($projet->statut!= 'selectionné')<span><a href="#modal-add-invest" data-toggle="modal" onclick="recupererprojet_id({{ $projet->id }})"><i class="fa fa-plus"></i></a></span> @endif</h4> 
                    <table class="table table-condensed table-bordered" style="text-align: center">
                    <thead style="text-align: center !important">
                            <tr>
                                <th style="text-align: center; width:5%">Designation</th>
                                <th style="text-align: center; width:5%">Montant Soumis</th>
                                <th style="text-align: center; width:5%">Apport Personnel Soumis</th>
                                <th style="text-align: center; width:5%">Subvention Soumis</th>
                                
                            </tr>
                    </thead>
                    <tbody id="tbadys">
                @foreach($projet->investissements as $investissment)
                    <tr >
                        @if ($projet->statut!='selectionné')
                            <td>
                                <a href="#modal-modif-invest" data-toggle="modal"  onclick="edit_investissement({{ $investissment->id }});" >{{getlibelle($investissment->designation)}}</a>
                            </td>
                        @else
                        <td>
                            {{getlibelle($investissment->designation)}}
                        </td>
                        @endif
                        <td>
                            {{format_prix($investissment->montant)}}
                        </td>
                        <td>
                            {{format_prix($investissment->apport_perso)}}
                        </td>
                        <td>
                            {{format_prix($investissment->subvention_demandee)}}
                        </td>

                    </tr>
                    @endforeach
                </tbody>
                </table>
        @if ($projet->statut=='selectionné')
        <h4>Plan d'investissement validé</h4>
        <table class="table table-condensed table-bordered" style="text-align: center">
        <thead style="text-align: center !important">
                <tr>
                    <th style="text-align: center; width:5%">Designation</th>
                    <th style="text-align: center; width:5%">Montant</th>
                    <th style="text-align: center; width:5%">Apport Personnel validé</th>
                    <th style="text-align: center; width:5%">Subvention validée</th>
                    
                </tr>
        </thead>
        <tbody id="tbadys">
        @foreach($projet->investissementvalides as $investissment)
        <tr >
            @if ($projet->statut!='selectionné')
                <td>
                    <a href="#modal-modif-invest" data-toggle="modal"  onclick="edit_investissement({{ $investissment->id }});" >{{getlibelle($investissment->designation)}}</a>
                </td>
            @else

            <td>
                {{getlibelle($investissment->designation)}}
            </td>
            @endif
            <td>
                {{format_prix($investissment->montant_valide)}}
            </td>
            <td>
                {{format_prix($investissment->apport_perso_valide)}}
            </td>
            <td>
                {{format_prix($investissment->subvention_demandee_valide)}}
            </td>

        </tr>
        @endforeach
        </tbody>
        </table>
    
    @endif
                


        @if($projet_piecejointes)
                <div class="row">
    
                    <div class="col-md-11">
                        <div class="block">
                        <div class="block-title">
                         <h4> Documents du PCA  @if ($projet->statut == 'soumis')<span><a href="#modal-add-piece" data-toggle="modal" onclick="recupererprojet_id({{ $projet->id }})"><i class="fa fa-plus"></i></a></span>@endif</h4> 
                      </div>
                        <div class="table-responsive">
                            <table class="table table-vcenter table-condensed table-bordered listepdf valdetail"   > 
                                <thead>
                                        <tr>
                                            <th>N°</th>
                                            <th>Type</th>
                                            <th>Actions</th>
                                        </tr>
                                  </thead>
                                  <tbody id="tbadys">
                            @foreach($projet_piecejointes as $key => $piecejointe)
                            <tr>
                                    <td>
                                    {{ $key + 1 }}
                                    </td>
                                    @if ($projet->statut !='selectionné')
                                    <td>
                                        <a href="#modal-modif-pj" data-toggle="modal"  onclick="edit_piecejointe({{ $piecejointe->id }});" > {{getlibelle($piecejointe->type_piece)}} </a>
                                    </td>
                                    @else
                                    <td>
                                         {{getlibelle($piecejointe->type_piece)}} 
                                    </td>
                                    @endif
                                    
                                        
                            <td>
                                <a href="{{ route('telechargerpiecejointe',$piecejointe->id)}}"title="télécharger" class="btn btn-xs btn-default"  target="_blank"><i class="fa fa-download"></i> </a>
                                {{-- <a href="{{ route('detaildocument',$piecejointe->id)}}"title="Visualiser le document" class="btn btn-xs btn-default" ><i class="fa fa-eye"></i> </a> --}}
                            </td>
                    
                        </tr>
                    @endforeach
                    </tbody>
                    </table>
                          </div>
                    </div>
                </div>
                </div>
        @endif
          
</div>
              <!-- /col-md-6 -->
            </div>
            @else
            <h4>Projet non enregistré</h4>
            @endif
        </div>
          <div id="chiffre" class="tab-pane">
            <div class="row mt-6" >
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
                     <h4>Quantite de produit vendus </h4>
                     <table class="table table-condensed table-bordered" style="text-align: center">
                        <thead style="text-align: center !important">
                                    <tr>
                                        <th style="text-align: center; width:5%">Annee</th>
                                        <th style="text-align: center; width:5%">Qantite</th>

                                    </tr>
                              </thead>
                              <tbody id="tbadys">
                        @foreach($produit_vendus as $key => $produit_vendus)
                        <tr>

                                     <td>
                                        {{getlibelle($produit_vendus->annee)}}
                                    </td>
                                    <td>
                                        {{$produit_vendus->quantite. " ". $produit_vendus->unite_de_mesure }}
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
          <!-- /tab-pane -->

         
          <!-- /tab-pane -->
        </div>
        <!-- /tab-content -->
      </div>
      <!-- /panel-body -->
    </div>
    <!-- /col-lg-12 -->
</div>

</section>
</div>
@endsection
@section('modal')
<div id="modal-user-data" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Modifier mes données</h2>
            </div>
           
            <div class="modal-body">
                <form  id="form-validation" action="{{route('updateprofilbeneficiaire',$promotrice)}}" method="get"  class="form-horizontal style-form">
                    <fieldset>
                        <legend>Infos personnelles</legend>
                    
                        <div class="row">
                            <div class="col-lg-6" style='margin-left:10px;'>
                                      <fieldset>
                                             <legend>Informations générales</legend>
                                                     <div class="form-group ">
                                                         <label class="control-label" for="nom_promoteur">Nom <span class="text-danger">*</span></label>
                                                         <div class="input-group col-md-10">
                                                             <input type="text" id="nom_promoteur" name="nom_promoteur" class="form-control"  value="{{$promotrice->nom}}" placeholder="Entrez votre nom" title="Ce champ est obligatoire" required >
                                                             @if ($errors->has('nom'))
                                                                     <span class="help-block">
                                                                          <strong>{{ $errors->first('nom_promoteur') }}</strong>
                                                                     </span>
                                                             @endif
                                                         </div>
                                                 </div>
                                                 <div class="form-group">
                                                     <label class="control-label" for="val_username">Prénom (s) <span class="text-danger">*</span></label>
                                                         <div class="input-group col-md-10">
                                                             <input type="text" id="prenom_promoteur" name="prenom_promoteur" class="form-control" value="{{$promotrice->prenom}}" placeholder="Entrez le prenom.." required="Ce champ est obligatoire">
                                                         </div>
                                                 </div>
                                                 <div class="form-group">
                                                     <label class="control-label " for="vl_username">Date de naissance<span class="text-danger">*</span></label>
                                                         <div class="input-group col-md-10">
                                                             <input type="text" id="datenais_promoteur" name="datenais_promoteur" value="{{format_date($promotrice->datenais)}}" class="form-control datepicker" data-date-format="dd-mm-yyyy" placeholder="Entrer votre date de naissance.." required="Ce champ est obligatoire">
                                                         </div>
                                                 </div>
                                                
                                
                                                 <div class="form-group">
                                                     <label class=" control-label" for="example-chosen">Genre<span class="text-danger">*</span></label>
                                                     <div class="input-group col-md-10">
                                                         <select id="genre" name="genre" class="form-control" data-placeholder="Choisir le genre" style="width: 100%;" required="Ce champ est obligatoire" title="Ce champ est obligatoire">
                                                             <option></option>
                                                             <option value="1" @if($promotrice->genre==1)
                                                                 selected
                                                             @endif>Féminin</option>
                                                             <option value="2"  @if($promotrice->genre==2)
                                                                selected
                                                            @endif>Masculin</option>
                                                         </select>
                                                      </div>
                                                 </div>
                                                 <div class="form-group">
                                                     <label class=" control-label" for="val_username">Télephone Principal:<span class="text-danger">*</span><span data-toggle="tooltip" title="Ce numéro de téléphone ne sera pas utilise pour d'autre souscription"><i class="fa fa-info-circle"></i></span></label>
                                                         <div class="input-group col-md-10">
                                                             <input type="text" id="telephone_promoteur" name="telephone_promoteur" class="form-control masked_phone" value="{{$promotrice->telephone_promoteur}}" placeholder="Votre numéro de télephone" required="Ce champ est obligatoire">
                                                         </div>
                                                         @if ($errors->has('telephone_promoteur'))
                                                         <span class="help-block text-danger">
                                                              <strong>Un promoteur a déja été enregistré avec ce numéro de telephone</strong>
                                                         </span>
                                                     @endif
                                                 </div>
                                                 <div class="form-group">
                                                     <label class=" control-label" for="val_username">Mobile (WhatsApp)</label>
                                                         <div class="input-group col-md-10">
                                                             <input type="text" id="mobile_promoteur" name="mobile_promoteur" value="{{$promotrice->mobile_promoteur }}" class="form-control masked_phone" placeholder="Votre numéro de télephone WhatsApp " >
                                                         </div>
                                                 </div>
                                                 <div class="form-group">
                                                     <label class=" control-label" for="val_email">Email <span class="text-danger">*</span><span data-toggle="tooltip" title="Cet adresse sera utilisé pour les notifications sur votre dossier par email "><i class="fa fa-info-circle"></i></span></label>
                                                         <div class="input-group col-md-10">
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
                                                                 <div class="input-group col-md-10">
                                                                     <select id="type_identite_promoteur" name="type_identite_promoteur" data-placeholder="Choisir type identite" class="form-control" style="width: 100%;" required>
                                                                         <option></option>
                                                                         <option value="1" @if($promotrice->type_identite ==1)
                                                                             selected
                                                                         @endif >CNIB</option>
                                                                         <option value="2" @if($promotrice->type_identite ==2)
                                                                            selected
                                                                        @endif>Passport</option>
                                                                     </select>
                                                                    </div>
                                                             </div>
                                                             <div class="form-group">
                                                                 <label class=" control-label" for="">Numéro <span class="text-danger">*</span></label>
                                                                 <div class="input-group col-md-10">
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
                                                          
                                                             <div class="input-group col-md-10">
                                                             <input type="text"  value="{{ format_date($promotrice->date_etabli_identite) }}" name="date_identification" class="form-control datepicker" data-date-format="dd-mm-yyyy">
                                                     </div>
                                            </div>
                                             <div class="form-group{{ $errors->has('docidentite') ? ' has-error' : '' }}">
                                                 <label class=" control-label" for="docidentite">Joindre une copie<span class="text-danger">*</span></label>
                                                <div class="input-group col-md-10"> 
                                                 <input class="form-control" type="file" name="docidentite" id="docidentite" accept=".pdf, .jpeg, .png"   placeholder="Charger une copie du document d'identification" >
                                                 @if ($errors->has('docidentite'))
                                                     <span class="help-block">
                                                         <strong>{{ $errors->first('docidentite') }}</strong>
                                                     </span>
                                                 @endif
                                                </div>
                                         </div>
                                         <legend>Compétence</legend>
                                         <div class="form-group">
                                            <label class=" control-label" for="example-chosen">Niveau d'instruction<span class="text-danger">*</span></label>
                                            <div class="input-group col-md-10">
                                                <select id="niveau_instruction" name="niveau_instruction"  value=""  class="form-control" data-placeholder="Selectionnez votre région de residence .." style="width: 100%;" required>
                                                  
                                                    <option></option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                                    
                                                    @foreach ($niveau_instructions as  $niveau_instruction )
                                                            <option value="{{ $niveau_instruction->id  }}" {{ old('niveau_instruction') == $niveau_instruction->id ? 'selected' : '' }}
                                                                @if($promotrice->niveau_instruction ==$niveau_instruction->id)
                                                                    selected
                                                                @endif>{{ $niveau_instruction->libelle }}</option>
                                                    @endforeach
                                                </select>
                                              </div>
                                        </div>
                                        <div class="form-group">
                                            <label class=" control-label" for="example-chosen">Formation (s) en rapport avec l’activité<span class="text-danger">*</span><span data-toggle="tooltip" title="Comment vous vous êtes formé sur l'activité que vous menez comme activité de l'entreprise "><i class="fa fa-info-circle"></i></span></label>
                                            <div class="input-group col-md-10">
                                            <select id="formation_activite" name="formation_activite" class="form-control" data-placeholder="Le mode de formation en relation avec l'activite" style="width: 100%;" required onchange="afficherautre('formation_activite',  2 ,'domaine_formation');">
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
                                      </div>
                                        <div class="form-group" id="domaine_formation">
                                            <label class="control-label" for="">Précisez le domaine ou thème</label>
                                            <div class="input-group col-md-10">
                                                <input type="text"  name="domaine_formation" class="form-control" data-placeholder=""="Précisez le domaine de formation " value="{{old("domaine_formation")}}" >
                                                <span class="input-group-addon"><i class="gi gi-learning"></i></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class=" control-label" for="">Expérience <span class="text-danger">*</span></label>
                                            <div class="input-group col-md-10">
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
                                <div class="input-group col-md-10"> 
                                <select id="region_residence" name="region_residence"  value="{{old("region_promoteur")}}" onchange="changeValue('region_residence', 'province_residence', {{ env('PARAMETRE_ID_PROVINCE') }});" class="form-control" data-placeholder="Selectionnez votre région de residence .." style="width: 100%;" required>
                                        <option></option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                        @foreach ($regions as $region )
                                                <option value="{{ $region->id  }}" {{ old('region_residence') == $region->id ? 'selected' : '' }}
                                                    @if($promotrice->region_residence==$region->id)
                                                        selected
                                                    @endif>{{ $region->libelle }}</option>
                                        @endforeach
                                    </select>
                                  </div>
                            </div>
                            <div class="form-group">
                                <label class=" control-label" for="example-chosen">Province<span class="text-danger">*</span></label>
                                <div class="input-group col-md-10"> 
                                <select id="province_residence" name="province_residence" class="form-control" onchange="changeValue('province_residence', 'commune_residence', {{ env('PARAMETRE_ID_COMMUNE') }});" data-placeholder="Selectionnez votre province de residence .." style="width: 100%" required>
                                        <option value="{{$promotrice->province_residence }}" selected >{{ getlibelle($promotrice->province_residence ) }}</option>
                                        {{-- <option  value="{{ old('province_residence') }}" {{ old('province_residence') == old('province_residence') ? 'selected' : '' }}>{{ getlibelle(old('province_residence')) }}</option><!-- Required for data-placeholder attribute to work with Chosen plugin --> --}}
                                    </select>
                            </div>
                          </div>
                        </div>
                        <div class=" offset-md-1 col-md-6">
                            <div class="form-group">
                                <label class=" control-label" for="example-chosen">Commune/Ville<span class="text-danger">*</span></label>
                                <div class="input-group col-md-10"> 
                                <select id="commune_residence" name="commune_residence"  class="form-control" value="{{old("commune_residence")}}" data-placeholder="Selectionnez votre commune de residence .." onchange="changeValue('commune_residence', 'arrondissement_residence', {{ env('PARAMETRE_ID_ARRONDISSEMENT') }});" style="width: 100%;" required>
                                        <option value="{{$promotrice->commune_residence }}" selected>{{ getlibelle($promotrice->commune_residence) }}</option>
                                        {{-- <option value="{{ old('commune_residence') }}" {{ old('commune_residence') == old('commune_residence') ? 'selected' : '' }}>{{ getlibelle(old('commune_residence')) }}</option> --}}
                                </select>
                            </div>
                          </div>
                        
                            <div class="form-group">

                                <label class=" control-label" for="arrondissement_resident">Secteur/Village<span class="text-danger">*</span></label>
                                <div class="input-group col-md-10">   
                                <select id="arrondissement_residence" class="form-control" value="{{old("arrondissement_residence")}}" name="arrondissement_residence"  data-placeholder="Selectionnez votre village ou secteur de residence .." onchange="changeValue('arrondissement_residence', 'secteur_residence', {{ env('PARAMETRE_ID_SECTEUR') }});" style="width: 100%;" required>
                                        <option value="{{$promotrice->arrondissement_residence }}" selected>{{ getlibelle($promotrice->arrondissement_residence) }}</option>
                                       
                                        {{-- <option value="{{ old('arrondissement_residence') }}" {{ old('arrondissement_residence') == old('arrondissement_residence') ? 'selected' : '' }}>{{ getlibelle(old('arrondissement_residence')) }}</option> --}}
                                    </select>
                            </div>
                          </div>
                            <div class="form-group">
                                <label class=" control-label" for="example-chosen">Situation résidence<span class="text-danger">*</span></label>
                                <div class="input-group col-md-10">  
                                <select id="example-chosen" name="situation_residence" class="form-control" value="{{old("situation_residence")}}"  data-placeholder="Quelle est votre situation de residence .." style="width: 100%;" required>
                                        <option></option>
                                        <option value="1" {{ old('situation_residence') == 1 ? 'selected' : '' }}
                                        @if ($promotrice->situation_residence=1)
                                            selected
                                        @endif>Resident</option>
                                        <option value="2" {{ old('situation_residence') == 2 ? 'selected' : '' }} 
                                        @if ($promotrice->situation_residence=2)
                                            selected
                                        @endif>Déplacé</option>
                                    </select>
                            </div>
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


<div id="modal-entreprise-data" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Modifier Les données de l'entreprise</h2>
            </div>
            <!-- END Modal Header -->

            <!-- Modal Body -->
            <div class="modal-body">
                <form  id="form-validation" action="{{route('updateEntrepriseBeneficiaire',$entreprise)}}" method="get"  class="form-horizontal style-form">
                    <fieldset>
                        <legend>Infos personnelles</legend>
                    
                        <div class="row">
                            <div class="col-lg-6" style='margin-left:10px;'>
                                      <fieldset>
                                             <legend>Informations générales</legend>
                                                     <div class="form-group ">
                                                         <label class="control-label" for="nom_promoteur">Denomination <span class="text-danger">*</span></label>
                                                         <div class="input-group col-md-10">
                                                             <input type="text" id="denomination" name="denomination" class="form-control"  value="{{$entreprise->denomination}}" placeholder="Entrez votre nom" title="Ce champ est obligatoire" required >
                                                             @if ($errors->has('nom'))
                                                                     <span class="help-block">
                                                                          <strong>{{ $errors->first('denomination') }}</strong>
                                                                     </span>
                                                             @endif
                                                         </div>
                                                 </div>
                                                 <div class="form-group">
                                                     <label class="control-label" for="val_username">Email <span class="text-danger">*</span></label>
                                                         <div class="input-group col-md-10">
                                                             <input type="text" id="email_entreprise" name="email_entreprise" class="form-control" value="{{$entreprise->email_entreprise}}" placeholder="Entrez le prenom.." required="Ce champ est obligatoire">
                                                         </div>
                                                 </div>
                                                 <div class="form-group">
                                                     <label class="control-label " for="vl_username">Télephone<span class="text-danger">*</span></label>
                                                         <div class="input-group col-md-10">
                                                             <input type="text" id="telephone_entreprise" name="telephone_entreprise" value="{{$entreprise->telephone_entreprise}}" class="form-control dur" date-format="dd-mm-yyyy" placeholder="Entrer votre date de naissance.." required="Ce champ est obligatoire">
                                                         </div>
                                                 </div>
                                                 </fieldset>
                                                     </div>
                                                     <div class="offset-md-1 col-lg-5">
                                                        <fieldset>
                                                             <legend></legend>
                                                             <div class="form-group">
                                                                <label class=" control-label" for="example-chosen">Entreprise formalisée?<span class="text-danger">*</span></label>
                                                                <div class="input-group col-md-10">
                                                                    <select id="formalise" name="formalise" class="form-control" data-placeholder="Entreprise formalisé?" style="width: 100%;" >
                                                                        <option></option>
                                                                        <option value="1" @if($entreprise->formalise==1)
                                                                            selected
                                                                        @endif>Oui</option>
                                                                        <option value="2"  @if($entreprise->formalise==2)
                                                                           selected
                                                                       @endif>Non</option>
                                                                    </select>
                                                                 </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label " for="vl_username">Date de formalisation<span class="text-danger">*</span></label>
                                                                    <div class="input-group col-md-10">
                                                                        <input type="text" id="date_de_formalisation" name="date_de_formalisation" value="{{format_date($entreprise->date_de_formalisation)}}" class="form-control datepicker" data-date-format="dd-mm-yyyy" placeholder="Entrez le date de formalisation de l'entreprise.." required="Ce champ est obligatoire">
                                                                    </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class=" control-label" for="example-chosen">Forme juridique<span class="text-danger">*</span></label>
                                                                <div class="input-group col-md-10">
                                                                    <select id="forme_juridique" name="forme_juridique" class="form-control" data-placeholder="Renseigner la forme juridique" style="width: 100%;"  >
                                                                        <option></option>
                                                                        @foreach ($forme_juridiques as  $forme_juridique )
                                                                        <option value="{{ $forme_juridique->id  }}" {{ old('niveau_instruction') == $forme_juridique->id ? 'selected' : '' }}
                                                                            @if($entreprise->forme_juridique ==$forme_juridique->id)
                                                                                selected
                                                                            @endif>{{ $forme_juridique->libelle }}</option>
                                                                @endforeach
                                                                    </select>
                                                                 </div>
                                                            </div>
                                                            <div class="form-group{{ $errors->has('doc_formalisation') ? ' has-error' : '' }}">
                                                                <label class=" control-label" for="doc_formalisation">Joindre une copie du document de formalisation<span class="text-danger">*</span></label>
                                                               <div class="input-group col-md-10"> 
                                                                <input class="form-control" type="file" name="doc_formalisation" id="doc_formalisation" accept=".pdf, .jpeg, .png"   placeholder="Charger une copie du document d'identification" >
                                                                @if ($errors->has('doc_formalisation'))
                                                                    <span class="help-block">
                                                                        <strong>{{ $errors->first('doc_formalisation') }}</strong>
                                                                    </span>
                                                                @endif
                                                               </div>
                                                        </div>
                                                             <div class="form-group">
                                                                <label class=" control-label" for="example-chosen">Secteur d'activité<span class="text-danger">*</span></label>
                                                                <div class="input-group col-md-10">
                                                                    <select id="secteur_dactivite" name="secteur_dactivite" class="form-control" data-placeholder="Choisir le genre" style="width: 100%;" required="Ce champ est obligatoire" title="Ce champ est obligatoire">
                                                                        <option></option>
                                                                        @foreach ($secteur_activites as  $secteur_activite )
                                                                        <option value="{{ $secteur_activite->id  }}" {{ old('niveau_instruction') == $secteur_activite->id ? 'selected' : '' }}
                                                                            @if($entreprise->secteur_activite ==$secteur_activite->id)
                                                                                selected
                                                                            @endif>{{ $secteur_activite->libelle }}</option>
                                                                @endforeach
                                                                    </select>
                                                                 </div>
                                                            </div>
                                                            <div class="form-group">
                                                               <label class=" control-label" for="example-chosen">Maillon d'activité<span class="text-danger">*</span></label>
                                                               <div class="input-group col-md-10">
                                                                   <select id="maillon_dactivite" name="maillon_dactivite" class="form-control" data-placeholder="Choisir le genre" style="width: 100%;" required="Ce champ est obligatoire" title="Ce champ est obligatoire">
                                                                       <option></option>
                                                                       @foreach ($maillon_activites as  $maillon_activite )
                                                                       <option value="{{ $maillon_activite->id  }}" {{ old('niveau_instruction') == $maillon_activite->id ? 'selected' : '' }}
                                                                           @if($entreprise->maillon_activite ==$maillon_activite->id)
                                                                               selected
                                                                           @endif>{{ $maillon_activite->libelle }}</option>
                                                               @endforeach
                                                                   </select>
                                                                </div>
                                                           </div>
                                                           <div class="form-group">
                                                               <label class=" control-label" for="example-chosen">Nombre d'année d'activité {{ $entreprise->nombre_annee_existence }}<span class="text-danger">*</span></label>
                                                               <div class="input-group col-md-10">
                                                                   <select id="nb_annee_activite" name="nb_annee_activite" class="form-control" data-placeholder="Choisir le genre" style="width: 100%;" required="Ce champ est obligatoire" title="Ce champ est obligatoire">
                                                                       <option></option>
                                                                       @foreach ($nb_annee_activites as  $nb_annee_activite )
                                                                       <option value="{{ $nb_annee_activite->id  }}" {{ old('niveau_instruction') == $nb_annee_activite->id ? 'selected' : '' }}
                                                                           @if($entreprise->nombre_annee_existence == $nb_annee_activite->id)
                                                                               selected
                                                                           @endif>{{ $nb_annee_activite->libelle }}</option>
                                                                   @endforeach
                                                                   </select>
                                                                </div>
                                                           </div>
                                                           <div class="form-group">
                                                            <label class=" control-label" for="example-chosen">Nature clientèle<span class="text-danger">*</span></label>
                                                            <div class="input-group col-md-10">
                                                                <select id="maillon_dactivite" name="nb_annee_dactivite" class="form-control" data-placeholder="Choisir le genre" style="width: 100%;" required="Ce champ est obligatoire" title="Ce champ est obligatoire">
                                                                    <option></option>
                                                                 @foreach ($nature_clienteles as  $nature_clientele )
                                                                    <option value="{{ $nature_clientele->id  }}" {{ old('niveau_instruction') == $nature_clientele->id ? 'selected' : '' }}
                                                                        @if($entreprise->nature_client ==$nature_clientele->id)
                                                                            selected
                                                                        @endif>{{ $nature_clientele->libelle }}</option>
                                                                @endforeach
                                                                </select>
                                                             </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class=" control-label" for="example-chosen">Technologie utilisée<span class="text-danger">*</span></label>
                                                            <div class="input-group col-md-10">
                                                                <select id="techno_utilise" name="techno_utilise" class="form-control" data-placeholder="Choisir le genre" style="width: 100%;" required="Ce champ est obligatoire" title="Ce champ est obligatoire">
                                                                    <option></option>
                                                                 @foreach ($techno_utilisees as  $techno_utilisee )
                                                                    <option value="{{ $techno_utilisee->id  }}" {{ old('niveau_instruction') == $techno_utilisee->id ? 'selected' : '' }}
                                                                        @if($entreprise->techno_utilise ==$techno_utilisee->id)
                                                                            selected
                                                                        @endif>{{ $techno_utilisee->libelle }}</option>
                                                                @endforeach
                                                                </select>
                                                             </div>
                                                        </div>
                                         </fieldset> 
                                         </div>
                                     </div>
                    <div class="row">
                        <legend>Localisation de l'entreprise</legend>
                        <div class="col-md-5" style="margin-left: 10px;">
                            <div class="form-group">
                                <label class=" control-label" for="example-chosen">Region<span class="text-danger">*</span></label>
                                <div class="input-group col-md-10"> 
                                <select id="region_residence" name="region_residence"  value="{{old("region_promoteur")}}" onchange="changeValue('region_residence', 'province_residence', {{ env('PARAMETRE_ID_PROVINCE') }});" class="form-control" data-placeholder="Selectionnez votre région de residence .." style="width: 100%;" required>
                                        <option></option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                        @foreach ($regions as $region )
                                                <option value="{{ $region->id  }}" {{ old('region_residence') == $region->id ? 'selected' : '' }}
                                                    @if($entreprise->region==$region->id)
                                                        selected
                                                    @endif>{{ $region->libelle }}</option>
                                        @endforeach
                                    </select>
                                  </div>
                            </div>
                            <div class="form-group">

                                <label class=" control-label" for="example-chosen">Province<span class="text-danger">*</span></label>
                                <div class="input-group col-md-10"> 
                                <select id="province_residence" name="province_residence" class="form-control"  onchange="changeValue('province_residence', 'commune_residence', {{ env('PARAMETRE_ID_COMMUNE') }});" data-placeholder="Selectionnez votre province de residence .." style="width: 100%" required>
                                        <option value="{{$entreprise->province }}" selected >{{ getlibelle($promotrice->province_residence ) }}</option>
                                        {{-- <option  value="{{ old('province_residence') }}" {{ old('province_residence') == old('province_residence') ? 'selected' : '' }}>{{ getlibelle(old('province_residence')) }}</option><!-- Required for data-placeholder attribute to work with Chosen plugin --> --}}
                                    </select>
                            </div>
                          </div>
                        </div>
                        <div class=" offset-md-1 col-md-6">
                            <div class="form-group">
                                <label class=" control-label" for="example-chosen">Commune/Ville<span class="text-danger">*</span></label>
                                <div class="input-group col-md-10"> 
                                <select id="commune_residence" name="commune_residence"  class="form-control" value="{{old("commune_residence")}}" data-placeholder="Selectionnez votre commune de residence .." onchange="changeValue('commune_residence', 'arrondissement_residence', {{ env('PARAMETRE_ID_ARRONDISSEMENT') }});" style="width: 100%;" required>
                                        <option value="{{$entreprise->commune }}" selected>{{ getlibelle($promotrice->commune_residence) }}</option>
                                        {{-- <option value="{{ old('commune_residence') }}" {{ old('commune_residence') == old('commune_residence') ? 'selected' : '' }}>{{ getlibelle(old('commune_residence')) }}</option> --}}
                                </select>
                            </div>
                          </div>
                        
                            <div class="form-group">

                                <label class=" control-label" for="arrondissement_resident">Secteur/Village<span class="text-danger">*</span></label>
                                <div class="input-group col-md-10">   
                                <select id="arrondissement_residence" class="form-control" value="{{old("arrondissement_residence")}}" name="arrondissement_residence"  data-placeholder="Selectionnez votre village ou secteur de residence .." onchange="changeValue('arrondissement_residence', 'secteur_residence', {{ env('PARAMETRE_ID_SECTEUR') }});" style="width: 100%;" required>
                                        <option value="{{$entreprise->arrondissement }}" selected>{{ getlibelle($entreprise->arrondissement) }}</option>
                                       
                                        {{-- <option value="{{ old('arrondissement_residence') }}" {{ old('arrondissement_residence') == old('arrondissement_residence') ? 'selected' : '' }}>{{ getlibelle(old('arrondissement_residence')) }}</option> --}}
                                    </select>
                            </div>
                          </div>
                            
                        </div>
                    </div>  
                    </fieldset>
                    
                    <div class="form-group form-actions">
                        <div class="col-xs-12 text-right">
                            <button type="submit" class="btn btn-sm btn-primary">Enregistrer</button>
                            <button type="button"  onclick="reload()" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>

                        </div>
                    </div>
                </form>
            </div>
            <!-- END Modal Body -->
        </div>
    </div>
</div>
<div id="modal-pca-update" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Modifier le PCA</h2>
            </div>
            <div class="modal-body">
                <form id="form-validation" method="POST"  action="{{route('pca.modifier')}}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                    {{ csrf_field() }}
                   
            <div class="row">
                <input type="hidden" id="pca_id" name="pca_id">
                <div class="form-group col-md-6">
                    <label class=" control-label" for="example-chosen">Selectionner le redacteur du PCA<span class="text-danger">*</span></label>
                        <select id="coach_u" name="coach"  value="{{old("coach")}}"  class="form-control" data-placeholder="Selectionner le coach ayant appuyer à l'elaboration du PCA .." style="width: 80%;" required>
                            <option></option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                            @foreach ($coachs as $coach )
                                    <option value="{{ $coach->id  }}" {{ old('coach') == $coach->id ? 'selected' : '' }}>{{ $coach->nom }} {{ $coach->prenom }}</option>
                            @endforeach
                        </select>
                </div>
                <div class="form-group col-md-6">
                    <label class=" control-label" for="example-chosen">Choisir la banque partenaire locale<span class="text-danger">*</span></label>
                        <select id="banque_choisi_u" name="banque_choisi"  value="{{old("region_promoteur")}}"  class="form-control" data-placeholder="Selectionner la banque partenaire locale .." style="width: 80%;" required>
                            <option></option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                            @foreach ($banques as $banque )
                                    <option value="{{ $banque->id}}">{{ $banque->nom }}</option>
                            @endforeach
                        </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-11" style="margin-left:0px;">
                    <label class="control-label" for="name">Titre du projet : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input id="titre_projet" type="text" class="form-control" name="titre_projet" placeholder="Cout de l'investissement" value="{{ old('cout') }}" required autofocus >
                            <span class="input-group-addon"><i class="gi gi-user"></i></span>
                        @if ($errors->has('titre_projet'))
                        <span class="help-block">
                            <strong>{{ $errors->first('titre_projet') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5" style="margin-left:10px;">
                    <div class="form-group">
                        <label class=" control-label" for="example-bio">Objectifs du projet</label>
                            <textarea id="objectif_projet" name="objectifs" rows="5" maxlength="500" class="form-control" placeholder="Décrire les activités du projet.." required></textarea>
                    </div>
                    <div class="form-group">
                        <label class=" control-label" for="example-email">Activités menées</label>
                        <textarea id="activite_menee" name="activite_menee" rows="5"  maxlength="500"  class="form-control" placeholder="Décrire les activités du projet.." required></textarea>
                    </div>
                </div>
                <div class="col-md-6" style="margin-left:10px;">
                    <div class="form-group">
                        <label class=" control-label" for="example-bio">Atouts du promoteur ou de l’entreprise</label>
                            <textarea id="atout_promo" name="atouts_entreprise" rows="5"  maxlength="500"  class="form-control" placeholder="De quels atouts que l’entreprise dispose pour conduire le projet (Qualification du personnel, expérience, niveau d’investissement disponible, surface financière, etc.) ? Quels sont ses forces ?  " required></textarea>
                        
                    </div>
                    <div class="form-group">
                        <label class=" control-label" for="example-email">Caractère innovant du projet (produit ou technologie)  </label>
                        <textarea id="caractere_innovant" name="innovations_apportes" rows="5" class="form-control"  maxlength="500"  placeholder="Qu’apportez-vous de nouveau avec ce projet ? En quoi est-il innovant ? " required></textarea>
                    </div>
                </div>
            </div>
                    
                <div class="form-group form-actions">
                <div class="col-md-8 col-md-offset-4">
                    <a href="" onclick="reload()" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
                    <button type="submit" class="btn btn-sm btn-success" ><i class="fa fa-arrow-right"></i> Modifier</button>

                </div>
            </div>
            </form>
            </div>
            <!-- END Modal Body  modal-devis-edit -->
        </div>
    </div>
</div>
<div id="modal-modif-invest" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Modifier une ligne d'investissement</h2>
            </div>
            <div class="modal-body">
                <form id="form-validation" method="POST"  action="{{route('investissement.modifier')}}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" id='invest_id' name="invest_id" value="">
            <div class="row">
                <div class="form-group col-md-3" style="margin-left: 15px;">
                    <label class="control-label " for="example-chosen">Categorie d'investissement<span class="text-danger">*</span></label>
                        <select id="categorie_invest" name="designation" class="form-control" onchange="afficher();" data-placeholder="formalisée?" style="width: 100%;" required>
                            <option></option>
                           @foreach ($categorie_investissments as $categorie_investissment)
                            <option value="{{ $categorie_investissment->id}}">{{ getlibelle($categorie_investissment->id)}}</option>
                           @endforeach
                        </select>
                </div>
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-3" style="margin-left:0px;">
                    <label class="control-label" for="name">Cout : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input id="cout" type="text" class="form-control" name="cout" placeholder="Cout de l'investissement" value="{{ old('cout') }}" required autofocus >
                            <span class="input-group-addon"><i class="gi gi-user"></i></span>
                        @if ($errors->has('designation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('cout') }}</strong>
                        </span>
                        @endif

                    </div>

                </div>
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-3" style="margin-left:0px;">
                    <label class="control-label" for="name">Subvention demandée  : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input id="subvention" type="text" class="form-control" name="subvention" placeholder="Cout de l'investissement" value="{{ old('subvention') }}" required autofocus onChange="deux_somme_complementaire('subvention','apport_perso','cout')">
                            <span class="input-group-addon"><i class="gi gi-user"></i></span>
                        @if ($errors->has('designation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('subvention') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-3" style="margin-left:0px;">
                    <label class="control-label" for="name">Apport personnel : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input id="apport_perso" type="text" class="form-control" name="apport_perso" placeholder="Cout de l'investissement" value="{{ old('apport_perso') }}" required autofocus onChange="verifier_montant('montant','devi_id','facture_id_fictif')">
                            <span class="input-group-addon"><i class="gi gi-user"></i></span>
                        @if ($errors->has('designation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('apport_perso') }}</strong>
                        </span>
                        @endif
                    </div>
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

<div id="modal-add-invest" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Ajouter une nouvelle ligne d'investissement</h2>
            </div>
            <div class="modal-body">
                <form id="form-validation" method="POST"  action="{{route('add.investissement')}}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" id='projet_id_new_invest' name="projet_id" >
            <div class="row">
                <div class="form-group col-md-3" style="margin-left: 15px;">
                    <label class="control-label" for="example-chosen">Categorie d'investissement<span class="text-danger">*</span></label>
                        <select id="categorie_invest_add" name="designation" class="form-control" onchange="afficher();" data-placeholder="formalisée?" style="width: 100%;" required>
                            <option></option>
                           @foreach ($categorie_investissments as $categorie_investissment)
                            <option value="{{ $categorie_investissment->id}}">{{ getlibelle($categorie_investissment->id)}}</option>
                           @endforeach
                        </select>
                </div>
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-3" style="margin-left:0px;">
                    <label class="control-label" for="name">Cout : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input id="cout_add" type="text" class="form-control" name="cout" placeholder="Cout de l'investissement" value="{{ old('cout') }}" required autofocus >
                            <span class="input-group-addon"><i class="gi gi-user"></i></span>
                        @if ($errors->has('designation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('cout') }}</strong>
                        </span>
                        @endif

                    </div>

                </div>
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-3" style="margin-left:0px;">
                    <label class="control-label" for="name">Subvention demandée  : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input id="subvention_add" type="text" class="form-control" name="subvention" placeholder="Cout de l'investissement" value="{{ old('subvention') }}" required autofocus onChange="deux_somme_complementaire('subvention_add','apport_perso_add','cout_add')">
                            <span class="input-group-addon"><i class="gi gi-user"></i></span>
                        @if ($errors->has('designation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('subvention') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-3" style="margin-left:0px;">
                    <label class="control-label" for="name">Apport personnel : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input id="apport_perso_add" type="text" class="form-control" name="apport_perso" placeholder="Cout de l'investissement" value="{{ old('apport_perso') }}" required autofocus onChange="verifier_montant('montant','devi_id','facture_id_fictif')">
                            <span class="input-group-addon"><i class="gi gi-user"></i></span>
                        @if ($errors->has('designation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('apport_perso') }}</strong>
                        </span>
                        @endif
                    </div>
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
<div id="modal-add-piece" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Ajouter une nouvelle pièce</h2>
            </div>
            <div class="modal-body">
                <form id="form-validation" method="POST"  action="{{route('add.piecetoprojet')}}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" id='projet_id_add_piece' name="projet_id" >
            <div class="row">
                <div class="form-group col-md-4" style="margin-left: 15px;">
                    <label class="control-label" for="example-chosen">Type pièce<span class="text-danger">*</span></label>
                        <select id="type_piece" name="type_piece" class="form-control" data-placeholder="Selectionner le type de la pièce" style="width: 100%;" required>
                            <option></option>
                           @foreach ($projet_type_pieces as $projet_type_piece)
                            <option value="{{ $projet_type_piece->id}}">{{ getlibelle($projet_type_piece->id)}}</option>
                           @endforeach
                        </select>
                </div>  
                <div class="form-group{{ $errors->has('piece_file') ? ' has-error' : '' }} col-md-8" style="margin-left:10px;">
                    <label  class="control-label"  class="control-label" for="piece_file">Joindre la nouvelle piece jointe <span class="text-danger">*</span></label>
                    <div class="input-group col-md-8">
                        <input class="form-control docsize"  type="file" name="piece_file" id="piece_file" accept=".pdf, .jpeg, .png"   onchange="VerifyUploadSizeIsOK('piece_file');" placeholder="Charger la nouvelle piece" required>
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
<div id="modal-modif-pj" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Changer de pièce jointe</h2>
            </div>
            <div class="modal-body">
                <form id="form-validation" method="POST"  action="{{route('piecejointe.modifier')}}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" id='piece_id' name="piece_id" value="">
                    <input type="hidden" id='type_piece' name="type_piece" value="">
            <div class="row">
                <div class="form-group{{ $errors->has('piece_file') ? ' has-error' : '' }} col-md-10" style="margin-left:10px;">
                    <label  class="control-label col-md-4"  class="control-label" for="piece_file">Joindre la nouvelle piece jointe <span class="text-danger">*</span></label>
                    <div class="input-group col-md-6">
                        <input class="form-control docsize"  type="file" name="piece_file" id="piece_file_u" accept=".pdf, .jpeg, .png"   onchange="VerifyUploadSizeIsOK('piece_file_u');" placeholder="Charger la nouvelle piece">
                        <span class="input-group-addon"><a href="#" class="empty_field" onclick="empty_input_file('piece_file_u')">Vider le champ</a></span>
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
@endsection

<script type="text/javascript">
    $(".dur").datepicker();
  </script>
<script>
         function recupererprojet_id(id_projet){
            document.getElementById("projet_id_new_invest").setAttribute("value", id_projet);
            document.getElementById("projet_id_add_piece").setAttribute("value", id_projet);
            
    }
</script>
<script>

    function edit_investissement(id){
                var id=id;
                var url = "{{ route('investissement.modif') }}";
                $.ajax({
                    url: url,
                    type:'GET',
                    dataType:'json',
                    data: {id: id} ,
                    error:function(){alert('error');},
                    success:function(data){
                        $("#invest_id").val(data.id);
                        $("#categorie_invest").val(data.categorie);
                       $("#cout").val(data.cout);
                       $("#subvention").val(data.subvention);
                       $("#apport_perso").val(data.apport_perso);

                    }
                });
        }
       
        function edit_piecejointe(id){
                var id=id;
                var url = "{{ route('piece.modif') }}";
                $.ajax({
                    url: url,
                    type:'GET',
                    dataType:'json',
                    data: {id: id} ,
                    error:function(){alert('error');},
                    success:function(data){
                        $("#piece_id").val(data.id);
                        $("#type_piece").val(data.type_piece);
                        

                    }
                });
        }
        function edit_pca(id){
                var id=id;
                var url = "{{ route('pca.modif') }}";
                $.ajax({
                    url: url,
                    type:'GET',
                    dataType:'json',
                    data: {id: id} ,
                    error:function(){alert('error');},
                    success:function(data){

                        $("#pca_id").val(data.id);
                         $("#coach_u").val(data.coach_id);
                         $("#banque_choisi_u").val(data.banque_id);
                       $("#titre_projet").val(data.titre_du_projet);
                       $("#objectif_projet").val(data.objectifs);
                       $("#activite_menee").val(data.activites_menees);
                       $("#atout_promo").val(data.atout_promoteur);
                       $("#caractere_innovant").val(data.innovation)

                    }
                });
        }
</script>