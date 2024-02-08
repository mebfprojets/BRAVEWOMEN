@extends('layouts.admin')
@section('finacement', 'active')
@section('devis', 'active')
@section('content')
<div class="row">
  <div class="col-md-4 document_style">
    <a class="" target="_blank" href="{{ route("telechargerdevis", $devi->id) }}?file=fiche">
      <span ><img src="{{ asset('img/upload_img.jpeg') }}" alt="" width="35"></span> <span><p>Fiche d'analyse</p></span>
    </a>
  </div>
  <div class="col-md-3 document_style">
    <a  target="_blank"  href="{{ route("telechargerdevis", $devi->id) }}?file=devi1">
      <span ><img src="{{ asset('img/upload_img.jpeg') }}" alt="" width="35"></span> <span><p>Devis conccurent 1</p></span>
    </a>
  </div>
  <div class="col-md-3 document_style">
    <a target="_blank" href="{{ route("telechargerdevis", $devi->id) }}?file=devi2">
      <span ><img src="{{ asset('img/upload_img.jpeg') }}" alt="" width="35"></span> <span><p>Devis conccurent 2</p></span>
    </a>
  </div>
</div>
<div class="col-md-12">
    <div class="block">
        <div class="block-title">
            <div class="block-options pull-right">
                <a onclick="window.history.back();" class="btn btn-sm btn-success"><i class="fa fa-repeat"></i> Fermer</a>

                {{-- <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default toggle-bordered enable-tooltip" data-toggle="button" title="Toggles .form-bordered class"></a> --}}
            </div>
            <h2><strong>Detail</strong> du devis</h2>
        </div>
      
        @if($devi->statut=='validé')
        <div class="row">
          <div class="row col-md-offset-2">
            <label class="col-md-7 control-label">Montant des demandes de paiement soumis : </label> <div class="col-md-5"> <span> {{ format_prix($devi->factures_soumis()->sum("montant")) }}</span></div>
        </div>
        <div class="row col-md-offset-2">
            <label class="col-md-7 control-label">Montant des paiements effectués : </label> <div class="col-md-5"> <span> {{ format_prix($devi->factures_payees()->sum("montant")) }}</span></div>
        </div>
        <div class="row col-md-offset-2">
            <label class="col-md-7 control-label">Reste à payer : </label> <div class="col-md-5"> <span> {{ format_prix( $devi->montant_devis - $devi->factures()->sum("montant") )  }}</span></div>
   
        </div>  
        <hr>
        </div>

        
        @endif

        <div class="table-responsive">
                    <div class="col-lg-4">
                            <!-- Nom document -->
                            {{-- <div class="form-group row">
                                <div class="col-sm-4">
                                  <label>Ligne concernée:</label>
                                </div>
                                <div class="col-sm-8 mb-3 mb-sm-0">
                                  <label class="fb"> {{ getlibelle($devi->ligneinvestissement->designation) }}</label>
                                </div>
                              </div> --}}
                            <div class="form-group row">
                              <div class="col-sm-4">
                                <label>Designation:</label>
                              </div>
                              <div class="col-sm-8 mb-3 mb-sm-0">
                                <label class="fb"> {{ $devi->designation }}</label>
                              </div>
                            </div>
                            <div class="form-group row">
                              <div class="col-sm-4">
                                <label>Description:</label>
                              </div>
                              <div class="col-sm-8 mb-3 mb-sm-0">
                                <label class="fb"> {{ $devi->description }}</label>
                              </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-4">
                                  <label>Montant:</label>
                                </div>
                                <div class="col-sm-8 mb-3 mb-sm-0">
                                  <label class="fb"> {{ format_prix($devi->montant_devis) }} </label>
                                </div>
                        </div>
                            <div class="form-group row">
                              <div class="col-sm-4">
                                <label>Avance demandée:</label>
                              </div>
                              <div class="col-sm-8 mb-3 mb-sm-0">
                                <label class="fb"> {{ format_prix($devi->montant_avance) }} </label>
                              </div>
                            </div>
                            <div class="form-group row">
                              <div class="col-sm-4">
                                <label>Taux de réalisation:</label>
                              </div>
                              <div class="col-sm-8 mb-3 mb-sm-0">
                                <label class="fb"> {{ $devi->taux_de_realisation}} % </label>
                              </div>
                            </div>
                            <div class="form-group row">
                              <div class="col-sm-4">
                                <label>Nombre de paiement souhaité:</label>
                              </div>
                              <div class="col-sm-8 mb-3 mb-sm-0">
                                <label class="fb"> {{$devi->nombre_de_paiement}}</label>
                              </div>
                          </div>
                            <div class="form-group row">
                                <div class="col-sm-4">
                                  <label>Nom du prestataire:</label>
                                </div>
                                <div class="col-sm-8 mb-3 mb-sm-0">
                                  <label class="fb"> {{$devi->prestataire->code_prestaire}} {{ $devi->prestataire->nom_responsable }} {{$devi->prestataire->prenom_responsable}}</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-4">
                                  <label>N de compte:</label>
                                </div>
                                <div class="col-sm-8 mb-3 mb-sm-0">
                                  <label class="fb"> {{ $devi->compte_bank_prestataire }} à la {{ $devi->nom_bank_prestataire }} </label>
                                </div>
                            </div>
                            <hr>
                            

                    </div>
                    <div class="col-lg-8 img-bg" style="cursor: pointer;">
                            <div style="box-shadow: 1px 2px 5px 1px #999">
                              <embed src= "{{ Storage::disk('local')->url($devi->copie_devis_prefere ) }}" height=600 type='application/pdf' style="width: 100%;" />
                        </div>

                    </div>
        </div>
                </div>
</div>
@if(count($devi->factures) !=0)
    <div class="col-md-12">
      <div class="block">
      <div class="block-title">
          Demandes de paiments du devis
      </div>
      <div class="block">
        <div class="table-responsive">
          <table  class="table table-vcenter table-condensed table-bordered listepdf">
              <thead>
                      <tr>
                          <th>Numéro</th>
                          <th>Montant</th>
                          <th>Statut</th>
                          <th>Actions</th>
                      </tr>
              </thead>
              <tbody>
                  @foreach($devi->factures as $facture)
                      <tr>
                          <td>{{ $facture->num_facture }}</td>
                          <td>{{ format_prix($facture->montant) }}</td>
                          <td>{{ $facture->statut }}</td>
                          <td>
                            <a href="{{ route('facture.show',$facture) }}" data-toggle="tooltip" title="Visualiser" class="btn btn-lg btn-success"><i class="fa fa-eye"></i></a>
                            @if($facture->statut=='payée')
                              <a target="_blank" href="{{ route("telechargerfacture", $facture->id) }}?file=recu_paiement" title="Visualiser le reçu de paiement" class="btn btn-lg btn-default"><i class="fa fa-file-o"></i></a>
                            @endif
                          </td>
                      </tr>
                  @endforeach
              </tbody>
              </table>
          </div>
    </div>
    </div>
    </div>
@endif
<div class="col-md-12">
  <div class="block">
  <div class="block-title">
      Historique de traitement
  </div>
  <div class="block">
    <div class="table-responsive">
      <table  class="table table-vcenter table-condensed table-bordered listepdf">
          <thead>
                  <tr>
                      
                      <th>Utilisateur</th>
                      <th>statut</th>
                      <th>Observations</th>
                      <th>Date</th>
                  </tr>
          </thead>
          <tbody>
              @foreach($historiques as $historique)
                  <tr>
                      <td>{{ getusername($historique->user_id) }}</td>
                      <td>{{ $historique->statut }}</td>
                      <td>{{ $historique->observation }}</td>
                      <td>{{ format_date($historique->date_statut) }}</td>
                  </tr>
              @endforeach
          </tbody>
          </table>
      </div>
</div>
</div>
</div>
@endsection

<div id="modal-confirm-devis" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Confirmer la validation du devis</h2>
            </div>
            <div class="modal-body">
                       <input type="hidden" name="id_entreprise" id="id_entreprise">
                        <p>Confirmez-vous la validation du devis ?</p>
                    <div class="form-group form-actions">
                        <div class="text-right">
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                            <button type="button" class="btn btn-sm btn-primary" onclick="changer_statut_devis();">OUI</button>
                        </div>
                    </div>

            </div>
            <!-- END Modal Body -->
        </div>
    </div>
</div>
<div id="modal-rejeter_devis" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Rejet du devis</h2>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="id_entreprise" id="id_entreprise">
                    <label for="raison_du_rejet">Motif du rejet <span class="text-danger">* </span>: </label><textarea name="raison_du_rejet" id="raison_du_rejet" cols="60" rows="10" placeholder="renseigner le motif du rejet du devis"></textarea>
                </div>
               
                    <div class="form-group form-actions">
                        <div class="text-right">
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                            <button type="button" class="btn btn-sm btn-primary" onclick="changer_statut_devis();">rejeter</button>
                        </div>
                    </div>
                
            </div>
            <!-- END Modal Body -->
        </div>
    </div>
</div>
<script>
     function changer_statut_devis(){
        $(function(){
            var devi_id= $("#id_entreprise").val();
            var raison= $("#raison_du_rejet").val();
            var url = "{{ route('devi.changerstatus') }}";
            $.ajax({
                url: url,
                type:'GET',
                data: {devi_id: devi_id, raison:raison} ,
                error:function(){alert('error');},
                success:function(){
                    $('#modal-confirm-rejet').hide();
                    location.reload();
                }
            });
            });
    }
</script>
