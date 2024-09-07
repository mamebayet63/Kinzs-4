<?php
require "../../../includes/database.php";
require "../../../includes/function.php";

// Initialisation des variables de filtrage
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : null;
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : null;
$admin_email = isset($_GET['admin_email']) ? $_GET['admin_email'] : null;


$historiques = getHistoriques($pdo, $start_date, $end_date, $admin_email);
$images = getImageGallerieWithId($pdo);
$residences = getResidence($pdo);
$chambres= getChambres($pdo);

?>
<!doctype html>
<html lang="en">

<head>
    <title>Historiques des reservations</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link rel="stylesheet" href="../../../../public/css/admin.css">
    <link href="
    https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.min.css
    " rel="stylesheet" />
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />
</head>

<body>
    <main>
        <div class="container">
            <div class="row mt-5">
                <div class="col-12">
                <a href="../../../../admin.php" class="text-decoration-none text-black d-flex gap-1 align-items-center fs-5">
                        <i class="ri-arrow-left-s-line"></i>
                        <span>Retour</span>
                    </a>
                    <h3 class="text-center">Historiques des reservations</h3>
                </div>
            </div>
            <div class="row mt-4 d-flex justify-content-between">
                <div class="col-4">
                    <div class="row">
                        <form method="GET" action="historique.php" class="bg-white shadow p-2 rounded">
                            <div class="d-flex align-items-center gap-2">
                                <p class="fw-bold m-0">Filtrer par date de réservation</p>
                                <i class="ri-filter-3-fill"></i>
                            </div>
                            <div class="d-flex flex-column gap-2 form-group mt-4">
                                <label for="start_date">Date de début :</label>
                                <input type="date" class="form-control p-2 shadow-sm" name="start_date" value="<?= htmlspecialchars($start_date) ?>">
                            </div>
                            <div class="d-flex flex-column gap-2 form-group mt-2">
                                <label for="end_date">Date de fin :</label>
                                <input type="date" class="form-control p-2 shadow-sm" name="end_date" value="<?= htmlspecialchars($end_date) ?>">
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mt-2">Filtrez</button>
                        </form>
                    </div>
                    <div class="row mt-3">
                        <form method="GET" action="historique.php" class="bg-white shadow p-2 rounded">
                            <div class="d-flex align-items-center gap-2">
                                <p class="fw-bold m-0">Filtrer par administrateur</p>
                                <i class="ri-filter-3-fill"></i>
                            </div>
                            <div class="form-group mt-4">
                                <label for="admin_email">Email de l'administrateur :</label>
                                <input type="email" placeholder="identifiant admin" class="mt-2 form-control p-2 shadow-sm" name="admin_email" value="<?= isset($admin_email) ?? "" ?>">
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mt-2">Filtrez</button>
                        </form>
                    </div>
                </div>
                <div class="col-7 bg-white rounded shadow overflow-auto">
                    <div class="row p-2">
                        <?php if (!empty($historiques)): ?>
                            <?php foreach ($historiques as $k => $historique): ?>
                                <div class="col-12 shadow-sm rounded mt-3 p-1">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <p class="m-0">Réservation de <?= $historique["prenom"] ?>-<?= $historique["nom"] ?></p>
                                        <a style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?= $k ?>" class="d-flex align-items-center gap-2 text-decoration-none">
                                            <span>Détails</span>
                                            <i class="ri-creative-commons-nd-line"></i>
                                        </a>
                                    </div>
                                    <div class="d-flex justify-content-end mt-2">
                                        <span class="fw-light" style="font-size: 10px !important;">le <?= $historique["date_validation"] ?></span>
                                    </div>
                                </div>
                                <div class="modal fade modal-scrollable" id="staticBackdrop<?= $k ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel<?= $k ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="text-center">Détails des informations</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="">
                                                    <p class="m-0"><span class="fw-bold">Nom :</span> <?= $historique["nom"] ?></p>
                                                    <p class="m-0"><span class="fw-bold">Prénom :</span> <?= $historique["prenom"] ?></p>
                                                    <p class="m-0"><span class="fw-bold">Email :</span> <?= $historique["email"] ?></p>
                                                    <p class="m-0"><span class="fw-bold">Nombre de jours :</span> <?= $historique["nbr_jours"] ?></p>
                                                    <p class="m-0"><span class="fw-bold">Date de début :</span> <?= $historique["date_validation"] ?> </p>
                                                    <p class="m-0"><span class="fw-bold">Numero :</span> <?= $historique["numero"] ?></p>
                                                    <p class="m-0"><span class="fw-bold">Admin :</span> <?= $historique["validate_by"] ?></p>
                                                    <p class="m-0 mt-3"><span class="fw-bold">chambre : 
                                                        <?php
                                                            foreach ($chambres as $chambre):
                                                                        if ($chambre["ID_Chambre"] == $historique["ID_Chambre"]): ?>
                                                                            <span><?= $chambre["nom"]?></span>
                                                                    <?php endif;
                                                                endforeach; ?>
                                                    </span></p>
                                                    <div id="carouselExample<?= $historique["ID_Chambre"] ?>" class="carousel slide mt-2">
                                                        <div class="carousel-inner">
                                                            <?php
                                                            $first = true; // Variable pour définir la première image comme active
                                                            foreach ($images as $image):
                                                                if ($image["ID_Chambre"] == $historique["ID_Chambre"]): ?>
                                                                    <div class="carousel-item <?= $first ? 'active' : '' ?>">
                                                                        <img src="../../../uploads/imgChambre/splide/<?= $image["url"] ?>" class="d-block w-100 rounded" style="height: 40vh;object-fit:cover" alt="Image de la chambre">
                                                                    </div>
                                                                    <?php $first = false; // Après la première image, passer à false 
                                                                    ?>
                                                            <?php endif;
                                                            endforeach; ?>
                                                        </div>
                                                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample<?= $historique["ID_Chambre"] ?>" data-bs-slide="prev">
                                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                            <span class="visually-hidden">Previous</span>
                                                        </button>
                                                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample<?= $historique["ID_Chambre"] ?>" data-bs-slide="next">
                                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                            <span class="visually-hidden">Next</span>
                                                        </button>
                                                    </div>
                                                    <?php foreach ($residences as $residence): ?>
                                                        <?php if ($residence["ID_Residence"] == $historique["ID_Residence"]): ?>
                                                            <p class="mt-5"><span class="fw-bold">Residences :</span> <?= $residence["nom"] ?></p>
                                                            <img src="../../../uploads/imgResidence/<?= $residence["couverture"] ?>" alt="" style="height: 40vh;object-fit:cover" class="rounded mt-2 w-100">
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="col-12 d-flex justify-content-center align-items-center">
                                <p class="text-center m-0">Aucun historique trouvé</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
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