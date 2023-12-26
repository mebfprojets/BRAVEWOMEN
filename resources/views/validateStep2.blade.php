@extends("layouts.public")
@section("main-content")
@section('classfooter', 'footersearch')
<div class="block">
    @if(Session::has('success'))

    <div class="alert alert-success">

        {{Session::get('success')}}

    </div>

@endif

    <div class="block-title">
        <h2><strong>Notification </h2>
    </div>
       <p>Vous avez epuisé le quotas d'entreprise possible.</p>
       <p>Le Recépissé est envoyé dans votre boite email.</p>
            <a href="{{ route("generer.recepisse", $promoteur) }}" class="btn btn-success">Generer le recépissé</a>
        <hr>
       <a href="{{ route("accueil") }}" class="btn btn-danger">Retour</a>
</div>
@endsection
