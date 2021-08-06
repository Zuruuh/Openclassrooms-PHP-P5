<?php 
/**
 * Comment Form Class File
 * Comment form for users to sign up
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
 * Comment Form Class
 * Comment form for users to sign up
 * PHP version 8.0.9
 *
 * @category Forms
 * @package  Forms
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */
class Comment extends \Forms\Form
{
    /**
     * Returns Comment form
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

        self::initForm("comment", $type, "post", $page_params);

        if (!isset($post_title)) {
            $post_title = "";
        }
        if (!isset($post_overview)) {
            $post_overview = "";
        }
        if (!isset($post_content)) {
            $post_content = "";
        }
        if (!isset($post_tags)) {
            $post_tags = "";
        }
        
        self::createTextArea(
            [
            "name" => "comment_content",
            "label" => "Ecrivez votre commentaire: ",
            "placeholder" => "Votre commentaire..",
            "required" => true,
            "maxlength" => \Utils\Constants::$MAX_COMMENT_LENGTH
            ]
        );
        
        self::endForm("Poster");
        return $this->form;
    }
}