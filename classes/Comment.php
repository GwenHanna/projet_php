<?php
require_once './classes/Db.php';
class Comment
{
    private $idUser;
    private $idPublication;
    private $content;
    private $dateCreated;

    public function __construct(int $idUser, int $idPublication, string $content)
    {
        $this->idUser = $idUser;
        $this->idPublication = $idPublication;
        $this->content = $content;
        $this->dateCreated = date("Y-m-d H:i:s");
    }

    static function getCommentArticle(Db $db, int $idPpublication): array
    {
        $query = 'SELECT * FROM `comments` WHERE Publications_id = :idPublication';
        $r = $db->getConnect()->prepare($query);
        $r->bindValue('idPublication', $idPpublication, PDO::PARAM_INT);

        $r->execute();
        $comments = $r->fetchAll(PDO::FETCH_ASSOC);
        return $comments;
    }

    /**
     * @throws PDOException  
     */
    public function insertCommentArticle(Db $db): void
    {
        $query = 'INSERT INTO comments (Users_id, Publications_id, content, dateCreated) VALUES (:Users_id, :Publications_id, :content, :dateCreated)';
        $r = $db->getConnect()->prepare($query);
        $r->bindValue('Users_id', $this->idUser, PDO::PARAM_INT);
        $r->bindValue('Publications_id', $this->idPublication, PDO::PARAM_INT);
        $r->bindValue('content', $this->content, PDO::PARAM_STR);
        $r->bindValue('dateCreated', $this->dateCreated, PDO::PARAM_STR);
        $r->execute();
    }
}
