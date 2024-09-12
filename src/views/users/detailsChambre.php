<?php
session_start();
require_once "../../includes/database.php";
require_once "../../includes/function.php";

$success = $_SESSION['success'] ?? [];
$error = $_SESSION["errors"] ?? [];
unset($_SESSION["errors"], $_SESSION["success"]);

$chambreId = $_GET["id"] ?? null;
$chambre = getChambreWithId($pdo, $chambreId);
$residences = searchParamsToGetResidences($pdo, $_GET);
$images = getImageGallerieWithId($pdo);

?>
<!doctype html>
<html lang="en">

<head>
    <title>Details chambre - Kinz</title>
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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.12/dist/css/splide.min.css">
</head>

<body>
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
                        <a href="tel:+1234567890" class="btn monBag2 d-flex align-items-center  gap-2"> <!-- Remplacez +1234567890 par le numéro de téléphone à appeler -->
                            <span class="text-white fs-6">Telephone</span>
                            <i class="ri-phone-fill fes-5 text-white"></i>
                        </a>
                        <!-- Icone WhatsApp avec un lien pour démarrer une discussion -->
                        <a href="https://wa.me/777425714" target="_blank"> <!-- Remplacez 1234567890 par le numéro de téléphone au format international -->
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
            <div class="row  ">
                <div class="col-12 col-lg-7  detImage" style="height: 40vh;">
                    <!-- Carrousel principal -->
                    <div id="main-carousel<?= $chambre["ID_Chambre"] ?>" class="splide bg-danger" aria-label="Main carousel">
                        <div class="splide__track">
                            <ul class="splide__list">
                            <?php foreach ($images as $image): ?>
                                <?php if ($image["ID_Chambre"] == $chambre["ID_Chambre"]): ?>
                                <li class="splide__slide">
                                    <img src="../../uploads/imgChambre/splide/<?= $image["url"] ?>" alt="Image de la chambre" class="w-100 h-100" style=" object-fit: cover; ">
                                </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Carrousel des vignettes -->
                    <div id="thumbnail-carousel<?= $chambre["ID_Chambre"] ?>" class="splide mt-3" aria-label="Thumbnail carousel">
                    <div class="splide__track">
                        <ul class="splide__list">
                        <?php foreach ($images as $image): ?>
                            <?php if ($image["ID_Chambre"] == $chambre["ID_Chambre"]): ?>
                            <li class="splide__slide">
                                <img src="../../uploads/imgChambre/splide/<?= $image["url"] ?>" alt="Thumbnail de la chambre" style="height: 60px; object-fit: cover;">
                            </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        </ul>
                    </div>
                    </div>

                </div>
                <div class="col-12 col-lg-5 d-flex flex-column justify-content-between">
                    <div>
                        <span class="fw-bold fs-5 mt-sm-3">Description : </span>
                        <p class="my-sm-3"><?= $chambre["description"] ?></p>
                    </div>
                    <div class="my-3">
                        <span class="fw-bold fs-5 ">Prix: </span>
                        <span><?= $chambre["prix"] ?> FCFA</span>
                    </div>
                    <div>
                        <span class="fw-bold fs-5">Residence: </span>
                        <?php foreach ($residences as $residence): ?>
                            <?php if ($residence["ID_Residence"] == $chambre["ID_Residence"]): ?>
                                <span><?= $residence["nom"] ?></span>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="mt-4">
                        <button <?php if ($chambre["status"] == 2) {
                                    echo "disabled";
                                } ?> class="btn monBag2 text-white w-100" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?= $chambre["ID_Chambre"] ?>">Reserver</button>
                    </div>
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
            <div class="row my-5">
                <div class="col-12 col-sm-6 mt-sm-5">
                    <span class="fw-bold fs-5 ">Caracteristique : </span>
                </div>
                <div class="col-12 mt-4">
                    <div class="row gap-4">
                        <?php if ($chambre["television"] == "oui"): ?>
                            <div class="col-2 col-sm-1  shadow d-flex flex-column fs-5 justify-content-center align-items-center bg-light rounded gap-3 p-3">
                                <img src="../../../public/images/icons/televisions.png" alt="" class="icons w-100">
                                
                            </div>
                        <?php endif; ?>
                        <?php if ($chambre["comodite"] == "ventiller"): ?>
                            <div class="col-2 col-sm-1  d-flex flex-column fs-5 justify-content-center align-items-center bg-light shadow rounded gap-3 p-3">
                                <img src="../../../public/images/icons/ventilateur.png" alt="" class="icons w-100">
                                
                            </div>
                        <?php else: ?>
                            <div class="col-2 col-sm-1 bg-light shadow d-flex flex-column fs-5 justify-content-center align-items-center bg-light rounded gap-3 p-3">
                                <img src="../../../public/images/icons/climatiseur.png" alt="" class="icons w-100">
                                
                            </div>
                        <?php endif; ?>
                        <?php if ($chambre["frigo"] == "oui"): ?>
                            <div class="col-2 col-sm-1  shadow d-flex flex-column fs-5 justify-content-center align-items-center bg-light rounded gap-3 p-3">
                                <img src="../../../public/images/icons/frigo.png" alt="" class="icons w-100">
                                
                            </div>
                        <?php endif; ?>
                        <?php if ($chambre["cuisine"] == "oui"): ?>
                            <div class="col-2 col-sm-1 shadow d-flex flex-column fs-5 justify-content-center align-items-center bg-light rounded gap-3 p-3">
                                <img src="../../../public/images/icons/cuisine.png" alt="" class="icons w-100">
                                
                            </div>
                        <?php endif; ?>
                        <?php if ($chambre["armoir"] == "oui"): ?>
                            <div class="col-2 col-sm-1  shadow d-flex flex-column fs-5 justify-content-center align-items-center bg-light rounded gap-3 p-3">
                                <img src="../../../public/images/icons/armoir.png" alt="" class="icons w-100">
                                
                            </div>
                        <?php endif; ?>
                        <?php foreach ($residences as $residence): ?>
                            <?php if ($chambre["ID_Residence"] == $residence["ID_Residence"]): ?>
                                <?php if ($residence["wifi"] == "oui"): ?>
                                    <div class="col-2 col-sm-1 shadow d-flex flex-column fs-5 justify-content-center align-items-center bg-light rounded gap-3 p-3">
                                        <img src="../../../public/images/icons/modem.png" alt="" class="icons w-100">
                                        
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?php foreach ($residences as $residence): ?>
                            <?php if ($chambre["ID_Residence"] == $residence["ID_Residence"]): ?>
                                <?php if ($residence["parking"] == "oui"): ?>
                                    <div class="col-2 col-sm-1  shadow d-flex flex-column fs-5 justify-content-center align-items-center bg-light rounded gap-3 p-3">
                                        <img src="../../../public/images/icons/parking.png" alt="" class="icons w-100">
                                        
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>
    <?php if (!empty($errors)) : ?>
        <?= notification("ri-alert-fill", "danger", $error); ?>
    <?php endif; ?>
    <!-- Bootstrap JavaScript Libraries -->
    <script>
        document.getElementById('reservationForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Empêche l'envoi par défaut du formulaire

            // Réinitialiser les messages d'erreur
            let errors = {
                email: '',
                debut: '',
                jours: '',
                nom: '',
                prenom: '',
                numero: ''
            };

            let email = document.getElementById('email').value;
            let debut = document.getElementById('debut').value;
            let jours = document.getElementById('jours').value;
            let nom = document.getElementById('nom').value;
            let prenom = document.getElementById('prenom').value;
            let numero = document.getElementById('numero').value;

            // Validation
            if (!debut) {
                errors.debut = 'Veuillez entrer une date de début.';
            }
            if (!email) {
                errors.email = 'Veuillez entrer une email valide.';
            }
            if (!jours || isNaN(jours) || jours <= 0) {
                errors.jours = 'Veuillez entrer un nombre de jours valide.';
            }
            if (!nom) {
                errors.nom = 'Veuillez entrer votre nom.';
            }
            if (!prenom) {
                errors.prenom = 'Veuillez entrer votre prénom.';
            }
            if (!numero || isNaN(numero)) {
                errors.numero = 'Veuillez entrer un numéro valide.';
            }

            // Afficher les erreurs
            document.getElementById('debut-error').textContent = errors.debut;
            document.getElementById('email-error').textContent = errors.email;
            document.getElementById('jours-error').textContent = errors.jours;
            document.getElementById('nom-error').textContent = errors.nom;
            document.getElementById('prenom-error').textContent = errors.prenom;
            document.getElementById('numero-error').textContent = errors.numero;

            // Vérifier s'il y a des erreurs
            let hasErrors = Object.values(errors).some(error => error !== '');
            if (!hasErrors) {
                // Si pas d'erreurs, rediriger vers le contrôleur PHP
                this.submit();
            }
        });
    </script>
    <script>
  document.addEventListener('DOMContentLoaded', function () {
    var main = new Splide('#main-carousel<?= $chambre["ID_Chambre"] ?>', {
      type       : 'fade',
      heightRatio: 0.5,
      pagination : false,
      arrows     : false,
    }).mount();

    var thumbnails = new Splide('#thumbnail-carousel<?= $chambre["ID_Chambre"] ?>', {
      fixedWidth  : 100,
      fixedHeight : 60,
      isNavigation: true,
      gap         : 10,
      focus       : 'center',
      pagination : false,
      cover      : true,
      breakpoints : {
        600: {
          fixedWidth : 66,
          fixedHeight: 40,
        },
      },
    }).mount();

    main.sync(thumbnails);
  });
</script>



    <script src="../../../public/javascript/chambre.js"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.12/dist/js/splide.min.js"></script>
</body>

</html>