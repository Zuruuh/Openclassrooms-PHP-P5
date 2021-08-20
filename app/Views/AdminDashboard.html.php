<?php
/**
 * Admin Dashboard Page View file
 * Admin Dashboard Page View
 * PHP version 8.0.9
 *
 * @category Views
 * @package  Views
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */
extract($values);
?>
<div style="height:0;"></div>
<div class='container-fluid p-4'>
    <h1>Interface d'administration</h1>
<section id="stats">
    <h2>Voici les statistiques récentes du site !</h2>
    <div class='row'>
    <?php
    foreach ($stats as $stat) {
        echo $stat;
    }
    ?>
    </div>
    <a class="btn btn-success btn-lg mb-3" href="index.php?page=admin&action=validate">Modération des commentaires</a>
</section>
<section id="recent" class='row'>
    <h2>Actions récentes</h2>
    <div id="posts-recent" class='col-xxl-4 col-xl-6 col-lg-12 recents'>
        <div id="latest-posts" class='recents-list'>
            <?php
            foreach ($recent_posts as $post) {
                echo $post;
            }
            ?>
        </div>
    </div>
    <div id="users-recent" class='col-xxl-4 col-xl-6 col-lg-12 recents'>
        <div id="latest-users" class='recents-list'>
        <?php
        foreach ($recent_users as $user) {
            echo $user;
        }
        ?>
        </div>
    </div>
    <div id="comments-recent" class='col-xxl-4 col-xl-6 col-lg-12 recents'>
        <div id="latest-comments" class='recents-list'>
        <?php
        foreach ($recent_comments as $comment) {
            echo $comment;
        }
        ?>
        </div>
        <p class=' my-3'>Cliquez <a href='index.php?page=admin&action=validate'>ici</a> pour administrer les commentaires !</p>
    </div>
</section>
    </div>
