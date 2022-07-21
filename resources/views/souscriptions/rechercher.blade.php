@extends("layouts.admin")
@section('dashboard', 'active')
@section('sousmenu', 'active')
@section('content')

<div class="row">
    <div class="col-md-10 col-md-offset-1" >
        <div  class="block full">
            <div class="block-title">
                <div class="block-options pull-right"> 
                </div>
                <h2><strong>Recherche</strong> Avancée</h2>
            </div>
            <form action=""></form>
            <div class="row">
                <div class="form-group col-md-6" >
                    <label class="col-md-4 control-label" for="type">Type d'entreprise<span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <select id="type_entreprise" name="type_entreprise" class="select-select2" data-placeholder="Type d'entreprise" style="width: 100%;" onchange="filtredata();" >
                            <option></option>
                            <option value="all">TOUT</option>
                            <option value="null">MPME</option>
                            <option value="aop">AOP</option>
                            <option value="leader">Leader</option>
                        </select>
                        @if ($errors->has('type_entreprise'))
                        <span class="help-block">
                            <strong>{{ $errors->first('type_entreprise') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group col-md-6" >
                    <label class="col-md-4 control-label" for="type">Région<span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <select id="region" name="region" class="select-select2" data-placeholder="Choisir la région" style="width: 100%;"  onchange="filtredata();" >
                            <option></option>
                            <option value="all">Tout</option>
                            @foreach ($regions as $region )
                                <option value="{{$region->id  }}" {{ old('region') == $region->id ? 'selected' : '' }} value="{{ $region->id }}">{{ $region->libelle }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('region'))
                        <span class="help-block">
                            <strong>{{ $errors->first('region') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group col-md-6" >
                    <label class="col-md-4 control-label" for="type">Secteur d'activité<span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <select id="secteur_activite" name="secteur_activite" class="select-select2" data-placeholder="Choisir le type de systeme de suivi" style="width: 100%;" onchange="filtredata();" >
                            <option></option>
                            <option value="all">Tout</option>
                             @foreach ($secteur_activites as $secteur_activite )
                                <option value="{{$secteur_activite->id  }}" {{ old('secteur_activite') == $secteur_activite->id ? 'selected' : '' }} value="{{ $secteur_activite->id }}">{{ $secteur_activite->libelle }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('secteur_activite'))
                        <span class="help-block">
                            <strong>{{ $errors->first('secteur_activite') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group col-md-6" >
                    <label class="col-md-4 control-label" for="type">Maillon d'activité<span class="text-danger">*</span></label>
                    <div class="col-md-6"> 
                        <select id="maillon" name="maillon_activite" class="select-select2" data-placeholder="Choisir le type de systeme de suivi" style="width: 100%;" onchange="filtredata();" >
                            <option></option>
                            <option value="all">Tout</option>
                            @foreach ($maillon_activites as $maillon_activite )
                                <option value="{{$maillon_activite->id  }}" {{ old('maillon_activite') == $maillon_activite->id ? 'selected' : '' }} value="{{ $maillon_activite->id }}">{{ $maillon_activite->libelle }}</option>
                            @endforeach 
                        </select>
                        @if ($errors->has('maillon_activite'))
                        <span class="help-block">
                            <strong>{{ $errors->first('maillon_activite') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
            </div>
    </div>
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
