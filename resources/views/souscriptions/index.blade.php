@extends('layouts.admin')
@section('souscription', 'active')
@section('gestion', 'active')
@section('souscription_enregistre', 'active')
@section('content')
<div class="block full">
    <div class="block-title">
        <h2><strong>Liste</strong> des souscriptions</h2>
    </div>

    <div class="table-responsive">
        <table id="" class="table table-vcenter table-condensed table-bordered listepdf">
            <thead>
                <tr>
                    {{-- <th class="text-center">N°</th> --}}
                    <th class="text-center" style="width:10px;">Code promoteur</th>
                    <th class="text-center">Nom</th>
                    <th class="text-center" >Prenom</th>
                    <th class="text-center">Télephone</th>
                    <th class="text-center">Entreprise</th>
                    <th class="text-center">Secteur d'activite</th>
                    <th class="text-center">Projet</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                  $i=0;
                @endphp
                @foreach ($promoteurs as $promoteur)
                        @php
                           $i++;
                        @endphp
                    <tr>
                        {{-- <td class="text-center" style="width: 10%">{{ $i }}</td> --}}
                        <td class="text-center">{{ $promoteur->code_promoteur }} </td>
                        <td class="text-center">{{ $promoteur->nom }}</td>
                        <td class="text-center">{{ $promoteur->prenom }}</td>
                        <td class="text-center">{{ $promoteur->telephone_promoteur }}</td>
                        <td class="text-center">{{ $promoteur->entreprise->denomination }}</td>
                        <td class="text-center">{{ $promoteur->entreprise->projet->objectif }}</td>
                        <td class="text-center">{{ $promoteur->entreprise->secteur_activite }}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="" data-toggle="tooltip" title="Editer" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                <a href="" data-toggle="tooltip" title="Visualiser" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i></a>
                                <a href="" data-toggle="tooltip" title="Imprimer" class="btn btn-xs btn-default"><i class="fa fa-print"></i></a>
                                <a title="Valider" class="btn btn-xs btn-success"><i class="fa fa-check"></i></a>
                                {{-- <a  href="#modal-confirm-delete" onclick="delConfirm({{ $parametre->id }});" data-toggle="modal" title="Supprimer" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a> --}}
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
    function delConfirm(id){
            //alert(id);
            document.getElementById("id_table").setAttribute("value", id);

    }
    function supp_id(){
            var id= $("#id_table").val();

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
    }
    </script>

