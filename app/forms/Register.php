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
        self::initForm("user", "register", "post");
        self::createField(
            [
            "name" => "first_name",
            "label" => "Entrez votre prénom: ",
            "type" => "text",
            "maxlength" => \Utils\Constants::$MAX_NAME_LENGTH,
            "placeholder" => "Votre prénom..",
            "required" => true
            ]
        );

        self::createField(
            [
            "name" => "last_name",
            "label" => "Entrez votre nom: ",
            "type" => "text",
            "maxlength" => \Utils\Constants::$MAX_NAME_LENGTH,
            "placeholder" => "Votre nom..",
            "required" => true
            ]
        );
        
        self::createField(
            [
            "name" => "username",
            "label" => "Entrez votre pseudonyme: ",
            "type" => "text",
            "maxlength" => \Utils\Constants::$MAX_USERNAME_LENGTH,
            "minlength" => \Utils\Constants::$MIN_USERNAME_LENGTH,
            "placeholder" => "Votre pseudonyme..",
            "required" => true
            ]
        );

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

        self::createField(
            [
            "name" => "password_conf",
            "label" => "Confirmez votre mot de passe: ",
            "type" => "password",
            "placeholder" => "Votre mot de passe..",
            "required" => true
            ]
        );

        self::createField(
            [
            "name" => "birthday",
            "label" => "Votre date de naissance: ",
            "type" => "date",
            "placeholder" => "Votre anniversaire..",
            "required" => true
            ]
        );

        self::endForm("M'inscrire");
        return $this->form;
    }
}