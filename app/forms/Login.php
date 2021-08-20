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
        self::createElement("header", "Connectez-vous", ["class" => "fs-2"]);
        self::initForm("user", "login", "form-floating container w-100 px-5 d-flex flex-column align-items-center");
        self::createField(
            [
                "name" => "email",
                "label" => "Entrez votre adresse mail: ",
                "type" => "email",
                "maxlength" => \Utils\Constants::$MAX_EMAIL_LENGTH,
                "placeholder" => "Votre adresse mail..",
            "required" => true,
            "class" => "p-2 my-1 col-md-6"
            ]
        );
        self::createField(
            [
                "name" => "password",
                "label" => "Entrez votre mot de passe: ",
                "type" => "password",
                "placeholder" => "Votre mot de passe..",
                "required" => true,
            "class" => "p-2 my-1 col-md-6"
            ]
        );

        self::endForm("Me connecter", "btn btn-primary mt-2");
        self::createElement("p", "Vous n'avez pas encore de compte ? Cliquez <a href='index.php?page=user&action=register'>ici</a> pour vous en créer un !", ["class" => "px-4 pt-2 text-break text-start"]);
        self::createElement("p", "Vous avez oublié votre mot de passe ? Cliquez <a href='index.php?page=user&action=forgotPassword'>ici</a> pour le réinitialiser.", ["class" => "px-4 pt-2 text-break text-start"]);
        return $this->form;
    }
}