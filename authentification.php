<?php
if (isset($errorMessageConnect)) {
    var_dump($errorMessageConnect);
}

require_once './classes/Config.php';
require_once './classes/Utils.php';
require_once './classes/User.php';
require_once './classes/Db.php';
require_once './classes/File.php';


// var_dump($_FILES['fileName']);

if (isset($_POST['register_submit_two'])) {
    $db = new Db();
    $connexion = $db->getConnect();
    try {



        //Cone=nexion BDD


        $user = new User($db);

        if (isset($_POST['register_submit_two'])) {

            //Modification de la date en string
            $formattedBirthday = date("Y-m-d", strtotime($_POST['birthday']));

            //Update de l'utilisateur a l'inscription sans newsletter
            if (!isset($_POST['newsletter']) && isset($_POST['bio'])) {
                $user->InsertCoordannateDetails($_POST['bio']);
            } else {
                //Update de l'utilisateur a l'inscription avec newsletter
                $user->InsertCoordannateDetails($_POST['bio'], $_POST['newsletter'], $_POST['address'], $_POST['locality'], $_POST['zipcode'], $formattedBirthday);
            }
        }
    } catch (FormatInvalidExeption $p) {
        Utils::redirect('singnin.php?error=' . Config::ERR_FORMAT_PICTURE);
    } catch (PDOException $p) {
        $errorMessageConnect = $p->getMessage();
    } catch (EmailInvalidInsertionExeption $i) {
        $errorMessageConnect = $i->getMessage();
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