<!-- MODAL INSCRIPTION -->
<div class="modal fade" id="ModalFormInscription" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title">S'inscrire</h4>
            </div>
            <div class="modal-body">
                <!-- erreurs form-->
                <?=$contenu; ?>

                <!-- FORMULAIRE D'INSCRIPTION -->
                <div id="inscription_erreurs"></div>
                <!-- zone erreurs -->
                <form novalidate method="post" class="form-horizontal" action="">
                    <!-- pseudo -->
                    <div class="form-group">
                        <label for="pseudo_inscription" class="col-sm-4 control-label">Pseudo :</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="pseudo_inscription" name="pseudo_inscription" placeholder="Votre pseudo..." value="<?=$_POST['pseudo_inscription'] ?? '' ?>" required autocus>
                        </div>
                    </div>

                    <!-- mot de passe -->
                    <div class="form-group">
                        <label for="mdp_inscription" class="col-sm-4 control-label">Mot de passe :</label>
                        <div class="col-sm-5">
                            <input type="password" class="form-control" id="mdp_inscription" name="mdp_inscription" placeholder="Votre mot de passe..." required >
                        </div>
                    </div>

                    <!-- civilité -->
                    <div class="form-group">
                        <label for="civilite" class="col-sm-4 control-label">Civilité :</label>
                        <div class="col-sm-5 pull-left">
                            Monsieur <input type="radio" id="civilite" name="civilite" value="m" <?=((isset($_POST['civilite']) 
                            && $_POST['civilite'] == 'm')) || !isset($_POST['civilite']) ? 'checked' : ''?>>
                                Madame <input type="radio"  id="civilite" name="civilite" value="f" <?=((isset($_POST['civilite']) 
                            && $_POST['civilite'] == 'f')) ? 'checked' : ''?>>
                        </div>
                    </div>

                    <!-- prénom -->
                    <div class="form-group">
                        <label for="prenom" class="col-sm-4 control-label">Prénom :</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Votre prénom..." value="<?=$_POST['prenom'] ?? '' ?>">
                        </div>
                    </div>

                    <!-- nom -->
                    <div class="form-group">
                        <label for="nom" class="col-sm-4 control-label">Nom :</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="nom" name="nom" placeholder="Votre nom..." value="<?=$_POST['nom'] ?? '' ?>">
                        </div>
                    </div>

                    <!-- email -->
                    <div class="form-group">
                        <label for="email" class="col-sm-4 control-label">Email :</label>
                        <div class="col-sm-5">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Votre email..." value="<?=$_POST['email'] ?? '' ?>">
                        </div>
                    </div>

                    <!-- telephone -->
                    <div class="form-group">
                        <label for="telephone" class="col-sm-4 control-label">Téléphone :</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="telephone" name="telephone" placeholder="Votre n° de telephone..." value="<?=$_POST['telephone'] ?? '' ?>">
                        </div>
                    </div>

            </div> <!-- /.modal-body -->
            <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
            <button type="submit" id="inscription" name="inscription" class="btn btn-primary">S'inscrire</button>
            </form> <!-- FIN FORMULAIRE INSCRIPTION -->
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->