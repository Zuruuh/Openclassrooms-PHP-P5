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
        \Utils\Http::checkParam(\Utils\Http::getParam("user", "get"), \Utils\Constants::$MISSING_USER_URL_PARAM);
        $user_id = intval(\Utils\Http::getParam("user", "get"));
        $user = $this->model->find($user_id);
        
        if (!$user) {
            \Utils\Errors::addError(\Utils\Constants::$USER_DO_NOT_EXIST);
            \Utils\Http::redirect("index.php");
        }

        extract($user);
        $user_role = $user["is_admin"] ? "Administrateur" : "Membre";
        $sess = 0;
        if (\Utils\Http::isSessionCorrect()) {
            $sess = \Utils\Http::isSessionCorrect();
        }
        $self = false;
        if (intval($sess) === $user_id) {
            $self = true;
        } 

        \Utils\Renderer::render(
            "User", "Blog - $username", 
            ["errors" => [], 
            "values" => [
                "username" => $username, 
                "user_path" => $profile_picture_path, 
                "user_description" => $description, 
                "user_location" => $location, 
                "user_role" => $user_role, 
                "user_register_date" => $register_date, 
                "user_birthday" => $birthday, 
                "self" => $self]
            ], 
            []
        );
    }

    /**
     * Display register page
     * 
     * @return void
     */
    public function register(): void
    {
        \Utils\Http::visitorPage(\Utils\Constants::$ALREADY_LOGGED_IN);
        $errors = array();
        if (\Utils\Http::getParam("submit")) {

            \Utils\Http::setCookie("saved_first_name", htmlspecialchars(\Utils\Http::getParam("first_name")));
            \Utils\Http::setCookie("saved_last_name", htmlspecialchars(\Utils\Http::getParam("last_name")));
            \Utils\Http::setCookie("saved_username", htmlspecialchars(\Utils\Http::getParam("username")));
            \Utils\Http::setCookie("saved_email", htmlspecialchars(\Utils\Http::getParam("email")));
            \Utils\Http::setCookie("saved_birthday", htmlspecialchars(\Utils\Http::getParam("birthday")));
            
            // ? 1 => VERIFIER SI LA VALEUR EXISTE
            
            $values = ["first_name","last_name","username","email","password","birthday"];
            foreach ($values as $value) {
                if (!\Utils\Http::getParam($value)) {
                    $const = strtoupper($value) . "_REQUIRED";
                    \Utils\Errors::addError(\Utils\Constants::$$const);
                    array_push($errors, \Utils\Constants::$$const);
                }
            }

            if (!empty($errors)) {
                \Utils\Renderer::render("Form", "S'inscrire", [], ["\Forms\Register"]);
                return;
            }

            $Validator = new \Utils\FormValidator($this->model);

            $input_errors = array();

            array_push($input_errors, $Validator->checkName(\Utils\Http::getParam("first_name"), true));
            array_push($input_errors, $Validator->checkName(\Utils\Http::getParam("last_name")));
            array_push($input_errors, $Validator->checkUsername(\Utils\Http::getParam("username")));
            array_push($input_errors, $Validator->checkEmail(\Utils\Http::getParam("email")));
            array_push($input_errors, $Validator->checkPassword(\Utils\Http::getParam("password"), \Utils\Http::getParam("password_conf")));
            array_push($input_errors, $Validator->checkBirthday(\Utils\Http::getParam("birthday")));

            $correct = true;

            foreach ($input_errors as $input_error) {
                if ($input_error) {
                    $correct = false;
                    \Utils\Errors::addError($input_error);
                }
            }

            if ($correct) {
                $hashed = password_hash(\Utils\Http::getParam("password"), PASSWORD_BCRYPT);
                $sess = $this->model->register(
                    htmlspecialchars(\Utils\Http::getParam("first_name")),
                    htmlspecialchars(\Utils\Http::getParam("last_name")),
                    htmlspecialchars(\Utils\Http::getParam("username")),
                    htmlspecialchars(\Utils\Http::getParam("email")),
                    $hashed,
                    htmlspecialchars(\Utils\Http::getParam("birthday"))
                );
                
                \Utils\Errors::addError(\Utils\Constants::$REGISTER_SUCCESS, "success");
                \Utils\Http::setSession("user_id", $sess);
                \Utils\Http::redirect("index.php");
            }

        }
        $saved_first_name = \Utils\Http::getCookie("saved_first_name");
        $saved_last_name = \Utils\Http::getCookie("saved_last_name");
        $saved_username = \Utils\Http::getCookie("saved_username");
        $saved_email = \Utils\Http::getCookie("saved_email");
        $saved_birthday = \Utils\Http::getCookie("saved_birthday");

        $values = [
            "saved_first_name" => $saved_first_name ? $saved_first_name : "",
            "saved_last_name" => $saved_last_name ? $saved_last_name : "",
            "saved_username" => $saved_username ? $saved_username : "",
            "saved_email" => $saved_email ? $saved_email : "",
            "saved_birthday" => $saved_birthday ? $saved_birthday : ""
        ];
        \Utils\Renderer::render("Form", "S'inscrire", ["values" => $values], ["\Forms\Register"]);
        
        
    }

    /**
     * Display login page
     * 
     * @return void
     */
    public function login(): void
    {
        \Utils\Http::visitorPage(\Utils\Constants::$ALREADY_LOGGED_IN);
        
        $errors = array();
        if (\Utils\Http::getParam("submit")) {
            // ? FORM FILLED, PROCESS DATA =>
            if (!\Utils\Http::getParam("email")) {
                \Utils\Errors::addError(\Utils\Constants::$EMAIL_REQUIRED);
                array_push($errors, \Utils\Constants::$EMAIL_REQUIRED);
            }
            if (!\Utils\Http::getParam("password")) {
                \Utils\Errors::addError(\Utils\Constants::$SINGLE_PASSWORD_REQUIRED);
                array_push($errors, \Utils\Constants::$SINGLE_PASSWORD_REQUIRED);
            }
            if (!empty($errors)) {
                \Utils\Renderer::render("Form", "Se Connecter", [], ["\Forms\Login"]);
                return;
            }
            // ?  Use model =>
            $EMAIL = htmlspecialchars(\Utils\Http::getParam("email"));
            $PASSWORD = htmlspecialchars(\Utils\Http::getParam("password"));
            $user = $this->model->login($EMAIL, $PASSWORD);

            if (!$user) {
                // Invalid Email
                \Utils\Errors::addError(\Utils\Constants::$INVALID_CREDENTIALS);
                \Utils\Http::redirect("index.php?page=user&action=login");
            }
    
            if (password_verify($PASSWORD, $user["password"])) {
                if (intval($user["disabled"]) === 1 ) {
                    // ! Account is banned
                    \Utils\Errors::addError(\Utils\Constants::$ACCOUNT_BANNED_ERROR);
                    \Utils\Http::redirect("index.php?page=user&action=login");
                }
                // ? Connect User
                $session = $user["id"] . "|" . $user["password"];
                \Utils\Errors::addError(\Utils\Constants::$LOGIN_SUCCESS, "success");
                \Utils\Http::setSession("user_id", $session);
                \Utils\Http::redirect("index.php");
            }
            // Invalid Password
            \Utils\Errors::addError(\Utils\Constants::$INVALID_CREDENTIALS);
            \Utils\Http::redirect("index.php?page=user&action=login");
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
        \Utils\Errors::addError(\Utils\Constants::$LOGOUT_SUCCESS, "primary");
        \Utils\Http::unsetSession("user_id");
        \Utils\Http::redirect("index.php");
    }

    /**
     * Displays user infos editing form
     * 
     * @return void
     */
    public function edit(): void
    {
        \Utils\Http::memberPage();

        $user_id = \Utils\Http::isSessionCorrect();

        $user = $this->model->find($user_id);

        $first_name = $user["first_name"];
        $last_name = $user["last_name"];
        $desc = $user["description"];
        $location = $user["location"];

        $errors = array();
        if (\Utils\Http::getParam("submit")) {

            $values = ["first_name","last_name"];

            foreach ($values as $value) {
                if (!\Utils\Http::getParam($value)) {
                    $const = strtoupper($value) . "_REQUIRED";
                    \Utils\Errors::addError(\Utils\Constants::$$const);
                    array_push($errors, \Utils\Constants::$$const);
                }
            }

            // ? 2 => LA VERIFIER AVEC LA FONCTION CHECK
            if (empty($errors)) {
                $Validator = new \Utils\FormValidator($this->model);

                $input_errors = array();

                array_push($input_errors, $Validator->checkName(\Utils\Http::getParam("first_name"), true));
                array_push($input_errors, $Validator->checkName(\Utils\Http::getParam("last_name")));
                array_push($input_errors, $Validator->checkDesc(\Utils\Http::getParam("description")));
                array_push($input_errors, $Validator->checkLocation(\Utils\Http::getParam("location")));

                $image_errors = array();
                $NEW_PATH;
                if ($_FILES["profile_picture"]["name"] !== "") {
                    $image = $_FILES["profile_picture"];
                    $image_correct = true;

                    if (!\Utils\File::isImage($image)) {
                        \Utils\Errors::addError(\Utils\Constants::$IMAGE_TYPE);
                        array_push($image_errors, \Utils\Constants::$IMAGE_TYPE);
                    }
                    if (empty($image_errors) && !\Utils\File::checkImageSize($image)) {
                        \Utils\Errors::addError(\Utils\Constants::$IMAGE_TOO_HEAVY);
                        array_push($image_errors, \Utils\Constants::$IMAGE_TOO_HEAVY);
                    }

                    $user_profile_picture = $this->model->getProfilePicture($user_id);

                    if (empty($image_errors)) {
                        if ($user_profile_picture !== "default.png") {
                            \Utils\File::deleteImage($user_profile_picture);
                        }

                        $NEW_PATH = \Utils\File::saveImage($image, $user_id);
                    }
                } else {
                    $NEW_PATH = $this->model->getProfilePicture($user_id);
                }
                $correct = true;

                foreach ($input_errors as $input_error) {
                    if ($input_error) {
                        \Utils\Errors::addError($input_error);
                        $correct = false;
                    }
                }

                if (!empty($image_errors)) {
                    $correct = false;
                }

                if ($correct) {
                    $this->model->update(
                        $user_id,
                        htmlspecialchars(\Utils\Http::getParam("first_name")),
                        htmlspecialchars(\Utils\Http::getParam("last_name")),
                        $NEW_PATH,
                        htmlspecialchars(\Utils\Http::getParam("description")),
                        htmlspecialchars(\Utils\Http::getParam("location"))
                    );
                    \Utils\Errors::addError(\Utils\Constants::$USER_UPDATE_SUCCESS, "success");
                    \Utils\Http::redirect("index.php?page=user&action=view&user=$user_id");
                } 

            }
        }
        \Utils\Renderer::render(
            "SelfUser", 
            "Blog - Modifiez vos informations personnelles", ["values" => [
                "first_name" => $first_name,
                "last_name" => $last_name,
                "desc" => $desc, 
                "location" => $location,
                "profile_picture_path" => $this->model->getProfilePicture($user_id)
            ],
            "form_type" => "edit",
            ],
            ["\Forms\User"]
        );

        
    }

    /**
     * Displays password changing page
     * 
     * @return void
     */
    public function forgotPassword(): void
    {

        if (\Utils\Http::getSession("user_id")) {
            \Utils\Errors::addError(\Utils\Constants::$ALREADY_LOGGED_IN, "primary");
            \Utils\Http::redirect("index.php");
        }

        if (\Utils\Http::getParam("token", "get")) {
            if (\Utils\Http::getParam("password") && \Utils\Http::getParam("password_conf")) {
                $TOKEN = htmlspecialchars(\Utils\Http::getParam("token", "get"));
                $user = \Utils\Http::validateToken($TOKEN, $this->model);

                $errors = array();

                $NEW_PASSWORD = htmlspecialchars(\Utils\Http::getParam("password"));
                $CONF_PASSWORD = htmlspecialchars(\Utils\Http::getParam("password_conf"));
                if ($NEW_PASSWORD !== $CONF_PASSWORD) {
                    \Utils\Errors::addError(\Utils\Constants::$PASSWORD_DO_NOT_MATCH);
                    array_push($errors, \Utils\Constants::$PASSWORD_DO_NOT_MATCH);
                }


                if (!empty($errors)) {
                    \Utils\Renderer::render(
                        "Form", "Blog - Mot de passe oublié", 
                        ["values" => ["fields" => [
                                [
                                    "name" => "password",
                                    "type" => "password",
                                    "label" => "Choisissez un nouveau mot de passe",
                                    "placeholder" => "Mot de passe..."
                                ],
                                [
                                    "name" => "password_conf",
                                    "type" => "password",
                                    "label" => "Confirmez votre mot de passe",
                                    "placeholder" => "Confirmez votre mot de passe"
                                ]
                            ],
                            "token" => \Utils\Http::getParam("token", "get"),
                            ]
                        ], 
                        ["\Forms\SingleForm"]
                    );
                } else {
                    $hashed = password_hash($NEW_PASSWORD, PASSWORD_BCRYPT);
                    $this->model->updatePassword($hashed, $user);
                    \Utils\Errors::addError(\Utils\Constants::$PASSWORD_CHANGE_SUCCESS, "success");
                    \Utils\Http::setSession("user_id", $user . "|" . $hashed);
                    \Utils\Http::redirect("index.php");
                }



            } else {
                // ! Verify token
                $TOKEN = \Utils\Http::getParam("token", "get");
                \Utils\Http::validateToken($TOKEN, $this->model);

                // ! Display new password form
            
                $header = [
                    "element" => "header",
                    "value" => "Choisissez votre nouveau mot de passe",
                    "props" => [
                        "class" => "text-break fs-4 px-2 text-center",
                    ]
                ];

                \Utils\Renderer::render(
                    "Form", "Blog - Mot de passe oublié", 
                    ["values" => ["fields" => [
                            [
                                "name" => "password",
                                "type" => "password",
                                "label" => "Choisissez un nouveau mot de passe",
                                "placeholder" => "Mot de passe...",
                                "class" => "p-2 my-1 col-md-6"
                            ],
                            [
                                "name" => "password_conf",
                                "type" => "password",
                                "label" => "Confirmez votre mot de passe",
                                "placeholder" => "Confirmez votre mot de passe",
                                "class" => "p-2 my-1 col-md-6"
                            ]
                        ],
                        "header" => $header,
                        "token" => \Utils\Http::getParam("token", "get"),
                        ]
                    ], 
                    ["\Forms\SingleForm"]
                );

            }
        } else if (\Utils\Http::getParam("submit")) {
            // ! Send mail
            $EMAIL_ADRESS = htmlspecialchars(\Utils\Http::getParam("email"));

            if (!filter_var($EMAIL_ADRESS, FILTER_VALIDATE_EMAIL)) {
                \Utils\Errors::addError(\Utils\Constants::$EMAIL_INVALID);
                \Utils\Http::redirect("index.php?page=user&action=forgotPassword");
            } 

            $account = $this->model->findBy($EMAIL_ADRESS);

            if (!$account) {
                \Utils\Errors::addError(\Utils\Constants::$EMAIL_NOT_USED);
                \Utils\Http::redirect("index.php?page=user&action=forgotPassword");
            }

            $first_name = $account["first_name"];
            $token = base64_encode($account["password"] . "|§§§|" . $EMAIL_ADRESS);

            $mail = \Utils\Mailer::initMail();

            $config = parse_ini_file("config/config.ini", true);

            $WEBSITE_URL = $config["WEBSITE_URL"];

            $mail .= \Utils\Mailer::createElement("p", "Hello $first_name 👋", [], true);
            $mail .= \Utils\Mailer::createElement("p", "Il semblerais que vous ayez demandé à changer votre mot de passe.", [], true);
            $mail .= \Utils\Mailer::createElement("p", "Si c'est le cas, vous pouvez cliquer <a href='$WEBSITE_URL/index.php?page=user&action=forgotPassword&token=$token'>ici</a>", [], true);
            $mail .= \Utils\Mailer::createElement("p", "Si vous n'êtes pas à l'origine de cette action, vous pouvez ignorer ce message");

            $mail .= \Utils\Mailer::endMail();

            \Utils\Mailer::sendEmail(\Utils\Http::getParam("email"), "Oubli de mot de passe", $mail);
            \Utils\Errors::addError(\Utils\Constants::$EMAIL_SENT, "success");
            \Utils\Http::redirect("index.php");
        } else {
            $header = [
                "element" => "header",
                "value" => "Réinitialisation de mot de passe<br><p class='fs-6'>Entrez l'adresse mail que vous avez utilisé pour créer votre compte: </p>",
                "props" => [
                    "class" => "fs-2 text-center"
                ]
            ];
            \Utils\Renderer::render(
                "Form", "Blog - Mot de passe oublié", 
                ["values" => 
                    ["fields" => [
                    ["name" => "email",
                    "type" => "email",
                    "label" => "Entrez l'adresse mail que vous avez utilisé pour créer votre compte: ",
                    "placeholder" => "adresse@mail.com"]
                    ],
                    "header" => $header
                    ]
                ], 
                ["\Forms\SingleForm"]
            );
        }
    }

    /**
     * Page for users to change their password 
     * 
     * @return void
     */
    public function changePassword(): void
    {
        if (!\Utils\Http::getSession("user_id")) {
            \Utils\Errors::addError(\Utils\Constants::$MUST_BE_CONNECTED, "primary");
            \Utils\Http::redirect("index.php");
        }

        if (!\Utils\Http::isSessionCorrect()) {
            \Utils\Errors::addError(\Utils\Constants::$INVALID_SESSION);
            \Utils\Http::redirect("index.php");
        }
        if (\Utils\Http::getParam("submit")) {

            $PASSWORD = htmlspecialchars(\Utils\Http::getParam("password"));
            $PASSWORD_CONF = htmlspecialchars(\Utils\Http::getParam("password_conf"));
            $OLD_PASSWORD = htmlspecialchars(\Utils\Http::getParam("old_password"));

            $USER_ID = intval(\Utils\Http::getSession("user_id")[0]);
            $USER = $this->model->find($USER_ID);

            if ($PASSWORD == "" || $PASSWORD_CONF == "" || $OLD_PASSWORD == "") {
                \Utils\Errors::addError(\Utils\Constants::$MISSING_FIELD);
                \Utils\Http::redirect("index.php?page=user&action=changePassword");
                return;
            }

            if (!password_verify($OLD_PASSWORD, $USER["password"])) {
                \Utils\Errors::addError(\Utils\Constants::$OLD_PASSWORD_INCORRECT);
                \Utils\Http::redirect("index.php?page=user&action=changePassword");
                return;
            }

            if ($PASSWORD !== $PASSWORD_CONF) {
                \Utils\Errors::addError(\Utils\Constants::$PASSWORD_DO_NOT_MATCH);
                \Utils\Http::redirect("index.php?page=user&action=changePassword");
                return;
            }

            $hashed = password_hash($PASSWORD, PASSWORD_BCRYPT);
            $this->model->updatePassword($hashed, $USER_ID);
            \Utils\Errors::addError(\Utils\Constants::$PASSWORD_CHANGE_SUCCESS, "success");
            \Utils\Http::unsetSession("user_id");
            \Utils\Http::setSession("user_id", $USER_ID . "|" . $hashed);
            \Utils\Http::redirect("index.php");

        } else {
            $fields = [
                [
                    "name" => "old_password",
                    "type" => "password",
                    "placeholder" => "Entrez votre ancien mot de passe..",
                    "class" => "p-2 my-1 col-md-6"
                ],
                [
                    "name" => "password",
                    "type" => "password",
                    "placeholder" => "Choisissez un nouveau mot de passe..",
                    "class" => "p-2 my-1 col-md-6"
                ],
                [
                    "name" => "password_conf",
                    "type" => "password",
                    "placeholder" => "Confirmez votre mot de passe",
                    "class" => "p-2 my-1 col-md-6"
                ]
            ];
            $header = [
                "element" => "header",
                "value" => "Changement de mot de passe",
                "props" => [
                    "class" => "fs-2 text-center"
                ]
            ];
            \Utils\Renderer::render(
                "Form", "Blog - Changer votre mot de passe",
                ["values" => ["fields" => $fields, "header" => $header, "form_type" => "changePassword"]],
                ["\Forms\SingleForm"]
            );
        }
    }

    /**
     * Page for users to change their username 
     * 
     * @return void
     */
    public function changeUsername(): void
    {
        if (!\Utils\Http::getSession("user_id")) {
            \Utils\Errors::addError(\Utils\Constants::$MUST_BE_CONNECTED, "primary");
            \Utils\Http::redirect("index.php");
        }

        if (!\Utils\Http::isSessionCorrect()) {
            \Utils\Errors::addError(\Utils\Constants::$INVALID_SESSION);
            \Utils\Http::redirect("index.php");
        }
        if (\Utils\Http::getParam("submit")) {

            $PASSWORD = htmlspecialchars(\Utils\Http::getParam("password"));
            $NEW_USERNAME = htmlspecialchars(\Utils\Http::getParam("username"));

            $USER_ID = intval(\Utils\Http::getSession("user_id")[0]);
            $USER = $this->model->find($USER_ID);

            if ($PASSWORD == "" || $NEW_USERNAME == "") {
                \Utils\Errors::addError(\Utils\Constants::$MISSING_FIELD);
                \Utils\Http::redirect("index.php?page=user&action=changeUsername");
                return;
            }

            if ($NEW_USERNAME === $USER["username"]) {
                \Utils\Errors::addError(\Utils\Constants::$OWN_USERNAME);
                \Utils\Http::redirect("index.php?page=user&action=changeUsername");
                return;
            }

            if (!password_verify($PASSWORD, $USER["password"])) {
                \Utils\Errors::addError(\Utils\Constants::$PASSWORD_INCORRECT);
                \Utils\Http::redirect("index.php?page=user&action=changeUsername");
                return;
            }

            $Validator = new \Utils\FormValidator($this->model);

            $username_error = $Validator->checkUsername($NEW_USERNAME);

            if ($username_error) {
                \Utils\Errors::addError($username_error, "danger");
                \Utils\Http::redirect("index.php?page=user&action=changeUsername");
                return;
            }

            $this->model->updateUsername($NEW_USERNAME, $USER_ID);
            \Utils\Errors::addError(\Utils\Constants::$USERNAME_UPDATE_SUCCESS, "success");
            \Utils\Http::redirect("index.php");

        } else {
            $fields = [
                [
                    "name" => "password",
                    "type" => "password",
                    "label" => "Entrez votre mot de passe",
                    "placeholder" => "Mot de passe...",
                    "class" => "p-2 my-1 col-md-6"
                ],
                [
                    "name" => "username",
                    "type" => "text",
                    "label" => "Choisissez un nouveau nom d'utilisateur",
                    "placeholder" => "Nouveau pseudonyme..",
                    "maxlength" => \Utils\Constants::$MAX_USERNAME_LENGTH,
                    "class" => "p-2 my-1 col-md-6"
                ],
            ];
            $header = [
                "element" => "header",
                "value" => "Changement de nom d'utilisateur",
                "props" => [
                    "class" => "fs-2 px-2 text-center"
                ]
            ];
            \Utils\Renderer::render(
                "Form", "Blog - Changer votre pseudonyme",
                ["values" => ["fields" => $fields, "header" => $header, "form_type" => "changeUsername"]],
                ["\Forms\SingleForm"]
            );
        }
    }
}