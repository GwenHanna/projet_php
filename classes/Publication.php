<?php
require_once './init/init.php';
class Publication
{
    private $db;
    private $content;
    private $createDate;
    private $media;
    private $category;

    public function __construct(
        Db $db,
        string $media,
        string $category = '',
        string $content = ''
    ) {
        $this->db = $db;
        $this->media = $media;
        $this->content = $content;
    }

    /**
     * Undocumented function
     *
     * @throws PDOExeption
     */
    static function upGradePublication(Db $db, int $publicationId): void
    {
        $query = 'UPDATE publications SET approval_status = 1 WHERE publications.id = :idPublication';

        $r = $db->getConnect()->prepare($query);
        $r->bindValue('idPublication', $publicationId, PDO::PARAM_INT);
        $r->execute();
    }

    /**
     * Undocumented function
     *
     * @throws PDOExeption
     */
    public function insertPublication(int $userId): array
    {
        $query = 'INSERT INTO publications (Users_id, content, media, dateCreated) VALUES (:userId, :content, :media, NOW())';

        $r = $this->db->getConnect()->prepare($query);

        $r->bindValue(':userId', $userId, pdo::PARAM_INT);
        $r->bindValue(':content', $this->content, PDO::PARAM_STR);
        $r->bindValue(':media', $this->media, PDO::PARAM_STR);

        $r->execute();
        $publications = $r->fetchAll(PDO::FETCH_COLUMN);

        return $publications;
    }

    /**
     * Undocumented function
     * @throws PDOException 
     */
    public function joinCategoryPublication(Db $dbInstance, int $idPublication, int $idCategory): void
    {
        $query = "INSERT INTO `publications_has_categories` (Publications_id, Categories_id) VALUES (:Publications_id, :Categories_id) ";

        $r = $dbInstance->getConnect()->prepare($query);
        $r->bindValue('Publications_id', $idPublication, PDO::PARAM_INT);
        $r->bindValue('Categories_id', $idCategory, PDO::PARAM_INT);
        $r->execute();
    }

    /**
     * Undocumented function
     *
     * @throws PDOExeption
     */
    static function getArticles(Db $db, int $idCategory): array
    {
        $query = 'SELECT * FROM `publications_has_categories` INNER JOIN categories ON categories.id = publications_has_categories.Categories_id INNER JOIN publications ON publications.id = publications_has_categories.Publications_id WHERE Categories_id = :idCategory';
        $r = $db->getConnect()->prepare($query);
        $r->bindValue('idCategory', $idCategory, PDO::PARAM_INT);
        $r->execute();
        $publications = $r->fetchAll(PDO::FETCH_ASSOC);
        return $publications;
    }

    /**
     * Undocumented function
     *
     * @throws PDOExeption
     */
    static function getPublicationsOnHol(Db $db): array
    {
        $query = 'SELECT * FROM publications WHERE publications.approval_status = 0';
        $r = $db->getConnect()->prepare($query);
        $r->execute();
        $publications = $r->fetchAll(PDO::FETCH_ASSOC);
        return $publications;
    }

    /**
     * Undocumented function
     *
     * @throws PDOExeption
     */
    static function getPublications(Db $db): array
    {
        $query = 'SELECT * FROM publications';
        $r = $db->getConnect()->prepare($query);
        $r->execute();
        $publications = $r->fetchAll(PDO::FETCH_ASSOC);
        return $publications;
    }

    /**
     * Undocumented function
     *
     * @throws PDOExeption
     */
    static function getPublicationsUser(Db $db, int $idUser): array
    {
        $query = 'SELECT * FROM publications WHERE Users_id = :idUser';
        $r = $db->getConnect()->prepare($query);
        $r->bindValue('idUser', $idUser);
        $r->execute();
        $publications = $r->fetchAll(PDO::FETCH_ASSOC);
        return $publications;
    }

    /**
     * Undocumented function
     *
     * @throws PDOExeption
     */
    static function deletePublication(Db $db, int $id): void
    {
        $query = 'DELETE FROM `publications` WHERE publications.id = :id';
        $r = $db->getConnect()->prepare($query);
        $r->bindValue('id', $id, PDO::PARAM_INT);
        $r->execute();
    }
}
