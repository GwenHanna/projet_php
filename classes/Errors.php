<?php
require_once './classes/Utils.php';
class Errors
{
    public const ERR_CONNECT_EMAIL = 1;
    public const ERR_CONNECT_PASS = 2;
    public const ERR_VALIDATION_EMAIL = 3;
    public const ERR_SPAM_EMAIL = 4;
    public const ERR_ALREADY_EMAIL = 5;
    public const ERR_VALIDATE_PASS = 6;

    /**
     * Error function
     *
     * @param integer Code d'erreur
     * @return string
     */
    static function getCodes(int $code): string
    {
        $res = '';
        switch ($code) {
            case 1:
                $res = 'Vous devez vous inscrire';
                break;
            case 2:
                $res = 'Votre mot de passe est incorect';
                break;
            case 3:
                $res = "Votre Email n'est pas valide";
                break;
            case 4:
                $res = "Cet Email est un spam !";
                break;
            case 5:
                $res = "Cet Email est déja présente";
                break;
            case 6:
                $res = "Ce mot de passe doit contenir 8 caractère minimum, une majuscule, une minucule, un chiffre et un caractère spécial";
                break;
            default:
                $res = 'Autre Erreur';
                echo $code;

                break;
        }
        return $res;
    }
}
