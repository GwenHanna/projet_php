<?php
class Errors
{
    public const ERR_CONNECT_EMAIL = 1;
    public const ERR_CONNECT_PASS = 2;
    public const ERR_VALIDATION_EMAIL = 3;
    public const ERR_SPAM_EMAIL = 4;

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
            default:
                $res = 'Autre Erreur';
                echo $code;

                break;
        }
        return $res;
    }
}
