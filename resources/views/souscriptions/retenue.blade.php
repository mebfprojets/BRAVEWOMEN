@extends('layouts.admin')
@section($active_principal, 'active')
@section($active, 'active')


@section('content')
<div class="block full">
    <div class="block-title">
        <h2><strong>Liste</strong> des souscriptions retunues {{ $titre }} pour la formation</h2>
    </div>

    <div class="table-responsive">
        <table id="" class="table table-vcenter table-condensed table-bordered listepdf">
            <thead>
                <tr>
                    <th class="text-center">N°</th>
                    <th class="text-center" style="width:10px;" >Code promoteur</th>
                    <th class="text-center">Entreprise</th>
                    <th class="text-center">Télephone </th>
                    <th class="text-center">Télephone </th>
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
                       <td class="text-center" style="width: 10%">{{ $i }}</td>
                        <td class="text-center" style="width: 5%;" >
                            {{ $entreprise->promotrice->code_promoteur }} {{-- <a href="{{ route("promoteur.edit", $entreprise->promotrice->slug) }}">{{ $entreprise->promotrice->code_promoteur }} </a> --}}
                        </td>
                        <td class="text-center">
                             {{ $entreprise->denomination }}
                        </td>
                        <td class="text-center">{{ $entreprise->promotrice->telephone_promoteur }}</td>
                        <td class="text-center">{{ $entreprise->telephone_entreprise }}</td>

                        {{-- <td class="text-center">{{ $entreprise->secteur_activite }}</td> --}}
                        {{-- <td class="text-center">
                            <a href="{{ route("projet.edit",$entreprise->projet->id) }}">Detail sur le projet</a>
                        </td> --}}
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route("entreprise.show",$entreprise) }}" data-toggle="tooltip" title="Visualiser" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i></a>
                                {{-- <a href="#modal-ajouter-a-session" data-toggle="modal" onclick="confirmChangeStatus({{$entreprise->id}})" title="Valider" class="btn btn-xs btn-success"><i class="fa fa-check"></i></a> --}}
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
    function confirmChangeStatus(id){
            document.getElementById("id_table").setAttribute("value", id);
    }
    function validerdossier(){
        $(function(){
            var id= $("#id_table").val();
            //alert(id);
            var url = "{{ route('entreprise.valider') }}";
            $.ajax({
                url: url,
                type:'GET',

                data: {id: id} ,
                error:function(){alert('error');},
                success:function(){
                    $('#modal-confirm-changestatus').hide();
                    location.reload();
                }
            });
            });
    }

    </script>

