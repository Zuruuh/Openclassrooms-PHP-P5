<?php
/**
 * Error Class File 
 * Class for error management
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
 * Error Class
 * Class for error management
 * PHP version 8.0.9
 *
 * @category Utils
 * @package  Utils
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */
class Errors
{

    /**
     * Displays all errors in session
     * 
     * @return string
     */
    public static function displayErrors(): string
    {
        $errors = \Utils\Http::getSession("errors");

        $page_errors = array();
        if (!is_array($errors)) {
            return "";
        }
        $i = 0;
        foreach ($errors as $error) {
            $text = $error[0];
            $type = $error[1];
            $element = \Utils\ElementBuilder::buildToast($text, $type);
            array_push($page_errors, $element);
        }
        
        $page_errors = implode("", $page_errors);

        \Utils\Http::unsetSession("errors");
        return $page_errors;
    }

    /**
     * Adds an error to session
     * 
     * @param string $text The error message
     * @param string $type (Optional) The type of the error, default is "danger"
     * 
     * @return void
     */
    public static function addError(string $text, string $type = "danger"): void
    {
        \Utils\Http::addToSession("errors", [$text, $type]);
    }

}