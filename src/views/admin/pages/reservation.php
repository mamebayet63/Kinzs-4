<?php
session_start();
require_once "../../../includes/database.php";
require_once "../../../includes/function.php";

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['admin_id'])) {
    header('Location: ./auth/connexion.php');
    exit();
}

$success = $_SESSION['success'] ?? [];
$error = $_SESSION["error"] ?? [];
unset($_SESSION['success'], $_SESSION['error']);

$reservations = searchParamsToGetReservations($pdo, $_GET);
$chambres = getChambres($pdo);
$residences = getResidence($pdo);
$nbReservation = getNombreReservations($pdo);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Nos Reservations</title>
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
                                    <a href="./chambre.php" class="sidebar-link text-decoration-none text-black d-none d-lg-flex">
                                        <i class="ri-book-open-line fs-5"></i>
                                        <span>Mes Chambres</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="./reservation.php" class="sidebar-link position-relative active text-decoration-none text-black d-none d-lg-flex">
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
                                <a class="sidebar-link text-decoration-none text-black d-none d-lg-block">
                                    <i class="ri-copyright-line"></i>
                                    <span>Kinzs - Residences</span>
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
                                <div class="d-sm-flex align-items-center gap-2">
                                    <div class="dropdown">
                                        <span class="dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="d-none d-sm-block fw-semibold"><?=$_SESSION['admin_prenom'] ?> <?=$_SESSION['admin_nom'] ?> </span>
                                            <i class="ri-admin-line fs-4"></i>
                                        </span>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item d-flex gap-2 align-items-center" href="./historique.php">
                                                    <i class="ri-chat-history-line"></i>
                                                    <span>Historiques</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item d-flex gap-2 align-items-center" href="../../../controllers/admin/auth/deconnexionController.php">
                                                    <i class="ri-logout-box-line"></i>
                                                    <span>Déconnexion</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-12 bg-white shadow-sm d-flex flex-column justify-content-between" style="min-height: 88vh;">
                                <div class="row d-flex justify-content-between">
                                    <div class="col-6">
                                        <form class="d-none d-sm-flex gap-1" action="#" role="search" method="get">
                                            <input class="form-control border border-end-0 bg-light rounded-start" type="search" placeholder="Recherche..." name="search" style="width: 340px" />
                                            <button class="border rounded-end monBag2 text-white p-2" type="submit">
                                                <i class="ri-search-line text-white"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 overflow-x-auto">
                                        <table class="table table-striped w-100">
                                            <thead>
                                                <tr>
                                                    <th>Nom</th>
                                                    <th>Prenom</th>
                                                    <th>Numero</th>
                                                    <th>chambre</th>
                                                    <th>Date de debut</th>
                                                    <th>Nombre de jours</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($reservations)) : ?>
                                                    <?php foreach ($reservations as $k => $reservation) : ?>
                                                        <tr>
                                                            <td><?= $reservation['nom'] ?></td>
                                                            <td><?= $reservation['prenom'] ?></td>
                                                            <td><?= $reservation['numero'] ?></td>
                                                            <td><?= $reservation['chambre_nom'] ?></td>
                                                            <td><?= $reservation['date_debut'] ?></td>
                                                            <td><?= $reservation['nbr_jours'] ?></td>
                                                            <td class="d-flex gap-2">
                                                                <?php if ($reservation["status"] == "attente"): ?>
                                                                    <a href="../../../controllers/admin/reservation/checkReservationController.php?id=<?= $reservation['ID_Reservation'] ?>" class="btn monBag2 text-white d-flex align-items-center gap-2 btn-sm">
                                                                        <span>Validez</span>
                                                                        <i class="ri-checkbox-circle-fill"></i>
                                                                    </a>
                                                                <?php else: ?>
                                                                    <a href="../../../controllers/admin/reservation/deleteReservationController.php?id=<?= $reservation['ID_Reservation'] ?>" class="btn btn-danger d-flex align-items-center gap-2 btn-sm">
                                                                        <span>supprimez</span>
                                                                        <i class="ri-close-circle-fill"></i>
                                                                    </a>
                                                                <?php endif; ?>
                                                                
                                                            </td>
                                                        </tr>
                                                        <div class="modal fade" id="staticBackdrop<?= $k ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel<?= $k ?>" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <h3 class="text-center">Confirmer la supression</h3>
                                                                        <div class="d-flex gap-3 justify-content-center">
                                                                            <a href="../../../controllers/admin/residence/deleteResidenceController.php?id=<?= $residence['ID_Residence'] ?>"><button class="btn bg-danger text-white">Supprimer</button></a>
                                                                            <button class="btn bg-primary text-white" data-bs-dismiss="modal">Annuler</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                <?php else : ?>
                                                    <tr>
                                                        <td colspan="4">Aucun reservations trouvé.</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
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
                                    <a href="./chambre.php" class="sidebar-link text-decoration-none text-black">
                                        <i class="ri-book-open-line fs-4"></i>
                                        <span>Mes Chambres</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="./reservation.php" class="sidebar-link active text-decoration-none text-black">
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
</body>

</html>