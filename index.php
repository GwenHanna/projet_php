<?php
require_once './layout/header.php';
require_once './classes/Publication.php';
require_once './init/init.php';
?>

<h1 class="pb-5">MyComunnityLib</h1>


<?php if (isset($_SESSION['user'])) {
    require_once './layout/side-bar-profile.php';
} ?>

<section id="index">
    <main>

        <?php
        $publications = Publication::getPublications($instance);
        foreach ($publications as $p) {
            require './assets/templates/post.php';
        }
        ?>
    </main>

</section>

<?php require_once './layout/side-bar.php'; ?>

<?php require_once './layout/footer.php'; ?>