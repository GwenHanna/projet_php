<?php
require_once './init/init.php';

class Users_has_files
{
    private Db $dbInstance;

    public function __construct(Db $dbInstance)
    {
        $this->dbInstance = $dbInstance;
    }


    public function InsertIdUserAndIdFile(int $idUser, int|null $idFile)
    {
        $query = 'INSERT INTO users_has_files (Users_id, Files_id )
        VALUES (:userid, :fileid);';
        $r = $this->dbInstance->getConnect()->prepare($query);

        $r->bindValue(':userid', $idUser, PDO::PARAM_STR);
        $r->bindValue(':fileid', $idFile);

        //test verrification
        try {
            $r->execute();
        } catch (PDOException $e) {
            $errorMessageConnect =  $e->getMessage();
            var_dump($errorMessageConnect);
        }
    }

    public function getLastIdFile($db)
    {
        $query = 'SELECT MAX(id) FROM files';

        $r = $db->getConnect()->prepare($query);
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
