<?php
/**
 * Post Controller Class File
 * Controller file for Post component
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
 * Post Controller Class
 * Controller class for Post component
 * PHP version 8.0.9
 *
 * @category Controllers
 * @package  Controllers
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */
class Post extends Controller
{

    protected $modelName = \Models\Post::class;

    /**
     * Returns most recents posts
     * 
     * @return void
     */
    public function view():void
    {
        $posts_number = $this->model->count();
        $PAGE = intval(\Utils\Http::getParam('pagination', "get"));
        if (!$PAGE) {
            $PAGE = 1;
        }

        $PAGINATION = \Utils\Pagination::paginate("index.php?page=post&action=view&pagination=", $posts_number, 10, $PAGE);

        $pagination_params = $PAGINATION["request_params"];

        $posts = $this->model->get($pagination_params["offset"], $pagination_params["limit"]);

        $user_model = new \Models\User();
        $post_elements = array();
        foreach ($posts as $post) {
            extract($post);
            $date = explode(" ", $last_modified)[0]; 
            $author = $user_model->getUsername($author_id);

            $post_element = \Utils\ElementBuilder::buildPost($id, $author_id, $author, $date, $title, $overview);

            array_push($post_elements, $post_element);
        }

        if (empty($post_elements)) {
            $post_elements = ["<div class='w-100 d-flex justify-content-center align-items-center flex-column'><h2>On dirait que vous êtes parti trop loin 🙁</h2><p>Cliquez <a href='index.php?page=post&action=view'>ici</a> pour revenir en arrière</p></div>"];
        }

        \Utils\Renderer::render("Posts", "Blog - Posts récents", ["posts" => $post_elements, "pagination" => $PAGINATION["page_buttons"]]);
    }

    /**
     * Returns specific post
     * 
     * @return void
     */
    public function get():void
    {
        if (\Utils\Http::getParam("post", "get")) {
            $post = $this->model->find(intval(\Utils\Http::getParam("post", "get")));
            if (!$post) {
                \Utils\Errors::addError(\Utils\Constants::$POST_DO_NOT_EXIST);
                \Utils\Http::redirect("index.php?page=post&action=view");
            }
            $user_model = new \Models\User();
            $author = $user_model->getUsername($post["author_id"]);
            
            $post["post_date"] = str_replace(" ", " à ", $post["post_date"]);
            $post["last_modified"] = str_replace(" ", " à ", $post["last_modified"]);

            if ($post["tags"] === "NULL") {
                $post["tags"] = "";
            } else {
                $tags = explode("#", $post["tags"]);
                unset($tags[0]);
                $post["tags"] = "";

                foreach ($tags as $tag) {
                    $post["tags"] .= \Utils\ElementBuilder::buildTag($tag);
                }
            }

            

            $title = $post["title"];

            $comment_model = new \Models\Comment();

            $PAGE = intval(\Utils\Http::getParam('pagination', "get"));
            $POST_ID = intval(\Utils\Http::getParam("post", "get"));

            $comment_number = $comment_model->countPostComments($POST_ID);
            if (!$PAGE) {
                $PAGE = 1;
            }
            $PAGINATION = \Utils\Pagination::paginate("index.php?page=post&action=get&post=$POST_ID&pagination=", $comment_number, 15, $PAGE);
            
            $pagination_params = $PAGINATION["request_params"];

            $comments = $comment_model->getPostComments($POST_ID, $pagination_params["offset"], $pagination_params["limit"]); 

            
            $comments_elements = array();

            foreach ($comments as $comment) {
                $comment["post_date"] = str_replace(" ", " à ", $comment["post_date"]);
                $comment["last_modified"] = str_replace(" ", " à ", $comment["last_modified"]);
                $comment_author = $user_model->find($comment["author_id"]);
                $own = false;

                if (\Utils\Http::isSessionCorrect()) {
                    if (intval(\Utils\Http::getSession("user_id")) === intval($comment["author_id"])) {
                        $own = true;
                    }
                }

                $comment_element = \Utils\ElementBuilder::buildComment(
                    $comment["profile_picture_path"],
                    $comment_author["username"],
                    $comment["author_id"],
                    $comment["comment_content"],
                    $comment["post_date"],
                    $comment["last_modified"],
                    $comment["id"],
                    $own
                );
                array_push($comments_elements, $comment_element);
                
            }

            $POST_ID = \Utils\Http::getParam("post", "get");
            \Utils\Renderer::render(
                "Post", "Blog - $title", [
                    "author" => $author,
                    "post" => $post,
                    "comments" => $comments_elements, 
                    "pagination" => $PAGINATION["page_buttons"],
                    "form_type" => "create", 
                    "values" => [], 
                    "page_params" => ["post" => $POST_ID]],
                ["\Forms\Comment"]
            );
        } else {
            \Utils\Errors::addError(\Utils\Constants::$MISSING_POST_URL_PARAM);
            \Utils\Http::redirect("index.php?page=post&action=view");
        }
    }

    /**
     * Returns post creation page
     * 
     * @return void
     */
    public function create(): void
    {
        if (!\Utils\Http::isSessionCorrect()) {
            \Utils\Errors::addError(\Utils\Constants::$MUST_BE_CONNECTED);
            \Utils\Http::redirect("index.php?page=post&action=view");
        }

        if (!\Utils\Http::isAdmin()) {
            \Utils\Errors::addError(\Utils\Constants::$USER_IS_NOT_ADMIN);
            \Utils\Http::redirect("index.php?page=post&action=view");
        }

        $errors = array();
        if (\Utils\Http::getParam("submit")) {

            // ? Form has been submited, check if it's valid, then save it

            \Utils\Http::setCookie("saved_post_title", htmlspecialchars(\Utils\Http::getParam("post_title")));
            \Utils\Http::setCookie("saved_post_overview", htmlspecialchars(\Utils\Http::getParam("post_overview")));
            \Utils\Http::setCookie("saved_post_content", htmlspecialchars(\Utils\Http::getParam("post_content")));
            \Utils\Http::setCookie("saved_post_tags", htmlspecialchars(\Utils\Http::getParam("post_tags")));
            
            $values = ["post_title", 
                        "post_overview", 
                        "post_content"
                    ];
            foreach ($values as $value) {
                if (!\Utils\Http::getParam($value)) {
                    $const = strtoupper($value) . "_REQUIRED";
                    \Utils\Errors::addError(\Utils\Constants::$$const);
                    array_push($errors, \Utils\Constants::$$const);
                }
            }
            if (!empty($errors)) {
                \Utils\Renderer::render("Form", "Créer un nouveau post", [], ["\Forms\Post"]);
                return;
            }
            
            $Validator = new \Utils\FormValidator();

            $input_errors = array();
            array_push($input_errors, $Validator->checkTitle(\Utils\Http::getParam("post_title")));
            array_push($input_errors, $Validator->checkOverview(\Utils\Http::getParam("post_overview")));
            array_push($input_errors, $Validator->checkContent(\Utils\Http::getParam("post_content")));
            
            if (\Utils\Http::getParam("tags")) {
                array_push($input_errors, $Validator->checkTags(\Utils\Http::getParam("tags")));
            }
            $correct = true;
            foreach ($input_errors as $input_error) {
                if ($input_error) {
                    $correct = false;
                    \Utils\Errors::addError($input_error);
                }
            }


            $tags = \Utils\Http::getParam("post_tags");
            $tags = str_replace("#", "", $tags);
            $tags = str_replace(" ", "", $tags);

            $formatted_tags = "";
            if (str_contains($tags, ",")) {
                $tags = explode(",", $tags);
                foreach ($tags as $tag) {
                    $tag = "#" . $tag;
                    $formatted_tags .= $tag;
                }
            } 

            if ($correct) {
                $new_post = $this->model->create(
                    htmlspecialchars(\Utils\Http::getSession("user_id")[0]),
                    htmlspecialchars(\Utils\Http::getParam("post_title")),
                    htmlspecialchars(\Utils\Http::getParam("post_overview")),
                    htmlspecialchars(\Utils\Http::getParam("post_content")),
                    htmlspecialchars($formatted_tags),
                );
                \Utils\Errors::addError(\Utils\Constants::$POST_SUCCESS, "success");
                \Utils\Http::redirect("index.php?page=post&action=get&post=$new_post");
            }

        }

        // ? Form has not been submitted yet, or was invalid
        // ? Show it anyways

        $saved_post_title = \Utils\Http::getCookie("saved_post_title");
        $saved_post_overview = \Utils\Http::getCookie("saved_post_overview");
        $saved_post_content = \Utils\Http::getCookie("saved_post_content");
        $saved_post_tags = \Utils\Http::getCookie("saved_post_tags");
        $values = [
            "post_title" => $saved_post_title,
            "post_overview" => $saved_post_overview,
            "post_content" => $saved_post_content,
            "post_tags" => $saved_post_tags
        ];
        \Utils\Renderer::render("Form", "Créer un nouveau post", ["form_type" => "create", "values" => $values], ["\Forms\Post"]);        
    }

    

    /**
     * Edits a post
     * 
     * @return void
     */
    public function edit(): void
    {
        if (!\Utils\Http::isSessionCorrect()) {
            \Utils\Errors::addError(\Utils\Constants::$MUST_BE_CONNECTED);
            \Utils\Http::redirect("index.php?page=post&action=view");
        }

        if (!\Utils\Http::getParam("post", "get")) {
            \Utils\Errors::addError(\Utils\Constants::$MISSING_POST_URL_PARAM);
            \Utils\Http::redirect("index.php?page=post&action=view");
        }

        $original_poster = $this->model->getAuthor(intval(\Utils\Http::getParam("post", "get")));
        $user_id = intval(\Utils\Http::getSession("user_id")[0]);
        
        if ($user_id !== $original_poster) {
            \Utils\Errors::addError(\Utils\Constants::$NOT_YOUR_POST);
            \Utils\Http::redirect("index.php?page=post&action=view");
        }

        $errors = array();
        if (\Utils\Http::getParam("submit")) {
            $values = ["post_title",
                       "post_overview",
                       "post_content"];

            foreach ($values as $value) {
                if (!\Utils\Http::getParam($value)) {
                    $const = strtoupper($value) . "_REQUIRED";
                    \Utils\Errors::addError(\Utils\Constants::$$const);
                    array_push($errors, \Utils\Constants::$$const);
                }
            }

            if (!empty($errors)) {
                \Utils\Renderer::render("Form", "Editer un post", ["form_type" => "edit", "values" => [], "page_params" => []], ["\Forms\Post"]);
                return;
            }

            $Validator = new \Utils\FormValidator();

            $input_errors = array();

            array_push($input_errors, $Validator->checkTitle(\Utils\Http::getParam("title")));
            array_push($input_errors, $Validator->checkOverview(\Utils\Http::getParam("overview")));
            array_push($input_errors, $Validator->checkContent(\Utils\Http::getParam("content")));
            if (\Utils\Http::getParam("tags")) {
                array_push($input_errors, $Validator->checkTags(\Utils\Http::getParam("tags")));
            }

            $correct = true;

            foreach ($input_errors as $input_error) {
                if ($input_error) {
                    $correct = false;
                    \Utils\Errors::addError($input_error);
                }
            }

            $tags = \Utils\Http::getParam("post_tags");
            $tags = str_replace("#", "", $tags);
            $tags = str_replace(" ", "", $tags);
            $formatted_tags = "";
            if (str_contains($tags, ",")) {
                $tags = explode(",", $tags);
                foreach ($tags as $tag) {
                    $tag = "#" . $tag;
                    $formatted_tags .= $tag;
                }
            }
            if ($correct) {
                $post_id = \Utils\Http::getParam("post", "get");
                $this->model->update(
                    $post_id,
                    \Utils\Http::getParam("post_title"),
                    \Utils\Http::getParam("post_overview"),
                    \Utils\Http::getParam("post_content"),
                    $formatted_tags,
                );
                \Utils\Errors::addError(\Utils\Constants::$POST_UPDATE_SUCCESS, "success");
                \Utils\Http::redirect("index.php?page=post&action=get&post=$post_id");
            }
        }

        $post = $this->model->find(\Utils\Http::getParam("post", "get"));
        extract($post);

        $tags = explode("#", $tags);
        $tags = array_splice($tags, 1);
        $newtags = array();
        foreach ($tags as $tag) {
            $tag = "#" . $tag;
            array_push($newtags, $tag);
        }
        $tags = implode(",", $newtags);

        $values = ["post_title" => $title, "post_overview" => $overview, "post_content" => $post_content, "post_tags" => $tags];
        \Utils\Renderer::render("Form", "Editer un post", ["values" => $values, "form_type" => "edit", "page_params" => ["post" => intval(\Utils\Http::getParam("post", "get"))]], ["\Forms\Post"]);

    }

    /**
     * Deletes a post
     * 
     * @return void
     */
    public function delete(): void
    {
        if (!\Utils\Http::isSessionCorrect()) {
            \Utils\Errors::addError(\Utils\Constants::$MUST_BE_CONNECTED);
            \Utils\Http::redirect("index.php?page=post&action=view");
        }
        if (\Utils\Http::getParam("post", "get")) {
            $post_id = intval(\Utils\Http::getParam("post", "get"));
            $user_id = intval(explode("|", \Utils\Http::getSession("user_id"))[0]);
            $user_model = new \Models\User;

            $original_poster = $this->model->getAuthor(intval($post_id));
            if (!$original_poster) {
                \Utils\Errors::addError(\Utils\Constants::$POST_DO_NOT_EXIST);
                \Utils\Http::redirect("index.php?page=post&action=view");
            }
            
            if (!$user_model->isAdmin($user_id)) {
                \Utils\Errors::addError(\Utils\Constants::$USER_IS_NOT_ADMIN);
                \Utils\Http::redirect("index.php?page=post&action=view");
            }

            if ($user_id === $original_poster) {
                $comment_model = new \Models\Comment();
                $comment_model->deleteAll($post_id);
                $this->model->delete($post_id);
                \Utils\Errors::addError(\Utils\Constants::$POST_DELETE_SUCCESS, "dark");
            }


            \Utils\Http::redirect("index.php?page=post&action=view");
        } else {
            \Utils\Errors::addError(\Utils\Constants::$MISSING_POST_URL_PARAM);
            \Utils\Http::redirect("index.php?page=post&action=view");
        }
    }
}