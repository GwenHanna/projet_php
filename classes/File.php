<?php
require_once './classes/Config.php';
require_once './classes/Errors.php';
require_once './classes/Db.php';

class FormatInvalidExeption extends Exception
{
}
class File
{



    // private string $file;
    private string $name;
    private string $format;
    private string $tmpname;
    private string $error;
    private string $size;
    private $conn;


    /**
     * Undocumented function
     *
     * @param string $name
     * @param string $format
     * @param string $tmpname
     * @param string $error
     * @param string $size
     * 
     * @throws FormatInvalidExeption Vérifie le format pour une photo
     */
    public function __construct(string $name, string $format, string $tmpname, string $error, string $size)
    {

        if ($this->checkFormatPicture($name) === false) {
            echo 'ok';
            throw new FormatInvalidExeption(Errors::getCodes(Config::ERR_FORMAT_PICTURE));
        }

        $this->name = $name;
        $this->format = $format;
        $this->tmpname = $tmpname;
        $this->error = $error;
        $this->size = $size;
        $this->conn = new Db();
    }



    /*********************** REQUETE SQL *********************************/




    /**
     * Insertion des fichier dans la bdd
     *
     * @return void
     */
    public function InsertFileBDD()
    {
        $query = 'INSERT INTO files (name, format, tmpname, size, datecreated) 
        VALUES (:name, :format, :tmpname, :size, NOW())';

        $conn = $this->conn->getConnect();
        $r = $conn->prepare($query);
        // var_dump($r);
        $r->bindParam(':name', $this->name, PDO::PARAM_STR);
        $r->bindParam(':format', $this->format, PDO::PARAM_STR);
        $r->bindParam(':tmpname', $this->tmpname, PDO::PARAM_STR);
        $r->bindParam(':size', $this->size, PDO::PARAM_STR);

        //test verrification
        try {
            $r->execute();
        } catch (PDOException $e) {
            $errorMessageConnect =  $e->getMessage();
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
