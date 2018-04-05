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

    ?>
    <h2 class="page-header">Home</h2>
    <div class="row">
        <div class="col-md-4">
            
            <form method="post" action="#">
                <!-- Filtre CATEGORIE -->
                <div class="form-group home_bloc_filtre">
                    <label for="home_filtre_categorie">Catégorie</label>
                    <select class="form-control home_css_select" name="home_filtre_categorie" id="home_filtre_categorie">
                        <option value="#">Toutes les catégories</option>
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
                        <option value="#">Toutes les départements</option>
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
                        <option value="#">Toutes les membres</option>
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
        <div class="col-md-8">
            <!-- Département filtré par défaut-->
            <?php echo '<p>Annonces publiées sur le département : <strong><span id="home_departement"></span></strong></p>'; ?>
            <small>Nombre de résultats : xxxx</small>
            <hr>    

            <!-- Tri par prix ASC/DESC -->
            <form action="">
                <select class="form-control home_css_select" name="home_filtre_prix" id="home_filtre_prix">
                    <option value="1">Trier par prix (du moins cher au plus cher)</option>
                    <option value="2">Trier par prix (du plus cher au moins cher)</option>
                </select>
            </form>

        </div>
    </div>
<?php } //fin condition selon existence annonce selon dept choisi sur carte?>