<?php
/**
 * Controller Class File
 * Abstract class containing default crud actions for other controllers
 * PHP version 8.0.9
 *
 * @category Controllers
 * @package  Controllers
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */

namespace Controllers;

/**
 * Controller Class
 * Abstract class containing default crud actions for other controllers
 * PHP version 8.0.9
 *
 * @category Controllers
 * @package  Controllers
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */
abstract class Controller
{
    protected $model, $modelName;

    /**
     * Creates new instance of Controller's linked Model
     */
    public function __construct()
    {
        if (isset($this->modelName)) {
            $this->model = new $this->modelName;
        }
    }
}