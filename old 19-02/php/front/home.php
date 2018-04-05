<?php
require_once('../../php_inc/init.php');

//$dept =$_POST['dept'];
$dept =  substr($_POST['dept'], -2, 2);

//je regarde si des annonces existent pour ce dept
$req_dept = $pdo->prepare("SELECT id_annonce FROM annonce WHERE SUBSTR(cp,1,2) = :dept");
$req_dept->execute(array('dept' => $dept));

//résultat, alors suite page, sinon retour réponse ajax
if($req_dept->rowCount() == 0){
    echo 'ko';
} else {

    //CATEGORIES pour lesquelles au-moins 1 annnonce existe
    $req_filtre_categories = $pdo->prepare("SELECT * FROM categorie");
    $req_filtre_categories->execute();

    //DEPARTEMENTS pour lesquels au-moins 1 annnonce existe
    $req_filtre_dept = $pdo->prepare("SELECT DISTINCT SUBSTR(cp,1,2) FROM annonce ORDER BY SUBSTR(cp,1,2) ASC");
    $req_filtre_dept->execute();

    //PSEUDO MEMBRES pour lesquels au-moins 1 annnonce existe
    $req_filtre_membres = $pdo->prepare("SELECT * FROM membre ORDER BY pseudo ASC");
    $req_filtre_membres->execute();
    
    /* REQUETE POUR AFFICHAGE DES ANNONCES */
    $sql_list_annonces = "
    SELECT 
    ANN.id_annonce,
    ANN.date_enregistrement,
    MEM.id_membre,
    MEM.pseudo,
    ANN.cp,
    ANN.categorie_id,
    ANN.membre_id,
    ANN.titre,ANN.description_longue,ANN.prix,
    PHO.url,MIn(PHO.date_enregistrement)
    FROM annonce ANN
    
    INNER JOIN photo PHO ON PHO.annonce_id = ANN.id_annonce
    INNER JOIN membre MEM ON MEM.id_membre = ANN.membre_id
    
    WHERE SUBSTR(ANN.cp,1,2) = 45

    GROUP BY ANN.id_annonce
    ORDER BY ANN.date_enregistrement DESC";

    $annonces_filtrees = $pdo->prepare($sql_list_annonces);

    //WHERE SUBSTR(ANN.cp,1,2) = 45 AND MEM.id_membre=3 AND ANN.categorie_id = 3

    //$order_prix_asc = " ORDER BY prix ASC";
    //$order_prix_desc = " ORDER BY prix DESC";

    $annonces_filtrees->execute(array('dept'=>$dept));
    

    ?>
    <h2 class="page-header">Home</h2>
    <div class="row">
        <div class="col-md-4">
            
            <form method="post" action="#">
                <!-- Filtre CATEGORIE -->
                <div class="form-group home_bloc_filtre">
                    <label for="home_filtre_categorie">Catégorie</label>
                    <select class="form-control home_css_select" name="home_filtre_categorie" id="home_filtre_categorie">
                        <option value="0">Toutes les catégories</option>
                        <?php
                        while($categorie = $req_filtre_categories->fetch(PDO::FETCH_ASSOC)){
                            echo '<option value="'.$categorie['id_categorie'].'">'.$categorie['titre'].'</option>';
                        } ?>
                    </select>
                    
                    </select>
                </div>

                <!-- Filtre DEPARTEMENT -->
                <div class="form-group home_bloc_filtre">
                    <label for="home_filtre_dept">Département</label>
                    <select class="form-control home_css_select" name="home_filtre_dept" id="home_filtre_dept">
                        <option value="0">Toutes les départements</option>
                        <?php
                        while($dept = $req_filtre_dept->fetch(PDO::FETCH_ASSOC)){
                            echo '<option value="'.$dept['SUBSTR(cp,1,2)'].'">'.$dept['SUBSTR(cp,1,2)'].'</option>';
                        } ?>
                    </select>
                </div>
            
                <!-- Filtre MEMBRE -->
                <div class="form-group home_bloc_filtre">
                    <label for="home_filtre_membre">Membre</label>
                    <select class="form-control home_css_select" name="home_filtre_membre" id="home_filtre_membre">
                        <option value="0">Toutes les membres</option>
                        <?php
                        while($membre = $req_filtre_membres->fetch(PDO::FETCH_ASSOC)){
                            echo '<option value="'.$membre['id_membre'].'">'.$membre['pseudo'].'</option>';
                        } ?>
                    </select>
                </div>

                <!-- Filtre PRIX -->
                <div class="form-group home_bloc_filtre">
                <label for="Points">Prix</label>
                    <input type="range" id="rangeValue" name="points" min="0" max="100" onchange="rangevalue.value=value">
                    <output id="rangevalue"></output>   

                </div>

            </form>
        </div>
            <div class="col-md-8" id="bloc_liste_annonces">
                <!-- Département filtré par défaut-->
                <?php echo '<p>Annonces publiées sur le département : <strong><span id="home_departement"></span></strong></p>'; ?>
                <small>Nombre de résultats :<?= $annonces_filtrees->rowCount() ?></small>
                <hr>    

                <!-- Tri par prix ASC/DESC -->
                <form id="form_tri_prix" method ="post" action="">
                    <select class="form-control home_css_select" name="home_filtre_prix" id="home_filtre_prix">
                        <option value="1">Trier par prix (du moins cher au plus cher)</option>
                        <option value="2">Trier par prix (du plus cher au moins cher)</option>
                    </select>
                </form>
                <?php
                
                /* AFFICHAGE DES ANNONCES */
                while($ligne = $annonces_filtrees->fetch(PDO::FETCH_ASSOC))
                {
                
               echo '<div class="row">';
                    echo'<div class="col-md-4">';
                            echo '<a target="_blank" href="'.$ligne['url'].'"> <img class="img-thumbnail img-responsive affiche" src="'.$ligne['url'].'" alt="'.$ligne['titre'].'"></a>';
                            echo 'id annonce = '.$ligne['id_annonce'].' - '.$ligne['cp'].'<br>';
                            echo 'id categorie = '.$ligne['categorie_id'].'<br>';
                            echo 'id membre = '.$ligne['membre_id'].'<br>';
                            echo 'Date d\'enregistrement annonce = '.format_dateheure($ligne['date_enregistrement']);
                    echo'</div>';/* fin col-md-4*/
                    
                    echo '<div class="col-md-8 fiche_annonce"><div><h2 class="titre_fiche"><a href="php/front/fiche_annonce.php">'.$ligne['titre'].'</a></h2></div>';
                    echo $ligne['description_longue'].'<br>';
                    echo '<span>'.$ligne['pseudo'].'</a></span>';
                    echo '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
                    echo '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
                    echo '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
                    echo '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
                    echo '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
                    echo '<span class="prix_annonce">'.$ligne['prix'].' €</span><hr>';
                    echo'</div>';/* fin du col-md-8 */
                    
               echo '</div>';/* fin de la row */
               
                }
                echo'<h3 class="text-center voir_plus"><a href="#">Voir plus...</a></h3>';
            ?>
            </div>    
    </div><!-- FIN DU ROW -->
   
            
        
    
<?php } //fin condition selon existence annonce selon dept choisi sur carte?>