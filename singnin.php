<?php

require_once './layout/header.php';
require_once './classes/Email.php';
require_once './classes/Errors.php';

$_SESSION['page'] = 1;

if (isset($_POST['submit-register'])) {
    try {
        $x = new Email($_POST['email']);
        $errorMessage = '';
    } catch (EmailValidationException $e) {
        $errorMessage = $e->getMessage();
    } catch (EmailSpamExeption $s) {
        $errorMessage = $s->getMessage();
    }
}

?>

<?php if ($_SESSION['page'] == 1) { ?>

    <form class="container" method="post" action="">

        <div class="row name">
            <p class="col-sm-3">
                <input class="form-control" type="text" name="firstname" id="firstNameUser" placeholder="Prénom" required>
            </p>
            <p class="col-sm-3">
                <input class="form-control" type="text" name="lastname" id="lastNameUser" placeholder="Nom" required>
            </p>
        </div>
        <div class="row email">
            <p class="col-sm-6">
                <input class="form-control" type="text" name="email" id="emailUser" placeholder="Email : toto@gmail.fr" required>
                <?php if (isset($errorMessage)) { ?>
                    <span><?php echo $errorMessage ?></span>
                <?php } ?>
            </p>
        </div>

        <div class="row pass-word">
            <p class="col-sm-6">
                <input class="form-control" type="text" name="password" id="passwordUser" placeholder="Mot de passe" required>
            </p>
        </div>
        <div class="row pass-check">
            <p class="col-sm-6">
                <input class="form-control" type="text" name="passcheck" id="passchecklUser" placeholder="Confirmation mot de passe" required>
            </p>
        </div>
        <input type="submit" name="submit-register" id="" value="Suivant">
    </form>

<?php }

require_once './layout/footer.php';
