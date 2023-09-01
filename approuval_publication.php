<?php
session_start();
require_once './classes/Config.php';
require_once './classes/Errors.php';
require_once './classes/Success.php';
require_once './classes/Utils.php';
require_once './classes/File.php';
require_once './classes/Publication.php';
require_once './init/init.php';

class InvalidErrorPublication extends ErrorException
{

    public function __construct(string $message, int $code)
    {
        parent::__construct($message, $code);
    }
}
$errorMessageConnect = '';
if ($errorMessageConnect) {
    var_dump($errorMessageConnect);
}

if (!isset($_POST)) {
    Utils::redirect('profile.php');
}

//Initialisation du chemin du media soit un fichier télécharger soit une url
if ($_FILES['picturePublication']['error'] == UPLOAD_ERR_OK  && !empty($_POST['linkPublication'])) {
    Utils::redirect('profile.php?error=' . Config::ERR_DOUBLE_FILE);
} elseif ($_FILES['picturePublication']['error'] == UPLOAD_ERR_OK) {

    $dirPathFile = Config::DIR_FILE_PICTURE;

    [
        'name' => $nameFile,
        'full_path' => $fullPath,
        'type' => $type,
        'tmp_name' => $tmpname,
        'error' => $error,
        'size' => $size,
    ] = $_FILES['picturePublication'];

    $media = $dirPathFile . $nameFile;

    try {
        $fileInstance = new File($instance, $nameFile, $type, $error, $size, $tmpname);
        $fileInstance->InsertFileDb();
    } catch (FormatInvalidExeption $th) {
        $errorMessage = $th->getMessage('err');
        exit;
    } catch (PDOException $p) {
        $errorMessage = $th->getMessage('err');
        exit;
    }
} elseif (isset($_POST['linkPublication'])) {

    [
        'linkPublication' => $linkUrl,
    ] = $_POST;

    $dirPathFile = "http://free.pagepeeker.com/v2/thumbs.php?size=m&url=";
    $media = $dirPathFile  . $linkUrl;
}

try {
    $instancePost = new Publication($instance, $media);
    $instancePost->insertPublicationApprouval($_SESSION['user']['id']);
    Utils::redirect('profile.php?success=' . Config::SUCC_INSERT_PUBLICATION);
} catch (PDOException $p) {
    $errorMessageConnect = $p->getMessage();
    echo $errorMessageConnect;
}
