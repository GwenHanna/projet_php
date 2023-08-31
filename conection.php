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
}

if (isset($_SESSION['user'])) {
    Utils::redirect('profile.php');
}


?>

<header>
    <?php require_once './layout/header.php' ?>
</header>

<section>
    <main>
        <fieldset>
            <legend>Connexion</legend>

            <form class="container" method="post" action=" conection_process.php">

                <div class="">
                    <label for="">Email</label>
                    <input class="form-control" type="text" name="email" id="email" placeholder="ex : toto@gmail.fr">
                    <?php if (isset($getErrorMessage)) { ?>
                        <span class="danger"><?php echo $getErrorMessage ?></span>
                    <?php } ?>
                </div>

                <div class="">
                    <input class="form-control" type="text" name="pass" id="pass" placeholder="Mot de passe">
                </div>

                <input type="submit" name="connect" id="" value="Connexion">
            </form>
        </fieldset>
    </main>
</section>

<footer>
    <?php require_once './layout/footer.php' ?>
</footer>