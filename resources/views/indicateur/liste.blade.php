@extends("layouts.admin")
@section('administration', 'active')
@section('administration-indicateur', 'active')
@section('blank')
    <li>Accueil</li>
    <li>Indicateurs</li>
    <li><a href="">Liste</a></li>
@endsection
@section('content')
        <div class="block full">
            <div class="block-title">
                <div class="row">
                    <div class="col-md-12">
                    <h2>Indicateurs de suivi <strong></strong></h2>
                    {{-- @can('role.create', Auth::user()) --}}
                        <a href="#modal-create-indicateur" data-toggle="modal"  data-toggle="tooltip" title="Edit" class="btn btn-xs btn-success"><i class="fa fa-plus"></i> Indicateur</a>
                    {{-- @endcan --}}
                </div>
                </div>
            </div>
<div class="table-responsive">
<table class="table table-vcenter table-condensed table-bordered listepdf">
        <thead>
                <tr>
                    <th>Numéro</th>
                    <th>Code</th>
                    <th>Categorie</th>
                    <th>Unité de mesure</th>  
                    <th>Libellé</th> 
                    <th>Cible</th>   
                    <th>Action</th>
                </tr>
        </thead>
        <tbody>
            @php
            $i=0;
          @endphp
      @foreach($indicateurs as $indicateur)
           @php
              $i++;
            @endphp
          <tr>
                    <td>{{$i}}</td>
                    <td>{{$indicateur->code_indicateur}}</td>
                    <td>{{$indicateur->categorie->libelle}}</td>
                    <td>{{getlibelle($indicateur->unite)}}</td>
                    <td>{{$indicateur->libelle}}</td>
                    <td>{{$indicateur->cible}}</td>
                    <td class="text-center">
                            <div class="btn-group">
                             {{-- @can('role.update', Auth::user()) --}}
                                <a  href="#modal-edit-indicateur" onclick="edit_indicateur({{ $indicateur->id }});"   data-toggle="modal" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                            {{-- @endcan --}}
                            
                            </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
        </div>
@endsection

<div id="modal-create-indicateur" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Enregistrer un indicateur</h2>
            </div>
            <div class="modal-body">
                <form id="form-validation" method="POST"  action="{{route('indicateur.store')}}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class=" control-label" for="name">Catégorie<span class="text-danger">*</span></label>
                                    <div class="input-group" style ='width:50%'>
                                        <select id="categorie" name="categorie" class="select-select2" data-placeholder="Choisir la catégorie de l'indicateur" style="width: 80%;"  >
                                            @foreach ($categories as $categorie )
                                                <option value="{{ $categorie->id }}">{{ $categorie->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if ($errors->has('categorie'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('categorie') }}</strong>
                                    </span>
                                    @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class=" control-label" for="name">Unité de mesure <span class="text-danger">*</span></label>
                                    <div class="input-group" style ='width:100%'>
                                        <select id="unite" name="unite" class="select-select2" data-placeholder="Choisir l'unité de l'indicateur" style="width: 100%;"  >
                                            @foreach ($unites as $unite )
                                                <option value="{{ $unite->id }}">{{ $unite->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if ($errors->has('unite'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('unite') }}</strong>
                                    </span>
                                    @endif
                                
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class=" control-label" for="name">Cible<span class="text-danger">*</span></label>
                                    <div class="input-group" style ='width:100%'>
                                            <input id="code" type="text" class="form-control" name="cible" value="{{ old('cible') }}" required autofocus>
                                            <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                    </div>
                                    @if ($errors->has('code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('code') }}</strong>
                                    </span>
                                    @endif
                                
                            </div>
                        </div>
                        
                    </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class=" control-label" for="name">Code<span class="text-danger">*</span></label>
                                <div class="input-group" style ='width:100%'>
                                        <input id="code" type="text" class="form-control" name="code" value="{{ old('code') }}" required autofocus>
                                        <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                </div>
                                @if ($errors->has('code'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('code') }}</strong>
                                </span>
                                @endif
                            
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class=" control-label" for="name">Libelle<span class="text-danger">*</span></label>
                                <div class="input-group" style ='width:100%'>
                                        <input id="libelle" type="text" class="form-control" name="libelle" value="{{ old('libelle') }}" required autofocus>
                                        <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                </div>
                                @if ($errors->has('libelle'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('libelle') }}</strong>
                                </span>
                                @endif
                            
                        </div>
                       
                    </div>
                    
                </div>
                <div class="form-group form-actions">
                    <div class="col-md-8 col-md-offset-4">
                        <a href="{{ route('grille.index') }}" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
                        <button type="submit" class="btn btn-sm btn-sucess"><i class="fa fa-arrow-right"></i> Valider</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div id="modal-edit-indicateur" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Modifier un critere</h2>
            </div>
            <div class="modal-body">
                <form id="form-validation" method="POST"  action="{{route('indicateur.update')}}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="indicateur_id" id="indicateur_id_u">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class=" control-label" for="name">Catégorie<span class="text-danger">*</span></label>
                                    <div class="input-group" style ='width:100%'>
                                        <select id="categorie_u" name="categorie"  data-placeholder="Choisir la catégorie de l'indicateur" style="width: 100%;"  >
                                           <option></option>
                                            @foreach ($categories as $categorie )
                                                <option value="{{ $categorie->id }}">{{ $categorie->libelle }}</option>
                                            @endforeach
                                           
                                        </select>
                                    </div>
                                    @if ($errors->has('categorie'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('categorie') }}</strong>
                                    </span>
                                    @endif
                                
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class=" control-label" for="name">Unité de mesure <span class="text-danger">*</span></label>
                                    <div class="input-group" style ='width:100%'>
                                        <select id="unite_u" name="unite"  data-placeholder="Choisir la catégorie de l'indicateur" style="width: 100%;"  >
                                            <option></option>
                                            @foreach ($unites as $unite )
                                                <option value="{{ $unite->id }}">{{ $unite->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if ($errors->has('unite'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('unite') }}</strong>
                                    </span>
                                    @endif
                                
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class=" control-label" for="name">Cible<span class="text-danger">*</span></label>
                                    <div class="input-group" style ='width:100%'>
                                            <input id="cible_u" type="text" class="form-control" name="cible_u" value="{{ old('cible') }}" required autofocus>
                                            <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                    </div>
                                    @if ($errors->has('cible'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cible') }}</strong>
                                    </span>
                                    @endif
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class=" control-label" for="name">Code<span class="text-danger">*</span></label>
                                <div class="input-group" style ='width:100%'>
                                        <input id="code_u" type="text" class="form-control" name="code_indicateur" value="{{ old('code') }}" required autofocus>
                                        <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                </div>
                                @if ($errors->has('code'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('code') }}</strong>
                                </span>
                                @endif
                            
                        </div>
                       
                    </div> 
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class=" control-label" for="name">Libelle <span class="text-danger">*</span></label>
                                    <div class="input-group" style ='width:100%'>
                                            <input id="libelle_u" type="text" class="form-control" name="libelle"  required autofocus>
                                            <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                    </div>
                                    @if ($errors->has('libelle'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('libelle') }}</strong>
                                    </span>
                                    @endif
                                
                            </div>
                        </div>
                         
                </div>
                <div class="form-group form-actions">
                    <div class="col-md-8 col-md-offset-4">
                        <a href="{{ route('grille.index') }}" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
                        <button type="submit" class="btn btn-sm btn-sucess"><i class="fa fa-arrow-right"></i> Valider</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>  
    <div id="modal-confirm-delete" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header text-center">
                        <h2 class="modal-title"><i class="fa fa-pencil"></i> Confirmation</h2>
                    </div>
                    <!-- END Modal Header -->

                    <!-- Modal Body -->
                    <div class="modal-body">
                            <input type="hidden" name="id_table" id="id_table">
                                <p>Voulez-vous vraiment Supprimer ce role ??</p>
                            <div class="form-group form-actions">
                                <div class="text-right">
                                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                                    <button type="submit" class="btn btn-sm btn-primary" onclick="supp_id();">OUI</button>
                                </div>
                            </div>

                    </div>
                    <!-- END Modal Body -->
                </div>
            </div>
    </div>


    <script>
        function edit_indicateur(id){
                    var id=id;
                   // alert(id)
                    var url = "{{ route('indicateur.modifier') }}";
                    $.ajax({
                        url: url,
                        type:'GET',
                        dataType:'json',
                        data: {id: id} ,
                        error:function(){alert('error');},
                        success:function(data){
                            $("#indicateur_id_u").val(data.id);
                            $("#categorie_u").val(data.categorie);  
                            $("#unite_u").val(data.unite);                        
                           $("#code_u").val(data.code_indicateur);
                           $("#libelle_u").val(data.libelle);
                           $("#cible_u").val(data.cible);
                           
                        }
                    });
            }
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
        function idstatus (id){
            var id= id;

            $.ajax({
                url: url,
                type:'GET',
                data: {id: id} ,
                error:function(){alert('error');},
                success:function(){
                }

            });
        }
        function delConfirm (id){
            //alert(id);
            $(function(){
                //alert(id);
                document.getElementById("id_table").setAttribute("value", id);
            });

        }

        function recu_id(){
            //var id= document.getElementById('id_table').value;
            $(function(){
                var id= $("#id_table").val();

                //alert(id);
                $.ajax({
                    url: url,
                    type:'GET',
                    data: {id: id} ,
                    error:function(){alert('error');},
                    success:function(){
                        $('#modal-user-reinitialise').hide();
                        location.reload();

                    }
                });
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


