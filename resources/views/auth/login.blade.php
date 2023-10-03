<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10" lang="en"> <![endif]-->

    <head>
        <meta charset="utf-8">

        <title>BRAVE WOMEN</title>

        <meta name="description" content="ProUI is a Responsive Bootstrap Admin Template created by pixelcave and published on Themeforest.">
        <meta name="author" content="pixelcave">
        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0">

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href= "{{ asset("img/favicon.ico") }}">
        <link rel="apple-touch-icon" href="img/icon57.png" sizes="57x57">
        <link rel="apple-touch-icon" href="img/icon72.png" sizes="72x72">
        <link rel="apple-touch-icon" href="img/icon76.png" sizes="76x76">
        <link rel="apple-touch-icon" href="img/icon114.png" sizes="114x114">
        <link rel="apple-touch-icon" href="img/icon120.png" sizes="120x120">
        <link rel="apple-touch-icon" href="img/icon144.png" sizes="144x144">
        <link rel="apple-touch-icon" href="img/icon152.png" sizes="152x152">
        <link rel="apple-touch-icon" href="img/icon180.png" sizes="180x180">
        <!-- END Icons -->

        <!-- Stylesheets -->
        <!-- Bootstrap is included in its original form, unaltered -->
        <link rel="stylesheet" href="css/bootstrap.min.css">

        <!-- Related styles of various icon packs and plugins -->
        <link rel="stylesheet" href="css/plugins.css">

        <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->
        <link rel="stylesheet" href="css/main.css">

        <!-- Include a specific file here from css/themes/ folder to alter the default theme of the template -->

        <!-- The themes stylesheet of this template (for using specific theme color in individual elements - must included last) -->
        <link rel="stylesheet" href="css/themes.css">
        <!-- END Stylesheets -->

        <!-- Modernizr (browser feature detection library) -->
        <script src="js/vendor/modernizr.min.js"></script>
    </head>
    <body>
        <!-- Login Alternative Row -->
        <div class="container">
            <div class="row">
                <div class="col-md-7 col-md-offset-1">
                    <div id="login-alt-container">
                        <!-- Title -->
                        <h1 class="push-top-bottom">
                            <img src="{{ asset("assets/img/brave-logo.png") }}" alt="" width="100" height="100"> <strong>PLATEFORME BRAVE WOMEN</strong><br>
                            <small>Bienvenue sur la plateforme BRAVE WOMEN Burkina!</small>
                        </h1>
                        <!-- END Title -->

                        <!-- Key Features -->

                        <!-- END Key Features -->

                        <!-- Footer -->
                        <footer class="text-muted push-top-bottom">
                            <small><span>2022</span> &copy; <a href="http://goo.gl/TDOSuC" target="_blank">BRAVE WOMEN Burkina</a></small>
                        </footer>
                        <!-- END Footer -->
                    </div>
                </div>
                <div class="col-md-4">
                    <!-- Login Container -->
                    <div id="login-container">
                        <!-- Login Title -->
                        <div class="login-title text-center">
                            <h1><strong>Connexion <i class="fa fa-key"></i></strong></h1>
                        </div>
                        <div class="block push-bit">
                            <!-- Login Form -->
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
                        <!-- END Login Block -->
                    </div>
                    <!-- END Login Container -->
                </div>
            </div>
        </div>
        <!-- END Login Alternative Row -->

        <!-- Modal Terms -->

        <!-- END Modal Terms -->

        <!-- jQuery, Bootstrap.js, jQuery plugins and Custom JS code -->
        <script src="js/vendor/jquery.min.js"></script>
        <script src="js/vendor/bootstrap.min.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/app.js"></script>

        <!-- Load and execute javascript code used only in this page -->
        <script src="js/pages/login.js"></script>
        <script>$(function(){ Login.init(); });</script>
    </body>
</html>

        {{-- <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <label for="email">email</label>
                <input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="mt-4">
                <label for="password">Mot de passe</label>
                <input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">

                    <span class="ml-2 text-sm text-gray-600">se rappeller </span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                      Mot de passe oublié?
                    </a>
                @endif
            </div>
            <button type="submit">Valider</button>
        </form> --}}

