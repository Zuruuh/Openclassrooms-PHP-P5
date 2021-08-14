<?php 
/**
 * Contact Form Class File
 * Contact form for users contact you directly from the website
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
 * Contact Form Class
 * Contact form for users contact you directly from the website
 * PHP version 8.0.9
 *
 * @category Forms
 * @package  Forms
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */
class Contact extends \Forms\Form
{
    /**
     * Returns post form
     * 
     * @param string $type        The action the form should perform
     * @param array  $page_params Additionnal params for form's action
     * @param array  $values      Values to pre-fill form
     * 
     * @return string
     */
    public function generateForm(?string $type = "create", ?array $page_params = [],?array $values = []): string
    {

        extract($values);
        if (!isset($page_params)) {
            $page_params = [];
        }

        self::initForm("contact", $type, "needs-validation", "post", $page_params);

        self::createField(
            [
                "name" => "name",
                "label" => "Entrez votre nom et prénom: ",
                "type" => "text",
                "placeholder" => "Nom & Prénom",
                "maxlength" => (\Utils\Constants::$MAX_NAME_LENGTH*2),
                "required" => true
            ]
        );

        self::createField(
            [
                "name" => "email",
                "label" => "Entrez votre adresse mail: ",
                "type" => "email",
                "placeholder" => "adresse@mail.com",
                "required" => true,
                "maxlength" => \Utils\Constants::$MAX_EMAIL_LENGTH
            ]
        );

        self::createField(
            [
                "name" => "subject",
                "label" => "Objet: ",
                "type" => "text",
                "placeholder" => "Demande d'informations..",
                "required" => true,
                "maxlength" => (\Utils\Constants::$MAX_NAME_LENGTH*2)
            ]
        );

        self::createTextArea(
            [
                "name" => "message_content",
                "label" => "Votre message",
                "placeholder" => "Bonjour, je vous contacte pour..",
                "required" => true,
                "maxlength" => \Utils\Constants::$MAX_MESSAGE_SIZE
            ]
        );

        self::endForm("Envoyer !");
        return $this->form;
    }
}