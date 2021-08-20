<?php 
/**
 * Comment Form Class File
 * Comment form for users to post comments
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
 * Comment form for users to post comments
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
        self::initForm("comment", $type, "d-flex flex-column w-full form-floating px-3 col w-75 h-75", "post", $page_params);

        if (!isset($comment_content)) {
            $comment_content = "";
        }
        
        self::createTextArea(
            [
            "name" => "comment_content",
            "class" => "form-control",
            "required" => true,
            "maxlength" => \Utils\Constants::$MAX_COMMENT_LENGTH,
            "value" => $comment_content,
            "class" => "p-2 my-1 col-sm-8 w-full form-control",
            "style" => "min-height: 150px"
            ]
        );
        
        self::endForm("Poster", "border-0, btn btn-primary w-full my-2");
        return $this->form;
    }
}