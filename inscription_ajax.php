<?php
require_once('php_inc/init.php');

$tab_erreurs = array();

//sécurité
$pseudo     =  secure_field($_POST['pseudo_inscription']);
$mdp        =  secure_field($_POST['mdp_inscription']);
$civilite   =  secure_field($_POST['civilite']);
$prenom     =  secure_field($_POST['prenom']);
$nom        =  secure_field($_POST['nom']);
$telephone  =  secure_field($_POST['telephone']);
$email      =  secure_field($_POST['email']);

//CONTROLE CHAMPS VIDES
$champs_vides = 0;
foreach($_POST as $indice => $valeur){
    if(empty($valeur)){
        $champs_vides++;
    }
}

if($champs_vides > 0){
    $tab_erreurs[] = 'Il y a '.$champs_vides.' information(s) manquante(s).';
}

//CONTROLE DE TAILLES SELON TAILLE BDD
//pseudo 20 caractères
if(strlen($pseudo) > 20){
    $tab_erreurs[] =  'Pas plus de 20 caractères autorisés pour le champs Pseudo';
}
//mdp 60 caractères
if(strlen($mdp) > 20){
    $tab_erreurs[] =  'Pas plus de 60 caractères autorisés pour le champs Mot de passe';
}
    
//prenom 20 caractères
    if(strlen($prenom) > 20){
        $tab_erreurs[] =  'Pas plus de 20 caractères autorisés pour le champs Prénom';
    }    
    
//nom 20 caractères
    if(strlen($nom) > 20){
        $tab_erreurs[] =  'Pas plus de 20 caractères autorisés pour le champs Nom';
    }    
//tel 20 caractères
    if(strlen($telephone) > 20){
        $tab_erreurs[] =  'Pas plus de 20 caractères autorisés pour le champs Téléphone';
    }    

    //email 50 caractères
    if(strlen($email) > 50){
        $tab_erreurs[] =  'Pas plus de 50 caractères autorisés pour le champs Email';
    }        
    
//CONTROLE FORMAT EMAIL
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $tab_erreurs[] =  'Adresse email incorrecte';
    }

//CONTROLE UNICITE PSEUDO 
    $req_pseudo = $pdo->prepare("SELECT pseudo,mdp FROM membre WHERE pseudo = :pseudo");
    $req_pseudo->execute(array('pseudo' => $pseudo));
    $req_pseudo->fetch(PDO::FETCH_ASSOC);

    if($req_pseudo->rowCount() > 0){
        //alors pseudo déjà utilisé
        $tab_erreurs[] =  'Pseudo déjà utlisé, merci d\'en choisir un autre';
    }
    
//CONTROLE UNICITE EMAIL 
    $req_email = $pdo->prepare("SELECT email FROM membre WHERE email = :email");
    $req_email->execute(array('email' => $email));
    $req_email->fetch(PDO::FETCH_ASSOC);

    if($req_email->rowCount() > 0){
        //alors email déjà utilisé
        $tab_erreurs[] =  'Email déjà utlisé, merci d\'en choisir un autre';
    }
    
// --- SI TOUT EST OK/$tab_erreurs VIDE INSERTION BDD + rtr ajax ---
    if(empty($tab_erreurs)){
        //insertion en bdd
        $insert_membre = $pdo->prepare("INSERT INTO membre(pseudo,mdp,civilite,nom,prenom,telephone,email,statut) VALUES(:pseudo,:mdp,:civilite,:nom,:prenom,:telephone,:email,:statut)");
        $insert_membre->execute(array(
            'pseudo'        => $pseudo,
            'mdp'           => md5($mdp),
            'civilite'      => $civilite,
            'nom'           => strtoupper($nom),
            'prenom'        => ucfirst($prenom),
            'telephone'     => $telephone,
            'email'         => $email,
            'statut'        => '0'));
        
        //RETOUR AJAX
        echo json_encode('ok');
        
    } else {

        //J'envoie le tableau des erreurs en JSON
        echo json_encode($tab_erreurs);
    }