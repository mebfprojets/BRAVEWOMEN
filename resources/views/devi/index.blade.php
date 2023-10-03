@extends('layouts.admin')
@section('finacement', 'active')
@section('devis', 'active')
@section('content')
<div class="col-md-12">
        <!-- Basic Form Elements Title -->

                <!-- Form Validation Example Block -->
                <div class="block">
                    <!-- Form Validation Example Title -->
                    <div class="block-title">
                        <h2> Liste <strong>des Devis</strong></h2>        
                    </div>
 <div class="table-responsive">
    <table  class="table table-vcenter table-condensed table-bordered listepdf">
        <thead>
                <tr>
                    <th>N</th>
                    <th>Numero devis</th>
                    <th>Code promotteur</th>
                    <th>Entreprise</th>
                    <th>Désignation</th>
                    <th>Prestataire</th>
                    <th>Montant</th>
                   
                    <th>Etat</th>
                    <th>Taux de réalisation</th>
                    <th>Actions</th>
                </tr>
        </thead>
        <tbody>
            @foreach($devis as $devi)
                <tr>
                    <td>N</td>
                    <td>{{$devi->numero_devis}}</td>
                    <td>{{$devi->entreprise->code_promoteur}}</td>
                    <td>{{$devi->entreprise->denomination}}</td>
                    <td>{{$devi->designation}}</td>
                    <td>{{$devi->prestataire->code_prestaire}} {{$devi->prestataire->nom_responsable}} {{$devi->prestataire->prenom_responsable}}</td>
                    <td>{{format_prix($devi->montant_devis)}}</td>
                    <td>{{$devi->statut}}</td>
                    <td>{{$devi->taux_de_realisation}}%</td>
                    <td class="text-center">
                            <div class="btn-group">
                             {{-- @can('formation.update', Auth::user()) --}}
                                <a href="{{ route('devi.show',$devi) }}" data-toggle="tooltip" title="Analyser le devis" class="btn btn-lg btn-success"><i class="fa fa-eye"></i></a>
                            {{-- @endcan --}}
                            </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
        </table>
    </div>
    </div>
    </div>
@endsection
@section('modalSection')
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

        function recu_id(){
            //var id= document.getElementById('id_table').value;
            $(function(){
                var id= $("#id_table").val();
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

@endsection

