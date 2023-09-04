<?php
require_once './init/init.php';
require_once './classes/Publication.php';
require_once './classes/Utils.php';

if (isset($_POST)) {

    $instancePublication = Publication::getPublicationsApprouval($instance);
    foreach ($instancePublication as $p) {
        if (empty($_POST['media_' . $p['id']])) {
            var_dump($p['id']);
            $id = intval($p['id']);
            try {
                Publication::deleteApprouvalPublication($instance, $id);
                Publication::insertPublication($instance, $p['id'], $p['content']);
                var_dump($p);
            } catch (PDOException $th) {
                $erroMessageConnect = $th->getMessage();
                var_dump($erroMessageConnect);
                exit;
            }
        }
    }
}
