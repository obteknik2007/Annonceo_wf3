<?php

require_once('../../php_inc/init.php');
require_once('../../php_inc/header.php');

$contenu='';
$ajout = false;
$update = false;

/* Ajout d'un membre */
if ( isset($_POST['insert'] ) 
    && !empty($_POST['pseudo']) 
    && !empty($_POST['nom'])
    && !empty($_POST['prenom'])
    && !empty($_POST['email'])
    && !empty($_POST['telephone'])
    && !empty($_POST['civilite'])
    && !empty($_POST['statut']))
{

    $insert=$pdo->prepare("INSERT INTO membre VALUES(NULL,:pseudo,:nom,:prenom,:email,:telephone,:civilite,:statut)");
    $insert->execute(array( 'pseudo'    => $_POST['pseudo'],
                            'nom'       => $_POST['nom'],
                            'prenom'    => $_POST['prenom'],
                            'email'     => $_POST['email'],
                            'telephone' => $_POST['telephone'],
                            'civilite'  => $_POST['civilite'],
                            'statut'    => $_POST['statut']));
                         
    $contenu .='<div class="alert alert-success">Le membre "'.$_POST['pseudo'].'" a été ajouté </div>';

    $ajout = true;
}

/* suppression  d'un membre */
if( isset($_GET['action']) && $_GET['action'] == 'suppression' && !empty($_GET['id_membre']))
{ 
    
    $pdo->query("DELETE FROM membre WHERE id_membre = ".$_GET['id_membre']);
    $contenu .='<div class="alert alert-success">Le membre "'.$_GET['id_membre'].'" a été supprimé</div>';
    
}

/*  modification d'un membre */
if( isset($_GET['action']) && $_GET['action'] == 'modification' && !empty($_GET['id_membre'])) 
{      
    if (isset($_POST['update']) 
        && !empty($_POST['pseudo']) 
        && !empty($_POST['nom'])
        && !empty($_POST['prenom'])
        && !empty($_POST['email'])
        && !empty($_POST['telephone'])
        && !empty($_POST['civilite'])
        && !empty($_POST['statut']))

    {
            
        $motdePasseCrypte = md5($_POST['mdp']);

        $maj = $pdo->prepare("UPDATE membre 
        SET pseudo=:pseudo,mdp=:mdp,nom=:nom, prenom=:prenom,email=:email,telephone=:telephone,civilite=:civilite,statut=:statut,id_membre=:id_membre
        WHERE id_membre=:id_membre");
        $maj->execute(array(    'pseudo'        => $_POST['pseudo'],
                                'mdp'           => $motdePasseCrypte,
                                'nom'           => $_POST['nom'],
                                'prenom'        => $_POST['prenom'],
                                'email'         => $_POST['email'],
                                'telephone'     => $_POST['telephone'],
                                'civilite'      => $_POST['civilite'],
                                'statut'        => $_POST['statut'],
                                'id_membre'     => $_GET['id_membre']));

        $contenu .='<div class="alert alert-success">Le membre "'.$_POST['pseudo'].'" a été modifié</div>';

        $update = true;
    }
    
}

/* affichage des membres */
$resul = $pdo->query("SELECT * FROM membre");

$contenu .="<h2 class='page-header' > Liste des membres</h2>";
$contenu .="<p>Nombre de membre(s) : ".$resul->rowCount()."</p>";
$contenu .="<table class='table-striped table-categorie'>
            <tr>";

/* les en tetes */
$contenu .='<th class="th_categorie">Id Membre</th>';
$contenu .='<th class="th_titre">Pseudo</th>';
$contenu .='<th class="th_motscles">Nom</th>';
$contenu .='<th class="th_motscles">Prénom</th>';
$contenu .='<th class="th_motscles">Email</th>';
$contenu .='<th class="th_motscles">Téléphone</th>';
$contenu .='<th class="th_motscles">Civilité</th>';
$contenu .='<th class="th_motscles">Statut</th>';
$contenu .='<th class="th_motscles">Date d\'enregistrement</th>';

$contenu .='<th class="th_actions">Actions</th>';

$contenu .="</tr>";

/* les donnees */
while($ligne = $resul->fetch(PDO::FETCH_ASSOC))
{
$contenu .='<tr>';
$contenu .='<td>'.$ligne['id_membre'].'</td>';
$contenu .='<td>'.$ligne['pseudo'].'</td>';
$contenu .='<td>'.$ligne['nom'].'</td>';
$contenu .='<td>'.$ligne['prenom'].'</td>';
$contenu .='<td>'.$ligne['email'].'</td>';
$contenu .='<td>'.$ligne['telephone'].'</td>';
$contenu .='<td>'.$ligne['civilite'].'</td>';
$contenu .='<td>'.$ligne['statut'].'</td>';
$contenu .='<td>'.format_dateheure($ligne['date_enregistrement']).'</td>';
//actions
$contenu .='<td><a href="?action=modification&id_membre='.$ligne['id_membre'].'"><span class="glyphicon modif glyphicon-pencil" aria-hidden="true"></span></a>
            <a href="?action=suppression&id_membre='.$ligne['id_membre'].'"onclick=
            "return(confirm(\'Etes vous certain de vouloir supprimer ce membre ?\'))"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></td>';     
$contenu .='</tr>';
}
$contenu .='<table>';

$contenu .='<h3 class="link_categorie alert alert-success"><a href="?action=ajout&id_membre=">Ajouter un membre </a><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></h3><br>';

/* verification des champs */
if( isset($_POST['update']) && empty($_POST['pseudo']) )
{
    $contenu .='<div class="alert alert-danger"> Veuillez entrer un pseudo </div>';
}

if( isset($_POST['update']) && empty($_POST['nom']) )
{
    $contenu .='<div class="alert alert-danger"> Veuillez entrer un nom </div>';
}

/* verification des champs */
if( isset($_POST['insert']) && empty($_POST['prenom']) )
{
    $contenu .='<div class="alert alert-danger"> Veuillez entrer un prénom </div>';
}
if( isset($_POST['insert']) && empty($_POST['telephone']) )
{
    $contenu .='<div class="alert alert-danger"> Veuillez entrer un n° de téléphone </div>';
}
if( isset($_POST['insert']) && empty($_POST['email']) )
{
    $contenu .='<div class="alert alert-danger"> Veuillez entrer une adresse mail valide </div>';
}


 /* affichage des donnes pour modification */
   echo $contenu;

   if ( (isset($_GET['action']) && ($_GET['action']=='modification')))
   :
   if ( !empty( $_GET['id_membre']) )
   {
        $resul = $pdo->prepare("SELECT * FROM membre WHERE id_membre=:id_membre");
        $resul->execute(array('id_membre' =>$_GET['id_membre']));
        $membre_actuel=$resul->fetch(PDO::FETCH_ASSOC);
   } 
?>
<?php if(!$update) { ?>
    <div class="content_form_update">
<!-- Formulaire de modification de membre -->
    <h2 class="page-header text_modif_categorie">Modifier un membre</h2>
    <div class="container-center">
        <div class="box-content">
            <form novalidate method="post" class="form-horizontal" action="#">
                <div class="row">
                    <!-- DEBUT BLOC GAUCHE -->
                    <div class="col-md-6">
                        <!-- pseudo -->
                        <div class="form-group">
                            <label for="pseudo" class="col-sm-3 control-label">Pseudo :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="pseudo" name="pseudo" placeholder="Pseudo..." value="<?=$membre_actuel['pseudo'] ?? '' ?>" required autofocus>
                            </div>
                        </div>

                        <!-- mot de passe -->
                        <div class="form-group">
                            <label for="mdp" class="col-sm-3 control-label">Mot de passe :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="mdp" name="mdp" placeholder="Mot de passe..." value="<?=$membre_actuel['mdp'] ?? '' ?>" required>
                            </div>
                        </div>


                        <!-- nom -->
                        <div class="form-group">
                            <label for="nom" class="col-sm-3 control-label">Nom :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom..." value="<?=$membre_actuel['nom'] ?? '' ?>" required >
                            </div>
                        </div>

                        <!-- prénom -->
                        <div class="form-group">
                            <label for="prenom" class="col-sm-3 control-label">Prénom :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prénom..." value="<?=$membre_actuel['prenom'] ?? '' ?>" required >
                            </div>
                        </div>


                    </div> <!-- FIN BLOC GAUCHE -->

                    <!-- DEBUT BLOC DROIT -->
                    <div class="col-md-6">
                        <!-- email -->
                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label">Email :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email..." value="<?=$membre_actuel['email'] ?? '' ?>" required >
                            </div>
                        </div>

                        <!-- telephone -->
                        <div class="form-group">
                            <label for="telephone" class="col-sm-3 control-label">Téléphone :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="telephone" name="telephone" placeholder="Téléphone..." value="<?=$membre_actuel['telephone'] ?? '' ?>" required >
                            </div>
                        </div>

                        <!-- civilite -->
                        <div class="form-group">
                            <label for="civilite" class="col-sm-2 control-label">Civilité :</label>
                            <div class="col-sm-3 pull-left">
                                Monsieur <input type="radio"  id="civilite" name="civilite" value="m" <?=((isset($membre_actuel['civilite']) 
                                && $membre_actuel['civilite'] == 'm')) || !isset($_POST['civilite']) ? 'checked' : ''?>>
                                    Madame <input type="radio"  id="civilite" name="civilite" value="f" <?=((isset($membre_actuel['civilite']) 
                                && $membre_actuel['civilite'] == 'f')) ? 'checked' : ''?>>
                            </div>
                        </div>

                        <!-- statut -->
                        <div class="form-group">
                            <label for="statut" class="col-sm-2 control-label">Statut :</label>
                            <div class="col-sm-3 pull-left">
                                Administrateur <input type="radio"  id="statut" name="statut" value="1" <?=((isset($membre_actuel['statut']) 
                                && $membre_actuel['civilite'] == '1')) || !isset($_POST['statut']) ? 'checked' : ''?>>
                                    Utilisateur <input type="radio"  id="statut" name="statut" value="0" <?=((isset($membre_actuel['statut']) 
                                && $membre_actuel['statut'] == '0')) ? 'checked' : ''?>>
                            </div>
                        </div>
                    </div> <!-- FIN BLOC DROIT -->

                </div> <!-- fin row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-md-12 ">
                                <input type="submit" value="Modifier le membre" name="update" id="update" class="btn btn-primary pull-right">
                                <button class="btn btn-primary pull-right" id="cancel_form_update">Annuler</button>
                            </div>
                        </div>
                    </div>
                </div> <!-- fin row -->
            </form>
        </div> <!-- FIN BOX-CONTENT-->
    </div> <!-- FIN CONTAINER CENTER -->
</div> <!-- FIN BLOC MODIFICATION -->
<?php } ?>

<?php
endif;/* fin de la modification */ ?>


<!-- Formulaire de modification de membre -->
<?php /* affichage du formulaire pour ajout de categorie */
if ( (isset($_GET['action']) && ($_GET['action']=='ajout')))
:
?>
<?php if(!$update) { ?>
<div class="content_form_add">

    <h2 class="page-header text_modif_categorie">Ajouter un membre</h2>
    <div class="container-center">
        <div class="box-content">
            <form novalidate method="post" class="form-horizontal" action="#">
                <div class="row">
                    <!-- DEBUT BLOC GAUCHE -->
                    <div class="col-md-6">
                        <!-- pseudo -->
                        <div class="form-group">
                            <label for="pseudo" class="col-sm-3 control-label">Pseudo :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="pseudo" name="pseudo" placeholder="Pseudo..." value="<?=$_POST['pseudo'] ?? '' ?>" required autofocus>
                            </div>
                        </div>

                        <!-- mot de passe -->
                        <div class="form-group">
                            <label for="mdp" class="col-sm-3 control-label">Mot de passe :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="mdp" name="mdp" placeholder="Mot de passe..." value="<?=$_POST['mdp'] ?? '' ?>" required>
                            </div>
                        </div>


                        <!-- nom -->
                        <div class="form-group">
                            <label for="nom" class="col-sm-3 control-label">Nom :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom..." value="<?=$_POST['nom'] ?? '' ?>" required >
                            </div>
                        </div>

                        <!-- prénom -->
                        <div class="form-group">
                            <label for="prenom" class="col-sm-3 control-label">Prénom :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prénom..." value="<?=$_POST['prenom'] ?? '' ?>" required >
                            </div>
                        </div>


                    </div> <!-- FIN BLOC GAUCHE -->

                    <!-- DEBUT BLOC DROIT -->
                    <div class="col-md-6">
                        <!-- email -->
                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label">Email :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email..." value="<?=$_POST['email'] ?? '' ?>" required >
                            </div>
                        </div>

                        <!-- telephone -->
                        <div class="form-group">
                            <label for="telephone" class="col-sm-3 control-label">Téléphone :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="telephone" name="telephone" placeholder="Téléphone..." value="<?=$_POST['telephone'] ?? '' ?>" required >
                            </div>
                        </div>

                        <!-- civilite -->
                        <div class="form-group">
                            <label for="civilite" class="col-sm-2 control-label">Civilité :</label>
                            <div class="col-sm-3 pull-left">
                                Monsieur <input type="radio"  id="civilite" name="civilite" value="m" 
                                <? ((isset($_POST['civilite']) || !isset($_POST['civilite'])) ? 'checked' : '' ?> >
                                
                                Madame <input type="radio"  id="civilite" name="civilite" value="f" 
                                <? (isset($_POST['civilite']) ? 'checked' : '' ?> >
                            </div>
                        </div>

                        <!-- statut -->
                        <div class="form-group">
                            <label for="statut" class="col-sm-2 control-label">Statut :</label>
                            <div class="col-sm-3 pull-left">
                                Administrateur <input type="radio"  id="statut" name="statut" value="1" <? ((isset($_POST['statut']) 
                                && $_POST['civilite'] == '1')) || !isset($_POST['statut']) ? 'checked' : ''?>>

                                    Utilisateur <input type="radio"  id="statut" name="statut" value="0" <?((isset($_POST['statut']) 
                                && $_POST['statut'] == '0')) ? 'checked' : ''?>>
                            </div>
                        </div>
                    </div> <!-- FIN BLOC DROIT -->

                </div> <!-- fin row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-md-12 ">
                                <input type="submit" value="Ajouter le membre" name="update" id="update" class="btn btn-primary pull-right">
                                <button class="btn btn-primary pull-right" id="cancel_form_add">Annuler</button>
                            </div>
                        </div>
                    </div>
                </div> <!-- fin row -->
            </form>
            </div> <!-- fin container-center-->
        </div> <!-- FIN BOX-CONTENT-->
</div> <!-- FIN BLOC AJOUT-->
<?php } ?>
<?php
endif;/* fin de l'ajout */
require_once('../../php_inc/footer.php');






