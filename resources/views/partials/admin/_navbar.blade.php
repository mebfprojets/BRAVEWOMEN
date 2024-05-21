<div id="sidebar">
    <!-- Wrapper for scrolling functionality -->
    <div id="sidebar-scroll">
        <!-- Sidebar Content -->
        <div class="sidebar-content">
            <!-- Brand -->
            <a href="index.html" class="sidebar-brand">
                <img src={{ asset("img/logo-bravebf4.PNG")  }} width=100% height=100%>
            </a>
            <div class="sidebar-section sidebar-user clearfix sidebar-nav-mini-hide">
                <div class="sidebar-user-avatar">
                    <a href="page_ready_user_profile.html">
                        <img src="{{ asset("img/placeholders/avatars/avatar2.jpg") }}" alt="avatar">
                    </a>
                </div>
                <div class="sidebar-user-name">
                    {{ Auth::user()->prenom }}
                </div>
            </div>
<hr>
            <ul class="sidebar-nav">
        @can('dashboard_bank', Auth::user())
            <li>
                <a href="{{ route("dashboad_banque") }}" class="@yield('dashboad_bank')"><i class="gi gi-stopwatch sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Tableau de bord bank</span></a>
            </li>
        @endcan
        @can('lister_client_bank', Auth::user())
            <li class="@yield('dashboard')">
                <a href="{{ route( "banque.beneficiaires") }}" class="@yield('beneficiaires_bank')"><i class="gi gi-stopwatch sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Mes Clients</span></a>
            </li>
        @endcan
            @can('tableau.debord', Auth::user()) 
                <li class="@yield('dashboard')">
                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-show_big_thumbnails sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Tableau de bord</span></a>
                        <ul>
                            <li class="@yield('dashboard_view') ">
                                <a href="{{ route("dashboad_pricipale") }}" ><i class="fa fa-eye sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Aperçu</span></a>
                            </li>
                         @can('dashboard.ugp', Auth::user()) 
                            <li class="@yield('activite_dashbord')">
                                <a href="{{ route("activite.liste") }}"><i class="fa fa-tasks sidebar-nav-icon"></i>Activites UGP</span></a>
                            </li>
                            <li class="@yield('budget_dashbord')">
                                <a href="{{ route("budget.liste") }}" ><i class="fa fa-money sidebar-nav-icon"></i>Budget UGP</span></a>
                            </li>
                        @endcan
                            <li class="@yield('dash.banque_perform')">
                                <a href="{{ route("dash.banque_perform") }}" ><i class="fa fa-money sidebar-nav-icon"></i>Activites Banques </span></a>
                            </li>
                            <li class="@yield('dashboard_detail')">
                                <a href="{{ route("dashboard") }}"><i class="gi gi-show_big_thumbnails sidebar-nav-icon"></i>Plus Detaillé</span></a>
                            </li>
                            <li class="@yield('success-storie')">
                                <a href="{{ route("sucessStorie.index") }}"><i class="gi gi-show_big_thumbnails sidebar-nav-icon"></i>Success Stories</span></a>
                            </li>
                        </ul>
                </li>
            @endcan   
            @can('acceder_souscriptions', Auth::user())
            <li class="@yield('souscription')">
                <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-folder sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Souscriptions</span></a>
                <ul>
                    <li class="@yield('pme')">
                        <a href="#" class="sidebar-nav-submenu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-vcard"></i></i><span class="sidebar-nav-mini-hide"> MPME</span></a>
                        <ul>
                        @can('souscription.liste', Auth::user())
                                <li class="@yield('souscription_enregistre')">
                                    <a href="{{ route("souscription.terminee") }}?typeentreprise=mpme" onclick="loadfunction()"> Enregistrées</a>
                                </li>
                                <li class="@yield('souscription_analyse_ugp')">
                                    <a href="{{ route("souscription.analyse_ugp") }}?typeentreprise=mpme" onclick="loadfunction()"> A analyser</a>
                                </li>
                                
                        @endcan
                        @can('souscription.listerParZone', Auth::user())
                            <li class="@yield('souscription_par_zone')">
                                <a href="{{ route("souscription__reparties_par_zone") }}?typeentreprise=mpme"> Par Zone</a>
                            </li>
                        @endcan
			        @can('souscription.liste', Auth::user())
                            <li class="@yield('souscription_soumis_aucomite')">
                                    <a href="{{ route("liste.postpreanalyse") }}?typeentreprise=mpme&type_resultat=selectionnee"  onclick="loadfunction()"> Bénéficiares data</a>
                            </li>
                            <li class="@yield('souscription_soumis_aucomite')">
                                <a href="{{ route("liste.postpreanalyse") }}?typeentreprise=mpme&type_resultat=ajournee"  onclick="loadfunction()"> Rejetées data</a>
                        </li>
                    @endcan
                        @can('souscription.soumis_au_comite', Auth::user())
                            <li class="@yield('souscription_soumis_aucomite')">
                                    <a href="{{ route("soumises_au_comite_technique") }}?typeentreprise=mpme"> En Attente d'Analyse</a>
                            </li>
                        @endcan
                        @can('souscription.soumis_au_comite', Auth::user())
                            <li class="@yield('analyse_par_le_comite')">
                                    <a href="{{ route("souscription.analyseParComite") }}?typeentreprise=mpme "> Analysées</a>
                            </li>
                        @endcan
                       @can('souscription.listerRetenues', Auth::user())
                            <li class="@yield('souscription_retenue')">
                                    <a href="{{ route("souscription_retenue") }}?typeentreprise=mpme"> Retenues </a>
                            </li>
                            <li class="@yield('mpme_rejete')">
                                <a href="{{ route("souscription.rejete") }}?typeentreprise=mpme"> Rejetees </a>
                            </li>
                        @endcan
                        @can('souscription.listerParZone', Auth::user())
                            <li class="@yield('pme_retenu_par_zone')">
                                <a href="{{ route("souscription_retenue_par_zone") }}?typeentreprise=mpme"> Retenues Par Zone</a>
                            </li>
                        @endcan
                        <li class="@yield('souscription_retenue')">
                            <a href="{{ route("souscription.rechercher") }}"> Rechercher</a>
                        </li>
                    </ul>
                </li>
              
                <li class="@yield('aop')">
                    <a href="#" class="sidebar-nav-submenu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-vcard"></i></i><span class="sidebar-nav-mini-hide"> AOP/Leader</span></a>
                    <ul>    
                        @can('souscription.liste', Auth::user())
                            <li class="@yield('aop_enregistre')">
                                <a href="{{ route("souscription.terminee") }}?typeentreprise=aop" onclick="loadfunction()"> Enregistrés</a>
                            </li>
                            <li class="@yield('souscription_analyse_ugp')">
                                <a href="{{ route("souscription.analyse_ugp") }}?typeentreprise=aop" onclick="loadfunction()"> A analyser</a>
                            </li>
                        @endcan
                        @can('souscription.listerParZone', Auth::user())
                            <li class="@yield('souscription_par_zone')">
                                <a href="{{ route("souscription__reparties_par_zone") }}?typeentreprise=aop"> Par Zone</a>
                            </li>
                        @endcan
                        @can('souscription.soumis_au_comite', Auth::user())
                            <li class="@yield('aop_soumis_aucomite')">
                                    <a href="{{ route("soumises_au_comite_technique") }}?typeentreprise=aop"> En Attente d'Analyse</a>
                            </li>
                        @endcan
                        @can('aop.soumis_au_comite', Auth::user())
                            <li class="@yield('aop_soumis_aucomite')">
                                <a href="{{ route("souscription.analyseParComite") }}?typeentreprise=aop"> Attente d'Analyse</a>
                            </li>
                        @endcan
                        @can('souscription.soumis_au_comite', Auth::user())
                            <li class="@yield('aop_analyse_par_lecomite')">
                                <a href="{{ route("souscription.analyseParComite") }}?typeentreprise=aop"> Soumises au Comité</a>
                            </li>
                        @endcan
                       @can('souscription.listerRetenues', Auth::user())
                            <li class="@yield('aop_retenu')">
                                    <a href="{{ route("souscription_retenue") }}?typeentreprise=aop"> Retenues </a>
                            </li>
                            <li class="@yield('aop_rejete')">
                                <a href="{{ route("souscription.rejete") }}?typeentreprise=aop"> Rejetees </a>
                            </li>
                            <li class="@yield('aop_post_analyse') loaddata">
                                <a href="{{ route("liste.postpreanalyse") }}?typeentreprise=aop&type_resultat=selectionnee" onclick="loadfunction()"> Bénéficiaires data</a>
                            </li>
                            <li class="@yield('aop_post_analyse') loaddata">
                                <a href="{{ route("liste.postpreanalyse") }}?typeentreprise=aop&type_resultat=ajournee"  onclick="loadfunction()"> Rejetées data</a>
                            </li>

                        @endcan
                        @can('souscription.listerParZone', Auth::user())
                            <li class="@yield('aop_retenue_par_zone')">
                                    <a href="{{ route("souscription_retenue_par_zone") }}?typeentreprise=aop"> Retenues Par Zone</a>
                            </li>
                        @endcan
                    </ul>
                </li>
                @can('formation.all', Auth::user())
                <li class="@yield('formation')">
                    <a href="#" class="sidebar-nav-submenu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-hand_up"></i></i><span class="sidebar-nav-mini-hide"> Formations</span></a>
                    <ul>
                  @can('formation.listerFormation', Auth::user())
                     <li class="@yield('formation')">
                        <a href="{{ route('formation.index') }}"> Mes séances</a>
                    </li>
                @endcan
                @can('formation.all', Auth::user())
                    <li class="@yield('all_formation')">
                        <a href="{{ route('formation.all') }}"> Toutes les séances</a>
                    </li>
                 @endcan
                    
                    </ul>
                    {{-- <a href="{{ route('formation.index') }}" class="sidebar-nav-menu"><i class=" sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-leaf"></i><span class="sidebar-nav-mini-hide"> Formations</span></a> --}}
                </li> 
                @endcan
             </ul>
            </li>
            <li class="@yield('pca')">
                <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide "></i><i class="fa fa-wrench sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Selection PCA</span></a>
                <ul>
                    <li class="@yield('pca_mpme')">
                        <a href="#" class="sidebar-nav-submenu"><i class="fa fa-angle-left sidebar-nav-indicator"></i>MPME</a>
                        <ul>
                            @can('projet.view', Auth::user())
                            <li class="@yield('all')">
                                <a href="{{ route("projet.index") }}?type_entreprise=mpme"> Plan enregistrés</a>
                            </li>
                            @endcan
                            @can('lister_pca_chef_de_zone', Auth::user())
                                <li class="@yield('liste_analyse')">
                                    <a href="{{ route("projet.liste") }}?statut=soumis&type_entreprise=mpme"> A analyser</a>
                                </li>
                            @endcan
                            @can('lister_chef_de_projet', Auth::user())
                                <li class="@yield('analyse')">
                                    <a href="{{ route("projet.liste") }}?statut=analyse&type_entreprise=mpme"> A analyser</a>
                                </li>
                            @endcan
                            @can('souscription.soumis_au_comite', Auth::user())
                            <li class="@yield('soumis_comite')">
                                <a href="{{ route("projet.liste") }}?statut=soumis_au_comite&type_entreprise=mpme"> Avis UGP favorable</a>
                            </li>
                            <li class="@yield('a_affecter_au_membre_du_comite')">
                                <a href="{{ route("projet.liste") }}?statut=a_affecter_au_membre_du_comite&type_entreprise=mpme"> Affectés au comité</a>
                            </li>
                            <li class="@yield('analyse_par_le_comite')">
                                <a href="{{ route("projet.liste") }}?statut=analyse_par_le_comite&type_entreprise=mpme"> Décision du comité</a>
                            </li>
                            @endcan
                            @can('acceder_aux_pca_selectionne',Auth::user())
                                    <li class="@yield('liste_dattente')">
                                        <a href="{{ route("pca.lister_liste_dattente") }}?type_entreprise=mpme"> Liste d'attente</a>
                                    </li>
                            @endcan
        
                            @can('projet.view', Auth::user())
                            <li class="@yield('selectionnes')">
                                <a href="{{ route("pca.selectionneparzone") }}?type_entreprise=mpme"> Projets retenus</a>
                            </li>
                            @endcan 
                            @can('souscription.liste', Auth::user())
                                <li class="@yield('kyc')">
                                    <a  href="{{ route('liste_demande_kyc') }}?type_entreprise=mpme"> Demandes de KYC</a>
                                </li>
                                <li class="@yield('pca_repecher')">
                                    <a  href="{{ route('projet.pca_repeches') }}?type_entreprise=mpme"></i> Demandes repechées</a>
                                </li>
                                <li class="@yield('pca_rejete')">
                                    <a  href="{{ route('projet.liste_rejetes') }}?type_entreprise=mpme"></i> Demandes rejetées</a>
                                </li>
                            @endcan
                            
                        </ul>
                    </li>
                    <li class="@yield('pca_aop')">
                        <a href="#" class="sidebar-nav-submenu"><i class="fa fa-angle-left sidebar-nav-indicator"></i> AOP/LEADER</a>
                        <ul>
                            @can('projet.view', Auth::user())
                            <li class="@yield('all')">
                                <a href="{{ route("projet.index") }}?type_entreprise=aop"> Plan enregistrés</a>
                            </li>
                            @endcan
                            @can('lister_pca_chef_de_zone', Auth::user())
                                <li class="@yield('liste_analyse')">
                                    <a href="{{ route("projet.liste") }}?statut=soumis&type_entreprise=aop"> A analyser</a>
                                </li>
                            @endcan
                            @can('lister_chef_de_projet', Auth::user())
                                <li class="@yield('analyse')">
                                    <a href="{{ route("projet.liste") }}?statut=analyse&type_entreprise=aop">  A analyser</a>
                                </li>
                            @endcan
                            @can('souscription.soumis_au_comite', Auth::user())
                            <li class="@yield('soumis_comite')">
                                <a href="{{ route("projet.liste") }}?statut=soumis_au_comite&type_entreprise=aop">  Avis UGP favorable</a>
                            </li>
                            <li class="@yield('a_affecter_au_membre_du_comite')">
                                <a href="{{ route("projet.liste") }}?statut=a_affecter_au_membre_du_comite&type_entreprise=aop">  Affectés au comité</a>
                            </li>
                            <li class="@yield('analyse_par_le_comite')">
                                <a href="{{ route("projet.liste") }}?statut=analyse_par_le_comite&type_entreprise=aop">  Décision du comité</a>
                            </li>
                            @endcan
                            @can('acceder_aux_pca_selectionne',Auth::user())
                                <li class="@yield('liste_dattente')">
                                    <a href="{{ route("pca.lister_liste_dattente") }}?type_entreprise=aop"> Liste d'attente</a>
                                </li>
                            @endcan
                            
                            @can('projet.view', Auth::user())
                            <li class="@yield('selectionnes')">
                                <a href="{{ route("pca.selectionneparzone") }}?type_entreprise=aop">  Projets retenus</a>
                            </li>
                            @endcan 
                            @can('souscription.liste', Auth::user())
                                <li class="@yield('kyc')">
                                    <a  href="{{ route('liste_demande_kyc') }}?type_entreprise=aop"></i> Demandes de KYC</a>
                                </li>
                                <li class="@yield('pca_repecher')">
                                    <a  href="{{ route('projet.pca_repeches') }}?type_entreprise=aop"></i> Demandes repechées</a>
                                </li>
                                <li class="@yield('pca_rejete')">
                                    <a  href="{{ route('projet.liste_rejetes') }}?type_entreprise=aop"></i> Demandes rejetées</a>
                                </li>
                                
                            @endcan
                            
                        </ul>
                    </li>
                   
                </ul>
            </li>
                
            @endcan
   
            @can('lister_les_mouvements_financiers', Auth::user())
            
                <li class="@yield('finacement')">
                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-money sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"> Exécution PCA</span></a>
                    <ul>
                        @can('suivre_execution_pca', Auth::user())
                                <li class="@yield('acquisition')">
                                    <a href="{{ route("acquisition.create") }}">  Acquisitions</a>
                                </li>
                                <li class="@yield('prestataire')">
                                    <a href="{{ route("prestataire.index") }}">Prestataires </a>
                                </li>
                                <li class="@yield('suivi_physique_mpme')">
                                    <a  href="{{ route('projet.asuivre') }}?type_entreprise=mpme"> Suivi Physique MPME</a>
                                </li>
                                <li class="@yield('suivi_physique_aop')">
                                    <a  href="{{ route('projet.asuivre') }}?type_entreprise=aop"></i> Suivi Physique AOP</a>
                                </li>
                                <li class="@yield('synthese_pca')">
                                    <a  href="{{ route('pca.synthese') }}"></i> Synthese de l'execution</a>
                                </li>
                                
                        @endcan
                        
                        @can('souscription.liste', Auth::user())
                                <li class="@yield('souscription_enregistre')">
                                    <a href="{{ route('banque.beneficiaires') }}"> Mouvements financiers</a>
                                </li>
                        @endcan  
                        @can('lister_all_devis', Auth::user())
                            <li class="@yield('devis')">
                                <a href="{{ route("devi.index") }}"> Devis Réçus</a>
                            </li>
                        @endcan
                        @can('lister_devis_soumis', Auth::user())
                             <li class="@yield('devis_analyse')">
                                <a href="{{ route("devi.de_mazone") }}">  Devis à analyser</a>
                            </li> 
                        @endcan
                        {{-- @can('lister_all_devis', Auth::user())
                            <li class="@yield('suivi_devis')">
                                <a href="{{ route("devis.listerASuivre") }}">  Exécution devis</a>
                            </li>
                        @endcan --}}
                        @can('lister_devis_transmis_au_pm', Auth::user())
                            <li class="@yield('devis_analyse')">
                                <a href="{{ route("devi.aanalyse") }}?statut=transmis_au_chef_de_projet"> Devis à analyser</a>
                            </li>
                        @endcan
                        @can('lister_all_devis', Auth::user())
                        <li class="@yield('facture')">
                            <a href="{{ route("facture.index") }}"> Factures Réçues</a>
                        </li>
                        @endcan
                        @can('lister_devis_soumis', Auth::user())
                            <li class="@yield('facture_analyse')">
                                <a href="{{ route("facture.mazone") }}"> Factures à analyser</a>
                            </li>
                       @endcan
                       @can('lister_devis_transmis_au_pm', Auth::user())
                        <li class="@yield('facture_analyse')">
                                <a href="{{ route("facture.aanalyse") }}?statut=transmis_au_chef_de_projet"> Facture à analyser</a>
                        </li>
                      @endcan
                      @can('lister_facture.a_payer', Auth::user())
                        <li class="@yield('facture_analyse')">
                                <a href="{{ route("facture.a_payer_de_par_banque") }}"> Factures à payer</a>
                        </li>
                      @endcan
                      
                       
                    </ul>
                </li>

                
                @endcan
                @can('document.view', Auth::user())
                <li class="@yield('documents')">
                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-archive sidebar-nav-icon"></i></i><span class="sidebar-nav-mini-hide "> Documentation</span></a>
                    <ul>
                @can('document.view', Auth::user())
                <li class="@yield('liste-document')">
                    <a href="{{ route('document.index') }}"> <i class="fa fa-folder-open sidebar-nav-icon"></i> Documents</a>
                </li>
                 @endcan
                    </ul>
                    {{-- <a href="{{ route('formation.index') }}" class="sidebar-nav-menu"><i class=" sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-leaf"></i><span class="sidebar-nav-mini-hide"> Formations</span></a> --}}
                </li> 
            @endcan
           @can('formation.all', Auth::user())
                <li class="@yield('gestion_projet')">
                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-settings sidebar-nav-icon"></i></i><span class="sidebar-nav-mini-hide "> Gestion du projet</span></a>
                    <ul>
                  @can('formation.listerFormation', Auth::user())
                     <li class="@yield('activite')">
                        <a href="{{ route('activites.index') }}"> <i class="gi gi-leaf sidebar-nav-icon"></i> Activités</a>
                    </li>
                @endcan
                @can('formation.all', Auth::user())
                <li class="@yield('budget')">
                    <a href="{{ route('budgets.index') }}"> <i class="gi gi-leaf sidebar-nav-icon"></i> Budget</a>
                </li>
                 @endcan
                    </ul>
                    {{-- <a href="{{ route('formation.index') }}" class="sidebar-nav-menu"><i class=" sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-leaf"></i><span class="sidebar-nav-mini-hide"> Formations</span></a> --}}
                </li> 
            @endcan
            
        {{-- @can('souscription.liste', Auth::user())
            <li class="@yield('document')">
                <a href="{{ route('formation.index') }}"> <i class="hi hi-folder-open sidebar-nav-icon"></i> Documents</a>
            </li>
        @endcan  --}}
        {{-- @can('formation.listerFormation', Auth::user())
            <li class="@yield('document')">
                <a href="{{ route('banque.beneficiaires') }}"> <i class="hi hi-folder-open"></i> Bénficiaires</a>
            </li>
        @endcan --}}
                @can('role.view', Auth::user())
                <li class="@yield('administration')">
                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-settings sidebar-nav-icon"></i></i><span class="sidebar-nav-mini-hide"> Administration</span></a>
                    <ul>
                    @can('parametre.view', Auth::user())
                        <li class="@yield('administration-parametre')">
                            <a href="{{ route('parametres.index') }}">Parametres</a>
                        </li>
                    @endcan
                    @can('valeur.view', Auth::user())
                         <li class="@yield('administration-banque')">
                             <a href="{{ route('banque.index') }}">Banques partenaires</a>
                         </li>
                         <li class="@yield('administration-coach')">
                            <a href="{{ route('coach.index') }}">Coachs</a>
                        </li>
                     @endcan
                        @can('valeur.view', Auth::user())
                            <li class="@yield('administration-valeur')">
                                <a href="{{ route('valeurs.index') }}">Valeurs</a>
                            </li>
                        @endcan
                        {{-- @endcan --}}
                        {{-- @can('role.view', Auth::user()) --}}
                        @can('role.view', Auth::user())
                            <li class="@yield('administration-role')">
                                <a href="{{ route("role.index") }}">Roles </a>
                            </li>
                        @endcan
                        @can('role.view', Auth::user())
                         
                        <li class="@yield('administration-prestataire')">
                            <a href="{{ route("grille.index") }}">Grille evaluation </a>
                        </li>
                        <li class="@yield('administration-indicateur')">
                            <a href="{{ route("indicateur.index") }}">Indicateur </a>
                        </li>
                        <li class="@yield('administration-impact')">
                            <a href="{{ route("impact.index") }}">Charger les données de l'impact </a>
                        </li>
                    @endcan 
                        {{-- @endcan --}}
                        {{-- @can('user.view', Auth::user()) --}}
                        @can('user.view', Auth::user())
                        <li class="@yield('administration-user')">
                                <a href="{{ route("user.index") }}">Utilisateurs</a>
                            </li>
                         @endcan
                        <li class="@yield('administration-permission')">
                            <a href="{{ route("permissions.index") }}">Permissions</a>
                        </li>
                        <li class="@yield('administration-permission')">
                            <a href="{{ route("form.import") }}">Import donnée géo</a>
                        </li>
                    </ul>
                </li>
                
                @endcan
               
            </ul>
        </div>
    </div>

</div>
