<?php
if (isset($errorMessageConnect)) {
    var_dump($errorMessageConnect);
}

//Init instance
require_once './init/init.php';

require_once './classes/Config.php';
require_once './classes/Utils.php';
require_once './classes/Email.php';
require_once './classes/Password.php';
require_once './classes/User.php';
require_once './classes/Db.php';
require_once './classes/File.php';



if (isset($_POST['submit-register'])) {
    try {

        //Vérification de la validation Email et vérif Spam a la construction de l'instance
        $newEmail = Email::getInstance($_POST['email'], $instance);

        if ($newEmail->isEmailBDD($_POST['email']) === true) {
            Utils::redirect('singnin.php?error=' . Config::ERR_ALREADY_EMAIL);
        }
        $email = $_POST['email'];

        //Vérification Password valid a la construction de l'instance
        $newPassword = new Password($_POST['password']);
        $pass = $_POST['password'];

        //Vérifier si le passwordcheck est identique au premier mot de pass
        $newPassword->isConfirmedPassword($_POST['password'], $_POST['passcheck']);

        //Insertion des id de user et id de file
        $lastname = $_POST['lastname'];
        $firstname = $_POST['firstname'];

        $user->InsertCoordannat($firstname, $lastname, $email, $pass);

        $lastIdUser = $db->lastInsertId();

        $_SESSION['pagination'] = 2;
        //File Picture

        if (isset($_FILES['fileName']) && !empty($_FILES['fileName']) && $_FILES['fileName']['error'] === 0) {

            $name = $_FILES['fileName']['name'];
            $type = $_FILES['fileName']['type'];
            $error = $_FILES['fileName']['error'];
            $size = $_FILES['fileName']['size'];
            $tmp_name = $_FILES['fileName']['tmp_name'];

            $picture = new File($instance, $name, $type, $error, $size, $tmp_name);
            $picture->InsertFileBDD();
            $lastIdFile = (int)$file->getLastIdFile($instance)['MAX(id)'];
            var_dump($lastIdFile);

            $file->InsertIdUserAndIdFile($lastIdUser, $lastIdFile);
        }
        Utils::redirect('singnin.php?success=ok');
    } catch (EmailValidationException $e) {
        Utils::redirect('singnin.php?error=' . Config::ERR_VALIDATION_EMAIL);
    } catch (EmailSpamExeption $s) {
        Utils::redirect('singnin.php?error=' . Config::ERR_SPAM_EMAIL);
    } catch (EmailAlreadyBdd $b) {
        Utils::redirect('singnin.php?error=' . Config::ERR_ALREADY_EMAIL);
    } catch (PasswordInvalidExeption $p) {
        $errorMessagePassword = $p->getMessage();
    } catch (PasswordIsNotConfirmedExeption $c) {
        Utils::redirect('singnin.php?error=' . Config::ERR_CONFIRMED_PASS);
    } catch (EmailInvalidInsertionExeption $i) {
        Utils::redirect('singnin.php?error=' . Config::ERR_INSERT_USER);
    } catch (FormatInvalidExeption $f) {
        Utils::redirect('singnin.php?error=' . Config::ERR_FORMAT_PICTURE);
    };
}

if (isset($_POST['register_submit_two'])) {

    try {


        //Modification de la date en string
        $formattedBirthday = date("Y-m-d", strtotime($_POST['birthday']));

        //Update de l'utilisateur a l'inscription sans newsletter
        if (!isset($_POST['newsletter']) && isset($_POST['bio'])) {
            $user->InsertCoordannateDetails($_POST['bio']);
        } else {
            $newsletterOk = true;
            //Update de l'utilisateur a l'inscription avec newsletter
            $user->InsertCoordannateDetails($_POST['bio'], $newsletterOk, $_POST['address'], $_POST['locality'], $_POST['zipcode'], $formattedBirthday);
        }
        Utils::redirect('connexion.php');
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