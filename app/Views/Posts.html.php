<?php
/**
 * Register View file
 * Register View
 * PHP version 8.0.9
 *
 * @category Views
 * @package  Views
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */
?>
<div style="height:0;"></div>
<section class='container-fluid px-4 list-group pt-5'>
<?php

if (\Utils\Http::isAdmin()) { ?>
    <a href='index.php?page=post&action=create' class='w-full mx-5 btn btn-success mb-5 btn-lg'>
        Créez un nouveau post
    </a>
<?php }

if (!empty($posts)) {
    foreach ($posts as $post) {
        echo $post;
    }
} else { ?>
    <div class='alert alert-info my-5' role='alert'>
        <h3>Désolé, aucun post n'a été trouvé 😓</h3>
    </div>
<?php } ?>

</section>
<nav aria-label="Page Pagination Nav" class='my-2'>
    <ul class='pagination justify-content-center'>
    <?= $pagination ?>
    </ul>
</nav>