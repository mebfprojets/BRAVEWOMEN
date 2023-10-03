@extends("layouts.espace_beneficiaire")
@section('content_space')
<div class="block">
    <div class="block-title">
        <h2><i class="fa fa-file-o"></i> <strong>Soummetre une nouveau devis</strong></h2>
        <a href="{{ route('devi.create') }}"data-toggle="tooltip" title=" Soumettre un nouveau devis" class="btn btn-success pull-right"><span><i class="fa fa-plus"></i></span> Devis</a>
    </div>
<div class="row">
    <div class="col-md-11">
        <div class="block">
            <!-- Form Validation Example Title -->
            {{-- <div class="block-title">
                <h2><strong>Ajouter un nouvel</strong> Role</h2>
            </div> --}}
            <form id="form-validation" method="POST"  action="{{route('devi.store')}}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('fiche_analyse') ? ' has-error' : '' }}">
                        <label class="control-label col-md-4" for="listedepresence">Fiche d'analyse <span class="text-danger">*</span></label>
                        <div class="input-group col-md-6">
                            <input class="form-control col-md-6" type="file" name="fiche_analyse" id="fiche_analyse" accept=".pdf, .jpeg, .png"   placeholder="Charger une copie de fiche d'analyse des offres">
                            <span class="input-group-addon"><i class="gi gi-user"></i></span>
                        </div>
                        @if ($errors->has('fiche_analyse'))
                            <span class="help-block">
                                <strong>{{ $errors->first('fiche_analyse') }}</strong>
                            </span>
                            @endif
                    </div>
                    <div class="form-group{{ $errors->has('fiche_analyse') ? ' has-error' : '' }}">
                        <label class="control-label col-md-4" for="listedepresence">Fiche d'analyse <span class="text-danger">*</span></label>
                        <div class="input-group col-md-6">
                            <input class="form-control col-md-6" type="file" name="fiche_analyse" id="fiche_analyse" accept=".pdf, .jpeg, .png"   placeholder="Charger une copie de fiche d'analyse des offres">
                            <span class="input-group-addon"><i class="gi gi-user"></i></span>
                        </div>
                        @if ($errors->has('fiche_analyse'))
                            <span class="help-block">
                                <strong>{{ $errors->first('fiche_analyse') }}</strong>
                            </span>
                            @endif
                    </div>
                    <fieldset>
                        <legend>Prestataire designé</legend>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label" for="name">Nom du prestataires<span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    
                                        <select id="name" class="select-select2" type="text" class="form-control" name="nom_prestataire" value="{{ old('nom') }}" required autofocus>
                                        
                                </div>
                                @if ($errors->has('nom_prestataire'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nom_prestataire') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('fiche_analyse') ? ' has-error' : '' }}">
                            <label class="control-label col-md-4" for="listedepresence">Joindre le devis <span class="text-danger">*</span></label>
                            <div class="input-group col-md-6">
                                <input class="form-control col-md-6" type="file" name="copie_devis" id="copie_devis" accept=".pdf, .jpeg, .png"   placeholder="Charger une copie de fiche d'analyse des offres">
                                <span class="input-group-addon"><i class="gi gi-user"></i></span>
                            </div>
                            @if ($errors->has('copie_devis'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('copie_devis') }}</strong>
                                </span>
                                @endif
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label" for="name">Montant du devis<span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <div class="input-group">
                                        <input id="name" type="number" class="form-control" name="montant_devis" value="{{ old('montant_devis') }}" required autofocus>
                                        <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                </div>
                                @if ($errors->has('montant_devis'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('montant_devis') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label" for="name">Avance demandé<span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <div class="input-group">
                                        <input id="name" type="number" class="form-control" name="no" value="{{ old('montant_avance') }}" required autofocus>
                                        <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                </div>
                                @if ($errors->has('montant_avance'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('montant_avance') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </fieldset>
                    
                    <fieldset>
                        <legend>Autre devis</legend>
                        <div class="form-group{{ $errors->has('fiche_analyse') ? ' has-error' : '' }}">
                            <label class="control-label col-md-4" for="listedepresence">Joindre le devis 1 <span class="text-danger">*</span></label>
                            <div class="input-group col-md-6">
                                <input class="form-control col-md-6" type="file" name="copie_devis1" id="copie_devis1" accept=".pdf, .jpeg, .png"   placeholder="Charger une copie de fiche d'analyse des offres">
                                <span class="input-group-addon"><i class="gi gi-user"></i></span>
                            </div>
                            @if ($errors->has('copie_devis1'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('copie_devis1') }}</strong>
                                </span>
                                @endif
                        </div>
                        <div class="form-group{{ $errors->has('fiche_analyse') ? ' has-error' : '' }}">
                            <label class="control-label col-md-4" for="listedepresence">Joindre le devis 2 <span class="text-danger">*</span></label>
                            <div class="input-group col-md-6">
                                <input class="form-control col-md-6" type="file" name="copie_devis2" id="copie_devis2" accept=".pdf, .jpeg, .png"   placeholder="Charger une copie de fiche d'analyse des offres">
                                <span class="input-group-addon"><i class="gi gi-user"></i></span>
                            </div>
                            @if ($errors->has('copie_devis2'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('copie_devis2') }}</strong>
                                </span>
                                @endif
                        </div>
                    </fieldset>
                    
                <div class="form-group form-actions">
                <div class="col-md-8 col-md-offset-4">
                    <button type="submit" class="btn btn-sm btn-sucess"><i class="fa fa-arrow-right"></i> Soumetter</button>
                    <a href="{{ route('profil.mesdevis') }}" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
                </div>
            </div>
            </form>
        </div>
    </div>
   
</div>
    
</div>
@endsection