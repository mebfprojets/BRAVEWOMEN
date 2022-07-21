@extends("layouts.public")
@section("main-content")
<div class="block">
    @if(Session::has('success'))

    <div class="alert alert-success">

        {{Session::get('success')}}

    </div>

@endif

    <!-- Wizard with Validation Title -->
    <div class="block-title">
        <h2><strong>Notification </h2>
    </div>
       <p>Vous avez terminé le processus de création de l'entreprise et du projet. Souhaitez-vous enregistrer une deuxième entreprise?</p>
       @if($promoteur!=null)
        <a href="{{ route("secondEntreprise.store",$promoteur) }}" class="btn btn-success">Enregistrer une autre</a>
       @endif
       <a href="{{ route("accueil") }}" class="btn btn-danger">Retour</a>
</div>
@endsection
