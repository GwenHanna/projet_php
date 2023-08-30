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
        $settings = parse_ini_file('./db.ini');

        if ($this->conn == null) {

            $host = $settings['HOST'];
            $dbname = $settings['DB_NAME'];
            $username = $settings['USER_NAME'];
            $password = $settings['PASSWORD'];

            try {
                $this->conn = new PDO("mysql:host=" . $host . ";dbname=" . $dbname, $username, $password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $exception) {
                throw new Exception($exception->getMessage());
            }
        }

        return $this->conn;
    }
}
