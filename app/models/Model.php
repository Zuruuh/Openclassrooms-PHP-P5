<?php
/**
 * Model Class File
 * Abstract class containing default crud actions for other models
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
 * Model Class 
 * Abstract class containing default crud actions for other models
 * PHP version 8.0.9
 *
 * @category Models
 * @package  Models
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */
abstract class Model
{
    protected $db, $table;

    /**
     * Sets database connexion when new model is instantiated
     */
    public function __construct()
    {
        $this->db = \Utils\Database::getDB();
    }

    /**
     * Finds one entity in database
     * 
     * @param int $id Entity Id
     *  
     * @return array|bool Returns entity if found, or false if entity does not exist
     */
    public function find(int $id): array|bool
    {
        $query = $this->db->prepare("SELECT * FROM {$this->table} WHERE id=:id");
        $query->execute(["id" => $id]);
        return $query->fetch();
    }

    /**
     * Finds all entities in table and returns them
     * 
     * @param string $sort Column to use for sorting & sorting order (e.g: created_at DESC)
     * 
     * @return array
     */
    public function findAll(?string $sort): array
    {
        $sql = "SELECT * FROM {$this->table}";
        if ($sort) {
            $sql .= " ORDER BY " . $sort;
        }
        $results = $this->db->query($sql);
        return $results->fetchAll();
    }

}