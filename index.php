<?php require_once './layout/header.php'; ?>


<section id="index">
    <?php if (isset($_SESSION['user'])) {
        require_once './layout/side-bar-profile.php';
    } ?>
    <main>
        <h1>MyComunnityLib</h1>
    </main>
    <?php require_once './layout/side-bar.php'; ?>

</section>

<footer>
    <?php require_once './layout/footer.php'; ?>
</footer>