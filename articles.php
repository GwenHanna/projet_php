<?php
require_once './init/init.php';
require_once './layout/header.php';
require_once './classes/Publication.php';
require_once './classes/Category.php';


if (isset($_GET)) {
    $messageNotArticles = '';
    $idMaxCategory = Category::getMaxIdCategory($instance);
    var_dump($idMaxCategory);
    if ($_GET['id'] > $idMaxCategory) {
        $messageNotArticles = 'Not Found';
    }
    [
        'id' => $idCategory
    ] = $_GET;

    try {
        $articles = Publication::getArticles($instance, intval($idCategory));
        if (count($articles) < 1) {
            $messageNotArticles = "Aucun article trouvé dans cette catégorie";
        }
    } catch (PDOException $th) {
        exit;
    }
}
if (isset($_SESSION['user'])) {
    require_once './layout/side-bar-profile.php';
} ?>
<section>
    <main>
        <?php if ($messageNotArticles !== '') { ?>
            <p><?php echo $messageNotArticles ?></p>
        <?php } ?>
        <?php foreach ($articles as $p) {
            [
                'id'                => $idArticle,
                'name'              => $nameCategory,
                'content'           => $contentPublication,
                'dateCreated'       => $dateCreated,
                'media'             => $media,
                'approval_status'   => $statut
            ] = $p;
            if ($statut == 1) {
                require './assets/templates/post.php';
            }
        } ?>
    </main>
</section>

<?php
require_once './layout/side-bar.php';
require_once './layout/footer.php';
?>