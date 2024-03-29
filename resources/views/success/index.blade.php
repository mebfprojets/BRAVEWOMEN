@extends("layouts.admin")
@section('dashboard', 'active')
@section('success-storie', 'active')
@section('blank')
    <li>Accueil</li>
    <li>Success Stories</li>
    <li><a href="{{ route('user.index') }}">Liste des success stories</a></li>
@endsection
@section('content')
        <div class="block full">
            <div class="block-title">
                <div class="row">
                        <div class="col-md-12">
                        <h2>Les <strong>Success Stories</strong></h2>
                        @can('creer_success_stories', Auth::user())
                            <a href="#modal-create-success_stories" data-toggle="modal"  data-toggle="tooltip" title="create"  class="btn btn-success pull-right"><span><i class="fa fa-plus"></i></span> Success Stories</a>
                        @endcan
                </div>
            </div>
        </div>
<div class="row">
@foreach ($success_stories as $success_storie)
    <div class="col-md-4">
        <div class="widget widget_plus" >
            <div class="widget-advanced widget-advanced-alt">
                <!-- Widget Header -->
                <div class="widget-header text-left" style="height: 300px;">
                    <!-- For best results use an image with at least 150 pixels in height (with the width relative to how big your widget will be!) - Here I'm using a 1200x150 pixels image -->
                    <img height="300" src="{{ Storage::disk('local')->url($success_storie->url_image) }}" alt="background">
                    <h3 class="widget-content widget-content-image widget-content-light clearfix">
                        <a href="javascript:void(0)" class="widget-icon pull-right">
                            <i class="fa fa-picture-o"></i>
                        </a>
                        <p>{{ $success_storie->beneficaire->denomination }}</p>
                    </h3>
                </div>
                <div class="widget-main">
                    <p> {{ $success_storie->apercu }}</p>
                </div>
                
                
                
                @can('update_success_stories', Auth::user())
                    <a href="#modal-update-success_stories" onclick="get_data_success_stories('{{ $success_storie->id }}')" data-toggle="modal"  data-toggle="tooltip" title="Modifier" class="btn btn-warning" style="width: 40%;"> Modifier</a>
                    <a href="#modal-confirme-supression" onclick="get_success_stories_id('{{ $success_storie->id }}')" data-toggle="modal"  data-toggle="tooltip" title="Modifier" class="btn btn-danger" style="width: 40%;"> Supprimer</a>
                @endcan
                <a href="#modal-view-success_stories" onclick="get_data_success_stories('{{ $success_storie->id }}')" data-toggle="modal"  data-toggle="tooltip" title="Lire la suite" class="btn btn-success" style="width: 100%;"> Lire la suite</a>
            </div>
        </div>
    
</div>

@endforeach
</div>
</div>

@endsection
@section('modal_part')
    <div id="modal-confirme-supression" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h2 class="modal-title"><i class="fa fa-times"></i> Confirmer la suppression</h2>
                </div>
                <div class="modal-body">
                    <form id="form-validation" method="POST"  action="{{route('sucessStorie.supprimer')}}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                        {{ csrf_field() }}
                            <p>Voulez-vous vraiment Supprimer le success stories ???</p>
                        <input type="hidden" name="success_stories_id" id="success_stories_sup_id">
                        <div class="form-group form-actions">
                            <div class="row text-right">
                                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-sm btn-primary">Supprimer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-create-success_stories" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center">
                    <h2 class="modal-title"><i class="fa fa-pencil"></i> Enregistrer un success stories </h2>
                </div>
                <div class="modal-body">
                    <form id="form-validation" method="POST"  action="{{route('sucessStorie.store')}}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label class=" control-label" for="name">Bénéficiaire concerné<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <select id="beneficiaire" name="beneficiaire" class="select-select2" data-placeholder="Choisir la catégorie de l'indicateur" style="width: 300px" required >
                                                <option></option>
                                                @foreach ($beneficaires as $beneficaire )
                                                    <option value="{{ $beneficaire->id }}">{{ $beneficaire->denomination }} - {{ $beneficaire->code_promoteur }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @if ($errors->has('beneficiaire'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('beneficiaire') }}</strong>
                                        </span>
                                        @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label class=" control-label" for="name">Joindre une image<span class="text-danger">*</span></label>
                                        <div class="input-group" style ='width:100%'>
                                            <input class="form-control col-md-6" type="file" name="image_successstorie" id="copie_du_recu" accept=".pdf, .jpeg, .png"   placeholder="Joindre une copie du reçu de versement" required>
                                                <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                        </div>
                                        @if ($errors->has('image_successstorie'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('image_successstorie') }}</strong>
                                        </span>
                                        @endif
                                    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label class=" control-label" for="name">Titre :<span class="text-danger">*</span></label>
                                        <div class="input-group" style ='width:100%'>
                                            <input class="form-control col-md-6" type="text" name="titre" id="titre"   placeholder="Donner un titre au success stories" required>
                                                <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                        </div>
                                        @if ($errors->has('titre'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('titre') }}</strong>
                                        </span>
                                        @endif
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class=" control-label" for="product-description">Description  <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <!-- CKEditor, you just need to include the plugin (see at the bottom of this page) and add the class 'ckeditor' to your textarea -->
                                    <!-- More info can be found at http://ckeditor.com -->
                                    <textarea id="product-description" name="description" rows="9" cols="100" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>                        
                
                    <div class="form-group form-actions">
                        <div class="col-md-8 col-md-offset-4">
                            <a data-dismiss="modal" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
                            <button type="submit" class="btn btn-sm btn-sucess"><i class="fa fa-arrow-right"></i> Valider</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-update-success_stories" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h2 class="modal-title"><i class="fa fa-pencil"></i> Modifier un success stories </h2>
                </div>
                <div class="modal-body">
                    <form id="form-validation" method="POST"  action="{{route('sucessStorie.modifier')}}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="success_storie_id" id="successStorie_id_u">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label class=" control-label" for="name">Bénéficiaire concerné<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <select id="beneficiaire_u" name="beneficiaire"   data-placeholder="Choisir l'auteur" style="width: 300px" required >
                                                <option></option>
                                                @foreach ($beneficaires as $beneficaire )
                                                    <option value="{{ $beneficaire->id }}">{{ $beneficaire->denomination }} - {{ $beneficaire->code_promoteur }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @if ($errors->has('beneficiaire'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('beneficiaire') }}</strong>
                                        </span>
                                        @endif
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label class=" control-label" for="name">Joindre une image<span class="text-danger">*</span></label>
                                        <div class="input-group" style ='width:100%'>
                                            <input class="form-control col-md-6" type="file" name="image_successstorie" id="image_successStorie_u" accept=".pdf, .jpeg, .png" placeholder="Joindre une copie du reçu de versement">
                                                <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                        </div>
                                        @if ($errors->has('image_successstorie'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('image_successstorie') }}</strong>
                                        </span>
                                        @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label class=" control-label" for="name">Titre :<span class="text-danger">*</span></label>
                                        <div class="input-group" style ='width:100%'>
                                            <input class="form-control col-md-6" type="text" name="titre" id="titre_u"   placeholder="Donner un titre au success stories" required>
                                                <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                        </div>
                                        @if ($errors->has('titre'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('titre') }}</strong>
                                        </span>
                                        @endif
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class=" control-label" for="product-description">Description  <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <!-- CKEditor, you just need to include the plugin (see at the bottom of this page) and add the class 'ckeditor' to your textarea -->
                                    <!-- More info can be found at http://ckeditor.com -->
                                    <textarea id="description_u" name="description"  rows="9" cols="100" class="form-control"  ></textarea>
                                </div>
                            </div>
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
            </div>
        </div>
    </div>
    <div id="modal-view-success_stories" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center">
                    <h2 class="modal-title">  <p class="beneficiaire"> </p> </h2>
                </div>
                <div class="modal-body">
                    <div class="widget" >
                        <div class="widget-advanced widget-advanced-alt">
                            <!-- Widget Header -->
                            <div class="widget-header text-left" >
                                <!-- For best results use an image with at least 150 pixels in height (with the width relative to how big your widget will be!) - Here I'm using a 1200x150 pixels image -->
                                <img  alt="background" id="image_source" height="200" >
                                <h3 class="widget-content widget-content-image widget-content-light clearfix">
                                    <a href="javascript:void(0)" class="widget-icon pull-right">
                                        <i class="fa fa-picture-o"></i>
                                    </a>
                                   
                                </h3>
                            </div>
                            <div class="widget-main">
                               <strong> <p class="titre" style="text-align: center"> </p> </strong> 
                               <p class="description"> </p>
                              
                            </div>
                        
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Fermer le detail</button>
                </div>
            </div>
        </div>
    </div>
@endsection

    <script>
        function get_success_stories_id(id){
            $("#success_stories_sup_id").val(id);
        }
        function get_data_success_stories(id){
            
            $(function(){
               var url = "{{ route('successStorie.get') }}";
                $.ajax({
                    url: url,
                    type:'GET',
                    dataType:'json',
                    data: {id: id} ,
                    error:function(){alert('error');},
                    success:function(data){
                       $("#beneficiaire_u").select2();
                       $("#beneficiaire_u").val(data.beneficiaire).trigger("change");
                       $(".description").text(data.description)
                       $(".titre").text(data.titre)
                       $("#beneficiaire_u").val(data.beneficiaire)
                       var url_img='{{asset(":img")}}'
                       var url_img = url_img.replace(':img', data['url_img']);
                       $("#image_source").attr("src",url_img);
                       $("#successStorie_id_u").val(data.id)
                       $("textarea#description_u").val(data.description)
                       $("#titre_u").val(data.titre)
                      
                    }
                });
            });
        }
    </script>








  