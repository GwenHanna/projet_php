<?php
require_once './init/init.php';
function get(Db $db): void
{
    $query = '';

    $r = $db->getConnect()->prepare($query);
    $r->execute();
}
