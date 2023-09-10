<?php
require_once './classes/Comment.php';
require_once './init/init.php';
require_once './functions/request.php';

if (isset($p)) {
    [
        'id'                => $idPpublication,
        'media'             => $media,
        'approval_status'   => $approvalStatus
    ] = $p;
}
$comments = Comment::getCommentArticle($instance, $idPpublication);
?>

<div class="card-post">
    <div class="card-header">
        <h3 class="card-title"><?php  ?></h3>
    </div>

    <div class="card-body">
        <img src="<?php echo $media ?>" alt="<?php echo $media ?>">
    </div>

    <?php if ($approvalStatus === 1) { ?>
        <button class="btn like-article">Like</button>
        <button class="btn comments-article">Commenter</button>

        <form class="hidden form-comment-article" action="register_comments_process.php" method="post">
            <label for="comments-article <?php echo $idPpublication ?>">Ajoutez un commantaire</label>
            <textarea name="comments_article_<?php echo $idPpublication ?>" id="comments-article <?php echo $idPpublication ?>" cols="30" rows="1"></textarea>
            <input class="register-comments" type="submit" name="register_comments" id="" value="Publier">
        </form>

        <?php
        foreach ($comments as $c) {
            if ($idPpublication === $c['Publications_id']) {
                $autor = getUserById($c['Users_id'], $instance);
        ?>
                <div>
                    <h6><?php echo $autor ?></h6>
                    <p><?php echo $c['content'] ?></p>
                </div>
        <?php }
        } ?>
</div>
<?php }

?>