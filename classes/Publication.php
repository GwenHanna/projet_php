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
    public function insertPublicationApprouval(int $userId): void
    {
        $query = "INSERT INTO `pendingapprovalpublication` (`User_id`, `content`, `media`, `dateCreated`) VALUES (:userId, :content, :media, NOW())";

        $r = $this->db->getConnect()->prepare($query);
        $r->bindValue(':userId', $userId, PDO::PARAM_INT);
        $r->bindValue(':content', $this->content, PDO::PARAM_STR);
        $r->bindValue(':media', $this->media, PDO::PARAM_STR);
        $r->execute();
    }

    /**
     * Undocumented function
     *
     * @throws PDOExeption
     */
    static function getPublicationsApprouval(Db $db): array
    {
        $query = 'SELECT * FROM pendingapprovalpublication';
        $r = $db->getConnect()->prepare($query);
        $r->execute();
        $publications = $r->fetchAll(PDO::FETCH_ASSOC);
        return $publications;
    }
}
