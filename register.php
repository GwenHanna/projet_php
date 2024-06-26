<?php
require_once './layout/header.php';
require_once './classes/Errors.php';
require_once './classes/Config.php';
require_once './classes/Utils.php';
require_once './classes/Address.php';


if (isset($_SESSION['user'])) {
    Utils::redirect('profile.php');
}

//Verification des erreur URL
if ((isset($_GET['error']))) {

    $codeError = intval($_GET['error']);

    if ($codeError >= 1 && $codeError <= 50) {
        $errorMessageEmail = Errors::getCodes($codeError);
    } elseif ($codeError >= 51 && $codeError <= 100) {
        if ($codeError === 53) {
            $errorMessagePasswordCheck = Errors::getCodes($codeError);
        }
        $errorMessagePass = Errors::getCodes($codeError);
    } elseif ($codeError === 101) {
        $errorMessageFormatPicture = Errors::getCodes($codeError);
    }
}


if (isset($_GET['success']) && !isset($codeError)) {
    $_SESSION['pagination'] = 2;
} else {
    $_SESSION['pagination'] = 1;
}


//Récupération des villes de france
$newAddress = new Address();
$citys = $newAddress->getCitys();
$zipcodes = $newAddress->getZipcodes();

?>

<section>
    <main>
        <?php if ($_SESSION['pagination'] === 1) { ?>

            <form class="form-control d-flex flex-column justify-content-center mx-auto w-75" method="post" action="register_process.php" enctype="multipart/form-data">
                <fieldset class="">
                    <legend>Coordonées</legend>
                    <!-- NAME -->
                    <div class="form-group d-sm-flex name">
                        <p class="col-sm-6">
                            <input value="" class="form-control" type="text" name="firstname" id="firstNameUser" placeholder="Prénom" required>
                        </p>
                        <p class="col-sm-6">
                            <input value="" class="form-control" type="text" name="lastname" id="lastNameUser" placeholder="Nom" required>
                        </p>
                    </div>
                    <!-- EMAIL -->
                    <div class="form-group d-sm-flex email">
                        <p class="col-sm-12">
                            <input value="" class="form-control" type="email" name="email" id="emailUser" placeholder="Email : toto@gmail.fr" required>
                            <?php if (isset($errorMessageEmail)) { ?>
                                <span class="error"><?php echo $errorMessageEmail ?></span>
                            <?php } ?>
                        </p>
                    </div>
                    <!-- PICTURE -->
                    <div class="form-group d-sm-flex picture">
                        <p class="col-sm-6">
                            <label class="custom-file-upload" for="fileUser">Téléchargement Photo</label>
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
                            <?php if (isset($errorMessagePass)) { ?>
                                <span class="error">
                                    <?php echo $errorMessagePass ?>
                                </span>
                            <?php } ?>
                        </p>
                    </div>
                    <!-- PASS WORD CHECK -->
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

        <?php } elseif ($_SESSION['pagination'] === 2) { ?>
            <form class="form-control d-flex flex-column justify-content-center mx-auto w-75" method="post" action="register_process.php">
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

                            <!-- CITYs -->
                            <?php if (count($citys) > 0) { ?>
                                <p class="col-6 citys">
                                    <label for="localityUser">Ville</label>
                                    <select class="col-12" name="locality" id="localityUser">
                                        <?php foreach ($citys as $c) { ?>
                                            <option value="<?php echo $c ?>"><?php echo $c ?></option>
                                        <?php } ?>
                                    </select>
                                </p>
                            <?php } ?>

                            <!-- ZIP CODE -->
                            <?php if (count($zipcodes) > 0) { ?>
                                <p class="col-6 zipcodes">
                                    <label for="zipcodes">Code postal</label>

                                    <select class="col-12" name="zipcodes" id="zipcodesUser">
                                        <?php foreach ($zipcodes as $z) { ?>
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
        <?php } ?>
    </main>
</section>
<?php require_once './layout/footer.php'; ?>