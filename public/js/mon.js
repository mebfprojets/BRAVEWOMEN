
    $(document).ready(function() {
      $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    })
 
    $('#error').hide();
    $('#autre_occupation').hide();
    $('#autre_formation').hide();
    $('#autre_niveau_instruction').hide();
    $('#systeme_suivi').hide();
    $('#autre_clientele_ciblee').hide();
    $('#autre_techno_utilisee_dans_le_projet').hide();
    $('#autre_techno_actuelle').hide();
    $('#autre_provenance_clientele').hide();
    $('#autre_nature_clientele').hide();
    $('#autre_systeme_de_suivi').hide();
    $('#autre_maillon_activite').hide();
    $('.entreformalise').hide();
    $('.aggremendispo').hide();
    $('.associations').hide();
    $('#typesyssuivi').hide();
    $('#domaine_formation').hide();
    $('#description_innovation').hide();
    $("#structure_rep").hide();
    $("#banque").hide();
    
    function empty_input_file(input) {
        $('#'+ input).val('');
}
function cout(){
  var cout_investissement= $('#cout_investissement').val();
    var fonderoulement= $('#fonderoulement').val();
    var cout_total= parseInt(cout_investissement) + parseInt(fonderoulement);
   $('#cout_total').attr("value",cout_total);
}
function deux_somme_complementaire(montant1, montant2, somme){
    var valmontant1=$("#"+montant1).val();
    var valsomme= $("#"+somme).val();
    //console.log(valsomme/2 == valmontant1);
    if(valsomme/2 == valmontant1 ){
        var restant= valsomme - valmontant1;
        $("#"+montant2).val(restant);
        format_montant(montant2);
        format_montant(montant1);
        format_montant(somme);
     
    }
    else{
       
        console.log("Attention le montant de la subvention ne doit pas être supérieur au coût du projet et la subvention doit être la moitié du coût total!!!");
        $("#"+montant1).val(' ');
        $("#"+somme).val(' ');
        $("#"+montant2).val(' ');
      
    }
 
  }
    function afficher(){
        var formalise=$('#formalise').val();
        if(formalise==1){
            $('.entreformalise').show();
        }
        else{
            $('.entreformalise').hide();
        }
    }
    function validerterme(){
        var valeur= $('#val_terms').val();
        if($('#val_terms').is(':checked')){
            $('#valider').prop('disabled', false);
        }
        else{
            $('#valider').prop('disabled', true);
        }
    }
    function afficherinnov(){
        var formalise=$('#innovation').val();
        if(formalise==1){
            $('#description_innovation').show();
        }
        else{
            $('#description_innovation').hide();
        }
    }
    function afficher_citer_association(){
        var membre_ass=$('#membre_ass').val();
        if(membre_ass==1){
            $('.associations').show();
        }
        else{
            $('.associations').hide();
        }
    }
    function afficher_nombanque(){
        var compte_perso_existe=$('#compte_perso_existe').val();
        if(compte_perso_existe=="oui"){
            $('#nom_structure').show();
        }
        else{
            $('#nom_structure').hide();
        }
    }
    function cachertypeSystem(){
        var system=$('#systeme_suivi').val();
        if(system==1){
            $('#typesyssuivi').show();
        }
        else{
            $('#typesyssuivi').hide();
        }

    }
    function afficher2(){
        var agrement_exige=$('#agrement_exige').val();
        if(agrement_exige==1){
            $('.aggremendispo').show();
        }
        else{
            $('.aggremendispo').hide();
        }
    }
    function afficherSiOui(champinit, champdep){

        var contenuchampinit= $('#'+champinit).val();
//alert(contenuchampinit);
        if((contenuchampinit==1) || (contenuchampinit=="oui") ){
            $('.'+champdep).show();
        }
        else{
            $('.'+champdep).hide();
        }
    }
    function afficherSiCheck(champinit, champdep){
        if($( '#'+champinit).is(':checked')){
            $('#'+champdep).show();
        }
        else{
            $('#'+champdep).hide();
        }
    }
    function afficherSicheck(){
        if($( "#membre_comite" ).is(':checked')){
            $('#structure_rep').show();
        }
        else{
            $('#structure_rep').hide();
            $('#structure_rep').val()="";

        }
    }
    function afficherautre(idchamp,valeurautre,idautre){
        var autre= $('#'+idchamp).val();
        //alert(autre);
        if(autre==valeurautre){
            $('#'+idautre).show();
        }
        else{
            $('#'+idautre).hide();
        }
        
    }
function VerifyUploadSizeIsOK(docsize)
{
   var UploadFieldID = docsize;
   var MaxSizeInBytes = 2097152;
   var fld = document.getElementById(docsize);
   var val= fld.value;
  // alert(val)
   var ext = val.split(".");
    ext = ext[ext.length-1].toLowerCase(); 
   
   var arrayExtensions = ["jpg" , "jpeg", "png", "pdf"];
if (arrayExtensions.lastIndexOf(ext) == -1) {
    alert("Ce type de fichier n'est pas autorisé. Seul les extensions : jpg, jpeg, png et pdf sont autorisés");
    $('#'+ docsize).val('');
}
   if( fld.files && fld.files.length == 1 && fld.files[0].size > MaxSizeInBytes )
   {
      alert("La taille de la copie des pièce jointes ne doit pas exceder " + parseInt(MaxSizeInBytes/1024/1024) + "MB");
      $('#'+ docsize).val('');
      return false;
   }
   return true;
} 
//Taille limitée à 10 Mo.
function VerifyUploadSizeIsOK_lourd (docsize)
{
   var UploadFieldID = docsize;
   var MaxSizeInBytes = 10485760;
   var fld = document.getElementById(docsize);
   var val= fld.value;
   var ext = val.split(".");
    ext = ext[ext.length-1].toLowerCase(); 
   
   var arrayExtensions = ["jpg" , "jpeg", "png", "pdf"];
if (arrayExtensions.lastIndexOf(ext) == -1) {
    alert("Ce type de fichier n'est pas autorisé. Seul les extensions : jpg, jpeg, png et pdf sont autorisés");
    $('#'+ docsize).val('');
}
   if( fld.files && fld.files.length == 1 && fld.files[0].size > MaxSizeInBytes )
   {
      alert("La taille de la copie des pièce jointes ne doit pas exceder " + parseInt(MaxSizeInBytes/1024/1024) + "MB");
      $('#'+ docsize).val('');
      return false;
   }
   return true;
} 
//function pour rendre le boutton de rejet desactivé tant que le champ raison n'est pas renseigné
function activerLeBouttonRejet(raison_du_rejet,btnrejet){
    var autre= $('#'+raison_du_rejet).val(); 
    if(autre !=""){
        $('#'+btnrejet).prop('disabled', false);
    }
    else{
       alert("Renseigner d'abord le raison du rejet du dossier")
        $('#'+btnrejet).prop('disabled', true);
    }
}
function format_montant(id){
    //alert(id);
var val= $('#'+id).val();
$('#montant_devi_cache').val(val);
var index = val.indexOf("XOF");
if(index !== -1){
    newval= val;
}
else{
    var val1= val.split(" ").join("");
    // var newval= new Intl.NumberFormat('fr', {unitDisplay: 'long'}).format(val1);
     var newval= new Intl.NumberFormat('fr', {
     style: 'currency',
   currency: 'XOF',
     }).format(val1);
}

$('#'+id).val(newval);
}
function calculer_pourcentage(id_avance, id_montant_devis, id_montant_devi_cache,avance_exige_div){
montant_devis= $('#'+ id_montant_devi_cache).val();
montant_devis=montant_devis.replace('F CFA', '');
var montant_avance=  $('#'+id_avance).val();
var pourcentage= (parseInt(montant_avance)/parseInt(montant_devis))*100;
var p= "<p style='color:red'> Soit " + pourcentage+ " % du montant total de la prestation</p>";
$('#'+avance_exige_div).append(p);
format_montant(id_avance);

}

$('input.CurrencyInput').on('blur', function() {
    var mnt= ($('.CurrencyInput').val());
    const value = this.value.replace(/,/g, '');
    this.value = parseFloat(value).toLocaleString('en-US', {
      style: 'decimal',
      maximumFractionDigits: 2,
      minimumFractionDigits: 2
    });
  });
$("input[data-type='currency']").on({
    keyup: function() {
      formatCurrency($(this));
    },
    blur: function() { 
      formatCurrency($(this), "blur");
    }
});


function formatNumber(n) {
  // format number 1000000 to 1,234,567
  return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ")
}
function affectervaleur_a_unchamp(id_du_champ,valeur_affectee){
   // alert(id_du_champ);
    document.getElementById(id_du_champ).setAttribute("value", valeur_affectee);
}
function formatCurrency(input, blur) {
  // appends $ to value, validates decimal side
  // and puts cursor back in right position.
  
  // get input value
  var input_val = input.val();
  
  // don't validate empty input
  if (input_val === "") { return; }
  
  // original length
  var original_len = input_val.length;

  // initial caret position 
  var caret_pos = input.prop("selectionStart");
    
  // check for decimal
  if (input_val.indexOf(" ") >= 0) {

    // get position of first decimal
    // this prevents multiple decimals from
    // being entered
    var decimal_pos = input_val.indexOf(" ");

    // split number by decimal point
    var left_side = input_val.substring(0, decimal_pos);
    var right_side = input_val.substring(decimal_pos);

    // add commas to left side of number
    left_side = formatNumber(left_side);

    // validate right side
    right_side = formatNumber(right_side);
    
    // On blur make sure 2 numbers after decimal
    if (blur === "blur") {
      right_side += "00";
    }
    
    // Limit decimal to only 2 digits
    right_side = right_side.substring(0, 0);

    // join number by .
    input_val =  left_side + " " + right_side;

  } else {
    // no decimal entered
    // add commas to number
    // remove all non-digits
    input_val = formatNumber(input_val);
    // input_val = "$" + input_val;
    
    // final formatting
    // if (blur === "blur") {
    //   input_val += ".00";
    // }
  }
  // send updated string to input
  input.val(input_val);
  // put caret back in the right position
  var updated_len = input_val.length;
  caret_pos = updated_len - original_len + caret_pos;
  input[0].setSelectionRange(caret_pos, caret_pos);
}
 function recharger_page_precedente(){
    window.history.back();
    location.reload(); 
 }










