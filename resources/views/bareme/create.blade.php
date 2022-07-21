@extends("layouts.admin")
@section('administration', 'active')
@section('administration-parametre', 'active')
@section('content')
    @section('blank')
    <li>Accueil</li>
    <li>Barame</li>
    <li><a href="">Nouveau</a></li>
@endsection
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <!-- Form Validation Example Block -->
                <div class="block">
                    <!-- Form Validation Example Title -->
                    <div class="block-title">
                        <h2><strong>Ajouter un nouveau</strong> barème</h2>
                    </div>
                    <form id="form-validation" method="POST"  action="{{route('baremes.store')}}" class="form-horizontal form-bordered">
                            {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('critere') ? ' has-error' : '' }}">
                             <label class="col-md-4 control-label">Critère<span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <select name="critere" id="for" class="form-control">
                                    <option></option>
                                        @foreach ( $criteres as $critere)
                                            <option value="{{ $critere->id }}">{{ $critere->libelle }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('critere') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label" for="val_inf">Valeur Inferieure<span class="text-danger">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                                <input id="name" type="number" class="form-control" name="val_inf" value="{{ old('val_inf') }}" required autofocus>
                                            <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                        </div>
                                        @if ($errors->has('val_inf'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('val_inf') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                            </div>
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label" for="val_sup">Valeur supérieure<span class="text-danger">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                                <input id="name" type="number" class="form-control" name="val_sup" value="{{ old('val_sup') }}" required autofocus>
                                            <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                        </div>
                                        @if ($errors->has('val_sup'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('val_sup') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label" for="note">Note<span class="text-danger">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                                <input id="name" type="number" class="form-control" name="note" value="{{ old('note') }}" required autofocus>
                                            <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                        </div>
                                        @if ($errors->has('note'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('note') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                        <div class="form-group form-actions">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-arrow-right"></i> Valider</button>
                            <a href="{{ route('permissions.index') }}" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
