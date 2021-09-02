<?php
/**
 * Comment Validation Page View file
 * Comment Validation Page View
 * PHP version 8.0.9
 *
 * @category Views
 * @package  Views
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */
?>

<div style="height:0;"></div>
<section class='h-100'>
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
    <div>
        <h5 class='mx-4 mt-4'>Cliquez <a href='index.php?page=admin&action=dashboard'>ici</a> pour revenir sur l'interface d'administration</h5>
    </div>
    <table class='mx-4 w-100 mt-4'>
        <tbody class='list-group w-100'>
            <?= $page_comments ?>
        </tbody>
    </table>
</section>
<div id="pagination">

</div>