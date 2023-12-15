@extends('layouts.admin')
@section('administration', 'active')
@section('administration-parametre', 'active')
@section('content')
<div class="col-md-12">
    <div class="block">
        <!-- Basic Form Elements Title -->
        <div class="block-title">
            <div class="block-options pull-right">
                <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default toggle-bordered enable-tooltip" data-toggle="button" title="Toggles .form-bordered class">No Borders</a>
            </div>
            <h2><strong>Detail</strong> dela pièce jointe</h2>
        </div>
        <div class="table-responsive">
                    <div class="col-lg-4">
                            <!-- Nom document -->
                            <div class="form-group row">
                              <div class="col-sm-4">
                                <label>Type de pièce:</label>
                              </div>
                              <div class="col-sm-8 mb-3 mb-sm-0">
                                <label class="fb"> {{ getlibelle($piecejointe->type_piece) }}</label>
                              </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-4">
                                  <label>Créer le:</label>
                                </div>
                                <div class="col-sm-8 mb-3 mb-sm-0">
                                  <label class="fb"> {{ $piecejointe->created_at }} </label>
                                </div>
                        </div>
                            <div class="form-group row">
                              <div class="col-sm-4">
                                <label>Dernière modif.:</label>
                              </div>
                              <div class="col-sm-8 mb-3 mb-sm-0">
                                <label class="fb"> {{ $piecejointe->updated_at }} </label>
                              </div>

                            </div>

                            <hr>

                            <div class="form-group">
                            <a onclick="window.history.back();" class="btn btn-sm btn-success"><i class="fa fa-repeat"></i> Fermer</a>
                            
                            </div>
                    </div>
                    <div class="col-lg-8 img-bg" style="cursor: pointer;">
                        <div style="box-shadow: 1px 2px 5px 1px #999">
                          <embed src= "{{ Storage::disk('local')->url($piecejointe->url) }}" height=600 type='application/pdf' style="width: 100%;" />
                        </div>
                    </div>
        </div>
                </div>
</div>
@endsection
