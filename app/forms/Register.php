<?php 
/**
 * Register Form Class File
 * Register form for users to sign up
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
 * Register Form Class
 * Register form for users to sign up
 * PHP version 8.0.9
 *
 * @category Forms
 * @package  Forms
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */
class Register extends \Forms\Form
{
    /**
     * Returns register form
     * 
     * @return string
     */
    public function generateForm(): string
    {
        self::createElement("header", "Inscrivez-vous", ["class" => "fs-2"]);
        self::initForm("user", "register", "form-floating container w-100 px-5 d-flex flex-column align-items-center");

        self::createField(
            [
            "name" => "first_name",
            "type" => "text",
            "maxlength" => \Utils\Constants::$MAX_NAME_LENGTH,
            "placeholder" => "Votre prénom..",
            "required" => true,
            "class" => "p-2 my-1 col-md-6"
            ]
        );

        self::createField(
            [
            "name" => "last_name",
            "type" => "text",
            "maxlength" => \Utils\Constants::$MAX_NAME_LENGTH,
            "placeholder" => "Votre nom..",
            "required" => true,
            "class" => "p-2 my-1 col-md-6"
            ]
        );
        
        self::createField(
            [
            "name" => "username",
            "type" => "text",
            "maxlength" => \Utils\Constants::$MAX_USERNAME_LENGTH,
            "minlength" => \Utils\Constants::$MIN_USERNAME_LENGTH,
            "placeholder" => "Votre pseudonyme..",
            "required" => true,
            "class" => "p-2 my-1 col-md-6"
            ]
        );

        self::createField(
            [
            "name" => "email",
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
            "type" => "password",
            "placeholder" => "Votre mot de passe..",
            "required" => true,
            "class" => "p-2 my-1 col-md-6"
            ]
        );

        self::createField(
            [
            "name" => "password_conf",
            "type" => "password",
            "placeholder" => "Confirmez votre mot de passe..",
            "required" => true,
            "class" => "p-2 my-1 col-md-6"
            ]
        );

        self::createField(
            [
            "name" => "birthday",
            "type" => "date",
            "placeholder" => "Votre anniversaire..",
            "required" => true,
            "class" => "p-2 my-1 col-md-6"
            ]
        );

        self::endForm("M'inscrire", "btn btn-primary mt-2");
        self::createElement("p", "Vous déjà un compte ? Cliquez <a href='index.php?page=user&action=login'>ici</a> pour vous connecter !", ["class" => "px-4 pt-2 text-break text-start"]);
        return $this->form;
    }
}