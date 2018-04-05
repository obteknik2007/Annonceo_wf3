<?php

require_once('../../php_inc/init.php');
require_once('../../php_inc/header.php');

$contenu='';
$update = false;

/* suppression  des annonces*/
if( isset($_GET['action']) && $_GET['action'] == 'suppression' && !empty($_GET['id_annonce']))
{ 
    
        $pdo->query("DELETE FROM annonce WHERE id_annonce = ".$_GET['id_annonce']);
        $contenu .='<div class="alert alert-success">L\'annonce\' a été supprimé</div>';
    
}

if ( !empty($_FILES['photo']['name']))
{
    $nom_photo = $_POST['titre'] . '-' . $_FILES['photo']['name'];
    $photo_bdd = RACINE_SITE . 'photos/' .$nom_photo;
    $photo_dossier = $_SERVER['DOCUMENT_ROOT'] . $photo_bdd;
    

    copy($_FILES['photo']['tmp_name'], $photo_dossier);
}

/*  modification d'une annonce */
if( isset($_GET['action']) && $_GET['action'] == 'modification' && !empty($_GET['id_annonce']))
{ 

    if ( $_POST )
    {

        $photo_bdd='';

        if ( isset($_POST['photo_actuelle']) )
        {
            $photo_bdd= $_POST['photo_actuelle'];
        }

        if (isset($_POST['update']))
        {
                
            $maj = $pdo->prepare("UPDATE annonce SET 
            titre=:titre,description_courte=:description_courte,description_longue=:description_longue,prix=:prix,pays=:pays,ville=:ville,adresse=:adresse,cp=:cp WHERE id_annonce=:id_annonce");
            $maj->execute(array('titre'                =>$_POST['titre'],
                                'description_courte'   =>$_POST['description_courte'],
                                'description_longue'   =>$_POST['description_longue'],
                                'prix'                 =>$_POST['prix'],    
                                'pays'                 =>$_POST['pays'],
                                'ville'                =>$_POST['ville'],
                                'adresse'              =>$_POST['adresse'],
                                'cp'                   =>$_POST['cp'],
                                'id_annonce'           =>$_GET['id_annonce']
                                ));
                               
                               
            $contenu .='<div class="alert alert-success">L\'annonce "'.$_POST['titre'].'" à été modifiée </div>';
            $update = true;
        }
    }
}
/* affichage des annonces */

$resul= $pdo->query('SELECT 
ANN.id_annonce,
ANN.titre,
ANN.description_courte,
ANN.description_longue,
ANN.prix,
ANN.pays,
ANN.ville,
ANN.adresse,
ANN.cp,
ANN.membre_id,
ANN.categorie_id,
ANN.date_enregistrement,
PHO.url,
PHO.annonce_id,
MIN(PHO.date_enregistrement)
FROM annonce ANN
INNER JOIN photo PHO ON PHO.annonce_id=ANN.id_annonce
GROUP BY ANN.id_annonce');

$contenu .="<h2 class='page-header' > Liste des annonces</h2>";

/* Menu déroulant */
$resulcat=$pdo->query('SELECT * FROM categorie');
$contenu .='<div class="col-xs-4 select_cat"><select class="form-control">
            <option selected>Trier par categorie</option>';
while($cat=$resulcat->fetch(PDO::FETCH_ASSOC))
{
    $contenu.='<option value="'.$cat['titre'].'">Categorie: '.$cat['titre'].'</option>';
};
$contenu .='</select><br></div>';

$contenu .="<p>Nombre d'annonce : ".$resul->rowCount()."</p>";
$contenu .="<table class='table-striped'>
            <tr>";

/* les en tetes */
$contenu .='<th >Id annonce</th>';
$contenu .='<th >Titre</th>';
$contenu .='<th >Description courte</th>';
$contenu .='<th >Description longue</th>';
$contenu .='<th >Prix</th>';
$contenu .='<th >Photos</th>';
$contenu .='<th >Pays</th>';
$contenu .='<th >Ville</th>';
$contenu .='<th >Adresse</th>';
$contenu .='<th >Code postale</th>';
$contenu .='<th >membre</th>';
$contenu .='<th >Categorie</th>';
$contenu .='<th >Date enregistrement</th>';
$contenu .='<th >Actions</th>';

$contenu .="</tr>";

/* les donnees */
while($ligne = $resul->fetch(PDO::FETCH_ASSOC) )
{
$contenu .='<tr>';
$contenu .='<td>'.$ligne['id_annonce'].'</td>';
$contenu .='<td>'.$ligne['titre'].'</td>';
$contenu .='<td>'.$ligne['description_courte'].'</td>';
$contenu .='<td>'.$ligne['description_longue'].'</td>';
$contenu .='<td>'.$ligne['prix'].'</td>';
$contenu .='<td><a target="_blank" href="'.$ligne['url'].'"> <img class="img-thumbnail img-responsive affiche" src="'.$ligne['url'].'" alt="'.$ligne['annonce_id'].'"></a>
<a class="font-size:8px;text-align : center" href="#ModalAutresPhotos" data-toggle="modal">Voir +</a></td>';  
?>                                          

<!-- modal autres photos-->
<div class="modal fade" id="ModalAutresPhotos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title">Autres photos de l'annnonce</h4>
            </div>
            <div class="modal-body">
                <?php
                //selection des autres photos éventuelles
                //photo déjà affichée =$ligne['url']
                $req_autresPhotos = $pdo->prepare("SELECT annonce_id,url FROM photo WHERE annonce_id=:annonce_id AND url<>:url"); // AND url<>:url
                $req_autresPhotos->execute(array(
                    'annonce_id' => $ligne['id_annonce'],
                    'url' => $ligne['url']));
                    
                echo '<div class="row">';
                while($res_autresPhotos = $req_autresPhotos->fetch(PDO::FETCH_ASSOC)){

                    //echo 'deja photo'.$ligne['id_annonce'];
                    //echo '<p>id annnonce ='.$res_autresPhotos['annonce_id'].'</p>';
                    //echo '<p>id annnonce ='.$res_autresPhotos['url'].'</p>';
                    echo '<div class="col-md-3"><img class="img-responsive img-thumbnail" src="'.$res_autresPhotos['url'].'" title=""></div>';

                }
                echo '</div>'; //row
                ?>
            </div> <!-- /.modal-body -->

            <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->












<?php
$contenu .='<td>'.$ligne['pays'].'</td>';
$contenu .='<td>'.$ligne['ville'].'</td>';
$contenu .='<td>'.$ligne['adresse'].'</td>';
$contenu .='<td>'.$ligne['cp'].'</td>';
$contenu .='<td>'.$ligne['membre_id'].'</td>';
$contenu .='<td>'.$ligne['categorie_id'].'</td>';
$contenu .='<td>'.format_dateheure($ligne['date_enregistrement']).'</td>';
$contenu .='<td><a href="?action=modification&id_annonce='.$ligne['id_annonce'].'"><span class="glyphicon modif glyphicon-pencil" aria-hidden="true"></span></a>
                <a href="?action=suppression&id_annonce='.$ligne['id_annonce'].'"onclick=
                "return(confirm(\'Etes vous certain de vouloir supprimer cette annonce :'.$ligne['titre'].'?\'))"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></td>';
$contenu .='</tr>';
}
$contenu .='<table>';

echo $contenu;
 /* affichage des donnes pour modification */

 if ( (isset($_GET['action']) && ($_GET['action']=='modification')))
 :
 if ( !empty( $_GET['id_annonce']) )
 {
      $resul = $pdo->prepare("SELECT * FROM annonce WHERE id_annonce=:id_annonce");
      $resul->execute(array('id_annonce' =>$_GET['id_annonce']));
      $annonce_actuelle=$resul->fetch(PDO::FETCH_ASSOC);
 } 
   

?>
<?php if(!$update) { ?>
    <div id="content_form_update">
    <h2 class="page-header">Modifier une annonce</h2>
    <div class="container-center">
        <div class="box-content">
            <form novalidate method="post" class="form-horizontal" action="" enctype="multipart/form-data">

                <div class="row">
                    <!-- DEBUT BLOC GAUCHE -->
                    <div class="col-md-6">
                        <!-- Titre -->
                        <div class="form-group">
                            <label for="titre" class="col-sm-3 control-label">Titre :</label>
                            <div class="col-sm-9">
                                <input type="titre" class="form-control" id="titre" name="titre" placeholder="Titre de l'annonce..." value="<?=$annonce_actuelle['titre'] ?? '' ?>" required autofocus>
                            </div>
                        </div>

                        <!-- Description courte -->
                            <div class="form-group">
                            <label for="description_courte" class="col-sm-3 control-label">Description courte :</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="description_courte" id="description_courte" rows="3" placeholder="Description courte de l'annonce..."><?=$annonce_actuelle['description_courte'] ?? '' ?></textarea>
                                </div>
                            </div>

                        <!-- Description longue -->
                            <div class="form-group">
                                <label for="description_longue" class="col-sm-3 control-label">Description longue :</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="description_longue" id="description_longue" rows="6" placeholder="Description longue de l'annonce..."><?=$annonce_actuelle['description_longue'] ?? '' ?></textarea>
                                </div>
                            </div>

                        <!-- Prix -->    
                            <div class="form-group">
                            <label for="titre" class="col-sm-3 control-label">Prix :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="prix" name="prix" placeholder="Prix..." value="<?=$annonce_actuelle['prix'] ?? '' ?>" required >
                            </div>

                        <!-- Photo -->
                            <div class="form-group">
                            <label for="photo" class="col-sm-3 control-label">Photo :</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" id="photo" name="photo">    
                                    <?php
                                        /* Reprise de la photo déja en base */
                                        if ( isset($annonce_actuelle['photo']) )
                                        {
                                            echo '<p>Vous pouvez uploader une nouvelle photo</p>';
                                            echo '<div class="row"><div class="col-xs-5"><img class="img-thumbnail" src="' .$annonce_actuelle['photo'] .'"alt="'.$annonce_actuelle['titre']. '" ></div></div>';
                                            echo '<input type="hidden" name="photo_actuelle" value="'.$annonce_actuelle['photo'].'" >';
                                            /* cet input permet de remplir $_POST sur un indice "photo actuelle" la valeur
                                                de l'url de la photo stockée en base. Ainsi si on ne charge pas de nouvelle photo,
                                                l'url actuelle sera remise en base.
                                            */
                                        }

                                    ?>
                            </div>                 
                        </div>  
                        </div>
                    </div> <!-- FIN BLOC GAUCHE -->

                    <!-- DEBUT BLOC DROIT -->
                    <div class="col-md-6">
                    <!-- Pays -->
                    <div class="form-group">
                            <label for="pays" class="col-sm-3 control-label">Pays :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="pays" name="pays" placeholder="pays..." value="<?=$annonce_actuelle['pays'] ?? '' ?>" required>
                            </div>
                        </div>

                        <!-- Ville -->
                        <div class="form-group">
                            <label for="ville" class="col-sm-3 control-label">Ville :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="ville" name="ville" placeholder="Ville..." value="<?=$annonce_actuelle['ville'] ?? '' ?>" required>
                            </div>
                        </div>

                        <!-- Adresse -->
                        <div class="form-group">
                            <label for="adresse" class="col-sm-3 control-label">Adresse :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="adresse" name="adresse" placeholder="Adresse..." value="<?=$annonce_actuelle['adresse'] ?? '' ?>" required>
                            </div>
                        </div>

                        <!-- Code postal -->
                        <div class="form-group">
                            <label for="code_postal" class="col-sm-3 control-label">Code postal :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="cp" name="cp" placeholder="Code postal..." value="<?=$annonce_actuelle['cp'] ?? '' ?>" required>
                            </div>
                        </div>
                        <!-- Id membre -->
                        <div class="form-group">
                            <label for="membre_id" class="col-sm-3 control-label">Id Membre :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="id_membre" name="id_membre" placeholder="Id_membre..." value="<?=$annonce_actuelle['membre_id'] ?? '' ?>" required>
                            </div>
                        </div>

                        <!-- Categorie -->
                        <div class="form-group">
                            <label for="categorie" class="col-sm-3 control-label">Categorie</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="categorie" name="categorie" placeholder="categorie..." value="<?=$annonce_actuelle['categorie'] ?? '' ?>" required>
                            </div>
                        </div>
                        <!-- Date enregistrment -->
                        <div class="form-group">
                            <label for="date_enregistrement" class="col-sm-3 control-label">Date enregistrement</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="date_enregistrement" name="date_enregistrement" placeholder="date_enregistrement..." value="<?=$annonce_actuelle['date_enregistrement'] ?? '' ?>" required>
                            </div>
                        </div>

                    </div> <!-- fin COL 6 -->
                </div> <!-- fin row -->
                    
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-md-12 ">
                                <input type="submit" value="Modifier l'annonce" name="update" id="update" class="btn btn-primary pull-right">
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
?>






