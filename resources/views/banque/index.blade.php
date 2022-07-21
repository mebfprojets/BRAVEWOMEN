@extends('layouts.admin')
@section('administration', 'active')
@section('administration-banque', 'active')
@section('content')
<div class="col-md-10">
        <!-- Basic Form Elements Title -->

                <!-- Form Validation Example Block -->
                <div class="block">
                    <!-- Form Validation Example Title -->
                    <div class="block-title">
                        <h2> Créer une <strong>banque partenaire</strong></h2>
                            <a href="{{ route('banque.create') }}" class="btn btn-success pull-right"><span><i class="fa fa-plus"></i></span>Banque partenaire</a>
                    </div>
<div class="table-responsive">
    <table class="table table-vcenter table-condensed table-bordered listepdf">
        <thead>
                <tr>
                    <th>Nom</th>
                    <th>Telephone</th>
                    <th>Actions</th>
                </tr>
        </thead>
        <tbody>
            @foreach($banques as $banque)
                <tr>
                    <td>{{$banque->nom}}</td>
                    <td>{{$banque->telephone}}</td>
                    <td class="text-center">
                            <div class="btn-group">
                             {{-- @can('banque.update', Auth::user()) --}}
                                <a href="{{ route('banque.edit',$banque) }}" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                <a href="{{ route('banque.affecter',$banque) }}" data-toggle="tooltip" title="Affecter des entreprises" class="btn btn-xs btn-default"><i class="fa fa-plus"></i></a>

                            {{-- @endcan --}}
                            
                                {{-- <a href="#modal-lister-participant" onclick="idConfirm({{ $formation->id }});" data-toggle="modal" title="Lister les participants" class="btn btn-xs btn-success"><i class="fa fa-times"></i></a> --}}
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

