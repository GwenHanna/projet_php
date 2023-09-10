<?php
session_start();
require_once './init/init.php';
require_once './classes/Comment.php';
require_once './classes/Utils.php';
if (isset($_POST['register_comments'])) {
    $idUser = $_SESSION['user']['id'];
    foreach ($_POST as $key => $value) {
        $res = explode('_', $key);
        if ($res[0] === 'comments') {
            $idArticle = $res[2];
            $content = $value;
        }
    }

    try {
        $instanceComment = new Comment($idUser, $idArticle, $content);
        $instanceComment->insertCommentArticle($instance);
        var_dump($instanceComment);
        Utils::redirect($_SERVER['HTTP_REFERER']);
    } catch (PDOException $th) {
        var_dump($th->getMessage());
        exit;
    }
}
