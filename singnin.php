<?php

require_once './layout/header.php';
require_once './classes/Email.php';
require_once './classes/Errors.php';
require_once './classes/Utils.php';
require_once './classes/Password.php';

if (isset($_SESSION['user'])) {
    Utils::redirect('profile.php');
}


$_SESSION['page'] = 1;

if (isset($_POST['submit-register'])) {
    try {

        //Vérification de la validation Email et vérif Spam a la construction
        $newEmail = new Email($_POST['email']);
        var_dump($newEmail->isEmailBDD($_POST['email']));
        $newPassword = new Password($_POST['password']);

        //Vérifier si l'email n'est pas deja présente dans la BDD
        if ($newEmail->isEmailBDD($_POST['email']) === true) {
            $errorMessageEmail = Errors::getCodes(Errors::ERR_ALREADY_EMAIL);
        } else {
            $_SESSION['page'] = 2;
        }
    } catch (EmailValidationException $e) {
        $errorMessageEmail = $e->getMessage();
    } catch (EmailSpamExeption $s) {
        $errorMessageEmail = $s->getMessage();
    } catch (PasswordInvalidExeption $p) {
        $errorMessagePassword = $p->getMessage();
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
                <?php if (isset($errorMessageEmail)) { ?>
                    <span class="error"><?php echo $errorMessageEmail ?></span>
                <?php } ?>
            </p>
        </div>

        <div class="row pass-word">
            <p class="col-sm-6">
                <input class="form-control" type="text" name="password" id="passwordUser" placeholder="Mot de passe" required>
                <?php if (isset($errorMessagePassword)) { ?>
                    <span class="error">
                        <?php echo $errorMessagePassword ?>
                    </span>
                <?php } ?>
            </p>
        </div>
        <div class="row pass-check">
            <p class="col-sm-6">
                <input class="form-control" type="text" name="passcheck" id="passchecklUser" placeholder="Confirmation mot de passe" required>
            </p>
        </div>
        <input type="submit" name="submit-register" id="" value="Suivant">
    </form>

<?php } elseif ($_SESSION['page'] = 2) { ?>
    <form method="post" action="conexion.php">
        <legend>Complément d'informations </legend>

        <div class="row">
            <p class="col-sm-6">
                <textarea name="bio" id="bioUser" cols="30" rows="10" placeholder="Votre parcours chez Human Booster ...">

            </textarea>
            </p>
        </div>
        <p class="col-sm-6">
            <input type="file" name="file" id="fileUser">
        </p>
        </div>
        <input type="submit" name="register_submit_two" id="" value="Valider votre inscription">
    </form>
<?php }

require_once './layout/footer.php';
