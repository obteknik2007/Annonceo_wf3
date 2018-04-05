<?php 
require_once('php_inc/init.php');

//Infos membre
$req = $pdo->prepare("SELECT * FROM membre WHERE id_membre = :id_membre");
$req->execute(array('id_membre' => $_SESSION['membre']['id_membre']));
$infos_membre = $req->fetch(PDO::FETCH_ASSOC);
?>

<!-- Profil infos membre -->
<section id="sect_profil_infos">
    <h2 class="page-header">Votre profil</h2>
   
    <div class="row">
        <div class="col-md-12">
            <p>Vous inscrit sur notre site depuis le <strong><?=format_dateHeure($infos_membre['date_enregistrement']) ?></strong>
            <?php if($_SESSION['membre']['statut'] == 1){
                echo '<span class="pull-right"> Statut : <strong>Administrateur</span></strong>';
            }?><p>
    </div>

    <small>Cliquez sue les différentes valeurs pour pouvoir les modifier.</small>
    <div class="row">
        <div class="col-md-6">
            <div class="box-content">
                <p>Pseudo : <strong><?='<span id="profil_pseudo" >'.$infos_membre['pseudo'].'</span>'; ?></strong></p>

                <p>Civilité : <strong><?php
                if($infos_membre['civilite'] == 'm'){
                    echo '<span id="profil_civilite" >Monsieur';
                } else {
                    echo '<span id="profil_civilite" >Madame';
                }
                ; 
                
                ?></strong></p>
                <p>Prénom : <strong><?='<span id="profil_prenom" >'.$infos_membre['prenom']; ?></strong></p>
                <p>Nom : <strong><?='<span id="profil_nom" >'.$infos_membre['nom']; ?></strong></p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box-content">
                <p>Email : <strong><?='<span id="profil_email" >'.$infos_membre['email']; ?></strong></p>
                <p>Téléphone : <strong><?='<span id="profil_telephone" >'.$infos_membre['telephone']; ?></strong></p>
            </div>
        </div>
    </div>

</section>

<!-- Annonces publiées infos membre -->
<section id="sect_profil_annonces">
    <h2 class="page-header">Vos publications d'annonces</h2>
    <div class="row">
    <?php
    //Annonces
    $sql="SELECT 
    ANN.id_annonce AS ANN_ID_ANNONCE,
    ANN.date_enregistrement AS ANN_DATE_ENREGISTREMENT,
    ANN.titre AS ANN_TITRE,
    ANN.description_courte AS ANN_DESCRIPTION_COURTE,
    PHO.url AS PHO_URL
    FROM annonce ANN
    INNER JOIN photo PHO ON PHO.annonce_id = ANN.id_annonce
    INNER JOIN membre MEM ON MEM.id_membre = ANN.membre_id

    WHERE ANN.membre_id = 1
    GROUP BY ANN.id_annonce";

    $req_annonces = $pdo->prepare($sql);
    $req_annonces->execute(array('membre_id' => $_SESSION['membre']['id_membre']));
    
        echo '<div class="row">';
        echo '<div class="col-md-12">';
                while($annonces = $req_annonces->fetch(PDO::FETCH_ASSOC)){
                    echo '<div class="box-content" style="margin-bottom:10px">';
                        echo '<div class="row">';

                        echo '<div class="col-md-8">';
                        echo '<p>Date de publication : <strong>'.format_dateHeure($annonces['ANN_DATE_ENREGISTREMENT']).'</strong></p>'
                        .'<p>Titre de l\'annonce : <strong>'.$annonces['ANN_TITRE'].'</strong></p>'
                        .'<p>Description courte : <strong>'.$annonces['ANN_DESCRIPTION_COURTE'].'</strong></p>';
                        echo '</div>'; //fin col8

                        echo '<div class="col-md-4">';
                        echo '<img class="img-responsive img-thumbnail" src="'.$annonces['PHO_URL'].'">';
                        echo '</div>'; //fin col4
                    
                        echo '</div>'; // fin ROW

                        //BLOC COMMENTAIRES
                        $sql_comentaires = "SELECT * FROM commentaire WHERE membre_id=:membre_id  AND annonce_id=:annonce_id";
                        $req_commentaires = $pdo->prepare($sql_comentaires);
                        $req_commentaires->execute(array(
                            'membre_id' => $_SESSION['membre']['id_membre'],
                            'annonce_id' => $annonces['ANN_ID_ANNONCE']));

                            echo '<div class="row" style="margin:0">';
                            echo '<div class="col-md-12" style="background-color:lightgrey;color:blue">';
                            echo '<p><strong>Liste des commentaires :</strong></p>';
                            while($commentaires = $req_commentaires->fetch(PDO::FETCH_ASSOC)){
                                echo '<p style="border:1px dashed blue;padding:5px">'.$commentaires['commentaire'].'</p>';
                            }
                            echo '</div>'; //fin col12
                            echo '</div>'; // fin ROW

                    //--------------------------------
                    echo '</div>'; // fin box-content
                }
        echo '</div>'; //fin col12
        echo '</div>'; //fin row
    ?>
</div>

<!-- note & listes des avis -->
<section id="sect_note_avis">
    <h2 class="page-header">Note & Avis</h2>
    <!-- Calcul de la note moyenne tout acheteur -->
    <div class="row">
        <div class="col-md-12">
        <?php
        $note_etoiles='';

        $note_moyenne = '';
        //nb de noteurs pour l'id_membre en session
        $req1 = $pdo->prepare("SELECT COUNT(membre_id1) FROM note WHERE membre_id2 = :membre_id2");
        $req1->execute(array('membre_id2' => $_SESSION['membre']['id_membre']));
        $res1 = $req1->fetch();
        $nb_noteurs = $res1['COUNT(membre_id1)'];

        $req2 = $pdo->prepare("SELECT SUM(note) FROM note WHERE membre_id2 = :membre_id2");
        $req2->execute(array('membre_id2' => $_SESSION['membre']['id_membre']));
        $res2 = $req2->fetch();
        $total_note = $res2['SUM(note)'];

        //note moyenne = $total_note/$nb_noteurs
        if($nb_noteurs ==0){
            echo 'Pour le moment, aucune note et avis déposé.';
        } else {
            // au moins 1 note/avis déposé

            $note_moyenne = ceil($total_note/$nb_noteurs);
            switch($note_moyenne){
                case 1 :
                    $note_etoiles .= '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
                    $note_etoiles .= '<span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>';
                    $note_etoiles .= '<span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>';
                    $note_etoiles .= '<span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>';
                    $note_etoiles .= '<span class="$note_moyenneglyphicon glyphicon-star-empty" aria-hidden="true"></span>';
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

            echo 'Note moyenne du vendeur = '.$note_etoiles.' - '.$note_moyenne.'/5';
            echo '<hr style="border:2px solid grey;margin-bottom:5px;">';

        // LISTE DES AVIS
        echo '<h4>Liste des avis'.'</h4>';

        $req_avis = $pdo->prepare("SELECT 
            NT.avis,
            NT.date_enregistrement,
            NT.membre_id1,
            MEM.pseudo
            FROM note NT
            INNER JOIN membre MEM ON MEM.id_membre = NT.membre_id2
            WHERE membre_id2 = :membre_id2");
        $req_avis->execute(array('membre_id2' => $_SESSION['membre']['id_membre']));

        $i = 1;
        while($avis = $req_avis->fetch(PDO::FETCH_ASSOC)){
            echo '<div class="box-content" style="margin-bottom:5px;">
                    <p><strong>Avis n° '.$i.' du '.format_dateheure($avis['date_enregistrement']).
                    ' par '.$avis['pseudo'].'</strong></p>
                    <p style="color:blue">'.$avis['avis'].'</p>
                </div>';

                $i++;
        }












        }

        
       


      
        ?>  
        </div>
    </div>

    <!-- Avis-->
    <div class="row">
        <div class="col-md-12">
        
        </div>
    </div>

</section>





</section>