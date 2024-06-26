<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <title>BraveWomen - Plateforme</title>
      
        <meta name="description" content="ProUI is a Responsive Bootstrap Admin Template created by pixelcave and published on Themeforest.">
        <meta name="author" content="pixelcave">
        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0">

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="{{ asset("img/favicon.ico") }}">
        <link rel="apple-touch-icon" href="{{ asset("img/favicon.ico")}}"  sizes="57x57">
        <link rel="apple-touch-icon" href="{{ asset("img/favicon.ico")}}"  sizes="72x72">
        <link rel="apple-touch-icon" href="{{ asset("img/favicon.ico")}}"  sizes="76x76">
        <link rel="apple-touch-icon" href="{{ asset("img/favicon.ico")}}"  sizes="114x114">
        <link rel="apple-touch-icon" href="{{ asset("img/favicon.ico")}}"  sizes="120x120">
        <link rel="apple-touch-icon" href="{{ asset("img/favicon.ico")}}"  sizes="144x144">
        <link rel="apple-touch-icon" href="{{ asset("img/favicon.ico")}}"  sizes="152x152">
        <link rel="apple-touch-icon" href="{{ asset("img/favicon.ico")}}"  sizes="180x180">
        <!-- END Icons -->

        <!-- Stylesheets -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>

        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('js/plugins/ekko-lightbox/ekko-lightbox.css') }}">
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
         <link href="https://unpkg.com/vis-timeline@latest/styles/vis-timeline-graph2d.min.css" rel="stylesheet" type="text/css" /> 
    </head>
    <body style="height: 100%">
        <div id="page-wrapper" >
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
               
                <div id="main-container">
                    @include('partials.admin.header')

                    <div id="page-content">
                        <div class="row">
                            @include('flash::message')
                            @yield('content')
                            <div id='loader'>
                                <div style="margin-top:200px; margin-left:50%;">
                                    <img  src="/img/loading-gif.gif" alt="" width="200"  center>
                                    <p style="color:green; font-size:18px; font-weight:600"> .... Chargement en cours</p>
                                </div>
                                    
                            </div>
                           
                            {{-- <script src="//code.jquery.com/jquery.js"></script>
	                            @include('flashy::message')--}}
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
       
        <a href="#" id="to-top"><i class="fa fa-angle-double-up"></i></a>
        @yield('modal_part')
    
        <!-- User Settings, modal which opens from Settings link (found in top right user menu) and the Cog link (found in sidebar user info) -->
        <div id="modal-user-settings" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header text-center">
                        <h2 class="modal-title"><i class="fa fa-pencil"></i> Profile utilisateur</h2>
                    </div>

                    <div class="modal-body">
                        <form  id="form-validation" action="{{route('updateByUser',Auth::user()->id)}}" method="get"  class="form-horizontal form-bordered">
                            <fieldset>
                                <legend>Infos personnelles</legend>
                               
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
        
      <div id="modal-confirm-ugp" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header text-center">
                         <h2 class="modal-title"><i class="fa fa-pencil"></i> Apprecier la conformité qualititative</h2>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_entreprise" id="id_entreprise1">
                        <input type="hidden" name="conformite" id="conformite">
                        <p class="modal-text">Cette action donnera un avis de l'UGP sur l'éligibilité de l'entreprise. Voulez-vous continuer?</p>
                    <div class="form-group form-actions">
                        <div class="text-right">
                            <button type="submit" class="btn btn-sm btn-danger" onclick="saveconformite_souscription();">Valider</button>
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Annnuler</button>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
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
                        <p><h3 style="color: red">Voulez-vous donner un avis favorable à ce dossier?</h3></p>
                    <div class="form-group form-actions">
                        <div class="text-right">
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-sm btn-primary" onclick="validerdossier();">OUI</button>
                        </div>
                    </div>
                    </div>
                   
                </div>
            </div>
        </div>
        <div id="modal-confirm-send_synthese" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header text-center">
                        <h2 class="modal-title"><i class="fa fa-pencil"></i> Confirmer</h2>
                    </div>
                    <div class="modal-body">
                    <form action="{{route('send.synthese')}}" method="get">
                        <input type="hidden" name="entreprise_id" id="entreprise_id">
                        <p>Voulez-vous vraiment envoyer la synthèse de la candidature aux membres du comité de selection ?</p>
                    <div class="form-group form-actions">
                        <div class="text-right">
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-sm btn-primary">OUI</button>
                        </div>
                    </div>
                </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="modal-confirm-rejet" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header text-center">
                        <h2 class="modal-title"><i class="fa fa-pencil"></i> Donner un avis defavorable </h2>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_entreprise" id="id_entreprise1">
                        <input type="hidden" name="id_user" id="id_user1">
                        <div class="form-group">
                          <label for="">Renseigner la raison :</label>
                          <textarea id="raison_du_rejet" name="raison_du_rejet" placeholder="Entrez la raison du rejet"  cols="60" rows="10"  aria-describedby="helpId" onchange="activerbtn('btn_rejet','raison_du_rejet')"></textarea>
                        </div>

                    <div class="form-group form-actions">
                        <div class="text-right">
                            <button type="submit"  disabled class="btn btn-sm btn-danger btn_rejet" onclick="rejeterdossier();">Avis défavorable</button>
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
                    <!-- END Modal Body -->
                </div>
            </div>
        </div>
        <div id="modal-decision-du-comite" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header text-center">
                        <h2 class="modal-title"><i class="fa fa-check"></i> Décision finale du comité technique</h2>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_entreprise" id="id_entreprise1">
                        <input type="hidden" name="id_user" id="id_user1">
                        <div class="form-group">
                          <label for="">Entrez les observations :</label>
                          <textarea id="observation_comite" name="observation" placeholder="Observation" id="" cols="60" rows="10" onchange="activerbtn('btn_desactive','observation_comite')" aria-describedby="helpId"></textarea>
                        </div>

                    <div class="form-group form-actions">
                        <div class="text-right">
                            <button  class="btn btn-md btn-danger btn_desactive" onclick="statuersurLasoucriptionPmeParleComitePourLaPhaseFormation('ajournee');" disabled>Ajournée</button>
                            <button class="btn btn-md btn-success btn_desactive" onclick="statuersurLasoucriptionPmeParleComitePourLaPhaseFormation('selectionnee');" disabled>Selectionnée</button>
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
    <script src="{{ asset("js/scriptmap.js") }}"></script>
    <script>
        $('div.alert').not('.alert-important').delay(2000).fadeOut(350);
    </script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    @yield('script_additionnel')
    <script>
           function recuperer_id(id,valeur){
            document.getElementById(id).setAttribute("value", valeur);     
    }
    </script>
    <script>
        function loadfunction(){
          //  alert('oko');
            $('#loader').show();
        }
        $(function() {
            $(".loaddata").click(function() {
               
                $('#loader').show();
            });
        });
        </script>
    <script>
function save_note_qualitatif(){
        var id_entreprise= $("#entreprise").val();
        var note_qualitatif= $("#note_qualitatif").val();
        var url = "{{ route('souscription.savenote_qualitatif') }}";
        $.ajax({
                url: url,
                type:'GET',
                data: {id_entreprise: id_entreprise, note_qualitatif:note_qualitatif} ,
                error:function(){alert('error');},
                success:function(){
                    $('#modal-confirm-rejet').hide();
                    location.reload();
                }
            });

    }
    $( document ).ready(function() {
            var url = "{{ route('all.activity') }}";
              $.ajax({
                  url: url,
                 type: 'GET',
                 dataType: 'json',
                  error:function(data){

    },
                   success: function (donnee) {
        console.log(donnee);
            var group= new Array();
            var items = new vis.DataSet();
                for(var i=0; i<donnee.length; i++)
                    {
                        group.push({
                            id: donnee[i].id,
                            content: donnee[i].numero+'. '+donnee[i].libelle+' '+donnee[i].taux + '%',
                    })  
                }
                var groups = new vis.DataSet(group);
                for(var i=0; i<donnee.length; i++)
                    {
                        var start = new Date(donnee[i].date_debut);
                        var end = new Date(donnee[i].date_fin);
                        items.add({
                            id: donnee[i].id,
                            group: donnee[i].id,
                            start: start,
                            end: end,
                            className: 'p1',
                            content: ''
                        });
                    }
                    var now = Date.now();
                    var options = {
                        stack: true,
    maxHeight: 240,
    horizontalScroll: true,
    verticalScroll: true,
    zoomKey: "ctrlKey",
    start: Date.now() - 1000 * 60 * 60 * 24 * 3, // minus 3 days
    end: Date.now() + 1000 * 60 * 60 * 24 * 60, // plus 1 months aprox.
    orientation: {
        axis: "both",
        item: "top",
    },

                        };
                            var content = document.getElementById('activity_timeline');
                            timeline = new vis.Timeline(content, null, options);
                            timeline.setGroups(groups);
                            timeline.setItems(items);
                } 
             });
            
            });
    </script>
    <script>
        $(document).ready(function() {
          $.fn.modal.Constructor.prototype.enforceFocus = function() {};
        })
    </script>
    <script type="text/javascript">
         google.charts.load('current', {'packages':['timeline']});
         google.charts.setOnLoadCallback(drawChart);

    function drawChart(){

        var url = "{{ route('activity.liste') }}";
              $.ajax({
                  url: url,
                 type: 'GET',
                 dataType: 'json',
                  error:function(data){
        
    },
                   success: function (donnee) {
        console.log(donnee);
        var data = new google.visualization.DataTable(donnee);
        var container = document.getElementById('timeline');
        var chart = new google.visualization.Timeline(container);
                chart.draw(data);

    }
              });

    }
           
    
    //   google.charts.load('current', {'packages':['timeline']});
    //   google.charts.setOnLoadCallback(drawChart);
    //   function drawChart() {
    //     var container = document.getElementById('timeline');
    //     var chart = new google.visualization.Timeline(container);
    //     var dataTable = new google.visualization.DataTable();
    
    //     dataTable.addColumn({ type: 'string', id: 'President' });
    //     dataTable.addColumn({ type: 'date', id: 'Start' });
    //     dataTable.addColumn({ type: 'date', id: 'End' });
    //     dataTable.addRows([
    //       [ 'Washington', new Date(1789, 3, 30), new Date(1797, 2, 4) ],
    //       [ 'Adams',      new Date(1797, 2, 4),  new Date(1801, 2, 4) ],
    //       [ 'Jefferson',  new Date(1801, 2, 4),  new Date(1809, 2, 4) ]]);
    
    //     chart.draw(dataTable);
    //   }
    </script>


<script type="text/javascript">
    $(document).ready(function() {
     $("input[id^='upload_file']").each(function() {
         var id = parseInt(this.id.replace("upload_file", ""));
         $("#upload_file" + id).change(function() {
             if ($("#upload_file" + id).val() != "") {
                 $("#moreImageUploadLink").show();
             }
         });
     });
 });
 </script>
 <script>
     $(document).ready(function() {
     var upload_number = 2;
     $('#attachMore').click(function() {
     //alert('oko');
         //add more file
         var moreUploadTag = '';
         moreUploadTag += '<div class="element"><label for="upload_file"' + upload_number + '>Joindre une image '  + '</label>';
         moreUploadTag += '<input type="file" accept=" .jpeg, .png, .JPG"  id="upload_file' + upload_number + '" name="image' + upload_number + '"/>';
         moreUploadTag += ' <a href="javascript:del_file(' + upload_number + ')" style="cursor:pointer;" onclick="return confirm("Are you really want to delete ?")">Supprimer ' + '</a></div>';
         $('<dl id="delete_file' + upload_number + '">' + moreUploadTag + '</dl>').fadeIn('slow').appendTo('#moreImageUpload');
     $('#champ_nombre_dimage').val(upload_number)
     upload_number++;
    
     });
 });
 function del_file(eleId) {
     var ele = document.getElementById("delete_file" + eleId);
     ele.parentNode.removeChild(ele);
 }
 </script>



<script>
      $("#depassement_de_subvention").hide();
    ('.avis_ugp').hide();
  
    function activerbtn(id_btn,id_champ){
        //alert('ok');
        var contenu_du_champ= $('#'+id_champ).val();
        
         if(contenu_du_champ==""){
           $('.'+id_btn).prop('disabled',true)
     }
        else{
          
         $('.'+id_btn).prop('disabled', false)
     }
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
        <script>
            function delConfirm (id){
            $(function(){
                document.getElementById("entreprise_id").setAttribute("value", id);
            });

        }
            function confirmChangeStatus(id){
            $(function(){
                document.getElementById("id_table").setAttribute("value", id);
            });

        }
            function changeValue(parent, child, niveau)
              {
                  var idparent_val = $("#"+parent).val();
                  var id_param = parseInt(niveau);
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
<script>

function initMap()
{
    var map = L.map('map').setView([12.375118, -1.522078], 7);
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 13,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: 'pk.eyJ1Ijoic3RlcGhzYW4iLCJhIjoiY2wxeGo1N2xuMDNiMDNkbXFudW8xazNrZiJ9.fHt7ZUxVTOdt_pAc-ps6dg'
    }).addTo(map);
    var url = "{{ route('souscriptiongeopresenation') }}";
    $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            error:function(data){alert("Erreur");},
            success: function (data) {
                for(item of data){
                    marker= L.marker([item.longitude, item.latitude]).addTo(map);
                    marker.bindPopup("<b>"+item.denomination+"!</b><br>"+item.denomination).openPopup();
                }

            }
    });
}
</script>
<script>
    function affilier_un_beneficiaire_ala_banque(){
        var selec=[];
        var banque = $("#banque").val();
        $('#listebeneficiaire :input:checkbox:checked').each(function(){
        selec.push($(this).val());
    });
    //alert(selec);
        var url = "{{ route('banque.storeaffiliation') }}";
    $.ajax({
        url: url,
        type:'GET',
        data: {banque: banque, beneficiaires: selec } ,
        error:function(){alert('error');},
        success:function(){
            location.reload();
            $('#listebeneficiaire').find('input').attr('checked', false);
        }
    });
    }
    </script>
    <script>
    function desaffilier_un_beneficiaire_ala_banque(){
        var deselec=[];
        var banque = $("#banque").val();
        $('#decocherbeneficiaire :input:checkbox:checked').each(function(){
        deselec.push($(this).val());
    });
        var url = "{{ route('banque.supprimeraffiliation') }}";
    $.ajax({
        url: url,
        type:'GET',
        data: {banque: banque, beneficiaires: deselec } ,
        error:function(){alert('error');},
        success:function(){
            location.reload();
            $('#decocherbeneficiaire').find('input').attr('checked', false);
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
        location.reload();
        $('#listecandidat').find('input').attr('checked', false);
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
        $('#decochercandidat').find('input').attr('checked', false);
        location.reload();
    }
});
}
</script>
<script>
   function localiser(id){
        var geoSuccess = function(position) { // Ceci s'exécutera si l'utilisateur accepte la géolocalisation
        startPos = position;
        var pos=[];
        var lat = startPos.coords.latitude;
        var lon = startPos.coords.longitude;
        var url = "{{ route('localisation.entreprise') }}";
    $.ajax({
        url: url,
        type:'GET',
        data: {longitude: lon, latitude: lat, id:id} ,
        error:function(){alert('error');},
        success:function(){
            location.reload();
        }
    });
    };
    var geoFail = function(){ // Ceci s'exécutera si l'utilisateur refuse la géolocalisation
        console.log("refus");
    };
    // La ligne ci-dessous cherche la position de l'utilisateur et déclenchera la demande d'accord
    navigator.geolocation.getCurrentPosition(geoSuccess,geoFail);
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
    function filtredata(){
        var region = $("#region").val();
        var secteur_activite = $("#secteur_activite").val();
        var maillon = $("#maillon").val();
        var type_entreprise = $("#type_entreprise").val();
        var url = "{{ route('filtrerdata') }}";
        $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    data: {region: region, secteur_activite: secteur_activite, maillon:maillon, type_entreprise:type_entreprise } ,
                    error:function(data){alert("Erreur");},
                    success: function (data) {
                        $('#datatable').dataTable().fnClearTable();
                        $('#datatable').dataTable().fnDestroy();
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
        


//fin total 
		dom: 'Bfrtip',
		initComplete: function () {
            var api = this.api();
 
            // For each column
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

{{-- Fonction Pour controler la date de paiement des factures --}}
<script>
      $(document).ready(function(){
    var date_validate= $('#facture_date_de_validation').val();
    var startd= new Date(date_validate);
    $('.datepaiement_facture').datepicker({
            autoclose: true,
            startDate: startd,
            endDate: new Date(),
});
//Bloquer la saisie de la date
$(".datepaiement_facture").keydown(false);

$('.input_banque').datepicker({
    endDate: new Date(),
});


});
function verifier_montant(montant_champ, devi_id,  facture_id ){
   
        var montant= $("#"+montant_champ).val();
        var devi_id= $("#"+devi_id).val();
        var facture_id= $("#"+facture_id).val();
       var mode_paiement= $('#mode_de_paiement').val();
       // alert(mode_paiement);
//Verifier si le montant de la demande de paiment est supérieur à 2 million le paiement mobile n'est pas possible
    if(mode_paiement=='paiement_mobile' && (montant > 2000000)){
            alert('Cette demande de paiement sera rejetée le car les paiements mobiles ne doivent pas exceder 2 million ')
        }
       if(montant > 2000000){
          $('#mode_de_paiement option[value="paiement_mobile"]').attr('disabled', true);;
        }
        else{
          $('#mode_de_paiement option[value="paiement_mobile"]').attr('disabled', false);;
        }
       
        var url = "{{ route('verifier_montant') }}";
        $.ajax({
                 url: url,
                  type: 'GET',
                  data: {montant: montant, devi_id:devi_id, facture_id:facture_id},
                  dataType: 'json',
                  error:function(data){alert("Erreur");},
                  success: function (data) {
                 
                   if(data==1){
                          $(".depassement_du_montant_du_devis").show();
                            $(".soumettre_facture").prop('disabled', true);
                            $("#"+montant_champ).val("");
                          format_montant(montant_champ);
                   }
                   else{
                        $(".depassement_du_montant_du_devis").hide();
                          $(".soumettre_facture").prop('disabled', false);
                          format_montant(montant_champ);
                   }
                  }
                  });

  }
    
</script>





    </body>
</html>
