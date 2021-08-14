<?php
/**
 * Navbar template file
 * Navbar layout for website
 * PHP version 8.0.9
 *
 * @category Layout
 * @package  Layout
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */
namespace Layout;
/**
 * Navbar template
 * Navbar layout for website
 * PHP version 8.0.9
 *
 * @category Layout
 * @package  Layout
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */
?>
<nav class="navbar navbar-expand-lg bg-secondary text-uppercase sticky-top" id="nav-bar">
    <div class="container-fluid px-5">
        <a class="navbar-brand" href="index.php"><img style="width:50px;height:50px" class='me-2 mb-2' src="./public/assets/logo.png" alt="Blog" />Blog</a>
        <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded me-5" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">

            <?php if (\Utils\Http::isAdmin()) { ?>
                <li class="nav-item">
                    <a class="nav-link admin-nav-link" href="index.php?page=admin&action=dashboard"><i class="fas fa-unlock"></i>&nbsp;&nbsp;Admin</a>
            <?php } ?>

            <?php if (!\Utils\Http::isSessionCorrect()) { ?>
            <li class="nav-item mx-0 mx-lg-1 d-flex flex-row align-items-center">
                <a class='nav-link' href='index.php?page=user&action=register'>S'inscrire</a>
            </li>
            <li class="nav-item mx-0 mx-lg-1 d-flex flex-row align-items-center">
                <a class='nav-link' href='index.php?page=user&action=login'>Se connecter</a>
            </li>
            <?php } else { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class='fas fa-user'></i>&nbsp;&nbsp;Mon Compte
                    </a>
                    <ul class='dropdown-menu vw-100' aria-labelledby="navbarDropdown">
                        <li>
                            <a class='dropdown-item nav-dropdown-item' href='index.php?page=user&action=view&user=<?= \Utils\Http::getSession("user_id")[0] ?>'><i class='far fa-user'> </i> Mon Profil</a>
                        </li>
                        <li><a class='dropdown-item nav-dropdown-item' href='index.php?page=user&action=edit'><i class='far fa-edit'> </i> Editer mes informations</a></li>
                        <li><hr class='dropdown-divider'></li>
                        <li><a class='dropdown-item nav-dropdown-item' href='index.php?page=user&action=disconnect'><i class='fas fa-sign-out-alt'> </i> Me déconnecter</a></li>
                    </ul>
                </li>
            <?php } ?>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=post&action=view">
                        <i class='fas fa-file-alt'></i>&nbsp;&nbsp;Posts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php#contact">
                        <i class='far fa-envelope'></i>&nbsp;&nbsp;Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php#projets">
                        <i class='fas fa-list-ul'></i>&nbsp;&nbsp;Projets</a>
                </li>
            </ul>
        </div>
    </div>
</nav>