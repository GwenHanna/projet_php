<?php
require_once './classes/User.php';
require_once './classes/Errors.php';
require_once './classes/Db.php';
require_once './classes/Password.php';
require_once './classes/Email.php';
require_once './classes/Config.php';
require_once './classes/Errors.php';


$getErrorMessage = '';

if (isset($_GET['error'])) {
    $codeError = intval($_GET['error']);
    $getErrorMessage = Errors::getCodes($codeError);
    var_dump($codeError);
}

if (isset($_SESSION['user'])) {
    Utils::redirect('profile.php');
}


?>

<header>
    <?php require_once './layout/header.php' ?>
</header>

<fieldset>
    <legend>Connexion</legend>

    <form class="container" method="post" action="connect.php">

        <div class="row mb-5">
            <input class="form-control" type="text" name="email" id="email" placeholder="ex : toto@gmail.fr">
            <?php if (isset($getErrorMessage)) { ?>
                <span class="danger"><?php echo $getErrorMessage ?></span>
            <?php } ?>
        </div>

        <div class="row mb-5">
            <input class="form-control" type="text" name="pass" id="pass" placeholder="Mot de passe">
        </div>

        <button class="btn" type="submit">Connexion</button>
    </form>
</fieldset>

<footer>
    <?php require_once './layout/footer.php' ?>
</footer>