@extends("layouts.admin")
@section('administration', 'active')
@section('administration-parametre', 'active')
@section('blank')
    <li>Accueil</li>
    <li>Document</li>
    <li><a href="">Création</a></li>
@endsection
    @section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-md-offset-1">
                <!-- Form Validation Example Block -->
                <div class="block">
                    <!-- Form Validation Example Title -->
                    <div class="block-title">
                        <h2><strong>Ajouter un nouveau </strong>document</h2>
                    </div>
                    <form id="form-validation" method="POST"  action="{{route('document.store')}}" class="form-horizontal form-bordered">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('parametre') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="typeorga">Catégorie : </label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <select  class="form-control" id="parent" name="categorie"  >
                                            <option></option>
            
                                            @foreach($categories as $categorie)
                                                                            <option value="{{ $categorie->id }}">{{ $categorie->libelle }}</option>
                                                                            @endforeach
            
                                        </select>     </div>
                                    @if ($errors->has('parent'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('parent') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="name">Titre du document<span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                            <input id="name" type="text" class="form-control" name="titre" value="{{ old('titre') }}" required autofocus>
                                            <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                    </div>
                                    @if ($errors->has('nom'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('titre') }}</strong>
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
                            <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="document">Joindre le document<span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input class="form-control col-md-6" type="file" name="document" id="document" accept=".pdf, .jpeg, .png"   placeholder="Joindre une copie du reçu de versement">
                                            <span class="input-group-addon"><i class="gi gi-files"></i></span>
                                    </div>
                                    @if ($errors->has('date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('date') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                        <div class="form-group form-actions">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn btn-sm btn-sucess"><i class="fa fa-arrow-right"></i> Valider</button>
                            <a href="{{ route('document.index') }}" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
