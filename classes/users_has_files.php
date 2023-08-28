<?php
require_once './init/init.php';

class Users_has_files
{
    private Db $dbInstance;
    private static Users_has_files|null $fileInstance = null;

    public function __construct(Db $dbInstance)
    {
        $this->dbInstance = $dbInstance;
    }

    /**
     * Undocumented function
     *
     * @return Users_has_files
     */
    static function getInstance(Db $db): Users_has_files
    {
        if (self::$fileInstance === null) {
            return new self($db);
        }
        return self::$fileInstance;
    }

    public function InsertIdUserAndIdFile(int $idUser, int|null $idFile)
    {
        $querry = 'INSERT INTO users_has_files (Users_id, Files_id )
        VALUES (:userid, :fileid);';
        $r = $this->dbInstance->getConnect()->prepare($querry);

        $r->bindParam(':userid', $idUser, PDO::PARAM_STR);
        $r->bindParam(':fileid', $idFile);

        //test verrification
        try {
            $r->execute();
        } catch (PDOException $e) {
            $errorMessageConnect =  $e->getMessage();
            var_dump($errorMessageConnect);
        }
    }

    static function getLastIdFile($db)
    {
        $querry = 'SELECT MAX(id) FROM files';

        $r = $db->getConnect()->prepare($querry);
        try {
            $r->execute();
            $res = $r->fetch();
            $lastIdFile = $res;
            var_dump($lastIdFile);
            return $lastIdFile;
        } catch (PDOException $e) {
            $errorMessageConnect =  $e->getMessage();
            var_dump($errorMessageConnect);
        }
    }
}
