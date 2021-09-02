<?php
/**
 * Home Controller Class File
 * Controller file for Home component
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
 * Home Controller Class
 * Controller class for Home component
 * PHP version 8.0.9
 *
 * @category Controllers
 * @package  Controllers
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */
class Home extends Controller
{
    /**
     * Returns default home page
     * 
     * @return void
     */
    public function view(): void
    {
        $post_elements = array();

        $post_model = new \Models\Post();
        $user_model = new \Models\User();

        $posts = $post_model->get(0, 3);

        foreach ($posts as $post) {
            extract($post);
            $author_username = $user_model->getUsername($author_id);
            array_push(
                $post_elements, 
                \Utils\ElementBuilder::buildPost(
                    $id,
                    $author_id,
                    $author_username,
                    $post_date,
                    $title,
                    $overview
                )
            );
        }

        \Utils\Renderer::render("Home", "Blog - Page d'accueil", ["posts" => $post_elements], ["\Forms\Contact"]);
    }
}