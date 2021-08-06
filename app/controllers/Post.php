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
        $posts = $this->model->get();
        $user_model = new \Models\User();
        $post_elements = array();
        foreach ($posts as $post) {
            extract($post);
            $date = explode(" ", $post_date)[0]; 
            $author = $user_model->getUsername($author_id);

            $post_element = \Utils\ElementBuilder::buildPost($id, $author_id, $author, $date, $title, $overview);

            array_push($post_elements, $post_element);
        }
        \Utils\Renderer::render("Posts", "Blog - Posts récents", ["posts" => $post_elements]);
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
                \Utils\Http::redirect("index.php?page=post&action=view");
            } else {
                $user_model = new \Models\User();
                $author = $user_model->getUsername($post["author_id"]);
                
                $post["post_date"] = str_replace(" ", " à ", $post["post_date"]);
                $post["last_modified"] = str_replace(" ", " à ", $post["last_modified"]);

                if ($post["tags"] === "NULL") {
                    $post["tags"] = "";
                }

                $title = $post["title"];

                $comment_model = new \Models\Comment();
                $comments = $comment_model->getPostComments(intval(\Utils\Http::getParam("post", "get")));
                
                $comments_elements = array();

                foreach ($comments as $comment) {
                    $comment["post_date"] = str_replace(" ", " à ", $comment["post_date"]);
                    $comment["last_modified"] = str_replace(" ", " à ", $comment["last_modified"]);

                    $comment_element = \Utils\ElementBuilder::buildComment(
                        $comment["profile_picture_path"],
                        $author,
                        $comment["author_id"],
                        $comment["comment_content"],
                        $comment["post_date"],
                        $comment["last_modified"]
                    );
                    array_push($comments_elements, $comment_element);
                }

                $POST_ID = \Utils\Http::getParam("post", "get");
                
                \Utils\Renderer::render("Post", "Blog - $title", ["author" => $author, "post" => $post, "comments" => $comments_elements, "form_type" => "create", "values" => [], "page_params" => ["post" => $POST_ID]], ["\Forms\Comment"]);
            }
        } else {
            \Utils\Renderer::render("Home");
        }
    }

    /**
     * Returns post creation page
     * 
     * @return void
     */
    public function create(): void
    {
        if (\Utils\Http::isSessionCorrect()) {
            $user_id = explode("|", \Utils\Http::getSession("user_id"))[0];
            $user_model = new \Models\User();
            if (!$user_model->isAdmin($user_id)) {
                \Utils\Http::redirect("index.php");
            }

            $errors = array();
            if (\Utils\Http::getParam("submit")) {

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
                        array_push($errors, \Utils\Constants::$$const);
                    }
                }

                if (!empty($errors)) {
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
                    print_r("test");
                    \Utils\Renderer::render("Form", "Créer un nouveau post", ["errors" => $errors, "form_type" => "create", "values" => $values], ["\Forms\Post"]);
                    return;
                }
                $Validator = new \Utils\FormValidator();

                $title_errors = $Validator->checkTitle(\Utils\Http::getParam("post_title"));
                $overview_errors = $Validator->checkOverview(\Utils\Http::getParam("post_overview"));
                $content_errors = $Validator->checkContent(\Utils\Http::getParam("post_content"));
                $tags_errors = null;
                if (\Utils\Http::getParam("tags")) {
                    $tags_errors = $Validator->checkTags(\Utils\Http::getParam("tags"));
                }

                $input_errors = [$title_errors, $overview_errors, $content_errors, $tags_errors ? $tags_errors : ["state" => true, "message" => null]];
                $check_errors = array();
                
                foreach ($input_errors as $input_error) {
                    if (isset($input_error["state"])) {
                        if ($input_error["state"] == true) {
                            array_push($check_errors, false);
                        } else {
                            array_push($check_errors, $input_error["message"]);
                        }
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
                        htmlspecialchars($user_id),
                        htmlspecialchars(\Utils\Http::getParam("post_title")),
                        htmlspecialchars(\Utils\Http::getParam("post_overview")),
                        htmlspecialchars(\Utils\Http::getParam("post_content")),
                        htmlspecialchars($formatted_tags),
                    );
                     \Utils\Http::redirect("index.php?page=post&action=get&post=$new_post");
                }

            } else {
                \Utils\Renderer::render("Form", "Créer un nouveau post", ["form_type" => "create", "values" => []], ["\Forms\Post"]);
            }
            



        } else {
            \Utils\Http::redirect("index.php");
        }
    }

    

    /**
     * Edits a post
     * 
     * @return void
     */
    public function edit(): void
    {
        if (!\Utils\Http::isSessionCorrect() || !\Utils\Http::getParam("post", "get")) {
            \Utils\Http::redirect("index.php?page=post&action=view");
        }

        $errors = array();
        if (\Utils\Http::getParam("submit")) {
            $values = ["post_title",
                       "post_overview",
                       "post_content"
                    ];
            foreach ($values as $value) {
                if (!\Utils\Http::getParam($value)) {
                    $const = strtoupper($value) . "_REQUIRED";
                    array_push($errors, \Utils\Constants::$$const);
                }
            }

            if (!empty($errors)) {
                \Utils\Renderer::render("Form", "Editer un post", ["errors" => $errors, "form_type" => "edit", "values" => [], "page_params" => []], ["\Forms\Post"]);
                return;
            }
            $Validator = new \Utils\FormValidator();

            $title_errors = $Validator->checkTitle(\Utils\Http::getParam("title"));
            $overview_errors = $Validator->checkOverview(\Utils\Http::getParam("overview"));
            $content_errors = $Validator->checkContent(\Utils\Http::getParam("content"));
            $tags_errors = null;
            if (\Utils\Http::getParam("tags")) {
                $tags_errors = $Validator->checkTags(\Utils\Http::getParam("tags"));
            }

            $input_errors = [$title_errors, $overview_errors, $content_errors, $tags_errors ? $tags_errors : ["state" => true, "message" => null]];
            $check_errors = array();
            
            foreach ($input_errors as $input_error) {
                if (isset($input_error["state"])) {
                    array_push($check_errors, false);
                } else {
                    print_r($input_error);
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
                \Utils\Http::redirect("index.php?page=post&action=get&post=$post_id");
            }
        }

        $original_poster = $this->model->getAuthor(intval(\Utils\Http::getParam("post", "get")));
        $user_id = \Utils\Http::getSession("user_id")[0];
        
        if ($user_id != $original_poster) {
            \Utils\Http::redirect("index.php?page=post&action=view");
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
        \Utils\Renderer::render("Form", "Editer un post", ["values" => $values, "form_type" => "edit", "page_params" => ["post=" . \Utils\Http::getParam("post", "get")]], ["\Forms\Post"]);

    }

    /**
     * Deletes a post
     * 
     * @return void
     */
    public function delete(): void
    {
        if (\Utils\Http::isSessionCorrect() &&  \Utils\Http::getParam("post", "get")) {
            $post_id = \Utils\Http::getParam("post", "get");
            $user_id = explode("|", \Utils\Http::getSession("user_id"))[0];
            $user_model = new \Models\User;

            $original_poster = $this->model->getAuthor(intval($post_id));
            if (!$original_poster) {
                \Utils\Http::redirect("index.php?page=post&action=view");
            }
            
            if ($user_id == $original_poster && $user_model->isAdmin($user_id)) {
                $comment_model = new \Models\Comment();
                $comment_model->deleteAll($post_id);
                $this->model->delete($post_id);
            }
            \Utils\Http::redirect("index.php?page=post&action=view");

        } else {
            \Utils\Http::redirect("index.php?page=post&action=view");
        }
    }
}