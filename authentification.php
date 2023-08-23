<?php
// var_dump($errorMessageConnect);

require_once './classes/Uploadfile.php';
require_once './classes/Config.php';
require_once './classes/Utils.php';
require_once './classes/User.php';
require_once './classes/Db.php';

if (isset($_POST['register_submit_two'])) {

    try {
        $picture = new Uploadfile($_FILES['fileName']['name'], $_FILES['fileName']['type'], $_FILES['fileName']['tmp_name'], $_FILES['fileName']['error'], $_FILES['fileName']['size']);

        $db = new Db();
        $connexion = $db->getConnect();
        $user = new User($db);
        var_dump($_POST);
        if (isset($_POST['register_submit_two'])) {
            $user->InsertCoordannateDetails($_POST['bio'], $_POST['address'], $_POST['locality'], $_POST['zipcode'], $_POST['birthday']);
        }
        // $user->InsertCoordannateDetails()

    } catch (FormatInvalidExeption $p) {
        Utils::redirect('singnin.php?error=' . Config::ERR_FORMAT_PICTURE);
    } catch (PDOException $p) {
        $errorMessageConnect = $p->getMessage();
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