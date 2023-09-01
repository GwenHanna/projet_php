<?php
require_once './init/init.php';
function insertApprouvalPublication(Db $db): void
{
    $query = '';

    $r = $db->getConnect()->prepare($query);
    $r->execute();
}
