@extends("layouts.admin")
@section('gestion_projet', 'active')
@section('budget', 'active')
@section('blank')
    <li>Accueil</li>
    <li>Budget</li>
    <li><a href="">Liste</a></li>
@endsection
@section('content')
        <div class="block full">
            <div class="block-title">
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ route('budget.import_view') }}" class="btn btn-success pull-right"><span><i class="fa fa-plus"></i></span>Importer le budget</a>
                    </div> 
              
                    </div>
                    
                </div>
             
<div class="table-responsive">
<table class="table table-vcenter table-condensed table-bordered listepdf ">
        <thead>
                <tr>
                    <th>Activité </th>
                    <th>Montant budgétiser</th>
                    <th>Montant dépensé</th>
                    <th>Montant dépensé en decembre 2021</th>
                    <th>Montant dépensé en decembre 2022</th>
                    <th>Montant dépensé en 2023</th>
                    <th>Action</th>
                </tr>
        </thead>
        <tbody>
            @foreach($budgets as $budget)
                <tr>
                    <td>{{$budget->activite}}</td>
                        <td>{{$budget->montant_budgetise}}</td>
                        <td>{{$budget->montant_depense}}</td>
                        <td>{{$budget->montant_depense_annee_n_2}}</td>
                        <td>{{$budget->montant_depense_annee_n_1}}</td>
                        <td>{{$budget->montant_depense_annee_n}}</td>
                    <td>
                    
                    </td>

                
                </tr>
            @endforeach
        </tbody>
    </table>
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


