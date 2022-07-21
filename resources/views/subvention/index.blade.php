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
                        <h2> Liste des subventions accordées à <strong>{{ $entreprise->denomination }}</strong></h2>
                            <a href="#modal-add-subvention" data-toggle="modal" class="btn btn-success pull-right"><span><i class="fa fa-plus"></i></span>Subvention</a>
                            <a onclick='history.back()' class="btn btn-danger pull-right"><span><i class="fa fa-plus"></i></span>Fermer</a>
                    </div>
<div class="table-responsive">
    <table class="table table-vcenter table-condensed table-bordered listepdf">
        <thead>
                <tr>
                    <th>n°</th>
                    <th>Date</th>
                    <th>Montant de la subvention</th>
                    <th>Telecharger le reçu</th>
                </tr>
        </thead>
        <tbody>
            @php
                $i=0;
            @endphp
            @foreach($subventions as $subvention)
            @php
            $i++;
            @endphp
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{format_date($subvention->date_subvention)}}</td>
                    <td>{{format_prix($subvention->montant_subvention) }}</td>
                    <td>
                    <a href="{{ route('subvention.getRecu',$subvention)}}"title="télécharger" class="btn btn-xs btn-default"  target="_blank"><i class="fa fa-download"></i> </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
        </table>
</div>
    </div>
    </div>
@endsection
<div id="modal-add-subvention"  class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Enregistrer une subvention</h2>
            </div>
            <div class="modal-body">
                    <input type="hidden" name="id_table" id="id_table">
                        <form id="form-validation" method="POST"  action="{{route('subvention.store')}}" class="form-horizontal form-bordered"  enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="entreprise_id" value="{{ $entreprise->id }}">
                            <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="montant">Montant : <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input  name="montant" class="form-control CurrencyInput" id="montant_subvention"   placeholder="1 000 000" onchange="valider_montant({{ $entreprise->id }}, 'subvention');" required autofocus> 
                                            {{-- <input id="name" type="currency" min=0 class="form-control" name="montant" value="{{ old('montant') }}" required autofocus>  --}}
                                            <span class="input-group-addon"><i class="gi gi-money"></i></span>
                                    </div>
                                    <p style="color: red;" id="depassement_de_subvention">Le Montant de la subvention doit être inférieur au montant de la contrepartie versée par la bénéficiciare. Veillez vérifier le montant saisi.</p>
                                    @if ($errors->has('montant'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('montant') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="telephone">Date du virement<span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                            <input id="date" type="date" class="form-control" name="date" value="{{ old('date') }}" required autofocus>
                                            <span class="input-group-addon"><i class="gi gi-"></i></span>
                                    </div>
                                    @if ($errors->has('date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('date') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="telephone">Joindre le reçu de virement<span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input class="form-control col-md-6" type="file" name="copie_du_recu" id="copie_du_recu" accept=".pdf, .jpeg, .png"   placeholder="Joindre une copie du reçu de versement">
                                            <span class="input-group-addon"><i class="gi gi-"></i></span>
                                    </div>
                                    @if ($errors->has('date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('date') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        <div class="form-group form-actions">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" id="valider_subvention" class="btn btn-sm btn-sucess"><i class="fa fa-arrow-right"></i> Valider</button>
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                    </form>
                    

            </div>
            <!-- END Modal Body -->
        </div>
    </div>
</div>
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

       
    </script>
    

@endsection

