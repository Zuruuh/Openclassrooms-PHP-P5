<?php
/**
 * Form Validator Class File
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
 * Form Validator Class
 * Class for field validation
 * PHP version 8.0.9
 *
 * @category Utils
 * @package  Utils
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */
class FormValidator
{

    private $_model;

    /**
     * Generates a new User Model when class is instantiated
     * 
     * @param \Models\Users $model User model for database interaction
     */
    public function __construct($model = null)
    {   
        if (isset($model)) {
            $this->_model = $model;
        }
    }

        // ! USER VERIFICATIONS

    /**
     * Verifies name length & returns array of errors
     * 
     * @param string $name  The name to verify
     * @param bool   $first (Optional) specify if name is a FirstName or not;
     * 
     * @return bool|string
     */
    public function checkName(string $name, ?bool $first = false): bool|string
    {
        if (strlen($name) > \Utils\Constants::$MAX_NAME_LENGTH) {
            return $first ? 
            \Utils\Constants::$FIRST_NAME_TOO_LONG : 
            \Utils\Constants::$LAST_NAME_TOO_LONG;
        }

        if (!preg_match("/^[\p{L}-]*$/u", $name)) {
            return $first ? 
            \Utils\Constants::$FIRST_NAME_SPECIAL_CHARS : 
            \Utils\Constants::$LAST_NAME_SPECIAL_CHARS;
        }
        return false;

    }

    /**
     * Verifies if username is correct
     * 
     * @param string $username The username to verify
     * 
     * @return bool|string
     */
    public function checkUsername(string $username): bool|string
    {
        if (strlen($username) > \Utils\Constants::$MAX_USERNAME_LENGTH) {
            return \Utils\Constants::$USERNAME_TOO_LONG;
        } 
        if (strlen($username) < \Utils\Constants::$MIN_USERNAME_LENGTH) {
            return \Utils\Constants::$USERNAME_TOO_SHORT;
        }
        if (str_contains($username, ' ')) {
            return \Utils\Constants::$USERNAME_SPACES;
        }
        if (!preg_match("#^[\p{L}-]*$#", $username)) {
            return \Utils\Constants::$USERNAME_SPECIAL_CHARS;
        }
        $user = $this->_model->findBy($username);
        if ($user) {
            return \Utils\Constants::$USERNAME_ALREADY_TAKEN;
        }
        return false;
    }
    
    /**
     * Verifies if email adress is correct
     * 
     * @param string $email The email adress to verify
     * 
     * @return bool|string
     */
    public function checkEmail(string $email): bool|string
    {
        if (strlen($email) > \Utils\Constants::$MAX_EMAIL_LENGTH) {
            return \Utils\Constants::$EMAIL_TOO_LONG;
        } 
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return \Utils\Constants::$EMAIL_INVALID;
        }
        $user = $this->_model->findBy(strtolower($email));
        if ($user) {
            return \Utils\Constants::$EMAIL_ALREADY_IN_USE;
        }
        return false;
    }

    /**
     * Verifies if passwords are correct
     * 
     * @param int $password      1st password input
     * @param int $conf_password 2nd password input
     * 
     * @return bool|string
     */
    public function checkPassword(string $password, string $conf_password): bool|string
    {
        if ($password !== $conf_password) {
            return \Utils\Constants::$PASSWORD_DO_NOT_MATCH;
        }
        return false;
    }

    /**
     * Verifies if description is correct
     * 
     * @param string $desc The description to verify
     * 
     * @return bool|string
     */
    public function checkDesc(string $desc): bool|string
    {
        if (strlen($desc) > \Utils\Constants::$MAX_DESC_LENGTH) {
            return \Utils\Constants::$DESC_TOO_LONG;
        } 
        if (preg_match("#<|>#", $desc)) {
            return \Utils\Constants::$DESC_SPECIAL_CHARS;
        }
        
        return false;
    }

    /**
     * Verifies if description is correct
     * 
     * @param string $location The description to verify
     * 
     * @return bool|string
     */
    public function checkLocation(string $location): bool|string
    {
        if (strlen($location) > \Utils\Constants::$MAX_LOCATION_LENGTH) {
            return \Utils\Constants::$LOCATION_TOO_LONG;
        } 
        if (!preg_match("#^[\p{L}-]*$#", $location)) {
            return  \Utils\Constants::$LOCATION_SPECIAL_CHARS;
        }

        return false;
    }
    /**
     * Verifies if birthday is valid
     * 
     * @param string $birthday The birthday to verify
     * 
     * @return bool|string
     */
    public function checkBirthday(string $birthday): bool|string
    {
        if (strlen($birthday) != 10) {
            return \Utils\Constants::$BIRTHDAY_REQUIRED;
        }
        if (preg_match("#<|>#", $birthday)) {
            return \Utils\Constants::$BIRTHDAY_REQUIRED;
        }
        return false;
    }
        // ! POST VERIFICATIONS

    /**
     * Verifies if post title is valid
     * 
     * @param string $title The title to verify
     * 
     * @return bool|string
     */
    public function checkTitle(string $title): bool|string
    {
        if (strlen($title) > \Utils\Constants::$MAX_POST_TITLE_LENGTH) {
            return \Utils\Constants::$POST_TITLE_TOO_LONG;
        }
        $title = explode(' ', $title);
        foreach ($title as $title_part) {
            if (!preg_match("#^[\p{L}-]*$#", $title_part)) {
                return \Utils\Constants::$POST_TITLE_SPECIAL_CHARS;
            }
        }
        return false;
    }

    /**
     * Verifies if overview is valid
     * 
     * @param string $overview The overview to verify
     * 
     * @return bool|string
     */
    public function checkOverview(string $overview): bool|string
    {
        if (strlen($overview) > \Utils\Constants::$MAX_POST_OVERVIEW_LENGTH) {
            return \Utils\Constants::$POST_OVERVIEW_TOO_LONG;
        }
        $overview = explode(' ', $overview);
        foreach ($overview as $overview_part) {
            if (!preg_match("#^[\p{L}-]*$#", $overview_part)) {
                return \Utils\Constants::$POST_OVERVIEW_SPECIAL_CHARS;
            }
        }
        return false;
    }

    /**
     * Verifies if content is valid
     * 
     * @param string $content The content to verify
     * 
     * @return bool|string
     */
    public function checkContent(string $content): bool|string
    {
        if (strlen($content) > \Utils\Constants::$MAX_POST_CONTENT_LENGTH) {
            return \Utils\Constants::$POST_CONTENT_TOO_LONG;
        }
        $content = explode(' ', $content);
        foreach ($content as $content_part) {
            if (!preg_match("#^[\p{L}-]*$#", $content_part)) {
                return \Utils\Constants::$POST_CONTENT_SPECIAL_CHARS;
            }
        }
        return false;
    }

    /**
     * Verifies if tags are valid
     * 
     * @param string $tags The tags to verify
     * 
     * @return bool|string
     */
    public function checkTags(string $tags): bool|string
    {
        if (strlen($tags) > \Utils\Constants::$MAX_POST_TAGS_LENGTH) {
            return \Utils\Constants::$POST_TAGS_TOO_LONG;
        }
        if (preg_match("#<|>#", $tags)) {
            return \Utils\Constants::$POST_TAGS_SPECIAL_CHARS;
        }
        return false;
    }
}