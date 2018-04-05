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
                        <li class="active" id="nav_qui_sommesnous"><a href="#">Qui sommes-nous <span class="sr-only">(current)</span></a></li>
                        <li><a href="#" id="nav_contact">Contact</a></li>
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
                <li><a href="#" id="nav_gestion_membres"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Gestion des membres</a></li>
                <li><a href="#" id="nav_gestion_categories"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> Gestion des catégories</a></li>
                <li><a href="#" id="nav_gestion_annonces"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Gestion des annonces</a></li>
                <li><a href="#" id="nav_gestion_commentaires"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Gestion des commentaires</a></li>
                <li><a href="#" id="nav_gestion_notes"><span class="glyphicon glyphicon-star" aria-hidden="true"></span> Gestion des notes</a></li>
                <li><a href="#" id="nav_stats"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span> Statistiques</a></li>
            </ul>
    
    </div>';
    } ?>
    <div id="contenu_ppal" class="container">    