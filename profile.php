<header>
    <?php
    require_once './layout/header.php';
    require_once './layout/header-profile.php';
    ?>

</header>
<?php

require_once './classes/User.php';
require_once './classes/Db.php';

if ($_SESSION == true) {
    var_dump($_SESSION);
}


?>

<main>


    <div class="col-sm-12">
        <button class="addPublication">Publier</button>
    </div>

    <div class="card text-center form-publication hidden ">
        <div class="card-header">

            <form class="form-control text-center" action="" method="post">


                <div class="card-body row">
                    <!-- Photo -->
                    <div class="col-6 col-md-12  form-group form-picture">
                        <input type="button" value="Photo" name="" id="picture-publication" class="col-9 mx-auto choice">
                        <div class="form-group actived">
                            <label class="m-3 custom-file-upload" for="picture">Photo</label>
                            <input value="Photo" type="file" name="picturePublication" id="picture">
                            <div class="form-group p-2">
                                <textarea class="col-sm-12" name="legendPicture" id="legendPicture" cols="30" rows="5" placeholder="Legende..."></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- Link -->
                    <div class="col-6 col-md-12 form-group form-picture">
                        <input value="Lien" type="button" name="" id="link-publication" class="col-9 mx-auto choice">

                        <div class="hidden" id="">
                            <input type="url" name="linkPublication" id="Linkpublication" placeholder="url de votre lien" class="choice">
                            <div class="form-group p-2">
                                <textarea class="col-sm-12" name="legend-file" id="legend-file" cols="30" rows="5" placeholder="Legende..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <input class="btn btn-dark col-6 m-3" type="submit" name="registerPublication" id="register-publication">
            </form>

        </div>

    </div>










</main>
<footer>
    <?php require_once './layout/footer.php' ?>

</footer>



<script src="./js/publication.js"></script>