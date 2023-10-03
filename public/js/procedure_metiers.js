function confirmChangeStatus1(id_entreprise, id_user){
      document.getElementById("id_entreprise").setAttribute("value", id_entreprise);
      document.getElementById("id_user").setAttribute("value", id_user);
}
function validerdossier(){
  $(function(){
      var id_entreprise= $("#id_entreprise").val();
      var id_user= $("#id_user").val();
      var raison= null;
      var url = "{{ route('entreprise.statuermembrecomite') }}";
      $.ajax({
          url: url,
          type:'GET',
          data: {id_entreprise: id_entreprise, id_user : id_user} ,
          error:function(){alert('error');},
          success:function(){
              $('#modal-confirm-changestatus').hide();
              location.reload();
          }
      });
      });
}

function rejeterdossier(){
  $(function(){
      var id_entreprise= $("#id_entreprise").val();
      var id_user= $("#id_user").val();
      var raison= $("#raison_du_rejet").val();
      var url = "{{ route('entreprise.statuermembrecomite') }}";
      $.ajax({
          url: url,
          type:'GET',
          data: {id_entreprise: id_entreprise, id_user : id_user, raison:raison} ,
          error:function(){alert('error');},
          success:function(){
              $('#modal-confirm-rejet').hide();
              location.reload();
          }
      });
      });
}
function statuersurLasoucriptionPmeParleComitePourLaPhaseFormation(statut){
  var id_entreprise= $("#id_entreprise").val();
  var observation= $("#observation").val();
  var url = "{{ route('entreprise.statuercomitetechniquepmephase1') }}";
  $.ajax({
          url: url,
          type:'GET',
          data: {id_entreprise: id_entreprise, observation:observation, statut:statut} ,
          error:function(){alert('error');},
          success:function(){
              $('#modal-confirm-rejet').hide();
              location.reload();
          }
      });
}

function recupererentreprise_id(id_entreprise,conforme){
      document.getElementById("id_entreprise").setAttribute("value", id_entreprise);
      document.getElementById("conformite").setAttribute("value", conforme);
}
function saveconformite_souscription(){
  $(function(){
      var id_entreprise= $("#id_entreprise").val();
      var conforme= $("#conformite").val();
      var url = "{{ route('souscription.saveconformite') }}";
      $.ajax({
          url: url,
          type:'GET',
          data: {id_entreprise: id_entreprise, conforme : conforme} ,
          error:function(){alert('error');},
          success:function(){
              $('#modal-confirm-changestatus').hide();
              location.reload();
          }
      });
      });
}
function save_avis_ugp(avis){
  var id_entreprise= $("#id_entreprise").val();
  var observation= $("#observation").val();
  var url = "{{ route('souscription.savedecisionugp') }}";
  $.ajax({
          url: url,
          type:'GET',
          data: {id_entreprise: id_entreprise, observation:observation, avis:avis} ,
          error:function(){alert('error');},
          success:function(){
              $('#modal-confirm-rejet').hide();
              location.reload();
          }
      });

}
function rejeterdossier(){
  $(function(){
      var id_entreprise= $("#id_entreprise").val();
      var id_user= $("#id_user").val();
      var raison= $("#raison_du_rejet").val();
      var url = "{{ route('entreprise.statuermembrecomite') }}";
      $.ajax({
          url: url,
          type:'GET',
          data: {id_entreprise: id_entreprise, id_user : id_user, raison:raison} ,
          error:function(){alert('error');},
          success:function(){
              $('#modal-confirm-rejet').hide();
              location.reload();
          }
      });
      });
}
