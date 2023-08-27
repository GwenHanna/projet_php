<?php
require_once './classes/User.php';
require_once './classes/Errors.php';
require_once './classes/Db.php';
require_once './classes/Password.php';
require_once './classes/Email.php';


$getErrorMessage = '';

if (isset($_GET['error'])) {
    $codeError = intval($_GET['error']);
    $getErrorMessage = Errors::getCodes($codeError);
}



if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['pass']) && !empty($_POST['pass'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    try {
        $newEmail = new Email($email);
        $newEmail->isEmailBDD($newEmail->getEmail());

        $newPass = new Password($pass);
    } catch (EmailAlreadyBdd $e) {
        $errorMess = $e->getMessage();
    } catch (EmailValidationException $e) {
        $errorMess = $e->getMessage();
    } catch (EmailSpamExeption $e) {
        $errorMess = $e->getMessage();
    }
}
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    var_dump($user);
}


?>

<header>
    <?php require_once './layout/header.php' ?>
</header>

<fieldset>
    <legend>Connexion</legend>

    <form class="container" method="post" action="">

        <div class="row mb-5">
            <input class="form-control" type="text" name="email" id="email" placeholder="ex : toto@gmail.fr">
            <?php if ($getErrorMessage && $codeError == 1) { ?>
                <span class="danger"><?php echo $getErrorMessage ?></span>
            <?php } ?>
        </div>

        <div class="row mb-5">
            <input class="form-control" type="text" name="pass" id="pass" placeholder="Mot de passe">
            <?php if ($getErrorMessage && $codeError == 2) { ?>
                <span class="danger"><?php echo $getErrorMessage ?></span>
            <?php } ?>
        </div>

        <button class="btn" type="submit">Connexion</button>
    </form>
</fieldset>

<footer>
    <?php require_once './layout/footer.php' ?>
</footer>