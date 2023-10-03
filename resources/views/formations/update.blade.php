@extends('layouts.admin')
@section('formation', 'active')
@section('formation-sessions', 'active')
@section('content')
<div class="col-md-10">
        <!-- Basic Form Elements Title -->

                <!-- Form Validation Example Block -->
                <div class="block">
                    <!-- Form Validation Example Title -->
                    <div class="block-title">
                        <h2> Modifier une <strong>Session de Formation</strong></h2>
                    </div>
                    <form id="form-validation" method="POST"  action="{{route('formation.update', $formation)}}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="libelle">Libellé de la formation<span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                            <input id="name" type="text" class="form-control" name="libelle" value="{{ old('libelle')?? $formation->libelle }}" required autofocus>
                                            <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                    </div>
                                    @if ($errors->has('libelle'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('libelle') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="type">Type de la formation<span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <select id="type_formation" name="type_formation" class="select-select2" data-placeholder="Choisir le type de systeme de suivi" style="width: 100%;"  >
                                        <option></option>
                                        @foreach ($type_formations as $type_formation )
                                            <option value="{{$type_formation->id  }}" {{ old('type_formation') == $type_formation->id ? 'selected' : '' }} value="{{ $type_formation->id }}"
                                                @if($type_formation->id == $formation->type)
                                                        selected
                                                @endif>
                                                {{ $type_formation->libelle }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('type_formation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('type_formation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4" for="date_debut">Date debut<span class="text-danger">*</span></label>
                                    <div class="input-group col-md-6">
                                        <input type="text" id="date_debut" name="date_debut" value="{{old('date_debut')?? $formation->date_debut}}" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="Entrer la date de debut.." required="Ce champ est obligatoire">
                                        <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                    </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4" for="date_fin">Date de Fin<span class="text-danger">*</span></label>
                                    <div class="input-group col-md-6">
                                        <input type="text" id="date_fin" name="date_fin" value="{{old('date_fin')?? $formation->date_fin}}" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="Entrer la date de fin.." required="Ce champ est obligatoire">
                                        <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                    </div>
                            </div>
                            <div class="form-group{{ $errors->has('listedepresence') ? ' has-error' : '' }}">
                                <label class="control-label col-md-4" for="listedepresence">Joindre la liste de présence <span class="text-danger">*</span></label>
                                <div class="input-group col-md-6">
                                    <input class="form-control col-md-6" type="file" name="listedepresence" id="listedepresence" accept=".pdf, .jpeg, .png"   placeholder="Charger une copie de la liste de présence">
                                    <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                </div>
                                @if ($errors->has('listedepresence'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('listedepresence') }}</strong>
                                    </span>
                                    @endif
                            </div>
                        <div class="form-group form-actions">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-sm btn-sucess"><i class="fa fa-arrow-right"></i>Modifier</button>
                                <a href="{{ route('formation.index') }}" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
                            </div>
                    </div>
                    </form>

            </div>
 </div>

@endsection
