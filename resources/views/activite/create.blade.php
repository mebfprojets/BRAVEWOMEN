@extends("layouts.admin")
@section('administration', 'active')
@section('administration-parametre', 'active')
@section('blank')
    <li>Accueil</li>
    <li>Activites</li>
    <li><a href="">liste</a></li>
@endsection
    @section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <!-- Form Validation Example Block -->
                <div class="block">
                    <!-- Form Validation Example Title -->
                    <div class="block-title">
                        <h2><strong>Ajouter une nouvelle</strong> Activité</h2>
                    </div>
                    <form id="form-validation" method="POST"  action="{{route('activites.store')}}" class="form-horizontal form-bordered">
                            {{ csrf_field() }}
                      
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} row">
                                <label class="col-md-4 control-label" for="name">Libellé de l'activité<span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                            <input id="name" type="text" class="form-control" name="libelle_activite" value="{{ old('libelle_activite') }}" required autofocus>
                                            <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                    </div>
                                    @if ($errors->has('libelle_activite'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('libelle_activite') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        <div class="row" style="margin-left:15px;">
                            <div class="form-group col-md-6" >
                                <label class=" control-label" for="val_username">Date de debut : </label>
                                    <div class="input-group">
                                        <input type="text" id="" name="date_de_debut" class="form-control datepicker" data-date-format="dd-mm-yyyy" placeholder="Date de debut de l'activité .." value="{{old('date_de_debut')}}" >
                                    </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class=" control-label" for="val_username">Date de fin : </label>
                                    <div class="input-group">
                                        <input type="text" id="" name="date_de_fin" class="form-control datepicker" data-date-format="dd-mm-yyyy" placeholder="Date de fin de l'activité .." value="{{old('date_de_fin')}}" >
                                    </div>
                            </div>
                        </div>
                        <div class="row" style="margin-left:15px;">
                            <div class="form-group col-md-6">
                                <label class=" control-label" for="val_username">Taux de réalisation : </label>
                                    <div class="input-group">
                                        <input type="number" id="" max="100" min="0" name="taux_de_realisation" class="form-control"  placeholder="Taux de réalisation de l'activité .." value="{{old('taux_de_realisation')}}" >
                                    </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label" for="region">Activité liée à : <span class="text-danger">*</span></label>
                                    <select id="activite_principale" name="activite_principale" class="select-select2" data-placeholder="Choisir l'activité principale .." value="{{old("activite_principale")}}" style="width:100%;">
                                        <option></option>
                                        @foreach ($activites as $activite )
                                            <option value="{{ $activite->id  }}" {{ old('activite_principale') == $activite->id ? 'selected' : '' }}>{{ $activite->libelle }}</option>
                                        @endforeach
                                    </select>
                            </div>
                        </div>
                        <div class="form-group form-actions">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn btn-sm btn-sucess"><i class="fa fa-arrow-right"></i> Valider</button>
                            <a href="{{ route('activites.index') }}" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
