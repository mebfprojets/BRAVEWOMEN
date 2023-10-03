@extends('layouts.admin')
@section('finacement', 'active')
@section('suivi_devis', 'active')
@section('content')
<div class="col-md-12">
        <!-- Basic Form Elements Title -->

                <!-- Form Validation Example Block -->
                <div class="block">
                    <!-- Form Validation Example Title -->
                    <div class="block-title">
                        <h2> Historique <strong>suivis de l'exécution du Devis</strong></h2>
                    @if($devis->taux_de_realisation<100)
                        <a href="#modal-add-suividevis" data-toggle="modal" class="btn btn-success pull-right"><span><i class="fa fa-plus"></i></span>Suivi</a>        
                    @endif
                    </div>
 <div class="table-responsive">
    <table  class="table table-vcenter table-condensed table-bordered listepdf">
        <thead>
                <tr>
                    <th>N</th>
                    <th>Numero devis</th>
                    <th>Date visite</th>
                    <th>Taux de réalisation</th>
                    <th>Observation</th>
                    <th>Actions</th>
                </tr>
        </thead>
        <tbody>
            @php
            $i=0;
         @endphp
            @foreach($suivi_devis as $suivi_devi)
            @php
            $i++;
            @endphp
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{$devis->numero_devis}}</td>
                    <td>{{format_date($suivi_devi->date_visite)}}</td>
                    <td>{{$suivi_devi->taux_de_realisation}} %</td>
                    <td>{{getlibelle($suivi_devi->observation_type)}}</td>
                    <td class="text-center">
                            <div class="btn-group">
                            <a href="{{ route('visualiser_detail_suivi',$suivi_devi)}}"title="Visualiser" class="btn btn-md btn-default"  target="_blank"><i class="fa fa-eye"></i> </a>
                            @can('update_suivi_execution_devis', Auth::user())
                                <a href="{{ route('edit_de_suivi',$suivi_devi)}}"title="Modifier" class="btn btn-md btn-sucess" ><i class="fa fa-pencil"></i> </a>
                            @endcan
                            </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
        </table>
    </div>
    </div>
<a href="{{ route('devis.listerASuivre') }}" class="btn btn-danger pull-right" style="float: right;"><span><i class="fa fa-times"></i></span> Fermer la page</a>

    </div>
@endsection

<div id="modal-add-suividevis"  class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Ajouter un suivi de réalisation</h2>
            </div>
            <!-- END Modal Header -->

            <!-- Modal Body -->
            <div class="modal-body">
                    <input type="hidden" name="id_table" id="id_table">
                        <form id="form-validation" method="POST"  action="{{route('suivreDevis.store')}}" class="form-horizontal form-bordered"  enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" id="devis_id" name="devis_id" value="{{ $devis->id }}">
                            <div class="row">
                                
                            </div>
                            <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }} col-md-6">
                                <label class="control-label" for="telephone">Date de visite :<span class="text-danger">*</span></label>
                                            <input id="name" type="text" class="form-control datepicker" data-date-format="dd-mm-yyyy" name="date_visite" value="{{ old('date_visite') }}" required autofocus>
                                   
                                    @if ($errors->has('date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('date') }}</strong>
                                    </span>
                                    @endif
                                
                            </div>
                           
                            <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }} col-md-6">
                                <label class=" control-label" for="taux_de_realisation">Taux de réalisation (Compris entre 0 et 100): <span class="text-danger">*</span></label>
                                    <input id="taux_de_realisation" max="100" min="0" type="number" class="form-control" name="taux_de_realisation" placeholder="Le taux de realisation"   required autofocus>
                                    @if ($errors->has('taux_de_realisation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('taux_de_realisation') }}</strong>
                                    </span>
                                    @endif
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-md-5" style="margin-left:10px;">
                                    <label class=" control-label" for="">Observation type <span data-toggle="tooltip" title="Le motif de rejet du devis"></label>
                                    <select id="motif_du_rejet" name="motif_de_rejet[]" class="select-select2" data-placeholder="Selectionner l'observation" style="width: 80%" required>
                                        @foreach ($observation_types as $observation_type)
                                            <option></option>
                                            <option value="{{ $observation_type->id }}">{{ $observation_type->libelle }}</option>
                                        @endforeach
                                    </select>
                                </div> 
                                <div class="form-group{{ $errors->has('fiche_analyse') ? ' has-error' : '' }} col-md-6" style="margin-left:15px;" >
                                    <label class="control-label" for="observation">Observations <span class="text-danger">*</span></label>
                                    <textarea name="observation" id="" cols="50" rows="4" required></textarea>
                                    @if ($errors->has('observation'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('observation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                
                               
                                
                            </div>
                        <div class="row"  style="margin:20px 5px">
                            {{-- <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }} row" >
                                <label class=" control-label" for="rapport_de_suivi">Joindre le rapport : <span class="text-success">*</span></label>
                                <input class="form-control" type="file" name="rapport_de_suivi" id="image_visite" accept=".pdf, .jpeg, .png"   placeholder="Joindre le rapport de suivi">
                                    @if ($errors->has('rapport_de_suivi'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('rapport_de_suivi') }}</strong>
                                    </span>
                                    @endif
                            </div> --}}
                            <div class="element row" style="margin:20px 0px">
                                <label>Joindre les images de la visite</label>
                                <input type="file" name="image1" id="upload_file1" accept=".pdf, .jpeg, .png, .JPG"  />
                            </div>

                            <div id="moreImageUpload"></div>
                            <div class="clear"></div>
                            <div id="moreImageUploadLink" style="display:none;margin-left: 10px;">
                                <a href="javascript:void(0);" id="attachMore">Ajouter d'autres images</a>
                            </div>
                        <input type="hidden" id="champ_nombre_dimage" name="champ_nombre_dimage"> 
                            
                        </div>
                        <div class="form-group form-actions">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-sm btn-sucess valider"><i class="fa fa-arrow-right"></i> Valider</button>
                        </div>
                    </div>
                    </form>
                    

            </div>
            <!-- END Modal Body -->
        </div>
    </div>
</div>
<div id="modal-update-suividevis"  class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Modifier un suivi de réalisation</h2>
            </div>
            <div class="modal-body">
                    <input type="hidden" name="id_table" id="id_table">
                        <form id="form-validation" method="POST"  action="{{route('suivi_devis.modifier')}}" class="form-horizontal form-bordered"  enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" id="devis_id_update" name="devis_id" >
                            <div class="row">
                                
                            </div>
                            <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }} col-md-6">
                                <label class="control-label" for="telephone">Date de visite :<span class="text-danger">*</span></label>
                                            <input id="date_visite_u" type="text" class="form-control datepicker" data-date-format="dd-mm-yyyy" name="date_visite"  required autofocus>
                                   
                                    @if ($errors->has('date_visite'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('date_visite') }}</strong>
                                    </span>
                                    @endif
                            </div>
                            <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }} col-md-6">
                                <label class=" control-label" for="taux_de_realisation">Taux de réalisation : <span class="text-danger">*</span></label>
                                    <input id="taux_de_realisation_u" type="text" class="form-control" name="taux_de_realisation" placeholder="Le taux de realisation"   required autofocus>
                                    @if ($errors->has('taux_de_realisation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('taux_de_realisation') }}</strong>
                                    </span>
                                    @endif
                            </div>
                        <div class="row">
                            <div class="form-group col-md-5" style="margin-left:10px;">
                                <label class=" control-label" for="">Observation type <span data-toggle="tooltip" title="Selectionner une observation sur la réalisation"></label>
                                <select id="motif_du_rejet" name="observation_type" class="select-select2" data-placeholder="Selectionner une observation sur la réalisation" style="width: 80%"  required>
                                    @foreach ($observation_types as $observation_type)
                                        <option></option>
                                        <option value="{{ $observation_type->id }}">{{ $observation_type->libelle }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group{{ $errors->has('fiche_analyse') ? ' has-error' : '' }} col-md-5" style="margin-left:15px;" >
                                <label class="control-label" for="observation">Observations <span class="text-danger">*</span></label>
                                <textarea name="observation" id="observation_u" cols="40" rows="4" required></textarea>
                                @if ($errors->has('observation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('observation') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }} col-md-6">
                                <label class="control-label" for="telephone">Joindre les images de la visite :<span class="text-danger">*</span></label>
                                <input class="form-control" type="file" name="image_visite" id="image_visite" accept=".pdf, .jpeg, .png"   placeholder="Joindre une copie du reçu de versement" >
                                @if ($errors->has('image_visite'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('image_visite') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group form-actions">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-sm btn-sucess valider"><i class="fa fa-arrow-right"></i> Valider</button>

                        </div>
                    </div>
                    </form>
                    
                    

            </div>
            <!-- END Modal Body -->
        </div>
    </div>
</div>
@section('script_additionnel')
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


