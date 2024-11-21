@extends("layouts.admin")
@section('dashboard', 'active')
@section('dash.banque_perform_en', 'active')
@section('content')
<div class="col-md-12 col-md-offset-1 block full" style="margin-left: 10px;">
    <div class="col-md-12">
        <div class="col-md-4">
            <div class="block">
                <!-- Quick Stats Title -->
                <div class="block-title">
                    <h2><i class="fa fa-line-chart"></i> <strong>Key indicators</strong></h2>
                </div>
                <a href="javascript:void(0)" class="widget widget-hover-effect2 themed-background-muted-light">
                    <div class="widget-simple">
                        <h4 class="text-left text-warning">
                            <strong>{{ $facture_soumis_par_banques->sum('nombre') }}</strong> ({{format_prix($facture_soumis_par_banques->sum('montant')) }} FCFA)<br><small> Recorded invoices</small>
                        </h4>
                    </div>
                </a>
                <a href="javascript:void(0)" class="widget widget-hover-effect2 themed-background-muted-light">
                    <div class="widget-simple">
                        <h4 class="text-left text-warning">
                            <strong>{{ $facture_payes_par_banques->sum('nombre') }}</strong> ({{format_prix($facture_payes_par_banques->sum('montant')) }} FCFA)<br><small> Paid invoices</small>
                        </h4>
                    </div>
                </a>
                <a href="javascript:void(0)" class="widget widget-hover-effect2 themed-background-muted-light">
                    <div class="widget-simple">
                        
                        <h4 class="text-left text-warning">
                            <strong>{{ $facture_a_payees_par_banques->sum('nombre') }}</strong> ({{format_prix($facture_a_payees_par_banques->sum('montant')) }} FCFA)<br><small>Bills payable</small>
                        </h4>
                    </div>
                </a>
                
                <a href="javascript:void(0)" class="widget widget-hover-effect2 themed-background-muted-light">
                    <div class="widget-simple">
                        <h4 class="text-left">
                            <strong> @if(($subvention_mobilise_par_banques->sum('montant') + $contrepartie_mobilise_par_banques->sum('montant')!=0))
                                {{  formater_deux_chiffres(($subvention_mobilise_par_banques->sum('montant') + $contrepartie_mobilise_par_banques->sum('montant'))/(env('total_enveloppe_global')*2)*100)}} %
                                @else
                                    0 %
                                @endif
                            </strong><br><small>Mobilization rate</small>
                        </h4>
                    </div>
                </a>
                <a href="javascript:void(0)" class="widget widget-hover-effect2 themed-background-muted-light">
                    <div class="widget-simple">
                        <h4 class="text-left text-success">
                            <strong>
                                @if(($taux_de_consommation_par_banque->sum('montant_a_mobilise')!=0))
                                    {{ formater_deux_chiffres($taux_de_consommation_par_banque->sum('montant_decaisse')/(env('total_enveloppe_global')*2)*100)}} %
                                @else
                                    0 %
                                @endif
                            </strong><br><small>Subsidy consumption rate</small>

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
                        <span class="label label-success">Total financing mobilized: <strong>{{ format_prix($subvention_mobilise_par_banques->sum('montant') + $contrepartie_mobilise_par_banques->sum('montant'))}} FCFA</strong></span>
                    </div>
                    <h2><i class="fa fa-money"></i> <strong>Funds mobilization by bank in FCFA</strong>  </h2>
                </div>
            <table class="table table-bordered table-striped table-vcenter ">
                <tr style="background-color: #52836338">
                    <th>BANK</th>
                    @foreach ($financement_par_banks as $financement_par_bank)
                        <th style="width:25%"> {{ return_sigle_bank($financement_par_bank->nom_banque)}}</th>
                    @endforeach
                    <th style="width:25%"> Total</th>

                </tr>
                <tr>
                    <th>Consideration to be mobilized <span data-toggle="tooltip" title="La situation des finacements à mobiliser sur la base des projets validés par le comité de selection."><i class="fa fa-info-circle"></i></span></th>
                    @foreach ($montant_projet_valide_par_comites as $montant_projet_valide_par_comite)
                        <td>{{ format_prix($montant_projet_valide_par_comite->montant/2)}}</td>
                        @php
                          
                        @endphp
                    @endforeach
                    <td>{{ format_prix($montant_projet_valide_par_comites->sum('montant')/2) }}</td>
                </tr>
    
               
                <tr>
                    <th>Mobilized consideration</th>
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
                    <th>Consideration mobilized</th>
                    @foreach ($facture_payes_par_banques as $facture_payes_par_banque)
                        <td>{{ format_prix($facture_payes_par_banque->montant/2)}}</td>
                        @php
                            $somme += $facture_payes_par_banque->montant/2
                         @endphp
                    @endforeach 
                        <td>{{ format_prix($somme)}}</td>
                </tr>
                <tr >
                    @php
                        $somme=0;
                    @endphp
                    <tr style="background-color: #52836338">
                        <th >Project completion rate</th>
                        @foreach ($taux_de_consommation_par_banque as $taux_de_consommation_par_bank)
                            <td>
                                    @if($taux_de_consommation_par_bank->montant_decaisse ==null)
                                        0 %
                                    @else
                                        {{ formater_deux_chiffres($taux_de_consommation_par_bank->montant_decaisse/$taux_de_consommation_par_bank->montant_a_mobilise *100 )}} %
                                    @endif
                             </td>
                        @endforeach 
                        <td>
                            {{ formater_deux_chiffres($taux_de_consommation_par_banque->sum('montant_decaisse')/$taux_de_consommation_par_banque->sum('montant_a_mobilise') *100 )}} %
                        </td>
                    </tr>
            </table>
        </div>
</div>
<div class="row">
    {{-- <p class="col-md-offset-4 col-md-10 titre_tableau">Statut des factures par banque</p> --}}
        <div class="col-md-10" id='statut_des_factures_par_bank'>

        </div>
</div>
        <div class="col-md-12">
            <div class="block">
                <div class="block-title">
                <div class="block-options pull-right">
                        <span class="label label-success">Total amount of paid invoices : <strong>{{ format_prix($taux_de_consommation_par_banque->sum('montant_decaisse')) }}</strong></span>
                    </div>
                    <h2><i class="fa fa-money"></i> <strong>Invoice details by bank</strong></h2>
                </div>
           
            <table  class="table table-bordered table-striped table-vcenter " >
                <tr style="background-color: #52836338">
                    <th>Banque</th>
                    @foreach ($facture_valides_par_banques as $facture_valides_par_bank)
                        <th style="width:25%"> {{ return_sigle_bank($facture_valides_par_bank->nom_banque)}}</th>
                    @endforeach
                </tr>
                <tr>
                    <th>Approuved invoices</th>
                    @foreach ($facture_valides_par_banques as $facture_valides_par_bank)
                        <td>
                            <strong>  {{ $facture_valides_par_bank->nombre}}</strong> Invoices
                            <hr> 
                            {{format_prix($facture_valides_par_bank->montant)}} Fcfa</td>
                    @endforeach 
                </tr>
                
                <tr>
                    <th>Paid invoices</th>
                    @foreach ($facture_payes_par_banques as $facture_payes_par_bank)
                        <td>
                           <strong>  {{ $facture_payes_par_bank->nombre}}</strong> Invoices
                            <hr> 
                            {{ format_prix($facture_payes_par_bank->montant)}} Fcfa
                        </td>
                    @endforeach 
                </tr>
                <tr>
                    <th>Bills to pay</th>
                    @foreach ($facture_a_payees_par_banques as $facture_a_payees_par_bank)
                        <td>
                           <strong style="font-size: 18px">  {{ $facture_a_payees_par_bank->nombre}}</strong> Factures
                            <hr> 
                            {{ format_prix($facture_a_payees_par_bank->montant)}} Fcfa
                         </td>
                       
                    @endforeach 
                </tr> 
                <tr style="background-color: #52836338">
                    <th >Fund consumption rate</th>
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
        
        <p class="col-md-offset-1 col-md-10 titre_tableau">Supplier payment terms by bank</p>
       
        <div class="col-md-4 graphique_respect_delais_de_paiement" id="delais_de_paiement_atlantique">

        </div>
        <div class="col-md-4 graphique_respect_delais_de_paiement" id="delais_de_paiement_coris">

        </div>
        <div class="col-md-4 graphique_respect_delais_de_paiement" id="delais_de_paiement_boa" >

        </div>
        
    </div>
    <div class="row">
        
        <p class="col-md-offset-2 col-md-8 center titre_tableau">Number of payment requests rejected by banks </p>
       
        <div class="col-md-offset-2 col-md-6 graphique_respect_delais_de_paiement" id="demande_depaiement_rejete">

        </div>
        
        
    </div>
    
    
    
</div>
@endsection
@section('script_additionnel')
<script language = "JavaScript">
    var url = "{{ route('situation_des_factures') }}"
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
                        var soumises= [];
                        var payees= [];
                        var  en_attente_de_paiement= [];
                        var donnch= new Array();
                        var status = new Array();
                    for(var i=0; i<donnee.length; i++)
                    {
                        soumises.push(parseInt(donnee[i].nbre_facture_soumis_aux_bank));
                        payees.push(parseInt(donnee[i].nbre_facture_payee));
                        en_attente_de_paiement.push(parseInt(donnee[i].nbre_facture_en_attente));
                    }
                    donnch.push({
                                name: 'register',
                                data:soumises,
                                color:'blue',
                                dataLabels: {
                                enabled: true,
                                }
                            })
                    donnch.push({
                                name: 'paid',
                                data:payees,
                                color:'green',
                                dataLabels: {
                                enabled: true,
                                }
                            })
                    donnch.push({
                                name: 'Pending payment',
                                data:en_attente_de_paiement,
                                color:'red',
                                dataLabels: {
                                enabled: true,
                                }
                            })
                   
                    console.log(donnch);
                    for(var i=0; i<donnee.length; i++)
                            {
                                    status[i] = donnee[i].nom_banque
                            }
                    
                    Highcharts.chart('statut_des_factures_par_bank', {
                        chart: {
                                    type: 'column'
                                },
                        xAxis: {
                                 categories: status
                            },
                        title: {
                            text: 'Invoice status by bank'
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
                        series:donnch
                    });

}

});      
</script>
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
                                y:  parseInt(donnee[i].nombre_de_facture),
                                color:'#602239',
                                dataLabels: {
                                enabled: true,
                                }
                            }  )
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
                            text: 'Number of invoices rejected by banks'
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
                        // var dans_les_delais= [];
                        // var retard_trois_jours= [];
                        // var  retard_sept_jours= [];
                        // var  retard_dix_jours= [];
                        // var  retard_dix_jours_et_plus= [];
                    
                    for(var i=0; i<donnee.length; i++)
                    {
                        if(donnee[i].statut_paiement== 'Dans les delais'){
                                var cl='green'
                                var nam='On schedule'
                        }
                        else if(donnee[i].statut_paiement== 'Retard [0,3] jrs'){
                                var cl='#d3d326'
                                 var nam='Delay [0,3] days'
                        }
                        else if(donnee[i].statut_paiement== 'Retard ]3,7] jrs'){
                                var cl='#d8b71f'
                                 var nam='Delay ]3,7] days'
                        }
                        else if(donnee[i].statut_paiement== 'Retard ]7,10] jrs'){
                                var cl='orange'
                                 var nam='Delay ]7,10] days'
                        }
                        else{
                            var cl='red'
                             var nam='Over 10 days late';
                        }
                      donnch.push({
                                name: nam,
                                y:  parseInt(donnee[i].nombre), 
                                color:cl,
                                dataLabels: {
                                enabled: true,
                                }
                            } 
                           )
                    }
                   // console.log(donnch)
                    for(var i=0; i<donnee.length; i++)
                            {
                                if(donnee[i].statut_paiement=='Dans les delais'){
                                        var stat='On schedule';
                                }
                                else if(donnee[i].statut_paiement=='Retard [0,3] jrs'){
                                    var stat='Delay [0,3] days';
                                }
                                else if(donnee[i].statut_paiement=='Retard ]3,7] jrs'){
                                    var stat='Delay ]3,7] days';
                                }
                                else if(donnee[i].statut_paiement=='Retard ]7,10] jrs'){
                                    var stat='Delay ]7,10] days';
                                }
                                else{
                                    var stat='Over 10 days late';
                                }
                                    status[i] = stat
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
                                    enabled: true
                                },
                                    showInLegend: true
                            }
                        },
                        series: [{
                            name: 'Bills',
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
                        
                        if(donnee[i].statut_paiement== 'Dans les delais'){
                                var cl='green'
                                var nam='On schedule'
                        }
                        else if(donnee[i].statut_paiement== 'Retard [0,3] jrs'){
                                var cl='#d3d326'
                                 var nam='Delay [0,3] days'
                        }
                        else if(donnee[i].statut_paiement== 'Retard ]3,7] jrs'){
                                var cl='#d8b71f'
                                 var nam='Delay ]3,7] days'
                        }
                        else if(donnee[i].statut_paiement== 'Retard ]7,10] jrs'){
                                var cl='orange'
                                 var nam='Delay ]7,10] days'
                        }
                        else{
                            var cl='red'
                             var nam='Over 10 days late';
                        }
                      donnch.push({
                                name: nam,
                                y:  parseInt(donnee[i].nombre),
                                color:cl,
                                dataLabels: {
                                enabled: true,
                                }
                            } )
                    }
                    for(var i=0; i<donnee.length; i++)
                            {
                                if(donnee[i].statut_paiement=='Dans les delais'){
                                        var stat='On schedule';
                                }
                                else if(donnee[i].statut_paiement=='Retard [0,3] jrs'){
                                    var stat='Delay [0,3] days';
                                }
                                else if(donnee[i].statut_paiement=='Retard ]3,7] jrs'){
                                    var stat='Delay ]3,7] days';
                                }
                                else if(donnee[i].statut_paiement=='Retard ]7,10] jrs'){
                                    var stat='Delay ]7,10] days';
                                }
                                else{
                                    var stat='Over 10 days late';
                                }
                                    status[i] = stat
                            }
                    //console.log(donnee);
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
                        
                         tooltip: {
                            pointFormat: '{series.name}: <b>{point.y}</b> ({point.percentage:.1f}%)<br/>'
                         },
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
                            name: 'Bills',
                            colorByPoint: true,
                            data: donnch
                        }],
                        
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
                        if(donnee[i].statut_paiement== 'Dans les delais'){
                                var cl='green'
                                var name ='On schedule'
                        }
                        else if(donnee[i].statut_paiement== 'Retard [0,3] jrs'){
                                var cl='#d3d326'
                                 var name ='Delay [0,3] days'
                        }
                        else if(donnee[i].statut_paiement== 'Retard ]3,7] jrs'){
                                var cl='#d8b71f'
                                 var name ='Delay ]3,7] days';
                        }
                        else if(donnee[i].statut_paiement== 'Retard ]7,10] jrs'){
                                var cl='orange'
                                 var name ='Delay ]7,10] days';
                        }
                        else{
                            var cl='red'
                             var name ='Over 10 days late';
                        }
                      donnch.push({
                                name: name,
                                y:  parseInt(donnee[i].nombre),
                                color:cl,
                                dataLabels: {
                                enabled: true,
                                }
                            } )
                    }
                    for(var i=0; i<donnee.length; i++)
                            {
                                if(donnee[i].statut_paiement=='Dans les delais'){
                                        var stat='On schedule';
                                        
                                }
                                else if(donnee[i].statut_paiement=='Retard [0,3] jrs'){
                                    var stat='Delay [0,3] days';
                                }
                                else if(donnee[i].statut_paiement=='Retard ]3,7] jrs'){
                                    var stat='Delay ]3,7] days';
                                }
                                else if(donnee[i].statut_paiement=='Retard ]7,10] jrs'){
                                    var stat='Delay ]7,10] days';
                                }
                                else{
                                    var stat='Over 10 days late';
                                }
                                    status[i] = stat
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
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
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
                            name: 'Bills',
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
                            name: 'Bills',
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
                                    name: 'Bills',
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