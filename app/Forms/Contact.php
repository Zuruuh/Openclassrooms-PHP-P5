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

        self::initForm("contact", $type, "form-floating container w-100 d-flex flex-column align-items-center", "post", $page_params);

        self::createField(
            [
                "name" => "name",
                "type" => "text",
                "placeholder" => "Nom & Prénom",
                "maxlength" => (\Utils\Constants::$MAX_NAME_LENGTH*2),
                "required" => true,
                "class" => "p-2 my-1 col-12 col-md-10"
            ]
        );

        self::createField(
            [
                "name" => "email",
                "type" => "email",
                "placeholder" => "adresse@mail.com",
                "required" => true,
                "maxlength" => \Utils\Constants::$MAX_EMAIL_LENGTH,
                "class" => "p-2 my-1 col-12 col-md-10"
            ]
        );

        self::createField(
            [
                "name" => "subject",
                "type" => "text",
                "placeholder" => "Demande d'informations..",
                "required" => true,
                "maxlength" => (\Utils\Constants::$MAX_NAME_LENGTH*2),
                "class" => "p-2 my-1 col-12 col-md-10"
            ]
        );

        self::createTextArea(
            [
                "name" => "message_content",
                "placeholder" => "Bonjour, je vous contacte pour..",
                "required" => true,
                "maxlength" => \Utils\Constants::$MAX_MESSAGE_SIZE,
                "class" => "p-2 my-1 col-12 col-md-10 contact-form"
            ]
        );

        self::endForm("Envoyer !", "btn btn-primary");
        return $this->form;
    }
}