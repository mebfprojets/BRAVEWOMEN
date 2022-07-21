@extends('layouts.admin')
@section('administration', 'active')
@section('administration-valeur', 'active')
@section('content')
    <div class="col-md-10">
        <div class="block">
            <!-- Basic Form Elements Title -->
            <div class="block-title">
                <div class="block-options pull-right">
                    <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default toggle-bordered enable-tooltip" data-toggle="button" title="Toggles .form-bordered class">No Borders</a>
                </div>
                <h2><strong>Creation</strong> de valeur</h2>
            </div>
            <!-- END Form Elements Title -->

            <!-- Basic Form Elements Content -->
            <form action="{{ route('valeurs.store') }}" method="POST" class="form-horizontal form-bordered">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('parametre') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label" for="typeorga">Parametre : </label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <select  class="form-control" id="parent" name="parametre"  >
                                <option></option>

                                @foreach($parametres as $parametre)
                                                                <option value="{{ $parametre->id }}">{{ $parametre->libelle }}</option>
                                                                @endforeach

                            </select>     </div>
                        @if ($errors->has('parent'))
                        <span class="help-block">
                            <strong>{{ $errors->first('parent') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('parent') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label" for="typeorga">valeur parent : </label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <select  class="form-control" id="parent" name="parent"  >
                                <option></option>

                                @foreach($valeurs as $valeur)
                                                                <option value="{{ $valeur->id }}">{{ $valeur->libelle }}</option>
                                                                @endforeach

                            </select>     </div>
                        @if ($errors->has('parent'))
                        <span class="help-block">
                            <strong>{{ $errors->first('parent') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('libele') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label" for="libele">Libellé : <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <div class="input-group">
                                <input id="libele" type="text" class="form-control" name="libelle" value="{{ old('libele') }}" required>

                        </div>
                        @if ($errors->has('libele'))
                        <span class="help-block">
                            <strong>{{ $errors->first('libele') }}</strong>
                        </span>
                        @endif
                    </div>
            </div>
            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                <label class="col-md-4 control-label" for="description">Description : <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    <div class="input-group">
                            <textarea id="description" name="description" placehorder="description" class="form-control">{{old('description')}}</textarea>
                            </div>
                    @if ($errors->has('description'))
                    <span class="help-block">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
                <div class="form-group form-actions">
                    <div class="col-md-9 col-md-offset-3">
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Enregistrers</button>
                        <a href="{{ route('valeurs.index') }}" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i>Annuler</a>
                    </div>
                </div>
            </form>
            <!-- END Basic Form Elements Content -->
        </div>
    </div>
@endsection
