<?php

require_once './classes/Uploadfile.php';
require_once './classes/Config.php';
require_once './classes/Utils.php';

if (isset($_POST['register_submit_two'])) {

    try {
        $picture = new Uploadfile($_FILES['fileName']['name'], $_FILES['fileName']['type'], $_FILES['fileName']['tmp_name'], $_FILES['fileName']['error'], $_FILES['fileName']['size']);
    } catch (FormatInvalidExeption $p) {
        Utils::redirect('singnin.php?error=' . Config::ERR_FORMAT_PICTURE);
    }
}

?>

<header>
    <?php
    require_once './layout/header.php';
    ?>
</header>
<h1>Téléchargement réussi</h1>
<a href="connexion.php">Se connecter</a>
<footer>
    <?php require_once './layout/footer.php' ?>
</footer>