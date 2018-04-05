<?php

require_once('../../php_inc/init.php');
require_once('../../php_inc/header.php');

/* Recuperation de la fiche annonce correspondante */
 $id_annonce=$_GET['id_annonce'] ; 

 $contenu='';
    

 /* selection des champs à afficher */
$resul=$pdo->prepare('SELECT phot.url,
ann.description_longue,
ann.date_enregistrement,
ann.prix,
ann.adresse,
ann.cp,
ann.ville,
ann.titre,
ann.id_annonce,
mem.pseudo,
note.note
FROM photo phot,
annonce ann,
membre mem,
note note
where id_annonce=:id_annonce
group by id_annonce');

$resul->execute(array('id_annonce'=>$id_annonce));

// req pour id vendeur
$req_idvendeur =$pdo->prepare("SELECT membre_id FROM annonce WHERE id_annonce =:id_annonce");
$req_idvendeur->execute(array('id_annonce' => $id_annonce));
$res_idvendeur = $req_idvendeur->fetch(PDO::FETCH_ASSOC);

$id_vendeur = $res_idvendeur['membre_id'];


/* Selection des autre annonces du même vendeur */
$resul_annonce=$pdo->query('SELECT ann.membre_id,ann.titre,pho.url from annonce ann, photo pho where pho.annonce_id=ann.id_annonce 
and membre_id=2 limit 1,4');
/*$resul_annonce=$pdo->execute(array('id_annonce' => $id_annonce));
$annonce = $resul_annonce->fetch(PDO:FETCH_ASSOC);*/

/* Envoi du formulaire */
if ( isset($_POST['submit'] ) && !empty($_POST['avis']) && !empty($_POST['note']))
{
    if(strlen($_POST['note']== 1))
    {
        if(is_numeric($_POST['note']))
        {
            $insert=$pdo->prepare("INSERT INTO note(membre_id1,membre_id2,note,avis) VALUES(:membre_id1,:membre_id2,:note,:avis)");
            $insert->execute(array( 'membre_id1'    => $_SESSION['membre']['id_membre'],
                                    'membre_id2'   => $id_vendeur,
                                    'note'         => $_POST['note'],
                                    'avis'         => $_POST['avis']));
                                                
            echo'<div class="alert alert-success">La note et l\'avis ont été ajoutés </div>';
        }
        else{
            $contenu.='<div class="alert alert-danger"> Entrez une note au format numerique </div>';
        }
    }
    else{
        $contenu.='<div class="alert alert-danger"> Vous devez entrer un seul chiffre entre 1 et 5 </div>';
    }
}


            while($annonce = $resul->fetch(PDO::FETCH_ASSOC))
            {
                echo'<div class="row">';/* partie image description */
                    echo'<div class="col-md-6">';
                        echo'<h2 class="titre_fiche">'.$annonce['titre'].'</h2>';
                        echo '<img src="'.$annonce['url'].'" class="img-responsive">' ;
                    echo'</div>';/* fin de la col image */
                    echo'<div class="col-md-6 desc_annonce">';
                        //echo' <button class="btn btn-primary">Contacter Membre</button>';

                        echo '<button class="btn btn-primary btn-md center-block"><a style="color:yellow;text-decoration:none;" href="../../php/front/contact.php">Contacter le vendeur</a></button>';
                        echo '<div><h3 class="titre_fiche">Description</h3>'.$annonce['description_longue'].'</div>' ;
                    echo'</div>';/* fin de la col description */
                echo'</div>';/* fin de la row image/description  */

                echo'<div class="row"';/* partie plan et + */
                    echo'<div class="col-md-12">';
                        echo'<span class="date"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>Date de publication '.format_dateHeure($annonce['date_enregistrement']).'</span>';
                        echo'<span class="date"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>'.$annonce['pseudo'].'</span>';
                        echo'<span> -note"'.$annonce['note'].'"</span>';
                        echo'<span class="date"><span class="glyphicon glyphicon-euro" aria-hidden="true"></span>'.$annonce['prix'].' €</span>';
                        echo'<span class="date"><span class="glyphicon glyphicon-globe" aria-hidden="true"></span>Adresse :'.$annonce['adresse'].' </span>';
                        echo $annonce['cp'];                    
                        echo $annonce['ville'];
                    echo'</div>';/* fin col-md-12 */
                echo'</div';/* fin de la row */
                echo'<div class="row">';
                    echo'<div class="col-md-12 plan">';
                    echo'<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d10502.476747112658!2d2.3324169500000003!3d48.8464021!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sfr!2sfr!4v1519055990689" width="100%" height="200" frameborder="0" style="border:0" allowfullscreen></iframe>';
                    echo'</div">';
                echo'</div">';

                /* Affichage des autre annonces */
                echo'<div class="row">';
                echo'<h2 class="autre">Autre annonces</h2>';
                    while($autre_annonces = $resul_annonce->fetch(PDO::FETCH_ASSOC))
                    {
                        echo '<div class="col-md-3"><img src="'.$autre_annonces['url'].'" class="img-responsive"></div>' ;
                    }
                echo'</div>';/* fin du row autre annonces */

                echo'<div class="row">';

               
                echo'<h2 class="autre">Déposer un avis ou une note</h2>';
                echo'<p class="retour"><a href="#">Retour vers les annonces</a></p>';
                echo'<div class="col-md-6">';

                 /* verification des champs avant envoi du formulaire */
                    if( isset($_POST['submit']) && empty($_POST['avis']) )
                    {
                        echo'<div class="alert alert-danger"> Veuillez entrer un avis </div>';
                    }
                    if( isset($_POST['submit']) && empty($_POST['note']) )
                    {
                        echo'<div class="alert alert-danger"> Veuillez entrer une note </div>';
                    }
                     //erreurs
                     echo $contenu;

                    ?>
                    <form method="post" action="#">
                    <div class="form-group">
                      <label for="commentaire">Avis</label>
                      <textarea class="form-control" name="avis" id="avis" rows="6" placeholder="Inscrivez votre avis..." value="<?=$_POST['avis'] ?? '' ?>" ></textarea>
                    </div>
                    <div class="form-group">
                      <label for="note">Attribuer une note de 1 à 5</label>
                      <input type="text" class="form-control" name="note" id="note" placeholder="votre note..." >
                    </div>
                    <button type="submit" name="submit" id="submit" class="btn btn-default">Envoyer</button>
                  </form>
                  </div>
                </div>
                <?php

            }
            require_once('../../php_inc/footer.php');
        ?>
    
    