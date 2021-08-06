<?php
/**
 * User Controller Class File
 * Controller file for User component
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
 * User Controller Class
 * Controller class for User component
 * PHP version 8.0.9
 *
 * @category Controllers
 * @package  Controllers
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */
class User extends \Controllers\Controller
{

    protected $modelName = \Models\User::class;

    /**
     * Display default home page
     *
     * @return void
     */
    public function view():void
    {

    }

    /**
     * Display register page
     * 
     * @return void
     */
    public function register(): void
    {
        if (\Utils\Http::getSession("user_id")) {
            \Utils\Http::redirect("index.php");
        }
        $errors = array();
        if (\Utils\Http::getParam("submit")) {

            // ? 1 => VERIFIER SI LA VALEUR EXISTE
            $values = ["first_name",
                       "last_name",
                       "username",
                       "email",
                       "password",
                       "birthday"
                    ];
            foreach ($values as $value) {
                if (!\Utils\Http::getParam($value)) {
                    $const = strtoupper($value) . "_REQUIRED";
                    array_push($errors, \Utils\Constants::$$const);
                }
            }
            if (!\Utils\Http::getParam("password_conf")) {
                array_push($errors, \Utils\Constants::PASSWORD_REQUIRED);
            }
            // ? 2 => LA VERIFIER AVEC LA FONCTION CHECK
            if (!empty($errors)) {
                \Utils\Renderer::render("Form", "S'inscrire", ["errors" => $errors], ["\Forms\Register"]);
                return;
            }
            $Validator = new \Utils\FormValidator($this->model);

            $first_name_errors = $Validator->checkName(\Utils\Http::getParam("first_name"), true);
            $last_name_errors = $Validator->checkName(\Utils\Http::getParam("last_name"));
            $username_errors = $Validator->checkUsername(\Utils\Http::getParam("username"));
            $email_errors = $Validator->checkEmail(\Utils\Http::getParam("email"));
            $password_errors = $Validator->checkPassword(\Utils\Http::getParam("password"), \Utils\Http::getParam("password_conf"));
            $birthday_errors = $Validator->checkBirthday(\Utils\Http::getParam("birthday"));

            $input_errors = [$first_name_errors, $last_name_errors, $username_errors, $email_errors, $password_errors, $birthday_errors];
            
            $check_errors = array();
            foreach ($input_errors as $input_error) {
                if ($input_error["state"]) {
                    array_push($check_errors, false);
                } else {
                    array_push($check_errors, $input_error["message"]);
                }
            }
            unset($input_errors);
            $input_errors = array();
            $correct = true;
            foreach ($check_errors as $check_error) {
                if ($check_error) {
                    $correct = false;
                    array_push($input_errors, $check_error);
                }
            }

            if ($correct) {
                $hashed = password_hash(\Utils\Http::getParam("password"), PASSWORD_BCRYPT);
                $sess = $this->model->register(
                    \Utils\Http::getParam("first_name"),
                    \Utils\Http::getParam("last_name"),
                    \Utils\Http::getParam("username"),
                    \Utils\Http::getParam("email"),
                    $hashed,
                    \Utils\Http::getParam("birthday")
                );
                
                \Utils\Http::setSession("user_id", $sess);
                \Utils\Http::redirect("index.php");
            }

            // ? 3 => RENVOYER LES ERREURS DANS UN ARRAY

            \Utils\Renderer::render("Form", "S'inscrire", ["errors" => $input_errors], ["\Forms\Register"]);
        } else {
            \Utils\Renderer::render("Form", "S'inscrire", ["errors" => $errors], ["\Forms\Register"]);
        }
        
    }

    /**
     * Display login page
     * 
     * @return void
     */
    public function login(): void
    {
        if (\Utils\Http::getSession("user_id")) {
            \Utils\Http::redirect("index.php");
        }
        
        $errors = array();
        if (\Utils\Http::getParam("submit")) {
            // ? FORM FILLED, PROCESS DATA =>
            if (!\Utils\Http::getParam("email")) {
                array_push($errors, \Utils\Constants::$EMAIL_REQUIRED);
            }
            if (!\Utils\Http::getParam("password")) {
                array_push($errors, \Utils\Constants::$SINGLE_PASSWORD_REQUIRED);
            }
            if (!empty($errors)) {
                \Utils\Renderer::render("Form", "Se Connecter", ["errors" => $errors], ["\Forms\Login"]);
                return;
            }
            // ?  Use model =>
            $EMAIL = htmlspecialchars(\Utils\Http::getParam("email"));
            $PASSWORD = htmlspecialchars(\Utils\Http::getParam("password"));

            $result = $this->model->login($EMAIL, $PASSWORD);
            if ($result) {
                \Utils\Http::setSession("user_id", $result);
                \Utils\Http::redirect("index.php");
            } else {
                array_push($errors, \Utils\Constants::$INVALID_CREDENTIALS);
                \Utils\Renderer::render("Form", "Se Connecter", ["errors" => $errors], ["\Forms\Login"]);
            }

        } else {
            \Utils\Renderer::render("Form", "Se Connecter", [], ["\Forms\Login"]);
        }
    }

    /**
     * Logs out user visiting the page
     * 
     * @return void
     */
    public function disconnect(): void
    {
        \Utils\Http::unsetSession("user_id");
        \Utils\Http::redirect("index.php");
    }
}
