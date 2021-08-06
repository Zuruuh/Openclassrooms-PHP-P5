<?php
/**
 * Register View file
 * Register View
 * PHP version 8.0.9
 *
 * @category Views
 * @package  Views
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */
?>
    <?php 
    if (isset($errors)) {
        echo "<div id='errors'>";
        foreach ($errors as $error) {
            echo "<div class='error'>$error</div>";
        } 
        echo "</div>";
    } 
    ?>
<div class="form">
    <?= $page_forms[0] ?>
</div>