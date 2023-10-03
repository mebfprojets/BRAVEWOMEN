@extends("layouts.admin")
@section('gestion_projet', 'active')
@section('activite', 'active')
@section('blank')
    <li>Accueil</li>
    <li>Activité</li>
    <li><a href="">Liste</a></li>
@endsection
@section('content')
        <div class="block full">
            <div class="block-title">
                <div class="row">
                    <div class="col-md-12">
                    <h2>Situation des <strong>activités du projet à la date du {{ format_date($date_deffet) }} </strong></h2> <a href="{{ route('activite.import_view') }}"> Importer les ativites</a>
                    {{-- @can('role.create', Auth::user()) --}}
                       <a href="{{ route('activites.create') }}"    title="Ajouter une nouvelle activité" class="btn btn-xs btn-success"><i class="fa fa-plus"></i> Activité</a>
                    {{-- @endcan --}}
                </div>
                </div>
            </div>
<div class="table-responsive">
<table class="table table-vcenter table-striped table-vcenter listepdf">
        <thead>
                <tr>
                    <th>Libelle </th>
                    <th>Date de debut</th>
                    <th>Date de fin</th>
                    <th>Taux de réalisation</th>
                    <th>Action</th>
                </tr>
        </thead>
        <tbody>
            @foreach($activites as $activite)
                <tr>
                    <td>{{$activite->libelle}}</td>
                    <td>{{format_date($activite->date_debut)}}</td>
                    <td>{{format_date($activite->date_fin)}}</td>
                    <td>{{$activite->taux_de_realisation}}%</td>
                    <td class="text-center">
                        <a href="{{ route('activites.edit',$activite) }}" data-toggle="tooltip" title="Modifier" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                            
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div id="timeline" style="height: 50%;"> etset</div>

</div>
@endsection

    


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


