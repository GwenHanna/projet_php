<?php
require_once './classes/Db.php';

//Connection a la base de donnée
$instance = Db::getInstance();
$db = $instance->getConnect();
