<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Annonceo | Home</title>
    <!-- css -->
    <link rel="stylesheet" href="<?=RACINE_SITE ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=RACINE_SITE ?>/assets/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="<?=RACINE_SITE ?>/assets/css/animate.min.css">
    <link rel="stylesheet" href="<?=RACINE_SITE ?>/assets/css/toastr.min.css">
    <link rel="stylesheet" href="<?=RACINE_SITE ?>/assets/css/pace_theme_1.css">

    <link rel="stylesheet" href="<?=RACINE_SITE ?>/assets/css/jquery-jvectormap-2.0.3.css">

    <link rel="stylesheet" href="<?=RACINE_SITE ?>/assets/css/style.css">
</head>
<body>
    <header>
        <nav id="barre" class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="<?=RACINE_SITE ?>" class="navbar-brand"><span>Annonceo</span></a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                    <ul class="nav navbar-nav">
                        <li class="active" id="nav_qui_sommesnous"><a href="http://localhost/annonceo/php/front/qui_sommesnous.php">Qui sommes-nous <span class="sr-only">(current)</span></a></li>
                        <!--<li><a href="#" id="nav_contact">Contact</a></li>-->
                        <li>
                            <form id="index_form_search" class="navbar-form">
                            <div class="form-group">
                                <input type="text" id="index_search" name="index_search" class="form-control" placeholder="Recherche...">
                            </div>
                            <!--<button type="submit" class="btn btn-default">Submit</button>-->
                            </form>
                        </li>
                    </ul>

                    <!-- NAVBAR RIGHT -->
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> Espace Membre <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <?php
                                if(!estConnecte()){
                                    echo '<li><a href="#ModalFormInscription" data-toggle="modal">S\'inscrire</a></li>';
                                    //echo '<li><a href="inscription.php" data-toggle="modal">S\'inscrire</a></li>';
                                    
                                    echo '<li><a href="#ModalFormConnexion" data-toggle="modal">Se connecter</a></li>';
                                } else {
                                    echo '<li><a href="#" id="nav_profil">Profil</a></li>';
                                    echo '<li><a href="#" id="deconnexion">Se déconnecter</a></li>';
                                }
                            ?>
                        </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container -->
        </nav>
    </header>
    <?php if(estConnecteEtAdmin()){
    echo '<div class="row content-admin" style="background:#a1aeff;color:#FFF">
            <ul id="menu_admin">
                <li><a href="'.RACINE_SITE.'php/back_office/gestion_membres.php"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Gestion des membres</a></li>
                <li><a href="'.RACINE_SITE.'php/back_office/gestion_categories.php" id="nav_gestion_categories"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> Gestion des catégories</a></li>
                <li><a href="'.RACINE_SITE.'php/back_office/gestion_annonces.php" id="nav_gestion_annonces"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Gestion des annonces</a></li>
                <li><a href="'.RACINE_SITE.'php/back_office/gestion_commentaires.php" id="nav_gestion_commentaires"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Gestion des commentaires</a></li>
                <li><a href="'.RACINE_SITE.'php/back_office/gestion_notes.php" id="nav_gestion_notes"><span class="glyphicon glyphicon-star" aria-hidden="true"></span> Gestion des notes</a></li>
                <li><a href="'.RACINE_SITE.'php/back_office/statistiques.php" id="nav_stats"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span> Statistiques</a></li>
            </ul>
    
    </div>';
    } ?>
    <div id="contenu_ppal" class="container">    

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
                <div id="inscription_erreurs"></div>
                <!-- zone erreurs -->
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
                            Monsieur <input type="radio" id="civilite" name="civilite" value="m" <?=((isset($_POST['civilite']) 
                            && $_POST['civilite'] == 'm')) || !isset($_POST['civilite']) ? 'checked' : ''?>>
                                Madame <input type="radio"  id="civilite" name="civilite" value="f" <?=((isset($_POST['civilite']) 
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
            </form> <!-- FIN FORMULAIRE INSCRIPTION -->
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