<?php
session_start();
require_once "src/includes/database.php";
require_once "src/includes/function.php";

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['admin_id'])) {
    header('Location: src/views/admin/auth/connexion.php');
    exit();
}

$success = $_SESSION['success'] ?? [];
unset($_SESSION['success']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Accueil - Admin</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link rel="stylesheet" href="public/css/admin.css">
    <link rel="stylesheet" href="public/css/home.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                        <img src="public/images/logo.svg" class="img-fluid d-none d-lg-block" style="height: 75px" alt="" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <nav>
                            <ul class="d-flex flex-column list-unstyled">
                                <li>
                                    <a href="#" class="sidebar-link text-decoration-none text-black active d-none d-lg-flex">
                                        <i class="ri-home-wifi-line fs-5"></i>
                                        <span>Accueil</span>
                                    </a>
                                </li>
                                <li class="m-0">
                                    <a href="src/views/admin/pages/chambre.php" class="sidebar-link text-decoration-none text-black d-none d-lg-flex">
                                        <i class="ri-book-open-line fs-5"></i>
                                        <span>Mes Chambres</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="src/views/admin/pages/reservation.php" class="sidebar-link text-decoration-none text-black d-none d-lg-flex">
                                        <i class="ri-reserved-line fs-5"></i>
                                        <span>Reservations</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="src/views/admin/pages/residence.php" class="sidebar-link text-decoration-none text-black d-none d-lg-flex">
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
            <div class="col-12 col-lg-10 contente" style="min-height: 100vh">
                <div class="container d-flex flex-column justify-content-between" style="min-height: 100vh">
                    <div>
                        <div class="row">
                            <div class="col-12 bg-white shadow-sm d-flex align-items-center justify-content-between" style="height: 12vh">
                                <div class="">
                                    <div class="fs-4 d-flex justify-content-center align-items-center rounded-circle menu" data-bs-toggle="offcanvas" href="#offcanvasExample" aria-controls="offcanvasExample">
                                        <i class="ri-menu-2-fill"></i>
                                    </div>
                                </div>
                                <?php if ($_SESSION['admin_role']=="Superadmin") : ?>
                                    <div class="">
                                        <a href="src/views/admin/forms/formAdd/addAdmin.php" class="btn monBag2 text-white">
                                            Ajouter un Admin <i class="ri-apps-2-add-line"></i>
                                        </a>
                                        
                                    </div>
                                <?php endif; ?>
                                <div class="d-sm-flex align-items-center gap-2">
                                    <div class="dropdown">
                                        <span class="dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="d-none d-sm-block fw-semibold"><?=$_SESSION['admin_prenom'] ?> <?=$_SESSION['admin_nom'] ?> </span>
                                            <i class="ri-admin-line fs-4"></i>
                                        </span>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item d-flex gap-2 align-items-center" href="src/views/admin/pages/historique.php">
                                                    <i class="ri-chat-history-line"></i>
                                                    <span>Historiques</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item d-flex gap-2 align-items-center" href="src/controllers/admin/auth/deconnexionController.php">
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
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-center">
                                        <h3 class="text-center w-50">Previsualiser vos données</h3>
                                    </div>
                                    <div class="col-12 d-flex justify-content-center mt-3">
                                        <canvas id="reservationsChart" width="400" height="200"></canvas>
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
                        <img src="public/images/logo.svg" class="img-fluid d-block d-lg-none" style="height: 60px" alt="" />
                    </div>
                </div>
                <div class="row" style="margin-top: 200px;">
                    <div class="col-12">
                        <nav>
                            <ul class="d-flex flex-column gap-2 list-unstyled">
                                <li>
                                    <a href="#" class="sidebar-link text-decoration-none active text-black ">
                                        <i class="ri-home-wifi-line fs-4"></i>
                                        <span>Accueil</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="src/views/admin/pages/chambre.php" class="sidebar-link text-decoration-none text-black">
                                        <i class="ri-book-open-line fs-4"></i>
                                        <span>Mes Chambres</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="src/views/admin/pages/reservation.php" class="sidebar-link text-decoration-none text-black">
                                        <i class="ri-reserved-line fs-4"></i>
                                        <span>Reservations</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="src/views/admin/pages/residences.php" class="sidebar-link text-decoration-none text-black ">
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
                                <a href="src/controllers/admin/auth/deconnexionController.php" class="sidebar-link text-decoration-none text-black">
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
    <script src="public/javascript/admin.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script>
        var ctx = document.getElementById('reservationsChart').getContext('2d');
        var reservationsChart = new Chart(ctx, {
            type: 'bar', // Type de graphique
            data: {
                labels: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
                datasets: [{
                    label: 'Nombre de reservations par mois',
                    data: [12, 19, 3, 5, 2, 3, 17, 14, 9, 10, 15, 7], // Remplacez ces données par les vôtres
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)', // Janvier
                        'rgba(54, 162, 235, 0.2)', // Février
                        'rgba(255, 206, 86, 0.2)', // Mars
                        'rgba(75, 192, 192, 0.2)', // Avril
                        'rgba(153, 102, 255, 0.2)', // Mai
                        'rgba(255, 159, 64, 0.2)', // Juin
                        'rgba(255, 99, 132, 0.2)', // Juillet
                        'rgba(54, 162, 235, 0.2)', // Août
                        'rgba(255, 206, 86, 0.2)', // Septembre
                        'rgba(75, 192, 192, 0.2)', // Octobre
                        'rgba(153, 102, 255, 0.2)', // Novembre
                        'rgba(255, 159, 64, 0.2)' // Décembre
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true // Commencer l'axe Y à 0
                    }
                }
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>