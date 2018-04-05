<?php
require_once('php_inc/init.php');

$inscription = false;

$tab_erreurs = array();

//soumission du fournisseur
if($_POST){

    //sécurité
    $pseudo     =  secure_field($_POST['pseudo']);
    $mdp        =  secure_field($_POST['mdp']);
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
    
    //SI TOUT EST OK/pas d'erreurs dans $contenu
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
        
        //message info utilisateur
        $contenu .= '<div class="alert alert-success">Vous êtes inscrit à notre site. <a href="connexion.php">Cliquer ici pour vous connecter</a></div>';

        $inscription = true;
    } else {
        //affichage des erreurs
        echo '<div class="alert alert-danger">';
        echo '<ul>';
        //parcours du tableau des erreurs
            for($i=0;$i<count($tab_erreurs);$i++){
                echo '<li>'.$tab_erreurs[$i].'</li>';
            }
        echo '</ul>';
        echo '</div>';
    }

} //fin post

echo $contenu;

//affichage du formulaire que si inscription
if(!$inscription){
?>
    <!-- FORMULAIRE D'INSCRIPTION -->
    <h2 class="page-header">S'inscrire</h2>
    <div class="box-content">
        <form novalidate method="post" class="form-horizontal" action="">

            <!-- pseudo -->
            <div class="form-group">
                <label for="pseudo" class="col-sm-2 control-label">Pseudo :</label>
                <div class="col-sm-3">
                    <input type="pseudo" class="form-control" id="pseudo" name="pseudo" placeholder="Votre pseudo..." value="<?=$_POST['pseudo'] ?? '' ?>" required autocus>
                </div>
            </div>

            <!-- mot de passe -->
            <div class="form-group">
                <label for="mdp" class="col-sm-2 control-label">Mot de passe :</label>
                <div class="col-sm-3">
                    <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Votre mot de passe..." required >
                </div>
            </div>

            <!-- civilité -->
            <div class="form-group">
                <label for="civilite" class="col-sm-2 control-label">Civilité :</label>
                <div class="col-sm-3 pull-left">
                    Monsieur <input type="radio"  id="civilite" name="civilite" value="m" <?=((isset($_POST['civilite']) 
                    && $_POST['civilite'] == 'm')) || !isset($_POST['civilite']) ? 'checked' : ''?>>
                        Madame <input type="radio"  id="civilite" name="civilite" value="f" <?=((isset($_POST['civilite']) 
                    && $_POST['civilite'] == 'f')) ? 'checked' : ''?>>
                </div>
            </div>

            <!-- prénom -->
            <div class="form-group">
                <label for="prenom" class="col-sm-2 control-label">Prénom :</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Votre prénom..." value="<?=$_POST['prenom'] ?? '' ?>">
                </div>
            </div>

            <!-- nom -->
            <div class="form-group">
                <label for="nom" class="col-sm-2 control-label">Nom :</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" id="nom" name="nom" placeholder="Votre nom..." value="<?=$_POST['nom'] ?? '' ?>">
                </div>
            </div>

            <!-- email -->
            <div class="form-group">
                <label for="email" class="col-sm-2 control-label">Email :</label>
                <div class="col-sm-3">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Votre email..." value="<?=$_POST['email'] ?? '' ?>">
                </div>
            </div>

            <!-- telephone -->
            <div class="form-group">
                <label for="telephone" class="col-sm-2 control-label">Téléphone :</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" id="telephone" name="telephone" placeholder="Votre n° de telephone..." value="<?=$_POST['telephone'] ?? '' ?>">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-3">
                <button type="submit" class="btn btn-primary">S'inscrire</button>
                </div>
            </div>
        </form>
    </div> <!-- fin box-content -->
<?php } ?>