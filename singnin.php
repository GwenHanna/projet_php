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

    if (isset($user) && isset($_POST['submit-register'])) {

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

    <form class="form-control d-flex flex-column justify-content-center mx-auto w-75" method="post" action="">
        <fieldset class="">
            <legend>Coordonée</legend>
            <div class="form-group d-sm-flex name">
                <p class="col-sm-6">
                    <input <?php if (isset($firstname)) { ?> value="<?php echo $firstname ?>" <?php } ?> class="form-control" type="text" name="firstname" id="firstNameUser" placeholder="Prénom" required>
                </p>
                <p class="col-sm-6">
                    <input <?php if (isset($lastname)) { ?> value="<?php echo $lastname ?>" <?php } ?> class="form-control" type="text" name="lastname" id="lastNameUser" placeholder="Nom" required>
                </p>
            </div>
            <div class="form-group d-sm-flex email">
                <p class="col-sm-12">
                    <input <?php if (isset($email)) { ?> value="<?php echo $email ?>" <?php } ?> class="form-control" type="text" name="email" id="emailUser" placeholder="Email : toto@gmail.fr" required>
                    <?php if (isset($errorMessageEmail)) { ?>
                        <span class="error"><?php echo $errorMessageEmail ?></span>
                    <?php } ?>
                </p>
            </div>

            <div class="form-group d-sm-flex pass-word">
                <p class="col-sm-12">
                    <input class="form-control" type="text" name="password" id="passwordUser" placeholder="Mot de passe" required>
                    <?php if (isset($errorMessagePassword)) { ?>
                        <span class="error">
                            <?php echo $errorMessagePassword ?>
                        </span>
                    <?php } ?>
                </p>
            </div>
            <div class="form-group d-sm-flex pass-check">
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
        </fieldset>
    </form>

<?php } elseif ($_SESSION['pagination-form-sign-in'] === 2 || isset($_GET['error'])) { ?>
    <form class="form-control d-flex flex-column justify-content-center mx-auto w-75" method="post" action="authentification.php" enctype="multipart/form-data">
        <fieldset class="p-4">
            <legend>Complément d'informations </legend>

            <!-- Biography -->
            <div class="form-group d-sm-flex bio">
                <p class="col-sm-12">
                    <textarea class="w-100" name="bio" id="bioUser" cols="30" d-sm-flexs="10" placeholder="Votre parcours chez Human Booster ..."></textarea>
                </p>
            </div>

            <div class="form-group newsletter">
                <p class="form-goupe d-flex justify-content-center w-100 p-2">
                    <label class="p-1" for="newsletter">Inscrivez vous à la newletter</label>
                    <input class="p-1" type="checkbox" name="newsletter" id="newsletter">
                </p>
            </div>

            <div class="form-group group-newletter">

                <p class="col-12 address">
                    <label for="addresseUser">Votre Adresse</label>
                    <input class="col-12" type="text" name="address" id="addressUser">
                </p>
                <div class="form-group d-sm-flex justify-content-aroud align-items-end">

                    <?php if (count($city) > 0) { ?>
                        <p class="col-6 city">
                            <label for="localityUser">Ville</label>
                            <select class="col-12" name="locality" id="localityUser">
                                <?php foreach ($city[0] as $c) { ?>
                                    <option value="<?php echo $c ?>"><?php echo $c ?></option>
                                <?php } ?>
                            </select>
                        </p>
                    <?php } ?>

                    <p class="col-6 zipcode">
                        <label for="zipcode">Code postal</label>
                        <input class="col-12" type="text" name="zipcode" id="zipcode">
                    </p>
                </div>

                <p class="col-6 birthday">
                    <label for="birthdayUser">Votre anniverssaire</label>
                    <input class="col-12" type="date" name="birthday" id="birthdayUser" placeholder="Votre date de naissance">
                </p>


                <div class="form-group d-sm-flex picture">
                    <p class="col-sm-6">
                        <input type="file" name="fileName" id="fileUser">
                        <?php if (isset($errorMessageFormatPicture)) { ?>
                            <span class="error"><?php echo $errorMessageFormatPicture ?></span>
                        <?php } ?>
                    </p>
                </div>
            </div>


            <input class="col-12 btn-dark mt-3 mb-3" type="submit" name="register_submit_two" id="" value="Valider votre inscription">
        </fieldset>

    </form>
<?php }

require_once './layout/footer.php';
