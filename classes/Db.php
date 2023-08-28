<?php
require_once './classes/Config.php';
class Db
{
    private static $instance = null;
    private $conn = null;

    private function __construct()
    {
    }

    /**
     * Undocumented function
     *
     * @return Db
     */
    public static function getInstance(): Db
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Connect BDD function
     *
     * @return  PDO
     * @throws Exception
     */
    public function getConnect(): PDO
    {
        if ($this->conn == null) {

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
