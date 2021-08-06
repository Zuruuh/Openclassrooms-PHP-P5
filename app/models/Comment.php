<?php
/**
 * Comment Model Class File
 * Model for Comment data manipulation
 * PHP version 8.0.9
 *
 * @category Models
 * @package  Models
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */

namespace Models;

/**
 * Comment Model Class
 * Model for Comment data manipulation
 * PHP version 8.0.9
 *
 * @category Models
 * @package  Models
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */

class Comment extends \Models\Model
{
    protected $table = "comments";

    /**
     * Returns all comments of a post
     * 
     * @param int $post_id The id of the post to get
     * 
     * @return array
     */
    public function getPostComments(int $post_id):array 
    {
        $query = $this->db->prepare("SELECT * FROM comments WHERE post_id=:post_id AND validated=1");
        $query->execute([":post_id" => $post_id]);
        $comments = $query->fetchAll();
        $user_model = new \Models\User();

        $new_comments = array();
        foreach ($comments as $comment) {
            $user = $user_model->find($comment["author_id"]);
            $path = $user_model->getExactPath($user["profile_picture_path"]);
            $comment["profile_picture_path"] = $path;
            array_push($new_comments, $comment);
        }
        return $new_comments;
    }

    /**
     * Deletes all comments of a post
     * 
     * @param int $post_id The id of the post
     * 
     * @return void
     */
    public function deleteAll(int $post_id): void
    {
        $query = $this->db->prepare("DELETE FROM comments WHERE `comments` . `post_id` = :post_id");
        $query->execute([":post_id" => $post_id]);
    }

    /**
     * Adds a new comment under a post
     * 
     * @param int    $author_id       The poster of the comment
     * @param int    $post_id         The post commented
     * @param string $comment_content The content of the comment
     * 
     * @return void
     */
    public function create(int $author_id, int $post_id, string $comment_content): void
    {
        print_r($author_id);
        $query = $this->db->prepare("INSERT INTO `comments` VALUES (NULL, :author_id, :post_id, :comment_content, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, NULL)");
        $query->bindValue(":author_id", $author_id);
        $query->bindValue(":post_id", $post_id);
        $query->bindValue(":comment_content", $comment_content);
        $query->execute();

    }

    //TODO Delete one
    //TODO Edit comment

}