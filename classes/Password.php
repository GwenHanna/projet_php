<?php
require_once './classes/Errors.php';


class PasswordInvalidExeption extends Exception
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
            throw new PasswordInvalidExeption(Errors::getCodes(Errors::ERR_VALIDATE_PASS));
        }
        //Hash le mot de pass
        $this->passwordHash = password_hash($password, PASSWORD_DEFAULT);
    }


    /**
     * Confirmation mot de pass
     *
     * @param string $password
     * @param string $passwordCheck
     * @return boolean
     */
    public function isConfirmedPassword(string $password, string $passwordCheck): bool
    {
        return $password === $passwordCheck;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }
}
