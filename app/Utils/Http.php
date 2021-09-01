<?php
/**
 * Http Class File
 * Class for url manipulation and redirection
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
 * Http Class
 * Class for url manipulation and redirection
 * PHP version 8.0.9
 *
 * @category Utils
 * @package  Utils
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */
class Http
{
    /** 
     * Redirects user to location
     * 
     * @param string $url The page to redirect the user to
     * 
     * @return void
     */
    public static function redirect(string $url): void
    {
        header("Location: " . $url);
        exit();
    }

    /**
     * Verifies if specific param exists 
     * 
     * @param string $value  Value to verify
     * @param string $method Specifies if value is passed in GET or POST
     * 
     * @return bool|string
     */
    public static function getParam(string $value, ?string $method = "post"): bool|string
    {
        if ($method === "post") {
            if (!isset($_POST[$value])) {
                return false;
            }
            return str_replace("/", "", htmlspecialchars($_POST[$value]));
        }
        if (!isset($_GET[$value])) {
            return false;
        }
        return str_replace("/", "", htmlspecialchars($_GET[$value]));
    }

    /**
     * Gets item in session if exists, returns false if item isn't set
     * 
     * @param string $value Value searched in session
     * 
     * @return mixed
     */
    public static function getSession(string $value): mixed
    {
        if (!isset($_SESSION[$value])) {
            return false;
        }
        return $_SESSION[$value];
    }

    /**
     * Sets item in session
     * 
     * @param string $key   Name of key-value pair stored in session
     * @param string $value Value of key-value pair
     * 
     * @return void
     */
    public static function setSession(string $key, string $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Adds item to session
     * 
     * @param string $key   Name of key-value pair stored in session
     * @param mixed  $value Value of key-value pair
     * 
     * @return void
     */
    public static function addToSession(string $key, mixed $value): void
    {
        if (!isset($_SESSION[$key])) {
            $_SESSION[$key] = array();
        }
        array_push($_SESSION[$key], $value);
    }

    /**
     * Unsets item in session
     * 
     * @param string $value Value to unset
     * 
     * @return void
     */
    public static function unsetSession(string $value): void
    {
        unset($_SESSION[$value]);
    }

    /**
     * Verifies if session is correct
     * 
     * @return bool
     */
    public static function isSessionCorrect(): bool
    {
        $sess = self::getSession("user_id");
        if (!$sess) {
            return false;
        }
        if (!str_contains($sess, "|")) {
            return false;
        }
        $sess = explode("|", self::getSession("user_id"));
        $user_model = new \Models\User();
        $user = $user_model->find((int) $sess[0]);
        if (!$user) {
            return false;
        }

        if ($sess[1] === $user["password"]) {
            if (intval($user["disabled"]) === 1) {
                // ! User was banned, unset session
                self::unsetSession("user_id");
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * Verifies if session is correct
     * 
     * @return bool
     */
    public static function isAdmin(): bool
    {
        $sess = self::getSession("user_id");
        if (!$sess) {
            return false;
        }
        if (!str_contains($sess, "|")) {
            return false;
        }
        $sess = explode("|", self::getSession("user_id"));
        $user_model = new \Models\User();
        $user = $user_model->find(intval($sess[0]));
        if (!$user) {
            return false;
        }

        if ($sess[1] !== $user["password"]) {
            return false;
        }

        return $user["is_admin"];
    }


    /**
     * Gets item in cookies if exists, returns false if item isn't set
     * 
     * @param string $value Value searched in cookies
     * 
     * @return bool|string
     */
    public static function getCookie(string $value): bool|string
    {
        if (!isset($_COOKIE[$value])) {
            return false;
        }
        return str_replace("/", "", htmlspecialchars($_COOKIE[$value]));
    }

    /**
     * Sets item in cookies
     * 
     * @param string $key   Name of key-value pair stored in cookies
     * @param string $value Value of key-value pair
     * 
     * @return void
     */
    public static function setCookie(string $key, string $value): void
    {
        $_COOKIE[$key] = $value;
    }

    /**
     * Unsets item in cookies
     * 
     * @param string $value Value to unset
     * 
     * @return void
     */
    public static function unsetCookie(string $value): void
    {
        unset($_COOKIE[$value]);
    }

    /**
     * Validates a token or not
     * 
     * @param string $TOKEN Token to validate
     * @param mixed  $model User model
     * 
     * @return int
     */
    public static function validateToken(string $TOKEN, mixed $model): int
    {
        $TOKEN = base64_decode($TOKEN);
        if (!str_contains($TOKEN, "|§§§|")) {
            \Utils\Errors::addError(\Utils\Constants::$INVALID_TOKEN);
            \Utils\Http::redirect("index.php?page=user&action=forgotPassword");
            return 0;
        }

        $TOKEN = explode("|§§§|", $TOKEN);
        $EMAIL = mb_convert_encoding($TOKEN[1], "ISO-8859-15");
        $PASSWORD = mb_convert_encoding($TOKEN[0], "ISO-8859-15");

        $user = $model->findBy($EMAIL);
        if (!$user) {
            \Utils\Errors::addError(\Utils\Constants::$INVALID_TOKEN);
            \Utils\Http::redirect("index.php?page=user&action=forgotPassword");
            return 0;
        }

        if ($user["password"] !== $PASSWORD) {
            \Utils\Errors::addError(\Utils\Constants::$INVALID_TOKEN);
            \Utils\Http::redirect("index.php?page=user&action=forgotPassword");
            return 0;
        }
        return $user["id"];
    }

}

