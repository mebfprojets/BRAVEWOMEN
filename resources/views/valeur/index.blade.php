@extends('layouts.admin')
@section('administration', 'active')
@section('administration-valeur', 'active')
@section('content')
<div class="block full">
    <div class="block-title">
        <h2><strong>Liste</strong> des valeur</h2>
        <a href="{{ route('valeurs.create') }}" class="btn btn-success pull-right"><span><i class="fa fa-plus"></i></span>valeurs</a>
    </div>
    <div class="row">

        <div class="row">
        <div class="form-group">
            <label  class="col-md-3 control-label" for="parametre">Parametre concerné <span class="text-danger">*</span> :</label>
            <div class="col-md-9">
                <select   id="parametre" name="parametre"  class="form-control select-select2" onchange="changelistevale();">
                    <option></option>

                    @foreach($parametres as $parametre)
                    <option value="{{ $parametre->id }}">{{ $parametre->libelle }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    </div>

    <div class="table-responsive">
        <table id="listepdf" class="table table-vcenter table-condensed table-bordered listepdf">
            <thead>
                <tr>
                    <th class="text-center">Numéro</th>
                    <th class="text-center">libelle</th>
                    <th class="text-center" >Description</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody id="tbadys">
                @php
                  $i=0;
                @endphp
                @foreach ($valeurs as $valeur)
                        @php
                           $i++;
                        @endphp
                    <tr>
                        <td class="text-center" style="width: 10%">{{ $i }}</td>
                        <td class="text-center">{{ $valeur->libelle }} </td>
                        <td class="text-center">{{ $valeur->description }}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('valeurs.edit',$valeur) }}" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                <a  href="#modal-confirm-delete" onclick="delConfirm({{ $valeur->id }});" data-toggle="modal" title="Supprimer" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
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
    function changelistevale()
         {   var idparent_val = $("#parametre").val();
         var url = '{{ route('valeur.listeval') }}';
             $.ajax({
                     url: url,
                     type: 'GET',
                     data: {idparent_val: idparent_val},
                     dataType: 'json',
                     error:function(data){alert("Erreur");},
                     success: function (data) {


                         var options = '';

                         for (var x = 1; x < data.length; x++) {
                             var rout= '{{ route("valeurs.edit",":id")}}';
                             var rout = rout.replace(':id', data[x]['id']);
                             options +='<tr> <td  width="5%" > ' + x + '</td><td width="20%" > ' + data[x]['libelle'] + '</td><td  width="40%"> ' + data[x]['description'] + '  </td> <td  width="15%"><div class="btn-group"><a  onclick="detailvaleur(' + data[x]['id'] + ' );" href="#modal-voir-detail" data-toggle="modal" title="Voir details" class="btn btn-xs btn-default"><i class="fa fa-eye"></i></a><a href="'+rout+'" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a><a href="#modal-confirm-delete" onclick="delConfirm(' + data[x]['id'] + ');" data-toggle="modal" title="Supprimer" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a></div></td></tr>';
                              }
                        $('#tbadys').html(options);
                     }
             });
         }
    </script>

