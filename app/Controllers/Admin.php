<?php
/**
 * Admin Dashboard Controller Class File
 * Controller file for Admin Dashboard
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
 * Admin Dashboard Controller Class
 * Controller class for Admin Dashboard
 * PHP version 8.0.9
 *
 * @category Controllers
 * @package  Controllers
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */
class Admin extends Controller
{

    /**
     * Displays page with most recents posts & comments + Stats
     * 
     * @return void
     */
    public function dashboard(): void
    {
        // ? Stats dernières 168h (Commentaires + posts), Posts récents (-1 semaine)
        if (!\Utils\Http::isSessionCorrect()) {
            \Utils\Errors::addError(\Utils\Constants::$INVALID_SESSION);
            \Utils\Http::redirect("index.php");
        }

        if (!\Utils\Http::isAdmin()) {
            \Utils\Errors::addError(\Utils\Constants::$USER_IS_NOT_ADMIN);
            \Utils\Http::redirect("index.php");
        }

        $post_model = new \Models\Post();
        $user_model = new \Models\User();
        $comment_model = new \Models\Comment();

        $posts = $post_model->getRecentPosts();
        $users = $user_model->getRecentUsers();
        $comments = $comment_model->getRecentComments();

        // ? 1 => Create stats elements
        $posts_number = sizeof($posts);
        $users_number = sizeof($users);
        $comments_number = sizeof($comments);

        $posts_stats = \Utils\ElementBuilder::buildStat("posts", $posts_number, "", "index.php?page=post&action=view");

        $user_stats = \Utils\ElementBuilder::buildStat("utilisateurs", $users_number, "", "index.php?page=admin&action=dashboard#latest-users");

        $comments_stats = \Utils\ElementBuilder::buildStat("commentaires", $comments_number, "", "index.php?page=admin&action=dashboard#latest-comments");

        // ? 2 => Create elements preview

        $posts_preview = array();
        $users_preview = array();
        $comments_preview = array();

        foreach ($posts as $post) {
            extract($post);
            $user_name = $user_model->getUsername($author_id);
            $exact_path = $user_model->getProfilePicture($author_id);
            $element  = "<div class='post-preview d-flex w-100 my-4 border rounded-1 px-2 h-auto'>";
            $element .= "<img src='./public/$exact_path' alt='$user_name's profile' class='rounded-circle w-25 h-25 p-2' />";
            $element .= "<div class='d-flex flex-grow-1 flex-column justify-content-between py-2'><em>$title</em>";
            $element .= "<p class='pe-4'>$overview</p>";
            $element .= "<div class='d-flex justify-content-between align-items-end'>";
            $element .= "<a href='index.php?page=post&action=get&post=$id'>Lire le post</a>";
            $element .= "<p class='m-0'>Par <a href='index.php?page=user&action=view&user=$author_id'>$user_name</a></p>";
            $element .= "</div></div></div>";
            array_push($posts_preview, $element);
        }

        foreach ($users as $user) {
            extract($user);
            $exact_path = $user_model->getProfilePicture($id);
            $element  = "<div class='user-preview d-flex w-100 my-4 border rounded-1 px-2 h-auto'>";
            $element .= "<img src='./public/$exact_path' alt='$username's profile' class='rounded-circle w-25 h-25 p-2' />";
            $element .= "<div><p><a href='index.php?page=user&action=view&user=$id'>$username</a></p>";
            $element .= "<div><p>$first_name</p>";
            $element .= "<p>$last_name</p></div></div></div>";
            array_push($users_preview, $element);
        }

        foreach ($comments as $comment) {
            extract($comment);
            $user_name = $user_model->getUsername($author_id);
            $exact_path = $user_model->getProfilePicture($author_id);
            $post_name = $post_model->getTitle($post_id);

            $element  = "<div class='comment-preview d-flex w-100 my-4 border rounded-1 px-2 h-auto'>";
            $element .= "<img src='./public/$exact_path' alt='$user_name's profile' class='rounded-circle w-25 h-25 p-2' />";
            $element .= "<div><p><a href='index.php?page=user&action=view&user=$id'>$username</a></p>";
            $element .= "<p>$comment_content</p>";
            $element .= "<p><i>Post: </i><a href='index.php?page=post&action=get&post=$post_id'>$post_name</a></p></div></div>";
            array_push($comments_preview, $element);
        }

        \Utils\Renderer::render(
            "AdminDashboard",
            "Blog - Interface d'administration",
            ["values" => [
                "stats" => [$posts_stats, $user_stats, $comments_stats],
                "recent_posts" => $posts_preview,
                "recent_users" => $users_preview,
                "recent_comments" => $comments_preview
            ]]
        );

    }

    /**
     * Displays list of recents comments with buttons to invalidate, validate, or ban user
     * 
     * @return void
     */
    public function validate(): void
    {
        // ? Liste commentaires invalidés + Pagination ?

        if (!\Utils\Http::isSessionCorrect()) {
            \Utils\Errors::addError(\Utils\Constants::$INVALID_SESSION);
            \Utils\Http::redirect("index.php");
        }

        if (!\Utils\Http::isAdmin()) {
            \Utils\Errors::addError(\Utils\Constants::$USER_IS_NOT_ADMIN);
            \Utils\Http::redirect("index.php");
        }

        $comment_model = new \Models\Comment(); 

        if (\Utils\Http::getParam("comment", "get") && (\Utils\Http::getParam("state", "get") !== null)) {
            // ? User clicked on validate button, execute action 
           
            $COMMENT_ID = intval(\Utils\Http::getParam("comment", "get"));
            $STATE = intval(\Utils\Http::getParam("state", "get"));

            $comment = $comment_model->find($COMMENT_ID);

            if ($comment == null) {
                // ? Comment does not exist
                \Utils\Errors::addError(\Utils\Constants::$COMMENT_DO_NOT_EXIST, "primary");
                \Utils\Http::redirect("index.php?page=admin&action=validate");
            }

            if ($comment["validated"] !== null) {
                // ? Comment was already verified
                \Utils\Errors::addError(\Utils\Constants::$COMMENT_ALREADY_VERIFIED, "primary");
                \Utils\Http::redirect("index.php?page=admin&action=validate");
            }

            // * UPDATE COMMENT & REDIRECT
            \Utils\Errors::addError(\Utils\Constants::$COMMENT_UPDATE_SUCCESS, "success");
            $comment_model->setState($COMMENT_ID, $STATE);
            \Utils\Http::redirect("index.php?page=admin&action=validate");

        } else {  
            // ? DISPLAY PAGE CORRECTLY

            $comments_raw_data = $comment_model->getUnvalidatedComments();
            $comments = array();

            $user_model = new \Models\User();
            
            foreach ($comments_raw_data as $comment_raw_data) {
                $user = $user_model->find($comment_raw_data["author_id"]); 
                $comment_element = \Utils\ElementBuilder::buildAdminComment(
                    $user["profile_picture_path"],
                    $user["username"],
                    $user["id"],
                    $comment_raw_data["comment_content"],
                    $comment_raw_data["post_date"],
                    $comment_raw_data["last_modified"],
                    $comment_raw_data["id"]
                );

                array_push($comments, $comment_element);
            }

            $page_comments = implode("", $comments);

            if (empty($comments)) {
                $page_comments  = "<div class='w-100 d-flex justify-content-center align-items-center flex-column mt-5'><h4 class='mt-5'>On dirait qu'il n'y a rien à voir ici..</h4>";
                $page_comments .= "<p>Cliquez <a href='index.php?page=admin&action=dashboard'>ici</a> pour revenir à l'interface d'administration</p></div>";
            }

            \Utils\Renderer::render(
                "CommentValidation",
                "Blog - Validation de commentaires",
                ["page_comments" => $page_comments]
            );
        }

    }

    /**
     * Bans an account & deletes all of his posts & comments
     * 
     * @return void
     */
    public function ban(): void
    {
        if (!\Utils\Http::isSessionCorrect()) {
            \Utils\Errors::addError(\Utils\Constants::$INVALID_SESSION);
            \Utils\Http::redirect("index.php");
        }

        if (!\Utils\Http::isAdmin()) {
            \Utils\Errors::addError(\Utils\Constants::$USER_IS_NOT_ADMIN);
            \Utils\Http::redirect("index.php");
        }

        if (!\Utils\Http::getParam("user", "get")) {
            // ? User not specified
            \Utils\Errors::addError(\Utils\Constants::$MISSING_USER_PARAM);
            \Utils\Http::redirect("index.php?page=admin&action=validate");
        }

        $user_model = new \Models\User();
        $USER_ID = intval(\Utils\Http::getParam("user", "get"));
        $user = $user_model->find($USER_ID);

        $sess = intval(\Utils\Http::getSession("user_id")[0]);

        if ($sess === $USER_ID) {
            // ? User is banning himself
            \Utils\Errors::addError(\Utils\Constants::$SELF_BAN, "primary");
            \Utils\Http::redirect("index.php?page=admin&action=validate");
        }

        if (!$user) {
            // ? User does not exist
            \Utils\Errors::addError(\Utils\Constants::$USER_DO_NOT_EXIST, "primary");
            \Utils\Http::redirect("index.php?page=admin&action=validate");
        }

        $comment_model = new \Models\Comment();
        $comment_model->deleteAllUserComments($USER_ID);

        if ($user["profile_picture_path"] !== \Utils\Constants::$DEFAULT_IMAGE) {
            \Utils\File::deleteImage($user["profile_picture_path"]);
        }

        $ACCOUNT_BANNED = \Utils\Constants::$ACCOUNT_BANNED;

        $user_model->update(
            $USER_ID,
            $ACCOUNT_BANNED,
            $ACCOUNT_BANNED,
            \Utils\Constants::$DEFAULT_IMAGE,
            $ACCOUNT_BANNED,
            $ACCOUNT_BANNED,
        );

        $user_model->changeUsername($USER_ID, \Utils\Constants::$REMOVED_ACCOUNT);

        $user_model->disableAccount($USER_ID);

        // ? User has been banned 
        \Utils\Errors::addError(\Utils\Constants::$BAN_SUCCESS, "dark");
        \Utils\Http::redirect("index.php?page=admin&action=validate");

    }

}