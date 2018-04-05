<?php require_once('php_inc/init.php');

//MAJ pseudo
if(isset($_POST['champ']) && $_POST['champ'] == 'pseudo' && isset($_POST['value_pseudo'])){
    $value_pseudo = secure_field($_POST['value_pseudo']);

    $req = $pdo->prepare("UPDATE membre SET pseudo = :pseudo WHERE id_membre=:id_membre");
    $req->execute(array(
        'pseudo' => $value_pseudo,
        'id_membre' => $_SESSION['membre']['id_membre']));

    //retour ajax
    echo 'ok';
}

//MAJ nom
if(isset($_POST['champ']) && $_POST['champ'] == 'nom' && isset($_POST['value_nom'])){
    $value_nom = secure_field($_POST['value_nom']);

    $req = $pdo->prepare("UPDATE membre SET nom = :nom WHERE id_membre=:id_membre");
    $req->execute(array(
        'nom' => $value_nom,
        'id_membre' => $_SESSION['membre']['id_membre']));

    //retour ajax
    echo 'ok';
}

//MAJ prénom
if(isset($_POST['champ']) && $_POST['champ'] == 'prenom' && isset($_POST['value_prenom'])){
    $value_prenom = secure_field($_POST['value_prenom']);

    $req = $pdo->prepare("UPDATE membre SET prenom = :prenom WHERE id_membre=:id_membre");
    $req->execute(array(
        'prenom' => $value_prenom,
        'id_membre' => $_SESSION['membre']['id_membre']));

    //retour ajax
    echo 'ok';
}

//MAJ email
if(isset($_POST['champ']) && $_POST['champ'] == 'email' && isset($_POST['value_email'])){
    $value_email = secure_field($_POST['value_email']);

    $req = $pdo->prepare("UPDATE membre SET email = :email WHERE id_membre=:id_membre");
    $req->execute(array(
        'email' => $value_email,
        'id_membre' => $_SESSION['membre']['id_membre']));

    //retour ajax
    echo 'ok';
}

//MAJ telephone
if(isset($_POST['champ']) && $_POST['champ'] == 'telephone' && isset($_POST['value_telephone'])){
    $value_telephone = secure_field($_POST['value_telephone']);

    $req = $pdo->prepare("UPDATE membre SET telephone = :telephone WHERE id_membre=:id_membre");
    $req->execute(array(
        'telephone' => $value_telephone,
        'id_membre' => $_SESSION['membre']['id_membre']));

    //retour ajax
    echo 'ok';
}

//MAJ civilité
if(isset($_POST['champ']) && $_POST['champ'] == 'civilite' && isset($_POST['value_civilite'])){
    $value_civilite = secure_field($_POST['value_civilite']);

    $req = $pdo->prepare("UPDATE membre SET civilite = :civilite WHERE id_membre=:id_membre");
    $req->execute(array(
        'civilite' => $value_civilite,
        'id_membre' => $_SESSION['membre']['id_membre']));

    //retour ajax
    echo 'ok';
}
?>