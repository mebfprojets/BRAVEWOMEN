@extends('layouts.admin')
@section($active_principal, 'active')
@section($active, 'active')


@section('content')
<div class="block full">
    <div class="block-title">
        <h2><strong>Synthèse</strong> de l'analyse des membres du comité techique</h2>

    </div>

    <div class="table-responsive">
        <table id="" class="table table-vcenter table-condensed table-bordered listepdf">
            <thead>
                <tr>
                    {{-- <th class="text-center">N°</th> --}}
                    <th class="text-center" style="width:10px;" >Code promoteur</th>
                    <th class="text-center" >Denomination</th>
                    <th class="text-center">Télephone</th>
                    <th class="text-center">zone</th>
                    <th class="text-center">Nombre de votant</th>
                    <th class="text-center" style="width: 5%;">Decisions des membre</th>
                    <th class="text-center" style="width: 5%;">Action</th>
                    <th class="text-center" style="width: 5%;">Verdict</th>
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
                    <tr>
                        {{-- <td class="text-center" style="width: 10%">{{ $i }}</td> --}}
                        <td class="text-center" style="width: 5%;" >
                            {{ $entreprise->promotrice->code_promoteur }}
                        </td>
                        <td class="text-center">{{ $entreprise->denomination }}</td>
                        <td class="text-center">{{ $entreprise->promotrice->telephone_promoteur }}</td>
                        <td class="text-center">{{ getlibelle($entreprise->region)}}</td>
                        <td class="text-center" style="width: 5%;">{{ count($entreprise->decisions) }} votants</td>
                     <td class="text-center">
                        @foreach($entreprise->decisions as $decision)
                            @if($decision->decision =="selectionnee")
                                <span style="background-color: green; width:2px; height:1px;">|</span>
                            @else
                                <span style="background-color: red; width:2px; height:1px;">|</span>
                            @endif
                           @endforeach
                    </td>
                    <td>
         @can('souscription.statuerSurSouscription', Auth::user())
                    @if($entreprise->decision_du_comite_phase1 == null)
                        <a href="#modal-decision-du-comite" data-toggle="modal" onclick="confirmChangeStatus1({{$entreprise->id}}, {{ Auth::user()->id }})" title="La décision du comité" class="btn btn-md btn-danger"><i class="fa fa-check"></i></a>  
                    @endif
                    </td>
        @endcan
                    <td class="text-center">
                        {{ $entreprise->decision_du_comite_phase1 }}
                    </td> 
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
<script>
    function confirmChangeStatus1(id_entreprise, id_user){
            document.getElementById("id_entreprise").setAttribute("value", id_entreprise);
            document.getElementById("id_user").setAttribute("value", id_user);
    }
    function validerdossier(){
        $(function(){
            var id_entreprise= $("#id_entreprise").val();
            var id_user= $("#id_user").val();
            var raison= null;
            var url = "{{ route('entreprise.statuermembrecomite') }}";
            $.ajax({
                url: url,
                type:'GET',
                data: {id_entreprise: id_entreprise, id_user : id_user} ,
                error:function(){alert('error');},
                success:function(){
                   // $('#modal-confirm-changestatus').hide();
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
    function statuersurLasoucriptionPmeParleComitePourLaPhaseFormation(statut){
        var id_entreprise= $("#id_entreprise").val();
        var observation= $("#observation").val();
        var url = "{{ route('entreprise.statuercomitetechniquepmephase1') }}";
        $.ajax({
                url: url,
                type:'GET',
                data: {id_entreprise: id_entreprise, observation:observation, statut:statut} ,
                error:function(){alert('error');},
                success:function(){
                    $('#modal-confirm-rejet').hide();
                    location.reload();
                }
            });
    }
    </script>

