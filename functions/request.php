<?php
require_once './init/init.php';

function getUserById(int $idUser, Db $db)
{
    $query = 'SELECT users.firstname FROM users WHERE users.id = :idUser ';

    try {
        $r = $db->getConnect()->prepare($query);
        $r->bindValue('idUser', $idUser, pdo::PARAM_INT);
        $r->execute();
        $user = $r->fetch(PDO::FETCH_COLUMN);
    } catch (PDOException $th) {
        var_dump($th->getMessage());
    }

    return $user;
}
