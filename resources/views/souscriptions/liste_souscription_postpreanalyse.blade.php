@extends('layouts.admin')
@section('souscription', 'active')
@section($active_principal, 'active')
@section($active, 'active')
@section('content')
<div class="block full">
    <div class="block-title">
        <h2><strong>Liste</strong> des souscriptions {{ $titre }}</h2>
        @can('user.create', Auth::user())
                            <a href="{{ route('generer.excel') }}" class="btn btn-success pull-right"><span><i class="fa fa-plus"></i></span> Générer en excel</a>
        @endcan
    </div>
    <div class="table-responsive">
        <table id="" class="table table-vcenter table-condensed table-bordered listepdf">
            <thead>
                <tr>
                    <th class="text-center">N°</th>
                    <th class="text-center" style="width:10px;" >Code promoteur</th>
                    <th class="text-center" style="width:10px;" >CNIB</th>
                    <th class="text-center">Région</th>
                    <th class="text-center">Province</th>
                    <th class="text-center">Commune</th>
                    <th class="text-center">Village</th>
                    <th class="text-center">Nom & Prénom</th>
                     <th class="text-center">Situation résident</th> 
                    <th class="text-center">Contacts</th>
                    <th class="text-center">Nom de l'entreprise</th>
                    <th class="text-center">Secteur d'activité</th>
		            <th class="text-center">nbre de membre en 2019</th>
		            <th class="text-center">nbre de membre en 2020</th>
		            <th class="text-center">nbre de membre en 2021</th>
                    <th class="text-center">nbre entreprise partenaire en 2019</th>
		            <th class="text-center">nbre entreprise partenaire en 2020</th>
		            <th class="text-center">nbre entreprise partenaire en 2021</th>
                    <th class="text-center">pourcentage de femme membre en 2019</th>
		            <th class="text-center">pourcentage de femme membre en 2020</th>
		            <th class="text-center">pourcentage de femme membre en 2021</th>
		            <th class="text-center">nbre de produits/services vendus.2019</th>
                    <th class="text-center">nbre de produits/services vendus.2020</th>
                    <th class="text-center">nbre de produits/services vendus.2021</th>
		            <th class="text-center">nbre Nouveaux produits/services lancés.2019</th>
                    <th class="text-center">nbre Nouveaux produits/services lancés.2020</th>
                    <th class="text-center">nbre Nouveaux produits/services lancés.2021</th>
                    <th class="text-center">Cf.aff.2019</th>
                    <th class="text-center">Cf.aff.2020</th>
                    <th class="text-center">Cf.aff.2021</th>
                    <th class="text-center">Bénéfice.2019</th>
                    <th class="text-center">Bénéfice.2020</th>
                    <th class="text-center">Bénéfice.2021</th>
                    <th class="text-center">nbre client.2019</th>
                    <th class="text-center">nbre client.2020</th>
                    <th class="text-center">nbre client.2021</th>
                    <th class="text-center">nbre Nouveaux marchés.2019</th>
                    <th class="text-center">nbre Nouveaux marchés.2020</th>
                    <th class="text-center">nbre Nouveaux marchés.2021</th>

                    <th class="text-center">nbre innovation.2019</th>
                    <th class="text-center">nbre innovation.2020</th>
                    <th class="text-center">nbre innovation.2021</th>
                    <th class="text-center">Salaire annuel.2019</th>
                    <th class="text-center">Salaire annuel.2020</th>
                    <th class="text-center">Salaire annuel.2021</th>
                    <th class="text-center">Membre d'une association</th>
                    <th class="text-center">Proportion des depenses en education en 2019</th>
                    <th class="text-center">Proportion des depenses en education en 2020</th>
                    <th class="text-center">Proportion des depenses en education en 2021</th>
                    <th class="text-center">Proportion des depenses en santé en 2019</th>
                    <th class="text-center">Proportion des depenses en santé en 2020</th>
                    <th class="text-center">Proportion des depenses en santé en 2021</th>
                    <th class="text-center">Proportion des depenses en bien 2019</th>
                    <th class="text-center">Proportion des depenses en bien 2020</th>
                    <th class="text-center">Proportion des depenses en bien 2021</th>
                    <th class="text-center">Effectif permanent Homme en 2019</th>
                    <th class="text-center">Effectif permanent Homme en 2020</th>
                    <th class="text-center">Effectif permanent Homme en 2021</th>
                    <th class="text-center">Effectif permanent femme en 2019</th>
                    <th class="text-center">Effectif permanent femme en 2020</th>
                    <th class="text-center">Effectif permanent femme en 2021</th>
                    <th class="text-center">Effectif temporaire Homme en 2019</th>
                    <th class="text-center">Effectif temporaire Homme en 2020</th>
                    <th class="text-center">Effectif temporaire Homme en 2021</th>
                    <th class="text-center">Effectif temporaire femme en 2019</th>
                    <th class="text-center">Effectif temporaire femme en 2020</th>
                    <th class="text-center">Effectif temporaire femme en 2021</th>

                    {{-- <th class="text-center">Score qualitatif</th>--}}
                    <th class="text-center">Niveau de resilience</th> 
                    <th class="text-center">Score</th>
                    <th class="text-center">Affecté par Covid</th>
                    <th class="text-center">Description de l'éffet Covid</th>
                    <th class="text-center">Affecté par la securité</th>
                    <th class="text-center">Description de l'éffet sécurité</th>
                    
                </tr>
            </thead>
            <tbody>
                @php
                  $i=0;
                @endphp
                @foreach ($entreprises as $entreprise)
                        @php
                           $i++;
                        @endphp
                    <tr 
                    @if($entreprise->conforme != null && $entreprise->decision_ugp   == null )
                            style="color:orange;"
                    @elseif($entreprise->conforme != null && $entreprise->decision_ugp   != null)
                        style="color:green;"
                        @endif>
                                         <td class="text-center" style="width: 2%">{{ $i }}</td>
                                         <td class="text-center" style="width: 5%;" >
                                            {{ $entreprise->promotrice->code_promoteur }}
                                        </td>
                                        <td class="text-center" style="width: 5%;" >
                                            {{ $entreprise->promotrice->numero_identite }}
                                        </td>
                                         <td class="text-center" style="width: 5%;" >
                                            {{ getlibelle($entreprise->region) }}
                                        </td>
                                        <td class="text-center" style="width: 5%;" >
                                            {{ getlibelle($entreprise->province) }}
                                        </td>
                                        <td class="text-center" style="width: 5%;" >
                                            {{ getlibelle($entreprise->commune) }}
                                        </td>
                                        <td class="text-center" style="width: 5%;" >
                                            {{ getlibelle($entreprise->arrondissement) }}
                                        </td>
                                        <td class="text-center" style="width: 5%;" >
                                            @if($entreprise->promotrice->situation_residence=1)
                                            Resident
                                            @else
                                                Déplacé
                                            @endif
                                        </td>
                                        
                                        <td class="text-center" style="width: 5%;">{{ $entreprise->promotrice->nom }} {{ $entreprise->promotrice->prenom }}</td>
                                        {{-- <td class="text-center" style="width: 5%;">
                                           @if($entreprise->promotrice->genre==1)
                                                Féminin
                                            @else
                                            Masculin
                                        @endif
                                        </td> --}}
                                        <td class="text-center" style="width: 5%;">{{ $entreprise->promotrice->telephone_promoteur }} / {{ $entreprise->telephone_entreprise }}/ {{ $entreprise->email_entreprise }}</td>
                                        <td class="text-center" style="width: 5%;">
                                            {{-- <a href="{{ route("entreprise.edit", $entreprise) }}"> {{ $entreprise->denomination }} </a> --}}
                                           {{ $entreprise->denomination }}
                                        </td>
                                       
                                        <td class="text-center" style="width: 5%;">
                                            {{ getlibelle($entreprise->secteur_activite) }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">
                                            {{ return_quantite_indicateur($entreprise->id,7098,46) }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">
                                            {{ return_quantite_indicateur($entreprise->id,7098,47) }}
                                        </td> <td class="text-center" style="width: 5%;">
                                            {{ return_quantite_indicateur($entreprise->id,7098,48) }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">
                                            {{ return_quantite_indicateur($entreprise->id,7100,46) }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">
                                            {{ return_quantite_indicateur($entreprise->id,7100,47) }}
                                        </td> <td class="text-center" style="width: 5%;">
                                            {{ return_quantite_indicateur($entreprise->id,7100,48) }}
                                        </td>
                                        
                                        
					                    <td class="text-center" style="width: 5%;">
                                            {{ return_quantite_indicateur($entreprise->id,41,46) }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">
                                            {{ return_quantite_indicateur($entreprise->id,41,47) }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">
                                            {{ return_quantite_indicateur($entreprise->id,41,48) }}
                                        </td>
					<td class="text-center" style="width: 5%;">
                                            {{ return_quantite_indicateur($entreprise->id,6715,46) }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">
                                            {{ return_quantite_indicateur($entreprise->id,6715,47) }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">
                                            {{ return_quantite_indicateur($entreprise->id,6715,48) }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">
                                            {{ return_quantite_indicateur($entreprise->id,42,46) }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">
                                            {{ return_quantite_indicateur($entreprise->id,42,47) }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">
                                            {{ return_quantite_indicateur($entreprise->id,42,48) }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">
                                            {{ return_quantite_indicateur($entreprise->id,43,46) }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">
                                            {{ return_quantite_indicateur($entreprise->id,43,47) }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">
                                            {{ return_quantite_indicateur($entreprise->id,43,48) }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">
                                            {{ return_quantite_indicateur($entreprise->id,7078,46) }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">
                                            {{ return_quantite_indicateur($entreprise->id,7078,47) }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">
                                            {{ return_quantite_indicateur($entreprise->id,7078,48) }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">
                                            {{ return_quantite_indicateur($entreprise->id,env('VALEUR_NOMBRE_NOUVEAU_MARCHE'),46) }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">
                                            {{ return_quantite_indicateur($entreprise->id,env('VALEUR_NOMBRE_NOUVEAU_MARCHE'),47) }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">
                                            {{ return_quantite_indicateur($entreprise->id,env('VALEUR_NOMBRE_NOUVEAU_MARCHE'),48) }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">
                                            {{ return_quantite_indicateur($entreprise->id,6713,46) }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">
                                            {{ return_quantite_indicateur($entreprise->id,6713,47) }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">
                                            {{ return_quantite_indicateur($entreprise->id,6713,48) }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">
                                            {{ return_quantite_indicateur($entreprise->id,env("VALEUR_SALAIRE_MOYEN_ANNUEL"),46) }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">
                                            {{ return_quantite_indicateur($entreprise->id,env("VALEUR_SALAIRE_MOYEN_ANNUEL"),47) }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">
                                            {{ return_quantite_indicateur($entreprise->id,env("VALEUR_SALAIRE_MOYEN_ANNUEL"),48) }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">
                                            @if($entreprise->promotrice->membre_ass==1)
                                                Oui
                                            @else
                                                Non
                                            @endif
                                        </td>
					 <td class="text-center" style="width: 5%;">
                                            {{ return_proportion_depense($entreprise->promotrice->id,env("VALEUR_PROPORTION_EDUCATION"),46) }}
                                        </td>
					 <td class="text-center" style="width: 5%;">
                                            {{ return_proportion_depense($entreprise->promotrice->id,env("VALEUR_PROPORTION_EDUCATION"),47) }}
                                        </td>

                                        <td class="text-center" style="width: 5%;">
                                            {{ return_proportion_depense($entreprise->promotrice->id,env("VALEUR_PROPORTION_EDUCATION"),48) }}
                                        </td>

                                        <td class="text-center" style="width: 5%;">
                                            {{ return_proportion_depense($entreprise->promotrice->id,env("VALEUR_PROPORTION_SANTE"),46)}}
                                        </td>
					 <td class="text-center" style="width: 5%;">
                                            {{ return_proportion_depense($entreprise->promotrice->id,env("VALEUR_PROPORTION_SANTE"),47) }}
                                        </td>

					 <td class="text-center" style="width: 5%;">
                                            {{ return_proportion_depense($entreprise->promotrice->id,env("VALEUR_PROPORTION_SANTE"),48) }}
                                        </td>

                                        <td class="text-center" style="width: 5%;">
                                            {{ return_proportion_depense($entreprise->promotrice->id,env("VALEUR_PROPORTION_BIEN"),46) }}
                                        </td>
					<td class="text-center" style="width: 5%;">
                                            {{ return_proportion_depense($entreprise->promotrice->id,env("VALEUR_PROPORTION_BIEN"),47) }}
                                        </td>
					<td class="text-center" style="width: 5%;">
                                            {{ return_proportion_depense($entreprise->promotrice->id,env("VALEUR_PROPORTION_BIEN"),48) }}
                                        </td>


                                        <td class="text-center" style="width: 5%;">
                                            {{ return_effectif_homme($entreprise->id,env("VALEUR_EFFECTIF_PERMANENENT"),46) }}
                                        </td>
					 <td class="text-center" style="width: 5%;">
                                            {{ return_effectif_homme($entreprise->id,env("VALEUR_EFFECTIF_PERMANENENT"),47) }}
                                        </td>
  					<td class="text-center" style="width: 5%;">
                                            {{ return_effectif_homme($entreprise->id,env("VALEUR_EFFECTIF_PERMANENENT"),48) }}
                                        </td>
  					<td class="text-center" style="width: 5%;">
                                            {{ return_effectif_femme($entreprise->id,env("VALEUR_EFFECTIF_PERMANENENT"),46) }}
                                        </td>
					 <td class="text-center" style="width: 5%;">
                                            {{ return_effectif_femme($entreprise->id,env("VALEUR_EFFECTIF_PERMANENENT"),47) }}
                                        </td>

					<td class="text-center" style="width: 5%;">
                                            {{ return_effectif_femme($entreprise->id,env("VALEUR_EFFECTIF_PERMANENENT"),48) }}
                                        </td>
					<td class="text-center" style="width: 5%;">

                                            {{ return_effectif_homme($entreprise->id,env("VALEUR_EFFECTIF_TEMPORAIRE"),46) }}
                                        </td>
 					
					<td class="text-center" style="width: 5%;">

                                            {{ return_effectif_homme($entreprise->id,env("VALEUR_EFFECTIF_TEMPORAIRE"),47) }}
                                        </td>
                                       <td class="text-center" style="width: 5%;">

                                            {{ return_effectif_homme($entreprise->id,env("VALEUR_EFFECTIF_TEMPORAIRE"),48) }}
                                        </td>
 
					<td class="text-center" style="width: 5%;">

                                            {{ return_effectif_femme($entreprise->id,env("VALEUR_EFFECTIF_TEMPORAIRE"),46) }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">
                                            {{ return_effectif_femme($entreprise->id,env("VALEUR_EFFECTIF_TEMPORAIRE"),47) }}
                                 	</td>
                                       <td class="text-center" style="width: 5%;">

                                            {{ return_effectif_femme($entreprise->id,env("VALEUR_EFFECTIF_TEMPORAIRE"),48) }}
                                        </td>

                                        <td class="text-center" style="width: 5%;">
                                            {{ getlibelle($entreprise->niveau_resilience)}}
                                       </td>
                                        <td class="text-center" style="width: 5%;">
                                             {{ $entreprise->note_critere_qualitatif +  $entreprise->noteTotale }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">
                                            {{ getlibelle($entreprise->affecte_par_covid) }}
                                       </td>
                                       <td class="text-center" style="width: 5%;">
                                         {{ $entreprise->description_effect_covid }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">
                                            {{ getlibelle($entreprise->affecte_par_securite) }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">
                                            {{ $entreprise->description_effet_securite }}
                                        </td>
                                       
                                        
                                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

<script>
  // ('.avis_ugp').hide();

    function recupererentreprise_id(id_entreprise,conforme){
        
            document.getElementById("id_entreprise").setAttribute("value", id_entreprise);
            document.getElementById("conformite").setAttribute("value", conforme);
    }
    function saveconformite_souscription(){
        $(function(){
            var id_entreprise= $("#id_entreprise").val();
            var conforme= $("#conformite").val();
            var url = "{{ route('souscription.saveconformite') }}";
            $.ajax({
                url: url,
                type:'GET',
                data: {id_entreprise: id_entreprise, conforme : conforme} ,
                error:function(){alert('error');},
                success:function(){
                    $('#modal-confirm-ugp').hide();
                    location.reload();
                    
                }
            });
            });
    }
    function save_avis_ugp(avis){
        var id_entreprise= $("#id_entreprise").val();
        var observation= $("#observation").val();
        var url = "{{ route('souscription.savedecisionugp') }}";
        $.ajax({
                url: url,
                type:'GET',
                data: {id_entreprise: id_entreprise, observation:observation, avis:avis} ,
                error:function(){alert('error');},
                success:function(){
                    $('#modal-decision-de-ugp').hide();
                    location.reload();
                }
            });

    }
    function rejeterdossier(){
        $(function(){
            var id_entreprise= $("#id_entreprise").val();
            var id_user= $("#id_user").val();
            var raison= $("#raison_du_rejet").val();
            var url = "{{ route('entreprise.statuermembrecomite') }}";
            $.ajax({
                url: url,
                type:'GET',
                data: {id_entreprise: id_entreprise, id_user : id_user, raison:raison} ,
                error:function(){alert('error');},
                success:function(){
                    $('#modal-confirm-rejet').hide();
                    location.reload();
                }
            });
            });
    }

    </script>

