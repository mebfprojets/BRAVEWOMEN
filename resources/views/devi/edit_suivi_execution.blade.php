@extends('layouts.admin')
@section('finacement', 'active')
@section('suivi_devis', 'active')
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <!-- Form Validation Example Block -->
        <div class="block">
            <!-- Form Validation Example Title -->
            <div class="block-title">
                <h2><strong>Modifier les informations sur le suivi</strong></h2>
            </div>
            <!-- END Form Validation Example Title -->

            <!-- Form Validation Example Content -->
            <form id="form-validation" method="POST"  action="{{route('suivi_devis.modifier')}}" class="form-horizontal form-bordered"  enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" id="suivi_id" name="suivi" value="{{ $suiviExecutionDevi->id }}" >
                <div class="row">
                    
                </div>
                <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }} col-md-6">
                    <label class="control-label" for="telephone">Date de visite :<span class="text-danger">*</span></label>
                                <input id="date_visite_u" type="text" class="form-control datepicker" data-date-format="dd-mm-yyyy" name="date_visite" value="{{ format_date($suiviExecutionDevi->date_visite) }}"  required autofocus>
                       
                        @if ($errors->has('date_visite'))
                        <span class="help-block">
                            <strong>{{ $errors->first('date_visite') }}</strong>
                        </span>
                        @endif
                </div>
                <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }} col-md-6">
                    <label class=" control-label" for="taux_de_realisation">Taux de réalisation : <span class="text-danger">*</span></label>
                        <input id="taux_de_realisation_u" type="text" class="form-control" name="taux_de_realisation" placeholder="Le taux de realisation" value="{{ $suiviExecutionDevi->taux_de_realisation }}"  required autofocus>
                        @if ($errors->has('taux_de_realisation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('taux_de_realisation') }}</strong>
                        </span>
                        @endif
                </div>
            <div class="row">
                <div class="form-group col-md-5" style="margin-left:10px;">
                    <label class=" control-label" for="">Observation type <span data-toggle="tooltip" title="Faire une observation sur le suivi"></label>
                    <select id="motif_du_rejet" name="observation_type" class="select-select2" data-placeholder="Faire une observation sur le suivi" style="width: 80%"  required>
                        @foreach ($observation_types as $observation_type)
                        <option></option>
                        <option value="{{ $observation_type->id }}" 
                            @if($suiviExecutionDevi->observation_type==$observation_type->id)
                                 selected
                            @endif>{{ $observation_type->libelle }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group{{ $errors->has('fiche_analyse') ? ' has-error' : '' }} col-md-5" style="margin-left:15px;" >
                    <label class="control-label" for="observation">Observations <span class="text-danger">*</span></label>
                    <textarea name="observation" id="observation_u" cols="40" rows="4" value="" required>{{ $suiviExecutionDevi->observation}}</textarea>
                    @if ($errors->has('observation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('observation') }}</strong>
                        </span>
                    @endif
                </div>
                {{-- <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }} col-md-5" >
                    <label class=" control-label" for="rapport_de_suivi">Joindre un nouveau rapport : <span class="text-success">*</span></label>
                    <input class="form-control" type="file" name="rapport_de_suivi" id="image_visite" accept=".pdf, .jpeg, .png"   placeholder="Joindre le rapport de suivi">
                        @if ($errors->has('rapport_de_suivi'))
                        <span class="help-block">
                            <strong>{{ $errors->first('rapport_de_suivi') }}</strong>
                        </span>
                        @endif
                </div> --}}
                

             </div>
                

            <div class="form-group form-actions">
            <div class="col-md-8 col-md-offset-4">
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-sm btn-sucess valider"><i class="fa fa-arrow-right"></i> Valider</button>

            </div>
        </div>
        </form>
            <!-- END Form Validation Example Content -->
        </div>
    </div>
</div>
<div class="col-md-12">
        <!-- Basic Form Elements Title -->

                <!-- Form Validation Example Block -->
                <div class="block">
                    <!-- Form Validation Example Title -->
                    <div class="block-title">
                       <p style="text-align: center"> <h2> Visualiser <strong>les images du suivi</strong></h2></p> 
                    </div>
                        <a  href="#modal-add-images-biens" data-toggle="modal" style="margin-bottom:10px"> <i class="fa fa-plus"></i> Ajouter d'autres images</a>
                        <div class="row" style="margin-top:10px">
                            @foreach ($suiviExecutionDevi->images_de_suivis as $image_de_suivi )
                                <div class="col-md-4">  
                                    <a  href="#modal-modif-image" data-toggle="modal"  onclick="setid_image({{ $image_de_suivi->id }})"> <i class="fa fa-pencil"></i> Changer l'image</a>
                                    <img class="cadre_image" src= "{{ Storage::disk('local')->url($image_de_suivi->url_image) }}" alt="">
                                </div>
                            @endforeach
                        </div>
    </div>
<a href="{{ route('devis.listerASuivre') }}" class="btn btn-danger pull-right" style="float: right;"><span><i class="fa fa-times"></i></span> Fermer la page</a>

    </div>
@endsection
<div id="modal-add-images-biens" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-add"></i> Changer une autre image</h2>
            </div>
            <div class="modal-body">
                <form id="form-validation" method="POST"  action="{{route('image_suivi.store')}}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" id='' name="suivi_id" value="{{ $suiviExecutionDevi->id }}">
            <div class="row">
                <div class="form-group{{ $errors->has('piece_file') ? ' has-error' : '' }} col-md-10" style="margin-left:10px;">
                    <label  class="control-label col-md-4"  class="control-label" for="piece_file">Joindre la nouvelle piece jointe <span class="text-danger">*</span></label>
                    <div class="input-group col-md-6">
                        <input class="form-control docsize"  type="file" name="image_suivi" id="suivi_image" accept=".pdf, .jpeg, .png"   onchange="VerifyUploadSizeIsOK('suivi_image');" placeholder="Charger la nouvelle piece">
                        <span class="input-group-addon"><a href="#" class="empty_field" onclick="empty_input_file('suivi_image')">Vider le champ</a></span>
                    </div>
                    @if ($errors->has('piece_file'))
                        <span class="help-block">
                            <strong>{{ $errors->first('piece_file') }}</strong>
                        </span>
                    @endif
                </div>
            </div> 
           
                <div class="form-group form-actions">
                <div class="col-md-8 col-md-offset-4">
                    <button type="button" onclick="reload()" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-sm btn-success" ><i class="fa fa-arrow-right"></i> Valider</button>

                </div>
            </div>
            </form>
            </div>
        </div>   
        </div>
    </div>
<div id="modal-add-image" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Changer l'image de l'acquisition</h2>
            </div>
            <div class="modal-body">
                <form id="form-validation" method="POST"  action="{{route('image_suivi.modifier')}}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" id='image_id' name="image_id" value=''>
                   
            <div class="row">
                <div class="form-group{{ $errors->has('piece_file') ? ' has-error' : '' }} col-md-10" style="margin-left:10px;">
                    <label  class="control-label col-md-4"  class="control-label" for="piece_file">Joindre la nouvelle piece jointe <span class="text-danger">*</span></label>
                    <div class="input-group col-md-6">
                        <input class="form-control docsize"  type="file" name="image_bien" id="piece_file" accept=".jpg, .jpeg, .png"   onchange="VerifyUploadSizeIsOK('piece_file');" placeholder="Charger la nouvelle piece">
                        <span class="input-group-addon"><a href="#" class="empty_field" onclick="empty_input_file('piece_file')">Vider le champ</a></span>
                    </div>
                    @if ($errors->has('piece_file'))
                        <span class="help-block">
                            <strong>{{ $errors->first('piece_file') }}</strong>
                        </span>
                    @endif
                </div>
            </div> 
           
                <div class="form-group form-actions">
                <div class="col-md-8 col-md-offset-4">
                    <button type="button" onclick="reload()" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-sm btn-success" ><i class="fa fa-arrow-right"></i> Valider</button>

                </div>
            </div>
            </form>
            </div>
        </div>   
        </div>
    </div>
<div id="modal-modif-image" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Changer l'image de l'acquisition</h2>
            </div>
            <div class="modal-body">
                <form id="form-validation" method="POST"  action="{{route('image_suivi.modifier')}}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" id='image_id' name="image_id" value=''>
                   
            <div class="row">
                <div class="form-group{{ $errors->has('piece_file') ? ' has-error' : '' }} col-md-10" style="margin-left:10px;">
                    <label  class="control-label col-md-4"  class="control-label" for="piece_file">Joindre la nouvelle piece jointe <span class="text-danger">*</span></label>
                    <div class="input-group col-md-6">
                        <input class="form-control docsize"  type="file" name="image_bien" id="piece_file" accept=".jpg, .jpeg, .png"   onchange="VerifyUploadSizeIsOK('piece_file');" placeholder="Charger la nouvelle piece">
                        <span class="input-group-addon"><a href="#" class="empty_field" onclick="empty_input_file('piece_file')">Vider le champ</a></span>
                    </div>
                    @if ($errors->has('piece_file'))
                        <span class="help-block">
                            <strong>{{ $errors->first('piece_file') }}</strong>
                        </span>
                    @endif
                </div>
            </div> 
           
                <div class="form-group form-actions">
                <div class="col-md-8 col-md-offset-4">
                    <button type="button" onclick="reload()" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-sm btn-success" ><i class="fa fa-arrow-right"></i> Valider</button>

                </div>
            </div>
            </form>
            </div>
        </div>   
        </div>
    </div>


@section('script_additionnel')
<script>
    function setid_image(id){
        $('#image_id').val(id);
    }
</script>
    <script>
        function edit_suivi_devis(id){
                var id=id;
                var url = "{{ route('suivi_devis.modif') }}";
                $.ajax({
                    url: url,
                    type:'GET',
                    dataType:'json',
                    data: {id: id} ,
                    error:function(){alert('error');},
                    success:function(data){
                        $("#devis_id_update").val(data.id);
                        $("#date_visite_u").val(data.date_visite);
                        $("#taux_de_realisation_u").val(data.taux_de_realisation);
                        $("#observation_u").val(data.observation);
                         
                    }
                });
        }
    </script>
@endsection


