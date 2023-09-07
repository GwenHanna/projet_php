<?php

require_once './classes/Category.php';
require_once './init/init.php';

try {
    $categorieInstance = new Category();
} catch (PDOException $th) {
    $errorMessage = $th->getMessage("Erreur !");
    exit;
}

$categories = $categorieInstance->getCategoriesDb($instance);

?>

<nav class="col-3 side-bar-categories">
    <?php foreach ($categories as $cat) { ?>
        <li><a href="articles.php?id=<?php echo $cat['id'] ?>"><?php echo $cat['name'] ?></a></li>
    <?php } ?>
</nav>