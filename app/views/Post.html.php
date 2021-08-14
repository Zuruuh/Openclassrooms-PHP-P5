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

extract($post);
$user_id = \Utils\Http::getSession("user_id")[0];
?>

<div style="height:0;"></div>
<article id='post container-fluid px-2'>
    <div class='d-flex justify-content-between px-2'>
        <p class='mb-0 mt-2'>Par <a class='post-author mt-2' href='index.php?page=user&action=view&user=<?=$author_id?>'><?=$author?></a></p>
        <i class='my-2'> le <?=$post_date?></i>
    </div>
    <hr class='mt-0'>
    <div class='d-flex justify-content-between px-1'>
        <h2 class='text-break ps-1'><?=$title?></h2>
        <div>
            <?php
            if ($author_id === $user_id && \Utils\Http::isSessionCorrect()) { ?>
                <a class='btn btn-primary btn-sm' href='index.php?page=post&action=edit&post=<?=$id?>'><i class='fas fa-edit'></i> Modifier</a>
                <a class='btn btn-danger btn-sm' href='index.php?page=post&action=delete&post=<?=$id?>'><i class='fas fa-trash'></i> Supprimer</a>
            <?php } ?>
        </div>
    </div>
    <p class='text-break ps-1'><?=$overview?></p>
    <div class='text-break ps-1'><?=$post_content?></div>
    <hr class='my-2'>
    <div>
        <div class='row d-flex flex-wrap px-3'>
        <?=$tags?>
        </div>
        <hr class='my-2'>
        <i class='ms-1'>Dernière mise à jour le <?=$last_modified?></i>
    </div>
</article>
<hr>
<section id='comments'>
    <div id="new-comment" class="comment-form w-100 d-flex justify-content-center px-5">
        <?php 
        if (\Utils\Http::isSessionCorrect()) {
            echo $page_forms[0]; 
        } else {
            echo "<p><a href='index.php?page=user&action=login'>Connectez-vous</a> pour poster un commentaire !</p>";
        }
        ?>
    </div>
    <div id='comments-pagination'>
        <ul class='list-group'>
        <?php 
        foreach ($comments as $comment) {
            echo $comment;
        }
        ?>  
        </ul>
    <nav aria-label="Page Pagination Nav">
        <ul class='pagination justify-content-center'>
        <?= $pagination ?>
        </ul>
    </nav>
    </div>
</section>
