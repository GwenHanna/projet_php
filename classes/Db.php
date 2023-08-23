<?php
require_once './classes/Config.php';
class Db
{
    public $conn;

    /**
     * Connect BDD function
     *
     * @throws PDOException
     * @return PDO
     */
    public function getConnect(): PDO
    {

        try {
            $this->conn = new PDO("mysql:host=" . Config::HOST . ";dbname=" . Config::DB_NAME_APP, Config::USER_NAME, Config::PASSWORD);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Erreur de connexion : " . $exception->getMessage();
        }

        return $this->conn;
    }
}
