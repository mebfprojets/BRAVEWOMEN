@extends("layouts.admin")
@section('administration', 'active')
@section('administration-impact', 'active')
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
                    <h2>Données de l'impact sociaux economique des sur les entreprise <strong></strong></h2>
                    {{-- @can('role.create', Auth::user()) --}}
                        <a href="#modal-charger-impact-data" data-toggle="modal"  data-toggle="tooltip" title="Edit" class="btn btn-xs btn-success"><i class="fa fa-plus"></i>Importer</a>
                    {{-- @endcan --}}
                </div>
                </div>
            </div>
<div class="table-responsive">
<table class="table table-vcenter table-condensed table-bordered listepdf">
        <thead>
                <tr>
                    <th>numéro</th>
                    <th>Date de collecte</th>
                    <th>Entreprise</th>
                    <th>Indicateur</th>
                    <th>Valeur de base</th>
                    <th>Resultat</th> 
                    <th>Valeur créée</th>      
                    <th>Action</th>
                </tr>
        </thead>
        <tbody>
            @php
            $i=0;
          @endphp
      @foreach($impacts as $impact)
           @php
              $i++;
            @endphp
          <tr>
                    <td>{{$i}}</td>
                    <td>{{format_date($impact->date_collecte)}}</td>
                    <td>{{$impact->entreprise->denomination}}</td>
                    <td>{{$impact->indicateur->libelle}}</td>
                    <td>{{$impact->valeur_ref}}</td>
                    <td>{{$impact->valeur_resultat}}</td>
                    <td>{{$impact->valeur_creee}}</td>

                    <td class="text-center">
                            <div class="btn-group">
                             {{-- @can('role.update', Auth::user()) --}}
                                <a  href="#modal-edit-impact" onclick="edit_impact({{ $impact->id }});"   data-toggle="modal" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
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

 <div id="modal-charger-impact-data" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Importer impacts data</h2>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('impact.store') }}" enctype="multipart/form-data" >
                    @csrf
                    <input type="file" name="fichier" >
                    <br>
                    <button type="submit" >Importer</button>
                </form> 
            </div>
        </div>
    </div>
</div>
<div id="modal-edit-impact" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Modifier la valeur de l'impact</h2>
            </div>
            <div class="modal-body">
                <form id="form-validation" method="POST"  action="{{route('impact.modifier')}}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="impact_id" id="impact_id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class=" control-label" for="name">Indicateur<span class="text-danger">*</span></label>
                                    <div class="input-group" style ='width:100%'>
                                        <select id="indicateur_id_u" name="indicateur"  data-placeholder="Choisir l'indicateur" style="width: 100%;"  >
                                           <option></option>
                                            @foreach ($indicateurs as $indicateur )
                                                <option value="{{ $indicateur->id }}">{{ $indicateur->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if ($errors->has('indicateur'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('indicateur') }}</strong>
                                    </span>
                                    @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class=" control-label" for="name">Valeur de référence<span class="text-danger">*</span></label>
                                    <div class="input-group" style ='width:100%'>
                                        <input id="valeur_ref" type="text" class="form-control" name="valeur_ref" value="{{ old('valeur') }}" required autofocus>
                                        <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                    </div>
                                    @if ($errors->has('valeur'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('valeur') }}</strong>
                                    </span>
                                    @endif
                            </div>
                           
                        </div> 
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class=" control-label" for="name">Valeur resulat<span class="text-danger">*</span></label>
                                    <div class="input-group" style ='width:100%'>
                                        <input id="valeur_resultat" type="text" class="form-control" name="valeur_resultat" value="{{ old('valeur') }}" required autofocus>
                                        <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                    </div>
                                    @if ($errors->has('valeur'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('valeur') }}</strong>
                                    </span>
                                    @endif
                            </div>
                           
                        </div>
                        
                    </div>
                    
            
                <div class="form-group form-actions">
                    <div class="col-md-8 col-md-offset-4">
                        <a href="{{ route('impact.index') }}" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
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
        function edit_impact(id){
                    var id=id;
                   // alert(id)
                    var url = "{{ route('impact.modif') }}";
                    $.ajax({
                        url: url,
                        type:'GET',
                        dataType:'json',
                        data: {id: id} ,
                        error:function(){alert('error');},
                        success:function(data){
                            $("#impact_id").val(data.id);
                            $("#entreprise_id_u").val(data.entreprise_id);  
                            $("#indicateur_id_u").val(data.indicateur_id);                        
                           $("#valeur_ref").val(data.valeur_ref);
                           $("#valeur_resultat").val(data.valeur_resultat);
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


