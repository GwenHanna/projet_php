<?php
require_once './classes/Config.php';
class Success
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
            Config::SUCC_INSERT_PUBLICATION => 'Votre publication a bien été enregistrer !',
            default => "Autre Suuccess"
        };

        return $result;
    }
}
