<?php
/**
 * Home Controller Class File
 * Controller file for Home component
 * PHP version 8.0.9
 *
 * @category Controllers
 * @package  Controllers
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */

namespace Controllers;

/**
 * Home Controller Class
 * Controller class for Home component
 * PHP version 8.0.9
 *
 * @category Controllers
 * @package  Controllers
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */
class Contact extends Controller
{
    
    /**
     * Returns default home page
     *
     * @return void
     */
    public function create():void
    {
        // ! 1 => Verif infos
        $values = [
            "name",
            "email",
            "subject",
            "message_content"
        ];


        $input_errors = array();
        foreach ($values as $value) {
            if (!\Utils\Http::getParam($value)) {
                array_push($input_errors, $value);
            }
        }
        if (!empty($input_errors)) {
            // * Return error message
            \Utils\Http::redirect("index.php");
        }
        unset($input_errors);
        
        $NAME = htmlspecialchars(\Utils\Http::getParam("name"));
        $EMAIL = htmlspecialchars(\Utils\Http::getParam("email"));
        $SUBJECT = htmlspecialchars(\Utils\Http::getParam("subject"));
        $MESSAGE_CONTENT = htmlspecialchars(\Utils\Http::getParam("message_content"));

        $check_errors = array();

        if (strlen($NAME) > (\Utils\Constants::$MAX_NAME_LENGTH*2) ) {
            array_push($check_errors, \Utils\Constants::$NAME_TOO_LONG);
        }
        if (strlen($EMAIL) > \Utils\Constants::$MAX_EMAIL_LENGTH) {
            array_push($check_errors, \Utils\Constants::$EMAIL_TOO_LONG);
        }
        if (!str_contains($EMAIL, "@")) {
            array_push($check_errors, \Utils\Constants::$EMAIL_INVALID);
        }
        if (strlen($SUBJECT) > (\Utils\Constants::$MAX_NAME_LENGTH*2)) {
            array_push($check_errors, \Utils\Constants::$SUBJECT_TOO_LONG);
        }
        if (strlen($MESSAGE_CONTENT) > \Utils\Constants::$MAX_MESSAGE_SIZE) {
            array_push($check_errors, \Utils\Constants::$MESSAGE_TOO_LONG);
        }

        if (!empty($check_errors)) {
            // * Return error message
            \Utils\Http::redirect("index.php");
        }

        // ! 2 => Prepare mail
    
        $mail = \Utils\Mail::initMail();
        $mail .= \Utils\Mail::createElement("p", "Blog - Mail Recu de la part de: $NAME", [], true);
        $mail .= \Utils\Mail::createElement("p", "Adresse pour reprise de contact: $EMAIL", [], true);
        $mail .= \Utils\Mail::createElement("p", "$MESSAGE_CONTENT");

        \Utils\Mail::sendEmail("ziadi.mail.pro@gmail.com", $SUBJECT, $mail);

        // ? Redirect with confirmation message
        \Utils\Http::redirect("index.php");



    }
}