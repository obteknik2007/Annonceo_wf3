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
function secure_field($valeur){
    return htmlspecialchars($valeur);
}
?>