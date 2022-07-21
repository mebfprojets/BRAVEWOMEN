@extends("layouts.admin")
@section('administration', 'active')
@section('administration-parametre', 'active')
@section('blank')
    <li>Accueil</li>
    <li>Utilisateurs</li>
    <li><a href="">Modifier</a></li>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <!-- Form Validation Example Block -->
            <div class="block">
                <!-- Form Validation Example Title -->
                <div class="block-title">
                    <h2><strong>Modifier</strong> Utilisateur</h2>
                </div>
                <!-- END Form Validation Example Title -->

                <!-- Form Validation Example Content -->
                <form id="form-validation" method="POST"  action="{{route('user.update', $user)}}" class="form-horizontal form-bordered">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                    <fieldset>
                        <legend><i class="fa fa-angle-right"></i>Informations personnelles</legend>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label" for="val_username">Nom<span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <div class="input-group">
                                        <input id="name" type="text" class="form-control" name="nom" value="{{ $user->name}}" required autofocus>
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
                                            <input id="name" type="text" class="form-control" name="prenom" value="{{ $user->prenom}}" required autofocus>
                                        <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                    </div>
                                    @if ($errors->has('prenom'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('prenom') }}</strong>
                                    </span>
                                    @endif
                                </div>
                        </div>


                        <div class="form-group{{ $errors->has('telephone') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="telephone">Telephone<span class="text-success">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                            <input id="masked_phone" type="text" class="form-control" name="telephone" value="{{ $user->telephone}}" required autofocus>
                                        <span class="input-group-addon"><i class="gi gi-earphone"></i></span>
                                    </div>
                                    @if ($errors->has('telephone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('telephone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                         </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label" for="val_email">Email <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                    <div class="input-group">
                                            <input id="val_email" name="email" type="text" class="form-control" name="email" value="{{ $user->email}}" required autofocus placeholder="test@example.com">
                                        <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                                    </div>
                                    @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                            </div>
                        </div>
                       <div class="form-group{{ $errors->has('organisation') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="organisation">Zone<span class="text-success">*</span></label>
                                <div class="col-md-6">
                                        <div class=" col-md-12 input-group ">
                                            <select  id="organisation" name="organisation" class="form-control">
                                                    <option value="00100">Coordination</option>
                                                    @foreach ($zones as $zone)
                                                        <option value="{!!old('organisation') ?? $zone->id!!}"
                                                                @if ($user->zone==$zone->id)
                                                                            selected
                                                                @endif>{{ $zone->libelle}}
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
                        <div class="form-group">
                            <label class="col-md-4 control-label"> Membre de comité technique<span class="text-success">*</span></label>
                        <div class="col-md-8">
                            <div class="input-group">
                                    <input type="checkbox"  class="form-control" id="membre_comite" name="membre_comite" value="1" id="membre_comite" onclick="afficherSicheck()"
                                    @if($user->structure_represente!="")
                                        checked
                                    @endif>
                            </div>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('structure_rep') ? ' has-error' : '' }} structure_rep" id="structure_rep">
                        <label class="col-md-4 control-label" for="structure_rep">Réprésentant : </label>
                        <div class="col-md-6">
                                <div class=" col-md-12 input-group ">
                                    <select  id="" name="structure_rep" class="form-control" placeholder="Selectionner">
                                        <option></option>
                                            @foreach ($strucure_representees as $strucure_representee)
                                                <option value="{!!old('structure_rep') ?? $strucure_representee->id!!}" @if($user->structure_represente== $strucure_representee->id)
                                                    selected
                                                @endif>{{ $strucure_representee->libelle}}</option>
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
                    </fieldset>
                    {{-- <div class="form-group">
                            <label class="col-sm-4">Activer</label>
                            <label class="switch switch-primary col-sm-1"><input type="checkbox" name="status"
                            @if($user->status == 1)
                                checked
                                @endif
                            value="1"><span></span></label>
                    </div> --}}
                    <fieldset>
                            <legend><i class="fa fa-angle-right"></i> Roles</legend>

                            <div class="form-group">
                                @foreach ($roles as $role)
                                    <div class="col-lg-3">
                                       <label><input type="checkbox"name='roles[]' value="{{ $role->id }}"
                                                @foreach ($user->roles as $user_role )
                                                    @if ($user_role->id==$role->id)
                                                        checked
                                                    @endif
                                                @endforeach
                                        > {{ $role->nom }}</label>
                                    </div>
                                @endforeach
                            </div>
                    </fieldset>
                    <div class="form-group form-actions">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-arrow-right"></i> Modifier</button>
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
