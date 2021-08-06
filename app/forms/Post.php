<?php 
/**
 * Post Form Class File
 * Post form for users to sign up
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
 * Post Form Class
 * Post form for users to sign up
 * PHP version 8.0.9
 *
 * @category Forms
 * @package  Forms
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */
class Post extends \Forms\Form
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

        self::initForm("post", $type, "post", $page_params);

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
        
        self::createField(
            [
            "name" => "post_title",
            "label" => "Entrez un titre: ",
            "type" => "text",
            "maxlength" => \Utils\Constants::$MAX_POST_TITLE_LENGTH,
            "placeholder" => "Mon titre de post..",
            "required" => true,
            "value" => $post_title
            ]
        );
        self::createField(
            [
            "name" => "post_overview",
            "label" => "Ecrivez une courte description de votre post: ",
            "type" => "text",
            "maxlength" => \Utils\Constants::$MAX_POST_OVERVIEW_LENGTH,
            "placeholder" => "Dans ce post, nous parlerons de..",
            "required" => true,
            "value" => $post_overview
            ]
        );
        self::createTextArea(
            [
            "name" => "post_content",
            "label" => "Ecrivez votre post: ",
            "placeholder" => "Votre post..",
            "required" => true,
            "value" => $post_content
            ]
        );
        self::createField(
            [
            "name" => "post_tags",
            "label" => "Choisissez quelques tags (Séparés par un ','): ",
            "type" => "text",
            "maxlength" => \Utils\Constants::$MAX_POST_TAGS_LENGTH,
            "placeholder" => "#php,#mysql..",
            "value" => $post_tags
            ]
        );
        
        self::endForm("Poster");
        return $this->form;
    }
}