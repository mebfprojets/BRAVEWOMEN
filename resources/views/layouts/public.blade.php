<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Brave Women</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href= " {{ asset("img/favicon.ico") }}" rel="icon">
  <link href="{{ asset("img/favicon.ico")}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  {{-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet"> --}}
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <!-- Vendor CSS Files -->
  <link href="{{ asset("assets/vendor/aos/aos.css") }} " rel="stylesheet">
  <link href="{{ asset("assets/vendor/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet">
  <link href="{{ asset("assets/vendor/bootstrap-icons/bootstrap-icons.css") }} " rel="stylesheet">
  <link href="{{ asset("assets/vendor/boxicons/css/boxicons.min.css") }}" rel="stylesheet">
  <link href="{{ asset("assets/vendor/glightbox/css/glightbox.min.css") }}" rel="stylesheet">
  <link href="{{ asset("assets/vendor/remixicon/remixicon.css" ) }}" rel="stylesheet">
  <link href="{{ asset("assets/vendor/swiper/swiper-bundle.min.css") }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset("assets/css/main.css") }}">
  <link rel="stylesheet" href="{{ asset("css/bootstrap.min.css") }}">
  <link href="{{ asset("assets/css/style.css") }}" rel="stylesheet">

  {{-- <link rel="stylesheet" href="{{ asset("assets/css_formulaire/style_formulaire.css.map") }}"> --}}
  {{-- <link rel="stylesheet" href="{{ asset("assets/css_foramaulaire/style_fomulaire.css") }}"> --}}


  <!-- Related styles of various icon packs and plugins -->
  <link rel="stylesheet" href="{{ asset("css/plugins.css") }}">

  <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->

  <!-- Include a specific file here from css/themes/ folder to alter the default theme of the template -->

  <!-- The themes stylesheet of this template (for using specific theme color in individual elements - must included last) -->
  <link rel="stylesheet" href="{{ asset("css/themes.css") }}">
  <!-- END Stylesheets -->

  <!-- Modernizr (browser feature detection library) -->
  <script src="{{ asset("js/vendor/modernizr.min.js") }}"></script>

</head>

<body>
<main id="content">
    <header id="header" class="fixed-top">
        <div class="container d-flex align-items-center justify-content-between">

          <h1 class="logo"><a href="{{ route("accueil") }}"><img src="{{ asset("assets/img/ brave-logo.png") }}" width="" alt=""></a></h1>

          <nav id="navbar" class="navbar">
            <ul>
              <li><a class="nav-link scrollto @yield('active_accueil')" href="{{ route("accueil") }}">ACCUEIL</a></li>
              {{-- <li><a class="nav-link scrollto" href="#partenaire">NOS PARTENAIRES</a></li> --}}
              <li><a class="nav-link scrollto @yield('active_comment')"  href="#modal-comment-souscrire" data-toggle="modal">COMMENT SOUSCRIRE?</a></li>
              {{-- <li><a class="nav-link scrollto @yield('active_souscription')" href="#modal-" data-toggle="modal">SOUSCRIRE</a></li> --}}
            </li>
            <li class="dropdown"><a href="#"><span>SOUSCRIRE</span> <i class="bi bi-chevron-down"></i></a>
                <ul>
                 <li class="dropdown"><a href="#modal-Fin-souscription"><span>MPME</span> <i class="bi bi-chevron-right"></i></a>
                    <ul>
                        <li><a href="#modal-Fin-souscription" data-toggle="modal"  data-toggle="tooltip">S'ENREGISTRER</a></li> 
                    <li><a href="{{ route("souscription") }}">S'ENREGISTRER</a></li> 
                    </ul>
                  </li> 
                  <li class="dropdown"><a href="#"><span>AOP/LEADER</span> <i class="bi bi-chevron-right"></i></a>
                    <ul>
                    {{--  <li><a href="{{ route("responsableaop.create") }}">S'ENREGISTRER</a></li>
                      --}}
                      <li><a href="#modal-Fin-souscription" data-toggle="modal"  data-toggle="tooltip">S'ENREGISTRER</a></li> 
                    </ul>
                  </li>
                </ul>
        
              </li>
              <li><a class="nav-link scrollto @yield('active_poursuivre')" href="{{ route("afficherform") }}">POURSUIVRE</a></li>
              <li><a class="nav-link scrollto @yield('active_result')" href="#modal-consulter-resultat" data-toggle="modal">RESULTAT</a></li>
              @if(auth()->guest())
                <li><a class="getstarted scrollto" href="#modal-user-create" data-toggle="modal">Créer un compte</a></li>
                {{-- <li><a class="getstarted scrollto" href="#modal-user-connexion" data-toggle="modal">Se Connecter</a></li> --}}
                <li><a class="getstarted scrollto" href="{{ route('login') }}" >Se Connecter</a></li>
            @else
                {{-- <li><a class="getstarted scrollto" href="#modal-user-connexion" data-toggle="modal">Se Déconnecter</a> --}}
            <li>
                <a class="getstarted scrollto" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                    Se Deconnecter
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
            @endif


            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
          </nav><!-- .navbar -->

        </div>
      </header><!-- End Header -->
        <!-- ======= About Section ======= -->

    <div class="container ">
        
        @include('flash::message')
            <div class="section-title">
              <h2>@yield("section-title")</h2>
            </div>

            <div class="row @yield("class")">
                @include('flash::message')
                    @yield("main-content")
                    
            </div>

    </div>
          <div id="footer" class="@yield('classfooter')">
            <div class="container d-md-flex py-4">

              <div class="me-md-auto text-center text-md-start">
                <div class="copyright">
                  &copy;Copyright 2022 | Projet BRAVE WOMEN Burkina Faso
                </div>
              </div>
              <div class="social-links text-center text-md-right pt-3 pt-md-0">
                <a href="#" class="twitter"><i class="si si-facebook"></i></a>
                <a href="#" class="linkedin"><i class="si si-linked_in"></i></a>
                <a href="#" class="facebook"><i class="si si-twitter"></i></a>
                <a href="#" class="instagram"><i class="si si-youtube"></i></a>
              </div>
            </div>

 </div>
</main>     <!-- End #main -->




    <!-- ======= Header ======= -->


  <!-- ======= Footer ======= -->
  <!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <div id="modal-complete-souscription" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="gi gi-pen" ></i>Avertissement</h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="float: right !important;">&times;</button>
            </div>
            <div class="modal-body" >
                <div class="row">
                    <span> <p style="color: red;"> NB: Vous devez completer cette souscription dans un delais de 72 soit trois jours. Sinon code promoteur sera invalide. </p></span>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="gotoaccueil();" class="btn btn-success">Ok</button>
                <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
<div id="modal-user-create" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Créer un compte Bénéficiaire</h2>
            </div>
            <div class="modal-body">
                <form  id="form-validation" action="{{route("storecompte.promoteur")}}" method="post"  class="form-horizontal form-bordered">
                    @csrf
                    <fieldset>
                        <legend></legend>
                    <p style="background-color:red; display:none" id="alert_pass">Bien vouloir vérifier la conformité du mot de passe</p>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="user_name">Code promoteur:</label>
                            <div class="col-md-8">
                                <input type="text" id="code_promoteur_cpt_promo" name="code_promoteur" class="form-control" onkeyup="afficher_le_formulaire_cpt_promoteur();">
                            </div>
                            <p id="code_incorrect" style="color:red; display:none"> Code incorrect ou compte déja créer avec ce code. Bien vouloir verifier </p>
                        </div>
                    </fieldset>
                <fieldset class="create_compte_promoteur" style="display: none">
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="user_name">Email :</label>
                        <div class="col-md-8">
                            <input type="email" id="email" name="email" class="form-control" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="user-settings-password">Mot de Passe</label>
                        <div class="col-md-8">
                            <input type="password" id="val_password_promo" name="password" class="form-control" placeholder="SVP entrez un mot de passe complexe">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="user-settings-repassword">Confirmer le Nouveau Mot de Passe</label>
                        <div class="col-md-8">
                            <input type="password" id="val_confirm_password_promo" name="password_confirmation" class="form-control" onchange="verifiedpass();" placeholder="Et confirmer le ...">
                        </div>
                    </div>
                </fieldset>
                    <div class="form-group form-actions create_compte_promoteur" >
                        <div class="col-xs-12 text-right">
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                            <button type="submit" id="save_compte" class="btn btn-sm btn-primary">Enregistrer</button>
                        </div>
                    </div>
               
                </form>
            </div>
            <!-- END Modal Body -->
        </div>
    </div>
</div>
<div id="modal-user-connexion" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
          
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Se connecter</h2>
            </div>
            <div class="modal-body">
                <form action="{{ route('login') }}" method="post" id="form-login" class="form-horizontal">
                    @csrf
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                                <input id="email" class="form-control input-lg" type="email" name="email" :value="old('email')" required autofocus />
                                {{-- <input type="text" id="login-email" name="login-email" class="form-control input-lg" placeholder="Email"> --}}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="gi gi-asterisk"></i></span>
                                <input id="password" class="form-control input-lg" type="password" name="password" required autocomplete="current-password" />
                                {{-- <input type="password" id="login-password" name="login-password" class="form-control input-lg" placeholder="Password"> --}}
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-actions">
                         <div class="col-xs-4">
                            <label class="switch switch-primary" data-toggle="tooltip" title="Remember Me?">
                                <input type="checkbox" id="login-remember-me" name="login-remember-me" checked>
                                <span></span>
                            </label>
                        </div>
                        <div class="col-xs-8 text-right">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Se connecter</button>
                        </div>
                    </div>
                    {{-- <div class="flex items-center justify-end mt-4">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                              Mot de passe oublié?
                            </a>
                        @endif
                    </div> --}}
                    <div class="form-group">
                        <div class="col-xs-12 text-center">
                            <a href="javascript:void(0)" id="link-reminder-login"><small>Mot de passe oublié?</small></a>
                        </div>
                    </div>
                </form>
                <form  method="POST" action="{{ route('password.email') }}" id="form-reminder" class="form-horizontal display-none">
                @csrf
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                                <input type="text" id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus class="form-control input-lg" placeholder="Email">
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-actions">
                        <div class="col-xs-12 text-right">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Changer mot de passe</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 text-center">
                            <small>Vous rappellez-vous du mot de passe?</small> <a href="javascript:void(0)" id="link-reminder"><small>Login</small></a>
                        </div>
                    </div>
                </form>
            </div>
            <!-- END Modal Body -->
        </div>
    </div>
</div> 
<div id="modal-user-changepassword" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
          
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Connexion</h2>
            </div>
            <div class="modal-body">
                <form  method="POST" action="{{ route('password.email') }}" id="form-reminder" class="form-horizontal display-none">
                    @csrf
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                                    <input type="text" id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus class="form-control input-lg" placeholder="Email">
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-actions">
                            <div class="col-xs-12 text-right">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Changer mot de passe</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 text-center">
                                <small>Vous rappellez-vous du mot de passe?</small> <a href="javascript:void(0)" id="link-reminder"><small>Login</small></a>
                            </div>
                        </div>
                    </form>
            </div>
            <!-- END Modal Body -->
        </div>
    </div>
</div>

<div id="modal-soumettre-devis" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="float: right !important;">&times;</button>
                <h3 class="modal-title"><i class="gi gi-pen" ></i>Renseigner le code promoteur</h3>
            </div>
            <div class="modal-body" >
                <form action="" method="post">
                   <input type="text" type="button" name="code_promoteur" >
                </form>
            </div>
            <div class="modal-footer">
                <a type="submit" class="btn btn-sm btn-success" href="#">Valider</a>
                <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
<div id="modal-soumettre-PCA" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="float: right !important;">&times;</button>
                <h3 class="modal-title"><i class="gi gi-pen" ></i>Renseigner le code promoteur</h3>
            </div>
            <div class="modal-body" >
                <div class="row">
                    <div  class="form-group">
                        <input id="code_promoteur" class="form-control" type="text" name="code_promoteur">
                        <button onclick="return_entreprise_validee('code_promoteur');" class="btn btn-success">Valider</button>
                    </div>
                </div>
                <div id="palette1" class="row">
                       <span> <p style="color: red;" id="resusltw"> </p></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
<div id="modal-Fin-souscription" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="float: right !important;">&times;</button>
                <h3 class="modal-title"><i class="gi gi-pen" ></i>Fin de la phase</h3>
            </div>
            <div class="modal-body" >
                <div class="row">
                    <div  class="form-group">
                        <p style="color: red">Oups!!! Cette phase a été clôturée</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
{{-- <div id="modal-Fin-souscription" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="float: right !important;">&times;</button>
                <h3 class="modal-title"><i class="gi gi-pen" ></i>Fin de la phase</h3>
            </div>
            <div class="modal-body" >
                <div class="row">
                    <div  class="form-group">
                        <p style="color: red">Oups!!! Cette phase a été clôturée</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div> --}}
  <div id="modal-consulter-resultat" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="float: right !important;">&times;</button>
                <h3 class="modal-title"><i class="gi gi-pen" ></i>Renseigner le code promoteur</h3>
            </div>
            <div class="modal-body" >
                <div class="row">
                    <div  class="form-group">
                        <input id="code_promoteur_r" class="form-control" type="text" name="code_promoteur">
                        <button onclick="afficherResultat('code_promoteur_r');" class="btn btn-success">Valider</button>
                    </div>
                </div>
                <div id="palette" class="row">
                       <span> <p style="color: red;" id="resusltw"> </p></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
  <div id="modal-comment-souscrire" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="float: right !important;">&times;</button>
                <h3 class="modal-title"><i class="gi gi-pen" ></i>Procedure de souscription</h3>
            </div>
            <div class="modal-body" >
                <p>La souscription se fait en trois étapes à savoir :
                    <ol>
                        <li style="color: red">Enregistrement des informations sur le promoteur</li>
                        <p> A cette étape, le promoteur ou le responsable est invité à remplir le formulaire, à prendre connaissance des conditions et obligations et à les accepter, pour pouvoir enregistrer les données.
                            A la fin de la première étape, un code promoteur est généré et envoyé à l'adresse email renseigné par le promoteur.
                            Ce code qui peut aussi être copié directement sur l’interface, sera utilisé pour poursuivre la souscription.</p>
                        <li style="color: red">Enrgistrement des informations sur l'entreprise</li>
                        <p>A cette étape, les données essentielles sur l’entreprise détenue/dirigée par le promoteur sont requises.</p>
                        <li style="color: red">Enregistrement des données sur l'idée de projet du promoteur</li>
                        <p>A cette étape, les précisions essentielles sur l’idée de projet portée par le promoteur sont requises.</p>
                    </ol>
               </p>
               <p>
                 NB : A la fin de chaque étape, vous pouvez continuer en cliquant sur le bouton Poursuivre ou Suspendre la souscription et revenir plus tard pour continuer en cliquant sur le bouton Poursuivre.
               </p>
               <p>
                    Pour continuer la souscription, cliquer sur le lien Poursuivre , et la plateforme vous demandera de renseigner votre Code promoteur à travers une fenêtre. Renseigner le et valider.
               </p>
               <p>
                A la fin de la dernière étape, la plateforme vous permet de générer le récépissé de souscription en cliquant sur le bouton Générer le récépissé.
                Le récépissé généré vous sera présenté sur la plateforme et il sera également envoyé par email.
               </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
  <div id="modal-terms" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="float: right !important;">&times;</button>
                <h3 class="modal-title"><i class="gi gi-pen" ></i> Les obligations et conditions</h3>
            </div>
            <div class="modal-body" >
                <h4 class="sub-header">Conditions de participation</h4>
                <p style="line-height: 32px;"> -   respecter les principes de la loi islamique ; </p>
                 <p style="line-height: 32px;">-	travailler avec les banques partenaires locales ; </p>
                 <p style="line-height: 32px;"> -	accepter de formaliser l’entreprise si ce n’est pas encore le cas ;</p>
                 <p style="line-height: 32px;"> -	suivre tout le processus de mise en œuvre du projet.</p>
                </p style="line-height: 32px;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">J'ai lu les termes!</button>
            </div>
        </div>
    </div>
</div>

  <!-- Vendor JS Files -->
  <script src="{{ asset("assets/vendor/purecounter/purecounter.js") }}"></script>
  <script src="{{ asset("assets/vendor/aos/aos.js") }}"></script>
  <script src="{{ asset("assets/vendor/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
  <script src="{{ asset("assets/vendor/glightbox/js/glightbox.min.js") }}"></script>
  <script src="{{ asset("assets/vendor/isotope-layout/isotope.pkgd.min.js") }}"></script>
  <script src="{{ asset("assets/vendor/swiper/swiper-bundle.min.js") }}"></script>
  <script src="{{ asset("assets/vendor/php-email-form/validate.js") }}"></script>
  <script src="{{ asset("js/vendor/jquery.min.js") }}"></script>
  <script src="{{ asset("js/vendor/bootstrap.min.js") }}"></script>
  <script src="{{ asset("js/plugins.js") }}"></script>
  <script src=" {{ asset("js/app.js") }}"></script>
  <!-- Template Main JS File -->
  <script src="{{ asset("assets/js/formsValidation.js") }}"></script>
  <script>$(function(){ FormsValidation.init(); });</script>
  <script src="{{ asset("js/pages/formsWizard.js") }}"></script>
  <script>$(function(){ FormsWizard.init(); });</script>
  <script src="{{ asset("js/mon.js") }}"></script>
  <script src={{ asset("datatables/js/datatables.js") }}></script>
  <script src="{{ asset("assets/js/main.js") }}"></script>
  <script src="{{ asset("js/pages/login.js") }}"></script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <script>$(function(){ Login.init(); });</script>
  <script type="text/javascript">
    $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
 </script>
 <script>
    function verifiedpass(){
       var password = $('#val_password_promo').val(); 
      var  confirm_password = $('#val_confirm_password_promo').val();
    if(password != confirm_password){
        $('#alert_pass').show();
        $('#save_compte').hide();
    }
    else{
        $('#alert_pass').hide();
        $('#save_compte').show();
    }
    }
 </script>
<script>
function afficher_le_formulaire_cpt_promoteur(){
    var code_promoteur = $('#code_promoteur_cpt_promo').val();
            var url= "{{ route("verifier_validite_cpt_promo") }}"
        $.ajax({
                    url: url,
                    type: 'GET',
                    data: {code_promoteur: code_promoteur},
                    dataType: 'json',
                    error:function(data){alert("Erreur");},
                    success: function(data) {
                        if(data==true){
                            $('.create_compte_promoteur').show();
                            $('#code_incorrect').hide();
                        }else{
                            $('.create_compte_promoteur').hide();
                            $('#code_incorrect').show();
                        }
                       
                    }
            });
}
    function gotoaccueil(){
        window.location.replace('https://www.bravewomen.bf/');
    }
    function get_promoteur_code(id){
        var val= $('#'+id).val() ;
        
            $(function(){ 
                document.getElementById("code_promoteur").setAttribute("value", val);
            });
}
$(function() {
                  $('.listepdf').DataTable({
                        responsive: true,
                        dom: '<"html5buttons"B>lTfgtip',
                            buttons: [
                                {extend: 'csv'},
                                {extend: 'excel'},
                                {extend: 'pdf'},
                                {extend: 'print',
                                text:'Imprimer',
                                }
                            ],
language: {
    "search": '',
    sLengthMenu: "Lignes _MENU_ ",
    sInfo: "_START_ à _END_ de _TOTAL_",
    sPageFirst: "Premier",
    sPagePrevious: "Précédent",
    sPageNext: "Suivant",
    sPageLast: "Dernier",
    "zeroRecords": "Aucun résultat trouvé",
    "infoEmpty": "Aucun enregistrement disponible",
    "infoFiltered": "(filtré à partir de _MAX_ enregistrements au total)",
    "paginate": {
        "first": "<i class='fa fa-angle-double-left'></i>",
        "previous":"<i class='fa fa-angle-left' ></i>",
        "next":"<i class='fa fa-angle-right'></i>",
        "last":"<i class='fa fa-angle-double-right'></i>"
    }
}

});

                   });
</script>

  <script type="text/javascript">
    $(document).ready(function(){
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = '<div><label for="">Designation:</label> <input type="text" name="infrastructure_designation[]" value="" placeholder="designation"/>  <label for="">Quantite:</label> <input type="number" name="infrastructure_quantite[]" value="" placeholder="quantite"/> <a href="javascript:void(0);" class="remove_button"><span> <i class="gi gi-minus"></i></a></div>';
        //var fieldHTML2 = '<div><input type="text" name="field_name1[]" value=""/><a href="javascript:void(0);" class="remove_button"><img src="remove-icon.png"/></a></div>'; //New input field html
        var x = 1; //Initial field counter is 1

        //Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(x < maxField){
                x++; //Increment field counter
                $(wrapper).append(fieldHTML);
                //$(wrapper).append(fieldHTML2);//Add field html
            }
        });

        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            var maxField = 10; //Input fields increment limitation
            var addButton = $('.add_button2'); //Add button selector
            var wrapper2 = $('.field_wrapper2'); //Input field wrapper
            var fieldHTML = '<div><label for="">Designation:</label> <input type="text" name="materiel_designation[]" value="" placeholder="designation"/>  <label for="">Quantite:</label> <input type="number" name="materiel_quantite[]" value="" placeholder="quantite"/> <a href="javascript:void(0);" class="remove_button"><span> <i class="gi gi-minus"></i></a></div>';
            //var fieldHTML2 = '<div><input type="text" name="field_name1[]" value=""/><a href="javascript:void(0);" class="remove_button"><img src="remove-icon.png"/></a></div>'; //New input field html
            var x = 1; //Initial field counter is 1

            //Once add button is clicked
            $(addButton).click(function(){
                //Check maximum number of input fields
                if(x < maxField){
                    x++; //Increment field counter
                    $(wrapper2).append(fieldHTML);
                    //$(wrapper).append(fieldHTML2);//Add field html
                }
            });

            //Once remove button is clicked
            $(wrapper2).on('click', '.remove_button', function(e){
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });
        });
        </script>
    <script>
        $('#palette').hide();
        function afficherResultat(idcodepromoteur){
            // var idparent_val = $("#"+parent).val();
            var code_promoteur = $('#'+idcodepromoteur).val();
            var url= "{{ route("result") }}"
        $.ajax({
                    url: url,
                    type: 'GET',
                    data: {code_promoteur: code_promoteur},
                    dataType: 'json',
                    error:function(data){alert("Erreur");},
                    success: function(data) {

                        $('#palette').show();
                        var options = '<option></option>';
                        for (var x = 0; x < data.length; x++) {
                            //alert(data[x]['denomination']);
                            p = '<p>' + 'Votre entreprise' +' '+ data[x]['denomination'] +' '+'est'+' ' + data[x]['resultat'] + '</p>';
                            $('#palette').append(p);
                           // $('#resusltw').text('Entreprise'+' '+data[x]['denomination']+' '+'votre souscription a été'+' '+ data[x]['resultat'])
                        }
                       // $('#'+resusltw).html(p);

                    }
            });

        }
    </script>
    <script type="text/javascript"> 
        function refresh(){
            var t = 1000; // rafraîchissement en millisecondes
            setTimeout('showDate()',t)
        }
        $(function () {
            var date1 = new Date("08/01/2022");
            var date2 = new Date();
          diff = dateDiff(date2,date1);
            var time= 'Clôture des souscriptions dans: '+diff.day+' Jours'+ ' ' +diff.hour +' Heures'+ ' '+diff.min+' minutes';
            document.getElementById('horloge').innerHTML = time;
            refresh();
    }); 
function dateDiff(date1, date2){
    var diff = {}                           // Initialisation du retour
    var tmp = date2 - date1;
 
    tmp = Math.floor(tmp/1000);             // Nombre de secondes entre les 2 dates
    diff.sec = tmp % 60;                    // Extraction du nombre de secondes
 
    tmp = Math.floor((tmp-diff.sec)/60);    // Nombre de minutes (partie entière)
    diff.min = tmp % 60;                    // Extraction du nombre de minutes
 
    tmp = Math.floor((tmp-diff.min)/60);    // Nombre d'heures (entières)
    diff.hour = tmp % 24;                   // Extraction du nombre d'heures
     
    tmp = Math.floor((tmp-diff.hour)/24);   // Nombre de jours restants
    diff.day = tmp;
    return diff;
}
</script>
    <script>
         $('#palette1').hide();
        function return_entreprise_validee(idcodepromoteur){
            // var idparent_val = $("#"+parent).val();
            var code_promoteur = $('#'+idcodepromoteur).val();
            var url= "{{ route("entrepriseRetenuParPromoteur") }}"
        $.ajax({
                    url: url,
                    type: 'GET',
                    data: {code_promoteur: code_promoteur},
                    dataType: 'json',
                    error:function(data){alert("Erreur");},
                    success: function(data) {
                        $('#palette1').show();
                            for (var x = 0; x < data.length; x++) { 
                          var rout= '{{ route("add.planDeContinute",":id")}}';
                          var rout = rout.replace(':id', data[x]['id_entreprise']);
                          p = '<p>' + 'Votre entreprise' +' '+ data[x]['denomination'] +' '+'est'+' ' + '<a href="'+rout+'" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-primary">Soummettre le plan de continuté des affaire</a>';
                          $('#palette1').append(p);
                         
                      }
                      
                        }

            });
        }
    </script>
<script>
    function unique(){
        var denomination= $('#denomination').val();
        var code_promoteur= $('#code_promoteur').val();
        var url= "{{ route("verifierentreprise") }}"
        $.ajax({
                    url: url,
                    type: 'GET',
                    data: {denom: denomination, promoteur: code_promoteur},
                    dataType: 'json',
                    error:function(data){alert("Erreur");},
                    success: function(data) {
                        if(data != null){
                            $('#error').show();
                            $("#bouton").hide();
                            $('input').prop('readonly', true);
                            $('#denomination').prop('readonly', false);
                        }
                       else{
                            $('#error').hide();
                            $("#bouton").show();
                            $('input').prop('readonly', false);
                        }
                    }
            });
    }
</script>
  <script>
    //foncion permettant de convertir un montant en franc CFA
      function format_montant(id){
          //alert(id);
    var val= $('#'+id).val();
    $('#montant_devi_cache').val(val);
    
       var val1= val.split(" ").join("");
       // var newval= new Intl.NumberFormat('fr', {unitDisplay: 'long'}).format(val1);
        var newval= new Intl.NumberFormat('fr', {
        style: 'currency',
    currency: 'XOF',
    //currencySign: 'accounting'
        }).format(val1);
    $('#'+id).val(newval);
}
function calculer_pourcentage(id_avance, id_montant_devis, id_montant_devi_cache,avance_exige_div){
    montant_devis= $('#'+ id_montant_devi_cache).val();
  montant_devis=montant_devis.replace('F CFA', '');
  var montant_avance=  $('#'+id_avance).val();
  var pourcentage= (parseInt(montant_avance)/parseInt(montant_devis))*100;
  var p= "<p style='color:red'> Soit " + pourcentage+ " % du montant total de la prestation</p>";
  $('#'+avance_exige_div).append(p);
  format_montant(id_avance);

}
      function changeValue(parent, child, niveau)
        {
            var idparent_val = $("#"+parent).val();
            var id_param = parseInt(niveau);
            //alert(niveau);
            var url = '{{ route('valeur.selection') }}';
            $.ajax({
                    url: url,
                    type: 'GET',
                    data: {idparent_val: idparent_val, id_param:id_param, parent:parent},
                    dataType: 'json',
                    error:function(data){alert("Erreur");},
                    success: function (data) {
                        var options = '<option></option>';
                        for (var x = 0; x < data.length; x++) {
                            options += '<option value="' + data[x]['id'] + '">' + data[x]['name'] + '</option>';
                        }
                       $('#'+child).html(options);
                    }
            });
        }
  </script>
  
</body>

</html>
