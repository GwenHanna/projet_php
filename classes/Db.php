<?php
class Db
{
    private $host = "host.docker.internal";
    private $userName = "root";
    private $passWord = "";
    private $dbName = "MyComunnityLib";
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
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbName, $this->userName, $this->passWord);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Erreur de connexion : " . $exception->getMessage();
        }

        return $this->conn;
    }
}
