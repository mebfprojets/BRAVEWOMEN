@extends('layouts.admin')
@section('souscription','active')
@section('formation', 'active')
@section('all_formation', 'active')
{{-- @section('formation-sessions', 'active') --}}

@section('content')

<div class="col-md-6" id="listecandidat">
        <!-- Basic Form Elements Title -->

                <!-- Form Validation Example Block -->
                <div class="block">
                    <!-- Form Validation Example Title -->
                    <div class="block-title">
                        <h2> Ajouter les participants <strong>à la session du {{ date('d-m-Y', strtotime($formation->date_debut))}}  au {{ date('d-m-Y', strtotime($formation->date_fin))}}</strong></h2>
                        <input type="hidden" id="formation" value="{{ $formation->id }}">
                            <a  onclick="selectionner();" class="btn btn-success pull-right"><span></i></span>Ajouter</a>
                    </div>
<div class="table-responsive">
    <table class="table table-vcenter table-condensed table-bordered listepdf">
        <thead>
                <tr>
                    <th>Selectionner</th>
                    <th>Region</th>
                    <th>Province</th>
                    <th>Denomination</th>
                    <th>code_promoteur</th>
                    <th>telephone_promoteur</th>
                </tr>
        </thead>
        <tbody>
            @foreach($entreprises_retenues as $entreprise)
                <tr>
                    <td>
                        <input type="hidden" id="formation" value="{{ $formation->id }}">
                        <input type="checkbox" name="" id="{{ $entreprise->id }}" value="{{ $entreprise->id }}">
                    </td>
                    <td>{{getlibelle($entreprise->region)}}</td>
                    <td>{{getlibelle($entreprise->province)}}</td>
                    <td>{{$entreprise->denomination}}</td>
                    <td>{{$entreprise->promotrice->code_promoteur}}</td>
                    <td>{{$entreprise->promotrice->telephone_promoteur}}</td>
                </tr>
            @endforeach
        </tbody>
        </table>
        </div>
    </div>


    </div>

    <div class="col-md-6" id="decochercandidat">
        <div class="block">
            <!-- Form Validation Example Title -->
            <div class="block-title">
                <a  onclick="deselectionner();" class="btn btn-success pull-right" style="margin-left: 10px"><span></i></span>Supprimer</a>
                {{-- <a href="#modal-confirm-presence" data-toggle="modal" onclick="present();" class="btn btn-success pull-right" ><span></i></span>Valider la présence</a> --}}
                <a  onclick="present();" class="btn btn-success pull-right" ><span></i></span>Valider la présence</a>
                <h2> Liste <strong>des participant à {{$formation->libelle}}</strong></h2>
            </div>
    <div class="table-responsive">
        <table class="table table-vcenter table-condensed table-bordered listepdf">
        <thead>
            <tr>
                <th>Cocher</th>
                <th>Region</th>
                <th>Province</th>
                <th>Denomination</th>
                <th>code_promoteur</th>
                <th>telephone_promoteur</th>
            </tr>
    </thead>
    <tbody>
    @foreach($participants as $participant)
        <tr @if($participant->present=='oui')
            style="color:green;"
        @endif>
            <td>
                <input type="checkbox" name="" id="{{ $participant->entreprise->id }}" value="{{ $participant->entreprise->id }}">
            </td>
            <td>{{getlibelle($participant->entreprise->region)}}</td>
            <td>{{getlibelle($participant->entreprise->province)}}</td>
            <td>{{$participant->entreprise->denomination}}</td>
            <td>{{$participant->entreprise->promotrice->code_promoteur}}</td>
            <td>{{$participant->entreprise->promotrice->telephone_promoteur}}</td>
        </tr>
    @endforeach
        </tbody>
    </table>
</div>
</div>
<a onclick="history.back()" class="btn btn-danger pull-right" style="float: right;"><span><i class="fa fa-times"></i></span> Fermer la page</a>

</div>
@endsection
@section('modalSection')
    <div id="modal-confirm-delete" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
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
                                <p>Voulez-vous vraiment Supprimer ce role ??</p>
                            <div class="form-group form-actions">
                                <div class="text-right">
                                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                                    <button type="submit" class="btn btn-sm btn-primary" onclick="supp_id();">OUI</button>
                                </div>
                            </div>

                    </div>
                    <!-- END Modal Body -->
                </div>
            </div>
    </div>


    <script>
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

@endsection

