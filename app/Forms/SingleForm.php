<?php 
/**
 * Single Field Form File
 * Single Field Form used to change password & email
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
 * Single Field Form Class
 * Single Field Form used to change password & email
 * PHP version 8.0.9
 *
 * @category Forms
 * @package  Forms
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */
class SingleForm extends \Forms\Form
{
    /**
     * Returns a single field
     * 
     * @param string $type        The action the form should perform
     * @param array  $page_params Additionnal params for form's action
     * @param array  $values      Values to pre-fill form
     * 
     * @return string
     */
    public function generateForm(?string $type = "edit", ?array $page_params = [],?array $values = []): string
    {
        extract($values);

        $params = [];

        if (isset($token)) {
            $params["token"] = $token;
        }

        if (!isset($form_type)) {
            $form_type = "forgotPassword";
        }

        if (isset($header)) {
            self::createElement($header["element"], $header["value"], $header["props"]);
        }
        if (isset($footer)) {
            self::createElement($footer["element"], $footer["value"], $footer["props"]);
        }

        self::initForm("user", $form_type, "fform-floating container w-100 px-5 d-flex flex-column align-items-center", "post", $params);
        
        foreach ($fields as $field) {
            extract($field);
            $field_params = array();
            foreach ($field as $value => $key) {
                $field_params[$value] = $key;
            }
            self::createField($field_params);
        }

        self::endForm("Confirmer", "btn btn-primary mt-2");

        return $this->form;
    }
}