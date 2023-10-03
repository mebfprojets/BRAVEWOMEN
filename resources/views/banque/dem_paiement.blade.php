@extends('layouts.admin')
@section('beneficiaires_bank', 'active') 
@section('content')
<div class="col-md-12">
                <div class="block">
                    <!-- Form Validation Example Title -->
                    <div class="block-title">
                        <h2> Liste <strong>des demandes de paiements en attente de traitement</strong></h2>        
                    </div>
<div class="table-responsive">
     <table class="table table-vcenter table-condensed table-bordered listepdf">
        <thead>
                <tr>
                    <th>N</th>
                    <th>Num facture</th>
                    <th>Montant</th>
                    <th>Entreprise</th>
                    <th>Mode de paiement</th>
                    <th>Validée le</th>
                    <th>Actions</th>
                </tr>
        </thead>
        <tbody>
            @foreach($factures as $facture)
                <tr
                {{-- @if( return_diffdate(return_facture($facture->facture_id)->historique_validee->date_statut, today() )  > env('delais_de_traitement'))  --}}
                @if(return_diffdate($facture->date_de_validation, $facture->date_de_paiement) >1)
                style = "color:red"
                @else
                 style = "color:green"
                @endif
           
                >
                    <td>{{ return_diffdate($facture->date_de_validation, $facture->date_de_paiement) }}</td>
                    <td>{{$facture->num_facture}}</td>
                    <td>{{format_prix($facture->montant) }}</td>
                    <td>{{$facture->denomination}}</td>
                    <td>{{$facture->mode_de_paiement}}</td>
                    <td>{{format_date(return_facture($facture->facture_id)->historique_validee->date_statut)}}</td>
                    @if(return_facture($facture->facture_id)->historique_payee)
                        <td>{{format_date(return_facture($facture->facture_id)->historique_payee->date_statut)}}</td>
                        <td>
                            {{return_diffdate(return_facture($facture->facture_id)->historique_payee->date_statut, return_facture($facture->facture_id)->historique_validee->date_statut )}} 
                        </td>

                    @endif
                    <td class="text-center">
                        <div class="btn-group">
                            <a href="{{ route('facture.showById',$facture->facture_id) }}" data-toggle="tooltip" title="Visualiser" class="btn btn-lg btn-success"><i class="fa fa-eye"></i></a>
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

