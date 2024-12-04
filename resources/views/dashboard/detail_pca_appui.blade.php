@extends('layouts.principale_dash_appui')
@section('dashboard', 'active')
@section($dash_phase, 'active')
@section('content')

<div class="row">
    <div class="col-sm-6 col-lg-4">
        <a href="javascript:void(0)" class="widget widget-hover-effect1">
            <div class="widget-simple themed-background pca_block_titre1">
                <h4 class="widget-content widget-content-light" style="text-align:center">
                    <strong>{{ $nombre_de_pca }}</strong>
                   Projets Soumis
                </h4>
            </div>
            <div class="widget-extra">

                <div class="row text-center">
                @foreach ($pca_enregistre_par_categories as $pca_enregistre_par_categorie )
                    <div class="col-xs-4">
                        <h3>
                            <strong>{{ $pca_enregistre_par_categorie->nombre}}</strong><br>
                            <p style="text-transform:uppercase">{{ $pca_enregistre_par_categorie->categorie}}</p>
                        </h3>
                    </div>
                @endforeach

                </div>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-lg-4">
        <a href="javascript:void(0)" class="widget widget-hover-effect1">
            <div class="widget-simple themed-background pca_block_titre2">
                <h4 class="widget-content widget-content-light" style="text-align: center">
                    <strong>{{ $nombre_pca_selelctionnes }}</strong>
                    Projet Selectionnés
                </h4>
            </div>
            <div class="widget-extra">
                <div class="row text-center">

            @foreach ($pca_selectionne_par_categories as $pca_selectionne_par_categorie )
                <div class="col-xs-4">
                    <h3>
                        <strong>{{ $pca_selectionne_par_categorie->nombre }}</strong><br>
                        <p style="text-transform:uppercase">{{ $pca_selectionne_par_categorie->categorie }}</p>
                    </h3>
                </div>
            @endforeach

                </div>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-lg-4">
        <a href="javascript:void(0)" class="widget widget-hover-effect1">
            <div class="widget-simple themed-background pca_block_titre3">
                <h4 class="widget-content widget-content-light" style="text-align: center">
                    <strong>{{ $nombre_pca_rejete }}</strong>
                    Projets Rejetés
                </h4>
            </div>
            <div class="widget-extra">
                <div class="row text-center">
                    @if ($pca_ajourne_par_categories->count()==0)
                        <div class="col-xs-12">
                            <h3>
                                <strong>Pas de données</strong><br>
                                <small>Disponible</small>
                            </h3>
                        </div>
                    @endif
                    @foreach ($pca_ajourne_par_categories as $pca_ajourne_par_categorie )
                    <div class="col-xs-4">
                        <h3>
                            <strong>{{ $pca_ajourne_par_categorie->nombre }}</strong><br>
                            <p style="text-transform:uppercase">{{ $pca_ajourne_par_categorie->categorie }}</p >
                        </h3>
                    </div>
                @endforeach

                </div>
            </div>
        </a>
</div>
</div>
<div class="row">
    
    <div class="col-sm-6">
        <p style="background-color:white; text-align: center">Situation des MPME</p>
        <!-- Billing Address Block -->
        <div class="row">
            <div class="col-sm-6 col-lg-4">
                <!-- Widget -->
                <a href="page_ready_article.html" class="widget widget-hover-effect1">
                    <div class="widget-simple">
                        <h3 class="widget-content text-right animation-pullDown">
                           Budget de la subvention MPME<br>
                           <hr>
                           <center><strong>{{ format_prix(env('total_enveloppe_MPME'))}} FCFA</strong></center>
                        </h3>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-lg-4">
                <!-- Widget -->
                <a href="page_comp_charts.html" class="widget widget-hover-effect1">
                    <div class="widget-simple">
                        <h3 class="widget-content text-right animation-pullDown">
                            Montant de la subvention accordé<br>
                            <hr>
                             <center><strong>{{ format_prix(return_info_enveloppe()[4])}} FCFA</strong></center>
                         </h3>
                    </div>
                </a>
                <!-- END Widget -->
            </div>
            <div class="col-sm-6 col-lg-4">
                <!-- Widget -->
                <a href="page_ready_inbox.html" class="widget widget-hover-effect1">
                    <div class="widget-simple">
                        <h3 class="widget-content text-right animation-pullDown">
                            Montant de la subvention accordé<br>
                            <hr>
                                <center><strong>{{ format_prix( env('total_enveloppe_MPME') - return_info_enveloppe()[4])}} FCFA</strong></center>
                        </h3>
                    </div>
                </a>
                <!-- END Widget -->
            </div>
        </div>
        <div class="block">
            <!-- Billing Address Title -->
            <div class="row box" style="font-weight: 600!important;">
                <div class="col-md-12">
                    <h3><strong>Etat des projets soumis par les MPME </strong></h3>
                </div>
                <div class="col-md-5">
                    <h3><strong> Nombre :</strong></h3>
                </div>
                <div class="col-md-4">
                  <h3> <strong>{{ format_prix($pca_enregistes_par_banque->sum('nombre')) }} </strong></h3>
                </div>
                <div class="col-md-5">
                    <h3><strong> Montant :</strong></h3>
                </div>
                <div class="col-md-4">
                  <h3> <strong>{{ format_prix($pca_enregistes_par_banque->sum('montant')/2) }} </strong></h3>
                </div>
                <p>Répartition par banque</p>
                <table class="styled-table center">
                    <tr>
                        <th>Banque</th>
                        <th> <center>Nombre</center></th>
                        <th>Montant</th>
                    </tr>
                    @foreach ($pca_enregistes_par_banque as $pca_enregistes_par_banq)
                        <tr>
                            <td style='width:100px'>{{ $pca_enregistes_par_banq->nom_banque}}</td><td style='width:50px'> <center>{{ $pca_enregistes_par_banq->nombre }}</center> </td><td style='width:100px; text-align: right !important;'>{{ format_prix($pca_enregistes_par_banq->montant/2) }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <!-- END Billing Address Content -->
        </div>
        <div class="block">
            <div class="row box" style="font-weight: 600!important;">
                <div class="col-md-12">
                    <h3><strong>Etat des projets des MPME sélectionnés</strong></h3>
                </div>
                <div class="col-md-5">
                    <h3><strong>Nombre :</strong></h3>
                </div>
                <div class="col-md-4">
                  <h3> <strong>{{ format_prix($pca_selectionne_par_banque->sum('nombre')) }} </strong></h3>
                </div>
                <div class="col-md-5">
                    <h3><strong>Montant :</strong></h3>
                </div>
                <div class="col-md-4">
                  <h3> <strong>{{ format_prix($pca_selectionne_par_banque->sum('montant')/2) }} </strong></h3>
                </div>
            <p>Répartition par banque.</p>
            <table class="styled-table center">
                <tr>
                    <th>Banque</th>
                    <th>Nombre</th>
                    <th>Montant</th>
                </tr>
                @foreach ($pca_selectionne_par_banque as $pca_selectionne_par_banq)
                    <tr>
                            <td style='width:100px'>{{ $pca_selectionne_par_banq->nom_banque}}</td><td style='width:50px;'> <center>{{ $pca_selectionne_par_banq->nombre }}</center></td><td style='width:100px; text-align: right !important;'>{{ format_prix($pca_selectionne_par_banq->montant/2) }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
            <!-- END Billing Address Content -->
        </div>
        <div class="block">
            <!-- Billing Address Title -->
            <div class="row box" style="font-weight: 600!important;">
                <div class="col-md-12">
                    <h3><strong>Etat de KYC des MPME concluant</strong></h3>
                </div>
                <div class="col-md-5">
                    <h3><strong>Nombre :</strong></h3>
                </div>
                <div class="col-md-4">
                  <h3> <strong>{{ format_prix($demandes_de_KYC_concluants_par_banque->sum('nombre')) }} </strong></h3>
                </div>
                <div class="col-md-5">
                    <h3><strong>Montant :</strong></h3>
                </div>
                <div class="col-md-4">
                  <h3> <strong>{{ format_prix($demandes_de_KYC_concluants_par_banque->sum('montant')/2) }} </strong></h3>
                </div>
                <p>Répartition par banque</p>
                <table class="styled-table center">
                    <tr>
                        <th>Banque</th>
                        <th> <center>Nombre</center></th>
                        <th>Montant</th>
                    </tr>
                    @foreach ($demandes_de_KYC_concluants_par_banque as $demandes_de_KYC_concluants_par_banq)
                        <tr>
                                <td style='width:100px'>{{ $demandes_de_KYC_concluants_par_banq->nom_banque}}</td><td style='width:50px; '> <center>{{ $demandes_de_KYC_concluants_par_banq->nombre }}</center></td><td style='width:100px ;text-align: right !important;'>{{ format_prix($demandes_de_KYC_concluants_par_banq->montant/2) }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>

        </div>
        <div class="block">
            <!-- Billing Address Title -->
            <div class="row box" style="font-weight: 600!important;">
                <div class="col-md-12">
                    <h3><strong>Etat des accords bénéficiaires de MPME signés</strong></h3>
                </div>
                <div class="col-md-5">
                    <h3><strong>Nombre: </strong></h3>
                </div>
                <div class="col-md-4">
                  <h3> <strong>{{ $accord_beneficiaire_signe_par_banque->sum('nombre') }} </strong></h3>
                </div>
                <div class="col-md-5">
                    <h3><strong>Montant: </strong></h3>
                </div>
                <div class="col-md-4">
                  <h3> <strong>{{ format_prix($accord_beneficiaire_signe_par_banque->sum('montant')/2) }} </strong></h3>
                </div>
                <p>Répartition par banque.</p>
                <table class="styled-table center">
                    <tr>
                        <th>Banque</th>
                        <th> <center>Nombre</center></th>
                        <th>Montant</th>
                    </tr>
                    @foreach ($accord_beneficiaire_signe_par_banque as $accord_beneficiaire_signe_par_banq)
                        <tr>
                            <td style='width:100px'>{{ $accord_beneficiaire_signe_par_banq->nom_banque}}</td><td style='width:50px'> <center> {{ $accord_beneficiaire_signe_par_banq->nombre }} </center></td><td style='width:100px; text-align: right !important;'>{{ format_prix($accord_beneficiaire_signe_par_banq->montant/2) }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>

        </div>

    </div>
    <div class="col-sm-6">
        <p style="background-color:white; text-align: center">Situation AOP/EL</p>
        <div class="row">
            <div class="col-sm-6 col-lg-4">
                <!-- Widget -->
                <a href="page_ready_article.html" class="widget widget-hover-effect1">
                    <div class="widget-simple ">
                        <h3 class="widget-content text-right animation-pullDown">
                           Budget de la subvention AOP<br>
                           <hr>
                           <center><strong>{{  format_prix(env('total_enveloppe_AOP'))}} FCFA</strong></center>
                        </h3>
                    </div>
                </a>
                <!-- END Widget -->
            </div>
            <div class="col-sm-6 col-lg-4">
                <!-- Widget -->
                <a href="page_comp_charts.html" class="widget widget-hover-effect1">
                    <div class="widget-simple ">
                       
                        <h3 class="widget-content text-right animation-pullDown">
                            Montant de la subvention accordé<br>
                            <hr>
                            <center><strong>{{ format_prix(return_info_enveloppe()[3])}} FCFA</strong></center>
                         </h3>
                    </div>
                </a>
                <!-- END Widget -->
            </div>
            <div class="col-sm-6 col-lg-4">
                <!-- Widget -->
                <a href="page_ready_inbox.html" class="widget widget-hover-effect1">
                    <div class="widget-simple">
                        <h3 class="widget-content text-right animation-pullDown">
                            Montant de la subvention restant<br>
                            <hr>
                            <center><strong>{{ format_prix( env('total_enveloppe_AOP') - return_info_enveloppe()[3])}} FCFA</strong></center>
                        </h3>
                    </div>
                </a>
                <!-- END Widget -->
            </div>
        </div>
        <div class="block">
            <!-- Billing Address Title -->
            <div class="row box" style="font-weight: 600!important;">
                <div class="col-md-12">
                    <h3><strong>Etat des projets soumis AOP/EL</strong></h3>
                </div>
                <div class="col-md-5">
                    <h3><strong> Nombre :</strong></h3>
                </div>
                <div class="col-md-4">
                  <h3> <strong>{{ format_prix($pca_aop_enregistes_par_banque->sum('nombre')) }} </strong></h3>
                </div>
                <div class="col-md-5">
                    <h3><strong> Montant :</strong></h3>
                </div>
                <div class="col-md-4">
                  <h3> <strong>{{ format_prix($pca_aop_enregistes_par_banque->sum('montant')/2) }} </strong></h3>
                </div>
                <p>Répartition par banque</p>
                <table class="styled-table center">
                    <tr>
                        <th>Banque</th>
                        <th> <center>Nombre</center></th>
                        <th>Montant</th>
                    </tr>
                    @foreach ($pca_aop_enregistes_par_banque as $pca_enregistes_par_banq)
                        <tr>
                                <td style='width:100px'>{{ $pca_enregistes_par_banq->nom_banque}}</td><td style='width:50px'><center> {{ $pca_enregistes_par_banq->nombre }}</center></td><td style='width:100px; text-align: right !important;'>{{ format_prix($pca_enregistes_par_banq->montant/2) }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>


            <!-- END Billing Address Content -->
        </div>
        <div class="block">
            <!-- Billing Address Title -->
            <div class="row box" style="font-weight: 600!important;">
                <div class="col-md-12">
                    <h3><strong>Etat des projets des AOP/EL sélectionnés</strong></h3>
                </div>
                <div class="col-md-5">
                    <h3><strong>Nombre :</strong></h3>
                </div>
                <div class="col-md-4">
                  <h3> <strong>{{format_prix($pca_aop_selectionne_par_banque->sum('nombre')) }} </strong></h3>
                </div>
                <div class="col-md-5">
                    <h3><strong>Montant :</strong></h3>
                </div>
                <div class="col-md-4">
                  <h3> <strong>{{ format_prix($pca_aop_selectionne_par_banque->sum('montant')/2) }} </strong></h3>
                </div>
                <p>Répartition par banque</p>
                <table class="styled-table center">
                    <tr>
                        <th>Banque</th>
                        <th> <center>Nombre</center></th>
                        <th>Montant</th>
                    </tr>
                    @foreach ($pca_aop_selectionne_par_banque as $pca_enregistes_par_banq)
                        <tr>
                                <td style='width:100px;'>{{ $pca_enregistes_par_banq->nom_banque}}</td><td style='width:50px;text-align: right !important;'><center>{{ $pca_enregistes_par_banq->nombre }}</center></td><td style='width:100px ;text-align: right !important;'>{{ format_prix($pca_enregistes_par_banq->montant/2) }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>

            <!-- END Billing Address Content -->
        </div>
        <div class="block">
            <!-- Billing Address Title -->
            <div class="row box" style="font-weight: 600!important;">
                <div class="col-md-12">
                    <h3><strong>Etat des KYC des AOP/EL concluants</strong></h3>
                </div>
                <div class="col-md-5">
                    <h3><strong>Nombre :</strong></h3>
                </div>
                <div class="col-md-4">
                  <h3> <strong>{{format_prix($demandes_aop_de_KYC_concluants_par_banque->sum('nombre')) }} </strong></h3>
                </div>
                <div class="col-md-5">
                    <h3><strong>Montant :</strong></h3>
                </div>
                <div class="col-md-4">
                  <h3> <strong>{{format_prix($demandes_aop_de_KYC_concluants_par_banque->sum('montant')) }} </strong></h3>
                </div>
                <p>Répartition par banque</p>
                <table class="styled-table center">
                    <tr>
                        <th>Banque</th>
                        <th> <center>Nombre</center></th>
                        <th>Montant</th>
                    </tr>
                    @foreach ($demandes_aop_de_KYC_concluants_par_banque as $demandes_de_KYC_concluants_par_banq)
                        <tr>
                                <td style='width:100px'>{{ $demandes_de_KYC_concluants_par_banq->nom_banque}}</td><td style='width:50px; text-align: right !important;'> <center>{{ $demandes_de_KYC_concluants_par_banq->nombre }}</center></td><td style='width:100px; text-align: right !important;'>{{ format_prix($demandes_de_KYC_concluants_par_banq->montant/2) }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>

        </div>
        <div class="block">
            <!-- Billing Address Title -->
            <div class="row box" style="font-weight: 600!important;">
                <div class="col-md-12">
                    <h3><strong>Etat des accords bénéficiaires de AOP/EL signés </strong></h3>
                </div>
                <div class="col-md-5">
                    <h3><strong>Nombre: </strong></h3>
                </div>
                <div class="col-md-4">
                  <h3> <strong>{{ $accord_beneficiaire_aop_signe_par_banque->sum('nombre') }} </strong></h3>
                </div>
                <div class="col-md-5">
                    <h3><strong>Montant: </strong></h3>
                </div>
                <div class="col-md-4">
                  <h3> <strong>{{ format_prix($accord_beneficiaire_aop_signe_par_banque->sum('montant')/2) }} </strong></h3>
                </div>
                <p>Répartition par banque</p>
                <table class="styled-table center">
                    <tr>
                        <th>Banque</th>
                        <th> <center>Nombre</center></th>
                        <th>Montant</th>
                    </tr>
                    @foreach ($accord_beneficiaire_aop_signe_par_banque as $accord_beneficiaire_signe_par_banq)
                        <tr>
                                <td style='width:100px'>{{ $accord_beneficiaire_signe_par_banq->nom_banque}}</td><td style='width:50px; text-align: right !important;'> <center>{{ $accord_beneficiaire_signe_par_banq->nombre }}</center></td><td style='width:100px ;text-align: right !important;'>{{ format_prix($accord_beneficiaire_signe_par_banq->montant/2) }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>

        </div>
        <!-- END Billing Address Block -->
    </div>
</div>
<div class="row">
    <div class="row">
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button"  style="font-size: 20px" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                 DETAILS PCA ENREGISTRES
                </button>
              </h2>
              <div id="collapseOne" class="accordion-collapse collapse show"  aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <div class="row" style="text-align:center">
                        <div class="col-md-5 divscrolable">
                            <p style="border-bottom: 1px solid black">Etat des projets des MPME enregistrés par région</p>
                         <div class='divscrolable'>
                            <table class="styled-table center">
                                <tr>
                                    <th>Zone</th>
                                    @foreach ($pca_par_region as $pca_par_reg)
                                        <th style='width:100px'>{{ getlibelle($pca_par_reg->region)}}</th>
                                    @endforeach
                                </tr>
                                <tr>
                                    <th>Nombre</th>
                                    @foreach ($pca_par_region as $pca_par_reg)
                                        <td>{{ $pca_par_reg->nombre}}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <th>Coût des Projets</th>
                                    @foreach ($pca_par_region as $pca_par_reg)
                                        <td>{{format_prix($pca_par_reg->montant)}}</td>
                                    @endforeach
                                </tr>
                            </table>
                        </div>
                    </div>
                        <div class="col-md-6 divscrolable" style="margin-left:20px;">
                            <p style="border-bottom: 1px solid black">Etat des projets des AOP/EL enregistrés par région </p>
                        <div class='divscrolable'>
                            <table class="styled-table">
                                    <tr>
                                        <th>Zone</th>
                                        @foreach ($pca_aop_par_region as $pca_aop_par_reg)
                                            <th style='width:27%'>{{ getlibelle($pca_aop_par_reg->region)}}</th>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <th>Nombre</th>
                                        @foreach ($pca_aop_par_region as $pca_aop_par_reg)
                                            <td style='width:30px'>{{ $pca_aop_par_reg->nombre}}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <th>Coût des Projets</th>
                                        @foreach ($pca_aop_par_region as $pca_aop_par_reg)
                                            <td style='width:30px'>{{format_prix($pca_aop_par_reg->montant)}}</td>
                                        @endforeach
                                    </tr>
                                </table>
                        </div>
                    </div>
                </div>
                <div class="row" style="text-align:center">
                        <div class="col-md-5 divscrolable">
                            <p style="border-bottom: 1px solid black">Etat des projets des MPME enregistrés par secteur d'activité  </p>
                            <div class='divscrolable'>
                                <table class="styled-table">
                                    <tr>
                                        <th>Activité</th>
                                        @foreach ($pca_par_secteurs as $pca_par_secteur)
                                            <th  style='width:15% text-align:center' >{{ getlibelle($pca_par_secteur->secteur_dactivite)}}</th>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <th>Nombre</th>
                                        @foreach ($pca_par_secteurs as $pca_par_secteur)
                                            <td style="width: 30px;">{{ $pca_par_secteur->nombre}}</td>
                                        @endforeach

                                    </tr>
                                    <tr>
                                        <th>Coût des Projets</th>
                                        @foreach ($pca_par_secteurs as $pca_par_secteur)
                                            <td style="width: 30px;">{{ format_prix($pca_par_secteur->montant)}}</td>
                                        @endforeach
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div  class="col-md-6 divscrolable" style="margin-left:20px;">
                            <p style="border-bottom: 1px solid black">Etat des projets des AOP/EL enregistrés  par secteur d'activité</p>
                            <div class='divscrolable'>
                                <table class="styled-table">
                                    <tr>
                                        <th>Activité</th>
                                        @foreach ($pca_aop_par_secteurs as $pca_aop_par_sect)
                                            <th style='width:25%'>{{ getlibelle($pca_aop_par_sect->secteur_dactivite)}}</th>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <th>Nombre</th>
                                        @foreach ($pca_aop_par_secteurs as $pca_aop_par_sect)
                                            <td style="width: 30px;">{{ $pca_aop_par_sect->nombre}}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <th>Coût des Projets</th>
                                        @foreach ($pca_aop_par_secteurs as $pca_aop_par_sect)
                                            <td style="width: 30px;">{{format_prix($pca_aop_par_sect->montant)}}</td>
                                        @endforeach
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
              </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" type="button"  style="font-size: 20px" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    DETAILS PCA SELECTIONNES
                </button>
              </h2>
              <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                <div class="row">
                    <div class="col-md-6 divscrolable">
                        <p style="border-bottom: 1px solid black">Etat des projets des MPME selectionnés par region </p>
                    <div class='divscrolable'>
                        <table class="styled-table">
                            <tr>
                            <th >Zone</th>
                                @foreach ($pca_selectionne_par_region as $pca_selectionne_par_reg)
                                    <th style="width: 20%"> {{ getlibelle($pca_selectionne_par_reg->region)}}</th>
                                @endforeach
                            </tr>
                            <tr>
                            <th>Nombre</th>
                                @foreach ($pca_selectionne_par_region as $pca_selectionne_par_reg)
                                    <td style="width: 30px;">{{ $pca_selectionne_par_reg->nombre}}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <th>Montant des Projets</th>
                                @foreach ($pca_selectionne_par_region as $pca_selectionne_par_reg)
                                    <td style="width: 30px;">{{ format_prix($pca_selectionne_par_reg->montant)}}</td>
                                @endforeach
                            </tr>
                        </table>
                    </div>
                </div>
                    <div class="col-md-5 divscrolable" style="margin-left:20px;">
                        <p style="border-bottom: 1px solid black">Etat des projets des AOP/EL selectionnés par region </p>
                    <div class='divscrolable'>
                        <table class="styled-table">
                            <tr>
                                <th>Zone</th>
                                @foreach ($pca_aop_selectionne_par_region as $pca_aop_selectionne_par_reg)
                                    <th style="width: 30px;"> {{ getlibelle($pca_aop_selectionne_par_reg->region)}}</th>
                                @endforeach
                            </tr>
                            <tr>
                                <th>Nombre</th>
                                @foreach ($pca_aop_selectionne_par_region as $pca_aop_selectionne_par_reg)
                                    <td style="width: 30px;">{{ $pca_aop_selectionne_par_reg->nombre}}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <th>Montant des Projets</th>
                                @foreach ($pca_aop_selectionne_par_region as $pca_selectionne_par_reg)
                                    <td style="width: 30px;">{{ format_prix($pca_selectionne_par_reg->montant)}}</td>
                                @endforeach
                            </tr>
                        </table>
                    </div>
                </div>
                </div>
                <div class="row">
                    <div class="col-md-6 divscrolable">
                        <p style="border-bottom: 1px solid black">Etat des projets des MPME selectionnés par secteur d'activité </p>
                    <div class='divscrolable'>
                        <table class="styled-table">
                            <tr>
                                <th>Activité</th>
                                @foreach ($pca_selectionne_par_secteurs as $pca_selectionne_par_reg)
                                    <th style="width: 15%;"> {{ getlibelle($pca_selectionne_par_reg->secteur_dactivite)}}</th>
                                @endforeach
                            </tr>
                            <tr>
                                <th>Nombre</th>
                                @foreach ($pca_selectionne_par_secteurs as $pca_selectionne_par_reg)
                                    <td style="width: 30px;">{{ format_prix($pca_selectionne_par_reg->nombre)}}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <th>Montant des Projets</th>
                                @foreach ($pca_selectionne_par_secteurs as $pca_selectionne_par_secteur)
                                    <td style="width: 30px;">{{ format_prix($pca_selectionne_par_secteur->montant)}}</td>
                                @endforeach
                            </tr>
                        </table>
                    </div>
                </div>
                    <div class="col-md-5 divscrolable" style="margin-left:15px">
                        <p style="border-bottom: 1px solid black">Etat des projets des AOP/EL selectionnés par secteur d'activité</p>
                    <div class='divscrolable'>
                        <table class="styled-table">
                            <tr>
                                <th>Activité</th>
                                @foreach ($pca_aop_selectionne_par_secteurs as $pca_aop_selectionne_par_secteur)
                                    <th style="width: 30px;"> {{ getlibelle($pca_aop_selectionne_par_secteur->secteur_dactivite)}}</th>
                                @endforeach
                            </tr>
                            <tr>
                                <th>Nombre</th>
                                @foreach ($pca_aop_selectionne_par_secteurs as $pca_aop_selectionne_par_secteur)
                                    <td style="width: 30px;">{{ $pca_aop_selectionne_par_secteur->nombre}}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <th>Montant des Projets</th>
                                @foreach ($pca_aop_selectionne_par_secteurs as $pca_selectionne_par_secteur)
                                    <td style="width: 30px;">{{ format_prix($pca_aop_selectionne_par_secteur->montant)}}</td>
                                @endforeach
                            </tr>
                        </table>
                    </div>
                </div>
                </div>
                </div>
              </div>
            </div>
            {{-- <div class="accordion-item">
              <h1 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" type="button"  style="font-size: 20px" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    DETAILS PCA REJETES
                </button>
              </h1>
              <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                <div class="row">
                    <div class="col-md-6">
                        <p style="border-bottom: 1px solid black">Situation des PCA rejetés par zone catégorie MPME</p>
                        <table class="styled-table">
                            <tr>
                                <th>Zone</th>
                                @foreach ($pca_rejete_par_region as $pca_rejete_par_reg)
                                    <th> {{ getlibelle($pca_rejete_par_reg->region)}}</th>
                                @endforeach
                            </tr>
                            <tr>
                                <th>Nombre</th>
                                @foreach ($pca_rejete_par_region as $pca_rejete_par_reg)
                                    <td>{{ $pca_rejete_par_reg->nombre}}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <th>Coût des projets</th>
                                @foreach ($pca_rejete_par_region as $pca_rejete_par_reg)
                                    <td>{{ format_prix($pca_rejete_par_reg->montant)}}</td>
                                @endforeach
                            </tr>
                        </table>

                    </div>
                    <div class="col-md-6">
                        <p style="border-bottom: 1px solid black">Situation des PCA rejétés par zone categorie AOP </p>
                        <table class="styled-table">
                            <tr>
                                <th>Zone</th>
                                @foreach ($pca_aop_rejete_par_region as $pca_aop_rejete_par_reg)
                                    <th> {{ getlibelle($pca_aop_rejete_par_reg->region)}}</th>
                                @endforeach
                            </tr>
                            <tr>
                                <th>Nombre</th>
                                @foreach ($pca_aop_rejete_par_region as $pca_aop_rejete_par_reg)
                                    <td>{{ $pca_aop_rejete_par_reg->nombre}}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <th>Coût des projets</th>
                                @foreach ($pca_aop_rejete_par_region as $pca_aop_rejete_par_reg)
                                    <td>{{format_prix( $pca_aop_rejete_par_reg->montant)}}</td>
                                @endforeach
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <p style="border-bottom: 1px solid black">Situation des PCA rejetés par Secteur d'activité categorie MPME </p>
                        <table class="styled-table">
                            <tr>
                                <th>Activité</th>
                                @foreach ($pca_rejetes_par_secteurs as $pca_rejetes_par_sec)
                                    <th> {{ getlibelle($pca_rejetes_par_sec->secteur_dactivite)}}</th>
                                @endforeach
                            </tr>
                            <tr>
                                <th>Nombre</th>
                                @foreach ($pca_rejetes_par_secteurs as $pca_rejetes_par_sec)
                                    <td>{{ $pca_rejetes_par_sec->nombre}}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <th>Coût des projets</th>
                                @foreach ($pca_rejetes_par_secteurs as $pca_rejetes_par_sec)
                                    <td>{{ format_prix($pca_rejetes_par_sec->montant)}}</td>
                                @endforeach
                            </tr>
                        </table>

                    </div>
                    <div class="col-md-6">
                        <p style="border-bottom: 1px solid black">Situation des PCA rejétés par secteur d'activité categorie AOP </p>
                        <table class="styled-table">
                            <tr>
                                <th>Activité</th>
                                @foreach ($pca_aop_rejetes_par_secteurs as $pca_selectionne_par_secteur)
                                    <th> {{ getlibelle($pca_selectionne_par_secteur->secteur_dactivite)}}</th>
                                @endforeach
                            </tr>
                            <tr>
                                <th>Nombre</th>
                                @foreach ($pca_aop_rejetes_par_secteurs as $pca_selectionne_par_secteur)
                                    <td>{{ $pca_selectionne_par_reg->nombre}}</td>
                                @endforeach

                            </tr>
                            <tr>
                                <th>Coût des projets</th>
                                @foreach ($pca_aop_rejetes_par_secteurs as $pca_selectionne_par_secteur)
                                    <td>{{ format_prix($pca_selectionne_par_reg->montant)}}</td>
                                @endforeach

                            </tr>
                        </table>
                    </div>
                </div>

                </div>
              </div>
            </div> --}}
          </div>
    </div>
</div>
{{-- <div class="col-md-12 col-md-offset-1 block full" style="margin-left: 10px;">

          <div class="block-title">
              <div class="block-options pull-right">
                  <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="Add Tag"><i class="fa fa-plus"></i></a>
              </div>
              <h2> <i class="fa fa-tags"></i> Details sur les Plans de Continuité d'Activité (PCA) <strong></strong></h2>
          </div> --}}

         {{-- <div class="row">
        <div class="col-md-6">
            <ul class="nav nav-pills nav-stacked">
                <li>
                    <a href="javascript:void(0)" onclick="dashboardpcaenregistre( 'autre');">
                        <span class="badge pull-right">{{ $nombre_de_pca   }} {{ $nombre_de_pca   }} MPME {{ $nombre_de_pca   }} AOP </span>
                        <i class="fa fa-tag fa-fw text-danger"></i> <strong>Nombre de PCA Elaborés :</strong>
                    </a>
                </li>
                <li style="margin-left:25px">
                    <a href="javascript:void(0)" onclick="dashboardpcaenregistre( 'autre');">
                        <span class="badge pull-right">{{ $nombre_de_pca   }} </span>
                        <i class="fa fa-tag fa-fw text-danger"></i> <strong>Nombre de PCA Elaboré categorie MPME:</strong>
                    </a>
                </li>
                <li style="margin-left:25Px">
                    <a href="javascript:void(0)" onclick="dashboardpcaenregistre( 'autre');">
                        <span class="badge pull-right">{{ $nombre_de_pca   }} </span>
                        <i class="fa fa-tag fa-fw text-danger"></i> <strong>Nombre de PCA Elaboré categorie AOP :</strong>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" onclick="entreprise_aformer('mpme',0);">
                        <span class="badge pull-right">{{ format_prix($montant_total_pca_enregistre) }}</span>
                        <i class="fa fa-tag fa-fw text-warning"></i> <strong>Coût Total des PCA enregistrés</strong>
                    </a>
                </li>
                <li style="margin-left:25Px">
                    <a href="javascript:void(0)" onclick="dashboardpcaenregistre( 'autre');">
                        <span class="badge pull-right">{{ $nombre_de_pca   }} </span>
                        <i class="fa fa-tag fa-fw text-warning"></i> <strong>Montant des PCA Soumis categorie MPME:</strong>
                    </a>
                </li>
                <li style="margin-left:25Px">
                    <a href="javascript:void(0)" onclick="dashboardpcaenregistre( 'autre');">
                        <span class="badge pull-right">{{ $nombre_de_pca   }} </span>
                        <i class="fa fa-tag fa-fw text-warning"></i> <strong>Montant des PCA Soumis categorie AOP :</strong>
                    </a>
                </li>
            </ul>

        </div>

        <div class="col-md-6">
            <ul class="nav nav-pills nav-stacked">
                {{-- <h1> Montant total des PCA enregistrés : {{ $total_mpme_aformation + $entreprisesLeaderAOP_aformer}} </h1>
                <li>
                    <a href="javascript:void(0)" onclick="entreprise_aformer('aop', 0);">
                        <span class="badge pull-right">{{ format_prix($montant_subvention_pca_enregistre)}}</span>
                        <i class="fa fa-tag fa-fw text-success"></i> <strong>Nombre d'entreprise ayant recu la subvention:</strong>
                    </a>
                </li>
                <li style="margin-left:25Px">
                  <a href="javascript:void(0)" onclick="dashboardpcaenregistre( 'autre');">
                      <span class="badge pull-right">{{ $nombre_de_pca   }} </span>
                      <i class="fa fa-tag fa-fw text-success"></i> <strong>Nombre de MPME ayant recu la subvention :</strong>
                  </a>
              </li>
              <li style="margin-left:25Px">
                  <a href="javascript:void(0)" onclick="dashboardpcaenregistre( 'autre');">
                      <span class="badge pull-right">{{ $nombre_de_pca   }} </span>
                      <i class="fa fa-tag fa-fw text-success"></i> <strong>Nombre de AOP/LEADER ayant recu la subvention:</strong>
                  </a>
              </li>
                  <li>
                      <a href="javascript:void(0)" onclick="entreprise_aformer('aop', 0);">
                          <span class="badge pull-right">{{ format_prix($montant_subvention_pca_enregistre)}}</span>
                          <i class="fa fa-tag fa-fw text-success"></i> <strong>Montant Total des Subventions Accordée</strong>
                      </a>
                  </li>
                  <li style="margin-left:25Px">
                    <a href="javascript:void(0)" onclick="dashboardpcaenregistre( 'autre');">
                        <span class="badge pull-right">{{ $nombre_de_pca   }} </span>
                        <i class="fa fa-tag fa-fw text-success"></i> <strong>Montant Total des Subventions accordé aux MPME:</strong>
                    </a>
                </li>
                <li style="margin-left:25Px">
                    <a href="javascript:void(0)" onclick="dashboardpcaenregistre( 'autre');">
                        <span class="badge pull-right">{{ $nombre_de_pca   }} </span>
                        <i class="fa fa-tag fa-fw text-success"></i> <strong>Montant Total des Subventions accordé aux AOP:</strong>
                    </a>
                </li>
                  <li>
                    <a href="javascript:void(0)" onclick="entreprise_aformer('mpme',1);">
                        <span class="badge pull-right">{{ format_prix($montant_apport_pca_enregistre)}}</span>
                        <i class="fa fa-tag fa-fw text-success"></i> <strong>Apport personnel à mobiliser</strong>
                    </a>
                </li>
                <li style="margin-left:25Px">
                    <a href="javascript:void(0)" onclick="dashboardpcaenregistre( 'autre');">
                        <span class="badge pull-right">{{ $nombre_de_pca   }} </span>
                        <i class="fa fa-tag fa-fw text-success"></i> <strong>Apport personnel à mobiliser par les MPME:</strong>
                    </a>
                </li>
                <li style="margin-left:25Px">
                    <a href="javascript:void(0)" onclick="dashboardpcaenregistre( 'autre');">
                        <span class="badge pull-right">{{ $nombre_de_pca   }} </span>
                        <i class="fa fa-tag fa-fw text-success"></i> <strong>Apport personnel à mobiliser par les AOP/Leader:</strong>
                    </a>
                </li>

            </ul>

        </div>
    </div> --}}
    {{-- <hr>
    <div class="row">
        <div class="col-md-6" id="indicateur1">

        </div>
        <div class="col-md-6" id="indicateur2">

        </div>
    </div> --}}

{{-- </div> --}}
@endsection
<script language = "JavaScript">
    function dashboardpcaenregistre(statut){
        var url = "{{ route('pca.par_secteur_dactivite') }}";

          $.ajax({
                            url: url,
                            type: 'GET',
                            data:{statut:statut},
                            dataType: 'json',
                            error:function(data){if (xhr.status == 401) {
                        window.location.href = 'https://www.bravewomen.bf/login';
                    }},
                            success: function (donnee) {
                            var donnch= new Array();
                            var secteur = new Array();
                        for(var i=0; i<donnee.length; i++)
                        {
                          donnch.push({
                                    name: donnee[i].secteur,
                                    y:  parseInt(donnee[i].nombre)} )
                        }
                        for(var i=0; i<donnee.length; i++)
                        {
                                secteur[i] = donnee[i].secteur
                        }
                        Highcharts.chart('indicateur1', {
                            chart: {
                                type: 'column'
                            },
                            xAxis: {
                                 categories: secteur
                            },
                            title: {
                                text:  "La repartition des"+ " " + "enregistrés par secteur d'activité"
                            },
                            plotOptions: {
                                pie: {
                                    allowPointSelect: true,
                                    cursor: 'pointer',
                                    dataLabels: {
                                        enabled: true,
                                        //format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                                    }
                                }
                            },
                            series: [{
                                name: 'Nombre',
                                colorByPoint: true,
                                data: donnch
                            }]
                        });
}

});
var url = "{{ route('aopleader.enregistreparzone') }}";
$.ajax({
                     url: url,
                     type: 'GET',
                     dataType: 'json',
                    data:{type_entreprise:type_entreprise, statut:statut},
                     error:function(data){if (xhr.status == 401) {
                        window.location.href = 'https://www.bravewomen.bf/login';
                    }},
                     success: function (donnee) {
                            var donnch= new Array();
                        for(var i=0; i<donnee.length; i++)
                        {
                          donnch.push({
                                    name: donnee[i].region,
                                    y:  parseInt(donnee[i].nombre)} )
                        }
                        Highcharts.chart('indicateur2', {
                            chart: {
                                plotBackgroundColor: null,
                                plotBorderWidth: null,
                                plotShadow: false,
                                type: 'pie'
                            },
                            title: {
                                text: "La repartition des"+ " " + type + " " + "enregistrés par localité"
                            },
                            tooltip: {
                                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                            },
                            plotOptions: {
                                pie: {
                                    allowPointSelect: true,
                                    cursor: 'pointer',
                                    dataLabels: {
                                        enabled: true,
                                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                                    }
                                }
                            },
                            series: [{
                                name: 'Nombre',
                                colorByPoint: true,
                                data: donnch
                            }]
                        });

    }

    });
    }      
</script>