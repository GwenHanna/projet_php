<?php
require_once './classes/Db.php';
require_once './classes/User.php';
require_once './classes/Email.php';
require_once './classes/Users_has_files.php';

//Connection a la base de donnée
$instance = Db::getInstance();
$db = $instance->getConnect();

//Instance User
$user = User::getInstance($instance);
//Instance Users_has_files
$file = Users_has_files::getInstance($instance);
