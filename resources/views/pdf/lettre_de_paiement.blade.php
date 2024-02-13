<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Demande de paiement</title>

    <style type="text/css">
        .enteteGauche{
            float: left;
            width: 50%;
            text-align: center;
        }
        .entetedroite{
            float: right;
            width: 50%;
            text-align: left;
            display: inline;
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
        .contenu_principal{
          padding-top: 150px;
            text-align:justify;
            padding-left:150px;
        }
    </style>
</head>
<body>

        {{-- <div class="enteteGauche" >MEBF <br> ----------- <br> Projet BRAVE WOMEN BURIKNA </div>
        <div class="entetedroite">Burkina Faso <br> -----------  <br> Unité-Progres-Justice </div> --}}
    <div class="contenu_principal">
        <div class="entetedroite"> Ouagadougou, le </div><br>
        <p class="entetegauche"><strong>Le Directeur Général </strong></p> 
        <div  style="padding-left:60%;">
            <p> A <br>
                Monsieur le Directeur Général {{ $facture->entreprise->banque->nom }} <br> 
                -Ouagadougou- </p>
        </div>
        <p>
        <span><p class="contenu"> <strong> N/Réf:  </strong></p></span><span> <p class="contenu">  /MEBF/DG/SG/DDP/soh</p> </span>
        <p class="contenu"><strong> Objet : </strong></p> <p class="contenu"> Paiement {{ $facture->montant/$devi->montant_devis*100 }} %  au profit de {{ $devi->prestataire->denomination_entreprise }}</p> <br> 
      </p>
      <br>
        <p> <span style="font-weight: bold;">Monsieur le Directeur Général, </span> <br>
        <span>L’entreprise</span><span style="font-weight: bold;">  {{ $facture->devi->entreprise->denomination }}</span> de madame  {{ $entreprise->promotrice->nom  }} {{ $entreprise->promotrice->prenom  }} pour . <span style="font-weight: bold;"> {{ $devi->designation}} .</span> <br> 
        Selon les directives de paiement du projet BRAVE Women, elle peut bénéficier {{ $facture->montant/$devi->montant_devis*100  }} % pour l’aménagement de l’unité et du paiement de pour l’acquisition des équipements après livraison de ceux-ci.</p>
       <p> <span>Par la présente, je vous prie de bien vouloir procéder au virement de {{ int2str($facture->montant) }} ({{ $facture->montant }}) Francs CFA, montant de la facture au profit de son prestataire {{ $devi->prestataire->denomination_entreprise }} </span></p>
      
       <p> <span>Je vous prie d’agréer, Monsieur le Directeur Général, l'expression de ma considération distinguée. </span></p> <br>
       <div class="entetedroite">Karim OUATTARA </div>
    </div> 
</body>
</html>

