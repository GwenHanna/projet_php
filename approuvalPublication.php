<?php
require_once './init/init.php';
require_once './classes/Publication.php';
require_once './classes/Utils.php';
require_once './classes/Config.php';

if (isset($_SESSION['user'])) {
    Utils::redirect('profile.php');
}
$instancePublication = Publication::getPublicationsOnHol($instance);

foreach ($_POST as $k => $val) {
    $idCheck = explode('_', $k);
    try {
        Publication::deletePublication($instance, intval($idCheck[1]));
    } catch (PDOException $th) {
        Utils::redirect('modo.php?error=' . $th->getCode());
        exit;
    }
}
foreach ($instancePublication as $key => $value) {
    try {
        Publication::upGradePublication($instance, $value['id']);
    } catch (PDOException $th) {
        Utils::redirect('modo.php?error=' . $th->getCode());
        exit;
    }
};
Utils::redirect('modo.php?' . Config::SUCC_INSERT_PUBLICATION);
