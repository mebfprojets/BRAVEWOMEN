@extends("layouts.admin")
@section('dashboard', 'active')
@section('dash.banque_perform', 'active')
@section('content')
<div class="col-md-12 col-md-offset-1 block full" style="margin-left: 10px;">
    <div class="col-md-12">
        <div class="col-md-4">
            <div class="block">
                <!-- Quick Stats Title -->
                <div class="block-title">
                    <h2><i class="fa fa-line-chart"></i> <strong>Indicateurs</strong> Clés</h2>
                </div>
                <a href="javascript:void(0)" class="widget widget-hover-effect2 themed-background-muted-light">
                    <div class="widget-simple">
                        <h4 class="text-left text-warning">
                            <strong>{{ $facture_payes_par_banques->sum('nombre') }}</strong> ({{format_prix($facture_payes_par_banques->sum('montant')) }})<br><small> Factures Payées</small>
                        </h4>
                    </div>
                </a>
                <a href="javascript:void(0)" class="widget widget-hover-effect2 themed-background-muted-light">
                    <div class="widget-simple">
                        
                        <h4 class="text-left text-warning">
                            <strong>{{ $facture_a_payees_par_banques->sum('nombre') }}</strong> ({{format_prix($facture_a_payees_par_banques->sum('montant')) }})<br><small>Factures à payer</small>
                        </h4>
                    </div>
                </a>
                <a href="javascript:void(0)" class="widget widget-hover-effect2 themed-background-muted-light">
                    <div class="widget-simple">
                        <h4 class="text-left">
                            <strong> @if(($subvention_mobilise_par_banques->sum('montant') + $contrepartie_mobilise_par_banques->sum('montant')!=0))
                                {{  formater_deux_chiffres(($subvention_mobilise_par_banques->sum('montant') + $contrepartie_mobilise_par_banques->sum('montant'))/$montant_a_mobilise_par_banque->sum('montant')*100)}} %
                                @else
                                    0 %
                                @endif
                            </strong><br><small>Taux de mobilisation</small>
                        </h4>
                    </div>
                </a>
                <a href="javascript:void(0)" class="widget widget-hover-effect2 themed-background-muted-light">
                    <div class="widget-simple">
                        
                        <h4 class="text-left text-success">
                            <strong>
                                @if(($taux_de_consommation_par_banque->sum('montant_a_mobilise')!=0))
                                    {{  formater_deux_chiffres($taux_de_consommation_par_banque->sum('montant_decaisse')/$taux_de_consommation_par_banque->sum('montant_a_mobilise')*100)}} %
                                @else
                                    0 %
                                @endif
                            </strong><br><small>Taux de consommation</small>

                        </h4>
                    </div>
                </a>
                
                
                <!-- END Quick Stats Content -->
            </div>
        </div>
        <div class="col-md-8">
            <div class="block">
                <div class="block-title">
                    <div class="block-options pull-right">
                        <span class="label label-success"><strong>{{ format_prix($subvention_mobilise_par_banques->sum('montant') + $contrepartie_mobilise_par_banques->sum('montant'))}}</strong></span>
                    </div>
                    <h2><i class="fa fa-money"></i> <strong>Situation de la Mobilisation des fonds par banque</strong>  </h2>
                </div>
            <table class="table table-bordered table-striped table-vcenter ">
                <tr style="background-color: #52836338">
                    <th>Banque</th>
                    @foreach ($financement_par_banks as $financement_par_bank)
                        <th style="width:25%"> {{ $financement_par_bank->nom_banque}}</th>
                    @endforeach
                    <th style="width:25%"> Total</th>

                </tr>
                <tr>
                    <th>Projets validés au comité <span data-toggle="tooltip" title="La situation des finacements à mobiliser sur la base des projets validés par le comité de selection."><i class="fa fa-info-circle"></i></span></th>
                    @foreach ($montant_projet_valide_par_comites as $montant_projet_valide_par_comite)
                        <td>{{ format_prix($montant_projet_valide_par_comite->montant)}}</td>
                        @php
                          
                        @endphp
                    @endforeach
                    <td>{{ format_prix($montant_projet_valide_par_comites->sum('montant')) }}</td>
                </tr>
                <tr>
                    <th>Financement à mobiliser <span data-toggle="tooltip" title="La situation des finacements à mobiliser sur la base des accords bénéficiaires signés."><i class="fa fa-info-circle"></i></span></th>
                    @php
                        $somme=0;
                    @endphp 
                    @foreach ($montant_a_mobilise_par_banque as $montant_a_mobilise_par_bank)
                        <td>{{ format_prix($montant_a_mobilise_par_bank->montant)}}</td>
                        @php
                           $somme += $montant_a_mobilise_par_bank->montant
                        @endphp
                    @endforeach 
                        <td>{{ format_prix($somme)}}</td>
                </tr>
               
                <tr>
                    <th>Contrepartie mobilisée</th>
                    @php
                        $somme=0;
                    @endphp
                    @foreach ($financement_par_banks as $financement_par_bank)
                        <td>{{ format_prix($financement_par_bank->montant_contrepartie)}}</td>
                        @php
                           $somme += $financement_par_bank->montant_contrepartie
                        @endphp
                    @endforeach 
                        <td>{{ format_prix($somme)}}</td>
                </tr>
                <tr>
                    @php
                        $somme=0;
                    @endphp
                    <th>Subvention debloquée</th>
                    @foreach ($financement_par_banks as $financement_par_bank)
                        <td>{{ format_prix($financement_par_bank->montant_subvention)}}</td>
                        @php
                            $somme += $financement_par_bank->montant_subvention
                         @endphp
                    @endforeach 
                        <td>{{ format_prix($somme)}}</td>
                </tr>
                <tr >
                    @php
                        $somme=0;
                    @endphp
                    <th>Financement mobilisé</th>
                    @foreach ($financement_par_banks as $financement_par_bank)
                        <td>{{ format_prix($financement_par_bank->montant_subvention +  $financement_par_bank->montant_contrepartie)}}</td>
                        @php
                            $somme += $financement_par_bank->montant_subvention +  $financement_par_bank->montant_contrepartie
                        @endphp
                    @endforeach 
                        <td>{{ format_prix($somme)}}</td>
                </tr>
            </table>
        </div>
</div>
        <div class="col-md-12">
            <div class="block">
                <div class="block-title">
                <div class="block-options pull-right">
                        <span class="label label-success"><strong>{{ format_prix($taux_de_consommation_par_banque->sum('montant_decaisse')) }}</strong></span>
                    </div>
                    <h2><i class="fa fa-money"></i> <strong>Situation de consommation des fonds par banque</strong></h2>
                </div>
           
            <table  class="table table-bordered table-striped table-vcenter " >
                <tr style="background-color: #52836338">
                    <th>Banque</th>
                    @foreach ($facture_valides_par_banques as $facture_valides_par_bank)
                        <th style="width:25%"> {{ $facture_valides_par_bank->nom_banque}}</th>
                    @endforeach
                </tr>
                <tr>
                    <th>Factures validées</th>
                    @foreach ($facture_valides_par_banques as $facture_valides_par_bank)
                        <td>
                            <strong>  {{ $facture_valides_par_bank->nombre}}</strong> Factures
                            <hr> 
                            {{format_prix($facture_valides_par_bank->montant)}} Fcfa</td>
                    @endforeach 
                </tr>
                
                <tr>
                    <th>Factures Payées</th>
                    @foreach ($facture_payes_par_banques as $facture_payes_par_bank)
                        <td>
                           <strong>  {{ $facture_payes_par_bank->nombre}}</strong> Factures
                            <hr> 
                            {{ format_prix($facture_payes_par_bank->montant)}} Fcfa
                        </td>
                    @endforeach 
                </tr>
                <tr>
                    <th>Factures à payer</th>
                    @foreach ($facture_a_payees_par_banques as $facture_a_payees_par_bank)
                        <td>
                           <strong style="font-size: 18px">  {{ $facture_a_payees_par_bank->nombre}}</strong> Factures
                            <hr> 
                            {{ format_prix($facture_a_payees_par_bank->montant)}} Fcfa
                         </td>
                       
                    @endforeach 
                </tr> 
                <tr style="background-color: #52836338">
                    <th >Taux de consommation des fonds</th>
                    @foreach ($taux_de_consommation_par_banque as $taux_de_consommation_par_bank)
                        
                        <td>
                                @if($taux_de_consommation_par_bank->montant_decaisse ==null)
                                    0 %
                                @else
                                    {{ formater_deux_chiffres($taux_de_consommation_par_bank->montant_decaisse/$taux_de_consommation_par_bank->montant_a_mobilise *100 )}} %
                                @endif
                         </td>
                       
                    @endforeach 
                </tr>
                
            </table>
        </div>
    </div>
</div>
    
    <div class="row">
        
        <p class="col-md-offset-1 col-md-10 titre_tableau">Respect du délai de paiement des Fournisseurs par banque</p>
       
        <div class="col-md-4 graphique_respect_delais_de_paiement" id="delais_de_paiement_atlantique">

        </div>
        <div class="col-md-4 graphique_respect_delais_de_paiement" id="delais_de_paiement_coris">

        </div>
        <div class="col-md-4 graphique_respect_delais_de_paiement" id="delais_de_paiement_boa" >

        </div>
        
    </div>
    <div class="row">
        
        <p class="col-md-offset-2 col-md-8 center titre_tableau" >Nombre de Demandes de paiement rejétés par les banques </p>
       
        <div class="col-md-offset-2 col-md-6 graphique_respect_delais_de_paiement" id="demande_depaiement_rejete">

        </div>
        
        
    </div>
    
    
    
</div>
@endsection
@section('script_additionnel')
<script language = "JavaScript">
    var url = "{{ route('demandes.rejete_par_les_banques') }}"
      $.ajax({
                 url: url,
                 type: 'GET',
                 dataType: 'json',
                 error:function(data){
                    if (xhr.status == 401) {
                        window.location.href = 'https://www.bravewomen.bf/login';
                    }
                },
                 success: function (donnee) {
                        var donnch= new Array();
                        var status = new Array();
                        
                    for(var i=0; i<donnee.length; i++)
                    {
                      donnch.push({
                                name: donnee[i].nom_banque,
                                y:  parseInt(donnee[i].nombre_de_facture)}  )
                    }
                   // console.log(donnch)
                    for(var i=0; i<donnee.length; i++)
                            {
                                    status[i] = donnee[i].nom_banque
                            }
                    Highcharts.chart('demande_depaiement_rejete', {
                        chart: {
                                    type: 'column'
                                },
                        xAxis: {
                                 categories: status
                            },
                        title: {
                            text: 'Nombre de facture rejétée par les banques'
                        },
                        credits : {
                            enabled: false
                        },
                       
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: false
                                },
                                    showInLegend: true
                            }
                        },
                        series: [{
                            name: 'Factures',
                            colorByPoint: true,
                            data: donnch
                        }]
                    });

}

});      
</script>
<script language = "JavaScript">
    var url = "{{ route('facture.groupbydelaidetraitement') }}?banque_id=1"
      $.ajax({
                 url: url,
                 type: 'GET',
                 dataType: 'json',
                 error:function(data){
                    if (xhr.status == 401) {
                        window.location.href = 'https://www.bravewomen.bf/login';
                    }
                },
                 success: function (donnee) {
                        var donnch= new Array();
                        var status = new Array();
                        
                    for(var i=0; i<donnee.length; i++)
                    {
                      donnch.push({
                                name: donnee[i].statut_paiement,
                                y:  parseInt(donnee[i].nombre)}  )
                    }
                   // console.log(donnch)
                    for(var i=0; i<donnee.length; i++)
                            {
                                    status[i] = donnee[i].statut_paiement
                            }
                    Highcharts.chart('delais_de_paiement_atlantique', {
                        chart: {
                                    type: 'column'
                                },
                        xAxis: {
                                 categories: status
                            },
                        title: {
                            text: 'Banque Atlantique'
                        },
                        credits : {
                            enabled: false
                        },
                       
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: false
                                },
                                    showInLegend: true
                            }
                        },
                        series: [{
                            name: 'Factures',
                            colorByPoint: true,
                            data: donnch
                        }]
                    });

}

});      
</script>
<script language = "JavaScript">
    var url = "{{ route('facture.groupbydelaidetraitement') }}?banque_id=2"
      $.ajax({
                 url: url,
                 type: 'GET',
                 dataType: 'json',
                 error:function(data){
                    if (xhr.status == 401) {
                        window.location.href = 'https://www.bravewomen.bf/login';
                    }
                },
                 success: function (donnee) {
                        var donnch= new Array();
                        var status = new Array();
                    for(var i=0; i<donnee.length; i++)
                    {
                      donnch.push({
                                name: donnee[i].statut_paiement,
                                y:  parseInt(donnee[i].nombre)} )
                    }
                    for(var i=0; i<donnee.length; i++)
                            {
                                    status[i] = donnee[i].statut_paiement
                            }
                    console.log(donnee);
                    Highcharts.chart('delais_de_paiement_coris', {
                        chart: {
                                    type: 'column'
                                },
                        xAxis: {
                                 categories: status
                            },
                        title: {
                            text: 'Coris Bank'
                        },
                        credits : {
                            enabled: false
                        },
                        // tooltip: {
                        //     pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                        // },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: true
                                },
                                    showInLegend: true
                            }
                        },
                        series: [{
                            name: 'Factures',
                            colorByPoint: true,
                            data: donnch
                        }]
                    });

}

});      
</script>
<script language = "JavaScript">
    var url = "{{ route('facture.groupbydelaidetraitement') }}?banque_id=3"
      $.ajax({
                 url: url,
                 type: 'GET',
                 dataType: 'json',
                 error:function(data){
                    if (xhr.status == 401) {
                        window.location.href = 'https://www.bravewomen.bf/login';
                    }
                 },
                 success: function (donnee) {
                        var donnch= new Array();
                        var status = new Array();
                    for(var i=0; i<donnee.length; i++)
                    {
                      donnch.push({
                                name: donnee[i].statut_paiement,
                                y:  parseInt(donnee[i].nombre)} )
                    }
                    for(var i=0; i<donnee.length; i++)
                            {
                                    status[i] = donnee[i].statut_paiement
                            }
                    Highcharts.chart('delais_de_paiement_boa', {
                        chart: {
                                    type: 'column'
                                },
                        xAxis: {
                                 categories: status
                            },
                        title: {
                            text: 'BOA'
                        },
                        credits : {
                            enabled: false
                        },
                       
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: false
                                },
                                    showInLegend: true
                            }
                        },
                        series: [{
                            name: 'Factures',
                            colorByPoint: true,
                            data: donnch
                        }]
                    });

}

});      
</script>
<script language = "JavaScript">
    var url = "{{ route('facture.parstatut') }}?banque_id=1"
      $.ajax({
                 url: url,
                 type: 'GET',
                 dataType: 'json',
                 error:function(data){
                    if (xhr.status == 401) {
                        window.location.href = 'https://www.bravewomen.bf/login';
                    }
                 },
                 success: function (donnee) {
                        var donnch= new Array();
                    for(var i=0; i<donnee.length; i++)
                    {
                      donnch.push({
                                name: donnee[i].statut,
                                y:  parseInt(donnee[i].nombre)} )
                    }
                    Highcharts.chart('perform_banque_boa', {
                        chart: {
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                            type: 'pie'
                        },
                        title: {
                            text: 'BOA'
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: false
                                },
                                    showInLegend: true
                            }
                        },
                        series: [{
                            name: 'Factures',
                            colorByPoint: true,
                            data: donnch
                        }]
                    });

}

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
                } },
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
                        credits : {
                            enabled: false
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.y:.1f}</b> Fcfa'
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: false
                                },
                                    showInLegend: true
                            }
                        },
                    
                        series: [{
                                    name: 'Factures',
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
                    Highcharts.chart('indicateur4', {
                        chart: {
                            type: 'column'
                        },
                        xAxis: {
                                     categories: banques
                                },
                        title: {
                            text: 'Situation de la mobilisation de la contrepartie par banque'
                        },
                        credits : {
                            enabled: false
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.y:.1f}</b> Fcfa'
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: false
                                },
                                    showInLegend: true
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
    var url = "{{ route('facture.parstatut') }}?banque_id=2"
      $.ajax({
                 url: url,
                 type: 'GET',
                 dataType: 'json',
                 error:function(data){
                    if (xhr.status == 401) {
                        window.location.href = 'https://www.bravewomen.bf/login';
                    }
                 },
                 success: function (donnee) {
                        var donnch= new Array();
                    for(var i=0; i<donnee.length; i++)
                    {
                      donnch.push({
                                name: donnee[i].statut,
                                y:  parseInt(donnee[i].nombre)} )
                    }
                    Highcharts.chart('perform_banque_coris', {
                        chart: {
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                            type: 'pie'
                        },
                        title: {
                            text: 'Coris bank'
                        },
                        credits : {
                            enabled: false
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: false
                                },
                                    showInLegend: true
                            }
                        },
                        series: [{
                            name: 'Pourcentage',
                            colorByPoint: true,
                            data: donnch
                        }]
                    });

}

});      
</script>
<script language = "JavaScript">
    var url = "{{ route('facture.parstatut') }}?banque_id=3"
      $.ajax({
                 url: url,
                 type: 'GET',
                 dataType: 'json',
                 error:function(data){
                if (xhr.status == 401) {
                        window.location.href = 'https://www.bravewomen.bf/login';
                    }
                     },
                 success: function (donnee) {
                        var donnch= new Array();
                    for(var i=0; i<donnee.length; i++)
                    {
                      donnch.push({
                                name: donnee[i].statut,
                                y:  parseInt(donnee[i].nombre)} )
                    }
                    Highcharts.chart('perform_banque_atlantique', {
                        chart: {
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                            type: 'pie'
                        },
                        title: {
                            text: 'Banque Atlantique'
                        },
                        credits : {
                            enabled: false
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: true,
                                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                                }
                            }
                        },
                        series: [{
                            name: 'Pourcentage',
                            colorByPoint: true,
                            data: donnch
                        }]
                    });

}

});      
</script>
@endsection