@extends("layouts.admin")
@section('administration', 'active')
@section('administration-parametre', 'active')
@section('content')
    @section('blank')
    <li>Accueil</li>
    <li>Permissions</li>
    <li><a href="">Nouveau</a></li>
@endsection
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <!-- Form Validation Example Block -->
                <div class="block">
                    <!-- Form Validation Example Title -->
                    <div class="block-title">
                        <h2><strong>Ajouter un nouvel</strong> Permissions</h2>
                    </div>
                    <form id="form-validation" method="POST"  action="{{route('permissions.store')}}" class="form-horizontal form-bordered">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label" for="nom">libellé de la permission<span class="text-danger">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                                <input id="name" type="text" class="form-control" name="nom" value="{{ old('nom') }}" required autofocus>
                                            <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                        </div>
                                        @if ($errors->has('nom'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('nom') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('nom') ? ' has-error' : '' }}">
                                        <label class="col-md-6 control-label">Module<span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <select name="for" id="for" class="form-control">
                                        <option selected disabled>Selectionne permission Pour</option>
                                        <option value="dossier">Souscription</option>
                                        <option value="administration">Administration</option>
                                    </select>
                                </div>
                                </div>
                        <div class="form-group form-actions">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn btn-sm btn-sucess"><i class="fa fa-arrow-right"></i> Valider</button>
                            <a href="{{ route('permissions.index') }}" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
