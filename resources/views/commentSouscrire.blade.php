@extends("layouts.public")
@section("main-content")
@section("class", "content")
<div class="block">
    @if(Session::has('success'))

    <div class="alert alert-success">

        {{Session::get('success')}}

    </div>

@endif

    <!-- Wizard with Validation Title -->
    <div class="block-title">
        <h2><strong>Procedure de souscription </h2>
    </div>
    <div class="block-content" style="font-family: cursive; font-size:18px;">
        <p>La souscriptio se fait en trois étapes à savoir :
            <ol>
                <li style="color: red">Enregistrement des informations sur le promoteur</li>
                <p> A cette étape Le promoteur est invité remplir le formulaire, a prendre connaissance des conditions et obligation et à les accepter pour pouvoir enregistrer les données.
                    A la fin de la première un code promoteur est généré et envoyé dans à l'adresse email renseigné par le promoteur qui sera utilisé pour poursuivre la souscription.</p>
                <li style="color: red">Enrgistrement des information sur l'entreprise</li>
                <li style="color: red">Enregistrement des données sur l'idée de projet du promoteur</li>
            </ol>
       </p>
       <p>
            A la fin de chaque étape vous pouvez continuer en cliquant sur le bouton <span>Poursuivre</span> ou suspendre la souscription et revenir plus tard pour continuer en cliquant sur le bouton <span>Suspendre</span>.
       </p>
       <p>
            Pour continuer la souscription cliquer sur le lien <a href="http://">poursuivre</a> la plateforme vous demandera de renseigner votre code promoteur à travers un formulaire reseigner le et valider.
       </p>
       <p>
           A la fin de la dernière étape la plateforme vous permet de générer le récépissé de souscription en cliquant sur le bouton générer le recepissé.
           Une fois que vous cliquez sur générer le recépissé le récépissé est généré et envoyé par email.
       </p>
    </div>

</div>
@endsection
