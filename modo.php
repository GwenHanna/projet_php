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
        $publications =  Publication::getPublications($instance);
    } catch (PDOException $th) {
        $errorMessageConnect = $th->getMessage();
        var_dump($errorMessageConnect);
        exit;
    }
}

?>
<section>
    <main>
        <form class="form-modo" action="approuvalPublication.php" method="post">
            <?php foreach ($publications as $p) {
                if ($p['approval_status'] === 0) { ?>
                    <span>
                        <?php
                        $check = ($p['approval_status'] == 1) ? "checked" : "";
                        ?>
                        <input type="checkbox" name="media_<?php echo $p['id'] ?>" id="<?php echo $p['id'] ?>" <?php $check; ?> />
                    </span>
            <?php require './assets/templates/post.php';
                }
            } ?>
            <input class="btn-delete-publication" type="submit" value="Supprimer">
        </form>
    </main>
</section>

<?php require_once './layout/footer.php' ?>