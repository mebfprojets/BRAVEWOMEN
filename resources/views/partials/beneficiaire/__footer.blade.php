


{{-- script pour le select2  --}}
{{-- <script src="{{ asset("assets_beneficiare/assets/libs/jquery/jquery.min.js") }}"></script>
<script src="{{ asset("assets_beneficiare/assets/libs/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
<script src="{{ asset("assets_beneficiare/assets/libs/metismenu/metisMenu.min.js") }}"></script>
<script src="{{ asset("assets_beneficiare/assets/libs/simplebar/simplebar.min.js") }}"></script>
<script src="{{ asset("assets_beneficiare/assets/libs/node-waves/waves.min.js") }}"></script>

<script src="{{ asset("assets_beneficiare/assets/js/pages/form-advanced.init.js") }}"></script> --}}
{{--Fin du  script pour le select2  --}}

  <!-- js placed at the end of the document so the pages load faster -->
  <script src="{{asset('js/vendor/bootstrap.min.js') }}"></script>
  <script src="{{asset('js/vendor/jquery.min.js') }} "></script>
  <script src="{{ asset('js/vendor/bootstrap.min.js') }}"></script>
  <script>
    $(document).ready(function() {
      $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    })
  </script>
  <script src="{{ asset('js/plugins.js') }}"></script>
  <script class="include" type="text/javascript" src="{{ asset("assets_beneficiare/lib/jquery.dcjqaccordion.2.7.js") }} "></script>
  <script src="{{ asset("assets_beneficiare/lib/jquery.scrollTo.min.js") }} "></script>
  <script src="{{ asset("assets_beneficiare/lib/jquery.nicescroll.js") }} " type="text/javascript"></script>
  <script src=" {{ asset("assets_beneficiare/lib/jquery.sparkline.js") }} "></script>
  <!--common script for all pages-->
  <script src="{{ asset("assets_beneficiare/lib/common-scripts.js") }} "></script>
  <script type="text/javascript" src="{{ asset("assets_beneficiare/lib/gritter/js/jquery.gritter.js") }} "></script>
  <script type="text/javascript" src="{{ asset("assets_beneficiare/lib/gritter-conf.js") }} "></script>
  <!--script for this page-->
  <script class="include" type="text/javascript" src="{{ asset("assets_beneficiare/lib/jquery.dcjqaccordion.2.7.js") }} "></script>
  <script src="{{ asset("assets_beneficiare/lib/jquery.scrollTo.min.js") }} "></script>
  <script src="{{ asset("assets_beneficiare/lib/jquery.nicescroll.js") }} "  type="text/javascript"></script>
  <script src=" {{ asset("assets_beneficiare/lib/sparkline-chart.js") }} "  type="text/javascript"></script>
  <script src=" {{ asset("assets_beneficiare/lib/zabuto_calendar.js") }} "  type="text/javascript"></script>
  <script src=" {{ asset("assets_beneficiare/lib/advanced-datatable/js/jquery.dataTables.js") }} "  type="text/javascript"></script>
  <script src=" {{ asset("assets_beneficiare/lib/advanced-datatable/js/DT_bootstrap.js") }} "  type="text/javascript"></script>
  <script src=" {{ asset("assets_beneficiare/lib/common-scripts.js") }} "  type="text/javascript"></script>
  <script src="{{ asset("assets_beneficiare/lib/jquery-ui-1.9.2.custom.min.js") }}"  type="text/javascript"></script>
  <script type="text/javascript" src="{{ asset("assets_beneficiare/lib/bootstrap-fileupload/bootstrap-fileupload.js") }}"></script>
  
  
  
  <script src=" {{ asset("js/app.js") }}"></script>
  <script src="{{ asset("js/mon.js") }}"></script>
  <script src={{ asset("js/test.min.js") }}></script>
  <script src="{{ asset("js/pages/formsWizard.js") }}"></script>
  
  <script>$(function(){ FormsWizard.init(); });</script>
  @yield('script_additionnel')
 
 
  <script>

    $('#cout1').change(function(){
  alert("The text has been changed.");
});
  </script>
  <script type="text/javascript">
   $(document).ready(function() {
	$("input[id^='upload_file']").each(function() {
		var id = parseInt(this.id.replace("upload_file", ""));
		$("#upload_file" + id).change(function() {
			if ($("#upload_file" + id).val() != "") {
				$("#moreImageUploadLink").show();
			}
		});
	});
});
</script>
<script>
    $(document).ready(function() {
	var upload_number = 2;
	$('#attachMore').click(function() {
    //alert('oko');
		//add more file
		var moreUploadTag = '';
		moreUploadTag += '<div class="element"><label for="upload_file"' + upload_number + '>Joindre une image '  + '</label>';
		moreUploadTag += '<input type="file" accept=" .jpeg, .png"  id="upload_file' + upload_number + '" name="image' + upload_number + '"/>';
		moreUploadTag += ' <a href="javascript:del_file(' + upload_number + ')" style="cursor:pointer;" onclick="return confirm("Are you really want to delete ?")">Supprimer ' + '</a></div>';
		$('<dl id="delete_file' + upload_number + '">' + moreUploadTag + '</dl>').fadeIn('slow').appendTo('#moreImageUpload');
    $('#champ_nombre_dimage').val(upload_number)
    upload_number++;
   
	});
});
function del_file(eleId) {
	var ele = document.getElementById("delete_file" + eleId);
	ele.parentNode.removeChild(ele);
}
</script>
  <script type="text/javascript">
  
    $(".dur").datepicker({
      });
  </script>
  <script>
    function setDrop() {
        if (!document.getElementById('third').classList.contains("fstdropdown-select"))
            document.getElementById('third').className = 'fstdropdown-select';
        setFstDropdown();
    }
    setFstDropdown();
    function removeDrop() {
        if (document.getElementById('third').classList.contains("fstdropdown-select")) {
            document.getElementById('third').classList.remove('fstdropdown-select');
            document.getElementById("third").fstdropdown.dd.remove();
            document.querySelector("#third~.fstdiv").remove();
        }
    }
    function addOptions(add) {
        var select = document.getElementById("fourth");
        for (var i = 0; i < add; i++) {
            var opt = document.createElement("option");
            var o = Array.from(document.getElementById("fourth").querySelectorAll("option")).slice(-1)[0];
            var last = o == undefined ? 1 : Number(o.value) + 1;
            opt.text = opt.value = last;
            select.add(opt);
        }
    }
    function removeOptions(remove) {
        for (var i = 0; i < remove; i++) {
            var last = Array.from(document.getElementById("fourth").querySelectorAll("option")).slice(-1)[0];
            if (last == undefined)
                break;
            Array.from(document.getElementById("fourth").querySelectorAll("option")).slice(-1)[0].remove();
        }
    }
    function updateDrop() {
        document.getElementById("fourth").fstdropdown.rebind();
    }
</script>
 
<script>
  function deux_somme_complementaire(montant1, montant2, somme){
    var valmontant1= $("#"+montant1).val();
    var valsomme= $("#"+somme).val();
    if(valsomme/2 != valmontant1 ){
      $("#tester").prop('disabled', true);
      alert("Attention le montant de la subvention ne doit pas être supérieur au coût du projet et la subvention doit être la moitié du coût total!!!");
      $("#"+montant1).val(' ');
      $("#"+somme).val(' ');
      $("#"+montant2).val(' ');
    }
    else{
       $("#tester").prop('disabled', false);
          var restant= valsomme - valmontant1;
          $("#"+montant2).val(restant);
          format_montant(montant2);
          format_montant(montant1);
          format_montant(somme);
    }
 
  }
 
  function verifier_montant(montant_champ, devi_id,  facture_id ){
        var montant= $("#"+montant_champ).val();
        var devi_id= $("#"+devi_id).val();
        var facture_id= $("#"+facture_id).val();
       var mode_paiement= $('#mode_de_paiement').val();
       // alert(mode_paiement);
//Verifier si le montant de la demande de paiment est supérieur à 2 million le paiement mobile n'est pas possible
    if(mode_paiement=='paiement_mobile' && (montant > 2000000)){
            alert('Cette demande de paiement sera rejetée le car les paiements mobiles ne doivent pas exceder 2 million ')
        }
       if(montant > 2000000){
          $('#mode_de_paiement option[value="paiement_mobile"]').attr('disabled', true);;
        }
        else{
          $('#mode_de_paiement option[value="paiement_mobile"]').attr('disabled', false);;
        }
       
        var url = "{{ route('verifier_montant') }}";
        $.ajax({
                 url: url,
                  type: 'GET',
                  data: {montant: montant, devi_id:devi_id, facture_id:facture_id},
                  dataType: 'json',
                  error:function(data){alert("Erreur");},
                  success: function (data) {
                 
                   if(data==1){
                          $(".depassement_du_montant_du_devis").show();
                            $(".soumettre_facture").prop('disabled', true);
                          format_montant(montant_champ);
                   }
                   else{
                        $(".depassement_du_montant_du_devis").hide();
                          $(".soumettre_facture").prop('disabled', false);
                          format_montant(montant_champ);
                   }
                  }
                  });

  }
function verifier_montant_devis(montant_champ, entreprise_id,devi_id){
   var montant= $("#"+montant_champ).val();
   var devi_id= $("#"+devi_id).val();
   var entreprise_id= $("#"+entreprise_id).val();
  // alert(devi_id);
   var url = "{{ route('verifier_montant_devis') }}";
   $.ajax({
            url: url,
             type: 'GET',
             data: {montant: montant, entreprise_id:entreprise_id, devis_id:devi_id},
             dataType: 'json',
             error:function(data){alert("Erreur");},
             success: function (data) {
              if(data==1){

                     $(".depassement_du_montant_du_devis").show();
                       $(".soumettre_facture").prop('disabled', true);
                     format_montant(montant_champ);
              }
              else{
                   $(".depassement_du_montant_du_devis").hide();
                     $(".soumettre_facture").prop('disabled', false);
                     format_montant(montant_champ);
              }
             }
             });

}
</script>
<script>
    function changeValue(parent, child, niveau)
              {
                  var idparent_val = $("#"+parent).val();
                  var id_param = parseInt(niveau);
                  var url = '{{ route('valeur.selection') }}';
                  $.ajax({
                          url: url,
                          type: 'GET',
                          data: {idparent_val: idparent_val, id_param:id_param, parent:parent},
                          dataType: 'json',
                          error:function(data){alert("Erreur");},
                          success: function (data) {
                              var options = '<option></option>';
                              for (var x = 0; x < data.length; x++) {

                                  options += '<option value="' + data[x]['id'] + '">' + data[x]['name'] + '</option>';
                              }
                             $('#'+child).html(options);
                          }
                  });
              }
</script>
<script type="text/javascript">
   $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
</script>
  <script type="application/javascript">
    $(document).ready(function() {
      $("#date-popover").popover({
        html: true,
        trigger: "manual"
      });
      $("#date-popover").hide();
      $("#date-popover").click(function(e) {
        $(this).hide();
      });

      $("#my-calendar").zabuto_calendar({
        action: function() {
          return myDateFunction(this.id, false);
        },
        action_nav: function() {
          return myNavFunction(this.id);
        },
        ajax: {
          url: "show_data.php?action=1",
          modal: true
        },
        legend: [{
            type: "text",
            label: "Special event",
            badge: "00"
          },
          {
            type: "block",
            label: "Regular event",
          }
        ]
      });
    });

    function myNavFunction(id) {
      $("#date-popover").hide();
      var nav = $("#" + id).data("navigation");
      var to = $("#" + id).data("to");
      console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
    }
  </script>
    <script>
      $.backstretch("img/login-bg.jpg", {
        speed: 500
      });
    </script>
    <script type="text/javascript">
      /* Formating function for row details */
      function fnFormatDetails(oTable, nTr) {
        var aData = oTable.fnGetData(nTr);
        var sOut = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
        sOut += '<tr><td>Rendering engine:</td><td>' + aData[1] + ' ' + aData[4] + '</td></tr>';
        sOut += '<tr><td>Link to source:</td><td>Could provide a link here</td></tr>';
        sOut += '<tr><td>Extra info:</td><td>And any further details here (images etc)</td></tr>';
        sOut += '</table>';
  
        return sOut;
      }
  
      $(document).ready(function() {
        /*
         * Insert a 'details' column to the table
         */
        var nCloneTh = document.createElement('th');
        var nCloneTd = document.createElement('td');
        nCloneTd.innerHTML = '<img src="lib/advanced-datatable/images/details_open.png">';
        nCloneTd.className = "center";
  
        $('#hidden-table-info thead tr').each(function() {
          this.insertBefore(nCloneTh, this.childNodes[0]);
        });
  
        $('#hidden-table-info tbody tr').each(function() {
          this.insertBefore(nCloneTd.cloneNode(true), this.childNodes[0]);
        });
  
        /*
         * Initialse DataTables, with no sorting on the 'details' column
         */
        var oTable = $('#hidden-table-info').dataTable({
          "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": [0]
          }],
          "aaSorting": [
            [1, 'asc']
          ]
        });
  
        /* Add event listener for opening and closing details
         * Note that the indicator for showing which row is open is not controlled by DataTables,
         * rather it is done here
         */
        $('#hidden-table-info tbody td img').live('click', function() {
          var nTr = $(this).parents('tr')[0];
          if (oTable.fnIsOpen(nTr)) {
            /* This row is already open - close it */
            this.src = "lib/advanced-datatable/media/images/details_open.png";
            oTable.fnClose(nTr);
          } else {
            /* Open this row */
            this.src = "lib/advanced-datatable/images/details_close.png";
            oTable.fnOpen(nTr, fnFormatDetails(oTable, nTr), 'details');
          }
        });
      });
    </script>
    