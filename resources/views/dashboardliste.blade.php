@extends("layouts.dashboard")
@section('dashboard', 'active')
@section('sousmenu', 'active')
@section('content')
<div class="row text-center">
    <div class="col-sm-6 col-lg-3">
        <a href="javascript:void(0)" onclick="listedashbordlistdata('{{ route('listeallensouscription') }}?typeentreprise=mpme')" class="widget widget-hover-effect2">
            <div class="widget-extra themed-background">
                <h4 class="widget-content-light"><strong>Souscriptions</strong> Enregistrées Formation</h4>
            </div>
            <div class="widget-extra-full"><span class="h2 animation-expandOpen">{{ $totalenregistres }}</span></div>
        </a>
    </div>
    <div class="col-sm-6 col-lg-3">
        <a href="javascript:void(0)"  onclick="listedashbordlistdata('{{ route('entreprise_retenues') }}?typeentreprise=mpme');" class="widget widget-hover-effect2">
            <div class="widget-extra themed-background-dark">
                <h4 class="widget-content-light"><strong>Souscriptions</strong> Retenues Formation</h4>
            </div>
            <div class="widget-extra-full"><span class="h2 themed-color-dark animation-expandOpen">{{ $decisions_retenu }}</span></div>
        </a>
    </div>
    <div class="col-sm-6 col-lg-3">
        <a href="javascript:void(0)" onclick="listedashbordlistdata('{{ route('listeallensouscription') }}?typeentreprise=aop')" class="widget widget-hover-effect2">
            <div class="widget-extra themed-background">
                <h4 class="widget-content-light"><strong></strong>Souscriptions</strong>AOP/leader Enregistées</h4>
            </div>
            <div class="widget-extra-full"><span class="h2 themed-color-dark animation-expandOpen">{{ $entreprisesLeaderAOP }}</span></div>
        </a>
    </div>
    <div class="col-sm-6 col-lg-3">
        <a href="javascript:void(0)" onclick="listedashbordlistdata('{{ route('entreprise_retenues') }}?typeentreprise=aop')" class="widget widget-hover-effect2">
            <div class="widget-extra themed-background-dark">
                <h4 class="widget-content-light"><strong>AOP/Leader</strong> A former</h4>
            </div>
            <div class="widget-extra-full"><span class="h2 themed-color-dark animation-expandOpen">{{ $nbaopaformer }}</span></div>
        </a>
    </div>
</div>

<div class="block full">
    <div class="table-responsive">
        <table id="datatable" class="table table-vcenter table-condensed table-bordered listepdf">
        <thead>
            <tr>
                 <th class="text-center">N°</th>
                <th class="text-center">Zone</th>
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
                    <td class="text-center">{{ $entreprise->denomination }}</td>
                    {{-- <td class="text-center">{{ getlibelle($entreprise->nombre_annee_existence) }}</td> --}}
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
