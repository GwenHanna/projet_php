<?php
$user = $_SESSION['user'];
?>
<div class="row">
    <div class="col-sm-6">
        <h3><?php echo $user['firstname'] . ' ' . $user['lastname'] ?></h3>
    </div>
</div>