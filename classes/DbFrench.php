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
        $settings = parse_ini_file('./db.ini');
        [
            'HOST' => $host,
            'DB_NAME_CITY' => $dbname,
            'USER_NAME' => $username,
            'PASSWORD' => $password,
        ] = $settings;

        try {
            $this->conn = new PDO("mysql:host=" . $host . ";dbname=" . $dbname, $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            throw new ConnectionInvalidExeption("Erreur de connexion : " . $exception->getMessage());
        }

        return $this->conn;
    }
}
