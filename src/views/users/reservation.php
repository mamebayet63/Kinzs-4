<?php
session_start();
require_once "../../includes/database.php";
require_once "../../includes/function.php";

$chambreId = $_GET["id"] ?? null;
$debut = $_GET["debut"] ?? null;
$fin = $_GET["fin"] ?? null;
$chambre = getChambreWithId($pdo, $chambreId);

$success = $_SESSION['success'] ?? [];
$errors = $_SESSION["errors"] ?? [];
unset($_SESSION['success'], $_SESSION['errors']);


?>
<!doctype html>
<html lang="en">

<head>
    <title>Reservation - Kinz</title>
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

<body>
    <header style="position: fixed;top:0;z-index:1000;background-color:white;width:100%">
        <nav class="navbar navbar-expand-lg bg-body-white shadow">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="../../../public/images/logo.svg" alt="" style="height: 70px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 menu p-1 d-flex gap-3">
                        <li class="nav-item sidebar-link">
                            <a class="nav-link" href="index.php">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link sidebar-link" href="./chambre.php">Nos Chambres</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link sidebar-link" href="./propos.php">Qui sommes-nous ?</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link sidebar-link" href="./contact.php">Contact</a>
                        </li>
                    </ul>
                    <div class="d-flex align-items-center gap-3">
                        <button class="btn bg-success d-flex align-items-center gap-4">
                            <span class="text-white fs-5">Telephone</span>
                            <i class="ri-phone-fill fes-5 text-white"></i>
                        </button>
                        <div style="width: 48px;height:48px" class="bg-success rounded-circle d-flex align-items-center justify-content-center">
                            <i class="ri-whatsapp-line text-white fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main style="margin-top: 120px;" class="position-relative">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>Completez votre reservations</h3>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-12 col-sm-12 col-lg-6 order-3 order-lg-1">
                    <form action="../../controllers/users/reservationController.php" method="post">
                        <input type="hidden" name="id_chambre" value="<?= $chambre["ID_Chambre"] ?>">
                        <input type="hidden" name="debut" value="<?= $debut ?>">
                        <input type="hidden" name="fin" value="<?= $fin ?>">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-lg-6 form-group">
                                <label for="nom" class="fw-bold border-bottom">Nom</label>
                                <input type="text" name="nom" class="form-control p-3 mt-2 shadow" placeholder="Entrez votre nom ...">
                                <?php if (!empty($errors['nom'])) : ?>
                                    <li class="text-danger"><?= $errors['nom'] ?></li>
                                <?php endif; ?>
                            </div>
                            <div class="col-12 col-sm-12 col-lg-6 form-group">
                                <label for="prenom" class="fw-bold border-bottom">Prenom</label>
                                <input type="text" name="prenom" class="form-control p-3 mt-2 shadow" placeholder="Entrez votre prenom ...">
                                <?php if (!empty($errors['prenom'])) : ?>
                                    <li class="text-danger"><?= $errors['prenom'] ?></li>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12 col-sm-12 col-lg-6 form-group">
                                <label for="numero" class="fw-bold border-bottom">Numero</label>
                                <input type="text" name="numero" class="form-control p-3 mt-2 shadow" placeholder="Entrez votre numero ...">
                                <?php if (!empty($errors['numero'])) : ?>
                                    <li class="text-danger"><?= $errors['numero'] ?></li>
                                <?php endif; ?>
                            </div>
                            <div class="col-12 col-sm-12 col-lg-6 form-group">
                                <label for="numero" class="fw-bold border-bottom">Email</label>
                                <input type="email" name="email" class="form-control p-3 mt-2 shadow" placeholder="Adresse mail">
                                <?php if (!empty($errors['email'])) : ?>
                                    <li class="text-danger"><?= $errors['email'] ?></li>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="w-100 btn bg-success text-white fs-5">
                                <span>Rerserver</span>
                                <i class="ri-calendar-schedule-line"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-12 col-sm-12 col-lg-6 order-1 order-lg-3">
                    <div class="rounded position-relative" style="background-image: url(../../uploads/imgChambre/<?= $chambre["image"] ?>);background-size:cover;background-position:center;background-repeat:no-repeat;height:25vh">
                        <p class="p-1 fs-5 rounded bg-warning text-white position-absolute top-0 end-0"><?= $chambre["nom"] ?></p>
                    </div>
                    <span class="fw-bold fs-5">Caracteristique : </span>
                    <div class="d-flex gap-2 mt-2">
                        <?php if ($chambre["television"] == "oui"): ?>
                            <div class="d-flex justify-content-center align-items-center bg-light rounded gap-2 p-1">
                                <i class="ri-tv-line"></i>
                                <span>Television</span>
                            </div>
                        <?php endif; ?>
                        <?php if ($chambre["comodite"] == "ventiller"): ?>
                            <div class="d-flex justify-content-center align-items-center bg-light rounded gap-2 p-1">
                                <i class="ri-water-flash-line"></i>
                                <span>Ventillateur</span>
                            </div>
                        <?php else: ?>
                            <div class="d-flex justify-content-center align-items-center bg-light rounded gap-2 p-1"">
                                <i class=" ri-fridge-line"></i>
                                <span>Climatiser</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="mt-1">
                        <span class="fw-bold fs-5">Prix: </span>
                        <span><?= $chambre["prix"] ?> FCFA</span>
                    </div>
                    <div class="mt-2">
                        <p class="fw-light"><?= $chambre["description"] ?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php if (!empty($success)) : ?>
            <?= notification("ri-checkbox-circle-fill", "success", $success); ?>
        <?php endif; ?>
        <?php if (!empty($error)) : ?>
            <?= notification("ri-alert-fill", "danger", $error); ?>
        <?php endif; ?>
    </main>

    <footer style="margin-top: 150px;">
        <!-- place footer here -->
        <div class="p-4" style="background-image: url(../../../public/images/footer-img.svg);background-size:cover;background-position:center;background-repeat:no-repeat;width:100%;">
            <div class="container">
                <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                        <img src="../../../public/images/logo.svg" alt="logo" style="height: 120px;">
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-12 col-sm-6 col-lg-4 d-flex flex-column gap-3">
                        <div>
                            <p class="m-0 fw-bold text-success fs-4">Telephone</p>
                            <span class="fs-5">
                                +221.77.757.57.57
                            </span>
                        </div>
                        <div class="d-flex flex-column gap-1">
                            <p class="m-0 fw-bold text-success fs-4">Adresse</p>
                            <span class="fs-5">
                                Keur Massar, Mtoa
                            </span>
                            <span class="fs-5">
                                Dakar, Sénégal
                            </span>
                        </div>
                        <div class="d-flex flex-column gap-1">
                            <p class="m-0 fw-bold text-success fs-4">Email</p>
                            <span class="fs-5">
                                Réservation.Dakar@
                            </span>
                            <span class="fs-5">
                                myblackpearl@gmail.com
                            </span>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 d-flex flex-column gap-3 mt-5 mt-sm-0">
                        <div>
                            <p class="m-0 fw-bold text-success fs-4">Telephone</p>
                            <nav class="mt-3">
                                <ul class="list-unstyled d-flex flex-column gap-2">
                                    <li>
                                        <a href="#" class="text-decoration-none text-black fs-5">Actualites</a>
                                    </li>
                                    <li>
                                        <a href="#" class="text-decoration-none text-black fs-5">Recrutement</a>
                                    </li>
                                    <li>
                                        <a href="#" class="text-decoration-none text-black fs-5">Annonces</a>
                                    </li>
                                    <li>
                                        <a href="#" class="text-decoration-none text-black fs-5">FAQ</a>
                                    </li>
                                </ul>
                            </nav>
                            <div class="d-flex align-items-center gap-3">
                                <i class="ri-facebook-box-fill fs-2"></i>
                                <i class="ri-instagram-fill fs-2"></i>
                                <i class="ri-whatsapp-fill fs-2"></i>
                                <i class="ri-linkedin-box-fill fs-2"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 d-flex flex-column gap-3 mt-5 mt-lg-0">
                        <p class="m-0 fw-bold text-success fs-4">S'inscrire a notre newsletter</p>
                        <form action="#" class="d-flex ">
                            <input type="email" name="email" class="form-control p-3" placeholder="Votre e-amil..">
                            <button type="submit" class="btn btn-warning text-white">Validez</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div style="background-color: rgba(0, 82, 72, 1) !important;" class="p-3">
            <p class="m-0 fw-bold text-white text-center">Tous droits réservés. | © 2024 Kinz</p>
        </div>
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="
    https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js
    "></script>
    <script src="public/javascript/home.js"></script>
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