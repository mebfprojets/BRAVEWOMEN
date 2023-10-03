@extends("layouts.admin")
@section('administration', 'active')
@section('administration-user', 'active')
@section('blank')
    <li>Accueil</li>
    <li>Utilisateurs</li>
    <li><a href="">Creer</a></li>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <!-- Form Validation Example Block -->
            <div class="block">
                <!-- Form Validation Example Title -->
                <div class="block-title">
                    <h2><strong>Ajouter un nouvel</strong> Utilisateur</h2>
                </div>
                <!-- END Form Validation Example Title -->

                <!-- Form Validation Example Content -->
                <form id="form-validation" method="POST"  action="{{route('user.store')}}" class="form-horizontal form-bordered">
                        {{ csrf_field() }}
                    <fieldset>
                        <legend><i class="fa fa-angle-right"></i> Informations personnelles</legend>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label" for="val_username">Nom<span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <div class="input-group">
                                        <input id="nome" type="text" class="form-control" name="nom" value="{{ old('nom') }}" required autofocus>
                                    <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                </div>
                                @if ($errors->has('nom'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nom') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('prename') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="prenom">Prenom <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                            <input id="prenom" type="text" class="form-control" name="prenom" value="{{ old('prenom') }}" required autofocus>
                                            <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                    </div>
                                    @if ($errors->has('prenom'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('prenom') }}</strong>
                                    </span>
                                    @endif
                                </div>
                        </div>
                         <div class="form-group{{ $errors->has('organisation') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="organisation">Zone </label>
                                <div class="col-md-6">
                                        <div class=" col-md-12 input-group ">
                                            <select  id="organisation" name="organisation" class="form-control">
                                            <option value="">Sélectionner une zone</option>
                                                <option value="00100">Coordination</option>
                                                    @foreach ($zones as $user_zone)
                                                        <option value="{!!old('organisation') ?? $user_zone->id!!}">{{ $user_zone->libelle}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                        </div>
                                            @if ($errors->has('organisation'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('organisation') }}</strong>
                                            </span>
                                            @endif

                                </div>
                            </div>
                        <div class="form-group membre_comite">
                                <label class="col-md-4 control-label"> Membre de comité technique<span class="text-success">*</span></label>
                            <div class="col-md-8">
                                <div class="input-group">
                                        <input type="checkbox"  class="form-control" id="membre_comite" name="membre_comite" value="1" id="membre_comite" onclick="afficherSiCheck('membre_comite','structure_rep')">
                                </div>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('structure_rep') ? ' has-error' : '' }} structure_rep" id="structure_rep"  style="display: none">
                            <label class="col-md-4 control-label" for="structure_rep">Réprésentant : </label>
                            <div class="col-md-6">
                                    <div class=" col-md-12 input-group ">
                                        <select  id="" name="structure_rep" class="form-control" placeholder="Selectionner">
                                            <option></option>
                                                @foreach ($strucure_representees as $strucure_representee)
                                                    <option value="{!!old('structure_rep') ?? $strucure_representee->id!!}">{{ $strucure_representee->libelle}}
                                                    </option>
                                                @endforeach
                                                </select>
                                    </div>
                                        @if ($errors->has('structure_rep'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('structure_rep') }}</strong>
                                        </span>
                                        @endif
                                 </div> 
                            </div>
                            <div class="form-group compte_banque">
                                <label class="col-md-4 control-label"> Compte banque<span class="text-success">*</span></label>
                            <div class="col-md-8">
                                <div class="input-group">
                                        <input type="checkbox"  class="form-control"  name="membre_comite" value="1" id="compte_banque" onclick="afficherSiCheck('compte_banque','banque')">
                                </div>
                            </div>
                        </div>
                            <div class="form-group{{ $errors->has('structure_rep') ? ' has-error' : '' }}" id="banque">
                                <label class="col-md-4 control-label" for="banque">Banque : </label>
                                <div class="col-md-6">
                                        <div class=" col-md-12 input-group ">
                                            <select  id="" name="banque" class="form-control" placeholder="Selectionner">
                                                <option></option>
                                                    @foreach ($banques as $banque)
                                                        <option value="{!!old('banque') ?? $banque->id!!}">{{ $banque->nom}}
                                                        </option>
                                                    @endforeach
                                                    </select>
                                        </div>
                                            @if ($errors->has('banque'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('banque') }}</strong>
                                            </span>
                                            @endif
                                     </div> 
                                </div>
                        <div class="form-group{{ $errors->has('telephone') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="masked_phone">Telephone<span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="text" id="masked_phone" name="telephone" class="form-control" value="{{ old('telephone') }}" placeholder="(+226) 99-99-99-99" required autofocus>
                                        <span class="input-group-addon"><i class="gi gi-earphone"></i></span>
                                    </div>
                                </div>
                                @if ($errors->has('telephone'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('telephone') }}</strong>
                                </span>
                                @endif
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label" for="email">Email <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                    <div class="input-group">
                                            <input id="email" name="email" type="text" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="test@example.com">
                                            <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                                    </div>
                                    @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                            </div>
                        </div>

                    </fieldset>
                    <fieldset>
                        <legend><i class="fa fa-angle-right"></i> Roles</legend>

                        <div class="form-group">
                            @foreach ($roles as $role)
                                <div class="col-lg-3 checkbox">
                                   <label><input type="checkbox" name='roles[]' value="{{ $role->id }}"> {{ $role->nom }}</label>
                                </div>
                            @endforeach
                        </div>

                    </fieldset>
                    <div class="form-group form-actions">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn btn-sm btn-sucess"><i class="fa fa-arrow-right"></i> Submit</button>
                            <a href="{{ route('user.index') }}" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
                        </div>
                    </div>

                </form>
                <!-- END Form Validation Example Content -->
            </div>
        </div>
    </div>
</div>
@endsection
