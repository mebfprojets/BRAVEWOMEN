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
                        <h2>Liste des <strong>{{ getlibelle($id) }}</strong></h2>
                        <a href="{{ route("document.index") }}"  class="btn btn-default pull-right"><span></span>Liste des dossiers</a>
                    </div>
                </div>
            </div>  
            <div class="widget-main">
                <div class="row text-center">
                @foreach ($documents as $document)
                <a href="{{ route("documents.afficher",$document) }}">
                    <div class="col-xs-3">
                        <div><strong> <small>{{$document->titre_doc}}</small> <br> <small>Auteur: {{ $document->auteur->name }} {{ $document->auteur->prenom }}</small>  </strong><br><img src="{{ asset("img/file.png") }}" alt="" width="60%;"></div>
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
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Enregistrer un versement de contrepartie</h2>
            </div>
            <div class="modal-body">
                    <input type="hidden" name="id_table" id="id_table">
                    <form id="form-validation" method="POST"  action="{{route('document.modifier')}}" class="form-horizontal form-bordered"  enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('parametre') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label" for="typeorga">Catégorie : </label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select  class="form-control" id="parent" name="categorie"  >
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
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label" for="name">Titre du document<span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <div class="input-group">
                                        <input id="name" type="text" class="form-control" name="titre" value="{{ old('titre') }}" required autofocus>
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
                                        <textarea id="description" name="description" placehorder="description" class="form-control">{{old('description')}}</textarea>
                                        </div>
                                @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label" for="document">Joindre le documentss<span class="text-danger">*</span></label>
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

   
    </script>



