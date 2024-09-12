<?php
session_start();
require_once "../../includes/database.php";
require_once "../../includes/function.php";

$chambres = getChambres($pdo);
$residences = searchParamsToGetResidences($pdo, $_GET);
$images = getImageGallerieWithId($pdo);

$success = $_SESSION['success'] ?? [];
$error = $_SESSION["errors"] ?? [];
$messages = $_SESSION["message"] ?? "";
unset($_SESSION["errors"], $_SESSION["success"], $_SESSION["message"],);


?>
<!doctype html>
<html lang="en">

<head>
    <title>Nos chambres - Kinz</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link rel="stylesheet" href="../../../public/css/home.css">
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
        }

        @media (max-width: 576px) {
            .menu {
                margin-left: 0px;
            }
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

<body class="position-relative">
    <header style="position: fixed;top:0;z-index:1000;background-color:white;width:100%">
        <nav class="navbar navbar-expand-lg bg-body-white shadow">
            <div class="container-fluid px-5">
                <a class="navbar-brand" href="../../../index.php">
                    <img src="../../../public/images/logo.svg" alt="" style="height: 50px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 menu p-1 px-3 d-flex gap-0 monBag rounded-pill ">
                        <li class="nav-item">
                            <a class="nav-link sidebar-link  monCoul2" href="./chambre.php">Nos Chambres</a>
                        </li>
                        <li class="" style="width:320px">
                            <hr class="mt-4">
                        </li>
                        <li class="nav-item">
                            <a class="nav-link sidebar-link monCouleur" href="./propos.php">Qui sommes-nous ?</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link sidebar-link monCouleur" href="./contact.php">Contact</a>
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
    <main style="margin-top: 120px;">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h2>Nos chambres</h2>
                </div>
            </div>
            <div class="row mt-5">
                <?php foreach ($chambres as $k => $chambre): ?>
                    <div class="col-12 col-sm-6 col-lg-4  position-relative p-2 hovera mt-5">
                        <div class="container CardBag roundede pb-2  shadow-sm hovera p-3 shadow-sm">
                            <!-- Commencer le carrousel uniquement si la chambre a des images -->
                            <div id="carouselExample<?= $chambre["ID_Chambre"] ?>" class="carousel slide">
                                <div class="carousel-inner">
                                    <?php
                                    $first = true; // Variable pour définir la première image comme active
                                    foreach ($images as $image):
                                        if ($image["ID_Chambre"] == $chambre["ID_Chambre"]): ?>
                                            <div class="carousel-item <?= $first ? 'active' : '' ?>">
                                                <img src="../../uploads/imgChambre/splide/<?= $image["url"] ?>" class="d-block w-100 rounded" style="height: 40vh;object-fit:cover" alt="Image de la chambre">
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
                            <div class="row">
                                <span class="m-0 text-center p-1 fw-medium text-white monSize2 rounded mt-3 CardBagTitre monCouleur rounded-pill hero-para"><?= $chambre["nom"] ?></span>
                            </div>
                            <div class="row monCouleur">
                                <span class="mt-3 monCouleur fw-semibold ">Caracteristiques</span>
                            </div>
                            <div class="d-flex gap-2 mt-2">
                                <?php if ($chambre["television"] == "oui"): ?>
                                    <div class="d-flex justify-content-center align-items-center bg-light rounded gap-2 p-1">
                                        <i class="ri-tv-2-line monSize"></i>
                                        <span class="monSize">Television</span>
                                    </div>
                                <?php endif; ?>
                                <?php if ($chambre["comodite"] == "ventiller"): ?>
                                    <div class="d-flex justify-content-center align-items-center bg-light rounded gap-2 p-1">
                                        <i class="ri-water-flash-line monSize"></i>
                                        <span class="monSize">ventilateur</span>
                                    </div>
                                <?php else: ?>
                                    <div class="d-flex justify-content-center align-items-center bg-light rounded gap-2 p-1">
                                        <i class=" ri-fridge-line monSize"></i>
                                        <span class="monSize">climatiseur</span>
                                    </div>
                                <?php endif; ?>
                                <div class="d-flex justify-content-center align-items-center bg-light rounded gap-2 p-1">

                                    <span class="monSize"><?= $chambre["dimension"] ?> (m²)</span>
                                </div>
                            </div>
                            <div class="mt-2">
                                <span class="fw-bold">Prix:</span>
                                <span class="fw-bold"><?= $chambre["prix"] ?>FCFA</span>
                            </div>
                            <div class="monCoul2">
                                <span class="fw-bold"><i class="ri-map-pin-fill"></i>: </span>
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
                                <a href="./detailsChambre.php?id=<?= $chambre["ID_Chambre"] ?>" class="text-decoration-none text-black">
                                    <div class="d-flex align-items-center gap-2 ">
                                        <span>Voir details</span>
                                        <i class="ri-arrow-right-circle-line"></i>
                                    </div>
                                </a>
                            </div>
                            <button <?php if ($chambre["status"] == 2) {
                                        echo "disabled";
                                    } ?> data-bs-toggle="modal" data-bs-target="#staticBackdrop<?= $chambre["ID_Chambre"] ?>" class="btn monBag2 w-100 text-white mt-4">Réserver</button>

<div class="modal fade modal-scrollable" id="staticBackdrop<?= $chambre["ID_Chambre"] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel<?= $chambre["ID_Chambre"] ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="text-center">Entrez les détails pour la reservations</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="">
                                        <form id="reservationForm" action="../../controllers/users/reservationController.php" method="post">
                                            <input type="hidden" name="id_chambre" value="<?= $chambre["ID_Chambre"] ?>" />
                                            <input type="hidden" name="id_residence" value="<?= $chambre["ID_Residence"] ?>">
                                            <div class="form-group col-12">
                                                <label for="email" class="fw-bold border-bottom">Email</label>
                                                <input type="email" id="email" placeholder="votre email" name="email" class="form-control p-3 shadow-sm mt-3">
                                                <ul class="error-message">
                                                    <li class="text-danger" id="email-error"></li>
                                                </ul>
                                            </div>
                                            <div class="form-group col-12">
                                                <label for="debut" class="fw-bold border-bottom">Date debut</label>
                                                <input type="date" id="debut" name="debut" class="form-control p-3 shadow-sm mt-3">
                                                <ul class="error-message">
                                                    <li class="text-danger" id="debut-error"></li>
                                                </ul>
                                            </div>

                                            <div class="form-group mt-3 col-12">
                                                <label for="jours" class="fw-bold border-bottom">Nombre de jours</label>
                                                <input type="text" id="jours" placeholder="entrez le nombre de jours" name="jours" class="form-control p-3 shadow-sm mt-3">
                                                <ul class="error-message">
                                                    <li class="text-danger" id="jours-error"></li>
                                                </ul>
                                            </div>

                                            <div class="form-group mt-3 col-12">
                                                <label for="nom" class="fw-bold border-bottom">Nom</label>
                                                <input type="text" id="nom" placeholder="Entrez votre nom" name="nom" class="form-control p-3 shadow-sm mt-3">
                                                <ul class="error-message">
                                                    <li class="text-danger" id="nom-error"></li>
                                                </ul>
                                            </div>

                                            <div class="form-group mt-3 col-12">
                                                <label for="prenom" class="fw-bold border-bottom">Prénom</label>
                                                <input type="text" id="prenom" placeholder="Entrez votre prenom" name="prenom" class="form-control p-3 shadow-sm mt-3">
                                                <ul class="error-message">
                                                    <li class="text-danger" id="prenom-error"></li>
                                                </ul>
                                            </div>

                                            <div class="form-group mt-3 col-12">
                                                <label for="numero" class="fw-bold border-bottom">Numéro</label>
                                                <input type="text" id="numero" placeholder="Entrez votre numero" name="numero" class="form-control p-3 shadow-sm mt-3">
                                                <ul class="error-message">
                                                    <li class="text-danger" id="numero-error"></li>
                                                </ul>
                                            </div>

                                            <div class="mt-3">
                                                <button type="submit" class="btn w-100 monBag2 d-flex align-items-center justify-content-center gap-3 text-white mt-3">
                                                    <span>Validez</span>
                                                    <i class="ri-arrow-right-circle-line"></i>
                                                </button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
    <?php if (!empty($success)) : ?>
        <?= notification("ri-checkbox-circle-fill", "success", $success); ?>
    <?php endif; ?>
    <?php if (!empty($errors)) : ?>
        <?= notification("ri-alert-fill", "danger", $error); ?>
    <?php endif; ?>
    <?php if (!empty($messages)) : ?>
        <?= notification("ri-alert-fill", "danger", $messages); ?>
    <?php endif; ?>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="../../../public/javascript/chambre.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var sliders = document.querySelectorAll('.splide');
            sliders.forEach(function(slider) {
                new Splide(slider, {
                    type: 'loop',
                    perPage: 1,
                    autoplay: true,
                    // Vous pouvez ajouter d'autres options ici, comme des flèches de navigation, des pagination, etc.
                }).mount();
            });
        });
    </script>
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