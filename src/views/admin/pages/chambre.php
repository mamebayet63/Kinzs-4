<?php
session_start();
require_once "../../../includes/database.php";
require_once "../../../includes/function.php";

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../auth/connexion.php');
    exit();
}

$success = $_SESSION['success'] ?? [];
$error = $_SESSION["error"] ?? [];
unset($_SESSION['success'], $_SESSION['error']);

$residence_id = $_GET["residence"] ?? null;
$residences = searchParamsToGetResidences($pdo, $_GET);
$chambres = getChambres($pdo, $residence_id);
$chambreSansId = getChambres($pdo);
$nbReservation = getNombreReservations($pdo);
$images = getImageGallerieWithId($pdo);
$hasSuspend = null;


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Nos Chambres</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link rel="stylesheet" href="../../../../public/css/admin.css">
    <link rel="stylesheet" href="../../../../public/css/home.css">
    <link href="
    https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.min.css
    " rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.12/dist/css/splide.min.css">

</head>

<body class="">
    <div class="container-fluid ">
        <div class="row">
            <div class="col-2 sidebar d-none d-lg-flex flex-column justify-content-between col-lg-2 bg-white p-0" style="height: 100vh; position: fixed; left: 0; bottom: 0">
                <div class="row">
                    <div class="col-12 d-flex justify-content-center mt-3">
                        <img src="../../../../public/images/logo.svg" class="img-fluid d-none d-lg-block" style="height: 110px" alt="logo" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <nav>
                            <ul class="d-flex flex-column list-unstyled">
                                <li>
                                    <a href="../../../../admin.php" class="sidebar-link text-decoration-none text-black d-none d-lg-flex">
                                        <i class="ri-home-wifi-line fs-5"></i>
                                        <span>Accueil</span>
                                    </a>
                                </li>
                                <li class="m-0">
                                    <a href="./chambre.php" class="sidebar-link text-decoration-none active text-black d-none d-lg-flex">
                                        <i class="ri-book-open-line fs-5"></i>
                                        <span>Mes Chambres</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="./reservation.php" class="sidebar-link position-relative text-decoration-none text-black d-none d-lg-flex">
                                        <i class="ri-reserved-line fs-5"></i>
                                        <span>Reservations</span>
                                        <?php if ($nbReservation > 0) : ?>
                                            <span class="badge bg-danger"><?= $nbReservation ?></span>
                                        <?php endif; ?>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="./residence.php" class="sidebar-link text-decoration-none text-black d-none d-lg-flex">
                                        <i class="ri-building-line fs-5"></i>
                                        <span>Residences</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <ul class="list-unstyled">
                            <li>
                                <a href="../../../controllers/admin/auth/deconnexionController.php" class="sidebar-link text-decoration-none text-black d-none d-lg-block">
                                    <i class="ri-logout-box-line fs-4"></i>
                                    <span>Deconnexion</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-10 contente position-relative" style="height: 100vh">
                <div class="container d-flex flex-column justify-content-between" style="min-height: 100vh">
                    <div>
                        <div class="row">
                            <div class="col-12 bg-white shadow-sm d-flex align-items-center justify-content-between" style="height: 12vh">
                                <div class="">
                                    <div class="fs-4 d-flex justify-content-center align-items-center rounded-circle menu" data-bs-toggle="offcanvas" href="#offcanvasExample" aria-controls="offcanvasExample">
                                        <i class="ri-menu-2-fill"></i>
                                    </div>
                                </div>
                                <div class="d-none d-sm-block">
                                    <p class="m-0 fw-bold">Listes des Chambres</p>
                                </div>
                                <div class="d-none d-sm-block">
                                    <p class="m-0 fw-bold">Administrateur</p>
                                </div>
                                <div class="d-block d-sm-none mt-4">
                                    <ul class="list-unstyled">
                                        <li>
                                            <a href="../../../controllers/admin/auth/deconnexionController.php" class="sidebar-link text-decoration-none text-black">
                                                <i class="ri-logout-box-line fs-4"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-12 bg-white shadow-sm d-flex flex-column justify-content-between" style="min-height: 88vh;">
                                <div class="row d-flex justify-content-between">
                                    <div class="col-12 col-sm-6 col-lg-4">
                                        <form method="get" action="#" class="mb-4 d-flex gap-3">
                                            <select name="residence" class="form-control">
                                                <option value="">Toutes les catégories</option>
                                                <?php foreach ($residences as $residence) : ?>
                                                    <option value="<?= $residence['ID_Residence'] ?>">
                                                        <?= htmlspecialchars($residence['nom']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div class="">
                                                <button type="submit" class="btn monBag2 text-white">Filtrer</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-12 d-flex justify-content-end align-items-center gap-3  mt-sm-0">
                                        <a href="../forms/formAdd/addChambre.php" class="btn monBag2 text-white d-flex align-items-center gap-2 text-white">
                                            <span>Nouveaux Chambres</span>
                                            <i class="ri-apps-2-add-line"></i>
                                        </a>
                                        <div>
                                            <?php foreach ($chambreSansId as $chambreid) : ?>
                                                <?php if ($chambreid["status"] == 2) {
                                                    $hasSuspend = true;
                                                    break;
                                                } ?>
                                            <?php endforeach; ?>
                                            <?php if ($hasSuspend) : ?>
                                                <a data-bs-toggle="modal" data-bs-target="#staticBackdropid2" class="btn monBag2 text-white d-flex align-items-center gap-2 ">
                                                    <span>Reactiver les chambres</span>
                                                    <i class="ri-alert-fill"></i>
                                                </a>
                                                <div class="modal fade" id="staticBackdropid2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <h5 class="text-center">Confirmer la reactivations des chambres</h5>
                                                                <div class="d-flex gap-3 justify-content-center">
                                                                    <a href="../../../controllers/admin/chambre/reactiverChambreController.php"><button class="btn monBag2 text-white">Reactiver</button></a>
                                                                    <button class="btn bg-danger text-white" data-bs-dismiss="modal">Annuler</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php else:  ?>
                                                <a data-bs-toggle="modal" data-bs-target="#staticBackdropid1" class="btn btn-danger d-flex align-items-center gap-2 text-white">
                                                    <span>Suspendre les reservations</span>
                                                    <i class="ri-alert-fill"></i>
                                                </a>
                                                <div class="modal fade" id="staticBackdropid1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <h5 class="text-center">Confirmer la suspension des chambres</h5>
                                                                <div class="d-flex gap-3 justify-content-center">
                                                                    <a href="../../../controllers/admin/chambre/suspendreChambreController.php"><button class="btn bg-danger text-white">Suspendre</button></a>
                                                                    <button class="btn monBag2 text-white" data-bs-dismiss="modal">Annuler</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                <?php foreach ($chambres as $k => $chambre): ?>
                                    <div class="col-12 col-sm-6 col-lg-4 shadow-sm position-relative p-2 mt-5">
                                        <!-- Affichage des informations de la chambre -->
                                        <div id="carouselExample<?= $chambre["ID_Chambre"] ?>" class="carousel slide">
                                <div class="carousel-inner">
                                    <?php
                                    $first = true; // Variable pour définir la première image comme active
                                    foreach ($images as $image):
                                        if ($image["ID_Chambre"] == $chambre["ID_Chambre"]): ?>
                                            <div class="carousel-item <?= $first ? 'active' : '' ?>">
                                            <img src="../../../uploads/imgChambre/splide/<?= $image["url"] ?>" class="d-block w-100 rounded" style="height: 40vh;object-fit:cover" alt="Image de la chambre">
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
                                        <p class="m-0 text-center py-3"><?= $chambre["nom"] ?></p>
                                        <span class="fw-bold">Caracteristique</span>
                                        <div class="d-flex gap-2">
                                            <?php if ($chambre["television"] == "oui"): ?>
                                                <div style="width: 45px;height:45px;" class="d-flex justify-content-center align-items-center bg-light rounded-circle">
                                                    <i class="ri-tv-2-line"></i>
                                                </div>
                                            <?php endif; ?>
                                            <?php if ($chambre["comodite"] == "ventiller"): ?>
                                                <div style="width: 45px;height:45px;" class="d-flex justify-content-center align-items-center bg-light rounded-circle">
                                                    <i class="ri-water-flash-line"></i>
                                                </div>
                                            <?php else: ?>
                                                <div style="width: 45px;height:45px;" class="d-flex justify-content-center align-items-center bg-light rounded-circle">
                                                    <i class="ri-fridge-line"></i>
                                                </div>
                                            <?php endif; ?>
                                            <?php if ($chambre["armoir"] == "oui"): ?>
                                                <div style="" class="d-flex justify-content-center align-items-center bg-light rounded gap-1 p-1">
                                                    <span class="mx-1">armoir</span>
                                                </div>
                                            <?php endif; ?>
                                            <?php if ($chambre["frigo"] == "oui"): ?>
                                                <div style="" class="d-flex justify-content-center align-items-center bg-light rounded gap-1 p-1">
                                                    <span class="mx-1">frigo</span>
                                                </div>
                                            <?php endif; ?>
                                            <?php if ($chambre["toilette"] == "oui"): ?>
                                                <div style="" class="d-flex justify-content-center align-items-center bg-light rounded gap-1 p-1">
                                                    <span class="mx-1">toilette</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <span class="fw-bold">Prix:</span>
                                            <span><?= $chambre["prix"] ?> FCFA</span>
                                        </div>
                                        
                                        <div>
                                            <span class="fw-bold">Dimension:</span>
                                            <span><?= $chambre["dimension"] ?> m²</span>
                                        </div>
                                        <div>
                                            <span class="fw-bold">Residence :</span>
                                            <p>
                                                <?php foreach ($residences as $residence): ?>
                                                    <?php if ($residence["ID_Residence"] == $chambre["ID_Residence"]): ?>
                                                        <?= $residence["nom"] ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </p>
                                        </div>
                                        <div class="d-flex gap-3">
                                            <a href="../forms/formUpdate/editChambre.php?id=<?= $chambre["ID_Chambre"] ?>" class="btn monBag2 text-white">Modifier</a>
                                            <!-- Lien avec modal unique pour chaque chambre -->
                                            <a data-bs-toggle="modal" data-bs-target="#staticBackdrop<?= $k ?>" class="btn bg-danger text-white">Supprimer</a>
                                        </div>
                                        
                                    </div>
                                    
                                    <!-- Modal unique pour chaque chambre -->
                                    <div class="modal fade" id="staticBackdrop<?= $k ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel<?= $k ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <h3 class="text-center">Confirmer la suppression</h3>
                                                    
                                                    <div class="d-flex gap-3 justify-content-center">
                                                        <!-- URL de suppression avec l'ID de la chambre -->
                                                        <a href="../../../controllers/admin/chambre/deleteChambreController.php?id=<?= $chambre["ID_Chambre"] ?>">
                                                            <button class="btn bg-danger text-white">Supprimer</button>
                                                        </a>
                                                        <button class="btn bg-primary text-white" data-bs-dismiss="modal">Annuler</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>


                                </div>
                                <div class="row border-top mt-5">
                                    <div class="col-12 py-2">
                                        <p class="m-0 text-center"> Tous droits réservés. | © 2024 Kinz.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (!empty($success)) : ?>
                <?= notification("ri-checkbox-circle-fill", "success", $success); ?>
            <?php endif; ?>
        </div>
    </div>
    </div>
    </div>
    <div class="offcanvas offcanvas-start d-block d-lg-none p-0" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body ">
            <div class="d-flex flex-column justify-content-between">
                <div class="row">
                    <div class="col-12 px-4 py-3">
                        <img src="../../../../public/images/logo.svg" class="img-fluid d-block d-lg-none" style="height: 60px" alt="" />
                    </div>
                </div>
                <div class="row" style="margin-top: 200px;">
                    <div class="col-12">
                        <nav>
                            <ul class="d-flex flex-column gap-2 list-unstyled">
                                <li>
                                    <a href="../../../../admin.php" class="sidebar-link text-decoration-none text-black ">
                                        <i class="ri-home-wifi-line fs-4"></i>
                                        <span>Accueil</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="./chambre.php" class="sidebar-link active text-decoration-none text-black">
                                        <i class="ri-book-open-line fs-4"></i>
                                        <span>Mes Chambres</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="./reservation.php" class="sidebar-link text-decoration-none text-black">
                                        <i class="ri-reserved-line fs-4"></i>
                                        <span>Reservations</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="./residence.php" class="sidebar-link text-decoration-none text-black ">
                                        <i class="ri-building-line fs-4"></i>
                                        <span>Residences</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="row" style="margin-top: 270px;">
                    <div class="col-12">
                        <ul class="list-unstyled">
                            <li>
                                <a href="../../../controllers/admin/auth/deconnexionController.php" class="sidebar-link text-decoration-none text-black">
                                    <i class="ri-logout-box-line fs-4"></i>
                                    <span>Deconnexion</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="../../../../public/javascript/admin.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.12/dist/js/splide.min.js"></script>
</body>

</html>