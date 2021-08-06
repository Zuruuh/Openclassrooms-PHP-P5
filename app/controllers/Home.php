<?php
/**
 * Home Controller Class File
 * Controller file for Home component
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
 * Home Controller Class
 * Controller class for Home component
 * PHP version 8.0.9
 *
 * @category Controllers
 * @package  Controllers
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */
class Home extends Controller
{
    
    /**
     * Returns default home page
     * 
     * @return void
     */
    public function view():void
    {
        if (\Utils\Http::getSession("user_id")) {
            print_r("Connected !");
        }
        \Utils\Renderer::render("Home", "Blog");
    }
}