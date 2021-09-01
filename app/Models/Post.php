<?php
/**
 * Post Model Class File
 * Model for Posts data manipulation
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
 * Post Model Class
 * Model for Posts data manipulation
 * PHP version 8.0.9
 *
 * @category Models
 * @package  Models
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */

class Post extends \Models\Model
{
    protected $table = "posts";

    /**
     * Returns posts
     * 
     * @param int $offset Offset in database
     * @param int $limit  Number of posts to get
     * 
     * @return array
     */
    public function get(int $offset = 0, int $limit = 10): array
    {
        $query = $this->db->prepare("SELECT * FROM posts ORDER BY last_modified DESC LIMIT :_offset, :_limit");
        $query->bindValue(":_offset", $offset, \PDO::PARAM_INT);
        $query->bindValue(":_limit", $limit, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Returns number of posts
     *  
     * @return int
     */
    public function count(): int
    {
        $query = $this->db->prepare("SELECT COUNT(*) FROM posts");
        $query->execute();
        return $query->fetch()["COUNT(*)"];
    }

    /**
     * Creates a new post
     * 
     * @param int    $author_id Id of original poster
     * @param string $title     Title of the post
     * @param string $overview  Short description of the post
     * @param string $content   Post's content
     * @param string $tags      Post's tags
     * 
     * @return int
     */
    public function create(
        int $author_id, 
        string $title, 
        string $overview, 
        string $content, 
        string $tags
    ): int {
        $query = $this->db->prepare("INSERT INTO `posts` VALUES (NULL, :author_id, :title, :overview, :content, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, :tags)");
        $query->bindValue(":author_id", $author_id);
        $query->bindValue(":title", $title);
        $query->bindValue(":overview", $overview);
        $query->bindValue(":content", $content);
        $null = null;
        if ($tags === "") {
            $query->bindValue(":tags", $null, \PDO::PARAM_NULL);
        } else {
            $query->bindValue(":tags", $tags);
        }
        $query->execute();
        return $this->db->lastInsertId();
    }

    /**
     * Verifies if user has permission to delete entity, if so, deletes it
     * 
     * @param int $post_id Post that will be deleted
     * 
     * @return void
     */
    public function delete(int $post_id): void
    {

        $query = $this->db->prepare("DELETE FROM posts WHERE id=:id");
        $query->execute([":id" => $post_id]);
    
    }    

    /**
     * Returns author of post
     * 
     * @param int $post_id Id of searched post
     * 
     * @return int|bool
     */
    public function getAuthor(int $post_id):int|bool
    {
        $query = $this->db->prepare("SELECT author_id FROM posts WHERE id=:id");
        $query->execute([":id" => $post_id]);
        return $query->fetch()["author_id"];
    }

    /**
     * Updates a post in database
     * 
     * @param int    $post_id       The id of the post to update
     * @param string $post_title    The post's new title
     * @param string $post_overview The post's new short description
     * @param string $post_content  The post's new content
     * @param string $post_tags     The post's new tags
     * 
     * @return void
     */
    public function update(
        int $post_id, 
        string $post_title, 
        string $post_overview, 
        string $post_content, 
        ?string $post_tags
    ): void {
        $query = $this->db->prepare("UPDATE posts SET title=:post_title, overview=:post_overview, post_content=:post_content, last_modified=CURRENT_TIMESTAMP(), tags=:post_tags WHERE posts . id=:post_id");
        $query->bindValue(":post_title", $post_title);
        $query->bindValue(":post_overview", $post_overview);
        $query->bindValue(":post_content", $post_content);
        $null = null;

        if (isset($post_tags)) {
            if ($post_tags === "") {
                $query->bindValue(":post_tags", $null, \PDO::PARAM_NULL);
            } else {
                $query->bindValue(":post_tags", $post_tags);
            }
        } else {
            $query->bindValue(":post_tags", $null, \PDO::PARAM_NULL);
        }
        
        $query->bindValue(":post_id", $post_id);
        $query->execute();
    }

    /**
     * Returns most recent posts (max 1 week)
     * 
     * @return array
     */
    public function getRecentPosts(): array
    {
        $query = $this->db->prepare("SELECT * FROM posts WHERE last_modified >= FROM_UNIXTIME(UNIX_TIMESTAMP()-604800) ORDER BY last_modified DESC LIMIT 0, 10");
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Returns a post's title
     * 
     * @param int $post_id The id of the post queried
     * 
     * @return string
     */
    public function getTitle(int $post_id): string
    {
        $query = $this->db->prepare("SELECT title FROM posts WHERE id=:id");
        $query->execute([":id" => $post_id]);
        return $query->fetch()["title"];
    }

}