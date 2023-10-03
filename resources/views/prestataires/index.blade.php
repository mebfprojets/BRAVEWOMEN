@extends("layouts.admin")
@section('administration', 'active')
@section('prestataire', 'active')
@section('blank')
    <li>Accueil</li>
    <li>Prestataire</li>
    <li><a href="">Liste</a></li>
@endsection
@section('content')
        <div class="block full">
            <div class="block-title">
                <div class="row">
                    <div class="col-md-12">
                    <h2>Liste des <strong>Prestataires</strong></h2>
                        <a href="#modal-create-prestataire" data-toggle="modal"  data-toggle="tooltip" title="Edit" class="btn btn-xs btn-success"><i class="fa fa-plus"></i> Prestataire</a>
                </div>
                </div>
            </div>
<div class="table-responsive">
<table class="table table-vcenter table-condensed table-bordered listepdf">
        <thead>
                <tr>
                    <th>Code prestataire</th>
                    <th>Denominiation</th>
                    <th>Nom & Prénom</th>
                    <th>Téléphone</th>
                    <th>Domaine activite</th>
                    <th>Situation Géographique</th>
                    <th>Action</th>
                </tr>
        </thead>
        <tbody>
            @foreach($prestataires as $prestataire)
                <tr>
                    <td>{{$prestataire->code_prestaire}}</td>
                    <td>{{$prestataire->denomination_entreprise}}</td>
                    <td>{{$prestataire->nom_responsable}} {{$prestataire->prenom_responsable}}</td>
                    <td>{{$prestataire->telephone}}</td>
                    <td>{{getlibelle($prestataire->domaine_activite)}}</td>
                    <td>{{ getlibelle($prestataire->region)}} {{getlibelle($prestataire->province)}} {{ getlibelle($prestataire->commune)}}</td>
                    <td class="text-center">
                            <div class="btn-group">
                             {{-- @can('role.update', Auth::user()) --}}
                                <a  href="#modal-edit-prestataire" onclick="edit_prestataire({{ $prestataire->id }});"   data-toggle="modal" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                            {{-- @endcan --}}
                            @can('role.delete',Auth::user())
                                <a href="#modal-confirm-delete" onclick="delConfirm({{ $prestataire->id }});" data-toggle="modal" title="Supprimer" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
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

<div id="modal-create-prestataire" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Enregistrer un prestataire</h2>
            </div>
            <div class="modal-body">
                <form id="form-validation" method="POST"  action="{{route('prestataire.store')}}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                    {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class=" control-label" for="name">Denomination de l'entreprise<span class="text-danger">*</span></label>
                            
                                <div class="input-group" style ='width:100%'>
                                        <input id='denom' type="text" class="form-control" name="denomination_entreprise" value="{{ old('denomination_entreprise') }}" onchange="controle_prestataire_denomination('denom');" required autofocus>
                                        <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                </div>
                                <p id="signaler_denomination" style="color:red; display:none">Attention un prestataire a déjà été enregistré avec ce numéro</p>
                                @if ($errors->has('denomination'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('denomination') }}</strong>
                                </span>
                                @endif
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="secteur_activite">Domaine d'activité<span class="text-danger">*</span></label>
                                <select id="secteur_activite" name="secteur_activite" class="select-select2" data-placeholder="Chosir Region du prestataire .." value="{{old("secteur_activite")}}"   style="width:100%;" required>
                                    <option></option><!-- Required for data-placeholder attribute to work with select2 plugin -->
                                    @foreach ($secteur_activites as $secteur_activite )
                                            <option value="{{ $secteur_activite->id  }}" {{ old('secteur_activite') == $secteur_activite->id ? 'selected' : '' }}>{{ $secteur_activite->libelle }}</option>
                                    @endforeach
                                </select>
    
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class=" control-label" for="name">Nom du responsable<span class="text-danger">*</span></label>
                           
                                <div class="input-group" style ='width:100%'>
                                        <input id="name" type="text" class="form-control" name="nom_responsable" value="{{ old('nom_responsable') }}" required autofocus>
                                        <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                </div>
                                @if ($errors->has('nom_responsable'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nom_responsable') }}</strong>
                                </span>
                                @endif
                            
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="control-label" for="name">Prénom du responsable<span class="text-danger">*</span></label>
                           
                                <div class="input-group" style ='width:100%'>
                                        <input id="name" type="text" class="form-control" name="prenom_responsable" value="{{ old('prenom_responsable') }}" required autofocus>
                                        <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                </div>
                                @if ($errors->has('prenom_responsable'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('prenom_responsable') }}</strong>
                                </span>
                                @endif
                            
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="control-label" for="name">Telephone<span class="text-danger">*</span></label>
                            
                                <div class="input-group" style ='width:100%'>
                                     <input id="name" type="text" class="form-control" name="telephone" value="{{ old('telephone') }}"  required autofocus>
                                </div>
                                @if ($errors->has('telephone'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('telephone') }}</strong>
                                </span>
                                @endif
                        </div>
                   
                    <div class="form-group">
                        <label class="control-label" for="region">Region<span class="text-danger">*</span></label>
                            <select id="region_residence" name="region" class="select-select2" data-placeholder="Chosir Region du Prestataire .." value="{{old("region")}}" onchange="changeValue('region_residence', 'province_residence', {{ env('PARAMETRE_ID_PROVINCE') }});"   style="width:100%;" required>
                                <option></option><!-- Required for data-placeholder attribute to work with select2 plugin -->
                                @foreach ($regions as $region )
                                        <option value="{{ $region->id  }}" {{ old('region') == $region->id ? 'selected' : '' }}>{{ $region->libelle }}</option>
                                @endforeach
                            </select>

                    </div>
                    <div class="form-group">
                        <label class="control-label" for="province_residence">Province du Prestataire<span class="text-danger">*</span></label>
                            <select id="province_residence" name="province" class="select-select2" onchange="changeValue('province_residence', 'commune_residence', {{ env('PARAMETRE_ID_COMMUNE') }});" data-placeholder="Chosir la province du Prestataire .."  style="width: 100%;">
                                <option  value="{{ old('province') }}" {{ old('province') == old('province') ? 'selected' : '' }}>{{ getlibelle(old('province')) }}</option>
                            </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="example-chosen">Commune/Ville du Prestataire<span class="text-danger">*</span></label>
                            <select id="commune_residence" name="commune" class="select-select2" data-placeholder="Chosir la commune du Prestataire ..." onchange="changeValue('commune_residence', 'arrondissement_residence', {{ env('PARAMETRE_ID_ARRONDISSEMENT') }});" style="width: 100%;" required>
                                <option  value="{{ old('commune') }}" {{ old('commune') == old('commune') ? 'selected' : '' }}>{{ getlibelle(old('commune')) }}</option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                            </select>
                    </div>
                </div>
                </div>
                <div class="form-group form-actions">
                    <div class="col-md-8 col-md-offset-4">
                        <a href="{{ route('prestataire.index') }}" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
                        <button type="submit" class="btn btn-sm btn-sucess"><i class="fa fa-arrow-right"></i> Valider</button>
                    </div>
                </div>
                    

                </form>
            </div>
        </div>
    </div>
</div>


<div id="modal-edit-prestataire" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Modifier un prestataire</h2>
            </div>
            <div class="modal-body">
                <form id="form-validation" method="POST"  action="{{route('prestataire.storemodif')}}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="prestataire" id="presta_id">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class=" control-label" for="name">Denomination de l'entreprise<span class="text-danger">*</span></label>
                            
                                <div class="input-group" style ='width:100%'>
                                        <input id="denomination" type="text" class="form-control" name="denomination_entreprise" value="{{ old('denomination_entreprise') }}" required autofocus>
                                        <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                </div>
                                @if ($errors->has('nom'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nom') }}</strong>
                                </span>
                                @endif
                            
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="secteur_activite">Domaine d'activité<span class="text-danger">*</span></label>
                                <select id="secteur_activite" name="secteur_activite" class="select-select2" data-placeholder="Choisir Le domaine d'activite .." value="{{old("secteur_activite")}}"   style="width:100%;" required>
                                    <option></option><!-- Required for data-placeholder attribute to work with select2 plugin -->
                                    @foreach ($secteur_activites as $secteur_activite )
                                            <option value="{{ $secteur_activite->id  }}" {{ old('secteur_activite') == $secteur_activite->id ? 'selected' : '' }}>{{ $secteur_activite->libelle }}</option>
                                    @endforeach
                                </select>
    
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class=" control-label" for="name">Nom du responsable<span class="text-danger">*</span></label>
                           
                                <div class="input-group" style ='width:100%'>
                                        <input id="nom_res" type="text" class="form-control" name="nom_responsable" value="{{ old('nom_responsable') }}" required autofocus>
                                        <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                </div>
                                @if ($errors->has('nom_responsable'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nom_responsable') }}</strong>
                                </span>
                                @endif
                            
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="control-label" for="name">Prénom du responsable<span class="text-danger">*</span></label>
                           
                                <div class="input-group" style ='width:100%'>
                                        <input id="prenom_res" type="text" class="form-control" name="prenom_responsable" value="{{ old('prenom_responsable') }}" required autofocus>
                                        <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                </div>
                                @if ($errors->has('prenom_responsable'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('prenom_responsable') }}</strong>
                                </span>
                                @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="control-label" for="name">Telephone<span class="text-danger">*</span></label>
                            
                                <div class="input-group" style ='width:100%'>
                                     <input id="telephone" type="text" class="form-control" name="telephone" value="{{ old('telephone') }}"  required autofocus>
                                </div>
                                @if ($errors->has('telephone'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('telephone') }}</strong>
                                </span>
                                @endif
                        </div>
                   
                    <div class="form-group">
                        <label class="control-label" for="region">Region<span class="text-danger">*</span></label>
                            <select id="region" name="region" class="select-select2" data-placeholder="Chosir Region du prestataire .." value="{{old("region")}}" onchange="changeValue('region', 'province', {{ env('PARAMETRE_ID_PROVINCE') }});"   style="width:100%;" required>
                                <option></option><!-- Required for data-placeholder attribute to work with select2 plugin -->
                                @foreach ($regions as $region )
                                        <option value="{{ $region->id  }}" {{ old('region') == $region->id ? 'selected' : '' }}>{{ $region->libelle }}</option>
                                @endforeach
                            </select>

                    </div>
                    <div class="form-group">
                        <label class="control-label" for="province_residence">Province<span class="text-danger">*</span></label>
                            <select id="province" name="province" class="select-select2" onchange="changeValue('province', 'commune', {{ env('PARAMETRE_ID_COMMUNE') }});" data-placeholder="Chosir la province du prestataire .."  style="width: 100%;">
                                <option  value="{{ old('province') }}" {{ old('province') == old('province') ? 'selected' : '' }}>{{ getlibelle(old('province')) }}</option>
                            </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="example-chosen">Commune/Ville<span class="text-danger">*</span></label>
                        <select id="commune" name="commune" class="select-select2" data-placeholder="Chosir la commune du prestataire ..." onchange="changeValue('commune', 'arrondissement', {{ env('PARAMETRE_ID_ARRONDISSEMENT') }});" style="width: 100%;" required>
                                <option  value="{{ old('commune') }}" {{ old('commune') == old('commune') ? 'selected' : '' }}>{{ getlibelle(old('commune')) }}</option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                            </select>
                    </div>
                </div>
                </div>
                <div class="form-group form-actions">
                    <div class="col-md-8 col-md-offset-4">
                        <a href="{{ route('prestataire.index') }}" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
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
    function controle_prestataire_denomination(denom){
       var den=$('#'+denom).val();
       //alert(den);
        var url = "{{ route('prestataire.verifierDenomination') }}";
                    $.ajax({
                        url: url,
                        type:'GET',
                        dataType:'json',
                        data: {denomination: den} ,
                        error:function(){alert('error');},
                        success:function(data){
                            if(data==1){
                                //alert('oko');
                                $("#signaler_denomination").show();
                            }
                            else{
                                $("#signaler_denomination").hide();
                            }
                           
                          
                        }
                    });
    }
</script>

    <script>
        function edit_prestataire(id){
                    var id=id;
                    var url = "{{ route('prestataire.modif') }}";
                    $.ajax({
                        url: url,
                        type:'GET',
                        dataType:'json',
                        data: {id: id} ,
                        error:function(){alert('error');},
                        success:function(data){
                            //var motif= data.motif+' '+ data.observation;
                            $("#presta_id").val(data.id);
                            //alert($("#presta_id").val());
                           $("#denomination").val(data.denomination);
                           $("#secteur_activite").val(data.domaine_activite);
                           $("#nom_res").val(data.nom_responsable);
                           $("#prenom_res").val(data.prenom_responsable);
                           $("#telephone").val(data.telephone); 
                           $("#region").val(data.region);
                           $("#province").val(data.province);
                           $("#commune").val(data.commune);
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


