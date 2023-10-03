<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    
    <style type="text/css">
    body{
        font-family: "Times New Roman", Times, serif;
    }
        .enteteGauche{
            float: left;
            width: 40%;
            text-align: center;
        }
        table {
            border-collapse: collapse;
            margin-top:10px;
        }

        table, th, td {
            border: 1px solid black;
            padding: 0 4px;
        }
        p{
            padding-bottom: 10px;
        }
        td{
            height: 50px;
            
        }
        .entetedroite{
            float: left;
            width: 60%;
            text-align: center;
        }
        .entete{

        }
        .titre{
            margin-top: 10%;
            text-align: center;  
        }
        .code{
            height: 10%;
        }
    </style>
</head>
<body>

        <div class="enteteGauche" >Cours de cassation <br> ----------- <br> Greffe Central </div>
        <div class="entetedroite">Burkina Faso <br> -----------  <br> Unité-Progres-Justice </div>
        <p class="titre">RECU DE CONSIGNATION N°:   </p>
        @if (getMatiereRequete($data->idrequete) == 25)
            <p>
                - Art. 605 du code de procedure criminelle <br>
                - Art. 33 du règlement intérieur de la cour de cassation <br>
                - Arrété 2003-001 du 06 janvier 2003
            </p>  
        @endif

        @if (getMatiereRequete($data->idrequete)== 22)
                - Art. 605 du code de procedure civile <br>
                - Art. 33 du règlement intérieur de la cour de cassation <br>
                - Arrété 2003-001 du 06 janvier 2003
        @endif

        @if (getMatiereRequete($data->idrequete)== 24)

                - Art. 605 du code de procedure commerciale <br>
                - Art. 33 du règlement intérieur de la cour de cassation <br>
                - Arrété 2003-001 du 06 janvier 2003
            
        @endif

    <div>
        <table>
            <tr>
                <th>Nom de la partie versante</th>
                <th>Numéro de la Requête</th>
                <th>Somme consignée</th>
                <th>Date de la consignation</th>
                <th>Observations</th>
            </tr>
            <tr>
                <td>{{ getUserPartie($data->par_id) }}</td>
                <td>{{ getNumRequete($data->idrequete) }}</td>
                <td>{{ getMontantParIdSomme ($data->som_id) }}</td>
                <td>{{ dateToFrench($data->created_at,'l j F Y') }}</td>
                <td>{{ $data->observation }}</td>
            </tr>
        </table>
    </div>
    <div>
        <p>
            Arreter le présent état à la somme de : {{ getMontantEnLettre(getMontantParIdSomme ($data->som_id)) }} franc CFA
        </p>
        <p class="enteteGauche"> Le greffier en chef </p>
        <p class="entetedroite"> Ouagadougou le : {{ dateToFrench($data->created_at,'j F Y') }} </p>
    </div>
</body>
</html>

