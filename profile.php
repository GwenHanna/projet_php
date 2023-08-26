<header>
    <?php
    require_once './layout/header.php';
    require_once './layout/header-profile.php';
    ?>

</header>
<?php

require_once './classes/User.php';
require_once './classes/Db.php';


if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['pass']) && !empty($_POST['pass'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    try {
        $db = new Db();
        $u = new User($db);
        $nuser = $u->connect($email, $pass);
    } catch (Exception $e) {
        $errorMessageConnect = $e->getMessage();
    }
}
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    var_dump($user);
}

?>

<main>



</main>
<footer>
    <?php require_once './layout/footer.php' ?>
</footer>