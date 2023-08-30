<?php
if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    $user = $_SESSION['user'];
}

?>
<div class=" d-flex justify-content-around col-12">
    <div class="col-sm-6">
        <?php if (isset($user)) { ?>
            <h3><?php echo $user['firstname'] . ' ' . $user['lastname'] ?></h3>
        <?php } ?>
    </div>
    <div class="picture-profile">
        <?php if (isset($user['picture'])) { ?>
            <img class="picture" src="<?php echo $user['picture'] ?>" alt="<?php echo $user['firstname'] . ' ' . $user['lastname'] ?>">
        <?php } ?>
    </div>
</div>