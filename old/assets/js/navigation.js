// fonction de chargt ajax
function chargtContenuPHP(idLien,urlPage,container){

    $.ajax({
        type : 'POST',
        cache: false,
        url : urlPage,  
        success : function(data){ $(container).html(data); },
        error: function(XMLHttpRequest,textStatus,errorThrown){
            alert(textStatus);
        }
    }); 

} //fin function

//ajax loader
function showLoader(div){
    $(div).append('<div class="loader"></div>');
    $('.loader').fadeTo(500,0.6);
}

function hideLoader(){
    $('.loader').fadeOut(500,function(){
        $('.loader').remove();
    });
}
/************************************************************************************************* */
$(function(){

/** NAVIGATION PRINCIPALE ***/
/***************************/
// ADMIN
/*
       
                <li><a href="#" id="nav_gestion_membres">Gestion des membres</a></li>
                <li><a href="#" id="nav_gestion_categories">Gestion des catégories</a></li>
                <li><a href="#" id="nav_gestion_annonces">Gestion des annonces</a></li>
                <li><a href="#" id="nav_gestion_commentaires">Gestion des commentaires</a></li>
                <li><a href="#" id="nav_gestion_notes">Gestion des notes</a></li>
*/
/* Vers menu GESTION DES MEMBRES */
$('#nav_gestion_membres').on('click',function(e){
    e.preventDefault();
    chargtContenuPHP(this,'php/back_office/gestion_membres.php','#contenu_ppal');
});

/* Vers menu GESTION DES CATEGORIES */
$('#nav_gestion_categories').on('click',function(e){
    e.preventDefault();
    chargtContenuPHP(this,'php/back_office/gestion_categories.php','#contenu_ppal');
});

/* Vers menu GESTION DES ANNONCES */
$('#nav_gestion_annonces').on('click',function(e){
    e.preventDefault();
    chargtContenuPHP(this,'php/back_office/gestion_annonces.php','#contenu_ppal');
});

/* Vers menu GESTION DES COMMENTAIRES */
$('#nav_gestion_commentaires').on('click',function(e){
    e.preventDefault();
    chargtContenuPHP(this,'php/back_office/gestion_commentaires.php','#contenu_ppal');
});

/* Vers menu GESTION DES NOTES */
$('#nav_gestion_notes').on('click',function(e){
    e.preventDefault();
    chargtContenuPHP(this,'php/back_office/gestion_notes.php','#contenu_ppal');
});

/* Vers menu STATISTIQUES */
$('#nav_stats').on('click',function(e){
    e.preventDefault();
    chargtContenuPHP(this,'php/back_office/statistiques.php','#contenu_ppal');
});
/***************************/
//HEADER
/* Vers menu QUI SOMMES-NOUS */
$('#nav_qui_sommesnous').on('click',function(e){
    e.preventDefault();
    chargtContenuPHP(this,'php/front/qui_sommesnous.php','#contenu_ppal');
});

/* Vers menu CONTACT */
$('#nav_contact').on('click',function(e){
    e.preventDefault();
    chargtContenuPHP(this,'php/front/contact.php','#contenu_ppal');
});

/* Champ de recherche */
$('#index_search').on('input',function(e){
    e.preventDefault();
    
    var content_search = $(this).val();
    console.log('Contenu recherché = ' +content_search);

    //envoi à search.php
    $.post('php/front/search.php','content_search=' + content_search,function(data){

        $('#contenu_ppal').html('Résultats de de recherche :<br><br>').append(data);
    },'html');
});

/* Vers INSCRIPTION MEMBRE */
$('#nav_inscription').on('click',function(e){
    e.preventDefault();
    chargtContenuPHP(this,'inscription.php','#contenu_ppal');
});

/* Vers CONNEXION MEMBRE */
$('#nav_connexion').on('click',function(e){
    e.preventDefault();
    chargtContenuPHP(this,'connexion.php','#contenu_ppal');
});

/*********************************************************/
/* Vers page PROFIL */
/*********************************************************/
$('#nav_profil').on('click',function(e){
    e.preventDefault();
    chargtContenuPHP(this,'profil.php','#contenu_ppal');
});

/* Profil => UPDATE PSEUDO */
$(document).delegate('#profil_pseudo','click',function(){
    var val = $('#profil_pseudo').text(); //alert('Valeur initiale = ' + val);
    
    $(this).replaceWith('<span id="profil_pseudo2"><form>' + 
    '<input id="value_pseudo" type="text" value="' + val + '">' + 
    '<input id="value_pseudo_hidden" type="hidden" value="' + val + '">' + 
    '<button id="pseudo_edit_cancel" type="reset" class="btn btn-primary btn-sm">Annuler</button>' +
    '<button id="pseudo_edit" type="submit" class="btn btn-primary btn-sm">Modifier</button></form></span>');
});

$(document).delegate('#pseudo_edit_cancel','click',function(){
    var val_initiale = $('#value_pseudo_hidden').val(); //alert('Valeur à remettre = ' + val_initiale);
    
    $('#profil_pseudo2').replaceWith('<span id="profil_pseudo">' + val_initiale + '</span>');
});

$(document).delegate('#pseudo_edit','click',function(e){
    e.preventDefault();
    var value_pseudo = $('#value_pseudo').val(); //alert('Valeur à enregistrer = ' + value_pseudo);
    
    //AJAX POUR MODIF VALEUR
    $.post('profil_edit.php','champ=pseudo&value_pseudo=' + value_pseudo,function(data){
        //modif champ
        $('#profil_pseudo2').replaceWith('<span id="profil_pseudo">' + value_pseudo + '</span>');
        
        //toast
        setTimeout(function () {
            toastr.options = {closeButton: true,progressBar: true,showMethod: 'fadeIn',timeOut: 2000};
            toastr.success('Modification du pseudo effectuée.');
        }, 1300);
    },'text');
});

/* Profil => UPDATE NOM */
$(document).delegate('#profil_nom','click',function(){
    var val = $('#profil_nom').text(); //alert('Valeur initiale = ' + val);
    
    $(this).replaceWith('<span id="profil_nom2"><form>' + 
    '<input id="value_nom" type="text" value="' + val + '">' + 
    '<input id="value_nom_hidden" type="hidden" value="' + val + '">' + 
    '<button id="nom_edit_cancel" type="reset" class="btn btn-primary btn-sm">Annuler</button>' +
    '<button id="nom_edit" type="submit" class="btn btn-primary btn-sm">Modifier</button></form></span>');
});

$(document).delegate('#nom_edit_cancel','click',function(){
    var val_initiale = $('#value_nom_hidden').val(); //alert('Valeur à remettre = ' + val_initiale);
    
    $('#profil_nom2').replaceWith('<span id="profil_nom">' + val_initiale + '</span>');
});

$(document).delegate('#nom_edit','click',function(e){
    e.preventDefault();
    var value_nom = $('#value_nom').val(); //alert('Valeur à enregistrer = ' + value_pseudo);
    
    //AJAX POUR MODIF VALEUR
    $.post('profil_edit.php','champ=nom&value_nom=' + value_nom,function(data){
        //modif champ
        $('#profil_nom2').replaceWith('<span id="profil_nom">' + value_nom + '</span>');
        
        //toast
        setTimeout(function () {
            toastr.options = {closeButton: true,progressBar: true,showMethod: 'fadeIn',timeOut: 2000};
            toastr.success('Modification du nom effectuée.');
        }, 1300);
    },'text');
});


/* Profil => UPDATE PRENOM */
$(document).delegate('#profil_prenom','click',function(){
    var val = $('#profil_prenom').text(); //alert('Valeur initiale = ' + val);
    
    $(this).replaceWith('<span id="profil_prenom2"><form>' + 
    '<input id="value_prenom" type="text" value="' + val + '">' + 
    '<input id="value_prenom_hidden" type="hidden" value="' + val + '">' + 
    '<button id="prenom_edit_cancel" type="reset" class="btn btn-primary btn-sm">Annuler</button>' +
    '<button id="prenom_edit" type="submit" class="btn btn-primary btn-sm">Modifier</button></form></span>');
});

$(document).delegate('#prenom_edit_cancel','click',function(){
    var val_initiale = $('#value_prenom_hidden').val(); //alert('Valeur à remettre = ' + val_initiale);
    
    $('#profil_prenom2').replaceWith('<span id="profil_prenom">' + val_initiale + '</span>');
});

$(document).delegate('#prenom_edit','click',function(e){
    e.preventDefault();
    var value_prenom = $('#value_prenom').val(); //alert('Valeur à enregistrer = ' + value_pseudo);
    
    //AJAX POUR MODIF VALEUR
    $.post('profil_edit.php','champ=prenom&value_prenom=' + value_prenom,function(data){
        //modif champ
        $('#profil_prenom2').replaceWith('<span id="profil_prenom">' + value_prenom + '</span>');
        
        //toast
        setTimeout(function () {
            toastr.options = {closeButton: true,progressBar: true,showMethod: 'fadeIn',timeOut: 2000};
            toastr.success('Modification du prénom effectuée.');
        }, 1300);
    },'text');
});

/* Profil => UPDATE EMAIL */
$(document).delegate('#profil_email','click',function(){
    var val = $('#profil_email').text(); //alert('Valeur initiale = ' + val);
    
    $(this).replaceWith('<span id="profil_email2"><form>' + 
    '<input id="value_email" type="text" value="' + val + '">' + 
    '<input id="value_email_hidden" type="hidden" value="' + val + '">' + 
    '<button id="email_edit_cancel" type="reset" class="btn btn-primary btn-sm">Annuler</button>' +
    '<button id="email_edit" type="submit" class="btn btn-primary btn-sm">Modifier</button></form></span>');
});

$(document).delegate('#email_edit_cancel','click',function(){
    var val_initiale = $('#value_email_hidden').val(); //alert('Valeur à remettre = ' + val_initiale);
    
    $('#profil_email2').replaceWith('<span id="profil_email">' + val_initiale + '</span>');
});

$(document).delegate('#email_edit','click',function(e){
    e.preventDefault();
    var value_prenom = $('#value_email').val(); //alert('Valeur à enregistrer = ' + value_pseudo);
    
    //AJAX POUR MODIF VALEUR
    $.post('profil_edit.php','champ=email&value_email=' + value_email,function(data){
        //modif champ
        $('#profil_email2').replaceWith('<span id="profil_email">' + value_email + '</span>');
        
        //toast
        setTimeout(function () {
            toastr.options = {closeButton: true,progressBar: true,showMethod: 'fadeIn',timeOut: 2000};
            toastr.success('Modification de l\'email effectuée.');
        }, 1300);
    },'text');
});

/* Profil => UPDATE TELEPHONE */
$(document).delegate('#profil_telephone','click',function(){
    var val = $('#profil_telephone').text(); //alert('Valeur initiale = ' + val);
    
    $(this).replaceWith('<span id="profil_telephone2"><form>' + 
    '<input id="value_telephone" type="text" value="' + val + '">' + 
    '<input id="value_telephone_hidden" type="hidden" value="' + val + '">' + 
    '<button id="telephone_edit_cancel" type="reset" class="btn btn-primary btn-sm">Annuler</button>' +
    '<button id="telephone_edit" type="submit" class="btn btn-primary btn-sm">Modifier</button></form></span>');
});

$(document).delegate('#telephone_edit_cancel','click',function(){
    var val_initiale = $('#value_telephone_hidden').val(); //alert('Valeur à remettre = ' + val_initiale);
    
    $('#profil_telephone2').replaceWith('<span id="profil_telephone">' + val_initiale + '</span>');
});

$(document).delegate('#telephone_edit','click',function(e){
    e.preventDefault();
    var value_telephone = $('#value_telephone').val(); //alert('Valeur à enregistrer = ' + value_pseudo);
    
    //AJAX POUR MODIF VALEUR
    $.post('profil_edit.php','champ=telephone&value_telephone=' + value_telephone,function(data){
        //modif champ
        $('#profil_telephone2').replaceWith('<span id="profil_telephone">' + value_telephone + '</span>');
        
        //toast
        setTimeout(function () {
            toastr.options = {closeButton: true,progressBar: true,showMethod: 'fadeIn',timeOut: 2000};
            toastr.success('Modification du téléphone effectuée.');
        }, 1300);
    },'text');
});

/* Profil => UPDATE CIVILITE */
$(document).delegate('#profil_civilite','click',function(){
    var val = $('#profil_civilite').text(); //alert('Valeur initiale = ' + val);
    
    $(this).replaceWith('<span id="profil_civilite2"><form>' + 
    '<input id="value_civilite" type="text" value="' + val + '">' + 
    '<input id="value_civilite_hidden" type="hidden" value="' + val + '">' + 
    '<button id="civilite_edit_cancel" type="reset" class="btn btn-primary btn-sm">Annuler</button>' +
    '<button id="civilite_edit" type="submit" class="btn btn-primary btn-sm">Modifier</button></form></span>');
});

$(document).delegate('#civilite_edit_cancel','click',function(){
    var val_initiale = $('#value_civilite_hidden').val(); //alert('Valeur à remettre = ' + val_initiale);
    
    $('#profil_civilite2').replaceWith('<span id="profil_civilite">' + val_initiale + '</span>');
});

$(document).delegate('#civilite_edit','click',function(e){
    e.preventDefault();
    var value_civilite = $('#value_civilite').val(); //alert('Valeur à enregistrer = ' + value_pseudo);
    
    //AJAX POUR MODIF VALEUR
    $.post('profil_edit.php','champ=civilite&value_civilite=' + value_civilite,function(data){
        //modif champ
        $('#profil_civilite2').replaceWith('<span id="profil_civilite">' + value_civilite + '</span>');
        
        //toast
        setTimeout(function () {
            toastr.options = {closeButton: true,progressBar: true,showMethod: 'fadeIn',timeOut: 2000};
            toastr.success('Modification de la civilité effectuée.');
        }, 1300);
    },'text');
});





/*********************************************************/
//FOOTER
/*********************************************************/
/* Vers MENTIONS LEGALES */
$('#footer_mentions_legales').on('click',function(e){
    e.preventDefault();
    chargtContenuPHP(this,'php/front/mentions_legales.php','#contenu_ppal');
});
/* Vers CGV */
$('#footer_cgv').on('click',function(e){
    e.preventDefault();
    chargtContenuPHP(this,'php/front/cgv.php','#contenu_ppal');
});


/** NAVIGATION SECONDAIRE ***/
/************************** */

/* Vers PUBLIER ANNONCE via btn*/
$('#index_btn_publier').on('click',function(e){
    e.preventDefault();
    chargtContenuPHP(this,'php/front/publier_annonce.php','#contenu_ppal');
});




























}); // fin ready