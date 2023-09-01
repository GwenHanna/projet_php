<?php
require_once './classes/Config.php';
require_once './classes/Errors.php';
require_once './init/init.php';

class FormatInvalidExeption extends Exception
{
}
class File
{

    //CONSTANTE
    const DIR_TARGET_PICTURE_PROFILE = './uploads/picture_profile/';

    private string $file;
    private string $name;
    private string $format;
    private string $pathfilePicture;
    private string $error;
    private string $size;
    private string $tmpname;
    private $dbInstance;


    /**
     * Undocumented function
     *
     * @param  PDO $db
     * @throws FormatInvalidExeption Vérifie le format pour une photo
     */

    public function __construct(Db $dbInstance, string $name, string $format, string $error, string $size, string $tmpname)
    {

        if ($this->isFormatPictureConfirmed($name) === false) {
            throw new FormatInvalidExeption(Errors::getCodes(Config::ERR_FORMAT_PICTURE));
        }

        $this->dbInstance = $dbInstance;
        $this->name = $name;
        $this->format = $format;
        $this->pathfilePicture = $this->getProfilePicturePath();
        $this->error = $error;
        $this->tmpname = $tmpname;
        $this->size = $size;

        if (move_uploaded_file($this->tmpname, $this->pathfilePicture)) {
            echo 'fichier enregistré ';
        } else {
            echo 'Probleme';
        }
    }

    /*********************************** FONCTIONS ************************************************ */

    /**
     * Retourne le chemin du fichier
     *
     * @return string
     */
    private function getProfilePicturePath(): string
    {
        return self::DIR_TARGET_PICTURE_PROFILE . basename($this->name);
    }




    /*********************************** REQUETE SQL************************************************ */
    /**
     * Insertion des fichier dans la bdd
     *
     * @throws PDOException
     */
    public function InsertFileDb(): void
    {
        $query = 'INSERT INTO files (name, format, path_file, size, datecreated) 
        VALUES (:name, :format, :path_file, :size, NOW())';


        $r = $this->dbInstance->getConnect()->prepare($query);

        // var_dump($r);
        $r->bindValue(':name', $this->name, PDO::PARAM_STR);
        $r->bindValue(':format', $this->format, PDO::PARAM_STR);
        $r->bindValue(':path_file', $this->pathfilePicture, PDO::PARAM_STR);
        $r->bindValue(':size', $this->size, PDO::PARAM_STR);

        //test verrification

        $r->execute();
    }

    /**
     * Récupère le chemin d'un fichier
     *
     * @throws  PDOExeption Si erreur de recuperation du chemin du fichier
     * @return string
     */
    static function getFilePath(int $userId, Db $dbInstance): string
    {
        $query = 'SELECT files.path_file FROM `users_has_files` INNER JOIN files ON files.id = users_has_files.Files_id INNER JOIN users ON users.id = users_has_files.Users_id WHERE users.id =:userId';

        $r = $dbInstance->getConnect()->prepare($query);
        $r->bindValue(':userId', $userId);
        $r->execute();
        $res = $r->fetch(PDO::FETCH_ASSOC);
        $path = $res['path'];
        return $path;
    }


    /*********************** FONCTION *********************************/

    /**
     * Valid le format des images
     *
     * @param string $name
     * @return boolean
     */
    private function isFormatPictureConfirmed(string $name): bool
    {
        $format = explode('.', $name);
        echo $format[1];
        return in_array($format[1], Config::FORMAT_PICTURE);
    }


    /*********************** GETERS *********************************/
}
