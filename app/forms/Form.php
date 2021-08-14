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
     * @param string $classes     Classes to apply to form 
     * @param string $method      (Optional) The method to transfer data (Default is "post")
     * @param array  $page_params (Optional) Additionnal informations for form's action
     * @param string $enctype     (Optional) Set to multipart/form-data if form will transfer a file
     * 
     * @return void
     */
    public function initForm(string $page, string $action, string $classes, ?string $method = "post", ?array $page_params = [], string $enctype = null): void
    {
        $form = "<form method='$method' ";

        if (isset($enctype)) {
            $form .= "enctype=$enctype";
        }

        $form .= " class=\"$classes\"";

        $form .= " action='index.php?page=$page&action=$action";
        foreach ($page_params as $key => $value) {
            $form .= "&$key=$value";
        }

        $form .= "'";
        
        $formatted_params = array();
        
        foreach ($page_params as $param => $param_value) {
            array_push($formatted_params, $param . "=" . $param_value);
        }

        foreach ($formatted_params as $param) {
            $form .= "&" . $param;
        }

        $form .= "'>";
        $this->form .= $form;
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

        $this->form .= "<input id='$name-Field''";

        foreach ($params as $param => $value) {
            if (is_array($value)) {
                $formatted_value = implode(" ", $value);
                $this->form .= " $param=\"$formatted_value\"";
            } else {
                $this->form .= " $param=\"$value\"";
            }
        }
        $this->form .= "/>";
        $this->form .= "<label class='form-label' for='$name-Field'>";
        $this->form .= "</label>";
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

        $this->form .= "<textarea name='$name'";
        foreach ($params as $param => $key) {
            if (is_array($key)) {
                $formatted_key = implode(" ", $key);
                $this->form .= " $param=\"$formatted_key\"";
            } else {
                $this->form .= " $param=\"$key\"";
            }
        }
        if (!isset($value)) {
            $value = "";
        }
        $this->form .= ">$value</textarea>";
        $this->form .= "<label class='ms-4 w-full' for=$name>";
        if (isset($label)) {
            $this->form .= $label;
        }

        if (!isset($value)) {
            $value = "";
        }
        $this->form .= "</label>";
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

    /**
     * Creates an html element above the form
     * 
     * @param string $element The element to create
     * @param string $value   The text displayed in the element
     * @param array  $props   Custom properties applied to element
     * 
     * @return void
     */
    public function createElement(string $element, string $value, ?array $props = []): void
    {
        $html = "<$element";
        foreach ($props as $prop => $key) {
            $html .= " $prop=\"$key\"";
        }
        $html .= ">$value</$element>";
        $this->form .= $html;
    }
}