<?php
/**
 * Footer template file
 * Footer layout for website
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
 * Footer template
 * Footer layout for website
 * PHP version 8.0.9
 *
 * @category Layout
 * @package  Layout
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */
?>
<footer class="footer">
    <div class="container">
        <div class="row d-flex justify-content-between">
            <div class="col-md-3 col-sm-6">
                <ul class="social-networks d-flex flex-column justify-content-around align-items-center h-100 list-unstyled">
                    <li class="social-network">
                        <a class='text-decoration-none list-unstyled text-dark h5' target="_blank" href="https://www.linkedin.com/in/younès-ziadi-756643205/" target="_blank" class="social-network-link">
                            <i class="fab fa-linkedin"></i> Linkedin
                        </a>
                    </li>
                    <li class="social-network">
                        <a class='text-decoration-none list-unstyled text-dark h5' target="_blank" href="https://twitter.com/zuruuh_" class="social-network-link">
                            <i class="fab fa-twitter"></i> Twitter
                        </a>
                    </li>
                    <li class="social-network">
                        <a class='text-decoration-none list-unstyled text-dark h5' target="_blank" href="https://github.com/Zuruuh" class="social-network-link">
                            <i class="fab fa-github"></i> Github
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-3 col-sm-6 d-flex flex-column justify-content-end">
                <div class="copyrights text-center">
                    <p>
                        <span>Copyright &copy; 2021 <b>Younès ZIADI</b></span>
                    </p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="footer-nav">
                    <ul class='list-unstyled d-flex flex-wrap justify-content-between'>
                        <li class="footer-nav-link px-2"><a class='text-decoration-none text-dark' href="index.php">Accueil</a></li>
                        <li class="footer-nav-link px-2"><a class='text-decoration-none text-dark' href="index.php#contact">Contact</a></li>
                        <li class="footer-nav-link px-2"><a class='text-decoration-none text-dark' href="index.php?page=post&action=view">Posts</a></li>
                        <li class="footer-nav-link px-2"><a class='text-decoration-none text-dark' href="index.php?page=home&action=about">A propos</a></li>
                        <?php if (\Utils\Http::isSessionCorrect()) { ?>
                            <li class="footer-nav-link px-2"><a class='text-decoration-none text-dark' href="index.php?page=user&action=view&user="<?= \Utils\Http::getSession("user_id")[0] ?>>Mon compte</a></li>
                        <?php } ?>
                        <?php if (\Utils\Http::isAdmin()) { ?>
                        <li class="footer-nav-link footer-nav-admin-link px-2"><a class='text-decoration-none text-dark' href="index.php?page=admin&action=dashboard">Administration</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>