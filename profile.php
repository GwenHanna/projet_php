<?php
require_once './layout/header.php';
?>


<?php
require_once './classes/User.php';
require_once './init/init.php';
require_once './classes/Utils.php';

if (!isset($_SESSION['user'])) {
    Utils::redirect(' conection_process.php');
}
?>

<section class="">
    <div class="section-profile">
        <?php if (isset($_SESSION['user'])) {
            require_once './layout/side-bar-profile.php';
        } ?>
        <main class="col-6 main-profile">

            Lorem ipsum dolor sit amet consectetur adipisicing elit. Sapiente reiciendis harum eaque numquam, esse sed excepturi dolor nesciunt amet rem temporibus tempora, iste consequuntur molestias eius repellat commodi illum corrupti odit sint accusantium nostrum laboriosam? Eaque, exercitationem alias! Dolore deleniti quas inventore nisi hic itaque laudantium doloremque explicabo placeat sequi. Repudiandae doloremque ea consequatur minus possimus aliquam vero ullam at eos explicabo illo rerum, error impedit in quasi magnam facere perferendis asperiores unde harum necessitatibus ab exercitationem ratione? Nam quidem veniam rem sed distinctio iure quos accusamus voluptatem provident, explicabo totam, quam laborum nisi dolor, et est ea architecto? Repellendus aut illum, modi, perspiciatis odit doloremque harum assumenda voluptatibus est aliquid quas voluptatem sed nulla, quod dolorem exercitationem ducimus quidem voluptas esse debitis reiciendis explicabo. Cumque voluptas error provident maiores veritatis explicabo consequatur perspiciatis aspernatur, nobis voluptate iure libero magnam eos omnis numquam nam adipisci facilis sapiente a tempore ad vero aliquam fuga delectus. Rem laudantium tenetur pariatur velit reiciendis placeat eligendi, error repellat quam animi enim a! Cumque perferendis culpa repellendus eius aspernatur deserunt voluptatum autem cum. Mollitia quo beatae repudiandae quidem sunt eos, alias explicabo commodi, ea quas expedita. Temporibus numquam et voluptas quaerat, ducimus dicta deserunt eaque ex modi nostrum recusandae eligendi culpa minus sed, voluptatibus repellendus tenetur facilis tempora sapiente alias omnis tempore! Totam impedit dolore ipsa obcaecati optio suscipit eveniet repellat consequuntur omnis dolorem! Distinctio ipsa officia harum, a quam fugiat. Quae quod explicabo enim assumenda nisi. Aliquam nam iure voluptatum, provident incidunt amet est perspiciatis nisi voluptate esse quam sit ex, sed ab veniam modi vitae obcaecati eos autem illum. Dignissimos libero cum placeat dicta id quasi nemo similique sunt porro itaque! Ipsum voluptate assumenda consequuntur fuga omnis explicabo ullam, enim officiis nemo iusto animi, laborum blanditiis ipsa iure. Placeat, ea. Nisi nihil, autem molestiae pariatur unde officiis. Cupiditate sit recusandae, autem dolorem commodi quisquam voluptatibus provident, maxime blanditiis ipsum earum. Sed quisquam, consectetur ipsa fugit expedita officia placeat vitae eius aliquid atque minus alias a quasi tempora itaque maiores dicta aliquam in ipsam natus totam. Quae molestias sapiente reiciendis quia perferendis? Est sapiente dicta quaerat dolorum error, magnam alias, distinctio tempora eos architecto nemo provident corrupti et iusto perspiciatis animi illo explicabo qui quam velit enim placeat? Est asperiores odio nobis animi tenetur dolore recusandae quasi deserunt omnis unde? Similique nam cumque non officiis tempora? Nulla, nemo blanditiis. Accusamus tempora nemo atque necessitatibus repellendus qui non exercitationem aliquam maiores illo sapiente quam, officiis laborum quasi nisi quod nam vero velit dolorum. Doloremque accusamus ad vel id iste minus cum eligendi praesentium ratione tempora, nulla eum a repudiandae facere ipsum quam cumque officia animi magni nostrum reiciendis? Mollitia sed incidunt asperiores, reprehenderit voluptates suscipit dolores earum vel quis molestias architecto reiciendis ratione quod sint natus rerum deleniti eum nostrum? Maiores expedita laborum nulla rem impedit magnam in architecto tempora corporis, deleniti ratione? Eius corporis nesciunt reiciendis qui quod aut tempora nisi nulla exercitationem quo harum, itaque expedita totam provident, mollitia culpa quibusdam quis adipisci maiores sint aliquam pariatur modi eum sit? Excepturi autem rem totam repellat iure deserunt aperiam! Similique repellendus aspernatur laborum aut doloremque laboriosam quae ipsum obcaecati ut amet eveniet adipisci optio, corrupti veniam et! Non enim odit hic, aspernatur eum repellat optio facilis est delectus, similique dolores eveniet doloribus. Beatae quam corporis doloribus velit voluptas necessitatibus nesciunt enim omnis tenetur similique praesentium illum quia fuga, mollitia temporibus amet id accusantium saepe ipsam reprehenderit delectus. Debitis corporis suscipit sapiente quam exercitationem accusamus necessitatibus voluptates! Sit maiores quisquam eaque quae dolor quis consectetur iusto vel repellendus dolores voluptate, consequuntur amet iure excepturi pariatur nam fugiat rem reiciendis natus, quibusdam magnam cupiditate nihil dicta nesciunt? Aut obcaecati voluptatum aliquam sed, ducimus reiciendis quidem et delectus quae suscipit explicabo reprehenderit sapiente, accusantium dignissimos dolor nam alias officia fugiat. Accusantium sequi incidunt quae aperiam ipsa corporis? Ipsum totam sit nostrum, quidem, blanditiis, placeat dolore sed magnam debitis illum ducimus reprehenderit itaque laborum. Est iste libero quo saepe dolore sed excepturi nesciunt deleniti necessitatibus veritatis perspiciatis quas, ducimus eius voluptatibus ab, nihil quia! Autem hic ratione reiciendis repellendus, quae consequatur maiores minus, iure repudiandae excepturi voluptatum natus aperiam, quas fugit commodi debitis rem! Natus minima consequatur iste.


        </main>
        <?php require_once './layout/side-bar.php'; ?>
    </div>

</section>

<footer>
    <?php require_once './layout/footer.php' ?>
</footer>


<script src="./js/publication.js"></script>