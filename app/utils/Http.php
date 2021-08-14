<?php
/**
 * Http Class File
 * Class for url manipulation and redirection
 * PHP version 8.0.9
 *
 * @category Controllers
 * @package  Controllers
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
 * @category Controllers
 * @package  Controllers
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
            return htmlspecialchars($_POST[$value]);
        }
        if (!isset($_GET[$value])) {
            return false;
        }
        return htmlspecialchars($_GET[$value]);
    }

    /**
     * Gets item in session if exists, returns false if item isn't set
     * 
     * @param string $value Value searched in session
     * 
     * @return bool|string
     */
    public static function getSession(string $value): bool|string
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
        $user = $user_model->find(intval($sess[0]));
        if (!$user) {
            return false;
        }

        if ($sess[1] === $user["password"]) {
            return true;
        }
        return false;
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
        return $_COOKIE[$value];
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

}

