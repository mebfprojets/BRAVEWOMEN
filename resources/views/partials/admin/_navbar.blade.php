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

                @can('tableau.debord', Auth::user()) 
                <li class="@yield('dashboard')">
                    <a href="{{ route("dashboard") }}"><i class="sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-dashboard"></i><span class="sidebar-nav-mini-hide"> Tableau de bord</span></a>
                </li>
            @endcan 
            @can('acceder_souscriptions', Auth::user())
                <li class="@yield('pme')">
                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-vcard"></i></i><span class="sidebar-nav-mini-hide"> MPME</span></a>
                    <ul>
                        @can('souscription.liste', Auth::user())
                                <li class="@yield('souscription_enregistre')">
                                    <a href="{{ route("souscription.terminee") }}?typeentreprise=mpme"><i class="gi gi-disk_save"></i> Enregistrées</a>
                                </li>
                            @endcan
                            
                        @can('souscription.listerParZone', Auth::user())
                            <li class="@yield('souscription_par_zone')">
                                <a href="{{ route("souscription__reparties_par_zone") }}"> <i class="hi hi-map-marker"></i> Par Zone</a>
                            </li>
                        @endcan
			@can('souscription.liste', Auth::user())
                            <li class="@yield('souscription_soumis_aucomite')">
                                    <a href="{{ route("liste.postpreanalyse") }}?typeentreprise=mpme"> <i class="gi gi-filter"></i> Préanalysés</a>
                            </li>
                        @endcan
                        @can('souscription.soumis_au_comite', Auth::user())
                            <li class="@yield('souscription_soumis_aucomite')">
                                    <a href="{{ route("soumises_au_comite_technique") }}?typeentreprise=mpme"> <i class="gi gi-filter"></i> En Attente d'Analyse</a>
                            </li>
                        @endcan
                        @can('souscription.soumis_au_comite', Auth::user())
                            <li class="@yield('analyse_par_le_comite')">
                                    <a href="{{ route("souscription.analyseParComite") }}?typeentreprise=mpme "> <i class="gi gi-filter"></i> Analysées</a>
                            </li>
                        @endcan
                       @can('souscription.listerRetenues', Auth::user())
                            <li class="@yield('souscription_retenue')">
                                    <a href="{{ route("souscription_retenue") }}?typeentreprise=mpme"> <i class="gi gi-check"></i> Retenues </a>
                            </li>
                        @endcan
                        @can('souscription.listerParZone', Auth::user())
                            <li class="@yield('pme_retenu_par_zone')">
                                    <a href="{{ route("souscription_retenue_par_zone") }}?typeentreprise=mpme"> <i class="gi gi-check"></i> Retenues Par Zone</a>
                            </li>
                        @endcan
                        <li class="@yield('souscription_retenue')">
                            <a href="{{ route("souscription.rechercher") }}"> <i class="gi gi-check"></i> Rechercher</a>
                        </li>
                    </ul>
                </li>
              
                <li class="@yield('aop')">
                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-vcard"></i></i><span class="sidebar-nav-mini-hide"> AOP/Leader</span></a>
                    <ul>    
                            @can('souscription.liste', Auth::user())
                            <li class="@yield('aop_enregistre')">
                                <a href="{{ route("souscription.terminee") }}?typeentreprise=aop"><i class="gi gi-disk_save"></i> Enregistrés</a>
                            </li>
                        @endcan
                        @can('souscription.soumis_au_comite', Auth::user())
                            <li class="@yield('aop_soumis_aucomite')">
                                    <a href="{{ route("soumises_au_comite_technique") }}?typeentreprise=aop"> <i class="gi gi-filter"></i> En Attente d'Analyse</a>
                            </li>
                        @endcan
                        @can('aop.soumis_au_comite', Auth::user())
                            <li class="@yield('aop_soumis_aucomite')">
                                    <a href="{{ route("souscription.analyseParComite") }}?typeentreprise=aop"> <i class="gi gi-filter"></i>Attente d'Analyse</a>
                            </li>
                        @endcan
                        @can('souscription.soumis_au_comite', Auth::user())
                            <li class="@yield('aop_analyse_par_lecomite')">
                                    <a href="{{ route("souscription.analyseParComite") }}?typeentreprise=aop"> <i class="gi gi-filter"></i> Soumises au Comité</a>
                            </li>
                        @endcan
                       @can('souscription.listerRetenues', Auth::user())
                            <li class="@yield('aop_retenu')">
                                    <a href="{{ route("aop.retenu") }}?typeentreprise=aop"> <i class="gi gi-check"></i> Retenues </a>
                            </li>
                        @endcan
                        @can('souscription.listerParZone', Auth::user())
                            <li class="@yield('aop_retenue_par_zone')">
                                    <a href="{{ route("souscription_retenue_par_zone") }}?typeentreprise=aop"> <i class="gi gi-check"></i> Retenues Par Zone</a>
                            </li>
                        @endcan
                    </ul>
                </li> 
            @endcan
                <li class="@yield('finacement')">
                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-money"></i><span class="sidebar-nav-mini-hide"> Financement</span></a>
                    <ul>
                        @can('souscription.liste', Auth::user())
                                <li class="@yield('souscription_enregistre')">
                                    <a href="{{ route("financement.enregistres") }}"><i class="gi gi-disk_save"></i> Enregistrées</a>
                                </li>
                            @endcan  
                        @can('souscription.listerParZone', Auth::user())
                            <li class="@yield('souscription_par_zone')">
                                <a href="{{ route("souscription__reparties_par_zone") }}"> <i class="hi hi-map-marker"></i> Par Zone</a>
                            </li>
                        @endcan
                        @can('souscription.soumis_au_comite', Auth::user())
                            <li class="@yield('souscription_soumis_aucomite')">
                                    <a href="{{ route("soumises_au_comite_technique") }}"> <i class="gi gi-filter"></i> En Attente d'Analyse</a>
                            </li>
                        @endcan
                        @can('souscription.soumis_au_comite', Auth::user())
                            <li class="@yield('souscription_analysee_par_lecomite')">
                                    <a href="{{ route("souscription.analyseParComite") }}"> <i class="gi gi-filter"></i> Soumises au Comité</a>
                            </li>
                        @endcan
                       @can('souscription.listerRetenues', Auth::user())
                            <li class="@yield('souscription_retenue')">
                                    <a href="{{ route("souscription_retenue") }}"> <i class="gi gi-check"></i> Retenues </a>
                            </li>
                        @endcan
                        @can('souscription.listerParZone', Auth::user())
                            <li class="@yield('souscription_retenue')">

                                    <a href="{{ route("souscription_retenue_par_zone") }}"> <i class="gi gi-check"></i> Retenues Par Zone</a>
                            </li>
                        @endcan
                    </ul>
                </li>
                <li class="@yield('finacement')">
                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-group"></i><span class="sidebar-nav-mini-hide"> Impacts</span></a>
                    <ul>
                        @can('souscription.liste', Auth::user())
                                <li class="@yield('souscription_enregistre')">
                                    <a href="{{ route("souscription.terminee") }}"><i class="gi gi-disk_save"></i> Enregistrées</a>
                                </li>
                            @endcan
                        @can('souscription.listerParZone', Auth::user())
                            <li class="@yield('souscription_par_zone')">
                                <a href="{{ route("souscription__reparties_par_zone") }}"> <i class="hi hi-map-marker"></i> Par Zone</a>
                            </li>
                        @endcan

                        @can('souscription.soumis_au_comite', Auth::user())
                            <li class="@yield('souscription_soumis_aucomite')">
                                    <a href="{{ route("soumises_au_comite_technique") }}"> <i class="gi gi-filter"></i> En Attente d'Analyse</a>
                            </li>
                        @endcan
                        @can('souscription.soumis_au_comite', Auth::user())
                            <li class="@yield('souscription_analysee_par_lecomite')">
                                    <a href="{{ route("souscription.analyseParComite") }}"> <i class="gi gi-filter"></i> Soumises au Comité</a>
                            </li>
                        @endcan
                       @can('souscription.listerRetenues', Auth::user())
                            <li class="@yield('souscription_retenue')">
                                    <a href="{{ route("souscription_retenue") }}"> <i class="gi gi-check"></i> Retenues </a>
                            </li>
                        @endcan
                        @can('souscription.listerParZone', Auth::user())
                            <li class="@yield('souscription_retenue')">

                                    <a href="{{ route("souscription_retenue_par_zone") }}"> <i class="gi gi-check"></i> Retenues Par Zone</a>
                            </li>
                        @endcan
                    </ul>
                </li>

             @can('formation.listerFormation', Auth::user())
                <li class="@yield('formation')">
                    <a href="{{ route('formation.index') }}"> <i class="gi gi-leaf"></i> Formations</a>
                    {{-- <a href="{{ route('formation.index') }}" class="sidebar-nav-menu"><i class=" sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-leaf"></i><span class="sidebar-nav-mini-hide"> Formations</span></a> --}}
                </li>
            @endcan
        @can('souscription.liste', Auth::user())
            <li class="@yield('document')">
                <a href="{{ route('formation.index') }}"> <i class="hi hi-folder-open"></i> Documents</a>
            </li>
        @endcan 
        
            <li class="@yield('document')">
                <a href="{{ route('banque.beneficiaires') }}"> <i class="hi hi-folder-open"></i> Bénficiaires</a>
            </li>
    
                @can('role.view', Auth::user())
                <li class="@yield('administration')">
                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-settings"></i></i><span class="sidebar-nav-mini-hide"> Administration</span></a>
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
                    </ul>
                </li>
                @endcan

            </ul>
        </div>
    </div>

</div>
