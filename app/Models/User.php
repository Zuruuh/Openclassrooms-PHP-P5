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
     * @return array|bool
     */
    public function login(string $email, string $password): array|bool
    {
        $query = $this->db->prepare("SELECT password, id, disabled FROM users WHERE email=:email");
        $query->execute([":email" => $email]);
        $user =  $query->fetch();

        return $user;
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
        // ! RETURN ID & HASHED_PASSWORD

        $default_profile_picture = \Utils\Constants::$DEFAULT_IMAGE;

        $query = $this->db->prepare("INSERT INTO `users` VALUES (NULL, :first_name, :last_name, :username, :email, :password, :profile_picture , NULL, NULL, CURRENT_TIMESTAMP, :birthday, 0, 0)");
        
        $query->bindValue(":first_name", $first_name);
        $query->bindValue(":last_name", $last_name);
        $query->bindValue(":username", $username);
        $query->bindValue(":email", $email);
        $query->bindValue(":password", $password);
        $query->bindValue(":profile_picture", $default_profile_picture);
        $query->bindValue(":birthday", $birthday);
        $query->execute();
        $id = $this->db->lastInsertId();
        return("$id|$password");
    }

    /**
     * Updates a user profile
     * 
     * @param int    $user_id     The user to update
     * @param string $first_name  The user's new first name
     * @param string $last_name   The user's new last name
     * @param string $path        The user's profile picture path
     * @param string $description The user's new description
     * @param string $location    The user's new location
     * 
     * @return void
     */
    public function update(int $user_id, string $first_name, string $last_name, string $path, string $description, string $location): void
    {
        $query = $this->db->prepare(
            "UPDATE users SET 
            first_name=:first_name, 
            last_name=:last_name, 
            profile_picture_path=:path, 
            description=:description, 
            location=:location 
            WHERE `users`.`id`=:user_id"
        );

        $query->bindValue(":first_name", $first_name);
        $query->bindValue(":last_name", $last_name);
        $query->bindValue(":path", $path);
        $query->bindValue(":description", $description);
        $query->bindValue(":location", $location);

        $query->bindValue(":user_id", $user_id);

        $query->execute();
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
     * Returns user's profile picture
     * 
     * @param int $user_id The user searched
     * 
     * @return string
     */
    public function getProfilePicture(int $user_id): string
    {
        $query = $this->db->prepare("SELECT profile_picture_path FROM users WHERE id=:id");
        $query->execute([":id" => $user_id]);
        return $query->fetch()["profile_picture_path"];
    }

    /**
     * Changes a user's password
     * 
     * @param string $new_password The new hashed password
     * @param int    $id           The user's id
     * 
     * @return void
     */
    public function updatePassword(string $new_password, int $id): void
    {
        $query = $this->db->prepare("UPDATE users SET password=:new_password WHERE users.id=:id");
        $query->bindValue(":new_password", $new_password);
        $query->bindValue(":id", $id);
        $query->execute();
    }

    /**
     * Changes a user's username
     * 
     * @param string $new_username The new hashed username
     * @param int    $id           The user's id
     * 
     * @return void
     */
    public function updateUsername(string $new_username, int $id): void
    {
        $query = $this->db->prepare("UPDATE users SET username=:new_username WHERE users.id=:id");
        $query->bindValue(":new_username", $new_username);
        $query->bindValue(":id", $id);
        $query->execute();
    }

    /**
     *  Sets a user's profile picture to default.png
     * 
     * @param int    $user_id  The user requested
     * @param string $username The new username
     * 
     * @return void
     */
    public function changeUsername(int $user_id, string $username): void
    {
        $query = $this->db->prepare("UPDATE users SET username=:username WHERE users.id=:user_id");
        $query->bindValue(":username", $username);
        $query->bindValue("user_id", $user_id);
        $query->execute();
    }

    /**
     * Disables an account
     * 
     * @param int $user_id The account to disable
     * 
     * @return void
     */
    public function disableAccount(int $user_id): void
    {
        $query = $this->db->prepare("UPDATE users SET disabled=1 WHERE users.id=:user_id");
        $query->execute([":user_id" => $user_id]);
    }

    /**
     * Returns most recent users (max 1 week)
     * 
     * @return array
     */
    public function getRecentUsers(): array
    {
        $query = $this->db->prepare("SELECT * FROM users WHERE register_date >= FROM_UNIXTIME(UNIX_TIMESTAMP()-604800) AND disabled=0 ORDER BY register_date DESC LIMIT 0, 15");
        $query->execute();
        return $query->fetchAll();
    }
}