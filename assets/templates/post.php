<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?php  ?></h3>
        <span>
            <?php
            $check = ($p['approval_status'] == 1) ? "checked" : "";
            ?>
            <input type="checkbox" name="media_<?php echo $p['id'] ?>" id="<?php echo $p['id'] ?>" <?php $check; ?> />
        </span>
    </div>

    <div class="card-body">
        <img src="<?php echo $p['media'] ?>" alt="<?php echo $p['media'] ?>">
    </div>
</div>