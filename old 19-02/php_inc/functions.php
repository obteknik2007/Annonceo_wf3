<?php
//Fonction de contrôle de connexion (profil connecté)
function estConnecte(){
    if (!empty($_SESSION['membre'])){
        return true;
    } else {
        return false;
    }
}

//Fonction de contrôle de connexion (profil connecté et administrateur)
function estConnecteEtAdmin(){
    if(estConnecte() && $_SESSION['membre']['statut'] == 1){
        return true;
    } else {
        return false;
    }
}

//Fonction sécurité post
function secure_field($field){
    return trim(htmlspecialchars($field));
}


function format_dateHeure($dateHeure){
    $dateHeure = date_create($dateHeure);
    $dateHeureFormatee = date_format($dateHeure,'d/m/Y H:i:s');

    return $dateHeureFormatee;
}

function format_date($date){
    $date = date_create($date);
    $dateFormatee = date_format($date,'d/m/Y');

    return $dateFormatee;
}

function format_décimal($nb,$nbDec){
    return number_format($nb,$nbDec, ',', ' ');
}
?>