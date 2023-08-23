<?php
require_once './layout/header.php';
require_once './classes/Email.php';
require_once './classes/Errors.php';
require_once './classes/Config.php';
require_once './classes/Utils.php';
require_once './classes/Password.php';
require_once './classes/Uploadfile.php';
require_once './classes/Db.php';
require_once './classes/User.php';
require_once './functions/ville.php';

if (isset($_SESSION['user'])) {
    Utils::redirect('profile.php');
}

//Verification des erreur URL
if ((isset($_GET['error']))) {
    $errorMessageFormatPicture =  Errors::getCodes($_GET['error']);
}

//Récupération des villes de france
$city[] = getCity();


//Init pagination
$_SESSION['pagination-form-sign-in'] = 1;

if (isset($_POST['submit-register'])) {
    try {
        $lastname = $_POST['lastname'];
        $firstname = $_POST['firstname'];

        //Vérification de la validation Email et vérif Spam a la construction de l'instance
        $newEmail = new Email($_POST['email']);
        $newEmail->isEmailBDD($_POST['email']);
        $email = $_POST['email'];

        //Vérification Password valid a la construction de l'instance
        $newPassword = new Password($_POST['password']);
        $pass = $_POST['password'];


        //Vérifier si le passwordcheck est identique au premier mot de pass
        $newPassword->isConfirmedPassword($_POST['password'], $_POST['passcheck']);

        //Connection a la base de donnée
        $db = new Db();
        $connexion = $db->getConnect();

        //Nouvelle instance de User
        $user = new User($connexion);

        //Pagination form 2
        $_SESSION['pagination-form-sign-in'] = 2;
    } catch (EmailValidationException $e) {
        $errorMessageEmail = $e->getMessage();
    } catch (EmailSpamExeption $s) {
        $errorMessageEmail = $s->getMessage();
    } catch (EmailAlreadyBdd $b) {
        $errorMessageEmail = $b->getMessage();
    } catch (PasswordInvalidExeption $p) {
        $errorMessagePassword = $p->getMessage();
    } catch (PasswordIsNotConfirmedExeption $c) {
        $errorMessagePasswordCheck = $c->getMessage();
    };

    if (isset($user)) {

        try {
            //Insertion valeur user form coordonnée
            $user->InsertCoordannat($firstname, $lastname, $email, $pass);
        } catch (EmailInvalidInsertionExeption $i) {
            Utils::redirect('singnin.php?error=' . Config::ERR_INSERT_USER);
        }
    }
}

?>

<?php if ($_SESSION['pagination-form-sign-in'] == 1 && !isset($_GET['error'])) { ?>

    <form class="d-flex flex-column justify-content-center mx-auto w-75" method="post" action="">
        <div class="d-sm-flex name">
            <p class="col-sm-6">
                <input <?php if (isset($firstname)) { ?> value="<?php echo $firstname ?>" <?php } ?> class="form-control" type="text" name="firstname" id="firstNameUser" placeholder="Prénom" required>
            </p>
            <p class="col-sm-6">
                <input <?php if (isset($lastname)) { ?> value="<?php echo $lastname ?>" <?php } ?> class="form-control" type="text" name="lastname" id="lastNameUser" placeholder="Nom" required>
            </p>
        </div>
        <div class="d-sm-flex email">
            <p class="col-sm-12">
                <input <?php if (isset($email)) { ?> value="<?php echo $email ?>" <?php } ?> class="form-control" type="text" name="email" id="emailUser" placeholder="Email : toto@gmail.fr" required>
                <?php if (isset($errorMessageEmail)) { ?>
                    <span class="error"><?php echo $errorMessageEmail ?></span>
                <?php } ?>
            </p>
        </div>

        <div class="d-sm-flex pass-word">
            <p class="col-sm-12">
                <input class="form-control" type="text" name="password" id="passwordUser" placeholder="Mot de passe" required>
                <?php if (isset($errorMessagePassword)) { ?>
                    <span class="error">
                        <?php echo $errorMessagePassword ?>
                    </span>
                <?php } ?>
            </p>
        </div>
        <div class="d-sm-flex pass-check">
            <p class="col-sm-12">
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
    <form class="d-flex flex-column justify-content-center mx-auto w-75" method="post" action="authentification.php" enctype="multipart/form-data">
        <legend>Complément d'informations </legend>

        <div class="d-sm-flex birthday">
            <input class="col-3" type="date" name="birthday" id="birthdayUser" placeholder="Votre date de naissance">
        </div>

        <?php if (count($city) > 0) { ?>
            <div class="d-sm-flex locality">
                <select name="locality" id="localityUser" class="col-3">
                    <?php foreach ($city[0] as $c) { ?>
                        <option value="<?php echo $c ?>"><?php echo $c ?></option>
                    <?php } ?>
                </select>
            </div>
        <?php } ?>

        <div class="d-sm-flex bio">
            <p class="col-sm-6">
                <textarea name="bio" id="bioUser" cols="30" d-sm-flexs="10" placeholder="Votre parcours chez Human Booster ...">

            </textarea>
            </p>
        </div class="d-sm-flex picture">
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
