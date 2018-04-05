<?php

require_once('../../php_inc/init.php');
require_once('../../php_inc/header.php');

$contenu='';
$update = false;

/* suppression  d'une note*/
if( isset($_GET['action']) && $_GET['action'] == 'suppression' && !empty($_GET['id_note']))
{ 
    
    $pdo->query("DELETE FROM note WHERE id_note = ".$_GET['id_note']);
    $contenu .='<div class="alert alert-success">La note "" a été supprimée</div>';
    
}

/*  modification d'un note */
if( isset($_GET['action']) && $_GET['action'] == 'modification'  && !empty($_GET['id_note']) ) 
{      
    if (isset($_POST['update']) && !empty($_POST['note']) &&!empty($_POST['avis']))
    {
                
        $maj = $pdo->prepare("UPDATE note SET 
        membre_id1=:membre_id1,membre_id2=:membre_id2,note=:note,avis=:avis,date_enregistrement=:date_enregistrement WHERE id_note=:id_note");
        $maj->execute(array('membre_id1'            =>$_POST['membre_id1'],
                            'membre_id2'           =>$_POST['membre_id2'],
                            'note'                  =>$_POST['note'],
                            'avis'                  =>$_POST['avis'],
                            'date_enregistrement'   =>$_POST['date_enregistrement'],
                            'id_note'               =>$_GET['id_note']
                                ));
        $contenu .='<div class="alert alert-success">La note a été modifiée</div>';

        $update = true;
    }
    
}

/* affichage des notes */
$resul = $pdo->query("SELECT 
    NT.id_note AS NT_ID_NOTE,
    NT.membre_id1 AS NT_MEMBRE_ID1,
    MEM.email  AS MEM_EMAIL_ID1,
    NT.membre_id2  AS NT_MEMBRE_ID2,
    MEM2.email AS MEM_EMAIL_ID2,
    NT.note AS NT_NOTE,
    NT.avis AS NT_AVIS,
    NT.date_enregistrement AS NT_DE
    FROM note NT
    INNER JOIN membre MEM ON MEM.id_membre = NT.membre_id1
    INNER JOIN membre MEM2 ON MEM2.id_membre = NT.membre_id2");

$contenu .="<h2 class='page-header' > Liste des notes</h2>";
 $contenu .="<p>Nombre de note(s) : ".$resul->rowCount()."</p>"; 
$contenu .="<table class='table-striped table-categorie'>
            <tr>";

/* les en tetes */
$contenu .='<th class="th_categorie">Id note</th>';
$contenu .='<th class="th_membre">Id membre1</th>';
$contenu .='<th class="th_membre">Id membre2</th>';
$contenu .='<th class="th_categorie">note</th>';
$contenu .='<th class="th_commentaire">avis</th>';
$contenu .='<th class="th_categorie">Date d\'enregistrement</th>';
$contenu .='<th class="th_actions">Actions</th>';

$contenu .="</tr>";

/*
                    echo '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
                    echo '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
                    echo '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
                    echo '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
                    echo '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
                    */
/* les donnees */
while($ligne = $resul->fetch(PDO::FETCH_ASSOC))
{
$contenu .='<tr>';
$contenu .='<td>'.$ligne['NT_ID_NOTE'].'</td>';
$contenu .='<td>'.$ligne['NT_MEMBRE_ID1'].' - '.$ligne['MEM_EMAIL_ID1'].'</td>';
$contenu .='<td>'.$ligne['NT_MEMBRE_ID2'].' - '.$ligne['MEM_EMAIL_ID2'].'</td>';

$note_etoiles='';
switch($ligne['NT_NOTE']){
    case 1 :
        $note_etoiles .= '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
        $note_etoiles .= '<span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>';
        $note_etoiles .= '<span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>';
        $note_etoiles .= '<span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>';
        $note_etoiles .= '<span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>';
        break;
    case 2 :
        $note_etoiles .= '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
        $note_etoiles .= '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
        $note_etoiles .= '<span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>';
        $note_etoiles .= '<span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>';
        $note_etoiles .= '<span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>';
        break;
    case 3 :
        $note_etoiles .= '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
        $note_etoiles .= '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
        $note_etoiles .= '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
        $note_etoiles .= '<span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>';
        $note_etoiles .= '<span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>';
        break;
    case 4 :
        $note_etoiles .= '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
        $note_etoiles .= '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
        $note_etoiles .= '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
        $note_etoiles .= '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
        $note_etoiles .= '<span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>';
        break;
    case 5 :
        $note_etoiles .= '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
        $note_etoiles .= '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
        $note_etoiles .= '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
        $note_etoiles .= '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
        $note_etoiles .= '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
        break;
}

//$contenu .='<td>'.$ligne['NT_NOTE'].'</td>';
$contenu .='<td>'.$note_etoiles.'</td>';



$contenu .='<td>'.$ligne['NT_AVIS'].'</td>';
$contenu .='<td>'.format_dateheure($ligne['NT_DE']).'</td>';
$contenu .='<td><a href="?action=modification&id_note='.$ligne['NT_ID_NOTE'].'"><span class="glyphicon modif glyphicon-pencil" aria-hidden="true"></span></a>
            <a href="?action=suppression&id_note='.$ligne['NT_ID_NOTE'].'"onclick=
            "return(confirm(\'Etes vous certain de vouloir supprimer cette note ?\'))"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></td>';     
$contenu .='</tr>';
}
$contenu .='<table>';

/* verification des champs  */
 if( isset($_POST['update']) && empty($_POST['note']) )
{
    $contenu .='<div class="alert alert-danger"> Veuillez entrer une note </div>';
}

if( isset($_POST['update']) && empty($_POST['avis']) )
{
    $contenu .='<div class="alert alert-danger"> Veuillez entrer un avis </div>';
} 

 /* affichage des donnes pour modification */
   echo $contenu;

   if ( (isset($_GET['action']) && ($_GET['action']=='modification')))
   :
   if ( !empty( $_GET['id_note']) )
   {
        $resul = $pdo->prepare("SELECT * FROM note WHERE id_note=:id_note");
        $resul->execute(array('id_note' =>$_GET['id_note']));
        $note_actuelle=$resul->fetch(PDO::FETCH_ASSOC);
   } 
?>

<?php if(!$update) { ?>
    <div id="content_form_update">
<!-- Formulaire de modification de commentaire -->
<h2 class="page-header ">Modifier une note ou un avis</h2>
<div class="container-center">
    <div class="box-content">
        <form novalidate method="post" class="form-horizontal" action="" enctype="multipart/form-data">
            <div class="row">
                <!-- DEBUT BLOC  -->
                <div class="col-md-6">
                    <input type="hidden" class="form-control" id="id_note" name="id_note"  value="<?=$note_actuelle['id_note'] ?? '' ?>"  >    
                    <input type="hidden" class="form-control" id="membre_id1" name="membre_id1"  value="<?=$note_actuelle['membre_id1'] ?? '' ?>"  >
                    <input type="hidden" class="form-control" id="membre_id2" name="membre_id2"  value="<?=$note_actuelle['membre_id2'] ?? '' ?>"  >
                    <input type="hidden" class="form-control" id="date_enregistrement" name="date_enregistrement" placeholder="date_enregistrement" value="<?=$note_actuelle['date_enregistrement'] ?? '' ?>"  >
                    <div class="form-group">
                        <label for="note" class="col-sm-3 control-label">Note :</label>
                        <div class="col-sm-9">
                            <input type="titre" class="form-control" id="note" name="note" placeholder="Modifier la note" value="<?=$note_actuelle['note'] ?? '' ?>"  autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="avis" class="col-sm-3 control-label">Avis :</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="avis" id="avis" rows="6" placeholder="Modifier l'avis..." autofocus><?=$note_actuelle['avis'] ?? '' ?></textarea>
                        </div>
                    </div>
                </div> <!-- FIN BLOC  -->
            </div> <!-- fin row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-md-12 ">
                            <input type="submit" value="Modifier" name="update" id="update" class="btn btn-primary pull-right">    
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






