@extends('layouts.admin')
@section('dashboad_bank', 'active')
@section('content')
<div class="col-md-12">
        <!-- Basic Form Elements Title -->
        <div class="row text-center">
            <div class="col-sm-6 col-lg-3">
                <a onclick="change_view_bank('facture_payee','entreprise_partenaire','mobilisation','en_attente_paiement')" href="javascript:void(0)" class="widget widget-hover-effect2" >
                    <div class="widget-extra themed-background">
                        <h4 class="widget-content-light"> Demandes de paiements <strong></strong> </h4>
                    </div>
                    <div class="widget-extra-full"><span class="h2 animation-expandOpen"  target="_blank" >{{ $nombre_facture_a_paye }}</span></div>
                </a>
            </div>
            <div class="col-sm-6 col-lg-3">
                <a onclick="change_view_bank('en_attente_paiement','facture_payee','mobilisation','entreprise_partenaire')" href="javascript:void(0)" class="widget widget-hover-effect2">
                    <div class="widget-extra themed-background-dark">
                        <h4 class="widget-content-light"><strong>Entreprises </strong> Partenaires</h4>
                    </div>
                    <div class="widget-extra-full"><span class="h2 themed-color-dark animation-expandOpen">{{ count($beneficiaire_par_banks) }}</span></div>
                </a>
            </div>
            <div class="col-sm-6 col-lg-3">
                <a onclick="change_view_bank('en_attente_paiement','entreprise_partenaire','mobilisation','facture_payee')" href="javascript:void(0)"  class="widget widget-hover-effect2" >
                    <div class="widget-extra themed-background-dark">
                        <h4 class="widget-content-light"><strong>Paiements</strong> Effectués</h4>
                    </div>
                    <div class="widget-extra-full"><span class="h2 themed-color-dark animation-expandOpen">{{ $nombre_facture_payes }}</span></div>
                </a>
            </div>
            <div class="col-sm-6 col-lg-3">
                <a onclick="change_view_bank('en_attente_paiement','entreprise_partenaire','facture_payee','mobilisation')" href="javascript:void(0)"  class="widget widget-hover-effect2"  >
                    <div class="widget-extra themed-background-dark">
                        <h4 class="widget-content-light">Fonds<strong> Mobilisé(Fcfa)</strong></h4>
                    </div>
                    <div class="widget-extra-full"><span class="h2 themed-color-dark animation-expandOpen">{{ format_prix($montant_total_mobilise_par_banque) }}</span></div>
                </a>
            </div>
        </div>
        <div class="block">
            <!-- Customer Addresses Title -->
            <div class="block-title">
                <h2><i class="fa fa-building-o"></i> <strong>Quelques </strong> Indicateurs de performances</h2>
            </div>
            <div class="row" style="font-size:16px; font-weight:600">
                <div class="col-lg-6">
                    <!-- Billing Address Block -->
                    <div class="block">
                        <!-- Billing Address Title -->
                        <div class="block-title">
                            <h2>Mobilisation des fonds</h2>
                        </div>
                        <div class="row" style="margin-bottom:15px;" >
                            <div class="col-md-6">
                                Montant à Mobiliser <span data-toggle="tooltip" title="La situation sur le montant à mobiliser en contrepartie et en subvention sur la base des accords bénéficiaires signés."><i class="fa fa-info-circle"></i></span> :
                            </div>
                            <div class="col-md-6">
                                    {{ format_prix($montant_des_projets_de_la_banque) }}
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:15px;" >
                            <div class="col-md-6" >
                                Montant Mobilisé <span data-toggle="tooltip" title="La situation sur le montant à mobiliser en contrepartie et en subvention sur la base des accords bénéficiaires signés."><i class="fa fa-info-circle"></i></span>:
                            </div>
                            <div class="col-md-6">
                                    {{ format_prix($montant_total_mobilise_par_banque) }}
                            </div>
                        </div>
                        
                        <div class="row" style="margin-bottom:10px;" >
                            <div class="col-md-6">
                                Taux de Mobilisation :
                            </div>
                            <div class="col-md-6">
                                @if($montant_des_projets_de_la_banque==0)
                                        0 %
                                @else
                                   {{ formater_deux_chiffres($montant_total_mobilise_par_banque/$montant_des_projets_de_la_banque *100)}} %
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- END Billing Address Block -->
                </div>
                <div class="col-lg-6" >
                    <!-- Shipping Address Block -->
                    <div class="block">
                        <!-- Shipping Address Title -->
                        <div class="block-title">
                            <h2>Consommation des ressources</h2>
                        </div>
                        <!-- END Shipping Address Title -->

                        <!-- Shipping Address Content -->
                        <div class="row" style="margin-bottom:15px; " >
                            <div class="col-md-6" >
                                Montant Consommé :
                            </div>
                            <div class="col-md-6">
                               {{ format_prix($factures_payees->sum('montant')) }}
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:15px;" >
                            <div class="col-md-6" >
                                Reste à Consommer <span data-toggle="tooltip" title="La différence entre le montant à mobiliser et les montants des factures payées sur la base des accords bénéficiaires signés."><i class="fa fa-info-circle"></i></span>:
                            </div>
                            <div class="col-md-6">
                                   {{ format_prix($montant_des_projets_de_la_banque - $factures_payees->sum('montant'))}}
                            </div>
                        </div><div class="row" style="margin-bottom:15px;" >
                            <div class="col-md-6" >
                               Taux de consommantion <span data-toggle="tooltip" title="Le taux entre le total des fonds à mobiliser et le total des factures payées sur la bases des accords bénéfaicaires dignés ."><i class="fa fa-info-circle"></i></span>:
                            </div>
                            <div class="col-md-6">
                                @if($montant_des_projets_de_la_banque==0)
                                        0 %
                                @else
                                    {{ formater_deux_chiffres($factures_payees->sum('montant')/$montant_des_projets_de_la_banque *100) }} %
                                @endif
                            </div>
                        </div>
                        <!-- END Shipping Address Content -->
                    </div>
                    <!-- END Shipping Address Block -->
                </div>
            </div>
            <!-- END Customer Addresses Content -->
        </div>
<div class="row en_attente_paiement" style="display: none" >
          <!-- Basic Form Elements Title -->
  
                  <!-- Form Validation Example Block -->
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
                @php
                    $i=0;
                  @endphp
                    @foreach($factures_validees as $facture)
                        <tr
                        @if(return_diffdate($facture->date_de_validation, today()) > env('NBRE_JR_DE_PAIEMENT_DES_FACTURES')) 
                        style = "color:red"
                        @else
                        style = "color:green"
                        @endif
        
                        >
                                @php
                                    $i++;
                                @endphp
                                <td>{{ $i }}</td>
                            <td>{{$facture->num_facture}}</td>
                            <td>{{format_prix($facture->montant) }}</td>
                            <td>{{$facture->denomination}}</td>
                            <td>{{$facture->mode_de_paiement}}</td>
                            <td>{{format_date($facture->date_de_validation)}}</td>
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
<div class="row facture_payee" style="display: none">
  <!-- Basic Form Elements Title -->

          <!-- Form Validation Example Block -->
  <div class="block">
              <!-- Form Validation Example Title -->
              <div class="block-title">
                  <h2> Liste <strong>des demandes de paiements éffectués</strong></h2>        
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
                  <th>Date de paiement</th>
                  {{-- <th>Recu de paiement</th> --}}
                  <th>Actions</th>
              </tr>
      </thead>
      <tbody>
        @php
        $i=0;
      @endphp
          @foreach($factures_payees as $facture_payee)
              <tr
          @if(return_facture($facture_payee->facture_id)->historique_payee)
              @if( return_diffdate($facture_payee->date_de_validation, $facture_payee->date_de_paiement) > env('NBRE_JR_DE_PAIEMENT_DES_FACTURES')) 
              style = "color:red"
              @else
              style = "color:green"
              @endif
          @endif
              >
                @php
                    $i++;
                @endphp
                  <td>{{ $i }}</td>
                  <td>{{$facture_payee->num_facture}}</td>
                  <td>{{format_prix($facture_payee->montant) }}</td>
                  <td>{{$facture_payee->denomination}}</td>
                  <td>{{$facture_payee->mode_de_paiement}}</td>
                  <td>{{format_date(return_facture($facture_payee->facture_id)->historique_validee->date_statut)}}</td>
                  @if(return_facture($facture_payee->facture_id)->historique_payee)
                      <td>{{format_date($facture_payee->date_de_paiement)}}</td>
                      {{-- <td>
                          {{return_diffdate(return_facture($facture_payee->facture_id)->historique_payee->date_statut, return_facture($facture->facture_id)->historique_validee->date_statut )}} 
                      </td> --}}

                  @endif
                  <td class="text-center">
                          <div class="btn-group">
                            <a href="{{ route('facture.showById',$facture_payee->facture_id) }}" data-toggle="tooltip" title="Visualiser" class="btn btn-lg btn-success" target="_blank"><i class="fa fa-eye"></i></a>
                          </div>
                  </td>
              </tr>
          @endforeach
      </tbody>
      </table>
      </div>
  </div>
</div>
<div class="row entreprise_partenaire" style="display: none" >
    <div class="block full">
      <div class="block-title">
          <h2><strong>Liste</strong> des bénéficiaires de la banque </h2>
      </div>
      <div class="table-responsive">
          <table id="" class="table table-vcenter table-condensed table-bordered listepdf">
              <thead>
                  <tr>
                      <th class="text-center">N°</th>
                      {{-- <th class="text-center" style="width:10px;" >Code promoteur</th> --}}
                      <th class="text-center">Catégorie</th>
                      <th class="text-center">Entreprise</th>
                      <th class="text-center">Coût du projet</th>
                      <th class="text-center">Contre partie versée</th>
                      <th class="text-center">Virements du bailleur</th>
                      <th class="text-center">Fond disponible</th>
                      <th class="text-center">Actions</th>
                  </tr>
              </thead>
              <tbody>
                  @php
                    $i=0;
                  @endphp
                  @foreach ($beneficiaire_par_banks as $entreprise)
                          @php
                            $i++;
                          @endphp
                      <tr>
                          <td class="text-center" style="width: 2%">{{ $i }}</td>
                          <td class="text-center" style="width: 2%"> {{ $entreprise->aopOuleader }}</td>
                          <td class="text-center" style="width: 5%;" >
                              {{ $entreprise->denomination }} - {{ $entreprise->telephone_entreprise }}
                          </td>
                          
                          <td class="text-center" style="width: 5%;">
                              @if($entreprise->projet)
                              {{ format_prix($entreprise->projet->investissements->sum('montant')) }} 
                              @else
                              Non disponible 
                              @endif
                          </td>
                          <td class="text-center" style="width: 5%;">{{ format_prix($entreprise->accomptes->sum('montant')) }}</td>
                          <td class="text-center" style="width: 5%;">{{ format_prix($entreprise->subventions->sum('montant_subvention'))}}</td>
                          <td class="text-center" style="width: 5%;">{{ format_prix($entreprise->subventions->sum('montant_subvention')+ $entreprise->accomptes->sum('montant'))}}</td>
                          <td class="text-center" style="width: 10%;">
                              <div class="btn-group">
                                  {{-- <a href="" data-toggle="tooltip" title="Editer" class="btn btn-md btn-default"><i class="fa fa-pencil"></i></a> --}}
                                  <a href="{{ route("entreprise.show",$entreprise) }}" data-toggle="tooltip" title="Visualiser les details du projet de la promotrice" class="btn btn-md btn-default"><i class="fa fa-eye"></i></a>
                                  <a href="{{ route("entreprise.accompte",$entreprise) }}" data-toggle="tooltip" title="Gérer les accomptes  du bénéficiaire" class="btn btn-md btn-success"><i class="gi gi-money"></i></a>
                                  <a href="{{ route("entreprise.subvention",$entreprise) }}" data-toggle="tooltip" title="Gérer les virements ICD sur le compte du bénéficiaire" class="btn btn-md btn-warning"><i class="gi gi-down_arrow"></i></a>
                                  {{-- <a href="{{ route("facture.a_payer_de_par_banque") }}" data-toggle="tooltip" title="Gérer les paiements fournisseurs" class="btn btn-md btn-danger"><i class="gi gi-bullhorn"></i></a> --}}
                              </div>
                          </td>
                      </tr>
                  @endforeach
              </tbody>
          </table>
      </div>
   </div>  
</div>
<div class="row mobilisation" style="display: none">
    <div class="col-md-6">
      <div class="block full">
          <div class="block-title">
              <h2><strong>Total Mobilisation de la contre partie :</strong> {{ format_prix($contrepartie_par_banks->sum('montant')) }}  </h2>
          </div>
          <div class="table-responsive">
              <table id="" class="table table-vcenter table-condensed table-bordered listepdf">
                  <thead>
                      <tr>
                          <th class="text-center">N°</th>
                          {{-- <th class="text-center" style="width:10px;" >Code promoteur</th> --}}
                          <th class="text-center">Entreprise</th>
                          <th class="text-center">Télephone</th>
                          <th class="text-center">Montant</th>
                          <th class="text-center">Date de l'operation</th>
                          <th class="text-center">Actions</th>
                      </tr>
                  </thead>
                  <tbody>
                      @php
                        $i=0;
                      @endphp
                      @foreach ($contrepartie_par_banks as $contrepartie)
                              @php
                                $i++;
                              @endphp
                          <tr>
                              <td class="text-center" style="width: 2%">{{ $i }}</td>
                              <td class="text-center" style="width: 5%;" >
                                  {{ $contrepartie->denomination }}
                              </td>
                              <td class="text-center" style="width: 5%;" >
                                  {{ $contrepartie->telephone_entreprise }}
                              </td>
                              <td class="text-center" style="width: 5%;">{{ format_prix($contrepartie->montant) }}</td>
                              <td class="text-center" style="width: 5%;" >
                                  {{format_date($contrepartie->date_versement) }}
                              </td>
                              <td class="text-center" style="width: 7%;">
                                  
                              </td>
                          </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>
      </div>
  </div>
  <div class="col-md-6">
      <div class="block full">
          <div class="block-title">
              <h2><strong>Total Mobilisation</strong> de la subvention: {{ format_prix($subvention_par_banks->sum('montant')) }} </h2>
          </div>
          <div class="table-responsive">
              <table id="" class="table table-vcenter table-condensed table-bordered listepdf">
                  <thead>
                      <tr>
                          <th class="text-center">N°</th>
                          {{-- <th class="text-center" style="width:10px;" >Code promoteur</th> --}}
                          <th class="text-center">Entreprise</th>
                          <th class="text-center">Télephone</th>
                          <th class="text-center">Montant</th>
                          <th class="text-center">Date de l'operation</th>
                          <th class="text-center">Actions</th>
                      </tr>
                  </thead>
                  <tbody>
                      @php
                        $i=0;
                      @endphp
                      @foreach ($subvention_par_banks as $subvention)
                              @php
                                $i++;
                              @endphp
                          <tr>
                              <td class="text-center" style="width: 2%">{{ $i }}</td>
                              <td class="text-center" style="width: 5%;" >
                                  {{ $subvention->denomination }}
                              </td>
                              <td class="text-center" style="width: 5%;" >
                                  {{ $subvention->telephone_entreprise }}
                              </td>
                              <td class="text-center" style="width: 5%;">{{ format_prix($subvention->montant) }}</td>
                              <td class="text-center" style="width: 5%;" >
                                  {{ format_date($subvention->date_subvention)}}
                              </td>
                              <td class="text-center" style="width: 7%;">
                                  
                              </td>
                          </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>
      </div>
  </div>
</div>
                <!-- Form Validation Example Block -->
  <div class="row graphique" >
    <div class="block">
      <!-- Form Validation Example Title -->
      <div class="block-title">
          <h2>Vue <strong> banque parténaires</strong></h2>
      </div>
      <div class="row">
          <div class="col-md-6" id="indicateur3">
  
          </div>
          <div class="col-md-6" id="indicateur4">
  
          </div>
      </div>
  </div>
  </div>
            </div>
@endsection
@section('script_additionnel')
<script>
  function change_view_bank(class_cache1, class_cache2, class_cache3,class_affiche){
      $("."+class_cache1).hide();
      $("."+class_cache2).hide();
      $("."+class_cache3).hide();
      $('.graphique').hide();
      $("."+class_affiche).show();

  }
</script>
<script language = "JavaScript">
$( document ).ready(function() {
       // alert('okok');
        var url = "{{ route('situation_des_subventions_debloque_par_banque') }}";
          $.ajax({
              url: url,
             type: 'GET',
             dataType: 'json',
              error:function(data){
                    if (xhr.status == 401) {
                    window.location.href = 'https://www.bravewomen.bf/login';
                }
                alert("Erreur");},
               success: function (donnee) {
                var donnch= new Array();
                var mois = new Array();
          
                for(var i=0; i<donnee.length; i++)
                        {
                            
                          donnch.push({
                                    name: donnee[i].name,
                                    data:  donnee[i].data});
                            
                        }

                        for(var i=0; i<donnee[1].mois.length; i++)
                        {
                            mois[i] = donnee[1].mois[i]
                        }
                  
                Highcharts.chart('indicateur44', {

title: {
text: 'Flux du du deblocage de la subvention par banque'
},

subtitle: {
text: 'Source: <a href="https://irecusa.org/programs/solar-jobs-census/" target="_blank">IREC</a>'
},

yAxis: {
title: {
text: 'La subvention mobilisée par banque'
}
},

xAxis: {
categories: mois
},
legend: {
layout: 'vertical',
align: 'right',
verticalAlign: 'middle'
},

plotOptions: {
series: {
label: {
  connectorAllowed: true
},

}
},

series: donnch,

responsive: {
rules: [{
condition: {
  maxWidth: 500
},
chartOptions: {
  legend: {
    layout: 'horizontal',
    align: 'center',
    verticalAlign: 'bottom'
  }
}
}]
}

});
 }
});

var url = "{{ route('contrepartie_versee_par_periode') }}";
          $.ajax({
              url: url,
             type: 'GET',
             dataType: 'json',
              error:function(data){
                    if (xhr.status == 401) {
                    window.location.href = 'https://www.bravewomen.bf/login';
                }
                    alert("Erreur");},
               success: function (donnee) {
                var donnch= new Array();
                var mois = new Array();
          
                for(var i=0; i<donnee.length; i++)
                        {
                            
                          donnch.push({
                                    name: donnee[i].name,
                                    data:  donnee[i].data});
                            
                        }

                        for(var i=0; i<donnee[1].mois.length; i++)
                        {
                            mois[i] = donnee[1].mois[i]
                        }
                    console.log(mois);
                Highcharts.chart('indicateur33', {

title: {
text: 'Flux de mobilisation de la contre partie des beneficiaires'
},

subtitle: {
text: 'BRAVE WOMEN Burkina Faso'
},

yAxis: {
title: {
text: 'Contrepartie mobilisée par banque'
}
},

xAxis: {
categories: mois
},
legend: {
layout: 'vertical',
align: 'right',
verticalAlign: 'middle'
},

plotOptions: {
series: {
label: {
  connectorAllowed: true
},

}
},

series: donnch,

responsive: {
rules: [{
condition: {
  maxWidth: 500
},
chartOptions: {
  legend: {
    layout: 'horizontal',
    align: 'center',
    verticalAlign: 'bottom'
  }
}
}]
}

});
 }
});

});

   
</script>

 <script language = "JavaScript">
    var url = "{{ route('contrepartie.parbanque') }}"
      $.ajax({
                 url: url,
                 type: 'GET',
                 dataType: 'json',
                 error:function(data){
                    if (xhr.status == 401) {
                    window.location.href = 'https://www.bravewomen.bf/login';
                }
                    alert("Erreur");
                },
                 success: function (donnee) {
                        var donnch= new Array();
                        var banques = new Array();
                    for(var i=0; i<donnee.length; i++)
                    {
                      donnch.push({
                                name: donnee[i].nom_banque,
                                y:  parseInt(donnee[i].montant_mobilise)
                            })
                    }
                    for(var i=0; i<donnee.length; i++)
                            {
    
                                banques[i] = donnee[i].nom_banque

                    }
                    Highcharts.chart('indicateur3', {
                        chart: {
                            type: 'column'
                        },
                        xAxis: {
                                     categories: banques
                                },
                        title: {
                            text: 'Situation de la mobilisation de la contrepartie par banque'
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.y:.1f}</b> Fcfa'
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: true,
                                    format: '<b>{point.name}</b>: {point.y:.1f} Fcfa'
                                }
                            }
                        },
                    
                        series: [{
                                    name: 'Montant',
                                    colorByPoint: true,
                                    data: donnch
                                }]
                    });

}

});      
</script> 
<script language = "JavaScript">
    var url = "{{ route('subvention.parbanque') }}"
      $.ajax({
                 url: url,
                 type: 'GET',
                 dataType: 'json',
                 error:function(data){
                    if (xhr.status == 401) {
                        window.location.href = 'https://www.bravewomen.bf/login';
                    }
                    alert("Erreur");},
                 success: function (donnee) {
                        var donnch= new Array();
                        var banques = new Array();
                    for(var i=0; i<donnee.length; i++)
                    {
                      donnch.push({
                                name: donnee[i].nom_banque,
                                y:  parseInt(donnee[i].montant_mobilise)
                            })
                    }
                    for(var i=0; i<donnee.length; i++)
                            {
    
                                banques[i] = donnee[i].nom_banque

                    }
                    Highcharts.chart('indicateur4', {
                        chart: {
                            type: 'column'
                        },
                        xAxis: {
                                     categories: banques
                                },
                        title: {
                            text: 'Situation du virement de la subvention par banque'
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.y:.1f}</b> Fcfa'
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: true,
                                    format: '<b>{point.name}</b>: {point.y:.1f} Fcfa'
                                }
                            }
                        },
                    
                        series: [{
                                    name: 'Montant',
                                    colorByPoint: true,
                                    data: donnch
                                }]
                    });

}

});      
</script>

<script language = "JavaScript">
            var url =  "{{ route('contrepartie.parbanque') }}";
              $.ajax({
                         url: url,
                         type: 'GET',
                         dataType: 'json',
                         error:function(data){
                            if (xhr.status == 401) {
                                window.location.href = 'https://www.bravewomen.bf/login';
                            }                                                               
                        alert("Erreur");},
                         success: function (donnee) {
                                var donnch= new Array();
                                var region = new Array();
                            for(var i=0; i<donnee.length; i++)
                            {
                              donnch.push({
                                        name: donnee[i].nom_banque,
                                        y:  parseInt(donnee[i].montant)} )
                            }
                            
                            Highcharts.chart('indicateur', {
                                chart: {
                                    type: 'column'
                                },
                                
                                title: {
                                    text: 'Repartition des souscriptions par region'
                                },
                               
                                credits:{
                                    enabled:false,
                                },
                                plotOptions: {
                                    pie: {
                                        allowPointSelect: true,
                                        cursor: 'pointer',
                                        dataLabels: {
                                            enabled: true,
                                            //format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                                        }
                                    }
                                },
                                series: [{
                                    name: 'Montant',
                                    colorByPoint: true,
                                    data: donnch
                                }]
                            });
    
        }
    
        });      
        </script>

@endsection