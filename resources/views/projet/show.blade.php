@extends('layouts.admin')
@section('pca', 'active')
@section('analyse', 'active')
@section('content')
<div class="row">
<div class="col-md-6 offset-md-3">
    
</div>

</div>
<hr>
<div class="block">
    <div class="row">
        <div class="block-title">
            <div class="block-options pull-right">
                <a onclick="window.history.back();" class="btn btn-sm btn-success"><i class="fa fa-repeat"></i> Fermer</a>
                @if($projet->statut=='selectionné')
                <a href="#modal-save-desistement" data-toggle="modal" title="Enregistrer un désistement" class="btn btn-md btn-danger"><i class="fa fa-times"></i> Desister </a>
                @endif
                {{-- <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default toggle-bordered enable-tooltip" data-toggle="button" title="Toggles .form-bordered class"></a> --}}
            </div>
            <h2><strong>Detail</strong> sur le plan de continuité des Activité</h2>
        </div>
        <div class="col-md-7">
                    <div class="form-group row">
                        <div class="col-md-4">
                        <label>Coach :</label>
                        </div>
                        <div class="col-sm-7 mb-3 mb-sm-0">
                        <label class="fb"> {{$projet->coach->nom}} {{$projet->coach->prenom}}</label>
                        </div>
                    </div>
            
                    <div class="form-group row">
                        <div class="col-md-4">
                          <label>Titre du projet :</label>
                        </div>
                        <div class="col-sm-7 mb-3 mb-sm-0">
                          <label class="fb"> {{$projet->titre_du_projet}}</label>
                        </div>
                      </div>

                      <div class="form-group row">
                          <div class="col-sm-4">
                            <label>Coût total du projet :</label>
                          </div>
                          <div class="col-sm-7 mb-3 mb-sm-0">
                            <label class="fb"> {{ format_prix($projet->investissements->sum('montant'))   }} </label>
                          </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-4">
                      <label>Coût total du projet validé:</label>
                    </div>
                    <div class="col-sm-7 mb-3 mb-sm-0">
                      <label class="fb"> {{ format_prix($projet->investissementvalides->sum('montant_valide'))   }} </label>
                    </div>
                </div>
                  <div class="form-group row">
                    <div class="col-sm-4">
                      <label>Subvention demandée:</label>
                    </div>
                    <div class="col-sm-7 mb-3 mb-sm-0">
                      <label class="fb"> {{ format_prix($projet->investissements->sum('subvention_demandee'))   }} </label>
                    </div>
                 </div>
                 <div class="form-group row">
                    <div class="col-sm-4">
                      <label>Apport personnel :</label>
                    </div>
                    <div class="col-sm-7 mb-3 mb-sm-0">
                      <label class="fb"> {{ format_prix($projet->investissements->sum('apport_perso'))   }} </label>
                    </div>
                 </div>
                      <div class="form-group row">
                        <div class="col-sm-4">
                          <label>Les objectifs :</label>
                        </div>
                        <div class="col-sm-8 mb-3 mb-sm-0">
                          <label class="fb"> {{ $projet->objectifs }} </label>
                        </div>
                      </div>
                      
                      <div class="form-group row">
                          <div class="col-sm-4">
                            <label>Les activités ménées :</label>
                          </div>
                          <div class="col-sm-8 mb-3 mb-sm-0">
                            <label class="fb"> {{ $projet->activites_menees }} </label>
                          </div>
                      </div>
                      <div class="form-group row">
                          <div class="col-sm-4">
                            <label>Les Atouts du projet :</label>
                          </div>
                          <div class="col-sm-8 mb-3 mb-sm-0">
                            <label class="fb"> {{  $projet->innovation }}</label>
                          </div>
                      </div>
        </div>
    
         <h2>Evaluation</h2>
        <hr>
      
        <div class="col-md-5">
            @foreach ( $projet->evaluations as $evaluation)
            <div class="form-group row" >
                <div class="col-md-9">
                <label>{{ $evaluation->critere->libelle }} :</label>
                </div>
                <div class="col-sm-3 mb-3 mb-sm-0" style="color: red">
                <label class="fb"> {{$evaluation->note}}</label>
                </div>
            </div>
            @endforeach
            <div class="form-group row" >
                <div class="col-md-9">
                <label>Total:</label>
                </div>
                <div class="col-sm-3 mb-3 mb-sm-0" style="color: red">
                <label class="fb"> {{$projet->evaluations->sum('note')}}</label>
                </div>
            </div>
        
            <div class="form-group row" >
                <div class="col-md-9">
                <label>Statut:</label>
                </div>
                <div class="col-sm-3 mb-3 mb-sm-0" style="color: red">
                <label class="fb">
                 @empty($projet->statut)
                 Information non disponible
                    @else
                          {{$projet->statut}}
                 @endempty
                </label>
                </div>
            </div>
            <div class="form-group row" >
                <div class="col-md-9">
                <label>Observations:</label>
                </div>
                <div class="col-sm-3 mb-3 mb-sm-0" style="color: red">
                <label class="fb">
                 @empty($projet->observations)
                 Information non disponible
                    @else
                          {{$projet->observations}}
                 @endempty
                </label>
                </div>
            </div>
        
        </div> 
        <div class="row">
            <div class="col-md-6">
                <div class="col-md-6">
                    <label>Avis Chef de Zone:</label>
                    </div>
                    <div class="col-sm-6 mb-6 mb-sm-0" style="color: red">
                    <label class="fb"> {{$projet->avis_chefdezone}}</label>
                    </div>
                </div>
            <div class="col-md-6">
                <div class="col-md-6">
                    <label>Observation Chef de Zone:</label>
                    </div>
                    <div class="col-sm-6 mb-6 mb-sm-0" style="color: red">
                    <label class="fb"> {{$projet->observation_chefdezone}}</label>
                    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="col-md-6">
                    <label>Avis UGP:</label>
                    </div>
                    <div class="col-sm-6 mb-6 mb-sm-0" style="color: red">
                    <label class="fb"> {{$projet->avis_ugp}}</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="col-md-6">
                    <label>Observation UGP:</label>
                    </div>
                    <div class="col-sm-6 mb-6 mb-sm-0" style="color: red">
                    <label class="fb"> {{$projet->observation_ugp}}</label>
                </div>
            </div>
        </div>
    </div>
<div class="row">
    <table class="table table-vcenter table-condensed table-bordered  valdetail"   >
        <thead>
        <h4>Les investissements</h4>
                <tr>
                    <th>N°</th>
                    <th>Designation</th>
                    <th>Coût total</th>
                    <th>Subvention Demandée</th>
                    <th>Apport Personnel</th>
                    <th>Coût du projet validé</th>
                    <th>Subvention Accordée</th>
                    <th>Actions</th>
                </tr>
          </thead>
          <tbody id="tbadys">
    @foreach($projet->investissements as $key => $investissement)
    <tr>
            <td>
            {{ $key + 1 }}
            </td>
                 <td>
                    {{getlibelle($investissement->designation)}}
                </td>
                <td>
                    {{format_prix($investissement->montant)}}
                </td>
                <td>
                    {{format_prix($investissement->apport_perso)}}
                </td>
                <td>
                    {{format_prix($investissement->subvention_demandee)}}
                </td>
                <td>
                    {{format_prix($investissement->montant_valide)}}
                </td>
                <td>
                    {{format_prix($investissement->subvention_demandee_valide)}}
                </td>
    <td>
        {{-- <a href="#"title="télécharger" class="btn btn-xs btn-default"  target="_blank"><i class="fa fa-download"></i> </a>
        <a href="#"title="Visualiser le document" class="btn btn-xs btn-default" ><i class="fa fa-eye"></i> </a> --}}
    </td>

</tr>
@endforeach
</tbody>
</table>
</div>
                 
<hr>
</div>       
<div class="row">
    
    <div class="col-md-11">
        <div class="block">
        <div class="block-title">
          Documents au PCA
      </div>
        <div class="table-responsive">
            <table class="table table-vcenter table-condensed table-bordered listepdf valdetail"   >
                <thead>
                        <tr>
                            <th>N°</th>
                            <th>Type</th>
                            <th>Actions</th>
                        </tr>
                  </thead>
                  <tbody id="tbadys">
            @foreach($piecejointes as $key => $piecejointe)
            <tr>
                    <td>
                    {{ $key + 1 }}
                    </td>
                         <td>
                            {{getlibelle($piecejointe->type_piece)}}
                        </td>
            <td>
                <a href="{{ route('telechargerpiecejointe',$piecejointe->id)}}"title="télécharger" class="btn btn-xs btn-default"  target="_blank"><i class="fa fa-download"></i> </a>
                <a href="{{ route('detaildocument',$piecejointe->id)}}"title="Visualiser le document" class="btn btn-xs btn-default" ><i class="fa fa-eye"></i> </a>
            </td>
    
        </tr>
    @endforeach
    </tbody>
    </table>
          </div>
    </div>
</div>
</div>

@endsection
@section('modal_part')
<div id="modal-save-desistement" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Enregistrer un desistement</h2>
            </div>
            <div class="modal-body" style="margin-left:15px;">
                <form id="form-validation" method="POST"  action="{{ route('save_desistement_projet', $projet) }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="entreprise" id="id_entreprise_beneficaire" value="">
            <div class="row">
            <div class="form-group{{ $errors->has('libelle') ? ' has-error' : '' }} col-md-8">
                <label class=" control-label" for="declaration_desistement">Joindre la declaration<span class="text-danger">*</span></label>
                <input class="form-control col-md-6" type="file" name="declaration_desistement" id="declaration_desistement" accept=".pdf, .jpeg, .png" onchange="VerifyUploadSizeIsOK('declaration_desistement');" placeholder="Joindre une copie de la declaration de desistement" required>  
                    @if ($errors->has('declaration_desistement'))
                    <span class="help-block">
                        <strong>{{ $errors->first('declaration_desistement') }}</strong>
                    </span>
                    @endif
            </div>
            </div>   
                <div class="form-group form-actions">
                <div class="col-md-8 col-md-offset-4">
                    <a href="#" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
                    <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-arrow-right"></i> Enregistrer</button>
                </div>
            </div>
            </form>
        </div>
            </div>
            <!-- END Modal Body  modal-devis-edit -->
        </div>
    </div>
<div id="modal-evaluer-pca" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Evaluer le PCA</h2>
            </div>
            <div class="modal-body">
            <form method="post"  action="{{ route('pca.evaluation') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="projet" id="" value="{{ $projet->id }}">
                    @foreach ($criteres as $critere )
                        <div class="col-md-6" >
                            <div class="form-group">
                                <label class="control-label" for="example-username">{{ $critere->libelle}}</label>
                                    <input type="number" id="{{ $critere->id}}" name="{{ $critere->id}}" max="30" min="0" class="form-control" placeholder="Evaluer ..." required>
                            </div>
                            @if ($errors->has('note'))
                            <span class="help-block">
                                <strong>{{ $errors->first('note') }}</strong>
                            </span>
                            @endif
                        </div>  
                    
                    @endforeach
               
                <div class="form-group form-actions">
                    <div class="col-md-8 col-md-offset-4">
                        <a href="#" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
                        <button type="submit" class="btn btn-sm btn-success soumettre_facture" ><i class="fa fa-arrow-right"></i> Valider</button>
                    </div>
                </div>
            </form>      
            </div>
            <!-- END Modal Body -->
        </div>
    </div>
</div>
<div id="modal-add-fiche_danalyse" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Joindre la fiche d'analyse</h2>
            </div>
            <div class="modal-body">
            <form method="post"  action="{{ route('save.fiche_danalyse') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="entreprise" id="" value="{{ $projet->entreprise->id }}">
                <input type="hidden" name="projet" id="" value="{{ $projet->id }}">

                <div class="form-group{{ $errors->has('fiche_danalyse') ? ' has-error' : '' }} col-md-6" style="margin-left:10px;">
                    <label class="control-label" for="listedepresence">Joindre la fiche d'analyse <span class="text-danger">*</span></label>
                        <input class="form-control docsize"  type="file" name="fiche_danalyse" id="fiche_danalyse" accept=".pdf, .jpeg, .png"  onchange="VerifyUploadSizeIsOK('fiche_danalyse');" placeholder="Charger la fiche d'analyse">
                    @if ($errors->has('fiche_danalyse'))
                        <span class="help-block">
                            <strong>{{ $errors->first('fiche_danalyse') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group form-actions">
                    <div class="col-md-8 col-md-offset-4">
                        <button type="submit" class="btn btn-sm btn-success soumettre_facture" ><i class="fa fa-arrow-right"></i> Enregistrer</button>
                        <a href="#" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
                    </div>
                </div>
            </form>      
            </div>
            <!-- END Modal Body -->
        </div>
    </div>
</div>
<div id="valider_lanalyse" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Confirmation</h2>
            </div>
            <div class="modal-body">
                       <input type="hidden" name="projet_id" id="projet_id">
                        <p>Voulez-vous Confirmer l'analyse de ce dossier ?</p>
                    <div class="form-group form-actions">
                        <div class="text-right">
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-sm btn-primary" onclick="statuer_sur_lanalyse_du_pca();">OUI</button>
                        </div>
                    </div>
            </div>
            <!-- END Modal Body -->
        </div>
    </div>
</div>
<div id="rejetter_lanalyse" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Rejet de l'analyse du PCA</h2>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="projet_id" id="projet_id">
                    <label for="raison_du_rejet">Motif du rejet <span class="text-danger">* </span>: </label><textarea name="raison_du_rejet" id="raison_du_rejet" cols="60" rows="10" placeholder="Renseigner le motif du rejet de l'analyse du PCA"></textarea>
                </div>
                    <div class="form-group form-actions">
                        <div class="text-right">
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                            <button type="button" class="btn btn-sm btn-primary" onclick="statuer_sur_lanalyse_du_pca();">rejeter</button>
                        </div>
                    </div>
            </div>
            <!-- END Modal Body -->
        </div>
    </div>
</div>
<div id="modal-decision-comite-pca" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-check"></i> Decision du comité</h2>
            </div>
            <div class="modal-body">
                <input type="hidden" name="projet_id"  id='projet_comite' value="{{ $projet->id }}">
                <div class="form-group">
                  <label for="">Entrez les observations :</label>
                  <textarea id="observation" name="observation" placeholder="Observation" id="" cols="60" rows="10" onchange="activerbtn('btn_desactive','observation')" aria-describedby="helpId"></textarea>
                </div>
            <div class="form-group form-actions">
                <div class="text-right">
                    <button  class="btn btn-md btn-success btn_desactive" onclick="save_decision_comite('selectionné');" disabled>Selectionné</button>
                    <button class="btn btn-md btn-danger btn_desactive" onclick="save_decision_comite('rejeté');" disabled>Rejeté</button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
            <!-- END Modal Body -->
        </div>
    </div>
</div> 
@endsection
<script>
         function recupererprojet_id(id_projet){
            //alert(id_projet);
            document.getElementById("projet_id").setAttribute("value", id_projet);

    }
    function statuer_sur_lanalyse_du_pca(){
        $(function(){
            var projet_id= $("#projet_id").val();
            var raison= $("#raison_du_rejet").val();
            var url = "{{ route('pca.valider_analyse') }}";
            $.ajax({
                url: url,
                type:'GET',
                data: {projet_id: projet_id, raison:raison} ,
                error:function(){alert('error');},
                success:function(){
                    $('#modal-confirm-rejet').hide();
                    location.reload();
                }
            });
            });
    }
    function save_decision_comite(avis){
        var projet_id= $("#projet_comite").val();
        var observation= $("#observation").val();
        var url = "{{ route('pca.savedecisioncomite') }}";
        $.ajax({
                url: url,
                type:'GET',
                data: {projet_id: projet_id, observation:observation, avis:avis} ,
                error:function(){alert('error');},
                success:function(){
                    $('#modal-confirm-rejet').hide();
                    location.reload();
                }
            });

    }
    
</script>
