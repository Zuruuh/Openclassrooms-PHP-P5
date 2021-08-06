<?php 
/**
 * Login Form Class File
 * Login form for users to log in
 * PHP version 8.0.9
 *
 * @category Forms
 * @package  Forms
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */

namespace Forms;

/**
 * Login Form Class
 * Login form for users to log in
 * PHP version 8.0.9
 *
 * @category Forms
 * @package  Forms
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */
class Login extends \Forms\Form
{
    /**
     * Returns login form
     * 
     * @return string
     */
    public function generateForm(): string
    {
        self::initForm("user", "login", "post");
        self::createField(
            [
            "name" => "email",
            "label" => "Entrez votre adresse mail: ",
            "type" => "email",
            "maxlength" => \Utils\Constants::$MAX_EMAIL_LENGTH,
            "placeholder" => "Votre adresse mail..",
            "required" => true
            ]
        );
        self::createField(
            [
            "name" => "password",
            "label" => "Entrez votre mot de passe: ",
            "type" => "password",
            "placeholder" => "Votre mot de passe..",
            "required" => true
            ]
        );

        self::endForm("Me connecter");
        return $this->form;
    }
}