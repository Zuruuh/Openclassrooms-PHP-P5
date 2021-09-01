<?php
/**
 * Element Builder Class File
 * Class for field validation
 * PHP version 8.0.9
 *
 * @category Utils
 * @package  Utils
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */

namespace Utils;

/**
 * Element Builder Class
 * Class for field validation
 * PHP version 8.0.9
 *
 * @category Utils
 * @package  Utils
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */
class ElementBuilder
{
    /**
     *  Returns an html comment element
     * 
     * @param int    $id              Post id
     * @param string $author_id       Id of post's author
     * @param string $author_username Username of post's author
     * @param string $date            Post's publishing datetime
     * @param string $title           Post's title
     * @param string $overview        Post's short description
     *
     * @return string
     */
    public static function buildPost(
        int $id, 
        string $author_id, 
        string $author_username, 
        string $date, 
        string $title, 
        string $overview
    ): string {
        $formatted_date = str_replace(" ", "T", $date);
        $post_element  = "<article class='mw-75 h-auto list-group-item py-2 pb-3' id='post-$id'>";
        $post_element .= "<div><h4 class='text-break ps-1 pe-2'>$title</h4>";
        $post_element .= "<div class='ps-1 pe-2'>Rédigé par: <a class='post-author' href='index.php?page=user&action=view&user=$author_id'>$author_username</a>";
        $post_element .= "<p class='my-2'>$overview</p><i>Dernière mise à jour le <time datetime='$formatted_date'>$date</time></i></div>";
        $post_element .= "<div class='d-flex justify-content-center'><a href='index.php?page=post&action=get&post=$id' class='btn w-100 mt-2 mx-3 btn-primary btn-lg text-lg'>Lire le post</a>";
        $post_element .= "</div></div>";
        $post_element .= "</article>";

        return $post_element;
    }

    /**
     * Returns an html comment element
     * 
     * @param string $path        Path to user profile picture
     * @param string $username    Comment poster's profile picture
     * @param string $user_id     Comment poster's id
     * @param string $content     Comment's content
     * @param string $post_date   Comment's publishing datetime
     * @param string $last_update Comment's last update datetime
     * @param int    $id          The comment's id
     * @param bool   $own         Shows edit & delete buttons if user is the comment poster
     * 
     * @return string
     */
    public static function buildComment(
        string $path, 
        string $username, 
        string $user_id, 
        string $content, 
        string $post_date, 
        string $last_update, 
        int $id,
        bool $own
    ): string {
        $formatted_post_date = str_replace(" à ", "T", $post_date);
        $formatted_last_update = str_replace(" à ", "T", $last_update);

        $comment_element  = "<li class='comment list-group-item'><div class='comment-body d-flex w-100' id='comment-$id'>";
        $comment_element .= "<div class='pe-3'><img class='profile-picture-sm rounded-circle' src='./public/$path' alt='$username' /></div>";
        $comment_element .= "<div class='w-100'><div class='d-flex align-items-center justify-content-between w-100'>";
        $comment_element .= "<div><a href='index.php?page=user&action=view&user=$user_id' class='pe-1'><b>$username</b></a>";
        $comment_element .= "<i> le <time datetime='$formatted_post_date'>$post_date</time></i></div>";
        $comment_element .= $own ? "<div class='btn-group mt-2 me-3'><a class='btn btn-sm btn-primary' href='index.php?page=comment&action=edit&comment=$id'><i class='fas fa-edit'></i> Modifier</a>" : "";
        $comment_element .= $own ? "<a class='btn btn-sm btn-danger' href='index.php?page=comment&action=delete&comment=$id'><i class='fas fa-trash'></i> Supprimer</a></div>" : "";
        $comment_element .= "</div><p>$content</p>";
        $comment_element .= "</div></div>";
        $comment_element .= "<i class='text-secondary'>Dernière modification le: <time datetime='$formatted_last_update'>$last_update</time></i></li>";

        return $comment_element;
    }

    
    /**
     * Returns an html comment element
     * 
     * @param string $path        Path to user profile picture
     * @param string $username    Comment poster's profile picture
     * @param string $user_id     Comment poster's id
     * @param string $content     Comment's content
     * @param string $post_date   Comment's publishing datetime
     * @param string $last_update Comment's last update datetime
     * @param int    $comment_id  Comment's id
     * 
     * @return string
     */
    public static function buildAdminComment(
        string $path, 
        string $username, 
        string $user_id, 
        string $content, 
        string $post_date, 
        string $last_update, 
        int $comment_id
    ): string {
        $formatted_post_date = str_replace(" ", "T", $post_date);
        $formatted_last_update = str_replace(" ", "T", $last_update);

        $comment_element  = "<tr class='admin-comment d-flex list-group-item justify-content-between mx-5'><th class='comment d-flex flex-column'>";
        $comment_element .= "<div class='d-flex'><img class='profile-picture-sm rounded-circle me-3 mt-2' src='./public/$path' alt='$username' />";
        $comment_element .= "<div class='comment-info d-flex flex-column'>";
        $comment_element .= "<a href='index.php?page=user&action=view&user=$user_id'><b>$username</b></a>";
        $comment_element .= "<i class='text-secondary'> le <time datetime='$formatted_post_date'>$post_date</time></i>";
        $comment_element .= "<p class='my-3 text-break'>$content</p>";
        $comment_element .= "</div></div>";
        $comment_element .= "<i class='text-secondary'>Dernière modification le: <time datetime='$formatted_last_update'>$last_update</time></i></div></th>";
        
        
        $comment_element .= "<th class='h-100 me-3 mt-2'><div class='btn-group-vertical'>";
        $comment_element .= "<a href='index.php?page=admin&action=validate&comment=$comment_id&state=1' class='btn btn-sm btn-success'>Valider</a>";
        $comment_element .= "<a href='index.php?page=admin&action=validate&comment=$comment_id&state=0' class='btn btn-sm btn-danger'>Invalider</a>";
        $comment_element .= "<button href='index.php?page=admin&action=ban&user=$user_id' class='btn btn-dark btn-sm ban-btn' data-bs-toggle='modal' data-bs-target='#ban-modal' onclick='confirmBan($user_id, \"$username\")'>Bannir</button>";
        $comment_element .= "</div></th></tr>";

        return $comment_element;
    }

    /**
     * Returns an html stat element
     * 
     * @param string $name  The name of the stat
     * @param string $value The value to display
     * @param string $icon  The icon to display
     * @param string $link  Link to redirect to on click
     * 
     * @return string
     */
    public static function buildStat(string $name, string $value, string $icon = "", string $link = "index.php"): string
    {
        $stat_element  = "<div class='col-xl-4 col-md-12' id='$name-stat'>";
        $stat_element .= "<div class='card bg-primary text-white mb-4'>";
        $stat_element .= "<div class='card-body d-flex justify-content-between'>";
        $stat_element .= "<div><i class='$icon'></i><p>Nouveaux $name:</p></div><p>$value</p>";
        $stat_element .= "</div><div class='card-footer d-flex align-items-center justify-content-between'>";
        $stat_element .= "<a href='$link' class='text-white'>Voir plus</a>";
        $stat_element .= "<b>></b>";
        $stat_element .= "</div></div></div>";

        return $stat_element;
    }

    /**
     * Returns an html stat element
     * 
     * @param string $text    The name of the stat
     * @param string $type    The value to display
     * @param int    $timeout The time it takes to make the toast disappear
     * 
     * @return string
     */
    public static function buildToast(string $text, string $type = "danger", int $timeout = 10000): string
    {
        $toast_element  = "<div class='toast my-1 align-items-center text-white bg-$type border-0' role='alert' aria-live='assertive' data-bs-delay='$timeout' aria-atomic='true'><div class='d-flex' style='z-index:1500;'>";
        $toast_element .= "<div class='toast-body'>$text</div>";
        $toast_element .= "<button type='button' class='btn-close btn-close-white me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>";
        $toast_element .= "</div></div>";

        return $toast_element;
    }

    /**
     * Returns an html tag element
     * 
     * @param string $text The text of the tag
     * 
     * @return string
     */
    public static function buildTag(string $text): string
    {
        $toast_element  = "<div class='rounded-pill w-auto bg-primary tag text-light py-2 px-3 my-1 mx-1 d-flex align-items-center'>";
        $toast_element .= "<span class='tag-hash rounded-circle d-flex justify-content-center align-items-center'>#</span>";
        $toast_element .= "<p class='m-0 ps-2'>$text</p>";
        $toast_element .= "</div>";

        return $toast_element;
    }

    /**
     * Returns an html bootstrap pagination element
     * 
     * @param string $text            The content display in the pagination element
     * @param string $element_classes The classes of the pagination element   
     * @param string $link            The link the element will redirect to
     * @param string $link_classes    The classes of the link element
     * 
     * @return string
     */
    public static function buildPagination( string $text = "", string $element_classes = "", string $link = "#", string $link_classes = ""): string
    {
        $pagination_element  = "<li class='page-item $element_classes'>";
        $pagination_element .= "<a class='page-link $link_classes' href='$link'>";
        $pagination_element .= "$text</a></li>";

        return $pagination_element;
    }

    
}