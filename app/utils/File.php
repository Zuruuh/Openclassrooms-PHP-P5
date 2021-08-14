<?php
/**
 * File Class 
 * Class for files & images interactions
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
 * File Class
 * Class for files & images interactions
 * PHP version 8.0.9
 *
 * @category Utils
 * @package  Utils
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */
class File
{
    private static $_DIR = "./public/pictures/";

    /**
     * Saves an image in the pictures/ folder
     * 
     * @param array  $image The image to save
     * @param string $name  The new name to give to the image
     * 
     * @return string
     */
    public static function saveImage(array $image, string $name): string
    {
        $tmp_name = $image["tmp_name"]; 
        $extension = pathinfo($image["name"])["extension"];

        $name = $name . "." . $extension;

        move_uploaded_file($tmp_name, self::$_DIR . $name);

        return $name;
    }

    /**
     * Verifies if file is a real image
     * 
     * @param array $img The image to verify
     * 
     * @return bool
     */
    public static function isImage(array $img): bool
    {
        $check = getimagesize($img["tmp_name"]);
        if ($check !== false) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Verifies if file is heavier than limit
     * 
     * @param array $img The image to verify
     * 
     * @return bool
     */
    public static function checkImageSize(array $img): bool
    {
        if (!isset($img["size"])) {
            return false;
        }
        if ($img["size"] > \Utils\Constants::$MAX_IMAGE_SIZE) {
            return false;
        }
        return true;
    }

    /**
     * Deletes a file
     * 
     * @param string $image_path The path to the image to delete
     * 
     * @return void
     */
    public static function deleteImage(string $image_path): void
    {
        unlink(self::$_DIR . $image_path);
    }

}