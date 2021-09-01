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

use \PDO;

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
     * @param int $offset  Offset in database
     * @param int $limit   Number of comments to get
     * 
     * @return array
     */
    public function getPostComments(int $post_id, int $offset = 0, int $limit = 10):array 
    {
        $query = $this->db->prepare("SELECT * FROM comments WHERE post_id=:post_id AND validated=1 ORDER BY id DESC LIMIT :_offset, :_limit");
        $query->bindValue(":post_id", $post_id, \PDO::PARAM_INT);
        $query->bindValue(":_offset", $offset, \PDO::PARAM_INT);
        $query->bindValue(":_limit", $limit, \PDO::PARAM_INT);
        $query->execute();
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
     * Returns number of comments of a post
     * 
     * @param int $post_id The id of the post to get
     * 
     * @return int
     */
    public function countPostComments(int $post_id): int
    {
        $query = $this->db->prepare("SELECT COUNT(*) FROM comments WHERE post_id=:post_id AND validated=1");
        $query->execute([":post_id" => $post_id]);
        $comments = $query->fetch();
        return $comments["COUNT(*)"];
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
     * @param bool   $admin           If the comment is an admin comment
     * 
     * @return void
     */
    public function create(int $author_id, int $post_id, string $comment_content, bool $admin = false): void
    {
        $query = $this->db->prepare("INSERT INTO `comments` VALUES (NULL, :author_id, :post_id, :comment_content, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, :admin)");
        $query->bindValue(":author_id", $author_id);
        $query->bindValue(":post_id", $post_id);
        $query->bindValue(":comment_content", $comment_content);
        if ($admin) {
            $query->bindValue(":admin", 1);
        } else {
            $null = null;
            $query->bindValue(":admin", $null, \PDO::PARAM_NULL);
        }
        $query->execute();

    }

    /**
     * Deletes a comment
     * 
     * @param int $id The id of the comment to delete
     * 
     * @return void
     */
    public function delete(int $id): void
    {
        $query = $this->db->prepare("DELETE FROM comments WHERE `comments` . `id`=:id");
        $query->execute([":id" => $id]);
    }

    /**
     * Edits a comment
     * 
     * @param int    $id      The id of the comment to edit
     * @param string $content The comment's new content
     * @param bool   $admin   If the comment poster is admin
     *  
     * @return void
     */
    public function edit(int $id, string $content, bool $admin = false): void
    {
        $query = $this->db->prepare("UPDATE `comments` SET `comment_content` = :content, `last_modified` = CURRENT_TIMESTAMP, `validated` = :validated WHERE `comments`.`id` = :id");
        $query->bindValue(":content", $content);
        $query->bindValue(":id", $id);
        if ($admin) {
            $query->bindValue(":validated", 1);
        } else {
            $query->bindValue(":validated", "NULL");
        }
        $query->execute();
    }

    /**
     * Returns the author of a comment
     * 
     * @param int $id The comment's id
     * 
     * @return int|bool
     */
    public function getAuthor(int $id): int|bool    
    {
        $query = $this->db->prepare("SELECT author_id FROM comments WHERE id=:id");
        $query->bindValue(":id", $id);
        $query->execute();
        return $query->fetch()["author_id"];
    }

    /**
     * Returns the post_id of a comment
     * 
     * @param int $id The comment's id
     * 
     * @return int|bool
     */
    public function getPost(int $id): int|bool    
    {
        $query = $this->db->prepare("SELECT post_id FROM comments WHERE id=:id");
        $query->bindValue(":id", $id);
        $query->execute();
        return $query->fetch()["post_id"];
    }

    /**
     * Returns all unvalidated comments
     * 
     * @return array|bool
     */
    public function getUnvalidatedComments(): array|bool
    {
        $query = $this->db->prepare("SELECT * FROM comments WHERE validated IS NULL");
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Sets a comment's validation state
     * 
     * @param int $comment_id The comment to update
     * @param int $state      The comment's new state
     * 
     * @return void
     */
    public function setState(int $comment_id, int $state): void
    {
        $query = $this->db->prepare("UPDATE comments SET validated=:state WHERE comments.id=:id");
        $query->bindValue(":state", $state);
        $query->bindValue(":id", $comment_id);
        $query->execute();
    }

    /**
     * Deletes all comment's of specified user
     * 
     * @param int $user_id The user requested
     * 
     * @return void
     */
    public function deleteAllUserComments(int $user_id): void
    {
        $query = $this->db->prepare("DELETE FROM comments WHERE comments.author_id=:id");
        $query->bindValue(":id", $user_id);
        $query->execute();
    }

    /**
     * Returns most recent comments (max 1 week)
     * 
     * @return array
     */
    public function getRecentComments(): array
    {
        $query = $this->db->prepare("SELECT * FROM comments WHERE last_modified >= FROM_UNIXTIME(UNIX_TIMESTAMP()-604800) ORDER BY last_modified DESC LIMIT 0, 15");
        $query->execute();
        return $query->fetchAll();
    }

}