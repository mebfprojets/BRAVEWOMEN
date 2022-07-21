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
        <h2><strong>Code Promoteur invalid </h2>
    </div>
       <p class="text-danger">Ce code promoteur est incorrect</p>
       <a href="{{ route("afficherform") }}" class="btn btn-danger">Réessayer</a>
       <a href="{{ route("accueil") }}" class="btn btn-danger">Abandonner</a>
</div>
@endsection
