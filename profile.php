<header>
    <?php require_once './layout/header.php'; ?>
</header>
<?php

require_once './classes/Utils.php';
require_once './classes/User.php';
require_once './classes/Db.php';

if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['pass']) && !empty($_POST['pass'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $db = new Db();
    $u = new User($db);
    $nuser = $u->connect($email, $pass);
    // var_dump($_SESSION['user']);
    require_once './layout/header-profile.php';
    $user = $_SESSION['user'];
}
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}

?>

<main>



</main>
<footer>
    <?php require_once './layout/footer.php' ?>
</footer>