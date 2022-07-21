@extends("layouts.dashboard")
@section('dashboard', 'active')
@section('dashboardgeo', 'active')
@section('content')
<div class="row text-center">
    <div class="col-sm-6 col-lg-3">
        <a href="javascript:void(0)" onclick="initMap();"  class="widget widget-hover-effect2">
            <div class="widget-extra themed-background">
                <h4 class="widget-content-light"><strong>Souscriptions</strong> Enregistrées Formation</h4>
            </div>
            <div class="widget-extra-full"><span class="h2 animation-expandOpen">{{ $totalenregistres }}</span></div>
        </a>
    </div>
    <div class="col-sm-6 col-lg-3">
        <a href="javascript:void(0)" onclick="dashboardparsecteuractivite();" class="widget widget-hover-effect2">
            <div class="widget-extra themed-background-dark">
                <h4 class="widget-content-light"><strong>Souscriptions</strong> Retenues Formation</h4>
            </div>
            <div class="widget-extra-full"><span class="h2 themed-color-dark animation-expandOpen">{{ $decisions_retenu }}</span></div>
        </a>
    </div>
    <div class="col-sm-6 col-lg-3">
        <a href="javascript:void(0)" class="widget widget-hover-effect2">
            <div class="widget-extra themed-background">
                <h4 class="widget-content-light"><strong></strong>Souscriptions</strong>AOP/leader Enregistées</h4>
            </div>
            <div class="widget-extra-full"><span class="h2 themed-color-dark animation-expandOpen">{{ $entreprisesLeaderAOP }}</span></div>
        </a>
    </div>
    <div class="col-sm-6 col-lg-3">
        <a href="javascript:void(0)" class="widget widget-hover-effect2">
            <div class="widget-extra themed-background-dark">
                <h4 class="widget-content-light"><strong>Souscriptions</strong> Retenu Subvention</h4>
            </div>
            <div class="widget-extra-full"><span class="h2 themed-color-dark animation-expandOpen">$ 4.250</span></div>
        </a>
    </div>
</div>
<div id="map"> </div>

@endsection

</script>
