<?php
/**
 * Renderer Class File
 * Class for html render
 * PHP version 8.0.9
 *
 * @category Utils
 * @package  Utils
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */

namespace Utils;

/**
 * Renderer Class
 * Class for html render
 * PHP version 8.0.9
 *
 * @category Utils
 * @package  Utils
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */

class Renderer
{
    /**
     * Renders a template file
     * 
     * @param string $path       Path to template file rendered
     * @param string $page_title Page title
     * @param array  $content    Page content & layout 
     * @param array  $forms      All forms available on page
     * 
     * @return void
     */
    public static function render(string $path, ?string $page_title = "Blog", ?array $content = ["form_type" => "create", "values" => []], ?array $forms = null): void
    {
        extract($content);

        if (!isset($values)) {
            $values = [];
        }

        if (!isset($form_type)) {
            $form_type = "create";
        }

        $page_forms = array();
        if (isset($forms)) {
            foreach ($forms as $formClass) {
                $form = new $formClass();
                if (!isset($page_params)) {
                    $page_params = [];
                }
                array_push($page_forms, $form->generateForm($form_type, $page_params, $values));
            }
        } else {
            $page_forms = null;
        }
        $page_errors = \Utils\Errors::displayErrors();
        if (!isset($page_errors)) {
            $page_errors = "";
        }
        ob_start();
        include "app/views/" . $path . ".html.php";
        $page_content = ob_get_clean();

        ob_start();
        include "app/views/layout/Navbar.html.php";
        $page_layout = ob_get_clean();

        ob_start();
        include "app/views/layout/Footer.html.php";
        $page_footer = ob_get_clean();

        include "app/views/Template.html.php";
    }
}