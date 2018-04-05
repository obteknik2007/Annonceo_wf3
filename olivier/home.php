<?php
require_once('../../php_inc/init.php');

//header
require_once('../../php_inc/header.php');

//
$dept =$_GET['dept'];

$contenu .= 'Annonces du département : '.$dept;

$contenu .= 'Membre connecté : '.$_SESSION['membre']['nom'];
?>




<?php
//contenu
echo $contenu;

//footer
require_once('../../php_inc/footer.php');
?>