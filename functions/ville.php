<?php
require_once './classes/Config.php';
/**
 * Undocumented function
 *
 * @throws PDOException
 * @return PDO
 */
function connBDDCyty(): PDO
{
    try {
        $connexion = new PDO("mysql:host=" . Config::HOST . ";dbname=" . Config::DB_NAME_CITY, Config::USER_NAME, Config::PASSWORD);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $p) {
        echo $p->getMessage();
    }
    return $connexion;
}

function getCity(): array
{
    try {
        $connexion = connBDDCyty();
        $r = $connexion->prepare('SELECT `ville_nom` FROM `villes_france_free` LIMIT 10');
        $r->execute();

        $city = array_column($r->fetchAll(), 'ville_nom');
        return $city;
    } catch (\Throwable $th) {
        //throw $th;
    }
}
