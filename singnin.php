<?php
require_once './layout/header.php';
require_once './classes/Email.php';
require_once './classes/Errors.php';
require_once './classes/Utils.php';
require_once './classes/Password.php';
require_once './classes/Uploadfile.php';
require_once './classes/Db.php';
require_once './classes/User.php';

if (isset($_SESSION['user'])) {
    Utils::redirect('profile.php');
}

//Verification des erreur URL
if ((isset($_GET['error']))) {
    $errorMessageFormatPicture =  Errors::getCodes($_GET['error']);
}

$_SESSION['pagination-form-sign-in'] = 1;

if (isset($_POST['submit-register'])) {
    try {

        //Vérification de la validation Email et vérif Spam a la construction de l'instance
        $newEmail = new Email($_POST['email']);

        $valueFirstname = $_POST['firstname'];
        $valueLastname = $_POST['lastname'];
        $valueEmail = $_POST['email'];

        //Vérification Password valid a la construction de l'instance
        $newPassword = new Password($_POST['password']);

        //Vérifier si l'email n'est pas deja présente dans la BDD
        if ($newEmail->isEmailBDD($_POST['email']) === true) {
            $errorMessageEmail = Errors::getCodes(Errors::ERR_ALREADY_EMAIL);
        }

        //Vérifier si l'email de confirmation est identique au premier mot de pass
        if ($newPassword->isConfirmedPassword($_POST['password'], $_POST['passcheck']) === false) {
            $errorMessagePasswordCheck = Errors::getCodes(Errors::ERR_CONFIRMED_PASS);
            $valuePass = $_POST['password'];
        } else {
            $_SESSION['pagination-form-sign-in'] = 2;
        }
    } catch (EmailValidationException $e) {
        $errorMessageEmail = $e->getMessage();
    } catch (EmailSpamExeption $s) {
        $errorMessageEmail = $s->getMessage();
    } catch (PasswordInvalidExeption $p) {
        $errorMessagePassword = $p->getMessage();
    }

    $db = new Db();
    $u = new User($db);
    $u->InsertCoordannat($_POST['firstname'], $_POST['lastname'], $newEmail->getEmail(), $newPassword->getPasswordHash());

    var_dump($newPassword->getPasswordHash());
    var_dump(password_verify('sdfJHJK54153:', $newPassword->getPasswordHash()));
    var_dump($u->InsertCoordannat($_POST['firstname'], $_POST['lastname'], $newEmail->getEmail(), $newPassword->getPasswordHash()));
}

?>

<?php if ($_SESSION['pagination-form-sign-in'] == 1 && !isset($_GET['error'])) { ?>

    <form class="container" method="post" action="">
        <div class="row name">
            <p class="col-sm-3">
                <input <?php if (isset($valueFirstname)) { ?> value="<?php echo $valueFirstname ?>" <?php } ?> class="form-control" type="text" name="firstname" id="firstNameUser" placeholder="Prénom" required>
            </p>
            <p class="col-sm-3">
                <input <?php if (isset($valueLastname)) { ?> value="<?php echo $valueLastname ?>" <?php } ?> class="form-control" type="text" name="lastname" id="lastNameUser" placeholder="Nom" required>
            </p>
        </div>
        <div class="row email">
            <p class="col-sm-6">
                <input <?php if (isset($valueEmail)) { ?> value="<?php echo $valueEmail ?>" <?php } ?> class="form-control" type="text" name="email" id="emailUser" placeholder="Email : toto@gmail.fr" required>
                <?php if (isset($errorMessageEmail)) { ?>
                    <span class="error"><?php echo $errorMessageEmail ?></span>
                <?php } ?>
            </p>
        </div>

        <div class="row pass-word">
            <p class="col-sm-6">
                <input <?php if (isset($valuePass)) { ?> value="<?php echo $valuePass ?>" <?php } ?> class="form-control" type="text" name="password" id="passwordUser" placeholder="Mot de passe" required>
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
                <?php if (isset($errorMessagePasswordCheck)) { ?>
                    <span class="error">
                        <?php echo $errorMessagePasswordCheck ?>
                    </span>
                <?php } ?>
            </p>
        </div>
        <input type="submit" name="submit-register" id="" value="Suivant">
    </form>

<?php } elseif ($_SESSION['pagination-form-sign-in'] === 2 || isset($_GET['error'])) { ?>
    <form method="post" action="authentification.php" enctype="multipart/form-data">
        <legend>Complément d'informations </legend>

        <div class="row">
            <p class="col-sm-6">
                <textarea name="bio" id="bioUser" cols="30" rows="10" placeholder="Votre parcours chez Human Booster ...">

            </textarea>
            </p>
        </div>
        <p class="col-sm-6">
            <input type="file" name="fileName" id="fileUser">
            <?php if (isset($errorMessageFormatPicture)) { ?>
                <span class="error"><?php echo $errorMessageFormatPicture ?></span>
            <?php } ?>
        </p>
        </div>
        <input type="submit" name="register_submit_two" id="" value="Valider votre inscription">
    </form>
<?php }

require_once './layout/footer.php';
