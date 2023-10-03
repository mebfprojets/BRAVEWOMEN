@extends('layouts.admin')
@section('administration', 'active')
@section('administration-banque', 'active')
@section('content')
<div class="col-md-10">
                <div class="block">
                    <!-- Form Validation Example Title -->
                    <div class="block-title">
                        <h2> Liste des subventions accordées à <strong>{{ $entreprise->denomination }}</strong></h2>
                            <a href="#modal-add-subvention"  onclick="initialiser_subvention_id('subvention_modif')"  data-toggle="modal" class="btn btn-success pull-right"><span><i class="fa fa-plus"></i></span>Subvention</a>
                            <a href="{{ route('banque.beneficiaires') }}" class="btn btn-danger pull-right"><span><i class="fa fa-times"></i></span>Fermer</a>
                    </div>
<div class="table-responsive">
    <table class="table table-vcenter table-condensed table-bordered listepdf">
        <thead>
                <tr>
                    <th>n°</th>
                    <th>Date</th>
                    <th>Montant de la subvention</th>
                    <th>Telecharger le reçu</th>
                    <th>Action</th>
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
                    <td>
                        @if(count($entreprise->factures) >0)
                            <a href="#modal-edit-subvention" data-toggle="modal"  title="télécharger" class="btn btn-xs btn-success"  target="_blank"><i class="fa fa-pencil" onclick="edit_subvention('{{ $subvention->id }}')"></i> </a>
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
                                        <input  name="montant" type="text" class="form-control " id="montant_create"   placeholder="1 000 000" onchange="valider_montant('montant_create',{{ $entreprise->id }}, 'subvention_modif');" required autofocus> 
                                            {{-- <input id="name" type="currency" min=0 class="form-control" name="montant" value="{{ old('montant') }}" required autofocus>  --}}
                                            <span class="input-group-addon"><i class="gi gi-money"></i></span>
                                    </div>
                                    <p style="color: red; display:none;" class="depassement_de_subvention">Le Montant de la subvention doit être inférieur au montant de la contrepartie versée par la bénéficiciare. Veillez vérifier le montant saisi.</p>
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
                                            <input id="date" type="text" class="form-control input_banque" name="date" value="{{ old('date') }}" data-date-format="dd-mm-yyyy" required autofocus>
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
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                            <button type="submit" id="valider_subvention" class="btn btn-sm btn-sucess valider_subvention"><i class="fa fa-arrow-right"></i> Valider</button>

                        </div>
                    </div>
                    </form>
            </div>
            <!-- END Modal Body -->
        </div>
    </div>
</div>
<div id="modal-edit-subvention"  class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Modifier une subvention</h2>
            </div>
            <div class="modal-body">
                    <input type="hidden" name="id_table" id="id_table">
                        <form id="form-validation" method="POST"  action="{{route('subvention.modifier')}}" class="form-horizontal form-bordered"  enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="id_subvention" id="subvention_modif">
                            <input type="hidden" id="entreprise_id" name="entreprise_id" value="{{ $entreprise->id }}">
                            <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="montant">Montant : <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input  name="montant" type="text" class="form-control " id="montant_update"   placeholder="1 000 000" onchange="valider_montant('montant_update', {{ $entreprise->id }}, 'subvention_modif');" required autofocus> 
                                            <span class="input-group-addon"><i class="gi gi-money"></i></span>
                                    </div>
                                    <p style="color: red; display:none;" class="depassement_de_subvention" >Le Montant de la subvention doit être inférieur au montant de la contrepartie versée par la bénéficiciare. Veillez vérifier le montant saisi.</p>
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
                                            <input id="date_update" type="text" class="form-control input_banque" name="date" value="{{ old('date') }}" data-date-format="dd-mm-yyyy" required autofocus>
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
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                            <button type="submit" id="valider_subvention" class="btn btn-sm btn-sucess valider_subvention"><i class="fa fa-arrow-right"></i> Valider</button>

                        </div>
                    </div>
                    </form>
                    

            </div>
            <!-- END Modal Body -->
        </div>
    </div>
</div>
@section('modalSection')  
   
@endsection
@section('script_additionnel')

<script>
     function initialiser_subvention_id(champ){
        $("#"+champ).val(0);
    }
        function edit_subvention(id){
                var id=id;
                var url = "{{ route('subvention.editer') }}";
                $.ajax({
                    url: url,
                    type:'GET',
                    dataType:'json',
                    data: {id: id} ,
                    error:function(){alert('error');},
                    success:function(data){
                        $("#subvention_modif").val(data.id);
                        $("#montant_update").val(data.montant);
                        $("#date_update").val(data.date_subvention);
                    }
                });
        }
    function format_montant(id){
    //alert(id);
var val= $('#'+id).val();
$('#montant_devi_cache').val(val);
var index = val.indexOf("XOF");
if(index !== -1){
    newval= val;
}
else{
    var val1= val.split(" ").join("");
    // var newval= new Intl.NumberFormat('fr', {unitDisplay: 'long'}).format(val1);
     var newval= new Intl.NumberFormat('fr', {
     style: 'currency',
   currency: 'XOF',
     }).format(val1);
}

$('#'+id).val(newval);
}
    function valider_montant(montant_subvention, entreprise_id, id_subvention){
          $(function(){
             var subvention= $("#"+id_subvention).val();
            // alert(subvention);
              var montant_subventionn= $("#"+montant_subvention).val(); 
              var url = "{{ route('valider_montant') }}";
              $.ajax({
                  url: url,
                  type:'GET',
                  data: {montant: montant_subventionn, id_entreprise: entreprise_id, id_subvention:subvention} ,
                  error:function(){alert('error');},
                  success:function(data){
                     if(data == 2){
                       // alert(2);
                        $(".depassement_de_subvention").show();
                        $(".valider_subvention").prop('disabled', true);
                        format_montant(montant_subvention);
                     }else{
                        $(".depassement_de_subvention").hide();
                        $(".valider_subvention").prop('disabled', false);
                         format_montant(montant_subvention);
                     }
                    
                  }
              });
              });
      }
  </script>
@endsection
