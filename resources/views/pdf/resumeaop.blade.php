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
                <td>{{ $promoteur->nom }}</td>
            </tr>
            <tr>
                <td>Prénom</td>
                <td>{{ $promoteur->prenom }}</td>
            </tr>
            <tr>
                <td>Fonction</td>
                <td>{{ $promoteur->fonction }}</td>
            </tr>
            <tr>
                <td>Date de naissance</td>
                <td>{{ $promoteur->datenais }}</td>
            </tr>
            <tr>
                <td>Genre</td>
                <td>@if($promoteur->genre==1)
                    Feminin
                    @else
                    masculin
                @endif</td>
            </tr>
            <tr>
                <td>Telephone</td>
                <td>{{ $promoteur->telephone_promoteur }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{ $promoteur->email_promoteur }}</td>
            </tr>  
            <tr>
                <td>Lieu de résidence</td>
                <td>{{ getlibelle($promoteur->region_residence)  }} {{ getlibelle($promoteur->province_residence)  }} {{ getlibelle($promoteur->commune_residence)  }} {{ getlibelle($promoteur->arrondissement_residence)  }}</td>
            </tr>
            <tr>
                <td>Situation de résidence</td>
                <td>{{ getlibelle($promoteur->region_residence)  }} {{ getlibelle($promoteur->province_residence)  }} {{ getlibelle($promoteur->commune_residence)  }} {{ getlibelle($promoteur->arrondissement_residence)  }}</td>
            </tr>
            <tr>
                <td>Niveau d’instruction</td>
                <td>{{ getlibelle($promoteur->niveau_instruction) }}</td>
            </tr>
            <tr>
                <td>Formation (s) en rapport avec le projet</td>
                <td>
                    @if($promoteur->formation_en_rapport_avec_activite==1)
                    Apprentissage sur le tas
                    @elseif($promoteur->formation_en_rapport_avec_activite==2)
                                Formation Formelle dans le domaine/thème : {{ $promoteur->domaine_formation }}
                    @else
                        Autre
                    @endif
        </td>
            </tr>
            <tr>
                <td>Nombre d’années d’expériences en tant que responsable : </td>
                <td>{{ $promoteur->nombre_annee_experience }}</td>
            </tr>
            <tr>
                <td>Membership</td>
                <td>{{ $promoteur->associations }}</td>
            </tr>
        </table>
        Proportion des depenses dans l'éducation
        <table>
            <tr>
                    @foreach($proportion_de_depense_education as $key => $proportion_de_depense_education)
                    <tr>
                        <td>
                            {{getlibelle($proportion_de_depense_education->annee_id)}}
                       </td>
                       <td>
                           {{$proportion_de_depense_education->pourcentage}}
                        </td>
                    </tr>
                        
                    @endforeach 
            </tr>
            
        </table>
        Proportion des dépenses dans la santé
        <table>
            <tr>
                    @foreach($proportion_de_depense_sante as $key => $proportion_de_depense_sante)
                    <tr>
                        <td>
                            {{getlibelle($proportion_de_depense_sante->annee_id)}}
                       </td>
                       <td>
                           {{$proportion_de_depense_sante->pourcentage}}
                        </td>
                    </tr>
                        
                    @endforeach 
            </tr>
            
        </table>
        Proportion des dépenses dans l'achat des biens et materiels
        <table>
            <tr>
                    @foreach($proportion_de_depense_bien_materiel as $key => $proportion_de_depense_bien_materiel)
                    <tr>
                        <td>
                            {{getlibelle($proportion_de_depense_bien_materiel->annee_id)}}
                       </td>
                       <td>
                           {{$proportion_de_depense_bien_materiel->pourcentage}}
                        </td>
                    </tr>
                        
                    @endforeach 
            </tr>
            
        </table>
       <h2>II.	Présentation de l’entreprise</h2> 
        <table>
            <tr>
                <td>Denomination</td>
                <td>{{ $entreprise->denomination }}</td>
            </tr>
            <tr>
                <td>Catégorie d'entreprise</td>
                <td>{{ $entreprise->aopOuleader }}</td>
            </tr>
            <tr>
                <td>Localisation de l'entreprise</td>
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
                     Oui le {{ $entreprise->date_de_formalisation }} avec un : {{ $entreprise->type_document_de_formalisation }} numéro: {{ $entreprise->num_rccm }}
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
                    {{ $entreprise->date_de_formalisation }}
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
                <td>Compte disponible dans une intitution financière?</td>
                <td>
                    @if($entreprise->compte_dispo==1)
                    Oui à la {{ $entreprise->banque_entreprise  }}
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
                <td>Produits/Services vendus</td>
                <td>
                    {{ $entreprise->produit_vendus }}
                </td>
            </tr> 
            <tr>
                <td>Technologie utilisée</td>
                <td>
                    {{ $entreprise->techno_utilise }}
                </td>
            </tr>
            <tr>
                <td>Produits/Services proposés</td>
                <td>
                    {{ $entreprise->produit_vendus  }}
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
                <td>Activités horizontales ménées </td>
                <td>
                    @foreach ( $entreprise->activites_horizontales_menees as $activites_horizontales_menee )
                        {{ getlibelle($activites_horizontales_menee->activite) }} 
                    @endforeach
                </td>
            </tr>
            <tr>
                <td>Activités horizontales à investir dans trois ans </td>
                <td>
                    @foreach ( $entreprise->activites_horizontales_invests as $activites_horizontales_invest )
                        {{ getlibelle($activites_horizontales_invest->activite) }} 
                    @endforeach
                </td>
            </tr>
            <tr>
                <td>Activités verticales ménées </td>
                <td>
                    @foreach ( $entreprise->activites_verticales_menees as $activites_verticale )
                        {{ getlibelle($activites_verticale->activite) }} 
                    @endforeach
                </td>
            </tr>
           
            <tr>
                <td>Activités verticales à investir dans trois ans </td>
                <td>
                    @foreach ( $entreprise->activites_verticales_invests as $activites_verticales_invest )
                        {{ getlibelle($activites_verticales_invest->activite) }} 
                    @endforeach
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
            <tr>
                <td>Idée de projet</td>
                <td>
                    {{ $entreprise->description_du_projet  }}
                </td>
            </tr>
            <tr>
                <td>Montant du projet</td>
                <td>
                    {{ $entreprise->cout_projet  }}
                </td>
            </tr>
            <tr>
                <td>Montant de la subvention</td>
                <td>
                    {{ $entreprise->montant_subvention }}
                </td>
            </tr>
        </table>
        Nombre de nouveaux clients
        <table>
            <tr>
                    @foreach($nombre_de_clients as $key => $nombre_de_client)
                    <tr>
                        <td>
                            {{getlibelle($nombre_de_client->annee)}}
                       </td>
                       <td>
                           {{$nombre_de_client->quantite}}
                        </td>
                    </tr>
                        
                    @endforeach 
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
        Salaire Moyen annuel
        <table>
            <tr>
                    @foreach($salaire_moyen_annuels as $key => $salaire_moyen_annuel)
                    <tr>
                        <td>
                            {{getlibelle($salaire_moyen_annuel->annee)}}
                       </td>
                       <td>
                           {{$salaire_moyen_annuel->quantite}}
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
        Nombre d'innovations introduites dans l'activité
        <table>
            <tr>
                    @foreach($nombre_dinnovations as $key => $nombre_dinnovation)
                    <tr>
                        <td>
                            {{getlibelle($nombre_dinnovation->annee)}}
                       </td>
                       <td>
                           {{$nombre_dinnovation->quantite}}
                        </td>
                    </tr>
                    @endforeach 
            </tr>
        </table>
        Nombre de nouveaux marchés 
        <table>
            <tr>
                    @foreach($nombre_nouveau_marches as $key => $nombre_nouveau_marche)
                    <tr>
                        <td>
                            {{getlibelle($nombre_nouveau_marche->annee)}}
                       </td>
                       <td>
                           {{$nombre_nouveau_marche->quantite}}
                        </td>
                    </tr>
                    @endforeach 
            </tr>
        </table>
        

</body>
</html>

