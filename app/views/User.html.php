<?php
/**
 * User profile View file
 * User profile View
 * PHP version 8.0.9
 *
 * @category Views
 * @package  Views
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */

extract($values);

$viewer = \Utils\Http::isAdmin();
$user_id = \Utils\Http::getParam("user", "get");
$self = false;
if (\Utils\Http::getSession("user_id")) {
    $self = intval(\Utils\Http::getSession("user_id")[0]) === intval($user_id);
}
?>
<div style="height:0;"></div>
<section id="user" class='container-fluid px-5 pt-3 h-full'>
<div class="modal fade" id="ban-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Bannissement définitif</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            Voulez-vous vraiment bannir <a id="modal-ban-user"></a> ?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Annuler</button>
            <a id="modal-ban-btn" type="button" class="btn btn-danger">Confirmer</a>
        </div>
        </div>
    </div>
    </div>
    <div class='d-flex h-full justify-content-between' id="user-info-container">
        <div id="user-top" class='h-full'>
            <img src="./public/pictures/<?= $user_path ?>" alt="<?= $username ?>" id="user-info-profile-picture" style="width:300px;height:300px" class='rounded-circle border border-2 border-primary'>
            <div>
                <h4><?= $username ?></h4>
                <p><?= $user_description ?></p>
            </div>
        </div>
        <div id="user-info" class='flex-grow-1 ms-4'>
            <ul class='list-group'>
                <li class='list-group-item'>
                    <b>Situation Géographique: </b>
                    <p><?= $user_location ?></p>
                </li>
                <li class='list-group-item'>
                    <b>Role: </b>
                    <p>
                    <?php 
                    if ($user_role === 'Administrateur') { ?>
                        <span class='text-danger fw-bold'><i class='fas fa-shield-alt'></i>&nbsp;Administrateur</span>
                    <?php } else { ?>
                        <?= $user_role ?>
                    <?php } ?>
                    </p>
                </li>
                <li class='list-group-item'>
                    <b>Date de création du compte:</b>
                    <p><?= $user_register_date ?></p>
                </li>
                <li class='list-group-item'>
                    <b>Anniversaire: </b>
                    <p><?= $user_birthday ?></p>
                </li>
            </ul>
        </div>
    </div>
    <?php 
    if ($viewer || $self) { ?>
        <section class='w-full row'>
    <?php } if ($self) { ?>
        <a href='index.php?page=user&action=edit' class='btn btn-primary mx-1 my-2'><i class='fas fa-user-edit'></i>&nbsp;Editer mon profil</a>
        <a href='index.php?page=user&action=changePassword' class='btn btn-primary mx-1 my-2'><i class="fas fa-asterisk"></i></i>&nbsp;Change mon mot de passe</a>
        <a href='index.php?page=user&action=changeUsername' class='btn btn-primary mx-1 my-2'><i class='fas fa-pen'></i>&nbsp;Changer mon pseudo</a>
    <?php } else if ($viewer) { ?>
        <a href="#" data-bs-toggle='modal' data-bs-target='#ban-modal' onclick='confirmBan(<?= $user_id ?>, "<?= $username ?>")' class='btn btn-dark text-light mx-1'><i class="fas fa-gavel"></i></i>&nbsp;Bannir</a>
    <?php } if ($viewer || $self) { ?>
        </section>
    <?php } ?> 
    </section>
