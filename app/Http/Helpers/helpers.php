<?php

use App\Models\Decision;
use App\Models\Proportion_de_depense_promotrice;
use App\Models\User;
use App\Models\Valeur;
use Illuminate\Support\Facades\Storage;

if (!function_exists('getlibelle')) {
    function getlibelle($id)
        {
            $record = Valeur::where('id', $id)->first();
            $libelle = isset($record['libelle']) ? $record['libelle'] : "";
                return $libelle;

        }
    }
    if (!function_exists('getrepresentationmembre')) {
        function getrepresentationmembre($id)
            {
                $record = User::where('id', $id)->first();
                $structure_represente = isset($record['structure_represente']) ? $record['structure_represente'] : "";
                return getlibelle($structure_represente) ;
            }
        }
        if (!function_exists('getnombrededecisiondesmembreducomitedelentreprise')) {
            function getnombrededecisiondesmembreducomitedelentreprise($id)
                {
                    $record = Decision::where('entreprise_id', $id)->get();
                    return count($record) ;
                }
            }
            if (!function_exists('reformater_montant')){
                function reformater_montant($montant){
                    return str_replace(",","",$montant);
                }

            }
            //Fonction pour savoir si les information d'une entreprise ont été complété
            if (!function_exists('proportionpromoteur_enregistre')) {
                function proportionpromoteur_enregistre($id)
                    {
                        $record = Proportion_de_depense_promotrice::where('promotrice_id', $id)->get();
                        if(count($record)==0){
                            return 1;
                        }
                        else{
                            return 0;
                        }
                        
                    }
                    if(!function_exists('format_prix')){
                        function format_prix($prix){
                            return number_format($prix, 0, ' ',' ').' '.'FCFA';
                        }
                    }
                    if(!function_exists('format_date')){
                        function format_date($date){
                            return  date('d-m-Y', strtotime($date));
                        }
                    }
                    if(!function_exists('upload_file')){
                        function upload_file($url){
                            return Storage::download($url);
                        }
                    }
                  
                   
                    if(!function_exists('genererExcel')){
                        function genererExcel($items){
                            $fileName = "itemdata-".date('d-m-Y').".xls";

// Définir les informations d'en-tête pour exporter les données au format Excel

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename='.$fileName);

// Défini la variable sur false pour l'en-tête
        $heading = false;

// Ajouter les données de la table MySQL au fichier Excel
        if(!empty($items)) {
    foreach($items as $item) {
    if(!$heading) {
    echo implode("\t", array_keys($item)) . "\n";
    $heading = true;
    }
    echo implode("\t", array_values($item)) . "\n";
    }
    }
    exit();
                            
                        }
                    }
                }
?>
