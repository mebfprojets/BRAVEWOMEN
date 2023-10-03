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
        <h2><strong>Enregistrement des données personelles de la promotrice </h2>
    </div>
    @if($promoteur->suscription_etape == 1)
        <p> Vous avez validé la prémière étape de la souscription.</p>
        <input type="hidden" name="entreprise" value="">
    @elseif($promoteur->suscription_etape == 2)
        <p> Vous avez validé la deuxième étape : l'enregistrement de votre entreprise</p>
    @else
        <p> Vous avez validé la troisième étape : l'enregistrement de votre idée de projet</p>
    @endif
         Votre code de suivi de la souscription est : {{ $promoteur->code_promoteur }}
         <p style="color: rgb(199, 38, 38)"> Bien vouloir garder ce code pour la suite. Ce code est envoyé dans votre boite mail. </p>
         <form action="{{ route("entrepriseaopl.new",$promoteur->code_promoteur) }}" method="post">
            @csrf
            <input type="hidden" name="promoteur_code" value="{{ $promoteur->code_promoteur }}">
            @if($promoteur->etape_suscription2 == null)
                @if($promoteur->suscription_etape != 3)
                    <button type="submit" class="btn btn-success"> <span> <i class="hi hi-arrow-right"></i> </span> Poursuivre</button>
                    <a href="#modal-complete-souscription" data-toggle="modal" class="btn btn-danger">Suspendre</a>
                @endif
                @if($promoteur->suscription_etape == 3)
                    <p>Le Recépissé est envoyé dans votre boite email.</p>
                    <a href="{{ route("generer.recepisse", $promoteur) }}" class="btn btn-success">Generer le recepissé</a>
                    <a href="{{ route("accueil") }}" class="btn btn-danger">Terminer</a>
                @endif
                @if($promoteur->suscription_etape == 2)
                    <input type="hidden" name="entreprise" value="{{ $entreprise}}">
                @endif
            @endif
            @if($promoteur->etape_suscription2 !=null)
            @if($promoteur->etape_suscription2 == 2)
                <a href="{{ route("secondEntreprise.store",$promoteur) }}" class="btn btn-success">Poursuivre</a>
                @endif
                    @if($promoteur->etape_suscription2 != 3)
                    {{-- <button type="submit" class="btn btn-success"> <span> <i class="hi hi-arrow-right"></i> </span> Poursuivre</button> --}}
                     <a href="#modal-complete-souscription" data-toggle="modal" class="btn btn-danger">Suspendre</a>
                @endif
                @if($promoteur->etape_suscription2 == 3)
                    <p>Le Recépissé est envoyé dans votre boite email.</p>
                    <a href="{{ route("generer.recepisse", $promoteur) }}" class="btn btn-success">Generer le recepissé</a>
                    <a href="{{ route("accueil") }}" class="btn btn-danger">Terminer</a>
                @endif

            @endif
        </form>

</div>
@endsection
