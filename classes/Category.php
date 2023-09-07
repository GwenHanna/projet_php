<?php
require_once './init/init.php';

class Category
{

    public function __construct()
    {
    }

    /**
     * Undocumented function
     *
     * @param Db $dbInstance
     * @throws PDOException 
     * @return array
     */
    public function getCategoriesDb(Db $dbInstance): array
    {
        $query = "SELECT categories.name, categories.id, categories.path FROM categories ";

        $r = $dbInstance->getConnect()->prepare($query);
        $r->execute();
        $categories = $r->fetchAll(PDO::FETCH_ASSOC);
        return $categories;
    }

    static function getMaxIdCategory(Db $dbInstance): int
    {
        $query = "SELECT MAX(id) FROM categories";

        $r = $dbInstance->getConnect()->prepare($query);
        $r->execute();
        $idMax = $r->fetch();
        return intval($idMax);
    }
}
