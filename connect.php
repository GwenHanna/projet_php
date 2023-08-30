<?php
require_once './classes/Email.php';
require_once './init/init.php';
require_once './classes/Password.php';

if (isset($_POST['connect'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    echo 'ok';
    try {

        $emailInstance = new Email($email, $instance);

        //Vérification du mot de pass
        $newPass = new Password($pass);
        $emailInstance->isConfirmedConnection($pass);

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
}
