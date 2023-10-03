@extends('layouts.admin')
@section('dashboard', 'active')
@section('gestion', 'active')
@section('souscription-edit', 'active')
    @section('content')
    @section('blank')
    <li>Dashboard</li>
    <li>Entreprise</li>
    <li><a href="">Détails</a></li>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            
            <!-- Customer Info Block -->
            
            <div class="block col-md-12">
                <!-- Customer Info Title -->
                
                <!-- END Customer Info Title -->

                <!-- Customer Info -->
                
            <div class="col-md-5">
                <div class="block-section text-center">
                    <a href="javascript:void(0)">
                        <img src="{{ asset("img/placeholders/avatars/avatar4@2x.jpg") }}" alt="avatar" class="img-circle" height="60">
                    </a>
                    <h3>
                        <strong>@empty($entreprise->promotrice->nom)
                            Informations non disponible
                            @endempty
                            {{$entreprise->promotrice->nom}} {{$entreprise->promotrice->prenom}}</strong><br><small></small>
                    </h3>
                </div>
                <table class="table table-borderless table-striped table-vcenter">
                    <tbody>
                        <tr>
                            <td class="text-left"><strong>Denomination </strong></td>
                            <td>{{$entreprise->denomination}}</td>
                        </tr>
                        <tr>
                            <td class="text-left"><strong>Zone </strong></td>
                            <td>{{getlibelle($entreprise->region)}}</td>
                        </tr>
                        <tr>
                            <td class="text-left"><strong>Contacts</strong></td>
                            <td>{{$entreprise->telephone_entreprise}}</td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
            <div class="col-md-7">
                <div class="row">
                    <div class="col-md-6 montant_detail_entreprise" >
                        <p> <span><img src="{{ asset('/img/money-icon.png') }}" width="30"></span> <span> Contrepartie Mobilisée</span> </p>
                        <p> {{ format_prix( $entreprise->accomptes->sum('montant'))}}</p>
                    </div>
                    <div class="col-md-5 montant_detail_entreprise" >
                        <p><span><img src="{{ asset('/img/money-icon.png') }}" width="30"></span><span></span> <span>Subvention Decaissée</span> </p>
                        <p > {{ format_prix( $entreprise->subventions->sum('montant_subvention')) }}</p>
                    </div>
                    <div class="col-md-6 montant_detail_entreprise" >
                        <p><span><img src="{{ asset('/img/money-icon.png') }}" width="30"></span><span></span> <span>Paiements Engagés</span> </p>
                        <p > {{ format_prix($entreprise->subventions->sum('montant_subvention')) }}</p>
                    </div>
                    <div class="col-md-5 montant_detail_entreprise">
                        <p><span><img src="{{ asset('/img/money-icon.png') }}" width="30"></span><span></span> <span>Paiement Effectué</span> </p>
                        <p > {{ format_prix($entreprise->subventions->sum('montant_subvention'))}}</p>
                    </div>
                </div>
               
            </div>
                
                <!-- END Customer Info -->
            </div>
           
        </div>
            <!-- END Customer Info Block -->
        
     </div>
            <div class="col-md-12 block-content ">
                            <div class="block full">
                                <!-- Block Tabs Title -->
                                <div class="block-title">
                                    <ul class="nav nav-tabs" data-toggle="tabs">
                                        <li class="active"><a href="#promotrice_data">Informations Générale</a></li>
                                        <li><a href="#projet" data-toggle="tooltip" title="Les details de l'entreprise"> Details du projet</a></li>
                                        <li><a href="#demande_de_paiement">Demandes de paiement </a></li>
                                         <li><a href="#bien_acquis">Biens Acquis</a></li>
                                         <li><a href="#files">Pièces Jointes</a></li>
                                         <a onclick="history.back()" class="btn btn-success pull-right" style="float: right;"><span><i class="fa fa-repeat"></i></span> Fermer </a>
                                    </ul>
                                </div>
                                <!-- END Block Tabs Title -->

                                <!-- Tabs Content -->
                                <div class="tab-content" >
                            <div class="tab-pane active" id="promotrice_data" style="height:60%;background: #fff">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div  id="condanation" class="form-group row">
                                            <p class="col-md-5 control-label labdetail"><span class="">Catégorie d'entreprise : </span> </p>
                                                <p class="col-md-6" >
                                                <span class="valdetail">
                                                @empty($entreprise->aopOuleader)
                                                         Informations non disponible
                                                @endempty
                                                     {{$entreprise->aopOuleader}}
                                            </span></p>
                                        </div>
                                        <div  id="condanation" class="form-group row">
                                            <p class="col-md-5 control-label labdetail"><span class="">Banque partenaire choisie : </span> </p>
                                                <p class="col-md-6" >
                                                <span class="valdetail">
                                                @empty($entreprise->banque_id)
                                                         Informations non disponible
                                                @else
                                                {{$entreprise->banque->nom}}
                                                @endempty
                                               
                                            </span></p>
                                        </div>
                                        <div  id="condanation" class="form-group row">
                                            <p class="col-md-5 control-label labdetail"> <span class="labdetail">Code Promoteur : </span> </p>
                                            <p class="col-md-6" >
                                            <span class="valdetail">
                                                @empty($entreprise->promotrice->code_promoteur)
                                                    Informations non disponible
                                                @endempty
                                                {{$entreprise->promotrice->code_promoteur}}
                                            </span>
                                        </p>
                                    </div>
                                            <div  class="form-group row">
                                                <p class="col-md-5 control-label labdetail"> <span >Nom :  </span> </p>
                                                <p class="col-md-6" >
                                                    <span class="valdetail">
                                                        @empty($entreprise->promotrice->nom)
                                                        Informations non disponible
                                                        @endempty
                                                        {{$entreprise->promotrice->nom}}
                                                    </span>
                                                 </p>
                                            </div>

                                        <div  id="condanation" class="form-group row" >
                                            <p class="col-md-5 control-label labdetail"> <span >Prenom : </span> </p>
                                            <p class="col-md-6" >
                                            <span class="valdetail">
                                                @empty($entreprise->promotrice->prenom)
                                                        Informations non disponible
                                                        @endempty
                                                {{$entreprise->promotrice->prenom}}
                                        </span></p>
                                        </div>
                        </div>
                            <div class="col-md-6">
                                <div  id="condanation" class="form-group row" >
                                    <p class="col-md-5 control-label labdetail"> <span class="">Email : </span> </p>
                                    <p class="col-md-6" >
                                    <span class="valdetail">
                                        @empty($entreprise->promotrice->email_promoteur)
                                                    Informations non disponible
                                                    @endempty
                                            {{$entreprise->promotrice->email_promoteur}}
                                    </span></p>
                                </div>
                                
                                
                            </div>
                            <div class="col-md-6">
                                <div  id="condanation" class="form-group row">
                                    <p class="col-md-5 control-label labdetail"><span class="">Region : </span> </p>
                                        <p class="col-md-6" >
                                        <span class="valdetail">
                                        @empty($entreprise->region)
                                                Informations non disponible
                                                            @endempty
                                             {{getlibelle($entreprise->region)}}
                                    </span></p>
                                </div>
                                <div  id="condanation" class="form-group row " >
                                    <p class="col-md-5 control-label labdetail"> <span class="">Province de residence : </span> </p>
                                    <p class="col-md-6" >
                                    <span class="valdetail">
                                        @empty($entreprise->promotrice->province_residence)
                                                    Informations non disponible
                                                    @endempty
                                            {{getlibelle($entreprise->promotrice->province_residence)}}
                                </span></p>
                                </div>
    
                            <div  id="condanation" class="form-group row" >
                                <p class="col-md-5 control-label labdetail"> <span class="">Commune de residence : </span> </p>
                                <p class="col-md-6" >
                                <span class="valdetail">
                                    @empty($entreprise->promotrice->commune_residence)
                                                Informations non disponible
                                                @endempty
                                        {{getlibelle($entreprise->promotrice->commune_residence)}}
                            </span></p>
                            </div>
                            

                    </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                            <div  id="condanation" class="form-group row">
                                <p class="col-md-5 control-label labdetail"><span class="">Secteur d'activite : </span> </p>
                                    <p class="col-md-6" style="text-align: justify;"  >
                                    <span class="valdetail">
                                    @empty($entreprise->secteur_activite)
                                                        Informations non disponible
                                                        @endempty
                                         {{getlibelle($entreprise->secteur_activite)}}
                                </span></p>
                            </div>
                            <div  id="condanation" class="form-group row">
                                <p class="col-md-5 control-label labdetail"><span class="">Maillon d'activite : </span> </p>
                                    <p class="col-md-6" >
                                    <span class="valdetail">
                                    @empty($entreprise->maillon_activite)
                                                        Informations non disponible
                                                        @endempty
                                         {{getlibelle($entreprise->maillon_activite)}}
                                </span></p>
                            </div>
                             
                        
                        </div>
                        <div class="col-md-6">
                            <div  id="condanation" class="form-group row " >
                                <p class="col-md-5 control-label"> <span class="labdetail">Téléphone : </span></p>
                                <p class="col-md-6" >
                                    <span class="valdetail">
                                    @empty($entreprise->promotrice->telephone_promoteur)
                                                Informations non disponible
                                                @endempty
                                        {{$entreprise->promotrice->telephone_promoteur}}
                                </span>
                            </p>
                            </div>

                            <div  id="condanation" class="form-group row" >
                                <p class="col-md-5 control-label"> <span class="labdetail">Mobile(whatsAp) : </span> </p>
                                <p class="col-md-6" >
                                    <span class="valdetail">
                                    @empty($entreprise->promotrice->mobile_promoteur)
                                                Informations non disponible
                                                @endempty
                                        {{$entreprise->promotrice->mobile_promoteur}}
                            </span></p>
                            </div>
                        </div>
                     </div>
                   
                          </div>
                               <div class="tab-pane" id="demande_de_paiement" style="height:100%;background: #fff">
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table table-vcenter table-condensed table-bordered listepdf">
                                                <thead>
                                                        <tr>
                                                            <th>N</th>
                                                            <th>Numéro Facture</th>
                                                            <th>Date Facture</th>
                                                            <th>Montant</th>
                                                            <th>Statut</th>
                                                        </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($entreprise->factures as $facture)
                                                        <tr>
                                                            <td>1</td>
                                                            <td>{{$facture->mum_facture}}</td>
                                                            <td>{{$facture->created_at}}</td>
                                                            <td>{{$facture->montant}}</td>
                                                            <td>{{$facture->statut}}</td>
                                                            
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                </div>
                                       

                                    </div>
                                    
                            <div class="tab-pane" id="projet" style="height:140%;">
                                        <div class="row">
                                                <div class="col-md-6" style="text-align: justify;">
                                                    <div  id="condanation" class="form-group row">
                                                    
                                                        <p class="col-md-4 control-label labdetail"><span class="">Titre du projet: </span> </p>
                                                            <p class="col-md-8" >
                                                            <span class="valdetail">
                                                            @empty($entreprise->projet->titre_du_projet)
                                                                                Informations non disponible
                                                                                @endempty
                                                                 {{$entreprise->projet->titre_du_projet}}
                                                        </span></p>
                                                    </div>
                                                    <div  id="condanation" class="form-group row">
                                                        <p class="col-md-4 control-label labdetail"><span class="">Montant du projet: </span> </p>
                                                            <p class="col-md-8" >
                                                            <span class="valdetail">
                                                            @empty($entreprise->projet->titre_du_projet)
                                                                                Informations non disponible
                                                                                @endempty
                                                                {{ format_prix($entreprise->projet->investissements->sum('montant')) }}
                                                        </span></p>
                                                    </div> 
                                                    <div  id="condanation" class="form-group row">
                                                        <p class="col-md-4 control-label labdetail"><span class="">Subvention demandée: </span> </p>
                                                            <p class="col-md-8" >
                                                            <span class="valdetail">
                                                            @empty($entreprise->projet->titre_du_projet)
                                                                                Informations non disponible
                                                                                @endempty
                                                                {{ format_prix($entreprise->projet->investissements->sum('subvention_demandee')) }}
                                                        </span></p>
                                                    </div> 
                                                    <div id="condanation" class="form-group row">
                                                        <p class="col-md-4 control-label labdetail"><span class="">Contrepartie à mobiliser: </span> </p>
                                                            <p class="col-md-8" >
                                                            <span class="valdetail">
                                                            @empty($entreprise->projet->titre_du_projet)
                                                                                Informations non disponible
                                                                                @endempty
                                                                {{ format_prix($entreprise->projet->investissements->sum('apport_perso')) }}
                                                        </span></p>
                                                    </div> 
                                                    <div  id="condanation" class="form-group row">
                                                        <p class="col-md-4 control-label labdetail"  style="text-align: justify;"><span class="">Objectifs du projet: </span> </p>
                                                            <p class="col-md-8" >
                                                            <span class="valdetail">
                                                            @empty($entreprise->projet->objectifs)
                                                                                Informations non disponible
                                                                                @endempty
                                                                 {{$entreprise->projet->objectifs}}
                                                        </span></p>
                                                    </div>
                                                    

                                                </div>
                                                <div class="col-md-6" style="text-align: justify;" >
                                                    
                                                    <div  id="condanation" class="form-group row">
                                                        <p class="col-md-4 control-label labdetail"><span class=""> Atouts du promoteur: </span> </p>
                                                            <p class="col-md-8" >
                                                            <span class="valdetail">
                                                            @empty($entreprise->projet->atouts_promoteur)
                                                                                Informations non disponible
                                                                                @endempty
                                                                 {{$entreprise->projet->atouts_promoteur}}
                                                        </span></p>
                                                    </div>
                                                    <div  id="condanation" class="form-group row">
                                                        <p class="col-md-4 control-label labdetail"><span class="">Innovations: </span> </p>
                                                            <p class="col-md-8" style="text-align: justify;" >
                                                            <span class="valdetail">
                                                            @empty($entreprise->projet->innovation)
                                                                                Informations non disponible
                                                                                @endempty
                                                                 {{$entreprise->projet->innovation}}
                                                        </span></p>
                                                    </div>
                                                    <div  id="condanation" class="form-group row">
                                                        <p class="col-md-4 control-label labdetail"  style="text-align: justify;"><span class="">Activité Ménée: </span> </p>
                                                            <p class="col-md-8" >
                                                            <span class="valdetail">
                                                            @empty($entreprise->projet->activites_menees)
                                                                                Informations non disponible
                                                                                @endempty
                                                                 {{$entreprise->projet->activites_menees}}
                                                        </span></p>
                                                    </div>
                                                  </div>
                                       
                                            </div>

                                                  <div class="col-md-10 detailed">
                                                    <h4>Plan d'investissement </h4> 
                                                    <table class="table table-condensed table-bordered" style="text-align: center">
                                                        <thead style="text-align: center !important">
                                                                <tr>
                                                                    <th style="text-align: center; width:5%">Designation</th>
                                                                    <th style="text-align: center; width:5%">Coût soumis</th>
                                                                    <th style="text-align: center; width:5%">Coût validé</th>
                                                                    <th style="text-align: center; width:5%">Subvention Accordée</th>
                                                                    <th style="text-align: center; width:5%">Subvention validée</th>
                                                                    <th style="text-align: center; width:5%">Statut</th>
                                                                    
                                                                </tr>
                                                        </thead>
                                                        <tbody id="tbadys">
                                                        @foreach($entreprise->projet->investissements as $investissment)
                                                        <tr >
                                                            
                                                            <td>
                                                                {{getlibelle($investissment->designation)}}
                                                            </td>
                                                            
                                                            <td>
                                                                {{format_prix($investissment->montant)}}
                                                            </td>
                                                            <td>
                                                                {{format_prix($investissment->montant_valide)}}
                                                            </td>
                                                            <td>
                                                                {{format_prix($investissment->subvention_demandee)}}
                                                            </td>
                                                            <td>
                                                                {{format_prix($investissment->subvention_demandee_valide)}}
                                                            </td>
                                                            <td>
                                                                {{$investissment->statut}}
                                                            </td>
                                                
                                                        </tr>
                                                        @endforeach
                                                        </tbody>
                                                        </table>
                                            </div>

                                        </div>
                                   
                                    <div class="tab-pane" id="files" style="height:600px;">
                                    <div class="control-label">
                                        <h1 class="labdetail">Pièces jointes</h1>
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
                                <div class="tab-pane" id="bien_acquis" style="height:100%;">
                                    
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-vcenter table-condensed table-bordered listepdf">
                                            <thead>
                                                    <tr>
                                                        <th>Designations</th>
                                                        <th>Descriptions</th>
                                                        <th>quantite</th>
                                                        <th>Prix unitaire</th>
                                                        <th>Cout Total</th>
                                    
                                                    </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($entreprise->acquisitions as $aquisition)
                                                    <tr>
                                                        <td>{{$aquisition->designation}}</td>
                                                        <td>{{$aquisition->description}}</td>
                                                        <td>{{$aquisition->quantite}}</td>
                                                        <td>{{$aquisition->cout_unitaire}}</td>
                                                        <td>{{$aquisition->cout_total}}</td>
                                                        
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                            </div>
                        </div>
                        <div style="clear:bot"></div>
                                </div>
                                <div style="clear:bot"></div>
                            </div>
            <div style="clear:bot"></div>
    </div>
<script src={{ asset("js/vendor/jquery.min.js") }}></script>

@stop



@section('modalSection')
{{-- modal de transmission --}}
<div id="modal-confirm-etape" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
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
                            <p>Voulez-vous vraiment transmettre le dossier ?</p>
                        <div class="form-group form-actions">
                            <div class="text-right">
                                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-sm btn-primary" onclick="trans_id();">OUI</button>
                            </div>
                        </div>

                </div>
                <!-- END Modal Body -->
            </div>
        </div>
</div>


{{-- modal de transmission --}}


<!-- debut Modal Chambre concerné. -->




<!-- debut Modal Valider Etat juge. -->



<!-- debut Modal Valider Conseiller rapporteur. -->

<!-- Modal de génération de convocation -->



<!-- Modal d'enregistrement de decision -->



<!-- debut Modal Valider Avocat général. -->

@stop
<script>
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
                error:function(){
                    if (xhr.status == 401) {
                        window.location.href = 'https://www.bravewomen.bf/login';
                    }
                },
                success:function(){
                    $('#modal-confirm-changestatus').hide();
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
                error:function(){
                    if (xhr.status == 401) {
                        window.location.href = 'https://www.bravewomen.bf/login';
                    }},
                success:function(){
                    $('#modal-confirm-rejet').hide();
                    location.reload();
                }
            });

    }
    function confirmChangeStatus1(id_entreprise, id_user){
            document.getElementById("id_entreprise").setAttribute("value", id_entreprise);
            document.getElementById("id_user").setAttribute("value", id_user);
    }
    function validerdossier(){
        $(function(){
            var id_entreprise= $("#id_entreprise").val();
            var id_user= $("#id_user").val();
            var url = "{{ route('entreprise.statuermembrecomite') }}";
            $.ajax({
                url: url,
                type:'GET',
                data: {id_entreprise: id_entreprise, id_user : id_user} ,
                error:function(){alert('error');},
                success:function(){
                    $('#modal-confirm-changestatus').hide();
                    location.reload();
                }
            });
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
