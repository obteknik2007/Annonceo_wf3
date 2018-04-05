<?php
require_once('php_inc/init.php');

//traitement connexion
//Déconnexion
if(isset($_POST['action']) && $_POST['action'] == 'deconnexion'){
    session_destroy();
    unset($_SESSION['membre']);

    //retour ajax
    echo 'ok';
}

//Traitement soumission du formulaire
if(isset($_POST['action']) && $_POST['action'] =='connexion'){ 

    //cryptage du mot de passe saisi pour le comparer au mdp en bdd
    $motdepassecrypte = md5($_POST['mdp_connexion']); 

    // à partir du pseudo et du mdp saisi, je recherche le membre en bdd
    $req_connexion = $pdo->prepare("SELECT * FROM membre WHERE pseudo = :pseudo AND mdp= :mdp");
    $req_connexion->execute(array('pseudo' => $_POST['pseudo_connexion'],'mdp' => $motdepassecrypte));
    
    //si j'ai un résultat, mise en session des infos du membre
    if($req_connexion->rowCount() > 0){ 
        $membre = $req_connexion->fetch(PDO::FETCH_ASSOC);
        $_SESSION['membre'] = $membre;

        //retour ajax
        echo 'ok';
    } else {
        echo 'KO';
    }
}
?>
