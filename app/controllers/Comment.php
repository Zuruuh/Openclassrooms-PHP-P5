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
            \Utils\Http::redirect("index.php?page=post&action=view");
        }

        if (!\Utils\Http::getParam("post", "get")) {
            \Utils\Http::redirect("index.php?page=post&action=view");
        }

        if (!\Utils\Http::getParam("comment_content")) {
            \Utils\Http::redirect("index.php?page=post&action=view");
        }

        // ? Paramètres OK

        // * 1 => Verif le post passé en url

        $user_model = new \Models\User();
        $post = $user_model->find(\Utils\Http::getParam("post", "get"));

        if (!$post) {
            \Utils\Http::redirect("index.php?page=post&action=view");
        }

        $POST_ID = $post["id"];
        $AUTHOR_ID = \Utils\Http::getSession("user_id")[0];

        // * 2 => Verif le contenu du post 

        $errors = array();
        $COMMENT_CONTENT = htmlspecialchars(\Utils\Http::getParam("comment_content"));

        if ($COMMENT_CONTENT > \Utils\Constants::$MAX_COMMENT_LENGTH) {
            array_push($errors, \Utils\Constants::$COMMENT_CONTENT_TOO_LONG);
        }
        
        $correct = true;

        foreach ($errors as $error) {
            $correct = false;
        }
        if ($correct) {
            $this->model->create($AUTHOR_ID, $POST_ID, $COMMENT_CONTENT);
            \Utils\Http::redirect("index.php?page=post&action=get&post=$POST_ID");
            return;
        }
        \Utils\Http::redirect("index.php?page=post&action=get&post=$POST_ID");
        // if (strlen(\Utils\Http::getParam("comment_content")) > 512) {
        //     \Utils\Renderer::render("Post", "Blog - $title", ["author" => $author, "post" => $post, "comments" => $comments_elements, "form_type" => "create", "values" => []], ["\Forms\Comment"]);
        // }

    }

}