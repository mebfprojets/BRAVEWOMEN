<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10" lang="en"> <![endif]-->

    <head>
        <meta charset="utf-8">
        <title>BRAVE WOMEN</title>
        <meta name="description" content="ProUI is a Responsive Bootstrap Admin Template created by pixelcave and published on Themeforest.">
        <meta name="author" content="pixelcave">
        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0">
        <link rel="shortcut icon" href="img/favicon.png">
        <link rel="apple-touch-icon" href="img/icon57.png" sizes="57x57">
        <link rel="apple-touch-icon" href="img/icon72.png" sizes="72x72">
        <link rel="apple-touch-icon" href="img/icon76.png" sizes="76x76">
        <link rel="apple-touch-icon" href="img/icon114.png" sizes="114x114">
        <link rel="apple-touch-icon" href="img/icon120.png" sizes="120x120">
        <link rel="apple-touch-icon" href="img/icon144.png" sizes="144x144">
        <link rel="apple-touch-icon" href="img/icon152.png" sizes="152x152">
        <link rel="apple-touch-icon" href="img/icon180.png" sizes="180x180">

        <link rel="stylesheet" href="{{ asset("css/bootstrap.min.css") }}">

        <!-- Related styles of various icon packs and plugins -->
        <link rel="stylesheet" href="{{ asset("css/plugins.css") }}">

        <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->
        <link rel="stylesheet" href="{{ asset("css/main.css") }}">

        <!-- Include a specific file here from css/themes/ folder to alter the default theme of the template -->

        <!-- The themes stylesheet of this template (for using specific theme color in individual elements - must included last) -->
        <link rel="stylesheet" href="{{ asset("css/themes.css") }}">
        <!-- END Stylesheets -->

        <!-- Modernizr (browser feature detection library) -->
        <script src="{{ asset("js/vendor/modernizr.min.js") }}"></script>
    </head>
    <body>
        <!-- Login Alternative Row -->
        <div class="container">
            <div class="row">
                <div class="col-md-7 col-md-offset-1">
                    <div id="login-alt-container">
                        <!-- Title -->
                        <h1 class="push-top-bottom">
                            <img src="{{ asset("assets/img/ brave-logo.png") }}" alt="" width="100" height="100"> <strong>PLATEFORME BRAVE WOMEN</strong><br>
                            <small>Bienvenue sur la plateforme BRAVE WOMEN Burkina!</small>
                        </h1>
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
                            <h1><strong>Changer le mot de passe <i class="fa fa-key"></i></strong></h1>
                        </div>
                        <div class="block push-bit">
                            <!-- Login Form -->
                            <form method="POST" action="{{ route('password.update') }}" id="form-login" class="form-horizontal">
                                @csrf
                                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                                            <input d="email" class="form-control input-lg" type="email" name="email" :value="old('email', $request->email)" required autofocus />
                                            {{-- <input type="text" id="login-email" name="login-email" class="form-control input-lg" placeholder="Email"> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="gi gi-asterisk"></i></span>
                                            <input id="password" class="form-control input-lg" type="password" name="password" required autocomplete="new-password"  />
                                            {{-- <input type="password" id="login-password" name="login-password" class="form-control input-lg" placeholder="Password"> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="gi gi-asterisk"></i></span>
                                            <input id="password_confirmation" class="form-control input-lg" type="password" name="password_confirmation" required autocomplete="new-password" />
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
                                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Changer le mot de passe</button>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="col-xs-12 text-center">
                                        <a href="javascript:void(0)" id="link-reminder-login"><small>Mot de passe oublié?</small></a>
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
        <script src= "{{asset("js/vendor/jquery.min.js")}}" ></script>
        <script src= "{{asset("js/vendor/bootstrap.min.js")}}"></script>
        <script src= "{{asset("js/plugins.js")}}" ></script>
        <script src="{{asset("js/app.js")}}" ></script>

        <!-- Load and execute javascript code used only in this page -->
        <script src="{{ asset("js/pages/login.js") }}"></script>
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









{{-- <x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="block">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button>
                    {{ __('Reset Password') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout> --}}
