<table id="" class="table">
    <thead>
        <tr>
            <th class="text-center">N°</th>
            <th class="text-center" style="width:10px;" >Code promoteur</th>
            <th class="text-center" style="width:10px;" >CNIB</th>
            <th class="text-center">Région</th>
            <th class="text-center">Province</th>
            <th class="text-center">Commune</th> 
            <th class="text-center">Nom & Prénom</th>
            <th class="text-center">Genre</th>
            <th class="text-center">Téléphone</th>
            <th class="text-center">Nom de l'entreprise</th>
            <th class="text-center">Forme juridique</th>
            <th class="text-center">Secteur d'activité</th>
            <th class="text-center">Cf.aff.2019</th>
            <th class="text-center">Cf.aff.2020</th>
            <th class="text-center">Cf.aff.2021</th>
            <th class="text-center">Score qualitatif</th>
            <th class="text-center">Score quantitatif</th>
            <th class="text-center">Score</th>
            <th class="text-center">Conformité</th>
            <th class="text-center">Décision UGP</th>
           <th class="text-center">Observation UGP</th>
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
                                {{-- <td class="text-center" style="width: 5%;" >
                                    {{ getlibelle($entreprise->province) }}
                                </td>
                                <td class="text-center" style="width: 5%;" >
                                    {{ getlibelle($entreprise->commune) }}
                                </td> --}}
                                <td class="text-center" style="width: 5%;">{{ $entreprise->promotrice->nom }} {{ $entreprise->promotrice->prenom }}</td>
                                <td class="text-center" style="width: 5%;">
                                   @if($entreprise->promotrice->genre==1)
                                        Féminin
                                    @else
                                    Masculin
                                @endif
                                </td>
                                <td class="text-center" style="width: 5%;">{{ $entreprise->promotrice->telephone_promoteur }}</td>
                                <td class="text-center" style="width: 5%;">
                                    {{-- <a href="{{ route("entreprise.edit", $entreprise) }}"> {{ $entreprise->denomination }} </a> --}}
                                   {{ $entreprise->denomination }}
                                </td>
                                <td class="text-center" style="width: 5%;">
                                   {{ getlibelle($entreprise->forme_juridique) }}
                                </td>
                                <td class="text-center" style="width: 5%;">
                                    {{ getlibelle($entreprise->secteur_activite) }}
                                </td>
                                @foreach ( $entreprise->chiffredaffaires as $chiffredaffaire )
                                <td class="text-center" style="width: 5%;">
                                    {{format_prix($chiffredaffaire->quantite) }}
                                 </td>
                                @endforeach
                                {{-- <td class="text-center" style="width: 5%;">
                                    {{ $entreprise->noteTotale }}
                                </td>
                                <td class="text-center" style="width: 5%;">
                                    {{ $entreprise->note_critere_qualitatif }}
                                </td> --}}
                                <td class="text-center" style="width: 5%;">
                                     {{ $entreprise->note_critere_qualitatif +  $entreprise->noteTotale }}
                                </td>
                                <td class="text-center" style="width: 5%;">
                                     @if($entreprise->conforme==1)
                                        Conforme
                                    @elseif ($entreprise->conforme==2)
                                    Non conforme 
                                    @else
                                    Non renseigné
                                    @endif
                                </td>
                                <td class="text-center" style="width: 5%;">
                                    {{ $entreprise->decision_ugp }}
                                </td>
                                <td class="text-center" style="width: 5%;">
                                    {{ $entreprise->observation_ugp }}
                                </td>
                            </tr>
        @endforeach
    </tbody>
</table>