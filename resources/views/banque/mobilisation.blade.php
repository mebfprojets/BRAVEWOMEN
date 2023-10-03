@extends('layouts.admin')
@section('beneficiaires_bank', 'active') 
@section('content')
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

