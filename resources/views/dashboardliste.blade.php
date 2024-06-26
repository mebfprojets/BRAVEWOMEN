@extends("layouts.dashboard")
@section('dashboard', 'active')
@section('sousmenu', 'active')
@section('content')

<div class="row">
<div class="col-md-12 col-md-offset-1 block full" style="margin-left: 10px;">
    <!-- Your Plan Widget -->
    
          <!-- Tags Title -->
          <div class="block-title">
              <div class="block-options pull-right">
                  <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="Add Tag"><i class="fa fa-plus"></i></a>
              </div>
              <h2> <i class="fa fa-tags"></i> <strong> Situation détaillée</strong></h2>
          </div>
          <!-- END Tags Title -->

          <!-- Tags Content -->

          <div class="row">
        <div class="col-md-10">
            <ul class="nav nav-pills nav-stacked">
                <li>
                    <a href="javascript:void(0)" onclick="listedashbordlistdata('{{ route('listeallensouscription') }}?typeentreprise=mpme')">
                        <span class="badge pull-right">{{ $total_mpme_enregistre }}</span>
                        <i class="fa fa-tag fa-fw text-success"></i> <strong>Nombre de souscription MPME</strong>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)"  onclick="listedashbordlistdata('{{ route('entreprise_retenues') }}?typeentreprise=mpme&forme=0');">
                        <span class="badge pull-right">{{ $total_mpme_aformer }}</span>
                        <i class="fa fa-tag fa-fw text-success"></i> <strong>Nombre de MPME selectionnées pour la  formation</strong>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" onclick="listedashbordlistdata('{{ route('entreprise_retenues') }}?typeentreprise=mpme&forme=1');">
                        <span class="badge pull-right">{{ $total_mpme_formes }}</span>
                        <i class="fa fa-tag fa-fw text-success"></i> <strong>Nombre de MPME formées</strong>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" onclick="listedashbordlistdata('{{ route('entreprise_pca_status')}}?typeentreprise=mpme');">
                        <span class="badge pull-right">{{ count($mpme_ayant_soumis_pca) }}</span>
                        <i class="fa fa-tag fa-fw text-success"></i> <strong>Nombre de MPME ayant soumis un PCA</strong>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" onclick="listedashbordlistdata('{{ route('entreprise_pca_status')}}?typeentreprise=mpme&pca_selectionne=1');">
                        <span class="badge pull-right">{{ count($pme_ayant_pca_a_subventionner) }}</span>
                        <i class="fa fa-tag fa-fw text-success"></i> <strong>Nombre de MPME a subentionner</strong>
                    </a>
                </li>
                
                <li>
                  <a href="javascript:void(0)"  onclick="listedashbordlistdata('{{ route('listeallensouscription') }}?typeentreprise=aop')">
                      <span class="badge pull-right">{{ $entreprisesLeaderAOP }}</span>
                      <i class="fa fa-tag fa-fw text-warning"></i> <strong>Nombre de souscriptions Leader/AOP </strong>
                  </a>
              </li>
                <li>
                    <a href="javascript:void(0)"  onclick="listedashbordlistdata('{{ route('entreprise_retenues') }}?typeentreprise=aop&forme=0')" >
                        <span class="badge pull-right">{{ $nb_entreprisesAOP_aformer }}</span>
                        <i class="fa fa-tag fa-fw text-warning"></i> <strong>Nombre de Leader/AOP selectionnées pour la  formation</strong>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" onclick="listedashbordlistdata('{{ route('entreprise_retenues') }}?typeentreprise=aop&forme=1')">
                        <span class="badge pull-right">{{ $total_aop_leader_formes }}</span>
                        <i class="fa fa-tag fa-fw text-warning"></i> <strong>Nombre de AOP/Entreprises Leader formées</strong>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" onclick="listedashbordlistdata('{{ route('entreprise_pca_status') }}?typeentreprise=aop');">
                        <span class="badge pull-right">{{ count($aop_ayant_soumis_pca) }}</span>
                        <i class="fa fa-tag fa-fw text-warning"></i> <strong>Nombre de AOP/Entreprises Leader ayant bénéficié de PD</strong>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" onclick="listedashbordlistdata('{{ route('entreprise_pca_status') }}?typeentreprise=aop&pca_selectionne=1');">
                        <span class="badge pull-right">{{ count($aop_ayant_pca_a_subventionner) }}</span>
                        <i class="fa fa-tag fa-fw text-warning"></i> <strong>Nombre de AOP/Entreprises Leader a subventionner</strong>
                    </a>
                </li>
            </ul>
            
        </div>
    </div>
    <hr>
    
</div>

</div>
<div class="block full">
    <div class="table-responsive">
        <table id="datatable" class="table table-vcenter table-condensed table-bordered listepdf">
        <thead>
            <tr>
                 <th class="text-center">N°</th>
                <th class="text-center">Region</th>
                <th class="text-center">Province</th>
                <th class="text-center">Commune</th>
                <th class="text-center">Secteur</th>
                <th class="text-center">Code promoteur</th>
                <th class="text-center">Dénomination</th>
                <th class="text-center">Secteur d'activite</th>
                <th class="text-center">Maillon d'activite</th>
                {{-- <th class="text-center">Nombre</th> --}}
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody id="tbadys">
            @php
              $i=0;
            @endphp
            @foreach ($entreprises as $entreprise)
                    @php
                       $i++;
                    @endphp
                <tr>
                     <td class="text-center" style="width: 10%">{{ $i }}</td>
                    <td class="text-center">{{getlibelle($entreprise->region) }}</td>
                    <td class="text-center">{{getlibelle($entreprise->province) }}</td>
                    <td class="text-center">{{getlibelle($entreprise->commune) }}</td>
                    <td class="text-center">{{getlibelle($entreprise->arrondissement) }}</td>
                    <td class="text-center">{{$entreprise->code_promoteur }}</td>

                    <td class="text-center">{{ $entreprise->denomination }}</td>                 
                    <td class="text-center">{{ getlibelle($entreprise->secteur_activite) }}</td>
                    <td class="text-center">{{ getlibelle($entreprise->maillon_activite) }}</td>
                   <td class="text-center">
                            {{-- <a href="" data-toggle="tooltip" title="Editer" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a> --}}
                            <a href="{{ route("entreprise.show",$entreprise) }}" data-toggle="tooltip" title="Visualiser" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i></a>
                            {{-- <a href="" data-toggle="tooltip" title="Imprimer" class="btn btn-xs btn-default"><i class="fa fa-print"></i></a>
                            <a title="Valider" class="btn btn-xs btn-success"><i class="fa fa-check"></i></a> --}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
@endsection
