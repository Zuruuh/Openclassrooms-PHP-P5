<?php
/**
 * Form Class File
 * Abstract class containing default actions for other forms
 * PHP version 8.0.9
 *
 * @category Forms
 * @package  Forms
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */

namespace Forms;
require_once "app/utils/autoload.php";

/**
 * Form Class
 * Abstract class containing default actions for other forms
 * PHP version 8.0.9
 *
 * @category Forms
 * @package  Forms
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */
abstract class Form
{
    protected $form;

    /**
     * Initializes form by creating it
     * 
     * @param string $page        The page the form will redirect to
     * @param string $action      The action the form will execute
     * @param string $method      (Optional) The method to transfer data (Default is "post")
     * @param array  $page_params (Optional) Additionnal informations for form's action
     * 
     * @return void
     */
    public function initForm(string $page, string $action, ?string $method = "post", ?array $page_params = []): void
    {
        $form = "<form method='$method' action='index.php?page=$page&action=$action";
        
        $formatted_params = array();
        
        foreach ($page_params as $param => $param_value) {
            array_push($formatted_params, $param . "=" . $param_value);
        }

        foreach ($formatted_params as $param) {
            $form .= "&" . $param;
        }

        $form .= "'>";
        $this->form = $form;
    }

    /**
     * Adds a new field to form
     * 
     * @param array $params The settings of the field
     * 
     * @return void
     */
    public function createField(array $params = ["name" => "field", "type" => "text", "value" => ""]): void
    {
        extract($params);
        $this->form .= "<label for=$name>";
        if (isset($label)) {
            $this->form .= $label;
        }
        if (!isset($value)) {
            $value = "";
        }

        $this->form .= "<input type=$type value='$value' name='$name'";
        if (isset($maxlength)) {
            $this->form .= " maxlength='$maxlength'";
        }
        if (isset($minlength)) {
            $this->form .= " minlength='$minlength'";
        }
        if (isset($placeholder)) {
            $this->form .= " placeholder='$placeholder'";
        }
        if (isset($oninput)) {
            $this->form .= " oninput='$oninput'";
        }
        if (isset($accept)) {
            $accept = implode(", ", $accept);
            $this->form .= " accept='$accept'";
        }
        if (isset($required)) {
            $this->form .= " required";
        }
        $this->form .= "/></label>";
    }

    /**
     * Adds a new text area to form
     * 
     * @param array $params The settings of the text area
     * 
     * @return void
     */
    public function createTextArea(array $params = ["name" => "field", "value" => ""]): void
    {
        extract($params);
        $this->form .= "<label for=$name>";
        if (isset($label)) {
            $this->form .= $label;
        }

        if (!isset($value)) {
            $value = "";
        }

        if ($required) {
            $required = "required";
        } else {
            $required = "";
        }

        $this->form .= "<textarea name='$name' $required";
        if (isset($maxlength)) {
            $this->form .= " maxlength='$maxlength'";
        }
        if (isset($minlength)) {
            $this->form .= " minlength='$minlength'";
        }
        if (isset($placeholder)) {
            $this->form .= " placeholder='$placeholder'";
        }
        if (isset($required)) {
            $this->form .= " required";
        }
        $this->form .= ">$value</textarea></label>";
    }

    /**
     * Finishes form creation
     * 
     * @param string $value   The text value displayed in the submit button
     * @param string $classes Custom classes applied to submit button
     * 
     * @return void
     */
    public function endForm(string $value, ?string $classes = ""): void
    {
        $this->form .= "<button type='submit' value='submit' name='submit' class='$classes'>$value</button>";
        $this->form .= "</form>";
    }

}