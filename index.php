<?php require_once './layout/header.php'; ?>


<h1 class="pb-5">MyComunnityLib</h1>
<section id="index">
    <main>
        <?php if (isset($_SESSION['user'])) {
            require_once './layout/side-bar-profile.php';
        } ?>
        <?php require_once './layout/side-bar.php'; ?>
    </main>

</section>


<?php require_once './layout/footer.php'; ?>