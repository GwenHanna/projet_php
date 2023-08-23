<?php
require_once './classes/DbVille.php';
class Address
{
    private $db;

    public function __construct()
    {
        try {
            $this->db = new DbVille();
        } catch (ConnectionInvalidExeption $c) {
            $errorConnectBdd = $c->getMessage();
        };
    }


    /**
     * Return un tableau de zip code
     *
     * @return array
     */
    public function getZipcode(): array
    {

        try {
            $connexion = $this->db->getConnect();
            $r = $connexion->prepare('SELECT `ville_code_postal` FROM `villes_france_free` LIMIT 10');
            $r->execute();

            $zipcodes = array_column($r->fetchAll(), 'ville_code_postal');
            return $zipcodes;
        } catch (ConnectionInvalidExeption $e) {
            $errorMessageConnect = $e->getMessage();
        }
    }


    /**
     * Tableau de ville
     *
     * @return array
     */
    public function getCity(): array
    {
        // $db = new DbVille();
        try {
            $connexion = $this->db->getConnect();
            $r = $connexion->prepare('SELECT `ville_nom` FROM `villes_france_free` LIMIT 10');
            $r->execute();

            $city = array_column($r->fetchAll(), 'ville_nom');
            return $city;
        } catch (ConnectionInvalidExeption $e) {
            $errorMessageConnect = $e->getMessage();
            var_dump($errorMessageConnect);
        }
    }
}
