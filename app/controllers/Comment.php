<?php
/**
 * Comment Controller Class File
 * Controller file for Comment component
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
 * Comment Controller Class
 * Controller class for Comment component
 * PHP version 8.0.9
 *
 * @category Controllers
 * @package  Controllers
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */
class Comment extends \Controllers\Controller
{
    protected $modelName = \Models\Comment::class;

    /**
     * Creates comment on a post
     * 
     * @return void
     */
    public function create(): void
    {
        if (!\Utils\Http::isSessionCorrect()) {
            \Utils\Errors::addError(\Utils\Constants::$MUST_BE_CONNECTED);
            \Utils\Http::redirect("index.php?page=post&action=view");
        }

        if (!\Utils\Http::getParam("post", "get")) {
            \Utils\Errors::addError(\Utils\Constants::$MISSING_POST_URL_PARAM);
            \Utils\Http::redirect("index.php?page=post&action=view");
        }

        if (!\Utils\Http::getParam("comment_content")) {
            \Utils\Errors::addError(\Utils\Constants::$COMMENT_CONTENT_REQUIRED, "primary");
            \Utils\Http::redirect("index.php?page=post&action=view");
        }

        // ? Paramètres OK

        // * 1 => Verif le post passé en url

        $post_model = new \Models\Post();
        $post = $post_model->find(\Utils\Http::getParam("post", "get"));
        if (!$post) {
            \Utils\Errors::addError(\Utils\Constants::$POST_DO_NOT_EXIST);
            \Utils\Http::redirect("index.php?page=post&action=view");
        }

        $POST_ID = $post["id"];
        $AUTHOR_ID = \Utils\Http::getSession("user_id")[0];

        // * 2 => Verif le contenu du commentaire 

        $errors = array();
        $COMMENT_CONTENT = htmlspecialchars(\Utils\Http::getParam("comment_content"));

        if (strlen($COMMENT_CONTENT) > \Utils\Constants::$MAX_COMMENT_LENGTH) {
            array_push($errors, \Utils\Constants::$COMMENT_CONTENT_TOO_LONG);
        }
        
        $correct = true;
        
        foreach ($errors as $error) {
            \Utils\Errors::addError($error);
            $correct = false;
        }
        if ($correct) {
            if (\Utils\Http::isAdmin()) {
                $this->model->create($AUTHOR_ID, $POST_ID, $COMMENT_CONTENT, true);
                \Utils\Errors::addError(\Utils\Constants::$COMMENT_POSTED, "success");
            } else {
                \Utils\Errors::addError(\Utils\Constants::$COMMENT_POSTED_NOT_VERIFIED, "success");
                $this->model->create($AUTHOR_ID, $POST_ID, $COMMENT_CONTENT);
            }
            \Utils\Http::redirect("index.php?page=post&action=get&post=$POST_ID");
            return;
        }
        \Utils\Http::redirect("index.php?page=post&action=get&post=$POST_ID");
    }

    /**
     * Deletes a comment under a post
     * 
     * @return void
     */
    public function delete(): void
    {
        if (!\Utils\Http::isSessionCorrect()) {
            \Utils\Errors::addError(\Utils\Constants::$MUST_BE_CONNECTED);
            \Utils\Http::redirect("index.php?page=post&action=view");
        }

        if (!\Utils\Http::getParam("comment", "get")) {
            \Utils\Errors::addError(\Utils\Constants::$MISSING_COMMENT_URL_PARAM);
            \Utils\Http::redirect("index.php?page=post&action=view");
        }

        $user_id = \Utils\Http::getSession("user_id")[0]; 

        $comment = $this->model->find(intval(\Utils\Http::getParam("comment", "get")));

        if (!$comment) {
            \Utils\Errors::addError(\Utils\Constants::$COMMENT_DO_NOT_EXIST);
            \Utils\Http::redirect("index.php?page=post&action=view");
        }

        $post_id = $comment["post_id"];
        if ($user_id != $comment["author_id"]) {
            \Utils\Errors::addError(\Utils\Constants::$COMMENT_OWNER);
            \Utils\Http::redirect("index.php?page=post&action=get&post=$post_id");
        }
        \Utils\Errors::addError(\Utils\Constants::$COMMENT_DELETE_SUCCESS, "success");
        $this->model->delete(intval(\Utils\Http::getParam("comment", "get")));
        \Utils\Http::redirect("index.php?page=post&action=get&post=$post_id");
    }

    /**
     * Edits an already existing comment
     * 
     * @return void
     */
    public function edit(): void
    {
        if (!\Utils\Http::isSessionCorrect()) {
            \Utils\Errors::addError(\Utils\Constants::$MUST_BE_CONNECTED);
            \Utils\Http::redirect("index.php?page=post&action=view");
        }

        if (!\Utils\Http::getParam("comment", "get")) {
            \Utils\Errors::addError(\Utils\Constants::$MISSING_COMMENT_URL_PARAM);
            \Utils\Http::redirect("index.php?page=post&action=view");
        }

        $user_id = intval(\Utils\Http::getSession("user_id")[0]); 

        $comment = $this->model->find(intval(\Utils\Http::getParam("comment", "get")));

        if (!$comment) {
            \Utils\Errors::addError(\Utils\Constants::$COMMENT_DO_NOT_EXIST);
            \Utils\Http::redirect("index.php?page=post&action=view");
        }

        $post_id = intval($comment["post_id"]);
        if ($user_id !== intval($comment["author_id"])) {
            \Utils\Errors::addError(\Utils\Constants::$COMMENT_OWNER);
            \Utils\Http::redirect("index.php?page=post&action=get&post=$post_id");
        }
        if (\Utils\Http::getParam("submit")) {
            if (!\Utils\Http::getParam("comment_content")) {
                \Utils\Errors::addError(\Utils\Constants::$COMMENT_CONTENT_REQUIRED, "primary");
                \Utils\Http::redirect("index.php?page=post&action=view&post=$post_id");
            } else if (strlen(strval(\Utils\Http::getParam("comment_content"))) > \Utils\Constants::$MAX_COMMENT_LENGTH) {
                \Utils\Errors::addError(\Utils\Constants::$COMMENT_CONTENT_TOO_LONG);
                \Utils\Http::redirect("index.php?page=post&action=view&post=$post_id");
            }
        
            $AUTHOR_ID = \Utils\Http::getSession("user_id")[0];
    
            $errors = array();
            $COMMENT_CONTENT = htmlspecialchars(\Utils\Http::getParam("comment_content"));
    
            if (strlen($COMMENT_CONTENT) > \Utils\Constants::$MAX_COMMENT_LENGTH) {
                array_push($errors, \Utils\Constants::$COMMENT_CONTENT_TOO_LONG);
            }
            
            $correct = true;
    
            foreach ($errors as $error) {
                \Utils\Errors::addError($error);
                $correct = false;
            }
            if ($correct) {
                $isAdmin = false;
                if (\Utils\Http::isAdmin()) {
                    $isAdmin = true;
                }
                \Utils\Errors::addError(\Utils\Constants::$COMMENT_UPDATE_SUCCESS, "success");
                $this->model->edit(\Utils\Http::getParam("comment", "get"), $COMMENT_CONTENT, $isAdmin);
                \Utils\Http::redirect("index.php?page=post&action=get&post=$post_id");
                
            }
        } else {
            \Utils\Renderer::render("Form", "Editer un commentaire", ["form_type" => "edit", "values" => ["comment_content" => $comment["comment_content"]], "page_params" => ["comment" => $comment["id"]]], ["\Forms\Comment"]);
        } 

    }

}