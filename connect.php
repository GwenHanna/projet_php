<?php
require_once './classes/Email.php';
require_once './init/init.php';
require_once './classes/Password.php';

if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['pass']) && !empty($_POST['pass'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    try {

        $emailInstance = new Email($_POST['email'], $instance);
        if ($emailInstance->isEmailBDD() === false) {
            $getErrorMessage = Errors::getCodes(Config::ERR_NOT_SIGN_IN);
        }

        //Vérification du mot de pass
        $newPass = new Password($pass);
        $emailInstance->isVerificationConnexion($pass);

        $user->connect($email, $pass);
        Utils::redirect('connexion.php');
    } catch (EmailValidationException $e) {
        Utils::redirect('connexion.php?error=' . Config::ERR_VALIDATION_EMAIL);
    } catch (EmailSpamExeption $e) {
        Utils::redirect('connexion.php?error=' . Config::ERR_SPAM_EMAIL);
    } catch (PasswordInvalidExeption $e) {
        Utils::redirect('connexion.php?error=' . Config::ERR_VALIDATE_PASS);
    }
}
