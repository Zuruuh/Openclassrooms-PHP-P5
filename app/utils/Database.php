<?php
/**
 * Database Class File
 * Create link between web app and database
 * PHP version 8.0.9
 *
 * @category Utils
 * @package  Utils
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */

namespace Utils;

use \PDO;

/**
 * Database Class File
 * Create link between web app and database
 * PHP version 8.0.9
 *
 * @category Utils
 * @package  Utils
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */
class Database
{

    private static $_instance = null;
    /**
     * Returns PDO object for further database manipulation
     * 
     * @return PDO
     */
    public static function getDB()
    {
        if (self::$_instance === null) {
            try {
                $config = parse_ini_file("config/database.ini", true);
    
                self::$_instance = new \PDO(
                    "mysql:host=$config[HOSTNAME];dbname=$config[DBNAME];charset=utf8",
                    "$config[DBUSER]", "$config[DBPASSWORD]", 
                    [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
            }
            catch(Exception $error)
            {
                exit(htmlspecialchars('Erreur de connection :'.$error->getMessage()));
            }
        }
        return self::$_instance;
    }

}