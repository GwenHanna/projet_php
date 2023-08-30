<?php
require_once './classes/Email.php';
require_once './init/init.php';
require_once './classes/Password.php';

if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['pass']) && !empty($_POST['pass'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    try {

        $emailInstance = new Email($email, $instance);

        //Vérification du mot de pass
        $newPass = new Password($pass);
        $emailInstance->isVerificationConnexion($pass);

        $user = new User($instance);
        $user->connect($email, $pass);
        Utils::redirect('profile.php');
    } catch (EmailAlreadyBdd $e) {
        Utils::redirect('register.php?error=' . Config::ERR_ALREADY_EMAIL);
    } catch (EmailValidationException $e) {
        Utils::redirect('connexion.php?error=' . Config::ERR_VALIDATION_EMAIL);
        exit;
    } catch (EmailSpamExeption $e) {
        Utils::redirect('connexion.php?error=' . Config::ERR_SPAM_EMAIL);
        exit;
    } catch (PasswordInvalidExeption $e) {
        Utils::redirect('connexion.php?error=' . Config::ERR_VALIDATE_PASS);
        exit;
    }
} else {
    Utils::redirect('connexion.php');
}
