<?php
require_once './classes/Errors.php';
require_once './classes/Config.php';


class PasswordInvalidExeption extends Exception
{
}

class PasswordIsNotConfirmedExeption extends Exception
{
}
class Password
{

    const PASS_VALID = '~^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#%^&*()\-_=+{}[\]:;<>.,?/]).{8,}$~';

    private string $passwordHash;


    /**
     * Construction de l'instance Password
     *
     * @param string $password
     * @throws PasswordInvalidExeption Vérification du mot de pass
     */
    public function __construct(string $password)
    {

        if (filter_var($password, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => self::PASS_VALID))) === false) {
            throw new PasswordInvalidExeption(Errors::getCodes(Config::ERR_VALIDATE_PASS));
        }
        //Hash le mot de pass
        $this->passwordHash = password_hash($password, PASSWORD_DEFAULT);
    }


    /*********************************** REQUETES *******************************************************/


    /*********************************** FONCTIONS *******************************************************/
    /**
     * Confirmation mot de pass
     *
     * @param string $password
     * @param string $passwordCheck
     * @throws PasswordIsNotConfirmedExeption
     */
    public function isConfirmedPassword(string $password, string $passwordCheck): void
    {
        if ($password !== $passwordCheck) {
            throw new PasswordIsNotConfirmedExeption(Errors::getCodes(Config::ERR_CONFIRMED_PASS));
        }
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }
}
