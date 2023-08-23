<?php
require_once './classes/Config.php';
require_once './classes/Errors.php';

class FormatInvalidExeption extends Exception
{
}
class Uploadfile
{



    // private string $file;
    private string $name;
    private string $type;
    private string $tmpname;
    private string $error;
    private string $size;

    /**
     * Undocumented function
     *
     * @param string $name
     * @param string $type
     * @param string $tmpname
     * @param string $error
     * @param string $size
     * 
     * @throws FormatInvalidExeption Vérifie le format pour une photo
     */
    public function __construct(string $name, string $type, string $tmpname, string $error, string $size)
    {

        if ($this->checkFormatPicture($name) === false) {
            echo 'ok';
            throw new FormatInvalidExeption(Errors::getCodes(Config::ERR_FORMAT_PICTURE));
        }

        $this->name = $name;
        $this->type = $type;
        $this->tmpname = $tmpname;
        $this->error = $error;
        $this->size = $size;
    }

    public function checkFormatPicture(string $name): bool
    {
        $format = explode('.', $name);
        echo $format[1];
        var_dump(in_array($format[1], Config::FORMAT_PICTURE));
        return in_array($format[1], Config::FORMAT_PICTURE);
    }
}
