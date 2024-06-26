<?php session_start();
if (isset($_SESSION['user'])) {
    // var_dump($_SESSION['user']);
}
$p =  './assets/';
// require_once __DIR__ . '../../assets/style.css';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="./js/publication.js" defer></script>
    <link rel="stylesheet" href="<?php echo $p . "style.css " ?>">
    <title>MyComunnityLib</title>
</head>

<body>

    <header class="d-sm-flex justify-content-around align-items-center mx-auto w-100 p-2 pb-5">
        <div class="logo col-sm-4">
            MyCommunityLib
        </div>
        <nav class="d-flex justify-content-around col-sm-6">
            <li><a href="index.php">Home</a></li>
            <?php if (isset($_SESSION['user'])) { ?>
                <li><a href="profile.php">Mon Profile</a></li>
                <?php if ($_SESSION['user']['role'] === 'modo' || $_SESSION['user']['role'] === 'admin') { ?>
                    <li><a href="modo.php">Ma page de modération</a></li>
                <?php } ?>
            <?php } ?>


        </nav>
        <nav class="btn col-sm-2">
            <?php
            if (empty($_SESSION['user'])) { ?>
                <a href="conection.php">Connexion</a>
                <a href="register.php">Inscription</a>
            <?php } else { ?>
                <a href="logout.php">Déconnexion</a>
            <?php }
            ?>

        </nav>
    </header>