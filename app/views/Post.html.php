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

?>

<article id='post'>
    <div>
        <a class='post-author' href='index.php?page=user&action=view&id=<?=$author_id?>'><?=$author?></a>
        <i> le <?=$post_date?></i>
    </div>
    <h2><?=$title?></h2>
    <p><?=$overview?></p>
    <div><?=$post_content?></div>
    <div>
        <div>
            <?php 
            $tags = explode(",", $tags);
            foreach ($tags as $tag) {
                echo "<div class='tag'>$tag</div>";
            }
            ?>
        </div>
        <i>Dernière mise à jour le <?=$last_modified?></i>
    </div>
</article>
<section id='comments'>
    <div id='comments-pagination'>
    <?php 
    foreach ($comments as $comment) {
        echo $comment;
    }
    ?>  
    </div>
    <div id="new-comment" class="comment-form">
        <?= $page_forms[0] ?>
    </div>
</section>
