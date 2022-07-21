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
        <h2><strong>Souscription validée avec succes</h2>
    </div>
       <p>Votre souscription a été validée avec success. Merci de consulter le récépissé dans votre boite email.  </p>
       <a href="{{ route("accueil") }}" class="btn btn-danger">Retour</a>
</div>
@endsection
