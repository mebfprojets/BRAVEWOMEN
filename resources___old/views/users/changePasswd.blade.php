@extends('layouts.log')
@section('entete')
    <small>SVP <strong>Changez votre mot de passe</strong></small>
@endsection 
@section('content')
    <form id="form-validation"  class="form-horizontal form-bordered form-control-borderless" method="POST" action="/chgpasswd">  
        {{csrf_field()}}
        <br>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="val_username">Mot de Passe <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="password" id="password" name="password" class="form-control" placeholder="Mot de passe" required title="Entrez le mot de passe">
                            <span class="input-group-addon" id="View"><i class="gi gi-eye_close" id="icone"></i></span>
                        </div>
                    </div>
                </div>
                    <div class="form-group">
                        <label for="password-confirm" class="col-md-4 control-label">Confirmer le mot de Passe <span class="text-danger">*</span></label>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input id="val_confirm_password" type="password" class="form-control" name="password_confirmation"  placeholder="Retaper le mot de passe" required title="Confirmer le mot de passse">
                                <span class="input-group-addon" id="VView"><i class="gi gi-eye_close" id="Vicone"></i></span>
                            </div>
                        </div>
                    </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                <input  class="btn btn-success" type="submit" value="Valider">
                </div>
            </div>
    </form>
@endsection
