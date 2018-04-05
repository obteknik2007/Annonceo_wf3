<?php
require_once('php_inc/init.php');

//header
require_once('php_inc/header.php');

if(estConnecte()){
    $contenu .= 'Bonjour '.$_SESSION['membre']['prenom'].' '.$_SESSION['membre']['nom'];
}
echo $contenu;
?>
<div class="box-content">
    <div id="map" style="width: 800px; height: 550px;margin: 0 auto;"></div>
</div>



<?php 
//footer
require_once('php_inc/footer.php');
?>