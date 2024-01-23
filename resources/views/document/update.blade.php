@extends("layouts.admin")
@section('administration', 'active')
@section('administration-parametre', 'active')
    @section('blank')
        <li>Accueil</li>
        <li>Document</li>
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
                        <h2><strong>Modifier le </strong>Role</h2>
                    </div>
                    <form id="form-validation" method="POST"  action="{{route('role.update', $role)}}" class="form-horizontal form-bordered">

                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label" for="nom">Libellé du role<span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                            <input id="name" type="text" class="form-control" name="nom" value="{{ $role->nom }}" required autofocus>
                                            <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                    </div>
                                    @if ($errors->has('nom'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nom') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"> Role Système <span class="text-success">*</span></label>
                            <div class="col-md-9">
                                <div class="input-group">
                                        <input type="checkbox"  class="form-control" name="typeRole" value="1"
                                        @if($role->typerole == 1)
                                        checked
                                         @endif>
                                </div>
                            </div>
                        </div>

                            <div class="row col-lg-offset-1">
                                <div class="col-lg-4">
                                    <label>Permissions Système</label>
                                    @foreach ($permissions as $permission )
                                        @if($permission->for== 'systeme')
                                                <label><input type="checkbox" name=permissions[] value="{{ $permission->id }}"
                                                    @foreach ($role->permissions as $role_permit)
                                                            @if ($role_permit->id==$permission->id)
                                                                  checked
                                                            @endif
                                                        @endforeach
                                                        > {{ $permission->name }}</label>
                                                    @endif
                                                @endforeach
                                </div>
                                <div class="col-lg-4">
                                        <label>Permissions Dossier</label>
                                        @foreach ($permissions as $permission )
                                            @if($permission->for== 'dossier')
                                                    <label><input type="checkbox" name=permissions[] value="{{ $permission->id }}"
                                                        @foreach ($role->permissions as $role_permit)
                                                            @if ($role_permit->id==$permission->id)
                                                                  checked
                                                            @endif
                                                        @endforeach
                                                        > {{ $permission->name }}</label>
                                            @endif
                                        @endforeach
                                </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                                <label>Permissions Administration</label>
                                                @foreach ($permissions as $permission )
                                                    @if($permission->for== 'administration')
                                                            <label><input type="checkbox" name=permissions[] value="{{ $permission->id }}"
                                                                @foreach ($role->permissions as $role_permit)
                                                                    @if ($role_permit->id==$permission->id)
                                                                      checked
                                                                    @endif
                                                                @endforeach

                                                                > {{ $permission->name }}</label>
                                                    @endif
                                                @endforeach
                                </div>
                            </div>

                        <div class="form-group form-actions">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-arrow-right"></i> Valider</button>
                            <a href="{{ route('role.index') }}" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
