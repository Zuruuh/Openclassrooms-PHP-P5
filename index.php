<?php
/**
 * Index file
 * Main entry point for web App
 * PHP version 8.0.9
 *
 * @category Utils
 * @package  Utils
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */

require_once "app/App.php";
try{
    \App::process();
}catch(Exception $e){
    echo "<p class='error'>{$e->getMessage()}</p>";
}