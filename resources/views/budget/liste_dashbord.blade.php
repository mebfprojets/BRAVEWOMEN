@extends("layouts.admin")
@section('dashboard', 'active')
@section('budget_dashbord', 'active')
@section('blank')
    <li>Accueil</li>
    <li>Budget</li>
    <li><a href="">Listes</a></li>
@endsection
@section('content')
        <div class="block full">
            <div class="block-title">
                <div class="row">
                    <div class="col-md-12">
                        <h2 > <strong>Budget performance</strong></h2>
                    </div> 
              
                    </div>
                    
                </div>
              
<div class="table-responsive">
<table class="table table-striped table-vcenter">
        <thead>
                <tr style="font-size:10px !important; font-family: 'helvetica neue', helvetica, arial, sans-serif; font-style: italic;">
                    <th style="width: 28%">Components </th>
                    <th style="width: 14%">Budgeted amount</th>
                    @if($trimestre==1)
                        <th style="width: 14%">Total spent Q4 {{ $annee -1 }}</th>
                    @else
                        <th style="width: 14%">Total spent Q T {{ $trimestre - 1}}</th>
                    @endif
                    <th style="width: 14%">Expenses Q {{ $trimestre}}</th>
                    <th style="width: 14%">Balance at Q {{ $trimestre}}</th>
                    <th style="width: 2%">Consumption rate</th>
                </tr>
        </thead>
        <tbody>
            @foreach($budgets as $budget)
                <tr>
                    <td>{{$budget->composante}}</td>
                    <td>$US {{ format_dollar_prix($budget->montant_budgetise)}} </td>
                    <td>$US {{ format_dollar_prix($budget->cumul_depense_au_T_1)}} </td>
                    <td>$US {{format_dollar_prix($budget->depense_du_trimestre)}} </td>
                    <td>$US {{format_dollar_prix($budget->solde_du_trimestre)}} </td>
                    <td class="col-md-2">
                    @if(taux_execution_budget($budget->montant_budgetise,$budget->cumul_depense_au_T_1)<50)
                        <div class="progress">
                            <div class="progress-bar progress-bar-danger"  role="progressbar" style="width: {{taux_execution_budget($budget->montant_budgetise,$budget->cumul_depense_au_T_1)}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{taux_execution_budget($budget->montant_budgetise,$budget->cumul_depense_au_T_1)}}%</div>
                          </div>
                    @elseif(taux_execution_budget($budget->montant_budgetise,$budget->cumul_depense_au_T_1)>50&& taux_execution_budget($budget->montant_budgetise,$budget->cumul_depense_au_T_1)<75)
                        <div class="progress"  >
                            <div class="progress-bar progress-bar-warning"  role="progressbar" style="width: {{taux_execution_budget($budget->montant_budgetise,$budget->cumul_depense_au_T_1)}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{taux_execution_budget($budget->montant_budgetise,$budget->cumul_depense_au_T_1)}}%</div>
                         </div>
                    @else
                    <div class="progress"  >
                        <div class="progress-bar progress-bar-success"  role="progressbar" style="width: {{taux_execution_budget($budget->montant_budgetise,$budget->cumul_depense_au_T_1)}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{taux_execution_budget($budget->montant_budgetise,$budget->cumul_depense_au_T_1)}}%</div>
                     </div>
                     @endif 
                    </td>
                </tr>
                
            @endforeach
            <tr style="background-color: rgb(192, 212, 177)">
                <td>Total</td>
                <td><strong>$US {{ format_dollar_prix($budget->sum('montant_budgetise'))}}  </strong></td>
                <td><strong>$US {{ format_dollar_prix($budget->sum('cumul_depense_au_T_1'))}} </strong> </td>
                <td><strong>$US {{ format_dollar_prix($budget->sum('depense_du_trimestre'))}} </strong></td>
                <td><strong>$US {{ format_dollar_prix($budget->sum('solde_du_trimestre'))}} </strong></td>
               
            </tr>
        </tbody>
    </table>
</div>



</div>
<div class="block full">
    <div class="block-title">
        <div class="row">
            <div class="col-md-12">
                <h2 >Budget forecast for the coming quarters</h2>
            </div> 
      
            </div>
            
        </div>
      
<div class="table-responsive">
<table class="table  table-striped table-vcenter">
<thead>
        <tr style="font-size:10px !important; font-family: 'helvetica neue', helvetica, arial, sans-serif; font-style: italic;">
            <th>Component </th>
            <th>Amount budgeted</th>
            <th>T{{ $ptrimestre}}-{{ $prev_annee }} </th>
        @if($ptrimestre==1)
            <th>T {{$ptrimestre +1}}-{{ $prev_annee }} </th>
            <th>T{{ $ptrimestre +2}}-{{ $prev_annee }} </th>
            <th>T{{ $ptrimestre +3 }}-{{ $prev_annee }} </th>
        @elseif($ptrimestre==2)
                <th>T {{$ptrimestre +1}}-{{ $prev_annee }} </th>
                <th>T{{ $ptrimestre +2}}-{{ $prev_annee }} </th>
                <th>T1 - {{ $prev_annee + 1}} </th>
        @elseif($ptrimestre==3)
                <th>T {{$ptrimestre +1}}-{{ $prev_annee }} </th>
                <th>T1 -{{ $prev_annee + 1 }} </th>
                <th>T2 - {{ $prev_annee + 1}} </th>
        @else
                <th>T1 -{{ $prev_annee }} </th>
                <th>T2 -{{ $prev_annee + 1 }} </th>
                <th>T3 - {{ $prev_annee + 1}} </th>
        @endif
        </tr>
</thead>
<tbody>
    @foreach($prevision_budgets as $budget)
        <tr>
            <td>{{$budget->activite}}</td>
            <td>$US {{format_dollar_prix($budget->montant_budgetise)}}</td>
            <td>$US {{format_dollar_prix($budget->montant_depense)}}</td>
            <td>$US {{format_dollar_prix($budget->prevision_mois_n)}}</td>
            <td>$US {{format_dollar_prix($budget->prevision_mois_n1)}}</td>
            <td>$US {{format_dollar_prix($budget->prevision_mois_n2)}}</td>
            
        </tr>
        
    @endforeach
    <tr style="background-color: rgb(192, 212, 177)">
        <td>Total</td>
        <td><strong>$US {{format_dollar_prix( $prevision_budgets->sum('montant_budgetise'))}}</strong> </td>
        <td><strong>$US {{ format_dollar_prix($prevision_budgets->sum('montant_depense')) }}</strong></td>
        <td><strong>$US {{ format_dollar_prix($prevision_budgets->sum('prevision_mois_n'))}}</strong></td>
        <td><strong>$US {{ format_dollar_prix($prevision_budgets->sum('prevision_mois_n1')) }}</strong></td>
        <td><strong>$US {{ format_dollar_prix($prevision_budgets->sum('prevision_mois_n2'))}}</strong></td>
    </tr>
</tbody>
</table>
</div>



</div>
<div class="block full">
    <div class="block-title">
        <div class="row">
            <div class="col-md-12">
                <h2 >Cashflow <strong></strong></h2>
            </div> 
      
            </div>
            
        </div>
      
<div class="table-responsive">
<table class="table  table-striped table-vcenter">
<thead>
        <tr style="font-size:10px !important; font-family: 'helvetica neue', helvetica, arial, sans-serif; font-style: italic;">
            <th style="width:40%">Libelle </th>
            <th>T{{$trimestre_cashf}}-{{ $annee_cashf }} </th>
            @if($trimestre_cashf==1)
            <th>T{{$trimestre_cashf +1}}-{{ $annee_cashf }} </th>
            <th>T{{ $trimestre_cashf +2}}-{{ $annee_cashf }} </th>
            <th>T{{ $trimestre_cashf +3 }}-{{ $annee_cashf }} </th>
        @elseif($trimestre_cashf==2)
                <th>T {{$trimestre_cashf +1}}-{{ $annee_cashf }} </th>
                <th>T{{ $trimestre_cashf +2}}-{{ $annee_cashf }} </th>
                <th>T1 - {{ $annee_cashf + 1}} </th>
        @elseif($trimestre_cashf==3)
                <th>T {{$trimestre_cashf +1}}-{{ $annee_cashf }} </th>
                <th>T1 -{{ $annee_cashf + 1 }} </th>
                <th>T2 - {{ $annee_cashf + 1}} </th>
        @else
                <th>T1 -{{ $annee_cashf }} </th>
                <th>T2 -{{ $annee_cashf + 1 }} </th>
                <th>T3 - {{ $annee_cashf + 1}} </th>
        @endif
        </tr>
</thead>
<tbody>
    <tr>
        <td style="with:100%">Inputs</td>
    </tr>
    @foreach($cashflow_entres as $cashflow_entre)
        <tr>
            <td>{{$cashflow_entre->libelle}}</td>
            <td>$US {{format_dollar_prix($cashflow_entre->trimestre1)}}</td>
            <td>$US {{format_dollar_prix($cashflow_entre->trimestre2)}}</td>
            <td>$US {{format_dollar_prix($cashflow_entre->trimestre3)}}</td>
            <td>$US {{format_dollar_prix($cashflow_entre->trimestre4)}}</td>
        </tr>
        
    @endforeach
    <tr>
        <td>Total</td>
        <td><strong>$US {{ format_dollar_prix($cashflow_entres->sum('trimestre1')) }}</strong> </td>
        <td><strong>$US {{ format_dollar_prix($cashflow_entres->sum('trimestre2')) }}</strong></td>
        <td><strong>$US {{ format_dollar_prix($cashflow_entres->sum('trimestre3')) }}</strong></td>
        <td><strong>$US {{ format_dollar_prix($cashflow_entres->sum('trimestre4') )}}</strong></td>

    </tr>
    <hr>
    <tr>
        <td style="with:100%">Expenses</td>
    </tr>
    @foreach($cashflow_depenses as $cashflow_depense)
    <tr>
        <td>{{$cashflow_depense->libelle}}</td>
        <td>$US {{format_dollar_prix($cashflow_depense->trimestre1)}}</td>
        <td>$US {{format_dollar_prix($cashflow_depense->trimestre2)}}</td> 
        <td>$US {{format_dollar_prix($cashflow_depense->trimestre3)}}</td> 
        <td>$US {{format_dollar_prix($cashflow_depense->trimestre4)}}</td> 

    </tr>
    
@endforeach
    <tr>
        <td>Total</td>
        <td><strong>$US {{format_dollar_prix($cashflow_depenses->sum('trimestre1')) }}</strong> </td>
        <td><strong>$US {{format_dollar_prix($cashflow_depenses->sum('trimestre2')) }}</strong> </td>
        <td><strong>$US {{ format_dollar_prix($cashflow_depenses->sum('trimestre3')) }}</strong> </td>
        <td><strong>$US {{ format_dollar_prix($cashflow_depenses->sum('trimestre4') )}}</strong></td>
    </tr>
    <tr style="background-color: rgb(192, 212, 177)">
        <td>Cash Flow</td>
        <td><strong>$US {{ format_dollar_prix($cashflow_entres->sum('trimestre1') - $cashflow_depenses->sum('trimestre1') )}}</strong> </td>
        <td><strong>$US {{ format_dollar_prix($cashflow_entres->sum('trimestre2') - $cashflow_depenses->sum('trimestre2') )}}</strong></td>
        <td><strong>$US {{ format_dollar_prix($cashflow_entres->sum('trimestre3') - $cashflow_depenses->sum('trimestre3') )}}</strong></td>
        <td><strong>$US {{ format_dollar_prix($cashflow_entres->sum('trimestre4') - $cashflow_depenses->sum('trimestre4') )}}</strong></td>
    </tr>
</tbody>
</table>
</div>



</div>
@endsection

    


    <script>
        function edit_prestataire(id){
                    var id=id;
                    var url = "{{ route('prestataire.modif') }}";
                    $.ajax({
                        url: url,
                        type:'GET',
                        dataType:'json',
                        data: {id: id} ,
                        error:function(){alert('error');},
                        success:function(data){
                            //var motif= data.motif+' '+ data.observation;
                            $("#presta_id").val(data.id);
                            //alert($("#presta_id").val());
                           $("#denomination").val(data.denomination);
                           $("#secteur_activite").val(data.domaine_activite);
                           $("#nom_res").val(data.nom_responsable);
                           $("#prenom_res").val(data.prenom_responsable);
                           $("#telephone").val(data.telephone); 
                           $("#region").val(data.region);
                           $("#province").val(data.province);
                           $("#commune").val(data.commune);
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
        function delConfirm (id){
            //alert(id);
            $(function(){
                //alert(id);
                document.getElementById("id_table").setAttribute("value", id);
            });

        }

        function recu_id(){
            //var id= document.getElementById('id_table').value;
            $(function(){
                var id= $("#id_table").val();

                //alert(id);
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

                //alert(id);
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


