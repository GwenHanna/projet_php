<?php
require_once './classes/Email.php';
require_once './classes/Password.php';
require_once './init/init.php';

if (isset($_POST['connect'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    try {

        $emailInstance = new Email($email, $instance);
        $isEmailInDb = $emailInstance->isEmailDb($email);
        if ($isEmailInDb  === false) {
            Utils::redirect('conection.php?error=' . Config::ERR_CONNECT_EMAIL);
            exit;
        }
        $newPass = new Password($pass);

        if ($emailInstance->isConfirmedConnection($pass) === true) {
            $user = new User($instance);
            //Connexion se l'utilisateur
            $user->connect($email, $pass);
        };

        Utils::redirect('profile.php');
    } catch (EmailAlreadyBdd $e) {
        echo 'ok';
        Utils::redirect('conection.php?error=' . Config::ERR_ALREADY_EMAIL);
        exit;
    } catch (EmailValidationException $e) {
        Utils::redirect('conection.php?error=' . Config::ERR_VALIDATION_EMAIL);
        exit;
    } catch (EmailSpamExeption $e) {
        Utils::redirect('conection.php?error=' . Config::ERR_SPAM_EMAIL);
        exit;
    } catch (PasswordInvalidExeption $e) {
        Utils::redirect('conection.php?error=' . Config::ERR_VALIDATE_PASS);
        exit;
    }
}
