<?php
/**
 * Home
 * Main Blog page
 * PHP version 8.0.9
 *
 * @category Views
 * @package  Views
 * @author   Younès Ziadi <ziadi.mail.pro@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://younes-ziadi.com/blog/
 */
?>
<div style="height:0"></div>
<section id="intro" class="d-flex align-items-center justify-content-start w-100 px-5">
    <div id="intro-left">
        <a href="index.php?page=user&action=view&user=1" class="">
            <img src="./public/pictures/1.jpeg" class="rounded-circle border border-2 border-primary"/>
        </a>
    </div>
    <div id="intro-right">
        <h1 class="text-left">Hello 👋 je suis Younès,</h1>
        <h3 class="text-left">Bienvenue sur mon Blog !</h3>
    </div>
</section>
<section>
    <h2 class ="text-center py-3">Posts récents 📖</h2>
    <div class="container-fluid px-4 list-group pt-5">
    <?php if (empty($posts)) { ?>
        <p>On dirait bien qu'il n'y a rien à voir ici 🙁</p>
    <?php } else {
        foreach ($posts as $post) { 
            echo $post;
        } ?>
    <?php } ?> 
    </div>
</section>
<hr>
<section id="projets" class="d-flex flex-column justify-content-center">
    <h2 class="text-center py-3">Mes projets 👇</h2>
    <div class="container">
        <div class="row">
        <div class="col-md-4 col-sm-6 d-flex flex-column justify-content-center mb-2 card rounded">
                <img src="./public/assets/dashboard.png" alt="" card="card-img-top">
                <div class="card-body">
                    <span class="fw-bold card-title">Tableau de bord d'administration</span>
                    <p class="card-text">Interface d'administration affichant des statistiques & informations</p>
                    <a class="btn btn-primary" href="https://younes-ziadi.com/projects/AdminDashboard/" >Voir le projet</a>
                </div>
            </div>

            <div class="col-md-4 col-sm-6 d-flex flex-column justify-content-center mb-2 card">
                <img src="./public/assets/calculator.png" alt="" class="card-img-top">
                <div class="card-body">
                    <span class="card-title fw-bold">Calculatrice JS</span>
                    <p class="card-text">Calculatrice réalisée en javascript</p>
                    <a class="btn btn-primary" href="https://younes-ziadi.com/projects/Calculator/HTML/" >Voir le projet</a>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 d-flex flex-column justify-content-center mb-2 card">
                <img src="./public/assets/credit.png" alt="" class="card-img-top">
                <div class="card-body">
                    <span class="card-title fw-bold">Carte de crédit HTML</span>
                    <p class="card-text">Copie de carte de crédit réalisée en HTML et CSS</p>
                    <a href="https://younes-ziadi.com/projects/Credit/" class="btn btn-primary">Voir le projet</a>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 d-flex flex-column justify-content-center mb-2 card">
                <img src="./public/assets/calendar.png" alt="" class="card-img-top">
                <div class="card-body">
                    <span class="card-title fw-bold">Calendrier Glassmorphique</span>
                    <p class="card-text">
                        Calendrier réalisé grâce à la librarie DyCalendar
                    </p>
                    <a href="https://younes-ziadi.com/projects/GlassCalendar/" class="btn btn-primary">Voir le projet</a>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 d-flex flex-column justify-content-center mb-2 card">
                <img src="./public/assets/cards.png" alt="" class="card-img-top">
                <div class="card-body">
                    <span class="card-title fw-bold">Cartes Glassmorphique</span>
                    <p class="card-text">
                        Cartes informatives réalisées grâce à la librarie TiltJS
                    </p>
                    <a href="https://younes-ziadi.com/projects/TiltedCards/html/" class="btn btn-primary">voir le projet</a>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 d-flex flex-column justify-content-center mb-2 card">
                <img src="./public/assets/price.png" alt="" class="card-img-top">
                <div class="card-body">
                    <span class="card-title fw-bold">Table des Prix</span>
                    <p class="card-text">
                        Tableau de prix réalisé en HTML et CSS
                        
                    </p>
                    <a href="https://younes-ziadi.com/projects/PricingCards/HTML/" class="btn btn-primary">Voir le projet</a>
                </div>
            </div>
        </div>
    </div>
</section>
<hr>
<section id="contact" class="d-flex flex-column justify-content-center pb-2">
    <h2 class="text-center mb-2">Me contacter</h2>
    <div class="container">
        <?= $page_forms[0] ?>
    </div>
</section>