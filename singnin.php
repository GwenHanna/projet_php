<?php
require_once './layout/header.php';
require_once './classes/Email.php';
require_once './classes/Errors.php';
require_once './classes/Config.php';
require_once './classes/Utils.php';
require_once './classes/Password.php';
require_once './classes/File.php';
require_once './classes/Db.php';
require_once './classes/User.php';
require_once './classes/Address.php';
require_once './classes/users_has_files.php';


if (isset($_SESSION['user'])) {
    Utils::redirect('profile.php');
}

//Verification des erreur URL
if ((isset($_GET['error']))) {
    $errorMessageFormatPicture =  Errors::getCodes($_GET['error']);
}

//Récupération des villes de france
$newAddress = new Address();
$city = $newAddress->getCity();
$zipcode = $newAddress->getZipcode();

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

        //PHOT DE PROFIL


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
            //Insertion des id de user et id de file
            $user->InsertCoordannat($firstname, $lastname, $email, $pass);

            //Insertion valeur user form coordonnée sEnregistre l'id du nouvel utilisateur
            $lastIdUser = $db->conn->lastInsertId();

            if (isset($_FILES['fileName']) && !empty($_FILES['fileName']) && $_FILES['fileName']['error'] === 0) {
                var_dump($_FILES['fileName']);
                $picture = new File($_FILES['fileName']['name'], $_FILES['fileName']['type'], $_FILES['fileName']['error'], $_FILES['fileName']['size'], $_FILES['fileName']['tmp_name']);
                $picture->InsertFileBDD();
                $lastIdFile = (int)Users_has_files::getLastIdFile($db)['MAX(id)'];
                Users_has_files::InsertIdUserAndIdFile($lastIdUser, $lastIdFile, $db);
            }
        } catch (EmailInvalidInsertionExeption $i) {
            Utils::redirect('singnin.php?error=' . Config::ERR_INSERT_USER);
        } catch (FormatInvalidExeption $f) {
            $errorMessageFormatPicture = $f->getMessage();
        }
    }
}

?>

<?php if ($_SESSION['pagination-form-sign-in'] == 1 && !isset($_GET['error'])) { ?>

    <form class="form-control d-flex flex-column justify-content-center mx-auto w-75" method="post" action="" enctype="multipart/form-data">
        <fieldset class="">
            <legend>Coordonée</legend>
            <!-- NAME -->
            <div class="form-group d-sm-flex name">
                <p class="col-sm-6">
                    <input <?php if (isset($firstname)) { ?> value="<?php echo $firstname ?>" <?php } ?> class="form-control" type="text" name="firstname" id="firstNameUser" placeholder="Prénom" required>
                </p>
                <p class="col-sm-6">
                    <input <?php if (isset($lastname)) { ?> value="<?php echo $lastname ?>" <?php } ?> class="form-control" type="text" name="lastname" id="lastNameUser" placeholder="Nom" required>
                </p>
            </div>
            <!-- EMAIL -->
            <div class="form-group d-sm-flex email">
                <p class="col-sm-12">
                    <input <?php if (isset($email)) { ?> value="<?php echo $email ?>" <?php } ?> class="form-control" type="text" name="email" id="emailUser" placeholder="Email : toto@gmail.fr" required>
                    <?php if (isset($errorMessageEmail)) { ?>
                        <span class="error"><?php echo $errorMessageEmail ?></span>
                    <?php } ?>
                </p>
            </div>
            <!-- PICTURE -->
            <div class="form-group d-sm-flex picture">
                <p class="col-sm-6">
                    <input type="file" name="fileName" id="fileUser">
                    <?php if (isset($errorMessageFormatPicture)) { ?>
                        <span class="error"><?php echo $errorMessageFormatPicture ?></span>
                    <?php } ?>
                </p>
            </div>
            <!-- PASS WORD -->
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
            <!-- NEWS LETTER CHECKBOX -->
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
            <!-- SUBMIT -->
            <input type="submit" name="submit-register" id="" value="Suivant">
        </fieldset>
    </form>

<?php } elseif ($_SESSION['pagination-form-sign-in'] === 2 || isset($_GET['error'])) { ?>
    <form class="form-control d-flex flex-column justify-content-center mx-auto w-75" method="post" action="authentification.php">
        <fieldset class="p-4">
            <legend>Complément d'informations </legend>

            <!-- BIOGRAPHY -->
            <div class="form-group d-sm-flex bio">
                <p class="col-sm-12">
                    <textarea class="w-100" name="bio" id="bioUser" cols="30" d-sm-flexs="10" placeholder="Votre parcours chez Human Booster ..."></textarea>
                </p>
            </div>

            <!-- NEWS LETTER -->
            <div class="form-group newsletter">
                <p class="form-goupe d-flex justify-content-center w-100 p-2">
                    <label class="p-1" for="newsletter">Inscrivez vous à la newletter</label>
                    <input class="p-1" type="checkbox" name="newsletter" id="newsletter">
                </p>
            </div>

            <div class="form-group group-newletter">

                <!-- ADRESSE -->
                <p class="col-12 address">
                    <label for="addresseUser">Votre Adresse</label>
                    <input class="col-12" type="text" name="address" id="addressUser">
                </p>
                <div class="form-group d-sm-flex justify-content-aroud align-items-end">

                    <!-- CITY -->
                    <?php if (count($city) > 0) { ?>
                        <p class="col-6 city">
                            <label for="localityUser">Ville</label>
                            <select class="col-12" name="locality" id="localityUser">
                                <?php foreach ($city as $c) { ?>
                                    <option value="<?php echo $c ?>"><?php echo $c ?></option>
                                <?php } ?>
                            </select>
                        </p>
                    <?php } ?>

                    <!-- ZIP CODE -->
                    <?php if (count($zipcode) > 0) { ?>
                        <p class="col-6 zipcode">
                            <label for="zipcode">Code postal</label>

                            <select class="col-12" name="zipcode" id="zipcodeUser">
                                <?php foreach ($zipcode as $z) { ?>
                                    <option value="<?php echo $z ?>"><?php echo $z ?></option>
                                <?php } ?>
                            </select>
                        </p>
                    <?php } ?>

                </div>

                <p class="col-6 birthday">
                    <label for="birthdayUser">Votre anniverssaire</label>
                    <input class="col-12" type="date" name="birthday" id="birthdayUser" placeholder="Votre date de naissance">
                </p>



            </div>


            <input class="col-12 btn-dark mt-3 mb-3" type="submit" name="register_submit_two" id="" value="Valider votre inscription">
        </fieldset>

    </form>
<?php }

require_once './layout/footer.php';
