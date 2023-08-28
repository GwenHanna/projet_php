<?php
require_once './classes/Config.php';
class Db
{
    private $conn = null;

    /**
     * Connect BDD function
     *
     * @throws Exception
     * @return PDO
     */
    public function getConnect(): PDO
    {
        if ($conn == null) {

            try {
                $this->conn = new PDO("mysql:host=" . Config::HOST . ";dbname=" . Config::DB_NAME_APP, Config::USER_NAME, Config::PASSWORD);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $exception) {
                throw new Exception($exception->getMessage());
            }
        }

        return $this->conn;
    }
}
