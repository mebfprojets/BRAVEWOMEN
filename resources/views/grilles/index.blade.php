@extends("layouts.admin")
@section('administration', 'active')
@section('administration-prestataire', 'active')
@section('blank')
    <li>Accueil</li>
    <li>Grille d'evaluation</li>
    <li><a href="">Liste</a></li>
@endsection
@section('content')
        <div class="block full">
            <div class="block-title">
                <div class="row">
                    <div class="col-md-12">
                    <h2>Grille d'evaluation des PCA <strong></strong></h2>
                    {{-- @can('role.create', Auth::user()) --}}
                        <a href="#modal-create-grille" data-toggle="modal"  data-toggle="tooltip" title="Edit" class="btn btn-xs btn-success"><i class="fa fa-plus"></i> Critère</a>
                    {{-- @endcan --}}
                </div>
                </div>
            </div>
<div class="table-responsive">
<table class="table table-vcenter table-condensed table-bordered listepdf">
        <thead>
                <tr>
                    <th>numéro</th>
                    <th>categorie</th>
                    <th>Libellé</th>
                    <th>Ponderation</th>
                    
                    <th>Action</th>
                </tr>
        </thead>
        <tbody>
            @php
            $i=0;
          @endphp
      @foreach($grilles as $grille)
           @php
              $i++;
            @endphp
          <tr>
                    <td>{{$i}}</td>
                    <td>{{$grille->categorie}}</td>
                    <td>{{$grille->libelle}}</td>
                    <td>{{$grille->ponderation}}</td>
                    <td class="text-center">
                            <div class="btn-group">
                             {{-- @can('role.update', Auth::user()) --}}
                                <a  href="#modal-edit-grille" onclick="edit_grille({{ $grille->id }});"   data-toggle="modal" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                            {{-- @endcan --}}
                            @can('role.delete',Auth::user())
                                <a href="#modal-confirm-grille" onclick="delConfirm({{ $grille->id }});" data-toggle="modal" title="Supprimer" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                            @endcan
                            </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
        </div>
@endsection

<div id="modal-create-grille" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Enregistrer un critère</h2>
            </div>
            <div class="modal-body">
                <form id="form-validation" method="POST"  action="{{route('grille.store')}}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label" for="type">Categorie<span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <select id="categorie" name="categorie" class="select-select2" data-placeholder="Choisir le type de systeme de suivi" style="width: 100%;"  >
                                    <option value="PCA">MPME</option>
                                    <option value="PA">AOP/Leader</option>
                                </select>
                                @if ($errors->has('categorie'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('categorie') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class=" control-label" for="name">Libelle <span class="text-danger">*</span></label>
                            
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
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class=" control-label" for="name">Pondération<span class="text-danger">*</span></label>
                                <div class="input-group" style ='width:100%'>
                                        <input id="ponderation" type="number" class="form-control" name="ponderation" value="{{ old('ponderation') }}" required autofocus>
                                        <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                </div>
                                @if ($errors->has('ponderation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('ponderation') }}</strong>
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


<div id="modal-edit-grille" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Modifier un critere</h2>
            </div>
            <div class="modal-body">
                <form id="form-validation" method="POST"  action="{{route('grille.storemodif')}}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="grille_id" id="grille_id">
                    <div class="row">
                        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label" for="type">Categorie<span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <select id="categorie" name="categorie" class="select-select2" data-placeholder="Choisir le type de systeme de suivi" style="width: 100%;"  >
                                    <option value="PCA">MPME</option>
                                    <option value="PA">AOP/Leader</option>
                                </select>
                                @if ($errors->has('categorie'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('categorie') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                <div class="row">
                   
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class=" control-label" for="name">Libelle <span class="text-danger">*</span></label>
                                
                                    <div class="input-group" style ='width:100%'>
                                            <input id="libelle_u" type="text" class="form-control" name="libelle" value="{{ old('libelle') }}" required autofocus>
                                            <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                    </div>
                                    @if ($errors->has('libelle'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('libelle') }}</strong>
                                    </span>
                                    @endif
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class=" control-label" for="name">Pondération<span class="text-danger">*</span></label>
                                    <div class="input-group" style ='width:100%'>
                                            <input id="ponderation_u" type="number" class="form-control" name="ponderation" value="{{ old('ponderation') }}" required autofocus>
                                            <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                    </div>
                                    @if ($errors->has('ponderation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ponderation') }}</strong>
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
        function edit_grille(id){
                    var id=id;
                    var url = "{{ route('grille.modif') }}";
                    $.ajax({
                        url: url,
                        type:'GET',
                        dataType:'json',
                        data: {id: id} ,
                        error:function(){alert('error');},
                        success:function(data){
                            $("#grille_id").val(data.id);
                            $("#categorie").val(data.categorie);                           
                           $("#libelle_u").val(data.libelle);
                           $("#ponderation_u").val(data.ponderation);
                          
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


