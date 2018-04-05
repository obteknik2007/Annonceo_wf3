<?php
require_once('php_inc/init.php');

//traitement connexion
//Déconnexion
if(isset($_GET['action']) && $_GET['action'] == 'deconnexion'){
    //session_destroy();
    unset($_SESSION['membre']);
}

//TEST utilisateur connecté
if(estConnecte()){
    header('location:index.php'); 
    exit; 
}

//Traitement soumission du formulaire
if($_POST){ 

    //cryptage du mot de passe saisi pour le comparer au mdp en bdd
    $motdepassecrypte = md5($_POST['mdp']); 

    // à partir du pseudo et du mdp saisi, je recherche le membre en bdd
    $req_connexion = $pdo->prepare("SELECT * FROM membre WHERE pseudo = :pseudo AND mdp= :mdp");
    $req_connexion->execute(array('pseudo' => $_POST['pseudo'],'mdp' => $motdepassecrypte));
    
    //si j'ai un résultat, mise en session des infos du membre
    if($req_connexion->rowCount() > 0){ 
        $membre = $req_connexion->fetch(PDO::FETCH_ASSOC);
        $_SESSION['membre'] = $membre;

        //si connexion ok,=>Mon compte
        header('location:index.php');
        exit();
    } else {
        $contenu .='<div class="bg-danger">Erreur sur les identifiants</div>';
    }
}

//header
require_once('php_inc/header.php');
?>
<!-- Formulaire de connexion -->
<h2 class="page-header">Se connecter</h2>
<div class="box-content">
    <form method="post" action="" class="form-horizontal">
        <!-- pseudo -->
        <div class="form-group">
            <label for="pseudo" class="col-sm-2 control-label">Votre pseudo</label>
            <div class="col-sm-3">
                <input type="pseudo" class="form-control" id="pseudo" name="pseudo" placeholder="Votre pseudo...">
            </div>
        </div>

        <!-- mot de passe -->
        <div class="form-group">
            <label for="mdp" class="col-sm-2 control-label">Votre mot de passe</label>
            <div class="col-sm-3">
                <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Votre mot de passe...">
            </div>
        </div>

        <!-- remember me -->
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label><input type="checkbox"> Se souvenir de moi</label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-primary">Se connecter</button>
            </div>
        </div>
    </form>
</div> <!-- fin box-content -->

<?php
//affichage contenu
echo $contenu;

//footer
require_once('php_inc/footer.php');
?>