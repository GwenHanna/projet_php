<?php
require_once './classes/Config.php';
class Errors
{

    /**
     * Undocumented function
     *
     * @param integer $code
     * @return string
     */
    static function getCodes(int $code): string
    {
        $result = match ($code) {
            Config::ERR_CONNECT_EMAIL => 'Vous devez vous inscrire',
            Config::ERR_SPAM_EMAIL => 'Cet Email est un spam !',
            Config::ERR_VALIDATION_EMAIL => "Votre Email n'est pas valide",
            Config::ERR_ALREADY_EMAIL => "Cet Email est déja présent",
            Config::ERR_CONNECT_PASS => "Votre mot de passe est incorect",
            Config::ERR_VALIDATE_PASS => "Ce mot de passe doit contenir 8 caractère minimum, une majuscule, une minucule, un chiffre et un caractère spécial",
            Config::ERR_CONFIRMED_PASS => "Ce mot de passe doit être identique",
            Config::ERR_FORMAT_PICTURE => "Le format accepter sont '.jpg', '.jpeg', 'png'",
            Config::ERR_INSERT_USER => "Echec d'enregistrement !",
            Config::ERR_NOT_SIGN_IN => "Vous devez vous inscrire",
            Config::ERR_DOUBLE_FILE => "Un seule type de publication",
            Config::SUCC_INSERT_USER => "Succès",
            default => "Autre Erreur"
        };

        return $result;
    }
}
