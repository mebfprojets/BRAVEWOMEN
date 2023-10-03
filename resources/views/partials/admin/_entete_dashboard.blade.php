
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
                        <a href="{{ route("dashboard") }}">
                            <span class="badge pull-right">{{ $total_mpme_enregistre }}</span>
                            <i class="fa fa-tag fa-fw text-success"></i> <strong>Nombre de souscription MPME</strong>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" onclick="entreprise_aformer('mpme',0);">
                            <span class="badge pull-right">{{ $total_mpme_aformer }}</span>
                            <i class="fa fa-tag fa-fw text-warning"></i> <strong>Nombre de MPME selectionnées pour la  formation</strong>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" onclick="entreprise_aformer('mpme',1);">
                            <span class="badge pull-right">{{ $total_mpme_formes }}</span>
                            <i class="fa fa-tag fa-fw text-warning"></i> <strong>Nombre de MPME formées</strong>
                        </a>
                    </li>
                    <li>
                      <a href="javascript:void(0)" onclick="dashboardaopenregistre('aop','nostatut');">
                          <span class="badge pull-right">{{ $entreprisesLeaderAOP }}</span>
                          <i class="fa fa-tag fa-fw text-warning"></i> <strong>Nombre de souscriptions Leader/AOP </strong>
                      </a>
                  </li>
                    <li>
                        <a href="javascript:void(0)" onclick="entreprise_aformer('aop', 0);">
                            <span class="badge pull-right">{{ $nb_entreprisesAOP_aformer }}</span>
                            <i class="fa fa-tag fa-fw text-danger"></i> <strong>Nombre de Leader/AOP selectionnées pour la  formation</strong>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" onclick="entreprise_aformer('aop',1);">
                            <span class="badge pull-right">{{ $total_aop_leader_formes }}</span>
                            <i class="fa fa-tag fa-fw text-danger"></i> <strong>Nombre de AOP/Entreprises Leader formées</strong>
                        </a>
                    </li>
                </ul>
                
            </div>

            
        </div>
        <hr>
        {{-- <div class="row">
            <div class="col-md-6">
                <ul class="nav nav-pills nav-stacked">
                    <li>
                        <a href="javascript:void(0)" onclick="entreprise_aformer('aop');">
                            <span class="badge pull-right">0</span>
                            <i class="fa fa-tag fa-fw text-success"></i> <strong>Montant total des subventions demandées </strong>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" onclick="entreprise_aformer('aop');">
                            <span class="badge pull-right">0</span>
                            <i class="fa fa-tag fa-fw text-success"></i> <strong>Montant total des subventions accordées </strong>
                        </a>
                    </li>              
                </ul>
    
            </div>    
            <div class="col-md-6">
                <ul class="nav nav-pills nav-stacked">
                    <li>
                        <a href="javascript:void(0)" onclick="entreprise_aformer('aop');">
                            <span class="badge pull-right">0</span>
                            <i class="fa fa-tag fa-fw text-success"></i> <strong>Montant total des subventions demandées </strong>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" onclick="entreprise_aformer('aop');">
                            <span class="badge pull-right">0</span>
                            <i class="fa fa-tag fa-fw text-success"></i> <strong>Montant total des subventions accordées </strong>
                        </a>
                    </li>
                    
                    
                </ul>
    
            </div>     
              <!-- END Tags Content -->
         </div>  --}}
  </div>

      {{-- <div class="col-sm-6 col-lg-3">
          <a href="{{ route("dashboard") }}" class="widget widget-hover-effect2">
              <div class="widget-extra themed-background">
                  <h4 class="widget-content-light"><strong>MPME</strong> Candidats</h4>
              </div>
              <div class="widget-extra-full"><span class="h2 animation-expandOpen">{{ $totalenregistres }}</span></div>
          </a>
      </div>
      <div class="col-sm-6 col-lg-2">
          <a href="javascript:void(0)" onclick="entreprise_aformer('mpme');" class="widget widget-hover-effect2">
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
          <a href="javascript:void(0)" onclick="entreprise_aformer('aop');" class="widget widget-hover-effect2">
              <div class="widget-extra themed-background-dark">
                  <h4 class="widget-content-light"><strong>AOP/leader</strong> A Former</h4>
              </div>
              <div class="widget-extra-full"><span class="h2 themed-color-dark animation-expandOpen">{{ $nb_entreprisesAOP_aformer }}</span></div>
          </a>
      </div>
      <div class="col-sm-6 col-lg-2">
            <a href="javascript:void(0)" onclick="dashboardaopenregistre();" class="widget widget-hover-effect2">
                <div class="widget-extra themed-background">
                    <h4 class="widget-content-light"><strong>AOP/leader</strong> Subventionnées</h4>
                </div>
                <div class="widget-extra-full"><span class="h2 themed-color-dark animation-expandOpen">{{ $entreprisesLeaderAOP }}</span></div>
            </a>
    </div> --}}
  