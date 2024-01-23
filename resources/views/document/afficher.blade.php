@extends('layouts.admin')
@section('documents', 'active')
@section('liste-document', 'active')
@section('content')
<div class="col-md-12">
    <div class="block">
        <!-- Basic Form Elements Title -->
        <div class="block-title">
            <div class="block-options pull-right">
                <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default toggle-bordered enable-tooltip" data-toggle="button" title="Toggles .form-bordered class">No Borders</a>
            </div>
            <h2><strong>Detail</strong>sur le document</h2>
        </div>
        <div class="table-responsive">
                    <div class="col-lg-4">
                            <!-- Nom document -->
                            <div class="form-group row">
                              <div class="col-sm-4">
                                <label>Categorie document:</label>
                              </div>
                              <div class="col-sm-8 mb-3 mb-sm-0">
                                <label class="fb"> {{ getlibelle($document->categorie) }}</label>
                              </div>
                            </div>
                            <div class="form-group row">
                              <div class="col-sm-4">
                                <label>Description:</label>
                              </div>
                              <div class="col-sm-8 mb-3 mb-sm-0">
                                <label class="fb"> {{ $document->description_doc }}</label>
                              </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-4">
                                  <label>Créer le:</label>
                                </div>
                                <div class="col-sm-8 mb-3 mb-sm-0">
                                  <label class="fb"> {{ $document->auteur->nom }} {{ $document->auteur->prenom }}</label>
                                </div>
                          </div>
                            <div class="form-group row">
                              <div class="col-sm-4">
                                <label>Zone de création .:</label>
                              </div>
                              <div class="col-sm-8 mb-3 mb-sm-0">
                                <label class="fb"> 
                                  @if ($document->auteur->zone =!100)
                                      {{ getlibelle($document->auteur->zone) }} 
                                  @else
                                    Coordination
                                  @endif </label>
                              </div>
                            </div>

                            <hr>

                            <div class="form-group">
                            <a onclick="window.history.back();" class="btn btn-sm btn-success"><i class="fa fa-repeat"></i> Fermer</a>
                            @can('document.update', Auth::user()) 
                             <a href="#modal-edit-document" data-toggle="modal" title="télécharger" class="btn btn-sm btn-warning" onclick="edit_document('{{ $document->id }}')"><i class="fa fa-pencil"></i> Modifier</a>
                            @endcan
                            </div>
                    </div>
                    <div class="col-lg-8 img-bg" style="cursor: pointer;">
                            <div style="box-shadow: 1px 2px 5px 1px #999">
                              @if($document->type_document!=7147)
                                <embed src= "{{ Storage::disk('local')->url($document->url_doc) }}" height=600 type='application/pdf' style="width: 100%;" />
                              @else
                              <iframe width="674" height="379" src="https://www.youtube.com/embed/QV2ua08jARE" title="spot" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                              @endif
                        </div>
                    </div>
          </div>
    </div>
</div>
@endsection
@section('modal_part')
<div id="modal-edit-document"  class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header text-center">
              <h2 class="modal-title"><i class="fa fa-pencil"></i> Modifier un document </h2>
          </div>
          <div class="modal-body">
                 
                  <form id="form-validation" method="POST"  action="{{ route("document.modifier") }}" class="form-horizontal form-bordered"  enctype="multipart/form-data">
                      {{ csrf_field() }}
                      <input type="hidden" name="id_doc" id="id_doc">
                      <div class="col-md-6 form-group{{ $errors->has('parametre') ? ' has-error' : '' }}">
                          <label class="col-md-4 control-label" for="typeorga">Catégorie : </label>
                          <div class="col-md-6">
                              <div class="input-group">
                                  <select  class="form-control" id="categorie" name="categorie"  >
                                      <option></option>
                                      @foreach($categories as $categorie)
                                          <option value="{{ $categorie->id }}">{{ $categorie->libelle }}</option>
                                      @endforeach
                                  </select>     
                              </div>
                              @if ($errors->has('parent'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('parent') }}</strong>
                              </span>
                              @endif
                          </div>
                      </div>
                      <div class=" col-md-6 form-group{{ $errors->has('parametre') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label" for="typeorga">Type de support : </label>
                        <div class="col-md-6">
                            <div class="input-group">
                                <select  class="select-select2" data-placeholder="Choisir le type de support" id="type_document" name="type_document" onchange="cacher_lien_video_ou_file_input()">
                                    <option></option>
                                    @foreach($type_supports as $type_support)
                                        <option value="{{ $type_support->id }}">{{ $type_support->libelle }}</option>
                                    @endforeach
                                </select> 
                                </div>
                            @if ($errors->has('parent'))
                            <span class="help-block">
                                <strong>{{ $errors->first('parent') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                      <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                          <label class="col-md-4 control-label" for="name">Titre du document<span class="text-danger">*</span></label>
                          <div class="col-md-6">
                              <div class="input-group">
                                      <input id="titre" type="text" class="form-control" name="titre" value="{{ old('titre') }}" required autofocus>
                                      <span class="input-group-addon"><i class="gi gi-user"></i></span>
                              </div>
                              @if ($errors->has('nom'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('titre') }}</strong>
                              </span>
                              @endif
                          </div>
                      </div>
                      <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                          <label class="col-md-4 control-label" for="description">Description : <span class="text-danger">*</span></label>
                          <div class="col-md-6">
                              <div class="input-group">
                                      <textarea id="description" name="description" placehorder="description" class="form-control" required>{{old('description')}}</textarea>
                                      </div>
                              @if ($errors->has('description'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('description') }}</strong>
                              </span>
                              @endif
                          </div>
                      </div>
                      <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}" id="doc_div">
                          <label class="col-md-4 control-label" for="document">Joindre le documents<span class="text-danger">*</span></label>
                          <div class="col-md-6">
                              <div class="input-group">
                                  <input class="form-control col-md-6" type="file" name="document" id="document" accept=".pdf, .jpeg, .png"   placeholder="Joindre une copie du reçu de versement">
                                      <span class="input-group-addon"><i class="gi gi-files"></i></span>
                              </div>
                              @if ($errors->has('date'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('date') }}</strong>
                              </span>
                              @endif
                          </div>
                      </div>
                      <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}" id="lien_video">
                        <label class="col-md-4 control-label" for="name">Lien de la vidéo<span class="text-danger">*</span></label>
                        <div class="col-md-6">
                            <div class="input-group">
                                    <input id="lien_video" type="text" class="form-control"  name="lien_video" value="{{ old('lien_video') }}" >
                                    <span class="input-group-addon"><i class="fa fa-link"></i></span>
                            </div>
                            @if ($errors->has('lien_video'))
                            <span class="help-block">
                                <strong>{{ $errors->first('lien_video') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                  <div class="form-group form-actions">
                  <div class="col-md-8 col-md-offset-4">
                      <a class="btn btn-sm btn-warning" data-dismiss="modal"><i class="fa fa-repeat"></i> Annuler</a>
                      <button type="submit" class="btn btn-sm btn-sucess"><i class="fa fa-arrow-right"></i> Valider</button>
                  </div>
              </div>
              </form>
                  

          </div>
          <!-- END Modal Body -->
      </div>
  </div>
</div>
@endsection
@section('script_additionnel')
<script>
  function edit_document(id){
                var url = "{{ route('document.modif') }}";
                $.ajax({
                    url: url,
                    type:'GET',
                    dataType:'json',
                    data: {id: id} ,
                    error:function(){alert('error');},
                    success:function(data){
                       $("#id_doc").val(data.id);
                        $("#titre").val(data.titre_doc);
                        $("#description").val(data.description);
                        $("#categorie").select2();
                        $("#categorie").val(data.categorie).trigger("change");
                        $("#type_document").select2();
                        $("#type_document").val(data.type_document).trigger("change");
                    }
                });
        }
</script>
<script>
  function cacher_lien_video_ou_file_input() {
         if($("#type_document").val() == 7147){
            $('#lien_video').show();
            $("#doc_div").hide();
         }
         else{
            $('#lien_video').hide();
            $("#doc_div").show();
         }
    };
</script>
@endsection
