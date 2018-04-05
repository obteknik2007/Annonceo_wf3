<?php 

require_once('../../php_inc/init.php');
$array ='';
//$array = "'categorie_id' => $cat,'dept'  =>  $dept,'membre_id' => $membre";
$where = '';

$cat = $_POST['categorie_id'] ;
$dept = $_POST['dept'];
$dept = substr($dept,-2,2);
$membre = $_POST['membre_id'];

//construction de WHERE

$andCategorie = " ANN.categorie_id = :categorie_id ";
$andDept = " SUBSTR(ANN.cp,1,2) = :dept ";
$andMembre = " ANN.membre_id = :membre_id ";

//$groupby = " GROUP BY ANN.id_annonce";
$groupby ='';
//toutes annonces
if($cat != 0 && $dept != 0 && $membre != 0){ // 3 filtres activés,3 valeurs différentes de 0
    $cas = 1;
    $where = ' WHERE '.$andCategorie.' AND '.$andDept.' AND '.$andMembre.$groupby; 
    $array = "'categorie_id' => $cat,'dept'  =>  $dept,'membre_id' => $membre";

    } elseif($cat == 0 && $dept == 0 && $membre== 0) { // Aucun filtre/tout à 0 => toutes les annonces
        $cas = 2;
        $where = $groupby; 
        $array = "''";

    //FILTRES UNIQUES
    } elseif($cat != 0 && $dept == 0 && $membre == 0) {// Filtre unique = categorie
        $cas = 3;
        $where = ' WHERE '.$andCategorie.$groupby;
        $array = "'categorie_id' => $cat"; 

    } elseif($membre == 0 && $cat == 0 && $dept!= 0) { // Filtre unique = dept
        $cas = 4;
        $where = ' WHERE '.$andDept.$groupby; 
        $array = "'dept'  =>  $dept";

    } elseif($cat == 0 && $dept == 0 && $membre!= 0) { // Filtre unique = membre
        $cas = 5;
        $where = ' WHERE '.$andMembre.$groupby; 
        $array = "'membre_id' => $membre";

    //FILTRES COMBINES
    } elseif($dept == 0 && $cat != 0 && $membre!= 0) { // Filtres = cat/membre
        $cas = 6;
        $where = ' WHERE '.$andCategorie.' AND '.$andMembre.$groupby; 
        $array = "'categorie_id' => $cat,'membre_id' => $membre";

    } elseif($cat == 0 && $dept != 0 && $membre!= 0) { // Filtres = dept/membre
        $cas = 7;
        $where = ' WHERE '.$andDept.' AND '.$andMembre.$groupby; 
        $array = "dept'  =>  $dept,'membre_id' => $membre";

    } elseif($cat != 0 && $dept != 0 && $membre== 0) { // Filtres = cat/dept
        $cas = 8;
        $where = ' WHERE '.$andCategorie.' AND '.$andDept; //.$groupby
        $array = "'categorie_id' => $cat,'dept'  =>  $dept";
}


$orderby = " ORDER BY ANN.date_enregistrement DESC";

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
        PHO.url
        FROM annonce ANN
        
        INNER JOIN photo PHO ON PHO.annonce_id = ANN.id_annonce
        INNER JOIN membre MEM ON MEM.id_membre = ANN.membre_id";

//REQUETE CONSOLIDEE
$sql_list_annonces_conso = $sql_list_annonces.$where;
echo 'CAS = '.$cas.'---';
echo $cat.'//'.$dept.'//'.$membre;
 echo $sql_list_annonces_conso.'<br><br>';
 echo 'SELECT GROUP_BY: '.$sql_list_annonces.$groupby.'<br>';
 echo '-----------------------';
 echo 'WHERE : '.$where.'<br>';
 echo '-----------------------';
 echo 'GROUP : '.$groupby;
 echo '-----------------------';
 echo 'ARRAY EXECUTE ='.$array;
 echo '-----------------------';
 echo 'WHERE : '.$where.'<br>';

//EXECUTION REQUETE
$annonces_filtrees = $pdo->prepare($sql_list_annonces_conso);

/// MODIFIER CONTENU EN FN DES CLAUSES WHERE !!!! ////
/*$annonces_filtrees->execute(array(
    'categorie_id' => $cat,
    'dept'  =>  $dept,
    'membre_id' => $membre));*/
    //$annonces_filtrees->execute(array($array));
    $annonces_filtrees->execute(array($array)); //'dept' => 45

?>
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
                while($annonce = $annonces_filtrees->fetch(PDO::FETCH_ASSOC))
                {
                
               echo '<div class="row">';
                    echo'<div class="col-md-4">';
                            echo '<a target="_blank" href="'.$annonce['url'].'"> <img class="img-thumbnail img-responsive affiche" src="'.$annonce['url'].'" alt="'.$annonce['titre'].'"></a>';
                            echo 'id annonce = '.$annonce['id_annonce'].' - '.$annonce['cp'].'<br>';
                            echo 'id categorie = '.$annonce['categorie_id'].'<br>';
                            echo 'id membre = '.$annonce['membre_id'].'<br>';
                            echo 'Date d\'enregistrement annonce = '.format_dateheure($annonce['date_enregistrement']);
                    echo'</div>';/* fin col-md-4*/
                    
                    echo '<div class="col-md-8 fiche_annonce"><div><h2 class="titre_fiche"><a href="php/front/fiche_annonce.php">'.$annonce['titre'].'</a></h2></div>';
                    echo $annonce['description_longue'].'<br>';
                    echo '<span>'.$annonce['pseudo'].'</a></span>';
                    echo '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
                    echo '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
                    echo '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
                    echo '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
                    echo '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
                    echo '<span class="prix_annonce">'.$annonce['prix'].' €</span><hr>';
                    echo'</div>';/* fin du col-md-8 */
                    
               echo '</div>';/* fin de la row */
               
                }
                echo'<h3 class="text-center voir_plus"><a href="#">Voir plus...</a></h3>';