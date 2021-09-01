<?php
/**
 * User self profile View file
 * User self profile View
 * PHP version 8.0.9
 *
 * @category Views
 * @package  Views
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */

extract($values);
?>
<div style="height:0;"></div>
<div class="w-full d-flex justify-content-center align-items-end mt-5 mb-2">
    <img class='edit-profile-picture rounded-circle border border-1 border-primary' style="width:300px;height:300px;" src='./public/<?=$profile_picture_path?>' alt='Your profile picture'/>
    <img class='edit-profile-picture rounded-circle border border-1 border-primary' style="width:150px;height:150px;" src='./public/<?=$profile_picture_path?>' alt='Your profile picture'/>
    <img class='edit-profile-picture rounded-circle border border-1 border-primary' style="width:80px;height:80px;" src='./public/<?=$profile_picture_path?>' alt='Your profile picture'/>
</div>
<section>
    <?php
    echo $page_forms[0];
    ?>
</section>
