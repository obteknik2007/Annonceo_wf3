$(function(){
    
 $('#map').vectorMap({
        map: 'fr_merc',
        backgroundColor:  'white', 
        onRegionClick:function(event, code){            
            var name = (code);  
            
              $.ajax({
                method : 'POST',
                url : 'php/front/home_filtre_dept.php',
                data : 'dept=' + code,
                success : function(data){
                  if(data == 'ko'){
                      //toast
                      setTimeout(function () {
                        toastr.options = {closeButton: true,progressBar: true,showMethod: 'fadeIn',timeOut: 1200};
                        toastr.warning('Pas d\'annonces actuellement dans ce département.');
                    }, 1300);
                  } else {
                    /*$('#contenu_ppal').html(data);
                    $('.jvectormap-tip').remove();

                    //Position du filtre Département sur le département choisi
                    var codeDept = code.substr(-2);   
                    $("#home_filtre_dept option[value=" + codeDept + "]").prop('selected', 'selected');

                    //maj departement au dessus liste annonces
                    $('#home_departement').html(codeDept);
                  
                  }*/
                  document.location.href = "http://localhost/annonceo/php/front/home.php?dept=" + code;
                }

                },
                error: function(XMLHttpRequest,textStatus,errorThrown){
                    alert(textStatus);
                }
            }); /* fin ajax */
            },
        regionStyle:{
              initial: {
                fill: 'grey',
                "fill-opacity": 1,
                stroke: 'none',
                "stroke-width": 0,
                "stroke-opacity": 1
              },
              hover: {
                fill: 'orange',
                "fill-opacity": 0.8,
                cursor: 'pointer'
              },
              selected: {
                fill: 'yellow'
              },
              selectedHover: {
              }
            }
            /* id&ée pour mettre le nb d'annonces par département....via fichier <script src="/js/gdp-data.js"></script>*/
        /*series: {
          regions: [{
            values: gdpData,
            scale: ['#C8EEFF', '#0071A4'],
            normalizeFunction: 'polynomial'
          }]
        },*/
        
        /*onRegionTipShow: function(e, el, code){
          el.html(el.html()+' (GDP - '+gdpData[code]+')');
        }*/
});
$('#retour_index_publier').on('click',function(e){
  e.preventDefault();
  document.location.href = "http://localhost/annonceo/index.php";


}); 

/****************************************************************************/
/***  CONNEXION ***/
/****************************************************************************/
$('#connexion').on('click',function(e){
  e.preventDefault();

  // recup valeurs champs de connexion
  var pseudo_connexion  = $('#pseudo_connexion').val();
  var mdp_connexion   = $('#mdp_connexion').val();

  $.post('connexion.php','action=connexion&pseudo_connexion=' + pseudo_connexion + '&mdp_connexion=' + mdp_connexion,function(data){
      if(data == 'KO'){
        //toast erreur
        setTimeout(function () {
            toastr.options = {closeButton: true,progressBar: true,showMethod: 'fadeIn',timeOut: 2000};
            toastr.warning('Erreur sur les identifiants');
        }, 1300);
      } else {
        setTimeout(function () {
          toastr.options = {closeButton: true,progressBar: true,showMethod: 'fadeIn',timeOut: 2000};
          toastr.success('Vous êtes connectés.');
      }, 1300);

      document.location.href="index.php";
      }
  },'html');
}); //{} connexion

/***  DECONNEXION ***/
$('#deconnexion').on('click',function(e){
  e.preventDefault();

  $.post('http://localhost/annonceo/connexion.php','action=deconnexion',function(data){
    if(data == 'ok'){
      //toast erreur
      /*setTimeout(function () {
          toastr.options = {closeButton: true,progressBar: true,showMethod: 'fadeIn',timeOut: 2000};
          toastr.success('Vous êtes déconnecté.');
      }, 1300);*/

      document.location.href="http://localhost/annonceo/index.php";
    } 
},'html');
}); //{} déconnexion

/****************************************************************************/
/***  INSCRIPTION ***/
/****************************************************************************/
$('#inscription').on('click',function(e){
  e.preventDefault();

 // recup valeurs champs de connexion
 /*
    $pseudo     =  secure_field($_POST['pseudo']);
    $mdp        =  secure_field($_POST['mdp']);
    $civilite   =  secure_field($_POST['civilite']);
    $prenom     =  secure_field($_POST['prenom']);
    $nom        =  secure_field($_POST['nom']);
    $telephone  =  secure_field($_POST['telephone']);
    $email      =  secure_field($_POST['email']);
 */
 var pseudo_inscription = $('#pseudo_inscription').val();
 var mdp_inscription    = $('#mdp_inscription').val();
 var civilite           = $('#civilite').val();
 var prenom             = $('#prenom').val();
 var nom                = $('#nom').val();
 var telephone          = $('#telephone').val();
 var email              = $('#email').val();

//envoi AJAX
 
 $.post('inscription_ajax.php','pseudo_inscription=' + pseudo_inscription + 
  '&mdp_inscription=' + mdp_inscription +
  '&civilite=' + civilite +
  '&prenom=' + prenom +
  '&nom=' + nom +
  '&telephone=' + telephone +
  '&email=' + email,
  function(json){
    //OK INSCRIPTION EFFECTUEE
     if(json == 'ok'){
      setTimeout(function () {
        toastr.options = {closeButton: true,progressBar: true,showMethod: 'fadeIn',timeOut: 2000};
        toastr.success('Merci de vous être inscrit sur notre site d\'annonces en ligne.');
    }, 1300);

      document.location.href="http://localhost/annonceo/index.php";

     } else {
       // ERREURS / TABLEAU JSON
       $('#inscription_erreurs').html(
        '<ul id="list_erreurs"></ul>');

      //CORPS liste : JE PARCOURE LES DATAS JSON ACTIONS
      $.each(json, function (index, value) {
          $('#list_erreurs').append('<li>' + value + '</li>');
      });
     }
 },'json');

}); //{} inscription
/****************************************************************************/
/*** form button cancel ****/
$('.cancel_form_update').on('click',function(e){
  e.preventDefault();
  $('#content_form_update').hide();
}); 

$('.cancel_form_add').on('click',function(e){
  e.preventDefault();
  $('#content_form_add').hide();
});   

/*** HOME ****/
// select tri par prix
//id select #home_filtre_prix

  // SELECT TRI PRIX
/*$(document).delegate('#home_filtre_prix','change', function() {

    var selected_value = $(this).val();
    alert('tri prix = ' + selected_value);
});*/







}); // FIN READY








$(function()
{
$('.slider').on('input change', function(){
          $(this).next($('.slider_label')).html(this.value);
        });
      $('.slider_label').each(function(){
          var value = $(this).prev().attr('value');
          $(this).html(value);
        });  
  
  
})