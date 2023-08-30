<?php
require_once './classes/Db.php';
require_once './classes/User.php';
require_once './classes/Email.php';
require_once './classes/Users_has_files.php';

//Connection a la base de donnée
$instance = Db::getInstance();
// $db = $instance->getConnect();
