<?php
require_once './classes/Config.php';
require_once './classes/Errors.php';
require_once './classes/Db.php';

class FormatInvalidExeption extends Exception
{
}
class File
{

    private string $file;
    private string $name;
    private string $format;
    private string $pathfilePicture;
    private string $error;
    private string $size;
    private string $tmpname;
    private $db;


    /**
     * Undocumented function
     *
     * @param string $name
     * @param string $format
     * @param string $error
     * @param string $size
     * 
     * @throws FormatInvalidExeption Vérifie le format pour une photo
     */
    //CONSTANTE
    const DIR_TARGET_PICTURE_PROFILE = './uploads/picture_profile/';


    public function __construct(string $name, string $format, string $error, string $size, string $tmpname)
    {

        if ($this->checkFormatPicture($name) === false) {
            throw new FormatInvalidExeption(Errors::getCodes(Config::ERR_FORMAT_PICTURE));
        }

        $this->name = $name;
        $this->format = $format;
        $this->pathfilePicture = $this->getPathFilePictureProfile();
        $this->error = $error;
        $this->tmpname = $tmpname;
        $this->size = $size;
        $this->db = new Db();

        var_dump($this->tmpname);
        var_dump($this->pathfilePicture);
        if (move_uploaded_file($this->tmpname, $this->pathfilePicture)) {
            echo 'fichier enregistré ';
        } else {
            echo 'Probleme';
        }
    }

    /*********************************** FONCTIONS ************************************************ */

    /**
     * Retourne le chemin du fichier pour les fichier
     *
     * @return string
     */
    private function getPathFilePictureProfile(): string
    {
        return self::DIR_TARGET_PICTURE_PROFILE . basename($this->name);
    }




    /*********************************** REQUETE SQL************************************************ */
    /**
     * Insertion des fichier dans la bdd
     *
     * @return void
     */
    public function InsertFileBDD()
    {
        $querry = 'INSERT INTO files (name, format, path_file, size, datecreated) 
        VALUES (:name, :format, :path_file, :size, NOW())';

        // $conn = $this->db->conn->getdb->connect();

        $co = $this->db->getConnect();
        $r = $co->prepare($querry);

        // var_dump($r);
        $r->bindParam(':name', $this->name, PDO::PARAM_STR);
        $r->bindParam(':format', $this->format, PDO::PARAM_STR);
        $r->bindParam(':path_file', $this->pathfilePicture, PDO::PARAM_STR);
        $r->bindParam(':size', $this->size, PDO::PARAM_STR);

        //test verrification
        try {
            $r->execute();
        } catch (PDOException $e) {
            $errorMessagedb =  $e->getMessage();
        }
    }

    /**
     * Récupère le chemin d'un fichier
     *
     * @throws  PDOExeption Si erreur de recuperation du chemin du fichier
     * @return string
     */
    public function getPathFile(): string
    {
        $querry = '';

        $r = $this->db->conn->prepare($querry);

        if ($r->execute()) {
            return $r->fetch();
        } else {
            throw new PDOException('Impossible de récupérer le chemin du fichier !');
        }
    }


    /*********************** FONCTION *********************************/

    /**
     * Valid le format des images
     *
     * @param string $name
     * @return boolean
     */
    public function checkFormatPicture(string $name): bool
    {
        $format = explode('.', $name);
        echo $format[1];
        return in_array($format[1], Config::FORMAT_PICTURE);
    }


    /*********************** GETERS *********************************/
}
