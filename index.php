<?php
session_start();
require_once "src/includes/database.php";
require_once "src/includes/function.php";


$chambres = getThreeFirstchambres($pdo);
$residences = getResidence($pdo);
$images = getImageGallerieWithId($pdo);

?>
<!doctype html>
<html lang="en">

<head>
    <title>Accueil - Kinz</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link rel="stylesheet" href="public/css/home.css">
    <style>
        @media (min-width: 992px) {
            .menu {
                margin-left: 150px;
            }
        }

        @media (max-width: 768px) {
            .menu {
                margin-left: 0px;
            }

            .hero-title {
                font-size: 30px;
                text-align: center;
            }
        }

        @media (max-width: 576px) {
            .menu {
                margin-left: 0px;
            }

            .hero-title {
                font-size: 30px;
                text-align: center;
            }
        }

        .monBagImage {
            background-image: url(public/images/footer-img.svg);
        }
    </style>
    <link
        href="
    https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css
    "
        rel="stylesheet" />
    <link href="
https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.min.css
" rel="stylesheet">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />
</head>

<body>
    <header style="position: fixed;top:0;z-index:1000;background-color:white;width:100%">
        <nav class="navbar navbar-expand-lg bg-body-white shadow">
            <div class="container-fluid px-5">
                <a class="navbar-brand" href="index.php">
                    <img src="public/images/logo.svg" alt="" style="height: 50px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 menu p-1 px-3 d-flex gap-0 monBag rounded-pill ">
                        <li class="nav-item">
                            <a class="nav-link sidebar-link monCouleur" href="src/views/users/chambre.php">Nos Chambres</a>
                        </li>
                        <li class="" style="width:320px">
                            <hr class="mt-4">
                        </li>
                        <li class="nav-item">
                            <a class="nav-link sidebar-link monCouleur" href="src/views/users/propos.php">Qui sommes-nous ?</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link sidebar-link monCouleur" href="src/views/users/contact.php">Contact</a>
                        </li>
                    </ul>
                    <div class="d-flex align-items-center gap-3 ">
                        <!-- Bouton pour démarrer un appel téléphonique -->
                        <a href="tel:+221786820303" class="btn monBag2 d-flex align-items-center  gap-2"> <!-- Remplacez +1234567890 par le numéro de téléphone à appeler -->
                            <span class="text-white fs-6">Telephone</span>
                            <i class="ri-phone-fill fes-5 text-white"></i>
                        </a>
                        <!-- Icone WhatsApp avec un lien pour démarrer une discussion -->
                        <a href="https://wa.me/786820303" target="_blank"> <!-- Remplacez 1234567890 par le numéro de téléphone au format international -->
                            <div class="monBag3 rounded-circle d-flex align-items-center justify-content-center">
                                <i class="ri-whatsapp-line text-white fs-4"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main style="margin-top: 98px;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="respMob " style="width: 100%; ">
                        <div class="d-flex align-items-center p-0 p-sm-5" style="background-image: url(public/images/Group36.svg); background-size: cover; background-repeat: no-repeat; background-position: center; height: 100%;">
                            <div>
                                <div class="w-100 py-5">
                                    <h1 class="text-white hero-title px-3 px-md-0 py-5">Bienvenue chez <br> <span class="monCoul2">Kinz Résidences</span> </h1>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="container ban z-3 d-none d-sm-block ">
            <div class="row">
                <div class="col-12 baniere rounded-pill d-flex justify-content-center gap-5 p-2">
                    <div class="text-white d-flex flex-column justify-content-center gap-3 align-items-center">
                        <p class="fs-4 m-0">+ 50 Résidences</p>
                        <div class="baniere-icon rounded-circle">
                            <i class="ri-home-office-line fs-3"></i>
                        </div>
                    </div>
                    <div class="text-white d-flex flex-column justify-content-center gap-3 align-items-center">
                        <p class="fs-4 m-0">+200 Chambres</p>
                        <div class="baniere-icon rounded-circle">
                            <i class="ri-stack-line fs-3"></i>
                        </div>
                    </div>
                    <div class="text-white d-flex flex-column justify-content-center gap-3 align-items-center">
                        <p class="fs-4 m-0">120k Demande</p>
                        <div class="baniere-icon rounded-circle">
                            <i class="ri-group-3-line fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12 d-flex flex-column align-items-center justify-content-center mt-0 mt-md-5">
                    <div class="line"></div>
                    <h2 class="mt-4 w-50 text-center">Explorez notre gallerie de chambre</h2>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-12 col-sm-6" style="height: 70vh;">
                    <div class="gallerie rounded d-flex justify-content-center align-items-center position-relative" style="background-image: url(public/images/gallerie-1.svg); background-size: cover; background-repeat: no-repeat; background-position: center; height: 100%;">
                        <div class="position-absolute bottom-0 end-0 d-flex gap-2 p-3">
                            <p class="m-0 text-white">Découvrir</p>
                            <i class="ri-arrow-right-circle-line text-white"></i>
                        </div>
                    </div>
                </div>
                <div class="col-12  d-none d-md-block col-sm-6 d-flex flex-column justify-content-between">
                    <div class="row mt-3 mt-sm-0">
                        <div class="col-12 col-sm-12 col-lg-6" style="height: 30vh;">
                            <div class="gallerie1 rounded position-relative" style="background-image: url(public/images/gallerie-2.svg); background-size: cover; background-repeat: no-repeat; background-position: center; height: 100%;">
                                <div class="position-absolute bottom-0 end-0 d-flex gap-2 p-3">
                                    <p class="m-0 text-white">Découvrir</p>
                                    <i class="ri-arrow-right-circle-line text-white"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-lg-6 mt-3 mt-sm-0 d-block d-sm-none d-lg-block" style="height: 30vh;">
                            <div class="gallerie2 rounded position-relative" style="background-image: url(public/images/gallerie-3.png); background-size: cover; background-repeat: no-repeat; background-position: center; height: 100%;">
                                <div class="position-absolute bottom-0 end-0 d-flex gap-2 p-3">
                                    <p class="m-0 text-white">Découvrir</p>
                                    <i class="ri-arrow-right-circle-line text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3 mt-sm-3">
                        <div class="col-12" style="height: 38vh;">
                            <div class="gallerie3 rounded position-relative" style="background-image: url(public/images/gallerie-4.svg); background-size: cover; background-repeat: no-repeat; background-position: center; height: 100%;">
                                <div class="position-absolute bottom-0 end-0 d-flex gap-2 p-3">
                                    <p class="m-0 text-white">Découvrir</p>
                                    <i class="ri-arrow-right-circle-line text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 d-none d-sm-block d-lg-none mt-sm-4" style="height: 35vh;">
                    <div class="gallerie rounded" style="background-image: url(public/images/gallerie-3.png); background-size: cover; background-repeat: no-repeat; background-position: center; height: 100%;">
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12 d-flex flex-column align-items-center justify-content-center mt-0">
                    <div class="line"></div>
                    <h2 class="mt-4 w-50 text-center fw-semibold">Découvrir nos chambres et suites</h2>
                </div>
            </div>
            <!-- Partie chambre et suites -->
            <div class="row mt-5 ">
                <?php foreach ($chambres as $k => $chambre): ?>
                    <div class="col-12 col-sm-6 col-lg-4 position-relative px-3 mt-4">
                        <div class="container CardBag roundede pb-2  shadow-sm hovera p-3">
                            <div id="carouselExample<?= $chambre["ID_Chambre"] ?>" class="carousel slide">
                                <div class="carousel-inner">
                                    <?php
                                    $first = true; // Variable pour définir la première image comme active
                                    foreach ($images as $image):
                                        if ($image["ID_Chambre"] == $chambre["ID_Chambre"]): ?>
                                            <div class="carousel-item <?= $first ? 'active' : '' ?>">
                                                <img src="src/uploads/imgChambre/splide/<?= $image["url"] ?>" class="d-block w-100 rounded" style="height: 40vh;object-fit:cover" alt="Image de la chambre">
                                            </div>
                                            <?php $first = false; // Après la première image, passer à false 
                                            ?>
                                    <?php endif;
                                    endforeach; ?>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample<?= $chambre["ID_Chambre"] ?>" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample<?= $chambre["ID_Chambre"] ?>" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                            <div class="row px-2">
                            <span class="m-0 text-center p-1 fw-medium text-white monSize2 rounded mt-3 CardBagTitre monCouleur rounded-pill hero-para"><?= $chambre["nom"] ?></span>
                            </div>
                            <div class="row monCouleur">
                                <span class="mt-3 monCouleur fw-semibold ">Caracteristiques</span>
                            </div>
                            <div class=" d-flex gap-2 mt-1 " >
                                <?php if ($chambre["television"] == "oui"): ?>
                                    <div class="d-flex justify-content-center align-items-center bg-light rounded gap-1 p-1">
                                        <i class="ri-tv-2-line monSize"></i>
                                        <span  class="monSize">Television</span>
                                    </div>
                                <?php endif; ?>
                                <?php if ($chambre["comodite"] == "ventiller"): ?>
                                    <div class="d-flex justify-content-center align-items-center bg-light rounded gap-1 p-1">
                                        <i class="ri-water-flash-line monSize"></i>
                                        <span class="monSize">ventilateur</span>
                                    </div>
                                <?php else: ?>
                                    <div class="d-flex justify-content-center align-items-center bg-light rounded gap-1 p-1 CardBagTitre2 text-center ">
                                        <i class=" ri-fridge-line monSize"></i>
                                        <span class="monSize">climatiseur</span>
                                    </div>
                                <?php endif; ?>
                                <div class=" d-flex justify-content-center align-items-center bg-light rounded gap-1 p-1 ">

                                    <span class="monSize"><?= $chambre["dimension"] ?>(m²)</span>
                            </div>
                                
                            </div>
                            
                            <div class="mt-2">
                                <span class="fw-bold">Prix:</span>
                                <span class="fw-bold"><?= $chambre["prix"] ?>FCFA</span>
                            </div>
                            <div class="monCoul2 mt-1">
                                <span class="fw-bold"><i class="ri-map-pin-fill"></i> : </span>
                                <?php foreach ($residences as  $residence): ?>
                                    <?php if ($chambre["ID_Residence"] == $residence["ID_Residence"]): ?>
                                        <a href="<?= $residence["position"] ?>" target="_blank">
                                            <span class="monCoul2"><?= $residence["adresse"] ?></span>
                                        </a>
                                    <?php endif; ?>

                                <?php endforeach; ?>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-4 ">
                                <a href="tel:+221786820303" class="btn text-white rounded d-flex align-items-center gap-2 monBag2"> <!-- Remplacez +1234567890 par le numéro de téléphone à appeler -->
                                    <span class="text-white ">Telephone</span>
                                    <i class="ri-phone-fill text-white"></i>
                                </a>
                                <a href="src/views/users/detailsChambre.php?id=<?= $chambre["ID_Chambre"] ?>" class="text-decoration-none text-black">
                                    <div class="d-flex align-items-center gap-2 ">
                                        <span>Voir details</span>
                                        <i class="ri-arrow-right-circle-line"></i>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 d-flex flex-column align-items-center justify-content-center mt-5">
                    <div class="line"></div>
                    <h2 class="mt-4 w-50 text-center">Découvrir nos résidences</h2>
                </div>
            </div>
            <div class="row mt-5 pl-3">
                <section class="splide" id="splide" aria-labelledby="carousel-heading">
                    <div class="splide__track">
                        <ul class="splide__list">
                            <?php foreach ($residences as $residence): ?>
                                <li class="splide__slide">
                                    <div
                                        class="rounded position-relative"
                                        style="
                                            background-image: url(src/uploads/imgResidence/<?= $residence["couverture"] ?>);
                                            background-repeat: no-repeat;
                                            background-size: cover;
                                            background-position: center;
                                            height: 60vh;
                                ">
                                        <div class=" mt-3 rounded d-flex justify-content-center align-items-center text-white position-absolute top-0 end-0">
                                            <p class="p-2 bg-warning rounded">
                                                <?= $residence["nom"] ?>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </section>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12 d-flex flex-column align-items-center justify-content-center mt-5">
                    <div class="line"></div>
                    <h2 class="mt-4 w-50 text-center">Témoignages</h2>
                </div>
            </div>
            <div class="row mt-5">
                <section class="splide" id="splide2" aria-labelledby="carousel-heading">
                    <div class="splide__track">
                        <ul class="splide__list">
                            <li class="splide__slide">
                                <div class="shadow p-2">
                                    <img
                                        class="p-2 rounded-circle"
                                        src="public/images/testi-4.svg"
                                        alt=""
                                        style="border: solid 2px var(--btn-color)" />
                                    <p class="fw-bold mt-3">Michael</p>
                                    <span>
                                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Obcaecati quidem mollitia accusamus debitis voluptates animi, nihil sint odio, excepturi dolorem eum. Esse animi asperiores recusandae iusto, earum vitae doloremque repudiandae?
                                    </span>
                                    <div class="d-flex gap-2 mt-3">
                                        <div class="text-warning"><i class="ri-star-fill"></i></div>
                                        <div class="text-warning"><i class="ri-star-fill"></i></div>
                                        <div class="text-warning"><i class="ri-star-fill"></i></div>
                                        <div class="text-warning"><i class="ri-star-fill"></i></div>
                                        <div class="text-warning"><i class="ri-star-fill"></i></div>
                                    </div>
                                </div>
                            </li>
                            <li class="splide__slide">
                                <div class="shadow p-2">
                                    <img
                                        class="p-2 rounded-circle"
                                        src="public/images/testi-2.svg"
                                        alt=""
                                        style="border: solid 2px var(--btn-color)" />
                                    <p class="fw-bold mt-3">Esther Howard</p>
                                    <span>
                                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nemo culpa debitis voluptates officia quos accusamus ipsam fugiat quibusdam nisi nam quo blanditiis error, magnam ea repellat quis perspiciatis dolorum incidunt?
                                    </span>
                                    <div class="d-flex gap-2 mt-3">
                                        <div class="text-warning"><i class="ri-star-fill"></i></div>
                                        <div class="text-warning"><i class="ri-star-fill"></i></div>
                                        <div class="text-warning"><i class="ri-star-fill"></i></div>
                                        <div class="text-warning"><i class="ri-star-fill"></i></div>
                                        <div class="text-warning"><i class="ri-star-fill"></i></div>
                                    </div>
                                </div>
                            </li>
                            <li class="splide__slide">
                                <div class="shadow p-2">
                                    <img
                                        class="p-2 rounded-circle"
                                        src="public/images/testi-1.svg"
                                        alt=""
                                        style="border: solid 2px var(--btn-color)" />
                                    <p class="fw-bold mt-3">Darlene Robertson</p>
                                    <span>
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam a ratione minima nemo numquam, qui doloremque ipsam nulla aliquid accusamus totam nisi. Suscipit a quidem neque! Dignissimos assumenda ex excepturi.
                                    </span>
                                    <div class="d-flex gap-2 mt-3">
                                        <div class="text-warning"><i class="ri-star-fill"></i></div>
                                        <div class="text-warning"><i class="ri-star-fill"></i></div>
                                        <div class="text-warning"><i class="ri-star-fill"></i></div>
                                        <div class="text-warning"><i class="ri-star-fill"></i></div>
                                        <div class="text-warning"><i class="ri-star-fill"></i></div>
                                    </div>
                                </div>
                            </li>
                            <li class="splide__slide">
                                <div class="shadow p-2">
                                    <img
                                        class="p-2 rounded-circle"
                                        src="public/images/testi-2.svg"
                                        alt=""
                                        style="border: solid 2px var(--btn-color)" />
                                    <p class="fw-bold mt-3">Kristin Watson</p>
                                    <span>
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium, ullam aspernatur. Animi veritatis consequatur, necessitatibus cumque ut dolores sint voluptas quis omnis reiciendis alias esse vero. Sint molestias tempora ipsam?
                                    </span>
                                    <div class="d-flex gap-2 mt-3">
                                        <div class="text-warning"><i class="ri-star-fill"></i></div>
                                        <div class="text-warning"><i class="ri-star-fill"></i></div>
                                        <div class="text-warning"><i class="ri-star-fill"></i></div>
                                        <div class="text-warning"><i class="ri-star-fill"></i></div>
                                        <div class="text-warning"><i class="ri-star-fill"></i></div>
                                    </div>
                                </div>
                            </li>
                            <li class="splide__slide">
                                <div class="shadow p-2">
                                    <img
                                        class="p-2 rounded-circle"
                                        src="public/images/testi-3.svg"
                                        alt=""
                                        style="border: solid 2px var(--btn-color)" />
                                    <p class="fw-bold mt-3">Joana Mills</p>
                                    <span>
                                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Pariatur labore fugit vero totam voluptas maxime quisquam repellat, magni incidunt, illum odio a voluptatibus reiciendis aperiam quas in perferendis aut sequi!
                                    </span>
                                    <div class="d-flex gap-2 mt-3">
                                        <div class="text-warning"><i class="ri-star-fill"></i></div>
                                        <div class="text-warning"><i class="ri-star-fill"></i></div>
                                        <div class="text-warning"><i class="ri-star-fill"></i></div>
                                        <div class="text-warning"><i class="ri-star-fill"></i></div>
                                        <div class="text-warning"><i class="ri-star-fill"></i></div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </section>
            </div>
        </div>
    </main>
    <footer style="margin-top: 80px;">
        <!-- place footer here -->
        <div class="container-fluid monBagImage">
            <div>
                <div class="container-fluid  py-5">
                    <div class="row d-flex justify-content-center ">
                        <div class="col-4 col-lg-2">
                            <img src="public/images/logo.svg" class="w-75" alt="">
                        </div>
                    </div>
                    <div class="container">
                        <div class="row mt-4 d-flex justify-content-between">
                            <div class="d-none d-md-block col-3">
                                <a href="763104000" class="noire">
                                    <div class="row">
                                        <span class="monCouleure fw-medium">Téléphone</span>
                                        <span>+221.77.757.57.57</span>
                                    </div>
                                </a>
                                <div class="row mt-3">
                                    <a href="" class="noire">
                                        <span class="monCouleure fw-medium">Adresse <br></span>
                                        <span>Keur Massar, Mtoa</span>
                                    </a>
                                </div>
                                <div class="row mt-3">
                                    <a href="mamebayet63@gmail.com">
                                        <span class="monCouleure fw-medium">Email <br></span>
                                        <span class="noire">myblackpearl@gmail.com</span>
                                    </a>
                                </div>
                            </div>
                            <div class="d-none d-md-block col-3">
                                <div class="row">
                                    <span class="monCouleure fw-medium">Liens utiles</span>
                                </div>
                                <div class="row mt-3">
                                    <span class="mt-0"><i class="ri-message-3-fill"></i> Actualités</span>
                                    <span class="mt-3"><i class="ri-message-2-line"></i> Recrutement</span>
                                    <span class="mt-3"><i class="ri-message-2-line"></i> Recrutement</span>
                                </div>
                                <div class="row mt-3">
                                    <span class="monCouleur fs-3">
                                        <i class="ri-facebook-circle-fill mx-1"></i>
                                        <i class="ri-instagram-fill mx-1"></i>
                                        <i class="ri-twitter-x-fill mx-1"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="row">
                                    <span class="monCouleur fw-medium">S’inscrire à la newsletter</span>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-10 form-group">
                                        <input type="text" class="w-100 monInput form-control" placeholder=" Email">
                                        <button class="mt-3 monBouton p-2 w-50">S’inscrire</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid monBag20 py-1">
            <div class="row d-flex justify-content-between">
                <div class="d-none d-lg-block col-4">
                    <span>Copyright 2024 By ...</span>
                </div>
                <div class="col-12 text-center col-lg-3 text-lg-start">
                    <span class="">
                        <i class="ri-facebook-circle-fill mx-1"></i>
                        <i class="ri-instagram-fill mx-1"></i>
                        <i class="ri-twitter-x-fill mx-1"></i>
                    </span>
                </div>
                <div class="d-none d-lg-block col-3">
                    <span class="mx-5">Politique de confidentialité</span>
                </div>
            </div>
        </div>
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var splide = new Splide("#splide", {
                perPage: 2,
                perMove: 1,
                pagination: false,
                gap: "10px",
                type: "loop",
                autoplay: true,
                interval: 5000,
                breakpoints: {
                    400: {
                        perPage: 1,
                    },
                    430: {
                        perPage: 1,
                    },
                    768: {
                        perPage: 2,
                    },
                    900: {
                        perPage: 2,
                    },
                },
            });
            splide.mount();

            new Splide("#splide2", {
                perPage: 3,
                perMove: 1,
                pagination: false,
                gap: "20px",
                type: "loop",
                autoplay: true,
                interval: 4000,
                breakpoints: {
                    400: {
                        perPage: 1,
                    },
                    430: {
                        perPage: 1,
                    },
                    768: {
                        perPage: 2,
                    },
                    900: {
                        perPage: 3,
                    },
                },
            }).mount();
        });
    </script>
    <script src="public/javascript/home.js"></script>
    <script src="
    https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js
    "></script>
    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>