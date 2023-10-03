@extends('layouts.admin')
@section('beneficiaires_bank', 'active') 

@section('content')
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
                    <th class="text-center">Entreprise</th>
                    <th class="text-center">Banque</th>
                    <th class="text-center">Télephone</th>
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
                @foreach ($entreprises as $entreprise)
                        @php
                           $i++;
                        @endphp
                    <tr>
                         <td class="text-center" style="width: 2%">{{ $i }}</td>
                        <td class="text-center" style="width: 5%;" >
                            {{ $entreprise->denomination }}
                        </td>
                        <td class="text-center" style="width: 5%;" >
                            {{ $entreprise->banque->nom }}
                        </td>
                        <td class="text-center" style="width: 5%;" >
                            {{ $entreprise->telephone_entreprise }}
                        </td>
                        <td class="text-center" style="width: 5%;">
                            @if($entreprise->projet)
                            {{ format_prix($entreprise->projet->investissementvalides->sum('montant_valide')) }} 
                            @else
                            Non disponible 
                            @endif
                        </td>
                        <td class="text-center" style="width: 5%;">{{ format_prix($entreprise->accomptes->sum('montant')) }}</td>
                        <td class="text-center" style="width: 5%;">{{ format_prix($entreprise->subventions->sum('montant_subvention'))}}</td>
                        <td class="text-center" style="width: 5%;">{{ format_prix($entreprise->subventions->sum('montant_subvention')+ $entreprise->accomptes->sum('montant'))}}</td>
                        <td class="text-center" style="width: 7%;">
                            <div class="btn-group">
                                <a href="{{ route("entreprise.show",$entreprise) }}" data-toggle="tooltip" title="Visualiser les details du projet de la promotrice" class="btn btn-md btn-default"><i class="fa fa-eye"></i></a>

                            @can('enregistrer_contrepartie',Auth::user())
                                <a href="{{ route("entreprise.accompte",$entreprise) }}" data-toggle="tooltip" title="Gérer les accomptes  du bénéficiaire" class="btn btn-md btn-success"><i class="gi gi-money"></i></a>
                            @endcan
                            @can('enregistrer_subvention',Auth::user())
                                <a href="{{ route("entreprise.subvention",$entreprise) }}" data-toggle="tooltip" title="Gérer les virements ICD sur le compte du bénéficiaire" class="btn btn-md btn-warning"><i class="gi gi-down_arrow"></i></a>
                            @endcan
                            {{-- @can('enregistrer_paiement',Auth::user())
                                <a href="{{ route("facture.valide_de_lentreprise",$entreprise) }}" data-toggle="tooltip" title="Gérer les paiements fournisseurs" class="btn btn-md btn-danger"><i class="gi gi-bullhorn"></i></a>
                                 @endcan --}}
                            </div>
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

