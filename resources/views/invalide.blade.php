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
        <h2><strong>Validité du code promoteur </h2>
    </div>
    @if(!$promoteur)
       <p class="text-danger">Ce code promoteur est incorrect</p>       
    @else
        <p class="text-danger">Oups !!!. Vous avez déjà bénéficié d'une formation et d'un PCA. Merci de contacter nos chefs de zone pour la suite de la procédure.</p>
    @endif
    <a href="{{ route("afficherform") }}" class="btn btn-danger">Réessayer</a>
        <a href="{{ route("accueil") }}" class="btn btn-danger">Abandonner</a>
</div>
@endsection
