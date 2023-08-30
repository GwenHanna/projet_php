<?php
require_once './classes/DbFrench.php';
class Address
{
    private $db;

    public function __construct()
    {
        try {
            $this->db = new DbFrench();
        } catch (ConnectionInvalidExeption $c) {
            $errorConnectBdd = $c->getMessage();
        };
    }


    /**
     * Return un tableau de zip code
     *
     * @return array
     */
    public function getZipcodes(): array
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
    public function getCitys(): array
    {
        // $db = new DbFrench();
        try {
            $connexion = $this->db->getConnect();
            $r = $connexion->prepare('SELECT `ville_nom` FROM `villes_france_free` LIMIT 10');
            $r->execute();

            $citys = array_column($r->fetchAll(), 'ville_nom');
            return $citys;
        } catch (ConnectionInvalidExeption $e) {
            $errorMessageConnect = $e->getMessage();
            var_dump($errorMessageConnect);
        }
    }
}
