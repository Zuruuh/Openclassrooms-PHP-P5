<?php
/**
 * Class Autoloader
 * Automatically imports all required classes in file
 * PHP version 8.0.9
 *
 * @category Utils
 * @package  Utils
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */

namespace Utils;

spl_autoload_register(
    function ($className) {
        $className = str_replace("\\", "/", $className);
        include_once "app/$className.php";
    }
);