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
     * @return array<bool,string|null>
     */
    public function checkName(string $name, ?bool $first = false): array
    {
        if (strlen($name) > \Utils\Constants::$MAX_NAME_LENGTH) {
            return ["state" => false, "message" => $first ? 
            \Utils\Constants::$FIRST_NAME_TOO_LONG : 
            \Utils\Constants::$LAST_NAME_TOO_LONG];
        }

        if (htmlspecialchars($name) !== $name || str_contains($name, "@")) {
            return ["state" => false, "message" => $first ? 
            \Utils\Constants::$FIRST_NAME_SPECIAL_CHARS : 
            \Utils\Constants::$LAST_NAME_SPECIAL_CHARS];
        }
        return ["state" => true, "message" => null];

    }

    /**
     * Verifies if username is correct
     * 
     * @param string $username The username to verify
     * 
     * @return array<bool,string|null>
     */
    public function checkUsername(string $username): array
    {
        if (strlen($username) > \Utils\Constants::$MAX_USERNAME_LENGTH) {
            return ["state" => false, "message" => \Utils\Constants::$USERNAME_TOO_LONG];
        } 
        if (strlen($username) < \Utils\Constants::$MIN_USERNAME_LENGTH) {
            return ["state" => false, "message" =>
            \Utils\Constants::$USERNAME_TOO_SHORT];
        }
        if (htmlspecialchars($username) !== $username || str_contains($username, "@")) {
            return ["state" => false, "message" =>
            \Utils\Constants::$USERNAME_SPECIAL_CHARS];
        }
        $user = $this->_model->findBy($username);
        if ($user) {
            return ["state" => false, "message" =>
            \Utils\Constants::$USERNAME_ALREADY_TAKEN];
        }
        return ["state" => true, "message" => null];
    }
    
    /**
     * Verifies if email adress is correct
     * 
     * @param string $email The email adress to verify
     * 
     * @return array<bool,string|null>
     */
    public function checkEmail(string $email): array
    {
        if (strlen($email) > \Utils\Constants::$MAX_EMAIL_LENGTH) {
            return ["state" => false, "message" => \Utils\Constants::$EMAIL_TOO_LONG];
        } 
        if (htmlspecialchars($email) !== $email) {
            return ["state" => false, "message" =>
            \Utils\Constants::$EMAIL_SPECIAL_CHARS];
        }
        $user = $this->_model->findBy(strtolower($email));
        if ($user) {
            return ["state" => false, "message" =>
            \Utils\Constants::$EMAIL_ALREADY_IN_USE];
        }
        return ["state" => true, "message" => null];
    }

    /**
     * Verifies if passwords are correct
     * 
     * @param int $password      1st password input
     * @param int $conf_password 2nd password input
     * 
     * @return array<bool,string|null>
     */
    public function checkPassword(string $password, string $conf_password)
    {
        if ($password !== $conf_password) {
            return ["state" => false, "message" =>
            \Utils\Constants::$PASSWORD_DO_NOT_MATCH];
        }
        if (htmlspecialchars($password) !== $password) {
            return ["state" => false, "message" =>
            \Utils\Constants::$PASSWORD_CHARS];
        }
        return ["state" => true, "message" => null];
    }

    /**
     * Verifies if description is correct
     * 
     * @param string $desc The description to verify
     * 
     * @return array<bool,string|null>
     */
    public function checkDesc(string $desc): array
    {
        if (strlen($desc) > \Utils\Constants::$MAX_DESC_LENGTH) {
            return ["state" => false, "message" => \Utils\Constants::$DESC_TOO_LONG];
        } 
        if (htmlspecialchars($desc) !== $desc) {
            return ["state" => false, "message" =>
            \Utils\Constants::$DESC_SPECIAL_CHARS];
        }
        
        return ["state" => true, "message" => null];
    }

    /**
     * Verifies if description is correct
     * 
     * @param string $location The description to verify
     * 
     * @return array<bool,string|null>
     */
    public function checkLocation(string $location): array
    {
        if (strlen($location) > \Utils\Constants::$MAX_LOCATION_LENGTH) {
            return ["state" => false, "message" => \Utils\Constants::$LOCATION_TOO_LONG];
        } 
        if (htmlspecialchars($location) !== $location) {
            return ["state" => false, "message" =>
            \Utils\Constants::$LOCATION_SPECIAL_CHARS];
        }

        return ["state" => true, "message" => null];
    }
    /**
     * Verifies if birthday is valid
     * 
     * @param string $birthday The birthday to verify
     * 
     * @return array<bool,string|null>
     */
    public function checkBirthday(string $birthday): array
    {
        if (strlen($birthday) != 10) {
            return ["state" => false, "message" =>
            \Utils\Constants::$BIRTHDAY_REQUIRED];
        }
        if (htmlspecialchars($birthday) !== $birthday) {
            return ["state" => false, "message" =>
            \Utils\Constants::$BIRTHDAY_REQUIRED];
        }
        return ["state" => true, "message" => null];
    }
        // ! POST VERIFICATIONS

    /**
     * Verifies if post title is valid
     * 
     * @param string $title The title to verify
     * 
     * @return array<bool,string|null>
     */
    public function checkTitle(string $title): array
    {
        if (strlen($title) > \Utils\Constants::$MAX_POST_TITLE_LENGTH) {
            return ["state" => false, "message" => \Utils\Constants::$POST_TITLE_TOO_LONG];
        }
        if (htmlspecialchars($title) !== $title) {
            return ["state" => false, "message" => \Utils\Constants::$POST_TITLE_SPECIAL_CHARS];
        }
        return ["state" => true, "message" => null];
    }

    /**
     * Verifies if overview is valid
     * 
     * @param string $overview The overview to verify
     * 
     * @return array<bool,string|null>
     */
    public function checkOverview(string $overview): array
    {
        if (strlen($overview) > \Utils\Constants::$MAX_POST_OVERVIEW_LENGTH) {
            return ["state" => false, "message" => \Utils\Constants::$POST_OVERVIEW_TOO_LONG];
        }
        if (htmlspecialchars($overview) !== $overview) {
            return ["state" => false, "message" => \Utils\Constants::$POST_OVERVIEW_SPECIAL_CHARS];
        }
        return ["state" => true, "message" => null];
    }

    /**
     * Verifies if content is valid
     * 
     * @param string $content The content to verify
     * 
     * @return array<bool,string|null>
     */
    public function checkContent(string $content):array
    {
        if (htmlspecialchars($content) !== $content) {
            return ["state" => false, "message" => \Utils\Constants::$POST_CONTENT_SPECIAL_CHARS];
        }
        return ["state" => true, "message" => null];
    }

    /**
     * Verifies if tags are valid
     * 
     * @param string $tags The tags to verify
     * 
     * @return array<bool,string|null>
     */
    public function checkTags(string $tags): array
    {
        if (strlen($tags) > \Utils\Constants::$MAX_POST_TAGS_LENGTH) {
            return ["state" => false, "message" => \Utils\Constants::$POST_TAGS_TOO_LONG];
        }
        if (htmlspecialchars($tags) !== $tags) {
            return ["state" => false, "message" => \Utils\Constants::$POST_TAGS_SPECIAL_CHARS];
        }
        return ["state" => true, "message" => null];
    }
}