<div class="row text-center">
      <div class="col-sm-6 col-lg-2">
          <a href="{{ route("dashboard") }}" class="widget widget-hover-effect2">
              <div class="widget-extra themed-background">
                  <h4 class="widget-content-light"><strong>MPME</strong> Enregistrées</h4>
              </div>
              <div class="widget-extra-full"><span class="h2 animation-expandOpen">{{ $totalenregistres }}</span></div>
          </a>
      </div>
      <div class="col-sm-6 col-lg-2">
          <a href="javascript:void(0)" onclick="dashboardparsecteuractivite();" class="widget widget-hover-effect2">
              <div class="widget-extra themed-background-dark">
                  <h4 class="widget-content-light"><strong>MPME</strong> A Former</h4>
              </div>
              <div class="widget-extra-full"><span class="h2 themed-color-dark animation-expandOpen">{{ $decisions_retenu }}</span></div>
          </a>
      </div>
      <div class="col-sm-6 col-lg-2">
            <a href="{{ route("dashboard") }}" class="widget widget-hover-effect2">
                <div class="widget-extra themed-background">
                    <h4 class="widget-content-light"><strong>MPME</strong>Subventionné</h4>
                </div>
                <div class="widget-extra-full"><span class="h2 animation-expandOpen">{{ $totalenregistres }}</span></div>
            </a>
        </div>
      <div class="col-sm-6 col-lg-2">
          <a href="javascript:void(0)" onclick="dashboardaopenregistre();" class="widget widget-hover-effect2">
              <div class="widget-extra themed-background">
                  <h4 class="widget-content-light"><strong>AOP/leader</strong> Enregistrées</h4>
              </div>
              <div class="widget-extra-full"><span class="h2 themed-color-dark animation-expandOpen">{{ $entreprisesLeaderAOP }}</span></div>
          </a>
      </div>
      <div class="col-sm-6 col-lg-2">
          <a href="javascript:void(0)" onclick="dashboardaopenregistre();" class="widget widget-hover-effect2">
              <div class="widget-extra themed-background-dark">
                  <h4 class="widget-content-light"><strong>AOP/leader</strong> A Former</h4>
              </div>
              <div class="widget-extra-full"><span class="h2 themed-color-dark animation-expandOpen">{{ $entreprisesLeaderAOP }}</span></div>
          </a>
      </div>
      <div class="col-sm-6 col-lg-2">
            <a href="javascript:void(0)" onclick="dashboardaopenregistre();" class="widget widget-hover-effect2">
                <div class="widget-extra themed-background">
                    <h4 class="widget-content-light"><strong>AOP/leader</strong> Subventionées</h4>
                </div>
                <div class="widget-extra-full"><span class="h2 themed-color-dark animation-expandOpen">{{ $entreprisesLeaderAOP }}</span></div>
            </a>
        </div>
  </div>