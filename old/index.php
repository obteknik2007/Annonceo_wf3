<?php
require_once('php_inc/init.php');

//header
require_once('php_inc/header.php');

//DECONNEXION
/*if(isset($_GET['mode']) && $_GET['mode'] == 'deconnexion'){
    session_destroy();
    unset($_SESSION['membre']);

    header('location:index.php');
    exit();
}*/
//-------------------------//
//SOUMISSION DU FORMULAIRE D'INSCRIPTION
if(isset($_POST['inscription'])){ 

    //sécurité
    $pseudo     =  secure_field($_POST['pseudo']);
    $mdp_inscription  =  secure_field($_POST['mdp_inscription']);
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
    if(strlen($mdp_inscription) > 20){
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
            'mdp'           => md5($mdp_inscription),
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
}

//-------------------------//
//nb d'annnonces en stock
$req = $pdo->query("SELECT COUNT(id_annonce) FROM annonce");
$res = $req->fetch(PDO::FETCH_ASSOC);
$nb_annonces = $res['COUNT(id_annonce)'];
?>


<div class="row" id="section_login">
    <div class="col-md-12 text-right">
        <?php if(estConnecte()){echo '<span id="index_login"><strong>Bonjour '.$_SESSION['membre']['prenom'].' '.$_SESSION['membre']['nom'].'</strong></span>'; }?>
    </div>
</div>

<div class="row">
    <div class="col-md-4"> <!-- BLOC GAUCHE -->
        <div class="box-content" style="width: 100%; height: 571px;">      
            <!-- Texte -->
            <p><span id="index_nb_annonces"><?=$nb_annonces ?> annonces</span> disponibles sur <span id="index_marque">Annonceo</span> !</p>

            <!-- Button 'publier annonce' -->
            <button id="index_btn_publier" class="btn btn-primary btn-md center-block">Publier votre annonce</button>
            <div class="clearfix"></div>

            <!-- encart publicitaire http://via.placeholder.com/250x350?text=encart_publicitaire -->
            <img id="index_encart_pub" src="assets/img/250x350_encart_publicitaire.png" alt="Encart publicitaire" class="img-responsive">

        </div>
    </div>
    <div class="col-md-8"> <!-- BLOC DROIT -->
        <div class="box-content"> 
            <p><span id="index_titre_carte">Choisissez votre département...</span></p>
            <hr><br>
            <div id="map" style="width: 100%; height: 500px;margin: 0 auto;"></div>
        </div>
    </div>
</div> <!-- fin row -->


<!-- MODAL INSCRIPTION -->
<div class="modal fade" id="ModalFormInscription" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title">S'inscrire</h4>
            </div>
            <div class="modal-body">
                <!-- erreurs form-->
                <?=$contenu; ?>

                <!-- FORMULAIRE D'INSCRIPTION -->
                <form novalidate method="post" class="form-horizontal" action="">
                    <!-- pseudo -->
                    <div class="form-group">
                        <label for="pseudo_inscription" class="col-sm-4 control-label">Pseudo :</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="pseudo_inscription" name="pseudo_inscription" placeholder="Votre pseudo..." value="<?=$_POST['pseudo_inscription'] ?? '' ?>" required autocus>
                        </div>
                    </div>

                    <!-- mot de passe -->
                    <div class="form-group">
                        <label for="mdp_inscription" class="col-sm-4 control-label">Mot de passe :</label>
                        <div class="col-sm-5">
                            <input type="password" class="form-control" id="mdp_inscription" name="mdp_inscription" placeholder="Votre mot de passe..." required >
                        </div>
                    </div>

                    <!-- civilité -->
                    <div class="form-group">
                        <label for="civilite" class="col-sm-4 control-label">Civilité :</label>
                        <div class="col-sm-5 pull-left">
                            Monsieur <input type="radio"  name="civilite" value="m" <?=((isset($_POST['civilite']) 
                            && $_POST['civilite'] == 'm')) || !isset($_POST['civilite']) ? 'checked' : ''?>>
                                Madame <input type="radio"  name="civilite" value="f" <?=((isset($_POST['civilite']) 
                            && $_POST['civilite'] == 'f')) ? 'checked' : ''?>>
                        </div>
                    </div>

                    <!-- prénom -->
                    <div class="form-group">
                        <label for="prenom" class="col-sm-4 control-label">Prénom :</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Votre prénom..." value="<?=$_POST['prenom'] ?? '' ?>">
                        </div>
                    </div>

                    <!-- nom -->
                    <div class="form-group">
                        <label for="nom" class="col-sm-4 control-label">Nom :</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="nom" name="nom" placeholder="Votre nom..." value="<?=$_POST['nom'] ?? '' ?>">
                        </div>
                    </div>

                    <!-- email -->
                    <div class="form-group">
                        <label for="email" class="col-sm-4 control-label">Email :</label>
                        <div class="col-sm-5">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Votre email..." value="<?=$_POST['email'] ?? '' ?>">
                        </div>
                    </div>

                    <!-- telephone -->
                    <div class="form-group">
                        <label for="telephone" class="col-sm-4 control-label">Téléphone :</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="telephone" name="telephone" placeholder="Votre n° de telephone..." value="<?=$_POST['telephone'] ?? '' ?>">
                        </div>
                    </div>

            </div> <!-- /.modal-body -->
            <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
            <button type="submit" id="inscription" name="inscription" class="btn btn-primary">S'inscrire</button>
            </form> <!-- FIN FORMULAIRE CONNEXION -->
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- MODAL CONNEXION -->
<div class="modal fade" id="ModalFormConnexion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title">Se connecter</h4>
            </div>
            <div class="modal-body">
                <!-- erreurs form-->
                <?=$contenu; ?>
                <!-- FORMULAIRE DE CONNEXION -->
                <form method="post" action="" class="form-horizontal">
                    <!-- pseudo -->
                    <div class="form-group">
                        <label for="pseudo_connexion" class="col-sm-4 control-label">Votre pseudo</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="pseudo_connexion" name="pseudo_connexion" placeholder="Votre pseudo...">
                        </div>
                    </div>

                    <!-- mot de passe -->
                    <div class="form-group">
                        <label for="mdp_connexion" class="col-sm-4 control-label">Votre mot de passe</label>
                        <div class="col-sm-5">
                            <input type="password" class="form-control" id="mdp_connexion" name="mdp_connexion" placeholder="Votre mot de passe...">
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
            </div> <!-- /.modal-body -->

            <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
            <button type="submit" id="connexion" name="connexion" class="btn btn-primary">Se connecter</button>
            </form> <!-- FIN FORMULAIRE CONNEXION -->
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php 
//footer
require_once('php_inc/footer.php');
?>