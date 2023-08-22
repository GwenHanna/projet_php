<?php session_start();
if (isset($_SESSION['user'])) {
    // var_dump($_SESSION['user']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>MyComunnityLib</title>
</head>

<body>

    <header>
        <div class="col-sm-1">MyComunnityLib</div>
        <nav class="col-sm-3">
            <?php if (isset($_SESSION['user'])) { ?>
                <li><a href="profile.php">Mon Profile</a></li>
            <?php } ?>
            <li><a href="index.php">Home</a></li>
        </nav>
        <nav class="btn col-sm-1">
            <?php
            if (empty($_SESSION['user'])) { ?>
                <a href="connexion.php">Connection</a>
                <a href="singnin.php">Inscription</a>
            <?php } else { ?>
                <a href="logout.php">Deconection</a>
            <?php }
            ?>

        </nav>
        <?php
        if (isset($_SESSION['user'])) {

            require_once './layout/header-profile.php';
        } ?>
    </header>