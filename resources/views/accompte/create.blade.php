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
                        <h2> Enregistrement <strong>d'un accompte de {{ $entreprise->promotrice->code_promoteur }}</strong></h2>
                    </div>
                    <form id="form-validation" method="POST"  action="{{route('accompte.store')}}" class="form-horizontal form-bordered"  enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="entreprise_id" value="{{ $entreprise->id }}">
                            <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="montant">Montant : <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                           <input id="name" type="number" min=0 class="form-control" name="montant" value="{{ old('montant') }}" required autofocus>
                                            <span class="input-group-addon"><i class="gi gi-money"></i></span>
                                    </div>
                                    @if ($errors->has('montant'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('montant') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="date">Date de versement<span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                            <input id="name" type="date" class="form-control input-datepicker" name="date" value="{{ old('date') }}" required autofocus>
                                            <span class="input-group-addon"><i class="gi gi-"></i></span>
                                    </div>
                                    @if ($errors->has('date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('date') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="copie_du_recu">Joindre le reçu de versement<span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input class="form-control col-md-6" type="file" name="copie_du_recu" id="copie_du_recu" accept=".pdf, .jpeg, .png"   placeholder="Joindre une copie du reçu de versement">
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
                            <a onclick='history.back()' class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
@endsection
