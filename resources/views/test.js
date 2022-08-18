<script type="text/javascript"> 
$(function () {
            var t = 1000; // rafraîchissement en millisecondes
            setTimeout('showDate()',t)
        });
       function showDate() {
            var date1 = new Date("08/01/2022");
            var date2 = new Date();
          diff = dateDiff(date2,date1);
            var time= 'Clôture des souscriptions dans: '+diff.day+' Jours'+ ' ' +diff.hour +' Heures'+ ' '+diff.min+' minutes';
            document.getElementById('horloge').innerHTML = time;
            refresh();
    }; 
function dateDiff(date1, date2){
    var diff = {}                           // Initialisation du retour
    var tmp = date2 - date1;
    tmp = Math.floor(tmp/1000);             // Nombre de secondes entre les 2 dates
    diff.sec = tmp % 60;                    // Extraction du nombre de secondes
    tmp = Math.floor((tmp-diff.sec)/60);    // Nombre de minutes (partie entière)
    diff.min = tmp % 60;                    // Extraction du nombre de minutes
 
    tmp = Math.floor((tmp-diff.min)/60);    // Nombre d'heures (entières)
    diff.hour = tmp % 24;                   // Extraction du nombre d'heures
     
    tmp = Math.floor((tmp-diff.hour)/24);   // Nombre de jours restants
    diff.day = tmp;
    return diff;
}
</script>