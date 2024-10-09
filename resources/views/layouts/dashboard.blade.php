<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <title>BraveWomen - Subscription</title>

        <meta name="description" content="ProUI is a Responsive Bootstrap Admin Template created by pixelcave and published on Themeforest.">
        <meta name="author" content="pixelcave">
        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0">
        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="{{ asset("img/favicon.ico") }}">
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
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
   <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css">
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

        <!-- Related styles of various icon packs and plugins -->
        <link rel="stylesheet" href="{{ asset('css/plugins.css') }}">

        <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">

        <!-- Include a specific file here from css/themes/ folder to alter the default theme of the template -->

        <!-- The themes stylesheet of this template (for using specific theme color in individual elements - must included last) -->
        <link rel="stylesheet" href=" {{ asset('css/themes.css') }} ">
        <!-- END Stylesheets -->

        <!-- Modernizr (browser feature detection library) -->
        <script src=" {{ asset('js/vendor/modernizr.min.js') }}"></script>
    </head>
    <body>
        <!-- Page Wrapper -->
        <!-- In the PHP version you can set the following options from inc/config file -->
        <!--
            Available classes:

            'page-loading'      enables page preloader
        -->
        <div id="page-wrapper">
            <!-- Preloader -->
            <!-- Preloader functionality (initialized in js/app.js) - pageLoading() -->
            <!-- Used only if page preloader is enabled from inc/config (PHP version) or the class 'page-loading' is added in #page-wrapper element (HTML version) -->
            <div class="preloader themed-background">
                <h1 class="push-top-bottom text-light text-center"><strong>BraveWomen</strong>Subscription</h1>
                <div class="inner">
                    <h3 class="text-light visible-lt-ie10"><strong>Loading..</strong></h3>
                    <div class="preloader-spinner hidden-lt-ie10"></div>
                </div>
            </div>
            <div id="page-container" class="sidebar-partial sidebar-visible-lg sidebar-no-animations">

                    @include('partials.admin._navbar')
                <!-- END Main Sidebar -->

                <!-- Main Container -->
                <div id="main-container">
                    @include('partials.admin.header')

                    <div id="page-content">

                        <div class="content-header">
                            <ul class="nav-horizontal text-center">
                                <li class="@yield("dashboardss")">
                                    <a href="{{ route("dashboard")}}?type_tableau_de_bord=dashboard"><i class="fa fa-bar-chart"></i>Vue graphique</a>
                                </li>
                                <li class="@yield("dashboardgeo")">
                                    <a href="{{ route("dashboard")}}?type_tableau_de_bord=geodashboard"><i class="gi gi-google_maps"></i></i>Vue Cartographique</a>
                                </li>
                                <li class="@yield("sousmenu")">
                                    <a href="{{ route("dashboard")}}?type_tableau_de_bord=dashboardliste"><i class="gi gi-list"></i></i>Vue Liste</a>
                                </li>

                            </ul>
                        </div>

                        <div class="row">

                            @yield('content')

                        </div>
                        <!-- END Dashboard 2 Content -->
                    </div>
                    <!-- END Page Content -->

                    <!-- Footer -->

                @include('partials.admin.footer')
                    <!-- END Footer -->
                </div>
                <!-- END Main Container -->
            </div>
            <!-- END Page Container -->
        </div>
        <!-- END Page Wrapper -->

        <!-- Scroll to top link, initialized in js/app.js - scrollToTop() -->
        <a href="#" id="to-top"><i class="fa fa-angle-double-up"></i></a>

        <!-- User Settings, modal which opens from Settings link (found in top right user menu) and the Cog link (found in sidebar user info) -->
        <div id="modal-user-settings" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header text-center">
                        <h2 class="modal-title"><i class="fa fa-pencil"></i> Profile utilisateur</h2>
                    </div>
                    <!-- END Modal Header -->

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form  id="form-validation" action="{{route('updateByUser',Auth::user()->id)}}" method="get"  class="form-horizontal form-bordered">
                            <fieldset>
                                <legend>Infos personnelles</legend>
                                {{-- <div class="form-group">
                                    <label class="col-md-4 control-label">Login</label>
                                    <div class="col-md-8">
                                        <p class="form-control-static">{{ Auth::user()->login}}</p>
                                    </div>
                                </div> --}}
                                <div class="form-group">
                                        <label class="col-md-4 control-label" for="user-settings-email">Email</label>
                                        <div class="col-md-8">
                                            <input type="email" id="user-settings-email" name="email" class="form-control" value="{{Auth::user()->email}}">
                                        </div>
                                </div>
                                <div class="form-group">
                                            <label class="col-md-4 control-label" for="user_name">Nom</label>
                                            <div class="col-md-8">
                                                <input type="text" id="user_name" name="nom" class="form-control" value="{{ Auth::user()->name}}">
                                            </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="user_prenom">Prenom</label>
                                    <div class="col-md-8">
                                        <input type="text" id="user_prenom" name="prenom" class="form-control" value="{{Auth::user()->prenom}}">
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
        <!-- END User Settings -->

        <div id="modal-confirm-changestatus" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header text-center">
                        <h2 class="modal-title"><i class="fa fa-pencil"></i> Confirmer</h2>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_entreprise" id="id_entreprise">
                        <input type="hidden" name="id_user" id="id_user">
                        <p><h2>Voulez-vous vraiment Valider ce dossier?</h2></p>
                    <div class="form-group form-actions">
                        <div class="text-right">
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-sm btn-primary" onclick="validerdossier();">OUI</button>
                        </div>
                        
                    </div>
                    </div>
                    <!-- END Modal Body -->
                </div>
            </div>
        </div>
        <div id="modal-confirm-rejet" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header text-center">
                        <h2 class="modal-title"><i class="fa fa-pencil"></i> Renseigner la raison du rejet</h2>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_entreprise" id="id_entreprise1">
                        <input type="hidden" name="id_user" id="id_user1">
                        <div class="form-group">
                          <label for="">Entrez la raison :</label>
                          <textarea id="raison_du_rejet" name="raison_du_rejet" placeholder="Entrez la raison du rejet" id="" cols="60" rows="10"  aria-describedby="helpId"></textarea>
                        </div>

                    <div class="form-group form-actions">
                        <div class="text-right">
                            <button type="submit" class="btn btn-sm btn-danger" onclick="rejeterdossier();">Valider le rejet</button>
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
                    <!-- END Modal Body -->
                </div>
            </div>
        </div>
        <div id="modal-confirm-presence" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header text-center">
                        {{-- <h2 class="modal-title"><i class="fa fa-pencil"></i> Valider la présence des entreprises à la formation</h2> --}}
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_entreprise" id="id_entreprise1">
                        <p><h2>Voulez-vous vraiment Valider la présence?</h2></p>
                    <div class="form-group form-actions">
                        <div class="text-right">
                            <button type="submit" class="btn btn-sm btn-danger" onclick="();">Valider</button>
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
                    <!-- END Modal Body -->
                </div>
            </div>
        </div>

     </div>
        <script src={{ asset("js/highcharts.js") }}></script>

        <!-- jQuery, Bootstrap.js, jQuery plugins and Custom JS code -->
        <script src=" {{ asset('js/vendor/jquery.min.js') }} "></script>
        <script src="{{ asset('js/vendor/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/plugins.js') }}"></script>

        <script src="{{ asset('js/helpers/ckeditor/ckeditor.js') }}"></script>
        <!-- Google Maps API Key (you will have to obtain a Google Maps API key to use Google Maps) -->
        <!-- For more info please have a look at https://developers.google.com/maps/documentation/javascript/get-api-key#key -->
        {{-- <script src="https://maps.googleapis.com/maps/api/js?key="></script> --}}
        <script src="{{ asset('js/helpers/gmaps.min.js') }}"></script>
        <script src={{ asset("js/modules/exporting.js") }}></script>
        <script src={{ asset("js/modules/export-data.js") }}></script>
        <script src="{{ asset('js/pages/ecomDashboard.js') }}"></script>
        <script src={{ asset("datatables/js/datatables.js") }}></script>
        <script src="{{ asset("js/pages/formsWizard.js") }}"></script>
        <script src="{{ asset('js/app.js') }}"></script>
        <script>$(function(){ FormsWizard.init(); });</script>
        <!-- Load and execute javascript code used only in this page -->
        {{-- <script src=" {{ asset('js/pages/index2.js') }}"></script> --}}
        <script src="{{ asset("js/mon.js") }}"></script>
        <script src="{{ asset("js/pages/formsValidation.js") }}"></script>
        <script>$(function(){ FormsValidation.init(); });</script>
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
    crossorigin=""></script>
    <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>

    @yield('additional_script')
    

    <script>
        function listedashbordlistdata(url) 
        {   
            var url = url;
            $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    error:function(data){alert("Erreur");},
                    success: function (data) {
                        $('#datatable').dataTable().fnClearTable();
                        $('#datatable').dataTable().fnDestroy();
                        console.log(data);
                        var options = '';
                        for (var x = 0; x < data.length; x++) {
                            var y= x + 1; 
                            var rout= '{{ route("entreprise.view",":id")}}';
                            var rout = rout.replace(':id', data[x]['id']);
                            options +='<tr> <td > ' + y + '</td><td > ' + data[x]['region'] + '</td><td > ' + data[x]['province'] + '</td><td > ' + data[x]['commune'] + '</td><td > ' + data[x]['arrondissement'] + '</td><td > ' + data[x]['code_promoteur'] + '</td><td  width="30%"> ' + data[x]['denomination']  + '</td><td  width="10%"> ' + data[x]['secteur_activite'] + '</td><td  width="10%"> ' + data[x]['maillon_activite'] + '</td> <td  width="5%"><div class="btn-group"><a  onclick="detailvaleur(' + data[x]['id'] + ' ); "href="'+rout+'" data-toggle="tooltip" data-toggle="modal" title="Voir details" class="btn btn-md btn-success"><i class="fa fa-eye"></i></a></div></td></tr>';
                             }
                       $('#tbadys').html(options); 
                       makedatatable();
                    }
            });
        }
        function listepcadashbordlistdata(url) 
        {   
            var url = url;
            $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    error:function(data){alert("Erreur");},
                    success: function (data) {
                        $('#datatable').dataTable().fnClearTable();
                        $('#datatable').dataTable().fnDestroy();
                        //alert(data);
                        var options = '';
                        for (var x = 0; x < data.length; x++) {
                            var y= x + 1; 
                            var rout= '{{ route("entreprise.view",":id")}}';
                            var rout = rout.replace(':id', data[x]['id']);
                            options +='<tr> <td > ' + y + '</td><td > ' + data[x]['region'] + '</td><td  width="30%"> ' + data[x]['denomination']  + '</td><td  width="10%"> ' + data[x]['secteur_activite'] + '</td><td  width="10%"> ' + data[x]['maillon_activite'] + '</td> <td  width="5%"><div class="btn-group"><a  onclick="detailvaleur(' + data[x]['id'] + ' ); "href="'+rout+'" data-toggle="tooltip" data-toggle="modal" title="Voir details" class="btn btn-md btn-success"><i class="fa fa-eye"></i></a></div></td></tr>';
                             }
                       $('#tbadys').html(options); 
                       makedatatable();
                    }
            });
        }
    </script>

<script>
function makedatatable(){
	var groupColumn = 0;
  var table = $('#datatable').DataTable({
        buttons: [
            'copyHtml5',
            {
                extend: 'excel',
            },
            'csvHtml5',
            'pdfHtml5'
        ],
		dom: 'Bfrtip',
		initComplete: function () {
            var api = this.api();
            api
                .columns()
                .eq(0)
                .each(function (colIdx) {
                    // Set the header cell to contain the input element
                    var cell = $('.filters th').eq(
                        $(api.column(colIdx).header()).index()
                    );
                    var title = $(cell).text();
                    $(cell).html('<input type="text" placeholder="' + title + '" />');
 
                    // On every keypress in this input
                    $(
                        'input',
                        $('.filters th').eq($(api.column(colIdx).header()).index())
                    )
                        .off('keyup change')
                        .on('keyup change', function (e) {
                            e.stopPropagation();
 
                            // Get the search value
                            $(this).attr('title', $(this).val());
                            var regexr = '({search})'; //$(this).parents('th').find('select').val();
 
                            var cursorPosition = this.selectionStart;
                            // Search the column for that value
                            api
                                .column(colIdx)
                                .search(
                                    this.value != ''
                                        ? regexr.replace('{search}', '(((' + this.value + ')))')
                                        : '',
                                    this.value != '',
                                    this.value == ''
                                )
                                .draw();
 
                            $(this)
                                .focus()[0]
                                .setSelectionRange(cursorPosition, cursorPosition);
                        });
                });
        },

    }
	);
	
}
   
   </script>
    <script language = "JavaScript">
        var url = "{{ route('souscriptionparzone') }}";
          $.ajax({
                     url: url,
                     type: 'GET',
                     dataType: 'json',
                     error:function(data){alert("Erreur");},
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
                                text: 'Nombre de souscription par région'
                            },
                            tooltip: {
                                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                            },
                            credits:{
                                enabled:false,
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
    </script>
    <script language = "JavaScript">
        var url = "{{ route('souscriptionparsecteuractivite') }}";
          $.ajax({
                            url: url,
                            type: 'GET',
                            dataType: 'json',
                            error:function(data){alert("Erreur");},
                            success: function (donnee) {
                            var donnch= new Array();
                            var secteur = new Array();
                        for(var i=0; i<donnee.length; i++)
                        {
                          donnch.push({
                                    name: donnee[i].secteur,
                                    y:  parseInt(donnee[i].nombre),
                                    dataLabels: {
                                    enabled: true,
                                    }} )
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
                                text: 'Nombre de souscription par secteur dactivite'
                            },
                            credits:{
                                enabled:false,
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
</script>
<script language ="JavaScript">
    function entreprise_aformer(type_entreprise, valeur_de_forme, pca){
        (type_entreprise=="mpme")?(categorie_entreprise="Les MPME"):(categorie_entreprise="Les Entreprises leaders et les AOP");
        (valeur_de_forme==1)?(former="ayant suivis la formation"):(former="Selectionnées pour la formation ");
        var url = "{{ route('souscriptionretenueparsecteuractivite') }}";
          $.ajax({
                            url: url,
                            type: 'GET',
                            dataType: 'json',
                            data:{type_entreprise:type_entreprise, valeur_de_forme:valeur_de_forme, pca:pca},
                            error:function(data){alert("Erreur");},
                            success: function (donnee) {
                        var donnch= new Array();
                            var secteur = new Array();
                        for(var i=0; i<donnee.length; i++)
                        {
                          donnch.push({
                                    name: donnee[i].secteur,
                                    y:  parseInt(donnee[i].nombre),
                                    dataLabels: {
                                    enabled: true,
                                    }
                                })
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
                                text: categorie_entreprise + " " + former + " " + "regroupés par secteur d'activité"
                            },
                            credits:{
                                enabled:false,
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
var url = "{{ route('entreprise.preselectionneparzone') }}";
$.ajax({
                     url: url,
                     type: 'GET',
                    data:{type_entreprise:type_entreprise, valeur_de_forme:valeur_de_forme,pca:pca},
                     dataType: 'json',
                     error:function(data){alert("Erreur");},
                     success: function (donnee) {
                            var donnch= new Array();
                        for(var i=0; i<donnee.length; i++)
                        {
                          donnch.push({
                                    name: donnee[i].region,
                                    y:  parseInt(donnee[i].nombre),
                                   
                                } )
                        }
                        Highcharts.chart('indicateur2', {
                            chart: {
                                plotBackgroundColor: null,
                                plotBorderWidth: null,
                                plotShadow: false,
                                type: 'pie'
                            },
                            title: {
                                text: categorie_entreprise + " " + former + " " +'regroupés par région'
                            },
                            tooltip: {
                                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                            },
                            credits:{
                                enabled:false,
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
<script language = "JavaScript">
    function dashboardaopenregistre(type_entreprise, statut){
        var url = "{{ route('aopleader.enregistreparsecteuractivite') }}";
        (type_entreprise=='mpme')?(type="des MPME"):(type="des AOP");

          $.ajax({
                            url: url,
                            type: 'GET',
                            data:{type_entreprise:type_entreprise, statut:statut},
                            dataType: 'json',
                            error:function(data){alert("Erreur");},
                            success: function (donnee) {
                            var donnch= new Array();
                            var secteur = new Array();
                        for(var i=0; i<donnee.length; i++)
                        {
                          donnch.push({
                                    name: donnee[i].secteur,
                                    y:  parseInt(donnee[i].nombre),
                                    dataLabels: {
                                    enabled: true,
                                    }
                                } )
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
                                text:  "La repartition des"+ " " + type + " " + "enregistrés par secteur d'activité"
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
                     error:function(data){alert("Erreur");},
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

<script language = "JavaScript">
    function dashboardentreprise_aformer(type_entreprise){
        var url = "{{ route('aopleader.enregistreparsecteuractivite') }}";
          $.ajax({
                            url: url,
                            type: 'GET',
                            dataType: 'json',
                            error:function(data){alert("Erreur");},
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
                                text: 'Nombre de souscription par secteur dactivite'
                            },
                            plotOptions: {
                                pie: {
                                    allowPointSelect: true,
                                    cursor: 'pointer',
                                    dataLabels: {
                                        enabled: true,
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
                     error:function(data){alert("Erreur");},
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
                                text: 'Nombre de souscription par région'
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
<script language = "JavaScript">
    var url = "{{ route('enregistreSecteurActiviteZone') }}";
      $.ajax({
                            url: url,
                            type: 'GET',
                            dataType: 'json',
                            error:function(data){alert("Erreur");},
                            success: function (donnee) {
                            var donnch= new Array();
                            var secteur = new Array();
                    for(var i=0; i<donnee.length; i++)
                    {

                      donnch.push({
                                name: "agriculture",
                                data: [2,2,3,3,2]
                    })
                }
                    for(var i=0; i<donnee.length; i++)
                    {

                            secteur[i] = donnee[i].region

                    }
                    Highcharts.chart('indicateur3', {
                        chart: {
                            type: 'column'
                        },
                        xAxis: {
                             categories: ['BOUCLE DU MOUHOUN', 'BOUCLE DU MOUHOUN', 'CENTRE', 'NORD']
                        },
                        title: {
                            text: 'Nombre de souscription par secteur dactivite'
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
</script>
<script>
    Highcharts.chart('indicateur3', {
  chart: {
    type: 'column'
  },
  title: {
    text: 'Column chart with negative values'
  },
  xAxis: {
    categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
  },
  credits: {
    enabled: false
  },
  series: [{
    name: 'John',
    data: [5, 3, 4, 7, 2]
  }, {
    name: 'Jane',
    data: [2, -2, -3, 2, 1]
  }, {
    name: 'Joe',
    data: [3, 4, 4, -2, 5]
  }]
});
</script>
<script>
function initMap()
{ 
    var markers = L.markerClusterGroup();
    var url = "{{ route('souscriptiongeopresenation') }}";
    $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            error:function(data){alert("Erreur");},
            success: function (data) {
                for(var i=0; i<data.length; i++)
                    {
                        if(data[i].longitude){
                            marker= L.marker([data[i].longitude, data[i].latitude]);
                            marker.bindPopup("<b>"+'Denomination :'+data[i].denomination+"!</b><br>"+'Zone :'+data[i].region).openPopup();
                            markers.addLayer(marker);
                        } 
                    }
                    map.addLayer(markers);
            }
    });
}
</script>

<script>
function selectionner(){
    var selec=[];
    var formation = $("#formation").val();
    $('#listecandidat :input:checkbox:checked').each(function(){
    selec.push($(this).val());
});
///alert(selec);
    var url = "{{ route('storeparticipant') }}";
$.ajax({
    url: url,
    type:'GET',
    data: {id_formation: formation, participants: selec } ,
    error:function(){alert('error');},
    success:function(){
        $('#modal-confirm-delete').hide();
        location.reload();
    }
});
}
</script>
<script>
function deselectionner(){
    var deselec=[];
    var formation = $("#formation").val();
    $('#decochercandidat :input:checkbox:checked').each(function(){
    deselec.push($(this).val());
});
    var url = "{{ route('supprimerparticipant') }}";
$.ajax({
    url: url,
    type:'GET',
    data: {id_formation: formation, participants: deselec } ,
    error:function(){alert('error');},
    success:function(){
        $('#modal-confirm-delete').hide();
        location.reload();
    }
});
}
</script>
<script>
    function present(){
        var deselec=[];
        var formation = $("#formation").val();
        $('#decochercandidat :input:checkbox:checked').each(function(){
        deselec.push($(this).val());
    });
        var url = "{{ route('validerpresenceparticipant') }}";
    $.ajax({
        url: url,
        type:'GET',
        data: {id_formation: formation, participants: deselec } ,
        error:function(){alert('error');},
        success:function(){
            $('#modal-confirm-delete').hide();
            location.reload();
        }
    });
    }
    </script>



        <script>
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




    </body>
</html>
