<?php require_once './layout/header.php' ?>

<?php

require_once './classes/Utils.php';
require_once './classes/Publication.php';
require_once './init/init.php';

if ($_SESSION['user']['role'] !== 'modo' || $_SESSION['user']['role'] !== 'admin') {
    if (!isset($_SESSION['user'])) {
        Utils::redirect('index.php');
    }

    try {
        $publications =  Publication::getPublicationsApprouval($instance);
    } catch (PDOException $th) {
        $errorMessageConnect = $th->getMessage();
        var_dump($errorMessageConnect);
        exit;
    }
} ?>
<section>
    <main>
        <?php foreach ($publications as $p) {
            require './assets/templates/post.php';
        } ?>
    </main>
</section>

<?php require_once './layout/footer.php' ?>