<?php
/**
 * User Model Class File
 * Model for User data manipulation
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
 * User Model Class
 * Model for User data manipulation
 * PHP version 8.0.9
 *
 * @category Models
 * @package  Models
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */

class User extends \Models\Model
{
    protected $table = "users";

    /**
     * Logs in user if credentials are correct
     * 
     * @param $email    User's email adress used during register
     * @param $password User's password used during register
     * 
     * @return string|bool
     */
    public function login(string $email, string $password): string|bool
    {
        $query = $this->db->prepare("SELECT password, id FROM users WHERE email=:email");
        $query->execute([":email" => $email]);
        $user =  $query->fetch();

        if (!$user) {
            return false;
        }

        if (password_verify($password, $user["password"])) {
            return $user["id"] . "|" . $user["password"];
        }
        return false;
    }

    /**
     * Registers user if all fields are correct
     * 
     * @param string $first_name User's first Name
     * @param string $last_name  User's last Name
     * @param string $username   User's username
     * @param string $email      User's email adress
     * @param string $password   User's password
     * @param string $birthday   User's birthday
     * 
     * @return string
     */
    public function register(
        string $first_name,
        string $last_name,
        string $username,
        string $email,
        string $password,
        string $birthday
    ):string {
        // ! RETURN ID + ";" + HASH OF PASSWORD
        $query = $this->db->prepare("INSERT INTO `users` VALUES (NULL, :first_name, :last_name, :username, :email, :password, 'default.png' , NULL, NULL, CURRENT_TIMESTAMP, :birthday, 0)");
        
        $query->bindValue(":first_name", $first_name);
        $query->bindValue(":last_name", $last_name);
        $query->bindValue(":username", $username);
        $query->bindValue(":email", $email);
        $query->bindValue(":password", $password);
        $query->bindValue(":birthday", $birthday);
        $query->execute();
        $id = $this->db->lastInsertId();
        return("$id|$password");
    }

    /**
     * Finds an user by it's unique indexes (email or username)
     * 
     * @param string $value May be an email or an username
     * 
     * @return array|bool
     */
    public function findBy(string $value): array|bool
    {
        $sql = "SELECT * FROM `users` WHERE";
        if (str_contains($value, "@")) {
            $sql .= " email=:value";
        } else {
            $sql .= " username=:value";
        }
        $query = $this->db->prepare($sql);
        $query->execute([":value" => $value]);
        return $query->fetch();
    }

    /**
     * Returns account username using it's id
     * 
     * @param int $id The id of the searched user
     * 
     * @return string
     */
    public function getUsername(int $id): string
    {
        $query = $this->db->prepare("SELECT username FROM users WHERE id=:id");
        $query->execute([":id" => $id]);
        return $query->fetch()["username"];
    }

    /**
     * Returns if user is admin or not
     * 
     * @param int $id The id of the searched user
     * 
     * @return bool
     */
    public function isAdmin(int $id): bool
    {
        $query = $this->db->prepare("SELECT is_admin FROM users WHERE id=:id");
        $query->execute([":id" => $id]);
        return $query->fetch()["is_admin"];
    }

    /**
     * Returns exact path to profile picture
     * 
     * @param string $path Profile Picture name
     * 
     * @return string
     */
    public function getExactPath(string $path): string
    {
        return "./public/pictures/$path";
    }
}