<?php
require_once './classes/Errors.php';


class PasswordInvalidExeption extends Exception
{
}
class Password
{

    const PASS_VALID = '~^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#%^&*()\-_=+{}[\]:;<>.,?/]).{8,}$~';
    /**
     * Construction de l'instance Password
     *
     * @param string $password
     * @throws PasswordInvalidExeption Vérification du mot de pass
     */
    public function __construct(string $password)
    {

        if (filter_var($password, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => self::PASS_VALID))) === false) {
            throw new PasswordInvalidExeption(Errors::getCodes(Errors::ERR_VALIDATE_PASS));
        }
    }
}
