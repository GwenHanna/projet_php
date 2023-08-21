<?php
class Errors
{
    public const ERR_CONNECT_EMAIL = 1;
    public const ERR_CONNECT_PASS = 2;

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

            default:
                $res = 'Autre Erreur';
                break;
        }
        return $res;
    }
}
