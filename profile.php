<?php
require_once './layout/header.php';
require_once './init/init.php';
require_once './classes/User.php';
require_once './classes/Publication.php';
require_once './classes/Utils.php';

if (!isset($_SESSION['user'])) {
    Utils::redirect(' conection_process.php');
} else {
    [
        'id' => $idUser
    ] = $_SESSION['user'];
}
?>

<section class="">
    <?php if (isset($_SESSION['user'])) {
        require_once './layout/side-bar-profile.php';
    } ?>
    <main class="">
        <?php
        $publications = Publication::getPublicationsUser($instance, $idUser);
        foreach ($publications as $p) {
            if ($p['approval_status'] === 1) {
                require './assets/templates/post.php';
            }
        }
        ?>

    </main>
    <?php require_once './layout/side-bar.php'; ?>

</section>

<footer>
    <?php require_once './layout/footer.php' ?>
</footer>