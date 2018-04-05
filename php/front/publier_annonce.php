<?php
require_once('../../php_inc/init.php');

//HEADER
require_once('../../php_inc/header.php');

//Traitements
$publication_annonce = false;

$tab_erreurs = array();

//Soumission du formulaire
if($_POST){

    //sécurité
    $titre              =  secure_field($_POST['titre']);
    $description_courte =  secure_field($_POST['description_courte']);
    $description_longue =  secure_field($_POST['description_longue']);
    $prix               =  secure_field($_POST['prix']);
    $adresse            =  secure_field($_POST['adresse']);
    $code_postal        =  secure_field($_POST['code_postal']);
    $ville              =  secure_field($_POST['ville']);
    $pays               =  secure_field($_POST['pays']);
    $categorie           =  secure_field($_POST['categorie']);

    //CONTROLE CHAMPS VIDES
    $champs_vides = 0;
    foreach($_POST as $indice => $valeur){
        if(empty($valeur)){
            $champs_vides++;
        }
    }

    if($champs_vides > 0){
        $tab_erreurs[] = 'Il y a '.$champs_vides.' information(s) manquante(s).';
    }

    //CONTROLE DE TAILLES SELON TAILLE BDD
    //titre 255 caractères
    if(strlen($titre) > 255){
        $tab_erreurs[] =  'Pas plus de 255 caractères autorisés pour le champs Titre';
    }

    //description_courte 255 caractères
    if(strlen($description_courte) > 255){
        $tab_erreurs[] =  'Pas plus de 255 caractères autorisés pour le champs Description courte';
    }

    //adresse 50 caractères
    if(strlen($adresse) > 50){
        $tab_erreurs[] =  'Pas plus de 50 caractères autorisés pour le champs Adresse';
    }

    //code_postal 5 caractères
    if(strlen($code_postal) > 5){
        $tab_erreurs[] =  'Pas plus de 5 caractères autorisés pour le champs Code postal';
    }

    //ville 20 caractères
    if(strlen($ville) > 20){
        $tab_erreurs[] =  'Pas plus de 20 caractères autorisés pour le champs Ville';
    }

    //pays 20 caractères
    if(strlen($pays) > 20){
        $tab_erreurs[] =  'Pas plus de 20 caractères autorisés pour le champs Pays';
    }
    
    //si post photo
    //recup dernier id annonce en base
    $req = $pdo->query("SELECT MAX(id_annonce) FROM annonce");
    $res = $req->fetch();
    $lastid_photo = $res['MAX(id_annonce)'];

    // SAUVEGARDE DES PHOTOS
    //photo 1
    if(!empty($_FILES['photo1']['name'])){
        $nom_photo1 = $lastid_photo.'-'.$_FILES['photo1']['name'];
        $photo_bdd1 = RACINE_SITE.'photos/'.$nom_photo1; 
        $photo_dossier = $_SERVER['DOCUMENT_ROOT'].$photo_bdd1; //adresse physique

        copy($_FILES['photo1']['tmp_name'],$photo_dossier);
    }

    //photo 2
    if(!empty($_FILES['photo2']['name'])){
        $nom_photo2 = $lastid_photo.'-'.$_FILES['photo2']['name'];
        $photo_bdd2 = RACINE_SITE.'photos/'.$nom_photo2; 
        $photo_dossier = $_SERVER['DOCUMENT_ROOT'].$photo_bdd2; //adresse physique

        copy($_FILES['photo2']['tmp_name'],$photo_dossier);
    }

    //photo 3
    if(!empty($_FILES['photo3']['name'])){
        $nom_photo3 = $lastid_photo.'-'.$_FILES['photo3']['name'];
        $photo_bdd3 = RACINE_SITE.'photos/'.$nom_photo3; 
        $photo_dossier = $_SERVER['DOCUMENT_ROOT'].$photo_bdd3; //adresse physique

        copy($_FILES['photo3']['tmp_name'],$photo_dossier);
    }

    //photo 4
    if(!empty($_FILES['photo4']['name'])){
        $nom_photo4 = $lastid_photo.'-'.$_FILES['photo4']['name'];
        $photo_bdd4 = RACINE_SITE.'photos/'.$nom_photo4; 
        $photo_dossier = $_SERVER['DOCUMENT_ROOT'].$photo_bdd4; //adresse physique

        copy($_FILES['photo4']['tmp_name'],$photo_dossier);
    }

    //photo 5
    if(!empty($_FILES['photo5']['name'])){
        $nom_photo5 = $lastid_photo.'-'.$_FILES['photo5']['name'];
        $photo_bdd5 = RACINE_SITE.'photos/'.$nom_photo5; 
        $photo_dossier = $_SERVER['DOCUMENT_ROOT'].$photo_bdd5; //adresse physique

        copy($_FILES['photo5']['tmp_name'],$photo_dossier);
    }

    //SI TOUT EST OK/pas d'erreurs dans $contenu
    if(empty($tab_erreurs)){
        //echo '<pre>';
        //var_dump($_FILES);
        //echo '</pre>';

        //insertion en bdd des informations d'annonce (table ANNONCE)
        $insert_annonce = $pdo->prepare("INSERT INTO annonce(
        titre,
        description_courte,
        description_longue,
        prix,
        pays,
        ville,
        adresse,
        cp,categorie_id,membre_id) 
        VALUES(:titre,:description_courte,:description_longue,:prix,:pays,:ville,:adresse,:cp,:categorie_id,:membre_id)");
        $insert_annonce->execute(array(
            'titre'                 => $titre,
            'description_courte'    => $description_courte,
            'description_longue'    => $description_longue,
            'prix'                 => $prix,
            'pays'                  => $pays,
            'ville'                 => $ville,
            'adresse'               => $adresse,
            'cp'                    => $code_postal,
            'categorie_id'          => $categorie,
            'membre_id'             => $_SESSION['membre']['id_membre']));
        
            $lastid_annonce = $pdo->lastInsertId();

        //insertion en bdd de la photo (table PHOTO)
        /*******************************************************/
        //parcours index de $_FILES pour avoir nb phtos postées
        //puis boucle for pour les inserts
        //$nb_photopostees = count($_FILES);
        //for($i = 0;$i<= $nb_photopostees;$i++){
            //INSERT PHOTO 1
            if(!empty($_FILES['photo1']['name'])){
            $insert_photo = $pdo->prepare("INSERT INTO photo(url,annonce_id) VALUES(:url,:annonce_id)");
            $insert_photo->execute(array(
                'url'           => $photo_bdd1,
                'annonce_id'    => $lastid_annonce));   
            }

            //INSERT PHOTO 2
            if(!empty($_FILES['photo2']['name'])){
            $insert_photo = $pdo->prepare("INSERT INTO photo(url,annonce_id) VALUES(:url,:annonce_id)");
            $insert_photo->execute(array(
                'url'           => $photo_bdd2,
                'annonce_id'    => $lastid_annonce)); 
            }

            //INSERT PHOTO 3
            if(!empty($_FILES['photo3']['name'])){
            $insert_photo = $pdo->prepare("INSERT INTO photo(url,annonce_id) VALUES(:url,:annonce_id)");
            $insert_photo->execute(array(
                'url'           => $photo_bdd3,
                'annonce_id'    => $lastid_annonce));   
            }

            //INSERT PHOTO 4
            if(!empty($_FILES['photo4']['name'])){
            $insert_photo = $pdo->prepare("INSERT INTO photo(url,annonce_id) VALUES(:url,:annonce_id)");
            $insert_photo->execute(array(
                'url'           => $photo_bdd4,
                'annonce_id'    => $lastid_annonce)); 
            }

            //INSERT PHOTO 5
            if(!empty($_FILES['photo5']['name'])){
            $insert_photo = $pdo->prepare("INSERT INTO photo(url,annonce_id) VALUES(:url,:annonce_id)");
            $insert_photo->execute(array(
                'url'           => $photo_bdd5,
                'annonce_id'    => $lastid_annonce));  
            } 
        //}
        

        //message info utilisateur
       // $contenu .= '<div class="alert alert-success">Votre annonce a bien été enregistrée.</div>';

        //$publication_annonce à vrai
        $publication_annonce = true;

    } else {
        //affichage des erreurs
        echo '<div class="alert alert-danger">';
        echo '<ul>';
        //parcours du tableau des erreurs
            for($i=0;$i<count($tab_erreurs);$i++){
                echo '<li>'.$tab_erreurs[$i].'</li>';
            }
        echo '</ul>';
        echo '</div>';
    }
    
} //fn post


//header
//require_once('../../php_inc/header.php');
if(!$publication_annonce){
?>

<!-- FORMULAIRE D'AJOUT ANNONCE -->
<form novalidate method="post" class="form-horizontal" action="" enctype="multipart/form-data">
<h2 class="page-header">Publier une annonce
<input type="submit" value="Valider l'annonce" class="btn btn-primary pull-right">
<button class="btn btn-primary pull-right" id="retour_index_publier">Annuler</button>

</h2>
<div class="container-center">
    <div class="box-content">


            <div class="row">
                <!-- DEBUT BLOC GAUCHE -->
                                    
                <div class="col-md-6">
                    <!-- Catéegorie -->

            <?php
            $req_cat = $pdo->query("SELECT DISTINCT * FROM categorie");

            ?>
                <div class="form-group">
                <label for="categorie" class="col-sm-3 control-label">Catégorie :</label>
                    <select name="categorie" id="categorie">
                        <?php while($categorie = $req_cat->fetch()){
                            echo '<option value ="'.$categorie['id_categorie'].'" >'.$categorie['titre'].'</option>';
                        }?>                    
                    </select>
                </div>
                    <!-- Titre -->
                    <div class="form-group">
                        <label for="titre" class="col-sm-3 control-label">Titre :</label>
                        <div class="col-sm-9">
                            <input type="titre" class="form-control" id="titre" name="titre" placeholder="Titre de l'annonce..." value="<?=$_POST['titre'] ?? '' ?>" required autofocus>
                        </div>
                    </div>

                    <!-- Description courte -->
                        <div class="form-group">
                        <label for="description_courte" class="col-sm-3 control-label">Description courte :</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="description_courte" id="description_courte" rows="7" placeholder="Description courte de l'annonce..."><?=$_POST['description_courte'] ?? '' ?></textarea>
                            </div>
                        </div>

                    <!-- Description longue -->
                        <div class="form-group">
                            <label for="description_longue" class="col-sm-3 control-label">Description longue :</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="description_longue" id="description_longue" rows="12" placeholder="Description longue de l'annonce..."><?=$_POST['description_longue'] ?? '' ?></textarea>
                            </div>
                        </div>
                </div> <!-- FIN BLOC GAUCHE -->

                <!-- DEBUT BLOC DROIT -->
                <div class="col-md-6">
                    <!-- Adresse -->
                    <div class="form-group">
                        <label for="adresse" class="col-sm-3 control-label">Adresse :</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="adresse" name="adresse" placeholder="Adresse..." value="<?=$_POST['adresse'] ?? '' ?>" required>
                        </div>
                    </div>

                    <!-- Code postal -->
                    <div class="form-group">
                        <label for="code_postal" class="col-sm-3 control-label">Code postal :</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="code_postal" name="code_postal" placeholder="Code postal..." value="<?=$_POST['code_postal'] ?? '' ?>" required>
                        </div>
                    </div>

                    <!-- Ville -->
                    <div class="form-group">
                        <label for="ville" class="col-sm-3 control-label">Ville :</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="ville" name="ville" placeholder="Ville..." value="<?=$_POST['ville'] ?? '' ?>" required>
                        </div>
                    </div>

                    <!-- Pays -->
                    <div class="form-group">
                        <label for="pays" class="col-sm-3 control-label">Pays :</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="pays" name="pays" placeholder="pays..." value="<?=$_POST['pays'] ?? '' ?>" required>
                        </div>
                    </div>

                    <!-- PHOTO 1-->
                    <div class="form-group">
                        <label for="photo1" class="col-sm-3 control-label">Photo 1 :</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" id="photo1" name="photo1">    
                        </div>                 
                    </div>     

                    <!-- PHOTO 2-->
                    <div class="form-group">
                        <label for="photo2" class="col-sm-3 control-label">Photo 2 :</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" id="photo2" name="photo2">    
                        </div>                 
                    </div>   

                    <!-- PHOTO 3-->
                    <div class="form-group">
                        <label for="photo3" class="col-sm-3 control-label">Photo 3 :</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" id="photo3" name="photo3">    
                        </div>                 
                    </div>   

                    <!-- PHOTO 4-->
                    <div class="form-group">
                        <label for="photo4" class="col-sm-3 control-label">Photo 4 :</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" id="photo4" name="photo4">    
                        </div>                 
                    </div>   

                    <!-- PHOTO 5-->
                    <div class="form-group">
                        <label for="photo4" class="col-sm-3 control-label">Photo 5 :</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" id="photo5" name="photo5">    
                        </div>                 
                    </div> 

                    <!-- Prix -->
                    <div class="form-group">
                        <label for="prix" class="col-sm-3 control-label">Prix :</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="prix" name="prix" placeholder="Prix..." value="<?=$_POST['prix'] ?? '' ?>" required>
                        </div>
                    </div>
                    
                </div> <!-- fin COL 6 -->
            </div> <!-- fin row -->
                
            <!--<div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="submit" value="Valider l'annonce" class="btn btn-primary center-block">
                    </div>
                </div>
            </div> <!-- fin row -->
    </form>
    </div> <!-- FIN BOX-CONTENT-->
</div> <!-- FIN CONTAINER CENTER -->
<?php
} else {
    //publication ok
    echo '<div class="alert alert-success">Votre annonce a bien été enregistrée. Vous pouvez maintenant <a href="../../profil.php">consulter votre profil</a> ou <a href="../../index.php">consulter les annonces</a></div>';
    '<div class="alert alert-success">Votre annonce a bien été enregistrée.</div>';
}

//FOOTER
require_once('../../php_inc/footer.php');
?>