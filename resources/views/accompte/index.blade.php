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
                        <h2> Situation de la contrepartie versée par <strong>{{ $entreprise->denomination }}</strong></h2>
                            <a href="#modal-add-account" data-toggle="modal" onclick="initialiser_contrepartie_id('contrepartie_modif')" class="btn btn-success pull-right"><span><i class="fa fa-plus"></i></span>Contrepartie</a>
                            <a  href="{{ route('banque.beneficiaires') }}"  class="btn btn-danger pull-right"><span><i class="fa fa-plus"></i></span>Fermer</a>
                    </div>
<div class="table-responsive">
    <table class="table table-vcenter table-condensed table-bordered listepdf">
        <thead>
                <tr>
                    <th>n°</th>
                    <th>Date</th>
                    <th>Montant versé</th>
                    <th>Telecharger le reçu</th>
                    <th>Actions</th>
                </tr>
        </thead>
        <tbody>
            @php
                $i=0;
            @endphp
            @foreach($accomptes as $accompte)
            @php
            $i++;
            @endphp
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{format_date($accompte->date_versement)}}</td>
                    <td>{{format_prix($accompte->montant) }}</td>
                    <td>
                    <a href="{{ route('account.getRecu',$accompte)}}" title="télécharger" class="btn btn-xs btn-default"  target="_blank"><i class="fa fa-download"></i> </a>
                    </td>
                    <td>
                    @if(count($entreprise->factures)==0)
                        <a href="#modal-edit-account" data-toggle="modal" title="télécharger" class="btn btn-xs btn-success"  target="_blank"><i class="fa fa-pencil" onclick="edit_accompte('{{ $accompte->id }}')"></i> </a>
                    @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
        </table>
</div>
    </div>
    </div>
@endsection
@section('modal_part')
<div id="modal-add-account"  class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Enregistrer un versement de contrepartie</h2>
            </div>
            <!-- END Modal Header -->

            <!-- Modal Body -->
            <div class="modal-body">
                    <input type="hidden" name="id_table" id="id_table">
                        <form id="form-validation" method="POST"  action="{{route('accompte.store')}}" class="form-horizontal form-bordered"  enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" id="entreprise_id" name="entreprise_id" value="{{ $entreprise->id }}">
                            <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="montant">Montant : <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                            <input id="montant" type="text" class="form-control" name="montant" placeholder="Saisir le montant"  onchange="verifier_montant_accompte('montant','entreprise_id','contrepartie_modif')"  required autofocus>
                                        {{-- <input type="currency" value="1000" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="currency" id="c1" /> --}}
                                            <span class="input-group-addon"><i class="gi gi-money"></i></span>
                                    </div>
                                    @if ($errors->has('montant'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('montant') }}</strong>
                                    </span>
                                    @endif
                                <span class='depassement_du_montant_accompte' style="color:red; display:none;"><p>Le comptant de versement de la contrepartie ne doit pas etre supérieur au total de la contrepartie attendue</p></span>

                                </div>

                            </div>
                            <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="telephone">Date de versement<span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                            <input id="name" type="input" class="form-control input_banque" name="date" value="{{ old('date') }}" data-date-format="dd-mm-yyyy" required autofocus>
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
                                <label class="col-md-4 control-label" for="telephone">Joindre le reçu de versement<span class="text-danger">*</span></label>
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
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-sm btn-sucess valider"><i class="fa fa-arrow-right"></i> Valider</button>

                        </div>
                    </div>
                    </form>
                    

            </div>
            <!-- END Modal Body -->
        </div>
    </div>
</div>
<div id="modal-edit-account"  class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Modifier un versement de contrepartie</h2>
            </div>
            <div class="modal-body">
                        <form id="form-validation" method="POST"  action="{{route('accompte.modif')}}" class="form-horizontal form-bordered"  enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="id_contrepartie" id="contrepartie_modif">
                            <input type="hidden" id="entreprise_id" name="entreprise_id" value="{{ $entreprise->id }}">
                            <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="montant">Montant : <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                            <input id="montant_contrepartie" type="text" class="form-control" name="montant" placeholder="Saisir le montant"  onchange="verifier_montant_accompte('montant_contrepartie','entreprise_id','contrepartie_modif')"  required autofocus>
                                            <span class="input-group-addon"><i class="gi gi-money"></i></span>
                                    </div>
                                    @if ($errors->has('montant'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('montant') }}</strong>
                                    </span>
                                    @endif
                                <span class='depassement_du_montant_accompte' style="color:red; display:none;"><p>Le comptant de versement de la contrepartie ne doit pas etre supérieur au total de la contrepartie attendue</p></span>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="telephone">Date de versement<span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                            <input id="date_contrepartie" type="input" class="form-control input_banque" name="date" value="{{ old('date') }}" data-date-format="dd-mm-yyyy" required autofocus>
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
                                <label class="col-md-4 control-label" for="telephone">Joindre le reçu de versement<span class="text-danger">*</span></label>
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
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-sm btn-sucess valider"><i class="fa fa-arrow-right"></i> Modifier</button>
                        </div>
                    </div>
                    </form>
            </div>
        </div>
    </div>
</div>
@endsection
    @section('script_additionnel')
        <script>
    function initialiser_contrepartie_id(champ){
        $("#"+champ).val(0);
    }
        function edit_accompte(id){
                var id=id;
                var url = "{{ route('entreprise.accompte.edit') }}";
                $.ajax({
                    url: url,
                    type:'GET',
                    dataType:'json',
                    data: {id: id} ,
                    error:function(){alert('error');},
                    success:function(data){
                       // alert(data.montant)
                        $("#contrepartie_modif").val(data.id);
                        $("#montant_contrepartie").val(data.montant);
                        $("#date_contrepartie").val(data.date_versement);
                    }
                });
        }
    function verifier_montant_accompte(montant_id, entreprise_id, accompte_id ){
        var id_contrepartie= $("#"+accompte_id).val();
        var montant= $("#"+montant_id).val();
        var entreprise_id= $("#"+entreprise_id).val();
        var url = "{{ route('verifier_montant_accompte') }}";
        $.ajax({
                 url: url,
                  type: 'GET',
                  data: {montant: montant, entreprise_id:entreprise_id, id_contrepartie:id_contrepartie},
                  dataType: 'json',
                  error:function(data){alert("Erreur");},
                  success: function (data) {
                   if(data==1){
                        //   $(".depassement_du_montant_accompte").show();
                        //     $(".valider").prop('disabled', true);
                          format_montant(montant_id);
                   }
                   else{
                        // $(".depassement_du_montant_accompte").hide();
                        //   $(".valider").prop('disabled', false);
                          format_montant(montant_id);
                   }
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

