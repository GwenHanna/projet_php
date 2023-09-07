<?php
require_once './init/init.php';
require_once './layout/header.php';
require_once './classes/Publication.php';
require_once './classes/Category.php';

$messageNotArticles = '';

if (isset($_GET)) {
    $idMaxCategory = Category::getMaxIdCategory($instance);
    if ($_GET['id'] > $idMaxCategory) {
        $messageNotArticles = 'Not Found';
    }
    [
        'id' => $idCategory
    ] = $_GET;

    try {
        $articles = Publication::getArticles($instance, intval($idCategory));
    } catch (PDOException $th) {
        var_dump($th->getMessage());
        exit;
    }
} else {
    $messageNotArticles = "Aucun article trouvé dans cette catégorie";
}
?>

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
require_once './layout/footer.php';
?>