<?php require_once('../../php_inc/init.php');

if(isset($_POST['content_search'])){
    $content_search = secure_field($_POST['content_search']);
}

//recherche 'contient' dans le titre ou la description longue des annonces
$sql_search = "SELECT 
ANN.id_annonce,
ANN.titre,
ANN.description_courte,
ANN.prix,
MIN(PHO.date_enregistrement)
FROM annonce ANN
INNER JOIN photo PHO ON PHO.annonce_id = ANN.id_annonce
WHERE titre LIKE '%".$content_search."%'
GROUP BY ANN.id_annonce";
$req_search = $pdo->prepare($sql_search);
$req_search->execute();

//retour ajax
$tab = array();
$tab['nb_annonces'][]= $req_search->rowCount();
if($req_search->rowCount() > 0){

    echo 'BLOC DES ANNONCES TROUVEES = '.$tab['nb_annonces'][0];
} else {
    echo 'message d\'absence d\'annonces trouvées';
}
?>