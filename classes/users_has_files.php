<?php
require_once './classes/Db.php';

class Users_has_files
{



    static function InsertIdUserAndIdFile(int $idUser, int $idFile, $db)
    {
        $querry = 'INSERT INTO users_has_files (Users_id, Files_id )
        VALUES (:userid, :fileid);';
        $r = $db->conn->prepare($querry);

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
}
