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
    public static function buildPost(int $id, string $author_id, string $author_username, string $date, string $title, string $overview): string 
    {
        $post_element  = "<article class='post' id='post-$id'>";
        $post_element .= "<div><a class='post-author' href='index.php?page=user&action=view&id=$author_id'>$author_username</a>";
        $post_element .= "<i>$date</i></div>";
        $post_element .= "<div><h4>$title</h4>";
        $post_element .= "<p>$overview</p></div>";
        $post_element .= "<a href='index.php?page=post&action=get&post=$id'>Lire le post</a>";
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
     * 
     * @return string
     */
    public static function buildComment(string $path, string $username, string $user_id, string $content, string $post_date, string $last_update): string 
    {
        $comment_element  = "<div class='comment'><div class='comment-body'>";
        $comment_element .= "<div><img class='profile-picture-sm' src='$path' alt='$username' /></div>";
        $comment_element .= "<div class='comment-info'><div>";
        $comment_element .= "<a href='index.php?page=user&action=view&id=$user_id'><b>$username</b></a>";
        $comment_element .= "<i> le $post_date</i>";
        $comment_element .= "</div><p>$content</p>";
        $comment_element .= "</div></div>";
        $comment_element .= "<i>Dernière modification le: $last_update</i></div>";

        return $comment_element;
    }

}