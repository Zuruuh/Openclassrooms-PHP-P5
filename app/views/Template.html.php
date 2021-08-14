<?php
/**
 * Template Class File
 * Class for view page render
 * PHP version 8.0.9
 *
 * @category Utils
 * @package  Utils
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
    <link rel="stylesheet" href="./public/css/lib/bootstrap.min.css">
    <link rel="stylesheet" href="./public/css/style.css">
</head>
<body>
    <?= $page_layout ?>
    <main>
    <?php
    if ($page_errors !== "") {
        $page_errors = "<section id='errors' style='z-index:1500' class='w-100 h-auto d-flex flex-column align-items-center position-fixed top-0'>" . $page_errors . "</section";
        echo $page_errors;
    }
    ?>
        <?= $page_content ?>
    </main>
    <script src="./public/js/lib/bootstrap.bundle.min.js"></script>
    <script src="./public/js/script.js"></script>
    <?= $page_footer ?>
</body>
</html>