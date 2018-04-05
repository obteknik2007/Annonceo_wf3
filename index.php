<?php
require_once('php_inc/init.php');

//header
require_once('php_inc/header.php');

//-------------------------//
//nb d'annnonces en stock
$req = $pdo->query("SELECT COUNT(id_annonce) FROM annonce");
$res = $req->fetch(PDO::FETCH_ASSOC);
$nb_annonces = $res['COUNT(id_annonce)'];
?>

<div class="row" id="section_login">
    <div class="col-md-12 text-right">
        <?php if(estConnecte()){echo '<span id="index_login"><strong>Bonjour '.$_SESSION['membre']['prenom'].' '.$_SESSION['membre']['nom'].'</strong></span>'; }?>
    </div>
</div>

<div class="row">
    <div class="col-md-4"> <!-- BLOC GAUCHE -->
        <div class="box-content" style="width: 100%; height: 571px;">      
            <!-- Texte -->
            <p><span id="index_nb_annonces"><?=$nb_annonces ?> annonces</span> disponibles sur <span id="index_marque">Annonceo</span> !</p>

            <!-- Button 'publier annonce' -->
            <button id="index_btn_publier" class="btn btn-primary center-block"><a style="color:yellow;text-decoration:none;" href="php/front/publier_annonce.php">Publier une annonce</a></button>
            <!--<button id="index_btn_publier" class="btn btn-primary btn-md center-block">Publier votre annonce</button>-->
            <div class="clearfix"></div>

            <!-- encart publicitaire http://via.placeholder.com/250x350?text=encart_publicitaire -->
            <img id="index_encart_pub" src="assets/img/250x350_encart_publicitaire.png" alt="Encart publicitaire" class="img-responsive">

        </div>
    </div>
    <div class="col-md-8"> <!-- BLOC DROIT -->
        <div class="box-content"> 
            <p><span id="index_titre_carte">Choisissez votre département...</span></p>
            <hr><br>
            <div id="map" style="width: 100%; height: 500px;margin: 0 auto;"></div>
        </div>
    </div>
</div> <!-- fin row -->





<?php 
//footer
require_once('php_inc/footer.php');
?>