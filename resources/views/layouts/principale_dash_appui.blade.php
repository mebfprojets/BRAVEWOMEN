<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <title>Dashboard BRAVE WOMEN</title>

        <meta name="description" content="ProUI is a Responsive Bootstrap Admin Template created by pixelcave and published on Themeforest.">
        <meta name="author" content="pixelcave">
        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0">

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href= " {{ asset("img/favicon.ico") }}">
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
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <link rel="stylesheet" href='{{ asset("js/plugins/fontawesome-free/css/all.min.css") }}'>
  <!-- Theme style -->
       
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}">
        <!-- Related styles of various icon packs and plugins -->
        <link rel="stylesheet" href="{{ asset('css/plugins.css') }}">
        
        <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">

        <!-- Include a specific file here from css/themes/ folder to alter the default theme of the template -->

        <!-- The themes stylesheet of this template (for using specific theme color in individual elements - must included last) -->
        <link rel="stylesheet" href="{{ asset('css/themes.css') }}">
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
        crossorigin=""/>
        <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css">

        <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
        <style>
           #map{
                height: 400px;
                margin-top:10px;
               
           }
        </style>
        <!-- END Stylesheets -->

        <!-- Modernizr (browser feature detection library) -->
        <script src="js/vendor/modernizr.min.js"></script>
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
                <h1 class="push-top-bottom text-light text-center"><strong>Pro</strong>UI</h1>
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
                        <div class="row">
                            <div class="col-lg-3 col-6">
                              <!-- small box -->
                              <div class="small-box bg-default">
                                <div class="inner">
                                  <h3>{{ $total_souscription_enregistres }}</h3>
                                  <p>Souscriptions</p>
                                </div>
                                <div class="icon">
                                  <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="{{ route('detail_dashboard') }}?type_detail=mpme&phase={{ $phase }}" class="small-box-footer block1">Plus details <i class="fa fa-long-arrow-right"></i></a>
                              </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-6">
                              <!-- small box -->
                              <div class="small-box bg-default">
                                <div class="inner">
                                  <h3> {{ $nombre_de_pca }}<sup style="font-size: 20px"></sup></h3>
                                  <span></span><p>PCA enregistrés</p> 
                                </div>
                                <div class="icon">
                                  <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="{{ route('detail_dashboard_appui') }}?type_detail=pca&phase={{ $phase }}" class="small-box-footer block2">Plus de details <i class="fa fa-long-arrow-right"></i></i></a>
                              </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-6">

                              <div class="small-box bg-default">
                                <div class="inner">
                                  <h3>{{ format_prix($fond_mobilise)}} FCFA</h3>
                                  <p>Ressources Mobilisées</p>
                                </div>
                                <div class="icon">
                                  <i class="ion ion ion-stats-bars"></i>
                                </div>
                                <a href="{{ route('detail_dashboard_appui') }}?type_detail=finance&phase={{ $phase }}" class="small-box-footer block3">Plus de details <i class="fa fa-long-arrow-right"></i></a>
                              </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-6">
                              <!-- small box -->
                              <div class="small-box bg-default">
                                <div class="inner">
                                  <h3>Impacts</h3>
                                  <p>Socials/Economique</p>
                                </div>
                                <div class="icon">
                                  <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="{{ route('detail_dashboard_appui') }}?type_detail=impact&phase={{ $phase }}" class="small-box-footer block4">Plus de details <i class="fa fa-long-arrow-right"></i></a>
                              </div>
                            </div>
                            <!-- ./col -->
                          </div>
                        
                        
                        </div>
                        <!-- END Mini Top Stats Row -->

                        <!-- Widgets Row -->
                        <div class="row" >

                            @yield('content')
                            
                        </div>
                        <!-- END Widgets Row -->
                    </div>

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
        
        <!-- END User Settings -->

        <!-- jQuery, Bootstrap.js, jQuery plugins and Custom JS code -->
        <script src="{{ asset('js/vendor/jquery.min.js') }}"></script>
        <script src="{{ asset('js/vendor/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/plugins.js') }}"></script>
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/highcharts.js') }}"></script>
        

        <!-- Google Maps API Key (you will have to obtain a Google Maps API key to use Google Maps) -->
        <!-- For more info please have a look at https://developers.google.com/maps/documentation/javascript/get-api-key#key -->
        {{-- <script src="https://maps.googleapis.com/maps/api/js?key="></script> --}}
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
      
        <script src="{{ asset('js/helpers/gmaps.min.js') }}"></script>
       @yield('script_add')
        <!-- Load and execute javascript code used only in this page -->
        <script src="{{ asset('js/pages/index.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script>$(function(){ Index.init(); });</script>
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
        crossorigin=""></script>
        <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
        <script>
            var map = L.map('map').setView([12.375118, -1.522078], 7);
            L.tileLayer( 'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}',{
                     // Il est toujours bien de laisser le lien vers la source des données
                     attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                     id: 'mapbox/streets-v11',
                     accessToken: 'pk.eyJ1Ijoic3RlcGhzYW4iLCJhIjoiY2wxeGo1N2xuMDNiMDNkbXFudW8xazNrZiJ9.fHt7ZUxVTOdt_pAc-ps6dg',
                     minZoom: 1,
                     maxZoom: 20
                }).addTo(map);
                var url = "{{ route('souscriptiongeopresenation') }}";
                var custumIcon= L.icon({
                    iconUrl:'./img/femme.png',
                    iconSize:[30,30]
                });
                var markers = L.markerClusterGroup();
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                error:function(data){alert("Erreur");},
                success: function (data) {
                            for(var i=0; i<data.length; i++)
                                {
                                    if(data[i].longitude){
                                        var url = '{{ route("dashboard.entreprise_detail",":id") }}';
                                        url = url.replace(':id', data[i].id);
                                        marker= L.marker([data[i].longitude, data[i].latitude],{
                                        icon:custumIcon,
                                        title:data[i].denomination
                                    });
                                        if(data[i].aopOuleader="mpme"){
                                            var categorie="MPME"
                                        }
                                        else{
                                            var categorie="Entreprise Leader/AOP"
                                        }
                                        marker.bindPopup("<br>"+'<strong>Catégorie</strong> :'+categorie+"</b><br>"+'<strong>Denomination :</strong>'+data[i].denomination+"</b><br>"+'<strong>Téléphone :</strong>'+data[i].telephone+"</b><br>"+'<strong>Activité :</strong>'+data[i].secteur_activite+"</b><br>"+'<strong>Zone :</strong>'+data[i].region+"</b><br>"+'<a href="' + url + '" target="_blank">Details</a>').openPopup();
                                        markers.addLayer(marker);
                                    }
                                    
                                }
                                map.addLayer(markers);
                            }
                });
        </script>
        <script>
   
        
        </script>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript">
            google.charts.load('current', {'packages':['timeline']});
            google.charts.setOnLoadCallback(drawChart);
   
       function drawChart(){
   
           var url = "{{ route('activity.liste') }}";
                 $.ajax({
                     url: url,
                    type: 'GET',
                    dataType: 'json',
                     error:function(data){alert("Erreur");},
                      success: function (donnee) {
           console.log(donnee);
           var data = new google.visualization.DataTable(donnee);
           var container = document.getElementById('timeline1');
           var chart = new google.visualization.Timeline(container);
                   chart.draw(data);
   
       }
                 });
   
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
                                var region = new Array();
                            for(var i=0; i<donnee.length; i++)
                            {
                              donnch.push({
                                        name: donnee[i].region,
                                        y:  parseInt(donnee[i].nombre)} )
                            }
                            for(var i=0; i<donnee.length; i++)
                            {
                                region[i] = donnee[i].region
                            }
                            Highcharts.chart('indicateur2', {
                                chart: {
                                    type: 'column'
                                },
                                xAxis: {
                                     categories: region
                                },
                                title: {
                                    text: 'Repartition des souscriptions par region'
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
                                    text: "Repartition des souscriptions par secteur d'activité"
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
<div id="modal-details-montant_mobilise"  class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Details des montants mobilisés </h2>
            </div>
            <div class="modal-body">
  
            </div>
            <!-- END Modal Body -->
        </div>
    </div>
  </div>
{{-- graphe chargé au lancement des details financements --}}
{{--<script language = "JavaScript">
        var url = "{{ route('situation_des_paiements_par_banque') }}?statut='validée'";

          $.ajax({
              url: url,
             type: 'GET',
             dataType: 'json',
              error:function(data){alert("Erreur");},
               success: function (donnee) {
                var donnch= new Array();
                var mois = new Array();
          
                for(var i=0; i<donnee.length; i++)
                        {
                            
                          donnch.push({
                                    name: donnee[i].name,
                                    data: donnee[i].data});
                            
                        }

                        for(var i=0; i<donnee[1].mois.length; i++)
                        {
                            mois[i] = donnee[1].mois[i]
                        }
                    console.log(mois);
                Highcharts.chart('indicateur3', {

title: {
text: 'Situation des factures fournisseurs en attente de paiement par banques partenaires'
},

subtitle: {
text: 'Source: BRAVE WOMEN Burkina Faso'
},

yAxis: {
title: {
text: 'Montant des Factures en attente de paiement chez les banques partenaire'
}
},

xAxis: {
categories: mois
},
legend: {
layout: 'vertical',
align: 'right',
verticalAlign: 'middle'
},

plotOptions: {
series: {
label: {
  connectorAllowed: true
},

}
},

series: donnch,

responsive: {
rules: [{
condition: {
  maxWidth: 500
},
chartOptions: {
  legend: {
    layout: 'horizontal',
    align: 'center',
    verticalAlign: 'bottom'
  }
}
}]
}

});
 }
});
var url = "{{ route('situation_des_paiements_par_banque') }}?statut='payée'";
//var statut1='payée'
          $.ajax({
              url: url,
             type: 'GET',
             dataType: 'json',
              error:function(data){alert("Erreur");},
               success: function (donnee) {
                var donnch= new Array();
                var mois = new Array();
          
                for(var i=0; i<donnee.length; i++)
                        {  
                          donnch.push({
                                    name: donnee[i].name,
                                    data:  donnee[i].data});
                            
                        }
                        for(var i=0; i<donnee[1].mois.length; i++)
                        {
                            mois[i] = donnee[1].mois[i]
                        }
                    console.log(mois);
                Highcharts.chart('indicateur4', {

title: {
text: 'Situation des paiements des founisseurs effectués par banques partenaires'
},

subtitle: {
text: 'Source: <a href="https://irecusa.org/programs/solar-jobs-census/" target="_blank">Brave Women</a>'
},

yAxis: {
title: {
text: 'Paiements des factures founisseurs par banques partenaires'
}
},

xAxis: {
categories: mois
},
legend: {
layout: 'vertical',
align: 'right',
verticalAlign: 'middle'
},

plotOptions: {
series: {
label: {
  connectorAllowed: true
},

}
},

series: donnch,

responsive: {
rules: [{
condition: {
  maxWidth: 500
},
chartOptions: {
  legend: {
    layout: 'horizontal',
    align: 'center',
    verticalAlign: 'bottom'
  }
}
}]
}

});
 }
});
       
</script>
<script language = "JavaScript">
    function versement_contrepartie_parmois(){
        var url = "{{ route('contrepartie_mobilisee_par_localite') }}";
          $.ajax({
              url: url,
             type: 'GET',
             dataType: 'json',
              error:function(data){alert("Erreur");},
               success: function (donnee) {
                var donnch= new Array();
                            var region = new Array();
                        for(var i=0; i<donnee.length; i++)
                        {
                          donnch.push({
                                    name: donnee[i].region,
                                    y:  parseInt(donnee[i].montant_mobilise)} )
                        }
                        for(var i=0; i<donnee.length; i++)
                        {
                                region[i] = donnee[i].region
                        }
                        Highcharts.chart('indicateur3', {
                                chart: {
                                    type: 'column'
                                },
                                xAxis: {
                                     categories: region
                                },
                                title: {
                                    text:  "Situation de la contre partie mobilisée par localité"
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
                                    name: 'Montant en FCFA',
                                    colorByPoint: true,
                                    data: donnch
                                }]
                            });
 
}
});
var url = "{{ route('contrepartie_versee_par_periode') }}";
          $.ajax({
              url: url,
             type: 'GET',
             dataType: 'json',
              error:function(data){alert("Erreur");},
               success: function (donnee) {
                var donnch= new Array();
                var mois = new Array();
          
                for(var i=0; i<donnee.length; i++)
                        {
                            
                          donnch.push({
                                    name: donnee[i].name,
                                    data:  donnee[i].data});
                            
                        }

                        for(var i=0; i<donnee[1].mois.length; i++)
                        {
                            mois[i] = donnee[1].mois[i]
                        }
                    console.log(mois);
                Highcharts.chart('indicateur4', {

title: {
text: 'Flux de mobilisation de la contre partie des beneficiaires'
},

subtitle: {
text: 'BRAVE WOMEN Burkina Faso'
},

yAxis: {
title: {
text: 'Contrepartie mobilisée par banque'
}
},

xAxis: {
categories: mois
},
legend: {
layout: 'vertical',
align: 'right',
verticalAlign: 'middle'
},

plotOptions: {
series: {
label: {
  connectorAllowed: true
},

}
},

series: donnch,

responsive: {
rules: [{
condition: {
  maxWidth: 500
},
chartOptions: {
  legend: {
    layout: 'horizontal',
    align: 'center',
    verticalAlign: 'bottom'
  }
}
}]
}

});
 }
});



    }      
</script>
--}}
 <script language = "JavaScript">
        function situation_de_deblocage_de_la_subvention(){
           // alert('okok');
            var url = "{{ route('situation_des_subventions_debloque_par_banque') }}";
              $.ajax({
                  url: url,
                 type: 'GET',
                 dataType: 'json',
                  error:function(data){alert("Erreur");},
                   success: function (donnee) {
                    var donnch= new Array();
                    var mois = new Array();
              
                    for(var i=0; i<donnee.length; i++)
                            {
                                
                              donnch.push({
                                        name: donnee[i].name,
                                        data:  donnee[i].data});
                                
                            }

                            for(var i=0; i<donnee[1].mois.length; i++)
                            {
                                mois[i] = donnee[1].mois[i]
                            }
                      
                    Highcharts.chart('indicateur4', {

title: {
  text: 'Flux du du deblocage de la subvention par banque'
},

subtitle: {
  text: 'Source: <a href="https://irecusa.org/programs/solar-jobs-census/" target="_blank">IREC</a>'
},

yAxis: {
  title: {
    text: 'La subvention mobilisée par banque'
  }
},

xAxis: {
    categories: mois
  },
legend: {
  layout: 'vertical',
  align: 'right',
  verticalAlign: 'middle'
},

plotOptions: {
  series: {
    label: {
      connectorAllowed: true
    },
    
  }
},

series: donnch,

responsive: {
  rules: [{
    condition: {
      maxWidth: 500
    },
    chartOptions: {
      legend: {
        layout: 'horizontal',
        align: 'center',
        verticalAlign: 'bottom'
      }
    }
  }]
}

});
     }
 });
 
    var url = "{{ route('situation_subvention_par_zone') }}";

              $.ajax({
                  url: url,
                 type: 'GET',
                 dataType: 'json',
                  error:function(data){alert("Erreur");},
                   success: function (donnee) {
                            var donnch= new Array();
                            var region = new Array();
                        for(var i=0; i<donnee.length; i++)
                        {
                          donnch.push({
                                    name: donnee[i].region,
                                    y:  parseInt(donnee[i].montant_debloque)} )
                        }
                        for(var i=0; i<donnee.length; i++)
                        {
                                region[i] = donnee[i].region
                        }
                        Highcharts.chart('indicateur3', {
                                chart: {
                                    type: 'column'
                                },
                                xAxis: {
                                     categories: region
                                },
                                title: {
                                    text:  "Situation de la subvention debloquée par localité"
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
                                    name: 'Montant en FCFA',
                                    colorByPoint: true,
                                    data: donnch
                                }]
                            });
     }
 });

    
   
        }      
</script>
<script language = "JavaScript">
    function entreprise_aformer(type_entreprise, valeur_de_forme){
        (type_entreprise=="mpme")?(categorie_entreprise="Les MPME"):(categorie_entreprise="Les Entreprises leaders et les AOP");
        (valeur_de_forme==1)?(former="ayant suivis la formation"):(former="sélectionnées pour la formation ");
        var url = "{{ route('souscriptionretenueparsecteuractivite') }}";
          $.ajax({
                            url: url,
                            type: 'GET',
                            dataType: 'json',
                            data:{type_entreprise:type_entreprise, valeur_de_forme:valeur_de_forme },
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
                    data:{type_entreprise:type_entreprise, valeur_de_forme:valeur_de_forme},
                     dataType: 'json',
                     error:function(data){alert("Erreur");},
                     success: function (donnee) {
                            var donnch= new Array();
                            var zone = new Array();
                        for(var i=0; i<donnee.length; i++)
                        {
                          donnch.push({
                                    name: donnee[i].region,
                                    y:  parseInt(donnee[i].nombre)} )
                        }
                        for(var i=0; i<donnee.length; i++)
                        {
                                zone[i] = donnee[i].region
                        }
                        Highcharts.chart('indicateur2', {
                            chart: {
                                type: 'column'
                            },
                            xAxis: {
                                 categories: zone
                            },
                            
                            title: {
                                text: categorie_entreprise + " " + former + " " +'regroupés par région'
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
                                        formatter: function () {
                                                return this.point.custom;
                                         }
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
 {{-- <script language = "JavaScript">
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
                            for(var i=0; i<donnee.length; i++)
                            {
                                    zone[i] = donnee[i].region
                            }
                            Highcharts.chart('indicateur2', {
                                chart: {
                                    type: 'column'
                                },
                                xAxis: {
                                     categories: zone
                                },
                                title: {
                                    text: "La repartition des"+ " " + type + " " + "enregistrés par localités"
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
        }      
    </script> --}}
    <script language = "JavaScript">
        function dashboardaopenregistre(type_entreprise, statut){
            var url = "{{ route('aopleader.enregistreparsecteuractivite') }}";
            (type_entreprise=='mpme')?(type="MPME"):(type="AOP");
            (statut=='nostatut')?(result="enregistrés"):(result="ajournés");

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
                                    text:  "La répartition des"+ " " + type + " " + result +" "+"par secteur d'activité"
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
                                var zone = new Array();
                            for(var i=0; i<donnee.length; i++)
                            {
                              donnch.push({
                                        name: donnee[i].region,
                                        y:  parseInt(donnee[i].nombre)} )
                            }
                            for(var i=0; i<donnee.length; i++)
                            {
                                    zone[i] = donnee[i].region
                            }
                            Highcharts.chart('indicateur2', {
                                chart: {
                                    type: 'column'
                                },
                                xAxis: {
                                     categories: zone
                                },
                                title: {
                                    text: "La répartition des"+ " " + type + " " + result +" "+ "par localités"
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
        }      
    </script>
    
    <script language = "JavaScript">
        function dashboardentreprise_aformer(type_entreprise){
            //alert(type_entreprise);
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
                         error:function(data){alert("Erreur");},
                         success: function (donnee) {
                                var donnch= new Array();
                                var zone = new Array();
                            for(var i=0; i<donnee.length; i++)
                            {
                              donnch.push({
                                        name: donnee[i].region,
                                        y:  parseInt(donnee[i].nombre)} )
                            }
                            for(var i=0; i<donnee.length; i++)
                            {
                                    zone[i] = donnee[i].region
                            }
                            Highcharts.chart('indicateur2', {
                                chart: {
                                    type: 'column'
                                },
                                xAxis: {
                                     categories: zone
                                },
                                title: {
                                    text: 'Nombre de souscription par région'
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
        }      
    </script>
    
    
    </body>
</html>
