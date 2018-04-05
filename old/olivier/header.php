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
    <link rel="stylesheet" href="<?=RACINE_SITE ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?=RACINE_SITE ?>/assets/css/jquery-jvectormap-2.0.3.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <!-- HEADER -->
                <div class="nav-header">
                    <button type="button" class="navbar-toggle collapsed" data="collapse" data-target="#monmenu">
                        <span class="sr-only">Naviguer</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <!--<span class="glyphicon glyphicon-menu-hamburger"></span>-->
                    </button>
                    <a href="<?=RACINE_SITE ?>" class="navbar-brand">Annonceo</a>
                </div>
                <!-- MENU -->
                <div class="collapse navbar-collapse" id="monmenu">
                    <ul class="nav navbar-nav">
                        <?php
                           if(estConnecteEtAdmin()){
                                //entrées de menu propres à l'adm°
                                echo '<li><a href="'.RACINE_SITE.'admin/gestion_membres.php">Gestion des membres</a></li>';
                                echo '<li><a href="'.RACINE_SITE.'admin/gestion_categories.php">Gestion des catégories</a></li>';
                                echo '<li><a href="'.RACINE_SITE.'admin/gestion_annonces.php">Gestion des annonces</a></li>';
                                echo '<li><a href="'.RACINE_SITE.'admin/gestion_commentaires.php">Gestion des commentaires</a></li>';
                                echo '<li><a href="'.RACINE_SITE.'admin/gestion_notes.php">Gestion des notes</a></li>';
                                echo '<li><a href="'.RACINE_SITE.'admin/statistiques.php">Espace statistiques</a></li>';
                            }
                            if(estConnecte()){
                                echo '<li><a href="'.RACINE_SITE.'profil.php">Mon compte</a></li>';
                                echo '<li><a href="'.RACINE_SITE.'connexion.php?action=deconnexion">Se déconnecter</a></li>';
                            } else {
                                echo '<li><a href="'.RACINE_SITE.'php/front/insert_annonce.php">Déposer une annonce</a></li>';
                                echo '<li><a href="'.RACINE_SITE.'inscription.php">S\'inscrire</a></li>';
                                echo '<li><a href="'.RACINE_SITE.'connexion.php">Se connecter</a></li>';
                            }
                         ?>
                    </ul>
                </div>

            </div>
            <?php if(estConnecte()){
                        echo '<span style="color:white;vertical-align:top" class="pull-right">Bonjour '.$_SESSION['membre']['prenom'].' '.$_SESSION['membre']['nom'].'</span>'; 
                    } ?>
        </nav>
    </header>
    <div class="container main">    