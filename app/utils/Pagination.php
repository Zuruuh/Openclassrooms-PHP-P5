<?php
/**
 * Pagination Class File
 * Class for pagination 
 * PHP version 8.0.9
 *
 * @category Utils
 * @package  Utils
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */

namespace Utils;

/**
 * Pagination Class
 * Class for pagination 
 * PHP version 8.0.9
 *
 * @category Utils
 * @package  Utils
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */

class Pagination
{
    
    /**
     * Returns pagination links
     * 
     * @param int $link         The link to redirect to 
     * @param int $total        Number of items
     * @param int $MAX_PER_PAGE Number of items per page
     * @param int $PAGE         Current page
     * 
     * @return array
     */
    public static function paginate(string $link, int $total = 0, int $MAX_PER_PAGE = 10, int $PAGE = 1): array
    {
        $MAX_PAGE = 1;
        $OFFSET = 0;

        while ($total > $MAX_PER_PAGE) {
            $MAX_PAGE++;
            $total -= $MAX_PER_PAGE;
        }

        if ($PAGE > 1) {
            $OFFSET = ($PAGE-1)*10;
        }

        $page_buttons = array();


        array_push($page_buttons, \Utils\ElementBuilder::buildPagination("<<", $PAGE === 1 ? "disabled" : "", $link . $PAGE-1));
        array_push($page_buttons, \Utils\ElementBuilder::buildPagination($PAGE, "active", $link . $PAGE));
        array_push($page_buttons, \Utils\ElementBuilder::buildPagination(">>", $PAGE === $MAX_PAGE ? "disabled" : "", $link . $PAGE+1));

        return ["request_params" => ["offset" => $OFFSET, "limit" =>$MAX_PER_PAGE], "page_buttons" => implode("", $page_buttons)];
    }

}