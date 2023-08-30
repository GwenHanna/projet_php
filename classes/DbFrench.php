<?php
require_once './classes/Config.php';

class ConnectionInvalidExeption extends Exception
{
}

class DbFrench
{

    public $conn;

    /**
     * Connect BDD function
     *
     * @throws ConnectionInvalidExeption
     * @return PDO
     */
    public function getConnect(): PDO
    {

        try {
            $this->conn = new PDO("mysql:host=" . Config::HOST . ";dbname=" . Config::DB_NAME_CITY, Config::USER_NAME, Config::PASSWORD);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            throw new ConnectionInvalidExeption("Erreur de connexion : " . $exception->getMessage());
        }

        return $this->conn;
    }
}
