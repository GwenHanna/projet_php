<?php
require_once './classes/Config.php';
class Errors
{

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
                $res = "Cet Email est déja présent";
                break;
            case 6:
                $res = "Ce mot de passe doit contenir 8 caractère minimum, une majuscule, une minucule, un chiffre et un caractère spécial";
                break;
            case 7:
                $res = "Ce mot de passe doit être identique";
                break;
            case 8:
                $res = "Le format accepter sont '.jpg', '.jpeg', 'png'";
                break;
            case 9:
                $res = "Echec d'enregistrement !";
                break;

            default:
                $res = 'Autre Erreur';
                echo $code;

                break;
        }
        return $res;
    }
}
