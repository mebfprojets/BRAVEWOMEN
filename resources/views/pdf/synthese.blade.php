<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Resume de la souscription</title>

    <style type="text/css">
    table, td, th {
  border: 1px solid;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
}

        .enteteGauche{
            float: left;
            width: 50%;
            text-align: center;
        }
        .entetedroite{
            float: left;
            width: 50%;
            text-align: center;
        }
        .entete{
            margin-top:90px;
            text-align: center;
            color:red;
            font-weight: blod;
            margin-bottom: 55px;
        }
        .titre{
            position:relative;
            margin-left:20px;
            width:50%;
            border:solid 2px black;
            padding-right:10px;
            text-align:center;

        }
        .contenu{
            position:relative;
            margin-right:20px;
            width:40%;
            text-align:center;
            padding-left:10px;
            display:inline-block;

        }
    </style>
</head>
<body>

        <div class="enteteGauche" >MEBF <br> ----------- <br> Projet BRAVE WOMEN BURIKNA </div>
        <div class="entetedroite">Burkina Faso <br> -----------  <br> Unité-Progres-Justice </div>
        <div class="entete"> Syntèse de informations saisies <hr> </div>
        <h2>I.	Présentation du promoteur</h2>
        <table id="">
            <tr>
                <td> Nom</td>
                <td>{{ $entreprise->promotrice->nom }}</td>
            </tr>
            <tr>
                <td>Prénom</td>
                <td>{{ $entreprise->promotrice->prenom }}</td>
            </tr>
            <tr>
                <td>Date de naissance</td>
                <td>{{ $entreprise->promotrice->datenais }}</td>
            </tr>
            <tr>
                <td>Genre</td>
                <td>@if($entreprise->promotrice->genre==1)
                    Feminin
                    @else
                    masculin
                @endif</td>
            </tr>
            <tr>
                <td>Telephone</td>
                <td>{{ $entreprise->promotrice->telephone_promoteur }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{ $entreprise->promotrice->email_promoteur }}</td>
            </tr>  
            <tr>
                <td>Lieu de résidence</td>
                <td>{{ getlibelle($entreprise->promotrice->region_residence)  }} {{ getlibelle($entreprise->promotrice->province_residence)  }} {{ getlibelle($entreprise->promotrice->commune_residence)  }} {{ getlibelle($entreprise->promotrice->arrondissement_residence)  }}</td>
            </tr>
            <tr>
                <td>Niveau d’instruction</td>
                <td>{{ getlibelle($entreprise->promotrice->niveau_instruction) }}</td>
            </tr>
            <tr>
                <td>Formation (s) en rapport avec le projet</td>
                <td>
                    @if($entreprise->promotrice->formation_en_rapport_avec_activite==1)
                    Apprentissage sur le tas
                    @elseif($entreprise->promotrice->formation_en_rapport_avec_activite==2)
                                Formation Formelle dans le domaine/thème : {{ $entreprise->promotrice->domaine_formation }}
                    @else
                        Autre
                    @endif
        </td>
            </tr>
            <tr>
                <td>Nombre d’années d’expérience dans le domaine d’activités</td>
                <td>{{ $entreprise->promotrice->nombre_annee_experience }}</td>
            </tr>
            <tr>
                <td>Membership</td>
                <td>{{ $entreprise->promotrice->associations }}</td>
            </tr>
        </table>
       <h2>II.	Présentation de l’entreprise</h2> 
        <table>
            <tr>
                <td>Denomination</td>
                <td>{{ $entreprise->denomination }}</td>
            </tr>
            <tr>
                <td>Location de l'entreprise</td>
                <td>{{ getlibelle($entreprise->region)  }} {{ getlibelle($entreprise->province)  }} {{ getlibelle($entreprise->commune)  }} {{ getlibelle($entreprise->arrondissement)  }}</td>
            </tr>
            <tr>
                <td>Téléphone</td>
                <td>{{ $entreprise->telephone_entreprise }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{ $entreprise->email_entreprise }}</td>
            </tr>
            <tr>
                <td>Secteur d’activité</td>
                <td>{{getlibelle($entreprise->secteur_activite) }}</td>
            </tr>
            <tr>
                <td>Nombre d’années d’existence de l’entreprise </td>
                <td>{{ $entreprise->email_entreprise }}</td>
            </tr>
            <tr>
                <td>Maillon </td>
                <td>{{ $entreprise->maillon_activite }}</td>
            </tr>
            <tr>
                <td>Formalisation de l’entreprise</td>
                <td>
                    @if($entreprise->formalise==1)
                     Oui le {{ $entreprise->date_de_formalisation }} sous le numéro RCCM : {{ $entreprise->num_rccm }}
                     @else
                      Non
                     @endif
                </td>
            </tr>
            @if($entreprise->formalise==1)
            <tr>
                <td>Forme juridique</td>
                <td>
                    {{ getlibelle($entreprise->forme_juridique) }}
                </td>
            </tr>
            <tr>
                <td>Date de formalisation</td>
                <td>
                    {{ getlibelle($entreprise->date_de_formalisation) }}
                </td>
            </tr>
            @endif
            <tr>
                <td>Agrément ou autorisation exigé</td>
                <td>
                    @if($entreprise->agrement_exige==1)
                     Oui
                     @else
                      Non
                     @endif
                </td>
            </tr>
            <tr>
                <td>Brève description de l’activité</td>
                <td>
                    {{ $entreprise->description_activite }}
                </td>
            </tr> 
            <tr>
                <td>Source d’approvisionnement actuelle</td>
                <td>
                    {{ getlibelle($entreprise->source_appro) }}
                </td>
            </tr> 
            <tr>
                <td>Provenance de la clientèle actuelle</td>
                <td>
                    {{ getlibelle($entreprise->provenance_clientele)}}
                </td>
            </tr>
            <tr>
                <td>Outils de suivi de l’activité </td>
                <td>
                    {{ getlibelle($entreprise->type_sys_suivi) }}
                </td>
            </tr>
            <tr>
                <td>Impact de la pandémie de COVID-19 sur l’entreprise</td>
                <td>
                    {{ $entreprise->description_effect_covid }}
                </td>
            </tr>
            <tr>
                <td>Impact de la crise sécuritaire sur l’entreprise</td>
                <td>
                    {{ $entreprise->description_effet_securite }}
                </td>
            </tr>
            <tr>
                <td>Capacité à mobiliser la contrepartie pour le financement de l’entreprise</td>
                <td>
                    {{ $entreprise->mobililise_contrepartie }}
                </td>
            </tr>
        </table>
       Chiffre d'affaire
        <table>
            <tr>
                    @foreach($chiffre_daffaire as $key => $chiffre_daffaire)
                    <tr>
                        <td>
                            {{getlibelle($chiffre_daffaire->annee)}}
                       </td>
                       <td>
                           {{$chiffre_daffaire->quantite}}
                        </td>
                    </tr>
                        
                    @endforeach 
            </tr>
            
        </table>
        Bénéfice net réalisé
        <table>
            <tr>
                    @foreach($benefice_nets as $key => $benefice_nets)
                    <tr>
                        <td>
                            {{getlibelle($benefice_nets->annee)}}
                       </td>
                       <td>
                           {{$benefice_nets->quantite}}
                        </td>
                    </tr>
                        
                    @endforeach 
            </tr>
            
        </table>
        Effectif permanent
        <table>
            <tr>
               
                    @foreach($effectif_permanent_entreprises as $key => $effectif_permanent_entreprise)
                    <tr>
                        <td>
                            {{getlibelle($effectif_permanent_entreprise->annee)}}
                       </td>
                       <td>
                        {{$effectif_permanent_entreprise->femme + $effectif_permanent_entreprise->homme }}
                        </td>
                    </tr>
                        
                    @endforeach 
            </tr>
            
        </table>
        Effectif temporaire
        <table>
            <tr>
               
                    @foreach($effectif_temporaire_entreprises as $key => $effectif_temporaire_entreprise)
                    <tr>
                        <td>
                            {{getlibelle($effectif_temporaire_entreprise->annee)}}
                       </td>
                       <td>
                           {{$effectif_temporaire_entreprise->femme + $effectif_temporaire_entreprise->homme}}
                        </td>
                    </tr>
                        
                    @endforeach 
            </tr>
            
        </table>
        <h2>IIII. Evaluation</h2>
        <table>
            <tr>
                <td style="width: 100%" >Résultat du comité d’analyse</td>
            </tr>
            <tr>
                <td style="width: 5%">N°</td>
                <td style="width: 85%">Critères de sélection</td>
                <td style="width: 10%">Note</td>
            </tr>
            @php
            $i=0;
            $total=0
        @endphp
            @foreach ($evaluations as $evaluation )
            @php
            $i++;
            $total=$total + $evaluation->note
            @endphp
            <tr>
                    <td style="width: 5%">{{ $i }}</td>
                    <td style="width: 85%">{{ $evaluation->indicateur }}</td>
                    <td style="width: 10%">{{ $evaluation->note }}</td>
            </tr>
            @endforeach
            <tr>
                <td>Total</td>
                <td>{{ $total }}</td>
                <td></td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="width: 15%">Avis de l'équipe technique</td>
                <td>
                    @if($total>50)
                        Favorable
                    @else
                        Défavorable
                    @endif
                </td>
            </tr>
        <tr>
            <td>Observations</td>
            <td></td>
        </tr>
        </table>
        <table>
            <tr>
                <td style="width: 100%">Décision du Comité technique </td>
                <td style="width: 0%"></td>
                <td style="width: 0%"></td>
                <td style="width: 0%"></td>
                <td style="width: 0%"></td>
            
            </tr>
            <tr>
                <td style="width: 10%">Date de la décision</td>
                <td style="width: 90%"> </td>
                <td style="width: 0%"></td>
                <td style="width: 0%"></td>
                <td style="width: 0%"></td>
            </tr>
            <tr style="width: 100%">
                <td style="width: 10%">Date de la décision</td>
                <td style="width: 35%">Selectionné</td>
                <td style="width: 10%"> </td>
                <td style="width: 35%">Ajourné</td>
                <td style="width: 10%"> </td>
            </tr>
            <tr style="width: 100%">
                <td style="width: 10%">Commentaire</td>
                <td style="width: 90%"></td>
                <td style="width: 0%"></td>
                <td style="width: 0%"></td>
                <td style="width: 0%"></td>
            </tr>

        </table>

</body>
</html>

