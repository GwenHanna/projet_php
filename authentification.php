<header>
    <?php
    require_once './layout/header.php';

    ?>
</header>
<?php

require_once './classes/Uploadfile.php';
require_once './classes/Errors.php';

if (isset($_POST['register_submit_two'])) {
    var_dump($_POST);
}



try {

    $picture = new Uploadfile($_FILES['fileName']['name'], $_FILES['fileName']['type'], $_FILES['fileName']['tmp_name'], $_FILES['fileName']['error'], $_FILES['fileName']['size']);
} catch (FormatInvalidExeption $p) {

    Utils::redirect('singnin.php?error=' . Errors::ERR_FORMAT_PICTURE);
} ?>


<h1>Téléchargement réussi</h1>
<footer>
    <?php require_once './layout/footer.php' ?>
</footer>