@extends('layouts.admin')
@section('administration', 'active')
@section('administration-banque', 'active')
@section('content')
<div class="col-md-10">
        <!-- Basic Form Elements Title -->

                <!-- Form Validation Example Block -->
                <div class="block">
                    <!-- Form Validation Example Title -->
                    <div class="block-title">
                        <h2> Modifier une <strong>Banque partenaire</strong></h2>
                    </div>
                    <form id="form-validation" method="POST"  action="{{route('banque.update', $banque)}}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="libelle">Nom<span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                            <input id="name" type="text" class="form-control" name="nom" value="{{ old('banque')?? $banque->nom }}" required autofocus>
                                            <span class="input-group-addon"><i class="gi gi-"></i></span>
                                    </div>
                                    @if ($errors->has('nom'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nom') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="libelle">Telephone<span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                            <input id="name" type="text" class="form-control" name="telephone" value="{{ old('telephone')?? $banque->telephone }}" required autofocus>
                                            <span class="input-group-addon"><i class="gi gi-"></i></span>
                                    </div>
                                    @if ($errors->has('telephone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('telephone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                        <div class="form-group form-actions">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-sm btn-sucess"><i class="fa fa-arrow-right"></i>Modifier</button>
                                <a href="{{ route('banque.index') }}" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
                            </div>
                    </div>
                    </form>
    

</div>
            </div>
 </div>

@endsection
