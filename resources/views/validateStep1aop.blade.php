@extends("layouts.public")
@section("main-content")
@section('classfooter', 'footersearch')
<div class="block">
    @if(Session::has('success'))

    <div class="alert alert-success">

        {{Session::get('success')}}

    </div>

@endif

    <!-- Wizard with Validation Title -->
    <div class="block-title">
        <h2><strong>Enregistrement des données personnelles du / de la responsable  </h2>
    </div>
    @if($promoteur->suscriptionaopleader_etape == 1)
        <p> Vous avez validé la prémière étape de la souscription.</p>
        Votre code de suivi de la souscription est : {{ $promoteur->code_promoteur }}
         <p style="color: rgb(199, 38, 38)"> Bien vouloir garder ce code pour la suite. Ce code sera envoyé dans votre boîte E-mail. </p>
        <a href="{{ route('entrepriseaopl.new', $promoteur->code_promoteur ) }}?typeentreprise=aop" data-toggle="modal" class="btn btn-success" >Si AOP poursuivre ici</a>
        <a href="{{ route('entrepriseaopl.new', $promoteur->code_promoteur ) }}?typeentreprise=leader" data-toggle="modal" class="btn btn-success" >Si Entreprise leader poursuivre ici</a>
        <a href="#modal-complete-souscription" data-toggle="modal" class="btn btn-danger">Suspendre</a>
    @elseif($promoteur->suscriptionaopleader_etape == 2 )
        <p> Vous avez validé la deuxième étape : l'enregistrement de votre entreprise</p>
        <input type="hidden" name="entreprise" value="{{ $entreprise}}">
        <a href="{{ route("entrepriseaopl.new",$promoteur->code_promoteur) }}?entreprise={{ $entreprise}}" class="btn btn-success">Poursuivre</a>
        <a href="#modal-complete-souscription" data-toggle="modal" class="btn btn-danger">Suspendre</a>
    @elseif ($promoteur->suscriptionaopleader_etape == null)
        <p> Bien vouloir compléter les informations vous concernant avant de continuer </p>
        <a href="{{ route("completeresponsableaop.view",$promoteur->code_promoteur) }}" class="btn btn-success">Completer</a>
        <a href="#modal-complete-souscription" data-toggle="modal" class="btn btn-danger">Suspendre</a>
    @else
        <p> Vous avez validé la troisième étape : l'enregistrement de votre idée de projet</p>
            <p>Le Recépissé est envoyé dans votre boite email.</p>
                    <a href="{{ route("generer.recepisse", $promoteur) }}" class="btn btn-success">Generer le recepissé</a>
                    <a href="{{ route("accueil") }}" class="btn btn-danger">Terminer</a>
              
    @endif
         
         

</div>
@endsection
