<?php
class Db
{
    private $host = "host.docker.internal";
    private $userName = "root";
    private $passWord = "";
    private $dbName = "MyComunnityLib";
    public $conn;


    public function getConnect()
    {

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbName, $this->userName, $this->passWord);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Erreur de connexion : " . $exception->getMessage();
        }

        return $this->conn;
    }
}
