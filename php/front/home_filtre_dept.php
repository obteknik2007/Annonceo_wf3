<?php require_once('../../php_inc/init.php');
$dept = substr($_POST['dept'],-2,2);

//je regarde si des annonces existent pour ce dept
$req_dept = $pdo->prepare("SELECT id_annonce FROM annonce WHERE SUBSTR(cp,1,2) = :dept");
$req_dept->execute(array('dept' => $dept));

//résultat, alors suite page, sinon retour réponse ajax
if($req_dept->rowCount() == 0){
    echo 'ko';
} else {
    echo 'ok';
}


?>