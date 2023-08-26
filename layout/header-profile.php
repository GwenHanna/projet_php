<?php
$user = $_SESSION['user'];

?>
<div class=" d-flex justify-content-around col-12">
    <div class="col-sm-6">
        <h3><?php echo $user['firstname'] . ' ' . $user['lastname'] ?></h3>
    </div>
    <div class="picture-profile">
        <img class="picture" src="<?php echo $user['picture']['path_file'] ?>" alt="<?php echo $user['firstname'] . ' ' . $user['lastname'] ?>">
    </div>
</div>