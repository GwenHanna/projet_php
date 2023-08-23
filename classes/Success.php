<?php
require_once './classes/Config.php';

class Success
{


    static function getCode(int $code): string
    {
        $res = '';
        switch ($code) {

            case 100:
                $res = "Vous avez été enregistré avec succès !";
                break;

            default:
                $res = "Autre succès";
                break;
        }
        return $res;
    }
}
