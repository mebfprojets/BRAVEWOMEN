@extends('layouts.admin')
@section($active_principal, 'active')
@section($active, 'active')
@section('content')
<div class="block full">
    <div class="block-title">
        <h2><strong>Liste</strong> des souscriptions {{ $titre }}</h2>
        @can('user.create', Auth::user())
                            <a href="{{ route('generer.excel') }}" class="btn btn-success pull-right"><span><i class="fa fa-plus"></i></span> Générer en excel</a>
        @endcan
    </div>
    <div class="table-responsive">
        <table id="" class="table table-vcenter table-condensed table-bordered listepdf">
            <thead>
                <tr>
                    <th class="text-center">N°</th>
                    <th class="text-center" style="width:10px;" >Zone</th>
                    <th class="text-center" style="width:10px;" >Code promoteur</th>
                    <th class="text-center">Nom & Prenom</th>
                    <th class="text-center">Télephone</th>
                    <th class="text-center">Entreprise</th>
                    <th class="text-center">Score</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                  $i=0;
                @endphp
                @foreach ($entreprises as $entreprise)
                        @php
                           $i++;
                        @endphp
                    <tr  
	@if($entreprise->conforme != null && $entreprise->decision_ugp   == null )
            style="color:orange;"
	@elseif($entreprise->conforme != null && $entreprise->decision_ugp   != null)
		style="color:green;"

        @endif>
                         <td class="text-center" style="width: 2%">{{ $i }}</td>
                         <td class="text-center" style="width: 5%;" >
                            {{ getlibelle($entreprise->region) }}
                        </td>
                        <td class="text-center" style="width: 5%;" >
                            {{ $entreprise->promotrice->code_promoteur }}
                        </td>
                        <td class="text-center" style="width: 5%;">{{ $entreprise->promotrice->nom }} {{ $entreprise->promotrice->prenom }}</td>
                        <td class="text-center" style="width: 5%;">{{ $entreprise->promotrice->telephone_promoteur }}</td>
                        <td class="text-center" style="width: 5%;">
                            {{-- <a href="{{ route("entreprise.edit", $entreprise) }}"> {{ $entreprise->denomination }} </a> --}}
                           {{ $entreprise->denomination }}
                        </td>
                        <td class="text-center" style="width: 5%;">
                           {{ $entreprise->noteTotale }}
                        </td>
                        {{-- <td class="text-center">{{ $entreprise->secteur_activite }}</td> --}}
                        {{-- <td class="text-center">
                            <a href="{{ route("projet.edit",$entreprise->projet->id) }}">Detail sur le projet</a>
                        </td> --}}
                        <td class="text-center" style="width: 7%;">
                            <div class="btn-group">
                                {{-- <a href="" data-toggle="tooltip" title="Editer" class="btn btn-md btn-default"><i class="fa fa-pencil"></i></a> --}}
                                <a href="{{ route("entreprise.show",$entreprise) }}" data-toggle="tooltip" title="Visualiser" class="btn btn-md btn-primary"><i class="fa fa-eye"></i></a>
                                {{-- @if(Auth::user()->zone== $entreprise->region)
                                    <a href="{{ route("generer.recepisse", $entreprise->promotrice->slug) }}" data-toggle="tooltip" title="Imprimer le recepissé" class="btn btn-md btn-default"><i class="fa fa-print"></i></a>
                                    <a href="#modal-confirm-send_synthese" onclick="delConfirm({{ $entreprise->id }});" data-toggle="modal" title="Envoyer la fiche de synthèse" class="btn btn-md btn-primary"><i class="fa fa-paper-plane"></i></a>
                                    @can('entreprise.geolocalise', Auth::user())
                                        <a href="#" class="text-center" onclick="localiser({{ $entreprise->id }});"><i class="fa fa-map-marker"></i></a>
                                    @endcan
                                @endif --}}
                                {{-- <a href="" data-toggle="tooltip" title="Imprimer" class="btn btn-md btn-default"><i class="fa fa-print"></i></a> --}}
                                {{-- @can('souscription.statuerSurSouscription', Auth::user())
                                    <a href="#modal-confirm-rejet" data-toggle="modal" onclick="confirmChangeStatus1({{$entreprise->id}}, {{ Auth::user()->id }})" title="rejeter" class="btn btn-md btn-danger"><i class="fa fa-times"></i></a>
                                    <a href="#modal-confirm-changestatus" data-toggle="modal" onclick="confirmChangeStatus1({{$entreprise->id}}, {{ Auth::user()->id }})" title="Valider" class="btn btn-md btn-success"><i class="fa fa-check"></i></a>
                                @endcan --}}
                                <a href="{{ route("generer.recepisse", $entreprise->promotrice->slug) }}" data-toggle="tooltip" title="Modifier la souscription" class="btn btn-md btn-default"><i class="hi hi-edit"></i></a>
                             
                                    {{-- @if($entreprise->conforme== null)
                                    @can('avisqualitative_ugp', Auth::user())
                                        <a href="#modal-confirm-ugp" data-toggle="modal" onclick="recupererentreprise_id({{$entreprise->id}}, 0)" title="non conforme" class="btn btn-md btn-warning"><i class="gi gi-remove_2"></i></a>
                                        <a href="#modal-confirm-ugp" data-toggle="modal" onclick="recupererentreprise_id({{$entreprise->id}}, 1)"  title="conforme" class="btn btn-md btn-success"><i class="fa fa-check"></i></a>
                                    @endcan
                                    @endif
                                 @if($entreprise->conforme!=null && $entreprise->decision_ugp==null) 
                                 @can('avisfinal_ugp', Auth::user()) 
                                    <a href="#modal-decision-de-ugp" data-toggle="modal" onclick="recupererentreprise_id({{$entreprise->id}})" title="La décision de l'ugp" class="btn btn-md btn-danger avis_ugp"><i class="fa fa-check-square-o"></i></a>
                                 @endcan 
                               @endif  --}}
                                @if(proportionpromoteur_enregistre($entreprise->promotrice->id)==1 && Auth::user()->zone== $entreprise->region)
                                    <a href="{{ route("promotrice.completeinfo", $entreprise) }}" data-toggle="tooltip" title="Completer les informations" class="btn btn-md btn-default"><i class="fa fa-info"></i></a>
                                @endif
                                {{-- <a  href="#modal-confirm-delete" onclick="delConfirm({{ $parametre->id }});" data-toggle="modal" title="Supprimer" class="btn btn-md btn-danger"><i class="fa fa-times"></i></a> --}}
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
{{-- <div id="modal-decision-de-ugp" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <!-- Modal Header -->
              <div class="modal-header text-center">
                  <h2 class="modal-title"><i class="fa fa-check"></i> Avis de l'UGP</h2>
              </div>
              <div class="modal-body">
                  <input type="hidden" name="id_entreprise" id="id_entreprise1">
                  <div class="form-group">
                    <label for="">Entrez les observations :</label>
                    <textarea id="observation" name="observation" placeholder="Observation" id="" cols="60" rows="10" onchange="activerbtn('btn_desactive','observation')" aria-describedby="helpId"></textarea>
                  </div>
              <div class="form-group form-actions">
                  <div class="text-right">
                      <button  class="btn btn-md btn-danger btn_desactive" onclick="save_avis_ugp('inéligible');" disabled>Inéligible</button>
                      <button class="btn btn-md btn-success btn_desactive" onclick="save_avis_ugp('éligible');" disabled>Eligible</button>
                      <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                  </div>
              </div>
          </div>
              <!-- END Modal Body -->
          </div>
      </div>
  </div>
<div id="modal-confirm-ugp" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <!-- Modal Header -->
              <div class="modal-header text-center">
                   <h2 class="modal-title"><i class="fa fa-pencil"></i> Apprecier la conformité qualititative</h2>
              </div>
              <div class="modal-body">
                  <input type="hidden" name="id_entreprise" id="id_entreprise1">
                  <input type="hidden" name="conformite" id="conformite">
                  <p class="modal-text">Cette action donnera un avis de l'UGP sur la conformité qualitative de la promoteur. Voulez-vous continuer?</p>
              <div class="form-group form-actions">
                  <div class="text-right">
                      <button type="submit" class="btn btn-sm btn-danger" onclick="saveconformite_souscription();">Valider</button>
                      <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Annnuler</button>
                  </div>
              </div>
          </div>
          </div>
      </div>
  </div> --}}
<script>
  // ('.avis_ugp').hide();

    function recupererentreprise_id(id_entreprise,conforme){
        
            document.getElementById("id_entreprise").setAttribute("value", id_entreprise);
            document.getElementById("conformite").setAttribute("value", conforme);
    }
    function saveconformite_souscription(){
        $(function(){
            var id_entreprise= $("#id_entreprise").val();
            var conforme= $("#conformite").val();
            var url = "{{ route('souscription.saveconformite') }}";
            $.ajax({
                url: url,
                type:'GET',
                data: {id_entreprise: id_entreprise, conforme : conforme} ,
                error:function(){alert('error');},
                success:function(){
                    $('#modal-confirm-ugp').hide();
                    location.reload();
                    
                }
            });
            });
    }
    function save_avis_ugp(avis){
        var id_entreprise= $("#id_entreprise").val();
        var observation= $("#observation").val();
        var url = "{{ route('souscription.savedecisionugp') }}";
        $.ajax({
                url: url,
                type:'GET',
                data: {id_entreprise: id_entreprise, observation:observation, avis:avis} ,
                error:function(){alert('error');},
                success:function(){
                    $('#modal-decision-de-ugp').hide();
                    location.reload();
                }
            });

    }
    function rejeterdossier(){
        $(function(){
            var id_entreprise= $("#id_entreprise").val();
            var id_user= $("#id_user").val();
            var raison= $("#raison_du_rejet").val();
            var url = "{{ route('entreprise.statuermembrecomite') }}";
            $.ajax({
                url: url,
                type:'GET',
                data: {id_entreprise: id_entreprise, id_user : id_user, raison:raison} ,
                error:function(){alert('error');},
                success:function(){
                    $('#modal-confirm-rejet').hide();
                    location.reload();
                }
            });
            });
    }

    </script>

