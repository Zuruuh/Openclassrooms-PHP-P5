<?php 
/**
 * User Edit Form Class File
 * User Edit Form for users to modify their personnal informations
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
 * User Edit Form Class
 * User Edit Form for users to modify their personnal informations
 * PHP version 8.0.9
 *
 * @category Forms
 * @package  Forms
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */
class User extends \Forms\Form
{
    /**
     * Returns User info edit form
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

        $user_profile_picture_path = "default.png";

        if (isset($profile_picture_path)) {
            $user_profile_picture_path = $profile_picture_path;
        }
 
        self::initForm("user", "edit", "d-flex flex-column w-full px-3", "post", [], "multipart/form-data");

        self::createField(
            [
                "name" => "profile_picture",
                "type" => "file",
                "accept" => ["image/png", "image/jpeg"],
                "oninput" => "imageInputPreview(this)",
                "class" => "my-5",
                "label" => "&nsbp;"
            ]
        );

        self::createField(
            [
            "name" => "first_name",
            "placeholder" => "Entrez votre prénom ",
            "type" => "text",
            "maxlength" => \Utils\Constants::$MAX_NAME_LENGTH,
            "required" => true,
            "value" => $first_name,
            "class" => "form-control my-1 py-3"
            ]
        );

        self::createField(
            [
            "name" => "last_name",
            "placeholder" => "Entrez votre nom ",
            "type" => "text",
            "maxlength" => \Utils\Constants::$MAX_NAME_LENGTH,
            "required" => true,
            "value" => $last_name,
            "class" => "form-control my-1 py-3"
            ]
        );

        self::createTextArea(
            [
                "name" => "description",
                "maxlength" => \Utils\Constants::$MAX_DESC_LENGTH,
                "value" => $desc,
                "class" => "form-control my-1  py-3 pb-5",
                "placeholder" => "Entrez une courte description ",
            ]
        );

        self::createField(
            [
                "name" => "location",
                "type" => "text",
                "label" => "Votre situation géographique",
                "maxlength" => \Utils\Constants::$MAX_LOCATION_LENGTH,
                "required" => true,
                "value" => $location,
                "class" => "form-control my-1 py-3",
                "placeholder" => "Votre situation géographique "
            ]
        );

        self::endForm("Enregistrer", "btn btn-primary btn-lg mb-5 mt-4");
        return $this->form;
    }
}