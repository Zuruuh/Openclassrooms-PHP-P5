<?php
/**
 * Mail Class File
 * Class for ServerMail interactions
 * PHP version 8.0.9
 *
 * @category Utils
 * @package  Utils
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */

namespace Utils;

use \Mail;

/**
 * Mail Class
 * Class for ServerMail interactions
 * PHP version 8.0.9
 *
 * @category Utils
 * @package  Utils
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */

class Mailer
{
    /**
     * Sends an email
     * 
     * @param string $to      The person to send an email to
     * @param string $subject The subject of the email
     * @param string $content The content of the email
     * 
     * @return void
     */
    public static function sendEmail(string $to, string $subject, string $content): void
    {
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        
        $config = parse_ini_file("config/config.ini", true);

        $smtp = Mail::Factory(
            "smtp",
            [
                "host" => $config["SMTP"],
                "port" => $config["SMTP_PORT"],
                "auth" => true,
                "username" => $config["SMTP_USERNAME"],
                "password" => $config["SMTP_PASSWORD"]
            ]
        );
    
        $smtp->send($to, $subject, $content, $headers);
    }

    /**
     * Starts a mail message
     * 
     * @return string
     */
    public static function initMail(): string
    {
        return "<html><body>";
    }

    /**
     * Creates an html element in mail's message
     * 
     * @param string $element    The html element to create
     * @param string $content    The content of the html element
     * @param array  $params     (Optional) The params of the html element
     * @param bool   $line_break Breaks line if set to true
     * 
     * @return string
     */
    public static function createElement(string $element, string $content, ?array $params = [], bool $line_break = false): string
    {
        $html_element = "<$element";

        foreach ($params as $param => $param_value) {
            $html_element .= " $param=\"$param_value\"";
        } 

        $html_element .= ">$content</$element>";
        if ($line_break) {
            $html_element .= "<br>";
        }
        return $html_element;
    }

    /**
     * Creates a self closing html element in mail's message
     * 
     * @param string $element The html element to create
     * @param array  $params  (Optional) The params of the html element
     * 
     * @return string
     */
    public static function createSingleElement(string $element, ?array $params = []): string
    {
        $html_element = "<$element ";

        foreach ($params as $param => $param_value) {
            $html_element .= "$param=\"$param_value\" ";
        } 

        $html_element .= ">";
        return $html_element;
    }

    /**
     * Creates a line break
     * 
     * @return string
     */
    public static function createLineBreak(): string
    {
        return "<br>";
    }

    /**
     * Ends a mail message
     * 
     * @return string
     */
    public static function endMail(): string
    {
        return "</html></body>";
    }
}