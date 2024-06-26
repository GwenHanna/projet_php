<?php
require_once './init/init.php';
require_once './classes/Success.php';
require_once './classes/Category.php';


if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    $user = $_SESSION['user'];
}

if (isset($user['picture']['name'])) {
    $namePicture = $user['picture']['name'];
    $pathFile = '../uploads/picture_profile/';
}
try {
    $InstanceCategorie = new Category();
    $categories = $InstanceCategorie->getCategoriesDb($instance);
} catch (PDOException $th) {
    //throw $th;
}

?>
<div class="col-3 side-bar-profile">
    <div class="picture-profile">
        <?php if (!empty($user['picture'])) { ?>
            <img class="picture" src="<?php echo $pathFile . $namePicture ?>" alt="<?php echo $user['firstname'] . ' ' . $user['lastname'] ?>">
        <?php } ?>
    </div>
    <div class="side-bar-profile-item">
        <?php if (isset($user)) { ?>
            <h3 class="side-bar-profile-name"><?php echo $user['firstname'] . ' ' . $user['lastname'] ?></h3>
        <?php } ?>
    </div>

    <div class="col-sm-12">
        <button class="addPublication">Publier</button>
    </div>

    <?php if (isset($_GET['success'])) { ?>
        <p class="pop-success actived">
            <?php echo Success::getCodes($_GET['success']) ?>
            <span>
                <svg class="close" width="15px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z" />
                </svg>
            </span>
        </p>
    <?php } ?>

    <div class="card text-center form-publication hidden ">
        <div class="">
            <p class="title-header-form">Ajouter une publication
                <span class="close">
                    <svg width="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z" />
                    </svg>
                </span>
            </p>


        </div>

        <div class="card-body">

            <!-- Formulaire d'ajout de publication -->
            <form class="form-control text-center" action="register_publication.php" method="post" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="btns d-flex">
                        <input value="Lien" type="button" name="" id="link-publication" class="col-9 mx-auto ">
                        <input type="button" value="Photo" name="" id="picture-publication" class="col-9 mx-auto ">
                    </div>

                    <!-- Photo -->
                    <div class="form-group">
                        <div class="choice-picture actived">
                            <label class="m-3 custom-file-upload" for="picture">Photo</label>
                            <input value="Photo" type="file" name="picturePublication" id="picture">
                        </div>
                    </div>
                    <!-- Link -->
                    <div class="form-group ">

                        <div class="choice-link hidden" id="">
                            <input type="url" name="linkPublication" id="Linkpublication" placeholder="url de votre lien" class="choice">

                        </div>
                    </div>

                    <select name="category" id="">
                        <?php foreach ($categories as $c) {
                            [
                                'id' => $idCategory,
                                'name' => $nameCategory
                            ] = $c; ?>
                            <option value="<?php echo $idCategory ?>"><?php echo $nameCategory ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="p-2">
                    <textarea class="col-sm-12" name="legend-file" id="legend-file" cols="30" rows="3" placeholder="Legende..."></textarea>
                </div>
                <input class="btn btn-dark col-6 m-3" type="submit" name="registerPublication" id="register-publication">
            </form>
        </div>

    </div>


</div>