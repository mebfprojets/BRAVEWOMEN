@extends('layouts.admin')
@section('finacement', 'active')
@section('facture_payees', 'active')
@section('content')
<div class="col-md-12">
        <!-- Basic Form Elements Title -->
                <!-- Form Validation Example Block -->
                <div class="block">
                    <!-- Form Validation Example Title -->
                    <div class="block-title">
                        <h2> Liste <strong>des factures payées</strong></h2>        
                    </div>
<div class="table-responsive">
     <table class="table table-vcenter table-condensed table-bordered listepdf">
        <thead>
                <tr>
                    <th>N</th>
                    <th>Zone</th>
                    <th>Banque</th>
                    <th>Num facture</th>
                    <th>Num devis</th>
                    <th>Entreprise</th>
                    <th>Statut</th>
                    <th>Montant</th>
                    <th>Mode de paiement</th>
                    <th>Actions</th>
                </tr>
        </thead>
        <tbody>
                @php
                    $i=0;
                @endphp
            @foreach($factures as $facture)
                    @php
                        $i++;
                    @endphp
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{getlibelle($facture->devi->entreprise->region)}}</td>
                    <td>{{$facture->devi->entreprise->banque->nom}}</td>
                    <td>{{$facture->num_facture}}</td>
                    <td>
                        <a href="{{ route('devi.show',$facture->devi) }}" title="Visualiser" target="_blank" >
                            @if($facture->devi->numero_devis)
                            {{$facture->devi->numero_devis}}
                            @else
                            Non defini
                            @endif
                        </a>
                    </td>
                    <td>{{$facture->devi->entreprise->denomination}}</td>
                    <td>{{$facture->statut}}</td>
                    <td>{{ format_prix($facture->montant)}}</td>
                    <td>{{$facture->mode_de_paiement}}</td>
                    <td class="text-center">
                            <div class="btn-group">
                             {{-- @can('formation.update', Auth::user()) --}}
                                <a href="{{ route('facture.show',$facture) }}" data-toggle="tooltip" title="Visualiser" class="btn btn-lg btn-success"><i class="fa fa-eye"></i></a>
                                @can('parametre.create', Auth::user())
                                    <a href="{{ route('facture.rejete',$facture) }}" data-toggle="tooltip" title="Visualiser" class="btn btn-lg btn-danger"><i class="fa fa-times"></i></a>
                                 @endcan 
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

