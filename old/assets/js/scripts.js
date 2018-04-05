$(function(){
    
 $('#map').vectorMap({
        map: 'fr_merc',
        backgroundColor:  'white', 
        onRegionClick:function(event, code){            
            var name = (code);  

              $.ajax({
                method : 'POST',
                url : 'php/front/home.php',
                data : 'dept=' + code,
                success : function(data){
                  if(data == 'ko'){
                      //toast
                      setTimeout(function () {
                        toastr.options = {closeButton: true,progressBar: true,showMethod: 'fadeIn',timeOut: 3000};
                        toastr.warning('Pas d\'annonces actuellement dans ce département.');
                    }, 1300);
                  } else {
                    $('#contenu_ppal').html(data);
                    $('.jvectormap-tip').remove();

                    //Position du filtre Département sur le département choisi
                    var codeDept = code.substr(-2);   
                    $("#home_filtre_dept option[value=" + codeDept + "]").prop('selected', 'selected');

                    //maj departement au dessus liste annonces
                    $('#home_departement').html(codeDept);
                  
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

/***  CONNEXION ***/
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

  $.post('connexion.php','action=deconnexion',function(data){
    if(data == 'ok'){
      //toast erreur
      setTimeout(function () {
          toastr.options = {closeButton: true,progressBar: true,showMethod: 'fadeIn',timeOut: 2000};
          toastr.success('Vous êtes déconnecté.');
      }, 1300);

      document.location.href="index.php";
    } 
},'html');
}); //{} déconnexion








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