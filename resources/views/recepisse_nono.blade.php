<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Document</title>

    <style type="text/css">
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
        <div class="entete"> Code promoteur {{ $promoteur->code_promoteur }} <hr> </div>
        <p class="contenu"><strong> Destinataire : </strong></p> <p class="contenu"> {{ $promoteur->nom }} {{ $promoteur->prenom }} </p> <br>
        <p class="contenu"> <strong>Numero d'identité : </strong></p> <p class="contenu"> {{ $promoteur->numero_identite }} du {{ $promoteur->date_etabli_identite }}</p> <br>
        <p class="contenu"><strong> Télephone du promoteur : </strong></p> <p class="contenu"> {{ $promoteur->telephone_promoteur }} / {{ $promoteur->mobile_promoteur }}</p> <br>
        <p class="contenu"> <strong>Email: </strong></p> <p class="contenu">{{ $promoteur->email_promoteur  }} </p> <br>
        <br>
        <p>Promoteur de l'entreprise <span style="font-weight: bold;">{{ $entreprise->denomination }}</span> exerçant dans le domaine de <span style="font-weight: bold;">  {{ getlibelle($entreprise->secteur_activite) }}</span> a souscrit sur la plateforme de BRAVE WOMEN Burkina Faso avec le projet suivant :  <span style="font-weight: bold;"> {{ $entreprise->description_du_projet}} .</span> </p> <br>
        <span style="width: 40%; float: right;">Fait le : <span style="font-weight: bold;">{{ date("d-m-Y") }}</span> </span> <br>
        <p style="font-size: x-small;  text-align: justify;">Ce récépissé constitue la preuve que le promoteur a pris connaissance des conditions d'interventions du projet BRAVE WOMEN auxquelles il souscrit entièrement notamment le processus de selection des bénéficiaires.Le promoteur certifie voir pris acte et s'engage à se conformer au processus de selection des bénéficiaires et aux délibérations du jury.</p>
        <p style="font-size: x-small;"> Pour toute information contactez nous aux : {{ $contact_chef_de_zone }} <br> NB: Ce récépissé constitue le depôt de cadidature aux activités du projet BRAVE WOMEN.</p>
</body>
</html>

