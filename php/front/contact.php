<?php
require_once('../../php_inc/init.php');
//header
require_once('../../php_inc/header.php');
?>
<h2 class="page-header">Formulaire de contact</h2>
<div class="container-center">
    <form method="post" action="#" class="form-horizontal">
        <!-- Email -->
        <div class="form-group">
            <label for="email" class="col-sm-2 control-label">Email :</label>
            <div class="col-sm-9">
                <input type="email" class="form-control" id="email" name="email" placeholder="Votre email..." value="<?=$_POST['email'] ?? '' ?>" required autofocus>
            </div>
        </div>

        <!-- Objet -->
        <div class="form-group">
            <label for="objet" class="col-sm-2 control-label">Objet :</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="objet" name="objet" placeholder="Votre objet..." value="<?=$_POST['objet'] ?? '' ?>" required>
            </div>
        </div>

        <!-- Objet -->
        <div class="form-group">
            <label for="msg" class="col-sm-2 control-label">Message :</label>
            <div class="col-sm-9">
                <textarea required class="form-control" rows="10" cols="8" name="msg" id="msg" placeholder="Votre message ici..."><?=$_POST['objet'] ?? '' ?></textarea>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-12">
                <button class="btn btn-primary center-block">Envoyer votre demande</button>
            </div>
        </div>
    </form>
</div>

<?php

//header
require_once('../../php_inc/footer.php');
?>