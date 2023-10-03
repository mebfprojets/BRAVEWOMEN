@extends("layouts.espace_beneficiaire")
@section('content_space')
<div class="block">
    <div class="block-title">
        <h2><i class="fa fa-file-o"></i> <strong>Informations Entreprise</strong></h2>
    </div>
<table class="table table-vcenter table-condensed table-bordered">
   
    <tbody>
        @foreach ($promotrice->entreprises as $entreprise)
        <tr>
            <td>{{ $entreprise->denomination }}</td>
            <td> <a href="http://">Joindre Le PCA </a> </td>
            <td> <a href="http://">  Soumettre Devis</a></td>
            <td> <a href="http://"> Situation </a></td>
        </tr>
        @endforeach
    </tbody>
</table>
    
</div>
@endsection
