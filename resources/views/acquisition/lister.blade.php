@extends("layouts.admin")
@section('finacement', 'active')
@section($type_entreprise, 'active')
@section("asuivre", 'active')
@section('blank')
    <li>Accueil</li>
    <li>Aquisitions </li>
    <li><a href="">Liste</a></li>
@endsection
@section('content')
        <div class="block full">
            <div class="block-title">
                <div class="row">
                    <div class="col-md-12">
                    <h2>Liste des <strong>Aquisitions de l'entreprise {{ $entreprise->denomination }}</strong></h2>
                   
                </div>
                </div>
            </div>
<div class="table-responsive">
<table class="table table-vcenter table-condensed table-bordered listepdf">
        <thead>
                <tr>
                    <th>Catégorie</th>
                    <th>Designation</th>
                    <th>Description</th>
                    <th>quantite</th>
                    <th>Prix unitaire</th>
                    <th>Cout Total</th>
                    <th>Valider</th>

                </tr>
        </thead>
        <tbody>
            @foreach($entreprise->acquisitions as $aquisition)
                <tr>
                    <td>{{getlibelle($aquisition->categorie_invest)}}</td>
                    <td>{{$aquisition->designation}}</td>
                    <td>{{$aquisition->description}}</td>
                    <td>{{$aquisition->quantite}}</td>
                    <td>{{$aquisition->cout_unitaire}}</td>
                    <td>{{$aquisition->cout_total}}</td>
                    <td class="text-center">
                       <input type="checkbox" name="" id="{{ $aquisition->id }}" value="{{ $aquisition->id }}" onclick="validerAcquisition('{{ $aquisition->id }}');"
                       @if($aquisition->acquis==1)
                            checked 
                       @endif>    
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a onclick="recharger_page_precedente()" class="btn btn-danger pull-right" style="float: right;"><span><i class="fa fa-times"></i></span> Fermer la page</a>
</div>
        </div>
@endsection
@section("script_additionnel")
    <script>

    function validerAcquisition(id){
               var valeur= $('#'+id).val();
              // alert(valeur);
             var x= $('#' + id).is(":checked")
               var url = "{{ route('acquisition.valider') }}";
                    $.ajax({
                        url: url,
                        type:'GET',
                        dataType:'json',
                        data: {id: valeur, cocher:x} ,
                        error:function(){alert('error');},
                        success:function(data){
                            location.reload();
                        }
                    });
        }
    </script>
@endsection


