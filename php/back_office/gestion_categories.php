<?php

require_once('../../php_inc/init.php');
require_once('../../php_inc/header.php');

$contenu='';
$ajout = false;
$update = false;

/* Ajout d'une categorie */
if ( isset($_POST['insert'] ) && !empty($_POST['titre']) && !empty($_POST['motscles']))
{

    $insert=$pdo->prepare("INSERT INTO categorie VALUES(NULL,:titre,:motscles)");
    $insert->execute(array( 'titre'        => $_POST['titre'],
                            'motscles'     => $_POST['motscles'],));
                         
    $contenu .='<div class="alert alert-success">La categorie "'.$_POST['titre'].'" à été ajoutée </div>';

    $ajout = true;
}

/* suppression  d'une categorie*/
if( isset($_GET['action']) && $_GET['action'] == 'suppression' && !empty($_GET['id_categorie']))
{ 
    
    $pdo->query("DELETE FROM categorie WHERE id_categorie = ".$_GET['id_categorie']);
    $contenu .='<div class="alert alert-success">La categorie "'.$_GET['id_categorie'].'" a été supprimé</div>';
    
}

/*  modification d'une categorie */
if( isset($_GET['action']) && $_GET['action'] == 'modification' && !empty($_GET['id_categorie'])) 
{      
    if (isset($_POST['update']) && !empty($_POST['titre']) && !empty($_POST['motscles']))
    {
                
        $maj = $pdo->prepare("UPDATE categorie SET 
        titre=:titre,motscles=:motscles WHERE id_categorie=:id_categorie");
        $maj->execute(array('titre'                =>$_POST['titre'],
                            'motscles'             =>$_POST['motscles'],
                            'id_categorie'         =>$_GET['id_categorie']
                                ));
        $contenu .='<div class="alert alert-success">La categorie "'.$_POST['titre'].'" a été modifié</div>';

        $update = true;
    }
    
}

/* affichage des catégories */
$resul = $pdo->query("SELECT * FROM categorie");

$contenu .="<h2 class='page-header' > Liste des categories</h2>";
$contenu .="<p>Nombre de categorie(s) : ".$resul->rowCount()."</p>";
$contenu .="<table class='table-striped table-categorie'>
            <tr>";

/* les en tetes */
$contenu .='<th class="th_categorie">Id Categorie</th>';
$contenu .='<th class="th_titre">Titre</th>';
$contenu .='<th class="th_motscles">Mots Clés</th>';
$contenu .='<th class="th_actions">Actions</th>';

$contenu .="</tr>";

/* les donnees */
while($ligne = $resul->fetch(PDO::FETCH_ASSOC))
{
$contenu .='<tr>';
$contenu .='<td>'.$ligne['id_categorie'].'</td>';
$contenu .='<td>'.$ligne['titre'].'</td>';
$contenu .='<td>'.$ligne['motscles'].'</td>';
$contenu .='<td><a href="?action=modification&id_categorie='.$ligne['id_categorie'].'"><span class="glyphicon modif glyphicon-pencil" aria-hidden="true"></span></a>
            <a href="?action=suppression&id_categorie='.$ligne['id_categorie'].'"onclick=
            "return(confirm(\'Etes vous certain de vouloir supprimer cette categorie :'.$ligne['titre'].'?\'))"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></td>';     
$contenu .='</tr>';
}
$contenu .='<table>';

$contenu .='<h3 class="link_categorie alert alert-success"><a href="?action=ajout&id_categorie=">Ajouter une catégorie </a><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></h3><br>';

/* verification des champs */
if( isset($_POST['update']) && empty($_POST['titre']) )
{
    $contenu .='<div class="alert alert-danger"> Veuillez entrer un titre de categorie </div>';
}

if( isset($_POST['update']) && empty($_POST['motscles']) )
{
    $contenu .='<div class="alert alert-danger"> Veuillez entrer une description </div>';
}

/* verification des champs */
if( isset($_POST['insert']) && empty($_POST['titre']) )
{
    $contenu .='<div class="alert alert-danger"> Veuillez entrer un titre de categorie </div>';
}
if( isset($_POST['insert']) && empty($_POST['motscles']) )
{
    $contenu .='<div class="alert alert-danger"> Veuillez entrer une description </div>';
}

 /* affichage des donnes pour modification */
   echo $contenu;

   if ( (isset($_GET['action']) && ($_GET['action']=='modification')))
   :
   if ( !empty( $_GET['id_categorie']) )
   {
        $resul = $pdo->prepare("SELECT * FROM categorie WHERE id_categorie=:id_categorie");
        $resul->execute(array('id_categorie' =>$_GET['id_categorie']));
        $annonce_actuelle=$resul->fetch(PDO::FETCH_ASSOC);
   } 
?>

<?php if(!$update) { ?>
    <div id="content_form_update">
<!-- Formulaire de modification de categorie -->
<h2 class="page-header text_modif_categorie">Modifier une Categorie</h2>
<div class="container-center">
    <div class="box-content">
        <form novalidate method="post" class="form-horizontal" action="" enctype="multipart/form-data">
            <div class="row">
                <!-- DEBUT BLOC GAUCHE -->
                <div class="col-md-6">
                    <!-- Titre -->
                    <div class="form-group">
                        <label for="titre" class="col-sm-3 control-label">Nom :</label>
                        <div class="col-sm-9">
                            <input type="titre" class="form-control" id="titre" name="titre" placeholder="Nom de la categorie..." value="<?=$annonce_actuelle['titre'] ?? '' ?>" required autofocus>
                        </div>
                    </div>
                    <!-- Description courte -->
                    <div class="form-group">
                        <label for="description_courte" class="col-sm-3 control-label">Description courte :</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="motscles" id="motscles" rows="3" placeholder="Mots Clés......"><?=$annonce_actuelle['motscles'] ?? '' ?></textarea>
                        </div>
                    </div>
                </div> <!-- FIN BLOC GAUCHE -->
            </div> <!-- fin row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-md-12 ">
                            <input type="submit" value="Modifier la categorie" name="update" id="update" class="btn btn-primary pull-right">  
                            <button class="btn btn-primary pull-right cancel_form_update" id="">Annuler</button>
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
endif;/* fin de la modification */

/* affichage du formulaire pour ajout de categorie */
if ( (isset($_GET['action']) && ($_GET['action']=='ajout')))
:
?>

<?php if(!$ajout) { ?>
<div id="content_form_add">
<h2 class="page-header text_ajout_categorie">Ajouter une Categorie</h2>
<div class="container-center">
    <div class="box-content">
        <form novalidate method="post" class="form-horizontal" action="" enctype="multipart/form-data">
            <div class="row">
                <!-- DEBUT BLOC GAUCHE -->
                <div class="col-md-6">
                    <!-- Titre -->
                    <div class="form-group">
                        <label for="titre" class="col-sm-3 control-label">Nom  :</label>
                        <div class="col-sm-9">
                            <input type="titre" class="form-control" id="titre" name="titre" placeholder="Nom de la categorie..." value="<?=$_POST['titre'] ?? '' ?>" required autofocus>
                        </div>
                    </div>
                    <!-- Description courte -->
                    <div class="form-group">
                        <label for="description_courte" class="col-sm-3 control-label">Description courte :</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="motscles" id="motscles" rows="3" placeholder="Mots Clés......"><?=$_POST['motscles'] ?? '' ?></textarea>
                        </div>
                    </div>
                </div> <!-- FIN BLOC GAUCHE -->
            </div> <!-- fin row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-md-12 ">
                            <input type="submit" value="Ajouter une categorie" name="insert" id="insert" class="btn btn-primary pull-right">
                            <button class="btn btn-primary pull-right cancel_form_add" id="">Annuler</button>
                        </div>
                    </div>
                </div>
            </div> <!-- fin row -->
        </form>
    </div> <!-- FIN BOX-CONTENT-->
</div> <!-- FIN CONTAINER CENTER -->
</div> <!-- FIN BLOC AJOUT -->
<?php } ?>
<?php
endif;/* fin de l'ajout */
require_once('../../php_inc/footer.php');






