<?php

require_once('../../php_inc/init.php');
require_once('../../php_inc/header.php');

$contenu='';
$update = false;

/* suppression  d'un commentaire*/
if( isset($_GET['action']) && $_GET['action'] == 'suppression' && !empty($_GET['id_commentaire']))
{ 
    
    $pdo->query("DELETE FROM commentaire WHERE id_commentaire = ".$_GET['id_commentaire']);
    $contenu .='<div class="alert alert-success">Le commentaire "" a été supprimé</div>';
    
}

/*  modification d'un commentaire */
if( isset($_GET['action']) && $_GET['action'] == 'modification' && !empty($_GET['id_commentaire'])) 
{      
    if (isset($_POST['update']) && !empty($_POST['commentaire']))
    {
                
        $maj = $pdo->prepare("UPDATE commentaire SET 
        membre_id=:membre_id,annonce_id=:annonce_id,commentaire=:commentaire,date_enregistrement=:date_enregistrement WHERE id_commentaire=:id_commentaire");
        $maj->execute(array('membre_id'            =>$_POST['membre_id'],
                            'annonce_id'           =>$_POST['annonce_id'],
                            'commentaire'          =>$_POST['commentaire'],
                            'date_enregistrement'  =>$_POST['date_enregistrement'],
                            'id_commentaire'       =>$_GET['id_commentaire']
                                ));
        $contenu .='<div class="alert alert-success">Le commentaire a été modifié</div>';

        $update = true;
    }
    
}

/* affichage des commentaires */
$resul = $pdo->query("SELECT * FROM commentaire COM
    INNER JOIN membre MEM ON MEM.id_membre = COM.membre_id
    INNER JOIN annonce ANN ON ANN.id_annonce = COM.annonce_id");

$contenu .="<h2 class='page-header' > Liste des commentaires</h2>";
$contenu .="<p>Nombre de commentaire(s) : ".$resul->rowCount()."</p>";
$contenu .="<table class='table-striped table-categorie'>
            <tr>";

/* les en tetes */
$contenu .='<th class="th_categorie">Id Commentaire</th>';
$contenu .='<th class="th_membre">Id membre</th>';
$contenu .='<th class="th_categorie">Id Annonce</th>';
$contenu .='<th class="th_commentaire">Commentaire</th>';
$contenu .='<th class="th_categorie">Date d\'enregistrement</th>';
$contenu .='<th class="th_actions">Actions</th>';

$contenu .="</tr>";

/* les donnees */
while($ligne = $resul->fetch(PDO::FETCH_ASSOC))
{
$contenu .='<tr>';
$contenu .='<td>'.$ligne['id_commentaire'].'</td>';
$contenu .='<td>'.$ligne['membre_id'].' - '.$ligne['email'].'</td>';
$contenu .='<td>'.$ligne['annonce_id'].' - '.$ligne['titre'].'</td>';
$contenu .='<td>'.$ligne['commentaire'].'</td>';
$contenu .='<td>'.format_dateheure($ligne['date_enregistrement']).'</td>';
$contenu .='<td><a href="?action=modification&id_commentaire='.$ligne['id_commentaire'].'"><span class="glyphicon modif glyphicon-pencil" aria-hidden="true"></span></a>
            <a href="?action=suppression&id_commentaire='.$ligne['id_commentaire'].'"onclick=
            "return(confirm(\'Etes vous certain de vouloir supprimer ce commentaire ?\'))"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></td>';     
$contenu .='</tr>';
}
$contenu .='<table>';

/* verification des champs  */
if( isset($_POST['update']) && empty($_POST['commentaire']) )
{
    $contenu .='<div class="alert alert-danger"> Veuillez entrer un commentaire </div>';
}

 /* affichage des donnes pour modification */
   echo $contenu;

   if ( (isset($_GET['action']) && ($_GET['action']=='modification')))
   :
   if ( !empty( $_GET['id_commentaire']) )
   {
        $resul = $pdo->prepare("SELECT * FROM commentaire WHERE id_commentaire=:id_commentaire");
        $resul->execute(array('id_commentaire' =>$_GET['id_commentaire']));
        $com_actuel=$resul->fetch(PDO::FETCH_ASSOC);
   } 
?>

<?php if(!$update) { ?>
    <div id="content_form_update">
<!-- Formulaire de modification de commentaire -->
<h2 class="page-header ">Modifier un commentaire</h2>
<div class="container-center">
    <div class="box-content">
        <form novalidate method="post" class="form-horizontal" action="" enctype="multipart/form-data">
            <div class="row">
                <!-- DEBUT BLOC  -->
                <div class="col-md-6">
                    <input type="hidden" class="form-control" id="commentaire" name="commentaire"  value="<?=$com_actuel['id_commentaire'] ?? '' ?>"  >    
                    <input type="hidden" class="form-control" id="membre_id" name="membre_id"  value="<?=$com_actuel['membre_id'] ?? '' ?>"  >
                    <input type="hidden" class="form-control" id="annonce_id" name="annonce_id"  value="<?=$com_actuel['annonce_id'] ?? '' ?>"  >
                    <input type="hidden" class="form-control" id="date_enregistrement" name="date_enregistrement" placeholder="date_enregistrement" value="<?=$com_actuel['date_enregistrement'] ?? '' ?>"  >
                    <div class="form-group">
                        <label for="commentaire" class="col-sm-3 control-label">commentaire :</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="commentaire" id="commentaire" rows="6" placeholder="Inscrivez votre commentaire..." autofocus><?=$com_actuel['commentaire'] ?? '' ?></textarea>
                        </div>
                    </div>
                </div> <!-- FIN BLOC  -->
            </div> <!-- fin row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-md-12 ">
                            <input type="submit" value="Modifier le commentaire" name="update" id="update" class="btn btn-primary pull-right"> 
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

require_once('../../php_inc/footer.php');






