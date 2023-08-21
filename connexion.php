<?php
require_once './classes/User.php';
require_once './classes/Errors.php';

$getErrorMessage = '';

if (isset($_GET['error'])) {
    $codeError = intval($_GET['error']);
    $getErrorMessage = Errors::getCodes($codeError);
}
?>

<header>
    <?php require_once './layout/header.php' ?>
</header>

<fieldset>
    <legend>Connexion</legend>

    <form class="container" method="post" action="profile.php">

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