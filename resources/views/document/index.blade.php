@extends("layouts.admin")
@section('documents', 'active')
@section('liste-document', 'active')
@section('blank')
    <li>Accueil</li>
    <li>Document</li>
    <li><a href="">Liste</a></li>
@endsection
@section('content')
        <div class="block full">
            <div class="block-title">
                <div class="row">
                    <div class="col-md-12">
                    <h2>Liste des <strong>Documents</strong></h2>
                     @can('document.create', Auth::user()) 
                        <a href="#modal-add-document" data-toggle="modal" onclick="initialiser_contrepartie_id('contrepartie_modif')" class="btn btn-success pull-right"><span><i class="fa fa-plus"></i></span>Document</a>
                    @endcan 
                </div>
                </div>
            </div>  
            <div class="widget-main">
                <div class="row text-center">
                @foreach ($documents as $document)
                <a href="{{ route("documents.byCategorie",$document->cat_id) }}">
                    <div class="col-xs-3">
                        <div><strong>{{ $document->nombre }} {{ $document->categorie }}</strong><br><img src="{{ asset("img/folder.png") }}" alt="" width="60%;"></div>
                    </div>
                </a>
                @endforeach
            </div>
                
        </div>
                
                   
        </div>
@endsection
@section('modal_part')
<div id="modal-add-document"  class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Enregistrer un document</h2>
            </div>
            <div class="modal-body">
                    <input type="hidden" name="id_table" id="id_table">
                    <form id="form-validation" method="POST"  action="{{route('document.store')}}" class="form-horizontal form-bordered"  enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class=" col-md-6 form-group{{ $errors->has('parametre') ? ' has-error' : '' }}" >
                            <label class="col-md-4 control-label" for="typeorga">Catégorie : </label>
                            <div class="col-md-7">
                                <div class="input-group">
                                    <select  class="select-select2" data-placeholder="Choisir la catégorie de document" id="parent" name="categorie"  >
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
                                    <input id="name" type="text" class="form-control" name="titre" value="{{ old('titre') }}" required autofocus>
                                    <span class="input-group-addon"><i class="fa fa-info"></i></span>
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
                                        <textarea id="description" name="description" placehorder="description" cols="50" rows="5" class="form-control" required>{{old('description')}}</textarea>
                                        </div>
                                @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}" id="doc_div">
                            <label class="col-md-4 control-label" for="document">Joindre le document<span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input class="form-control col-md-6" type="file" name="document" id="document" accept=".pdf, .jpeg, .png"   placeholder="Joindre le document">
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
                        <a  class="btn btn-sm btn-warning"  data-dismiss="modal"><i class="fa fa-repeat"></i> Annuler</a>
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
    <script>
    function detailUser(id){
                var id=id;

                $.ajax({
                    url: url,
                    type:'GET',
                    dataType:'json',
                    data: {id: id} ,
                    error:function(){alert('error');},
                    success:function(data){
                        $("#nom_user").text(data.nomUser);
                        $("#prenom_user").text(data.prenomUser);
                        $("#email_user").text(data.emailUser);
                        $("#telephone_user").text(data.telephone);
                        $("#login_user").text(data.login);
                    }
                });
        }
       
        

        

        function supp_id(){
            $(function(){
                var id= $("#id_table").val();

                //alert(id);
                $.ajax({
                    url: url,
                    type:'GET',
                    data: {id: id} ,
                    error:function(){alert('error');},
                    success:function(){
                        $('#modal-confirm-delete').hide();
                        location.reload();

                    }
                });
            });
        }
    </script>



