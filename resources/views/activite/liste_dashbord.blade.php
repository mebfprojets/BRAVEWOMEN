@extends("layouts.admin")
@section('dashboard', 'active')
@section('activite_dashbord', 'active')
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
                            <h2 >Situation des activités du projet à la date du <strong> {{ format_date($date_deffet) }} </strong></h2>
                        </div> 
                        <div class="row" style="margin:0 15px">
                            <div class="col-md-3 ml-2">Taux de réalisation global</div>
                            <div class="col-md-9">
                                @if($taux_de_realisation_global<50)
                                <div class="progress">
                                    <div class="progress-bar progress-bar-danger"  role="progressbar" style="width: {{$taux_de_realisation_global}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{$taux_de_realisation_global}}%</div>
                                </div>
                            @elseif($taux_de_realisation_global>50&& $taux_de_realisation_global<75)
                                <div class="progress"  >
                                    <div class="progress-bar progress-bar-warning"  role="progressbar" style="width: {{$taux_de_realisation_global}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{$taux_de_realisation_global}}%</div>
                                </div>
                            @else
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success"  role="progressbar" style="width: {{$taux_de_realisation_global}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{$taux_de_realisation_global}}%</div>
                                </div>
                            @endif
                            </div> 
                        </div>  
                </div>
            </div>
           
<div class="tableFixHead">
    <table class="table table-striped table-vcenter  ">
            <thead>
                    <tr>
                        <th>Numero </th>
                        <th>Activité </th>
                        <th>Precedentes </th>
                        <th>Debut</th>
                        <th>Fin</th>
                        <th>Taux </th>
                    </tr>
            </thead>
            <tbody>
                @foreach($activites as $activite)
                    <tr>
                        <td>{{$activite->numero}}</td>
                        <td>{{$activite->libelle}}</td>
                        <td style="text-align: center">{{$activite->numero_precedent}}</td>
                        <td>{{format_date($activite->date_debut)}}</td>
                        <td>{{format_date($activite->date_fin)}}</td>
                        <td>
                            @if($activite->taux_de_realisation<50)
                                <div class="progress"  >
                                    <div class="progress-bar progress-bar-danger"  role="progressbar" style="width: {{$activite->taux_de_realisation}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{$activite->taux_de_realisation}}%</div>
                                </div>
                            @elseif ($activite->taux_de_realisation>50&& $activite->taux_de_realisation<75)
                                <div class="progress"  >
                                    <div class="progress-bar progress-bar-warning"  role="progressbar" style="width: {{$activite->taux_de_realisation}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{$activite->taux_de_realisation}}%</div>
                                </div>
                            @else
                                <div class="progress"  >
                                    <div class="progress-bar progress-bar-success"  role="progressbar" style="width: {{$activite->taux_de_realisation}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{$activite->taux_de_realisation}}%</div>
                                </div>
                            @endif
                        </td>

                    
                    </tr>
                @endforeach
            </tbody>
    </table>
</div>

</div>


<div class="block full">
            <div class="block-title">
                <div class="row">
                        <div class="col-md-12">
                            <h2 >Situation des activités du projet à la date du <strong> {{ format_date($date_deffet) }} </strong></h2>
                        </div> 
                </div>
           

<div id="activity_timeline">

</div>
</div>
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


