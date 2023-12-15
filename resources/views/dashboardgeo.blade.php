@extends("layouts.dashboard")
@section('dashboard', 'active')
@section('dashboardgeo', 'active')
@section('content')
<div id="map"> 


</div>

<div class="col-md-12 col-md-offset-1 block full" style="margin-left: 10px;">
    <!-- Your Plan Widget -->
    
          <!-- Tags Title -->
          <div class="block-title">
              <div class="block-options pull-right">
                  <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="Add Tag"><i class="fa fa-plus"></i></a>
              </div>
              <h2> <i class="fa fa-tags"></i> Indicateur de  <strong>preformance</strong></h2>
          </div>
          <!-- END Tags Title -->

          <!-- Tags Content -->

          <div class="row">
        <div class="col-md-10">
            <ul class="nav nav-pills nav-stacked">
                <li>
                    <a href="javascript:void(0)" onclick="allsouscription('mpme');">
                        <span class="badge pull-right">{{ $total_mpme_enregistre }}</span>
                        <i class="fa fa-tag fa-fw text-success"></i> <strong>Nombre de souscription MPME</strong>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" onclick="entreprise_aformer_geo('mpme',0);">
                        <span class="badge pull-right">{{ $total_mpme_aformer }}</span>
                        <i class="fa fa-tag fa-fw text-warning"></i> <strong>Nombre de MPME selectionnées pour la  formation</strong>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" onclick="entreprise_aformer_geo('mpme',1);">
                        <span class="badge pull-right">{{ $total_mpme_formes }}</span>
                        <i class="fa fa-tag fa-fw text-warning"></i> <strong>Nombre de MPME formées</strong>
                    </a>
                </li>
                <li>
                  <a href="javascript:void(0)" onclick="allsouscription('aop');">
                      <span class="badge pull-right">{{ $entreprisesLeaderAOP }}</span>
                      <i class="fa fa-tag fa-fw text-warning"></i> <strong>Nombre de souscriptions Leader/AOP </strong>
                  </a>
              </li>
                <li>
                    <a href="javascript:void(0)" onclick="entreprise_aformer_geo('aop', 0);">
                        <span class="badge pull-right">{{ $nb_entreprisesAOP_aformer }}</span>
                        <i class="fa fa-tag fa-fw text-danger"></i> <strong>Nombre de Leader/AOP selectionnées pour la  formation</strong>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" onclick="entreprise_aformer_geo('aop',1);">
                        <span class="badge pull-right">{{ $total_aop_leader_formes }}</span>
                        <i class="fa fa-tag fa-fw text-danger"></i> <strong>Nombre de AOP/Entreprises Leader formées</strong>
                    </a>
                </li>
            </ul>
            
        </div>
    </div>
    <hr>
   
</div>
@section("additional_script")
<script>
   const markerIcon = L.icon({
    iconSize: [25, 41],
    iconAnchor: [10, 41],
    popupAnchor: [2, -40],
    iconUrl: "https://unpkg.com/leaflet@1.5.1/dist/images/marker-icon.png",
    shadowUrl: "https://unpkg.com/leaflet@1.5.1/dist/images/marker-shadow.png"
});
    var map = L.map('map').setView([12.35, -1.516667], 8,       {
        draggable: true, // Make the icon dragable
        title: "Hover Text", // Add a title
        opacity: 0.5,
        icon: markerIcon // here assign the markerIcon var
});
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}',{
                     // Il est toujours bien de laisser le lien vers la source des données
                     attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                     id: 'mapbox/streets-v11',
                     accessToken: 'pk.eyJ1Ijoic3RlcGhzYW4iLCJhIjoiY2wxeGo1N2xuMDNiMDNkbXFudW8xazNrZiJ9.fHt7ZUxVTOdt_pAc-ps6dg',
                    minZoom: 1,
                    maxZoom: 20
                }).addTo(map);
           
</script>
<script>
    function allsouscription(type_entreprise)
    { 
        var custumIcon= L.icon({
            iconUrl:'./img/femme.png',
            iconSize:[30,30]
        });
        var markers = L.markerClusterGroup();
        var url = "{{ route('geopresenation_beneficiaire_par_type_entreprise') }}";
        $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                data:{type_entreprise:type_entreprise },
                error:function(data){alert("Erreur");},
                success: function (data) {
                    for(var i=0; i<data.length; i++)
                        {
                            if(data[i].longitude){
                                marker= L.marker([data[i].longitude, data[i].latitude],{
                                    icon:custumIcon,
                                    title:data[i].denomination
                            });
                                marker.bindPopup("<b>"+'Denomination :'+data[i].denomination+"!</b><br>"+'Zone :'+data[i].region).openPopup();
                                markers.addLayer(marker);
                            } 
                        }
                        map.addLayer(markers);
                }
        });
    }
    function entreprise_aformer_geo(type_entreprise, valeur_de_forme)
    { 
        var markers = L.markerClusterGroup();
        (type_entreprise=="mpme")?(categorie_entreprise="Les MPME"):(categorie_entreprise="Les Entreprises leaders et les AOP");
        (valeur_de_forme==1)?(former="ayant suivis la formation"):(former="Selectionnées pour la formation ");
        var markers = L.markerClusterGroup();
        var url = "{{ route('entreprise_forme') }}";
        $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                data:{type_entreprise:type_entreprise, valeur_de_forme:valeur_de_forme },
                error:function(data){alert("Erreur");},
                success: function (data) {
                    console.log(data)
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
    function dashboardaopenregistre_geo(type_entreprise, statut)
    { 
        var markers = L.markerClusterGroup();
        (type_entreprise=='mpme')?(type="des MPME"):(type="des AOP");
        var url = "{{ route('souscriptionretenueparsecteuractivite') }}";
        var markers = L.markerClusterGroup();
        var url = "{{ route('souscriptiongeopresenation') }}";
        $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                data:{type_entreprise:type_entreprise, statut:statut},
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
@endsection







@endsection


